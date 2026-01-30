<?php

declare(strict_types=1);

namespace App\Enums;

use App\Models\Base\BaseProduct;
use App\Models\PhysicalProduct;

enum ProductType: string
{
    case Physical = 'physical';
    case Digital = 'digital';

    public static function baseProductClass(): String
    {
        return match (self::class) {
            self::Physical => PhysicalProduct::class,
            self::Digital  => BaseProduct::class,
            default        => BaseProduct::class,
        };
    }

    public function isShippable(): bool
    {
        return match ($this) {
            self::Physical => true,
            self::Digital  => false,
        };
    }

    public function label(): string
    {
        return match ($this) {
            self::Physical => 'Physical Product',
            self::Digital  => 'Digital Product',
        };
    }
}