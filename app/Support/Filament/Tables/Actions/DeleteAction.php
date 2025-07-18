<?php

namespace App\Support\Filament\Tables\Actions;

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
            ->icon('lucide-trash-2');
    }
}
