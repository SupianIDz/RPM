<?php

namespace App\Order\Models;

use App\Order\Observers\OrderItemObserver;
use App\Product\Models\Product;
use App\Product\Models\ProductPrice;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[ObservedBy([OrderItemObserver::class])]
class OrderItem extends Model
{
    use HasUuids;

    /**
     * @var string[]
     */
    protected $fillable = [
        'invoice', 'name', 'quantity', 'product_id', 'product_price_id', 'type', 'amount',
    ];

    /**
     * @return Attribute
     */
    protected function fullName() : Attribute
    {
        return Attribute::make(function () {
            $name = [];

            $name[] = $this->name;

            if ($this->product) {
                $name[] = $this->product->brand->name;
            }

            return implode(' - ', array_filter($name));
        });
    }

    /**
     * @return Attribute
     */
    protected function total() : Attribute
    {
        return Attribute::get(function () {
            return $this->amount * $this->quantity;
        });
    }

    /**
     * @return Attribute
     */
    protected function image() : Attribute
    {
        return Attribute::get(function () {
            $image = $this->product->image?->name;
            if ($image) {
                return storage('product:image')->url($image);
            }

            return asset('images/no-image.svg');
        });
    }

    /**
     * @return BelongsTo
     */
    public function price() : BelongsTo
    {
        return $this->belongsTo(ProductPrice::class, 'product_price_id');
    }

    public function product() : BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function order() : BelongsTo
    {
        return $this->belongsTo(Order::class, 'invoice', 'invoice');
    }
}


