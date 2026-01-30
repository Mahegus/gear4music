<?php

declare(strict_types=1);

namespace App\Models\Base;

use App\Enums\Country;
use App\Enums\Currency;
use App\Enums\Language;
use App\Enums\ProductCondition;
use App\Enums\ProductType;
use App\Interfaces\InventoryInterface;
use App\Interfaces\PriceableInterface;
use App\Interfaces\RegionFilterableInterface;
use App\Interfaces\ShippableInterface;
use App\Interfaces\TranslationInterface;
use App\Models\ProductCountry;
use App\Models\ProductPrice;
use App\Models\ProductTranslation;
use App\Models\StockLevel;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

abstract class BaseProduct extends Model implements
    InventoryInterface,
    TranslationInterface,
    PriceableInterface,
    RegionFilterableInterface,
    ShippableInterface
{
    protected $fillable = [
        'sku',
        'type',
        'weight',
        'box_volume',
    ];

    protected $casts = [
        'type'      => ProductType::class,
        'condition' => ProductCondition::class,
    ];

    public function translations(): HasMany
    {
        return $this->hasMany(ProductTranslation::class);
    }

    public function prices(): HasMany
    {
        return $this->hasMany(ProductPrice::class);
    }

    public function countryVisibility(): HasMany
    {
        return $this->hasMany(ProductCountry::class);
    }

    public function stockLevels(): HasMany
    {
        return $this->hasHany(StockLevel::class);
    }

    public function scopeVisibleInCountry(Builder $query, Country $country): Builder
    {
        return $query->whereHas('countryVisibility', function (Builder $q) use ($country): void {
            $q->where('country_code', $country->value);
        });
    }

    public function scopeAvailable(Builder $query): Builder
    {
        return $query->whereHas('stockLevels', function (Builder $q) {
            $q->where('quantity', '>', 0);
        });
    }

    public function getSku(): string
    {
        return $this->sku;
    }

    public function getType(): ProductType
    {
        return $this->type;
    }

    public function isAvailable(): bool
    {
        return $this->stockLevels?->quantity > 0;
    }

    public function getStockLevel(): int
    {
        return $this->stockLevels?->quantity ?? 0;
    }

    public function getName(Language $language): string
    {
        return $this->getTranslationField('name', $language);
    }

    public function getDescription(Language $language): string
    {
        return $this->getTranslationField('description', $language);
    }

    public function getPrice(Currency $currency, ?ProductCondition $productCondition = null): float
    {
        return $this->prices->firstWhere([
            'currency_code' => $currency,
            'condition'     => $productCondition ?? ProductCondition::New,
        ]);
    }

    public function getBasePrice(): float
    {
        return $this->getPrice($this->getBaseCurrency())->price;
    }

    public function getBaseCurrency(): Currency
    {
        return Currency::GBP;
    }

    public function getWeight(): int
    {
        return 0;
    }

    public function getBoxVolume(): int
    {
        return 0;
    }

    public function getDaysToDeliver(Country $country): int
    {
        return 0;
    }

    public function isVisibleIn(Country $country): bool
    {
        return $this->countryVisibility->contains('country_code', $country);
    }

    public function visibleCountries(): array
    {
        return $this->countryVisibility->pluck('country_code')->all();
    }

    private function getTranslationField(string $field, Language $language): string
    {
        $translations = $this->translations;

        $localised = $translations->firstWhere('language_code', $language);
        if ($localised) {
            return $localised->{$field};
        }

        $fallback = $translations->firstWhere('language_code', Language::EN);

        return $fallback?->{$field} ?? '';
    }
}