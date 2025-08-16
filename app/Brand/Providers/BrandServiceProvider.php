<?php

namespace App\Brand\Providers;

use App\Brand\Console\Commands\GenerateLogoCommand;
use Illuminate\Support\ServiceProvider;

class BrandServiceProvider extends ServiceProvider
{
    /**
     * @return void
     */
    public function register() : void
    {
        $this->commands([
            GenerateLogoCommand::class,
        ]);
    }
}
