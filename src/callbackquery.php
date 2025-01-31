<?php
namespace Lochin\Shaxzod;

class CallbackQuery {
    private $data;
    private $token;

    public function __construct(array $data, string $token) {
        $this->data = $data;
        $this->token = $token;
    }

    public function getData(): string {
        return $this->data['data'] ?? '';
    }
}