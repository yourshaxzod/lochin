<?php
namespace Lochin\Shaxzod;

class Message {
    private $data;
    private $token;

    public function __construct(array $data, string $token) {
        $this->data = $data;
        $this->token = $token;
    }

    public function getText(): string {
        return $this->data['text'] ?? '';
    }

    public function getChatId(): int {
        return $this->data['chat']['id'];
    }

    public function reply(string $text) {
        $bot = new Bot($this->token);
        $bot->apiRequest('sendMessage', [
            'chat_id' => $this->getChatId(),
            'text' => $text
        ]);
    }

    public function getFrom(): array {
        return $this->data['from'] ?? [];
    }
}
