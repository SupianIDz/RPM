<?php

namespace App\Support\Filament\Tables\Actions;

use Filament\Support\Enums\IconSize;
use Filament\Tables\Actions\EditAction;

class ModifyAction extends EditAction
{
    /**
     * @return void
     */
    protected function setUp() : void
    {
        parent::setUp();

        $this
            ->hiddenLabel()
            ->tooltip('EDIT')
            ->icon('lucide-pen-square')
            ->iconSize(IconSize::Medium)
            ->color('warning');
    }
}
