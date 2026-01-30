<?php

declare(strict_types=1);

namespace App\Interfaces;

use App\Enums\ProductCondition;
use App\Enums\ProductType;

interface InventoryInterface
{
    public function getSku(): string;

    public function getType(): ProductType;

    public function isAvailable(): bool;

    public function getStockLevel(): int;
}