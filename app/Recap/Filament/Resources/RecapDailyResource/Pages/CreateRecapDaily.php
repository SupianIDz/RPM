<?php

namespace App\Recap\Filament\Resources\RecapDailyResource\Pages;

use App\Recap\Filament\Resources\RecapDailyResource;
use Filament\Resources\Pages\CreateRecord;

class CreateRecapDaily extends CreateRecord
{
    protected static string $resource = RecapDailyResource::class;

    protected function getHeaderActions() : array
    {
        return [

        ];
    }
}
