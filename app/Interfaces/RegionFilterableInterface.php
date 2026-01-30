<?php

declare(strict_types=1);

namespace App\Interfaces;

use App\Enums\Country;

interface RegionFilterableInterface
{
    public function isVisibleIn(Country $country): bool;

    /** @return Country[] */
    public function visibleCountries(): array;
}
