<?php

namespace App\Order\Observers;

use App\Order\Models\OrderItem;

class OrderItemObserver
{
    /**
     * @param  OrderItem $item
     * @return void
     */
    public function creating(OrderItem $item) : void
    {
        if (blank($item->name) && filled($item->product_id)) {
            $item->name = $item->product->name;
        }

        $item->cogs = $item->product->price->cogs;
    }
}
