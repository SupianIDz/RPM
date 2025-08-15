<?php

namespace App\Recap\Providers;

use Illuminate\Support\ServiceProvider;

class RecapServiceProvider extends ServiceProvider
{
    /**
     * @return void
     */
    public function boot() : void
    {
        $this->loadRoutesFrom(__DIR__ . '/../routes.php');
    }
}
