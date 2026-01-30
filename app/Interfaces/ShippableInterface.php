<?php

declare(strict_types=1);

namespace App\Interfaces;

use App\Enums\Country;

interface ShippableInterface
{
    public function getWeight(): int;

    public function getBoxVolume(): int;

    public function getDaysToDeliver(Country $country): int;
}