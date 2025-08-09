<?php

namespace App\Recap\Services;

use App\Order\Enums\Payment;
use App\Order\Models\Order;
use App\Recap\Enums\Type;
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

        $recap->increment($this->getOrderColumn(), $count);
        $recap->increment($this->getValueColumn(), $total);

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

        $recap->decrement($this->getOrderColumn(), $count);
        $recap->decrement($this->getValueColumn(), $total);

        return $this;
    }

    /**
     * @return Recap
     */
    private function recap() : Recap
    {
        $this->generateFullYears();

        return
            Recap::firstOrCreate([
                'period' => $this->order->date->format('Y-m-1'),
            ]);
    }

    /**
     * @return void
     */
    private function generateFullYears() : void
    {
        $query = Recap::whereYear('period', now()->year);

        if (! $query->exists() || $query->count() < 12 * count(Type::cases())) {
            foreach (range(1, 12) as $month) {
                $query->firstOrCreate([
                    'period' => now()->year . '-' . $month . '-1',
                ]);
            }
        }
    }

    /**
     * @return string
     */
    public function getOrderColumn() : string
    {
        return match ($this->order->payment) {
            Payment::CASH        => 'total_order_c',
            Payment::TRANSFER    => 'total_order_t',
            Payment::MARKETPLACE => 'total_order_m',
        };
    }

    /**
     * @return string
     */
    public function getValueColumn() : string
    {
        return match ($this->order->payment) {
            Payment::CASH        => 'total_value_c',
            Payment::TRANSFER    => 'total_value_t',
            Payment::MARKETPLACE => 'total_value_m',
        };
    }
}
