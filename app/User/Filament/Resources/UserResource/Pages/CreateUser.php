<?php

namespace App\User\Filament\Resources\UserResource\Pages;

use App\User\Filament\Resources\UserResource;
use Filament\Resources\Pages\CreateRecord;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions() : array
    {
        return [

        ];
    }
}
