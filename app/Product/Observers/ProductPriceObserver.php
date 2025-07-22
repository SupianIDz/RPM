<?php

namespace App\Product\Observers;

use App\Product\Models\ProductPrice;

class ProductPriceObserver
{
    /**
     * @param  ProductPrice $price
     * @return void
     */
    public function creating(ProductPrice $price) : void
    {
        if ($price->product->price) {
            $price->product->price->delete();
        }
    }
}
