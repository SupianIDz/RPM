<?php

namespace App\Support\Filament\Actions;

use Closure;

class CreateAction extends \Filament\Actions\CreateAction
{
    protected bool|Closure $canCreateAnother = false;

    /**
     * @return void
     */
    protected function setUp() : void
    {
        parent::setUp();

        $this
            ->icon('lucide-plus')
            ->label('Create')
            ->closeModalByClickingAway(false);
    }
}
