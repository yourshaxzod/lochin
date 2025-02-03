<?php

namespace Shaxzod\Lochin;

use InvalidArgumentException;

class Lochin
{
    private string $token;
    private Configuration $config;
    private array $handlers = [];
    private array $middleware = [];
    private array $textPatterns = [];
    private string $mode;
    private int $offset = 0;

    public function __construct(string $token, ?Configuration $config = null)
    {
        if (empty($token)) {
            throw new InvalidArgumentException('The token cannot be empty.');
        }

        $this->token = $token;
        $this->config = $config ?? new Configuration($token);
    }

    public function onMessage(callable $handler)
    {
        $this->handlers['message'] = $handler;
        return $this;
    }

    public function onCommand(string $command, callable $handler): self
    {
        $command = trim($command, '/');
        $this->handlers['command'][$command] = $handler;
        return $this;
    }

    public function onText(string $pattern, callable $handler): self
    {
        $this->textPatterns[] = [
            'pattern' => $this->convertPatternToRegex($pattern),
            'original' => $pattern,
            'handler' => $handler
        ];

        return $this;
    }

    private function convertPatternToRegex(string $pattern): string
    {
        return '/^' . preg_replace_callback('/\{(\w+)\}/', function ($matches) {
            return "(?P<{$matches[1]}>.+?)";
        }, preg_quote($pattern, '/')) . '$/';
    }

    public function sendMessage(string $text, array $extra = []): array
    {
        return $this->apiRequest('sendMessage', array_merge([
            'chat_id' => $this->getCurrentChatId(),
            'text' => $text
        ], $extra));
    }

    private function getCurrentChatId(): ?int
    {
        return $this->currentUpdate['message']['chat']['id'] ?? null;
    }

    public function onCallbackQuery(callable $handler)
    {
        $this->handlers['callback_query'] = $handler;
        return $this;
    }

    public function addMiddleware(callable $middleware)
    {
        $this->middleware[] = $middleware;
        return $this;
    }

    public function run(string $mode = 'polling'): void
    {
        $this->mode = $mode;

        if ($this->mode === 'webhook') {
            $this->handleWebhook();
        } else {
            $this->startPolling();
        }
    }

    private function handleWebhook(): void
    {
        $payload = json_decode(file_get_contents('php://input'), true);

        if ($payload && is_array($payload)) {
            $this->processUpdate($payload);
            echo "OK";
        } else {
            http_response_code(400);
            echo json_encode(['error' => 'Invalid payload']);
        }
    }

    private function startPolling(): void
    {
        while (true) {
            $updates = $this->getUpdates($this->offset);

            foreach ($updates as $update) {
                $this->processUpdate($update);
                $this->offset = $update['update_id'] + 1;
            }

            usleep(100000);
        }
    }

    private function processUpdate(array $update): void
    {
        foreach ($this->middleware as $middleware) {
            $middleware($update);
        }

        if (isset($update['message'])) {
            $this->handleMessage($update['message']);
        }

        if (isset($update['callback_query'])) {
            $this->handleCallbackQuery($update['callback_query']);
        }
    }

    private function handleMessage(array $message): void
    {
        if (isset($message['text']) && str_starts_with($message['text'], '/')) {

            $parts = explode(' ', substr($message['text'], 1));
            $command = $parts[0];

            if (isset($this->handlers['command'][$command])) {
                call_user_func($this->handlers['command'][$command], $this);
                return;
            }
        }

        if (isset($message['text'])) {
            foreach ($this->textPatterns as $pattern) {
                if (preg_match($pattern['pattern'], $message['text'], $matches)) {
                    $params = array_filter($matches, function ($key) {
                        return !is_numeric($key);
                    }, ARRAY_FILTER_USE_KEY);

                    call_user_func_array($pattern['handler'], [$this, ...array_values($params)]);
                    return;
                }
            }
        }
    }

    private function handleCallbackQuery(array $callbackQuery)
    {
        if (isset($this->handlers['callback_query'])) {
            $this->handlers['callback_query'](new CallbackQuery($callbackQuery, $this->token));
        }
    }

    private function getUpdates(): array
    {
        $response = $this->apiRequest('getUpdates', [
            'offset' => $this->offset,
            'limit' => $this->config->getUpdatesLimit(),
            'timeout' => $this->config->getTimeout(),
            'allowed_updates' => ['message', 'callback_query']
        ]);

        return $response['result'] ?? [];
    }

    public function apiRequest(string $method, array $params = []): array
    {
        $url = $this->config->getApiUrl() . '/bot' . $this->config->getToken() . '/' . $method;

        $context = stream_context_create([
            'http' => [
                'method' => 'POST',
                'header' => "Content-Type: application/json\r\n",
                'content' => json_encode($params)
            ]
        ]);

        $response = file_get_contents($url, false, $context);
        return json_decode($response, true);
    }
}
