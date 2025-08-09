<?php

namespace App\Recap\Filament\Resources\RecapResource\Pages;

use App\Recap\Filament\Resources\RecapResource;
use Filament\Resources\Pages\CreateRecord;

class CreateRecap extends CreateRecord
{
    protected static string $resource = RecapResource::class;

    protected function getHeaderActions() : array
    {
        return [

        ];
    }
}
