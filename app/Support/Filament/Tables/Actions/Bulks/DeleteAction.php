<?php

namespace App\Support\Filament\Tables\Actions\Bulks;

use Filament\Tables\Actions\DeleteBulkAction;
use Override;

class DeleteAction extends DeleteBulkAction
{
    /**
     * @return void
     */
    #[Override]
    protected function setUp() : void
    {
        parent::setUp();

        $this
            ->icon('lucide-trash-2')
            ->requiresConfirmation();
    }
}
