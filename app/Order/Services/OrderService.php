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
     * Create a new service instance for a given order.
     *
     * @param  Order $order
     */
    public function __construct(protected Order $order)
    {
        // Initialization only
    }

    /**
     * Synchronize customer and recalculate the order amount.
     *
     * If a customer is assigned to the order, this method ensures
     * the customer's relation and associated vehicle data are synced.
     * It also recalculates the total amount of the order.
     *
     * @return void
     * @throws Throwable
     */
    public function sync() : void
    {
        if ($this->order->customer) {
            $this->customer($this->order->customer);
        }

        $this->recalculate();
    }

    /**
     * Assign a customer to the order and sync vehicle data if present.
     *
     * If the order is linked to a vehicle, this method will ensure
     * the customer has that vehicle listed in their records.
     *
     * @param  Customer $customer
     * @return OrderService
     * @throws Throwable
     */
    public function customer(Customer $customer) : OrderService
    {
        DB::transaction(function () use ($customer) {
            // Associate the customer with the order
            $this->order->update([
                'customer_id' => $customer->id,
            ]);

            // Sync vehicle relationship to customer if applicable
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
     * Recalculate the total amount of the order based on its items.
     *
     * Loops through each order item and sums up the total based on quantity and amount.
     *
     * @return bool
     * @throws Throwable
     */
    public function recalculate() : bool
    {
        // Calculate total from all order items
        $total = $this->order->items->sum(function (OrderItem $item) {
            return $item->quantity * $item->amount;
        });

        // Update the order amount
        return $this->order->update([
            'amount' => $total,
        ]);
    }
}
