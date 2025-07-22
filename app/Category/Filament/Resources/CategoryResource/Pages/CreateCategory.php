<?php

namespace App\Category\Filament\Resources\CategoryResource\Pages;

use App\Category\Filament\Resources\CategoryResource;
use Filament\Resources\Pages\CreateRecord;

class CreateCategory extends CreateRecord
{
    protected static string $resource = CategoryResource::class;

    protected function getHeaderActions() : array
    {
        return [

        ];
    }
}
