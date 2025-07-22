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
        'code', 'amount', 'created_by',
    ];

    /**
     * @return BelongsTo
     */
    public function product() : \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Product::class, 'code', 'code');
    }
}
