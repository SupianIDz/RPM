<?php

namespace App\Order\Console\Commands;

use App\Order\Models\Order;
use Illuminate\Console\Command;

class FixOrderPaymentCommand extends Command
{
    protected $signature = 'order:fix-payment';

    protected $description = 'Command description';

    public function handle() : void
    {
        Order::get()->each(function (Order $order) {
            if ($order->payments->isEmpty()) {
                $order->payments()->create([
                    'amount' => $order->amount,
                    'type'   => $order->payment,
                ]);
            }
        });
    }
}
