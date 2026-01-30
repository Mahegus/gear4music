<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\Currency;
use App\Enums\ProductCondition;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

final class ProductPrice extends Model
{
    protected $fillable = [
        'product_id',
        'currency_code',
        'price',
        'condition',
    ];

    protected $casts = [
        'currency_code' => Currency::class,
        'condition'     => ProductCondition::class,
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(DigitalProduct::class);
    }
}