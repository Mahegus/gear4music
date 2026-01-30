<?php

declare(strict_types=1);

namespace App\Enums;

enum Currency: string
{
    case GBP = 'GBP';
    case EUR = 'EUR';

    public function symbol(): string
    {
        return match ($this) {
            self::GBP => '£',
            self::EUR => '€',
        };
    }

    public function minorUnitDigits(): int
    {
        return match ($this) {
            self::GBP, self::EUR => 2,
        };
    }

    public function label(): string
    {
        return match ($this) {
            self::GBP => 'British Pound Sterling',
            self::EUR => 'Euro',
        };
    }
}
