<?php

namespace App\Brand\Filament\Components\Forms;

use Filament\Forms\Components\Select;

class BrandSelect extends Select
{
    protected function setUp() : void
    {
        parent::setUp();

        $this
            ->name('brand_id')
            ->label('Brand')
            ->placeholder('Select a brand')
            ->options(function () {
                return \App\Brand\Models\Brand::active()->pluck('name', 'id');
            });

        $this->searchable();
    }
}
