<?php

namespace App\Order\Observers;

use App\Order\Models\Order;
use App\Recap\Services\RecapService;

class OrderObserver
{
    /**
     * @param  Order $order
     * @return void
     */
    public function updated(Order $order) : void
    {
        new RecapService($order)->create($order->total);
    }

    /**
     * @param  Order $order
     * @return void
     */
    public function deleted(Order $order) : void
    {
        new RecapService($order)->delete($order->total);
    }
}
