<?php

namespace App\Support\Filament\Tables\Actions;

use Filament\Support\Enums\IconSize;
use Override;

class ForceDeleteAction extends \Filament\Tables\Actions\ForceDeleteAction
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
            ->tooltip('DELETE')
            ->icon('lucide-trash-2')
            ->iconSize(IconSize::Medium)
            ->requiresConfirmation();
    }
}
