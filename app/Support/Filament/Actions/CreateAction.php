<?php

namespace App\Support\Filament\Actions;

class CreateAction extends \Filament\Actions\CreateAction
{
    /**
     * @return void
     */
    protected function setUp() : void
    {
        parent::setUp();

        $this
            ->icon('lucide-plus')
            ->label('Create');
    }
}
