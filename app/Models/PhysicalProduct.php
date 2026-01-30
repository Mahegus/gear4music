<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\Country;
use App\Models\Base\BaseProduct;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

final class PhysicalProduct extends BaseProduct
{
    public function getWeight(): int
    {
        return $this->weight ?? 0;
    }

    public function getBoxVolume(): int
    {
        return $this->box_volume ?? 0;
    }

    public function getDaysToDeliver(Country $country): int
    {
        return $country->baseDeliveryDays();
    }
}