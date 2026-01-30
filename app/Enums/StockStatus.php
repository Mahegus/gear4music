<?php

declare(strict_types=1);

namespace App\Enums;

enum StockStatus: string
{
    case InStock = 'in_stock';
    case LowStock = 'low_stock';
    case OutOfStock = 'out_of_stock';

    public static function fromQuantity(int $quantity): self
    {
        return match (true) {
            $quantity <= 0 => self::OutOfStock,
            $quantity <= 5 => self::LowStock,
            default        => self::InStock,
        };
    }

    public function isAvailable(): bool
    {
        return match ($this) {
            self::InStock, self::LowStock => true,
            self::OutOfStock              => false,
        };
    }

    public function label(): string
    {
        return match ($this) {
            self::InStock    => 'In Stock',
            self::LowStock   => 'Low Stock',
            self::OutOfStock => 'Out of Stock',
        };
    }
}