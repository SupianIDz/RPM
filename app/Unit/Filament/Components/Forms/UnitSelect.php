<?php

namespace App\Unit\Filament\Components\Forms;

use App\Unit\Models\Unit;
use Filament\Forms\Components\Select;

class UnitSelect extends Select
{
    protected function setUp() : void
    {
        parent::setUp();

        $this
            ->name('unit_id')
            ->label('Unit')
            ->placeholder('Select a unit')
            ->options(function () {
                return Unit::pluck('name', 'id');
            });

        $this->searchable()->required();
    }
}
