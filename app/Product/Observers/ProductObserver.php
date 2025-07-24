<?php

namespace App\Product\Observers;

use App\Product\Models\Product;
use Illuminate\Support\Str;

class ProductObserver
{
    /**
     * @param  Product $product
     * @return void
     */
    public function creating(Product $product) : void
    {
        if (! $product->code) {
            $product->code = 'RPM-' . strtoupper(Str::random(5));
        }
    }
}
