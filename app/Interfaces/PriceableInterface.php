<?php

declare(strict_types=1);

namespace App\Interfaces;

use App\Enums\Currency;
use App\Enums\ProductCondition;

interface PriceableInterface
{
    public function getPrice(Currency $currency, ProductCondition $productCondition): float;

    public function getBaseCurrency(): Currency;

    public function getBasePrice(): float;
}