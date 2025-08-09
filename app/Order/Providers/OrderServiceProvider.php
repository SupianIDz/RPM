<?php

namespace App\Order\Providers;

use Illuminate\Support\ServiceProvider;

class OrderServiceProvider extends ServiceProvider
{
    /**
     * @return void
     */
    public function register() : void
    {
        $this->loadRoutesFrom(__DIR__ . '/../routes.php');
    }
}
