<?php

namespace App\Product\Filament\Resources\ProductResource\Actions;

class ModifyAction extends \App\Support\Filament\Tables\Actions\ModifyAction
{
    /**
     * @return void
     */
    protected function setUp() : void
    {
        parent::setUp();

        $this->form(new Forms\Form()->configure($this));
    }
}
