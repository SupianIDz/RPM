<?php

namespace App\Product\Filament\Resources\UnitResource\Pages;

use App\Product\Filament\Resources\UnitResource;
use Filament\Resources\Pages\CreateRecord;

class CreateUnit extends CreateRecord
{
    protected static string $resource = UnitResource::class;

    protected function getHeaderActions() : array
    {
        return [

        ];
    }
}
