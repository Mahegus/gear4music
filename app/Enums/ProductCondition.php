<?php

declare(strict_types=1);

namespace App\Enums;

enum ProductCondition: string
{
    case New = 'new';
    case Used = 'used';
    case Refurbished = 'refurbished';

    public function priceMultiplier(): float
    {
        return match ($this) {
            self::New         => 1.0,
            self::Used        => 0.85,
            self::Refurbished => 0.70,
        };
    }

    public function hasDefaultWarranty(): bool
    {
        return match ($this) {
            self::New, self::Refurbished => true,
            self::Used                   => false,
        };
    }

    public function label(): string
    {
        return match ($this) {
            self::New         => 'New',
            self::Used        => 'Used',
            self::Refurbished => 'Refurbished',
        };
    }
}