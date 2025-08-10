<?php

namespace App\Recap\Filament\Resources\RecapDailyResource\Pages;

use App\Recap\Filament\Resources\RecapDailyResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditRecapDaily extends EditRecord
{
    protected static string $resource = RecapDailyResource::class;

    protected function getHeaderActions() : array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
