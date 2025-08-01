<?php

namespace App\Order\Filament\Resources\OrderResource\Actions;

use App\Order\Models\Order;
use App\Order\Models\OrderItem;
use Filament\Support\Enums\MaxWidth;

class ModifyAction extends \App\Support\Filament\Tables\Actions\ModifyAction
{
    /**
     * @return void
     */
    protected function setUp() : void
    {
        parent::setUp();

        $this
            ->modalWidth(MaxWidth::SixExtraLarge)
            ->form(new Forms\Form()->configure($this));
    }
}
