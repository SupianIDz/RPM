<?php

namespace App\Recap\Services;

use App\Order\Models\Order;
use App\Recap\Models\Recap;

class RecapService
{
    /**
     * @param  Order $order
     */
    public function __construct(protected Order $order)
    {
        //
    }

    /**
     * @param  float $total
     * @param  int   $count
     * @return RecapService
     */
    public function create(float $total, int $count = 1) : RecapService
    {
        $recap = $this->recap();

        $recap->increment('total_order', $count);
        $recap->increment('total_value', $total);

        return $this;
    }

    /**
     * @param  float $total
     * @param  int   $count
     * @return RecapService
     */
    public function delete(float $total, int $count = 1) : RecapService
    {
        $recap = $this->recap();

        if ($recap->total_order > 0) {
            $recap->decrement('total_order', $count);
        }

        if ($recap->total_value > 0) {
            $recap->decrement('total_value', $total);
        }

        return $this;
    }

    /**
     * @return Recap
     */
    private function recap() : Recap
    {
        return
            Recap::firstOrCreate([
                'type'   => $this->order->payment,
                'period' => $this->order->date->format('Y-m-1'),
            ]);
    }
}
