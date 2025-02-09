<?php

namespace Shaxzod\Lochin\Telegram\Types\User;

use Shaxzod\Lochin\Telegram\Types\BaseType;

/**
 * Bu obyekt Telegram foydalanuvchisi yoki botini ifodalaydi.
 * @see https://core.telegram.org/bots/api#user
 */
class User extends BaseType
{
    /**
     * Ushbu foydalanuvchi yoki bot uchun noyob identifikator.
     * @var int $id
     */
    public int $id;

    /**
     * True, agar bu foydalanuvchi bot bo'lsa.
     * @var bool $is_bot
     */
    public bool $is_bot;

    /**
     * Foydalanuvchi yoki botning ismi.
     * @var string $first_name
     */
    public string $first_name;

    /**
     * Ixtiyoriy. Foydalanuvchi yoki botning familiyasi.
     * @var string|null $last_name
     */
    public ?string $last_name = null;

    /**
     * Ixtiyoriy. Foydalanuvchi yoki botning foydalanuvchi nomi.
     * @var string|null $username
     */
    public ?string $username = null;

    /**
     * Ixtiyoriy. Foydalanuvchi tilining {@see https://en.wikipedia.org/wiki/IETF_language_tag IETF} tili yorlig'i.
     * @var string|null $language_code
     */
    public ?string $language_code = null;

    /**
     * Ixtiyoriy. True, agar bu foydalanuvchi Telegram Premium foydalanuvchisi bo'lsa.
     * @var bool|null $is_premium
     */
    public ?bool $is_premium = null;

    /**
     * Ixtiyoriy. True, agar bu foydalanuvchi botni biriktirma menyusiga qo'shgan bo'lsa.
     * @var bool|null $is_blocked
     */
    public ?bool $added_to_attachment_menu = null;

    /**
     * Ixtiyoriy. True, agar botni guruhlarga taklif qilish mumkin bo'lsa. Faqat {@see https://core.telegram.org/bots/api#getme getMe}-da qaytarildi.
     * @var bool|null $can_join_groups
     */
    public ?bool $can_join_groups = null;

    /**
     * Ixtiyoriy. True, agar bot uchun maxfiylik rejimi o'chirilgan bo'lsa. Faqat {@see https://core.telegram.org/bots/api#getme getMe}-da qaytarildi.
     * @var bool|null $can_read_all_group_messages
     */
    public ?bool $can_read_all_group_messages = null;

    /**
     * Ixtiyoriy. True, agar bot inline so'rovlarni qo'llab-quvvatlasa. Faqat {@see https://core.telegram.org/bots/api#getme getMe}-da qaytarildi.
     * @var bool|null $supports_inline_queries
     */
    public ?bool $supports_inline_queries = null;

    /**
     * Ixtiyoriy. True, agar bot o'z xabarlarini qabul qilish uchun Telegram Business hisobiga ulanishi mumkin bo'lsa. Faqat {@see https://core.telegram.org/bots/api#getme getMe}-da qaytarildi.
     * @var bool|null $can_connect_to_business
     */
    public ?bool $can_connect_to_business = null;

    /**
     * Ixtiyoriy. True, agar botda asosiy veb-ilova bo'lsa. Faqat getMe{@see https://core.telegram.org/bots/api#getme getMe}-da qaytarildi.
     * @var bool|null $has_main_web_app
     */
    public ?bool $has_main_web_app = null;

    public static function make(
        int $id,
        bool $is_bot,
        string $first_name,
        ?string $last_name = null,
        ?string $username = null,
        ?string $language_code = null,
        ?bool $is_premium = null,
        ?bool $added_to_attachment_menu = null,
        ?bool $can_join_groups = null,
        ?bool $can_read_all_group_messages = null,
        ?bool $supports_inline_queries = null,
        ?bool $can_connect_to_business = null,
        ?bool $has_main_web_app = null
    ): User {
        $user = new self();
        $user->id = $id;
        $user->is_bot = $is_bot;
        $user->first_name = $first_name;
        $user->last_name = $last_name;
        $user->username = $username;
        $user->language_code = $language_code;
        $user->is_premium = $is_premium;
        $user->added_to_attachment_menu = $added_to_attachment_menu;
        $user->can_join_groups = $can_join_groups;
        $user->can_read_all_group_messages = $can_read_all_group_messages;
        $user->supports_inline_queries = $supports_inline_queries;
        $user->can_connect_to_business = $can_connect_to_business;
        $user->has_main_web_app = $has_main_web_app;
        return $user;
    }
}
