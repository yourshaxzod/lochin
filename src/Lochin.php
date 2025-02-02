<?php

namespace Shaxzod\Lochin;

use InvalidArgumentException;

class Lochin
{
    /**
     * @var string
     */
    private string $token;

    /**
     * @var Configuration
     */
    private Configuration $config;

    private $handlers = [];
    private $middleware = [];
    private $mode;
    private $offset = 0;

    public function __construct(string $token, ?Configuration $config)
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

    public function onCommand(string $command, callable $handler)
    {
        $this->handlers['command'][$command] = $handler;
        return $this;
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

    public function run(string $mode = 'polling')
    {
        $this->mode = $mode;
        
        if ($this->mode === 'webhook') {
            $this->handleWebhook();
        } else {
            $this->startPolling();
        }
    }

    private function handleWebhook()
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

    private function startPolling()
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

    private function processUpdate(array $update)
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

    private function handleMessage(array $message)
    {
        $messageObj = new Message($message, $this->token);

        if (isset($message['text']) && $message['text'][0] === '/') {
            $command = explode(' ', $message['text'])[0];
            if (isset($this->handlers['command'][$command])) {
                $this->handlers['command'][$command]($messageObj);
            }
        }

        if (isset($this->handlers['message'])) {
            $this->handlers['message']($messageObj);
        }
    }

    private function handleCallbackQuery(array $callbackQuery)
    {
        if (isset($this->handlers['callback_query'])) {
            $this->handlers['callback_query'](new CallbackQuery($callbackQuery, $this->token));
        }
    }

    private function getUpdates()
    {
        $response = $this->apiRequest('getUpdates', [
            'offset' => $this->offset,
            'limit' => $this->config->getUpdatesLimit(),
            'timeout' => $this->config->getTimeout(),
            'allowed_updates' => ['message', 'callback_query']
        ]);

        return $response['result'] ?? [];
    }

    public function apiRequest(string $method, array $params = [])
    {
        $url = $this->config->getApiUrl() . $this->config->getToken() . '/' . $method;

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
