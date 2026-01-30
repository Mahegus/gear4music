<?php

declare(strict_types=1);

namespace App\Enums;

enum Country: string
{
    case GB = 'GB';
    case FR = 'FR';
    case ES = 'ES';

    public function defaultCurrency(): Currency
    {
        return match ($this) {
            self::GB           => Currency::GBP,
            self::FR, self::ES => Currency::EUR,
        };
    }

    public function defaultLanguage(): Language
    {
        return match ($this) {
            self::GB => Language::EN,
            self::FR => Language::FR,
            self::ES => Language::ES,
        };
    }

    public function label(): string
    {
        return match ($this) {
            self::GB => 'United Kingdom',
            self::FR => 'France',
            self::ES => 'Spain',
        };
    }

    public function baseDeliveryDays(): int
    {
        return match ($this) {
            self::GB => 1,
            self::FR => 3,
            self::ES => 4,
        };
    }
}