<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\ProductCondition;
use App\Enums\StockStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

final class StockLevel extends Model
{

    protected $fillable = [
        'product_id',
        'quantity',
        'status',
        'condition',
    ];

    protected $casts = [
        'status'    => StockStatus::class,
        'condition' => ProductCondition::class,
    ];

    protected static function booted(): void
    {
        static::saving(function (StockLevel $stockLevel): void {
            $stockLevel->status = StockStatus::fromQuantity($stockLevel->quantity);
        });
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(DigitalProduct::class);
    }
}