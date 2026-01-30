<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\Country;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

final class ProductCountry extends Model
{
    protected $fillable = [
        'product_id',
        'country_code',
    ];

    protected $casts = [
        'country_code' => Country::class,
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(DigitalProduct::class);
    }
}