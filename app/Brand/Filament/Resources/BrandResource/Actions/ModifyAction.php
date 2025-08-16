<?php

namespace App\Brand\Filament\Resources\BrandResource\Actions;

use Override;

class ModifyAction extends \App\Support\Filament\Tables\Actions\ModifyAction
{
    #[Override]
    protected function setUp() : void
    {
        parent::setUp();

        $this
            ->form(new Forms\Form()->configure());
    }
}
