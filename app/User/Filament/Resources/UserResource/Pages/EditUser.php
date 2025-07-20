<?php

namespace App\User\Filament\Resources\UserResource\Pages;

use App\User\Filament\Resources\UserResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditUser extends EditRecord
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions() : array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
