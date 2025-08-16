<?php

namespace App\Brand\Observers;

use App\Brand\Models\Brand;

class BrandObserver
{
    /**
     * @param  Brand $brand
     * @return void
     */
    public function deleted(Brand $brand) : void
    {
        $brand->products()->update([
            'brand_id' => null,
        ]);
    }
}
