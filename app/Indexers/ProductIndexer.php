<?php

declare(strict_types=1);

namespace App\Indexers;

use App\Enums\Country;
use App\Enums\Currency;
use App\Enums\Language;
use App\Enums\ProductType;
use App\Models\DigitalProduct;
use App\Models\PhysicalProduct;

final class ProductIndexer
{
    public function getInventory(
        Country           $country,
        ?Language         $language = null,
        ?Currency         $currency = null,
        ?ProductType      $type = null,
        bool              $onlyAvailable = true,
    ): Collection {
        $language ??= $country->defaultLanguage();
        $currency ??= $country->defaultCurrency();

        $buildQuery = static function (string $modelClass) use (
            $country,
            $language,
            $currency,
            $type,
            $onlyAvailable,
        ) {
            $query = $modelClass
                ::query()
                ->visibleInCountry($country)
                ->withRegionalData($language, $currency);

            if ($type !== null) {
                $query->ofType($type);
            }

            if ($onlyAvailable) {
                $query->available();
            }

            return $query;
        };

        if ($type !== null) {
            return $buildQuery($type->baseProductClass())->get();
        }

        $digital = $buildQuery(DigitalProduct::class)->get();
        $physical = $buildQuery(PhysicalProduct::class)->get();

        return $digital
            ->concat($physical)
            ->values();
    }

    /**
     * Retrieve a single product by SKU with regional data eager-loaded.
     * If $type is null, searches both digital and physical products.
     */
    public function getProduct(
        string       $sku,
        Country      $country,
        ?Language    $language = null,
        ?Currency    $currency = null,
        ?ProductType $type = null,
    ): DigitalProduct|PhysicalProduct|null {
        $language ??= $country->defaultLanguage();
        $currency ??= $country->defaultCurrency();

        $findIn = function (string $modelClass) use ($sku, $country, $language, $currency) {
            return $modelClass
                ::query()
                ->where('sku', $sku)
                ->visibleInCountry($country)
                ->withRegionalData($language, $currency)
                ->first();
        };

        if ($type !== null) {
            return $findIn($type->baseProductClass());
        }

        return $findIn(DigitalProduct::class)
               ?? $findIn(PhysicalProduct::class);
    }
}
