<?php

declare(strict_types=1);

namespace App\Indexers;

use App\Enums\Country;
use App\Enums\Currency;
use App\Enums\Language;
use App\Enums\ProductCondition;
use App\Enums\ProductType;
use App\Models\Base\BaseProduct;
use App\Models\DigitalProduct;
use Illuminate\Database\Eloquent\Collection;

final class ProductIndexer
{
    public function getInventory(
        Country           $country,
        ?Language         $language = null,
        ?Currency         $currency = null,
        ?ProductType      $type = null,
        ?ProductCondition $condition = null,
        bool              $onlyAvailable = true,
    ): Collection {
        $language ??= $country->defaultLanguage();
        $currency ??= $country->defaultCurrency();

        $query = BaseProduct
            ::query()
            ->visibleInCountry($country)
            ->withRegionalData($language, $currency);

        if ($type !== null) {
            $query->ofType($type);
        }

        if ($condition !== null) {
            $query->ofCondition($condition);
        }

        if ($onlyAvailable) {
            $query->available();
        }

        return $query->get()->map(fn($product) => $product->morphTo());
    }

    /**
     * Retrieve a single product by SKU with regional data eager-loaded.
     */
    public function getProduct(
        string    $sku,
        Country   $country,
        ?Language $language = null,
        ?Currency $currency = null,
    ): ?DigitalProduct {
        $language ??= $country->defaultLanguage();
        $currency ??= $country->defaultCurrency();

        return BaseProduct
            ::query()
            ->where('sku', $sku)
            ->visibleInCountry($country)
            ->withRegionalData($language, $currency)
            ->first()
            ->morphTo();
    }
}