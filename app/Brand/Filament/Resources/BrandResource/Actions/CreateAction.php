<?php

namespace App\Brand\Filament\Resources\BrandResource\Actions;

use Override;

class CreateAction extends \App\Support\Filament\Actions\CreateAction
{
    #[Override]
    protected function setUp() : void
    {
        parent::setUp();

        $this
            ->form(new Forms\Form()->configure());
    }
}
