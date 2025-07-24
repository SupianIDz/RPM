<?php

namespace App\Support\Filament\Tables\Actions;

use Filament\Support\Enums\IconSize;

class RestoreAction extends \Filament\Tables\Actions\RestoreAction
{
    protected function setUp() : void
    {
        parent::setUp();

        $this
            ->hiddenLabel()
            ->tooltip('RESTORE')
            ->icon('lucide-archive-restore')
            ->iconSize(IconSize::Medium)
            ->color('info');
    }
}
