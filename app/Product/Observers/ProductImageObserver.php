<?php

namespace App\Product\Observers;

use App\Product\Models\ProductImage;

class ProductImageObserver
{
    /**
     * @param  ProductImage $image
     * @return void
     */
    public function creating(ProductImage $image) : void
    {
        $image->product->images()->delete();
    }

    /**
     * @param  ProductImage $image
     * @return void
     */
    public function deleting(ProductImage $image) : void
    {
        storage('product:image')->delete($image->name);
    }
}
