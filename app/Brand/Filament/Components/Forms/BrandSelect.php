<?php

namespace App\Brand\Filament\Components\Forms;

use App\Brand\Models\Brand;
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
                return Brand::active()->pluck('name', 'id');
            });

        $this->searchable();
    }
}
