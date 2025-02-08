<?php

namespace Shaxzod\Lochin\Telegram\Types;

use Shaxzod\Lochin\Telegram\Types\Interval\Arrayable;

abstract class BaseType implements Arrayable
{
    /** @var object|null */
    private ?object $_bot;

    /** @var array */
    private array $_extra = [];

    /**
     * @param object|null $bot
     */
    public function __construct(?object $bot = null)
    {
        $this->_bot = $bot;
    }

    /**
     * @param string $method
     * @param array $parameters
     * @return mixed
     */
    public function __call(string $method, array $parameters): mixed
    {
        if ($this->_bot !== null && method_exists($this->_bot, $method)) {
            return $this->_bot->$method(...$parameters);
        }

        throw new \BadMethodCallException("Method '{$method}' not found.");
    }

    /**
     * @param string $name
     * @param mixed $value
     */
    public function __set(string $name, mixed $value): void
    {
        $this->_extra[$name] = $value;
    }

    /**
     * @param string $name
     * @return mixed
     */
    public function __get(string $name): mixed
    {
        return $this->_extra[$name] ?? null;
    }

    /**
     * @param string $name
     * @return bool
     */
    public function __isset(string $name): bool
    {
        return isset($this->_extra[$name]);
    }

    /**
     * @param object|null $bot
     * @return self
     */
    public function bindToInstance(?object $bot): self
    {
        $this->_bot = $bot;
        return $this;
    }

    /**
     * @return object|null
     */
    public function getBot(): ?object
    {
        return $this->_bot;
    }

    /**
     * Ichki propertylarni tozalab, massivga o'tkazish
     */
    protected function filterInternalProperties(array $data): array
    {
        $filtered = [];

        foreach ($data as $key => $value) {
            // Ichki propertylarni o'tkazib yuborish
            if (str_starts_with($key, '_')) {
                continue;
            }

            // Arrayable interfaceni tekshirish
            if ($value instanceof Arrayable) {
                $filtered[$key] = $value->toArray();
                continue;
            }

            // Null bo'lmagan qiymatlarni qo'shish
            if ($value !== null) {
                $filtered[$key] = $value;
            }
        }

        return $filtered;
    }

    /**
     * Obyektni massivga o'tkazish
     */
    public function toArray(): array
    {
        $data = [...get_object_vars($this), ...$this->_extra];
        return $this->filterInternalProperties($data);
    }
}
