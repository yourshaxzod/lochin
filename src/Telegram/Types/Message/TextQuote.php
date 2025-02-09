<?php

namespace Shaxzod\Lochin\Telegram\Types\Message;

use Shaxzod\Lochin\Telegram\Types\BaseType;

/**
 * Ushbu obyekt xabarning kotirovka qilingan qismi haqidagi ma'lumotlarni o'z ichiga oladi, bu xabarga javob beradi.
 * @see https://core.telegram.org/bots/api#textquote
 */
class TextQuote extends BaseType
{
    /**
     * Berilgan xabar tomonidan javob berilgan xabarning iqtibosli qismining matni.
     * @var string
     */
    public string $text;

    /**
     * Ixtiyoriy. Iqtibosda ko'rinadigan maxsus obyektlar.
     * @var array|null
     */
    public ?array $entities = null;

    /**
     * Yuboruvchi tomonidan belgilangan UTF-16 kod birliklarida asl xabardagi taxminiy tirnoq pozitsiyasi.
     * @var int
     */
    public int $position;

    /**
     * Ixtiyoriy. True, agar taklif xabar jo'natuvchi tomonidan qo'lda tanlangan bo'lsa. Aks holda, taklif server tomonidan avtomatik ravishda qo'shilgan.
     * @var bool|null
     */
    public ?bool $is_manual = null;
}
