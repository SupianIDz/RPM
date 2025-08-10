<?php

namespace App\Recap\Filament\Resources;

use App\Recap\Filament\Resources\RecapResource\Pages;
use App\Recap\Models\Recap;
use Filament\Resources\Resource;

class RecapResource extends Resource
{
    protected static ?string $model = Recap::class;

    protected static ?string $slug = 'recaps';

    protected static ?string $navigationIcon = 'lucide-pie-chart';

    protected static ?int $navigationSort = 3;

    public static function getPages() : array
    {
        return [
            'index'  => Pages\ListRecaps::route('/'),
        ];
    }
}
