<?php

namespace App\Product\Models;

use App\Product\Observers\ProductImageObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[ObservedBy([ProductImageObserver::class])]
class ProductImage extends Model
{
    use HasUuids;

    /**
     * @var string[]
     */
    protected $fillable = [
        'name', 'code',
    ];

    /**
     * @return BelongsTo
     */
    public function product() : BelongsTo
    {
        return $this->belongsTo(Product::class, 'code', 'code');
    }
}
