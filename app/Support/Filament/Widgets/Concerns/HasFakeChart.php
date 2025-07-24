<?php

namespace App\Support\Filament\Widgets\Concerns;

use Filament\Widgets\StatsOverviewWidget\Stat;
use Random\RandomException;

trait HasFakeChart
{
    /**
     * @param  int $iterate
     * @param  int $min
     * @param  int $max
     * @return int[]
     * @throws RandomException
     */
    private function fakeChartData(int $iterate = 10, int $min = 5, int $max = 16) : array
    {
        $rands = [];

        for ($i = 0; $i < $iterate; $i++) {
            $rands[] = random_int($min, $max);
        }

        return $rands;
    }

    /**
     * @param  Stat $stat
     * @return Stat
     * @throws RandomException
     */
    private function fakeChart(Stat $stat) : Stat
    {
        return $stat->chart($this->fakeChartData());
    }
}
