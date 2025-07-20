<?php

namespace App\Brand\Filament\Resources\BrandResource\Pages;

use App\Brand\Filament\Resources\BrandResource;
use Filament\Resources\Pages\CreateRecord;

class CreateBrand extends CreateRecord
{
    protected static string $resource = BrandResource::class;

    protected function getHeaderActions() : array
    {
        return [

        ];
    }
}
