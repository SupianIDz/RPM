<?php

namespace App\Recap\Observers;

use App\Recap\Models\Recap;
use App\Recap\Models\RecapDaily;
use App\Recap\Services\SyncRecapService;

class RecapDailyObserver
{
    /**
     * @param  RecapDaily $daily
     * @return void
     */
    public function created(RecapDaily $daily) : void
    {
        new SyncRecapService()->daily($daily);
    }

    /**
     * @param  RecapDaily $daily
     * @return void
     */
    public function updated(RecapDaily $daily) : void
    {
        new SyncRecapService()->daily($daily);
    }

    /**
     * @param  RecapDaily $daily
     * @return void
     */
    public function deleted(RecapDaily $daily) : void
    {
        Recap::where('period', $daily->period)->delete();
    }
}
