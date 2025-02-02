<?php

namespace Shaxzod\Lochin;

final class Configuration 
{
    public const DEFAULT_API_URL = 'https://api.telegram.org';
    public const DEFAULT_TIMEOUT = 10;
    public const DEFAULT_LIMIT = 100;
    
    public function __construct(
        private string $token,
        private string $apiUrl = self::DEFAULT_API_URL,
        private bool $debug = false,
        private int $timeout = self::DEFAULT_TIMEOUT,
        private int $updatesLimit = self::DEFAULT_LIMIT,
        private array $extra = []
    ) {
    }

    public function getToken(): string 
    {
        return $this->token;
    }

    public function getApiUrl(): string 
    {
        return $this->apiUrl;
    }

    public function isDebug(): bool 
    {
        return $this->debug;
    }

    public function getTimeout(): int 
    {
        return $this->timeout;
    }

    public function getUpdatesLimit(): int 
    {
        return $this->updatesLimit;
    }

    public static function fromArray(array $config): self 
    {
        return new self(
            token: $config['token'],
            apiUrl: $config['api_url'] ?? self::DEFAULT_API_URL,
            debug: $config['debug'] ?? false,
            timeout: $config['timeout'] ?? self::DEFAULT_TIMEOUT,
            updatesLimit: $config['updates_limit'] ?? self::DEFAULT_LIMIT,
            extra: $config['extra'] ?? []
        );
    }

    public function toArray(): array 
    {
        return [
            'token' => $this->token,
            'api_url' => $this->apiUrl,
            'debug' => $this->debug,
            'timeout' => $this->timeout,
            'updates_limit' => $this->updatesLimit,
            'extra' => $this->extra
        ];
    }

    public function getExtra(string $key, mixed $default = null): mixed 
    {
        return $this->extra[$key] ?? $default;
    }
}