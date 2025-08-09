<?php

namespace App\Support\Filament\Tables\Actions;

use Filament\Support\Enums\IconSize;
use Filament\Tables\Actions\ViewAction;

class DetailAction extends ViewAction
{
    /**
     * @return void
     */
    protected function setUp() : void
    {
        parent::setUp();

        $this
            ->hiddenLabel()
            ->tooltip('VIEW')
            ->icon('lucide-eye')
            ->color('primary')
            ->iconSize(IconSize::Medium);
    }
}
