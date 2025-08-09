<?php

namespace App\Recap\Filament\Resources\RecapResource\Pages;

use App\Recap\Filament\Resources\RecapResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditRecap extends EditRecord
{
    protected static string $resource = RecapResource::class;

    protected function getHeaderActions() : array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
