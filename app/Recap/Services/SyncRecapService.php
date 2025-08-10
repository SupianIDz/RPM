<?php

namespace App\Recap\Services;

use App\Recap\Models\Recap;
use App\Recap\Models\RecapDaily;

class SyncRecapService
{
    /**
     * Synchronize monthly recap totals based on daily recap data.
     *
     * This method aggregates all RecapDaily records within the same month and year
     * as the given $daily record, then updates or creates the corresponding Recap record
     * with the summed totals.
     *
     * @param  RecapDaily $daily The daily recap instance used as reference period.
     * @return void
     */
    public function daily(RecapDaily $daily) : void
    {
        // Fetch all daily recaps in the same month and year as $daily
        $dailyRecaps = RecapDaily::period($daily->period)->get();

        // Determine the period date representing the first day of the month
        $period = $daily->period->copy()->startOfMonth()->format('Y-m-d');

        // Update existing monthly recap or create if not exists
        Recap::updateOrCreate(['period' => $period], [
            'total_order_c' => $dailyRecaps->sum('total_order_c'),
            'total_value_c' => $dailyRecaps->sum('total_value_c'),
            'total_order_t' => $dailyRecaps->sum('total_order_t'),
            'total_value_t' => $dailyRecaps->sum('total_value_t'),
            'total_order_m' => $dailyRecaps->sum('total_order_m'),
            'total_value_m' => $dailyRecaps->sum('total_value_m'),
        ]);
    }
}
