<?php

namespace App\Support\Filament\Tables\Actions;

use Filament\Support\Enums\IconSize;
use Override;

class DeleteAction extends \Filament\Tables\Actions\DeleteAction
{
    /**
     * @return void
     */
    #[Override]
    protected function setUp() : void
    {
        parent::setUp();

        $this
            ->hiddenLabel()
            ->icon('lucide-trash-2')
            ->iconSize(IconSize::Medium)
            ->requiresConfirmation();
    }
}
