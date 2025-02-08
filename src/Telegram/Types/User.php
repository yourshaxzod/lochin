<?php

namespace Shaxzod\Lochin\Telegram\Types;

/**
 * Bu obyekt Telegram foydalanuvchisi yoki botini ifodalaydi.
 * @see https://core.telegram.org/bots/api#user
 */
class User
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
     * @var string $last_name
     */
    public string $last_name;

    /**
     * Ixtiyoriy. Foydalanuvchi yoki botning foydalanuvchi nomi.
     * @var string $username
     */
    public string $username;

    /**
     * Ixtiyoriy. Foydalanuvchi tilining IETF tili yorlig'i.
     * @var string $language_code
     * @see https://en.wikipedia.org/wiki/IETF_language_tag
     */
    public string $language_code;

    /**
     * Ixtiyoriy. True, agar bu foydalanuvchi Telegram Premium foydalanuvchisi bo'lsa.
     * @var bool $is_premium
     */
    public ?bool $is_premium = null;

    /**
     * Ixtiyoriy. True, agar bu foydalanuvchi botni biriktirma menyusiga qo'shgan bo'lsa.
     * @var bool $is_blocked
     */
    public ?bool $added_to_attachment_menu = null;

    /**
     * Ixtiyoriy. True, agar botni guruhlarga taklif qilish mumkin bo'lsa. Faqat getMe-da qaytarildi.
     * @var bool $can_join_groups
     */
    public bool $can_join_groups;

    /**
     * Ixtiyoriy. True, agar bot uchun maxfiylik rejimi o'chirilgan bo'lsa. Faqat getMe-da qaytarildi.
     * @var bool $can_read_all_group_messages
     */
    public bool $can_read_all_group_messages;

    /**
     * Ixtiyoriy. True, agar bot inline so'rovlarni qo'llab-quvvatlasa. Faqat getMe-da qaytarildi.
     * @var bool $supports_inline_queries
     */
    public bool $supports_inline_queries;

    /**
     * Ixtiyoriy. True, agar bot o'z xabarlarini qabul qilish uchun Telegram Business hisobiga ulanishi mumkin bo'lsa. Faqat getMe-da qaytarildi.
     * @var bool $can_connect_to_business
     */
    public bool $can_connect_to_business;

    /**
     * Ixtiyoriy. True, agar botda asosiy veb-ilova bo'lsa. Faqat getMe-da qaytarildi.
     * @var bool $has_main_web_app
     */
    public bool $has_main_web_app;
}