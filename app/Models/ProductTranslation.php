<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\Language;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

final class ProductTranslation extends Model
{
    protected $fillable = [
        'product_id',
        'language_code',
        'name',
        'description',
    ];

    protected $casts = [
        'language_code' => Language::class,
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(DigitalProduct::class);
    }
}