<?php

namespace App\Recap\Services;

use App\Order\Enums\Payment;
use App\Order\Models\Order;
use App\Recap\Models\Recap;
use App\Recap\Models\RecapDaily;
use Illuminate\Database\Eloquent\Model;

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
        $recap = $this->recapDaily();

        foreach ($this->order->payments as $payment) {
            $recap->increment($this->getOrderColumn($payment->type), $count);
            $recap->increment($this->getValueColumn($payment->type), $total);
        }

        return $this;
    }

    /**
     * @param  float $total
     * @param  int   $count
     * @return RecapService
     */
    public function delete(float $total, int $count = 1) : RecapService
    {
        $recap = $this->recapDaily();

        foreach ($this->order->payments as $payment) {
            $recap->decrement($this->getOrderColumn($payment->type), $count);
            $recap->decrement($this->getValueColumn($payment->type), $total);
        }

        return $this;
    }

    /**
     * @return Recap|Model
     */
    private function recapDaily() : Model|Recap
    {
        $this->generateFullYears();
        $this->generateFullMonth();

        return
            RecapDaily::firstOrCreate([
                'period' => $this->order->date->format('Y-m-d'),
            ]);
    }

    /**
     * @return void
     */
    private function generateFullYears() : void
    {
        $query = Recap::whereYear('period', now()->year);

        if (! $query->exists()) {
            foreach (range(1, 12) as $month) {
                $query->firstOrCreate([
                    'period' => now()->year . '-' . $month . '-1',
                ]);
            }
        }
    }

    /**
     * @return void
     */
    private function generateFullMonth() : void
    {
        $str = now()->startOfMonth();
        $end = now()->endOfMonth();

        $dates = [];

        for ($date = $str->copy(); $date->lte($end); $date->addDay()) {
            RecapDaily::firstOrCreate([
                'period' => $date->format('Y-m-d'),
            ]);
        }
    }

    /**
     * @param  Payment $payment
     * @return string
     */
    public function getOrderColumn(Payment $payment) : string
    {
        return match ($payment) {
            Payment::CASH        => 'total_order_c',
            Payment::TRANSFER    => 'total_order_t',
            Payment::MARKETPLACE => 'total_order_m',
        };
    }

    /**
     * @param  Payment $payment
     * @return string
     */
    public function getValueColumn(Payment $payment) : string
    {
        return match ($payment) {
            Payment::CASH        => 'total_value_c',
            Payment::TRANSFER    => 'total_value_t',
            Payment::MARKETPLACE => 'total_value_m',
        };
    }
}
