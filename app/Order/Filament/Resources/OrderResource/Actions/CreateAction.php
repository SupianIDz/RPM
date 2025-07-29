<?php

namespace App\Order\Filament\Resources\OrderResource\Actions;

use App\Support\Filament\Actions\CreateAction as Action;
use Filament\Support\Enums\MaxWidth;

class CreateAction extends Action
{
    /**
     * @return void
     */
    protected function setUp() : void
    {
        parent::setUp();

        $this
            ->form(new Forms\Form()->configure($this));
    }
}
