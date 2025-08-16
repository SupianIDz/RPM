<?php

namespace App\Product\Models;

use App\Product\Observers\ProductPriceObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

#[ObservedBy(ProductPriceObserver::class)]
class ProductPrice extends Model
{
    use HasUuids, SoftDeletes;

    /**
     * @var string[]
     */
    protected $fillable = [
        'code', 'cogs', 'amount', 'created_by',
    ];

    /**
     * @return string[]
     */
    protected function casts() : array
    {
        return [
            'cogs'   => 'decimal:0',
            'amount' => 'decimal:0',
        ];
    }

    /**
     * @return BelongsTo
     */
    public function product() : BelongsTo
    {
        return $this->belongsTo(Product::class, 'code', 'code');
    }
}
