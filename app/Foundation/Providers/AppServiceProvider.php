<?php

namespace App\Foundation\Providers;

use App\Foundation\Providers\Filament\FilamentServiceProvider;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * @return void
     * @throws BindingResolutionException
     */
    public function register() : void
    {
        l3d()->register([
            'App\\' => app_path('/'),
        ]);

        $this->app->register(FilamentServiceProvider::class);
    }
}
