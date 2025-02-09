<?php

namespace Shaxzod\Lochin\Telegram\Types;

use Shaxzod\Lochin\Telegram\Properties\ChatType;
use Shaxzod\Lochin\Telegram\Types\BaseType;

/**
 * Bu obyekt suhbatni ifodalaydi.
 * @see https://core.telegram.org/bots/api#chat
 */
class Chat extends BaseType
{
    /**
     * Bu chat uchun noyob identifikator.
     * @var int $id
     */
    public int $id;

    /**
     * Chat turi. "private", "group", "supergroup" yoki "channel" bo'lishi mumkin.
     * @var ChatType|string $type
     */
    public ChatType|string $type;

    /**
     * Ixtiyoriy. Sarlavha, superguruhlar, kanallar va guruh chatlari uchun.
     * @var string|null $title
     */
    public ?string $title = null;

    /**
     * Ixtiyoriy. Agar mavjud bo'lsa, shaxsiy chatlar, superguruhlar va kanallar uchun foydalanuvchi nomi.
     * @var string|null $username
     */
    public ?string $username = null;

    /**
     * Ixtiyoriy. Shaxsiy chatdagi boshqa tomonning ismi.
     * @var string|null $first_name
     */
    public ?string $first_name = null;

    /**
     * Ixtiyoriy. Shaxsiy chatdagi boshqa tomonning familiyasi.
     * @var string|null $last_name
     */
    public ?string $last_name = null;

    /**
     * Ixtiyoriy. True,  agar superguruh suhbati forum bo'lsa ({@see https://telegram.org/blog/topics-in-groups-collectible-usernames#topics-in-groups mavzular} yoqilgan).
     * @var bool $is_forum
     */
    public ?bool $is_forum = null;

    public static function make(
        int $id,
        ChatType|string $type,
        ?string $title = null,
        ?string $username = null,
        ?string $first_name = null,
        ?string $last_name = null,
        ?bool $is_forum = null
    ): Chat {
        $chat = new self();
        $chat->id = $id;
        $chat->type = $type;
        $chat->title = $title;
        $chat->username = $username;
        $chat->first_name = $first_name;
        $chat->last_name = $last_name;
        $chat->is_forum = $is_forum;
        return $chat;
    }

    public function isPrivate(): bool
    {
        return $this->type === ChatType::PRIVATE;
    }

    public function isGroup(): bool
    {
        return $this->type === ChatType::GROUP;
    }

    public function isSupergroup(): bool
    {
        return $this->type === ChatType::SUPERGROUP;
    }

    public function isChannel(): bool
    {
        return $this->type === ChatType::CHANNEL;
    }
}
