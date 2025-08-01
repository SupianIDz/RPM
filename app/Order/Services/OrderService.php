<?php

namespace App\Order\Services;

use App\Customer\Models\Customer;
use App\Order\Models\Order;
use App\Order\Models\OrderItem;
use Illuminate\Support\Facades\DB;
use Throwable;

class OrderService
{
    /**
     * @param  Order $order
     */
    public function __construct(protected Order $order)
    {
        //
    }

    /**
     * @param  Customer $customer
     * @return OrderService
     * @throws Throwable
     */
    public function customer(Customer $customer) : OrderService
    {
        DB::transaction(function () use ($customer) {
            $this->order->update([
                'customer_id' => $customer->id,
            ]);

            if (filled($this->order->vehicle)) {
                $customer->vehicles()->updateOrCreate([
                    'vehicle_id' => $this->order->vehicle->id,
                ]);
            }

            return true;
        });

        return $this;
    }

    /**
     * @return bool
     */
    public function recalculate() : bool
    {
        $total = $this->order->items->sum(function (OrderItem $item) {
            return $item->quantity * $item->amount;
        });

        return $this->order->update([
            'amount' => $total,
        ]);
    }
}
