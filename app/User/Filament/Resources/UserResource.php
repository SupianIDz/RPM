<?php

namespace App\User\Filament\Resources;

use App\User\Filament\Resources\UserResource\Pages;
use App\User\Models\User;
use Filament\Resources\Resource;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $slug = 'users';

    protected static ?string $navigationIcon = 'lucide-users';

    protected static ?int $navigationSort = 4;

    /**
     * @return array
     */
    public static function getPages() : array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
        ];
    }

    /**
     * @return array
     */
    public static function getGloballySearchableAttributes() : array
    {
        return [];
    }
}
