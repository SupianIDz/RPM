<?php

namespace App\Product\Filament\Resources;

use App\Product\Filament\Resources\CategoryResource\Pages;
use App\Product\Models\Category;
use Filament\Resources\Resource;

class CategoryResource extends Resource
{
    protected static ?string $model = Category::class;

    protected static ?string $slug = 'categories';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function getPages() : array
    {
        return [
            'index' => Pages\ListCategories::route('/'),
        ];
    }

    public static function getGloballySearchableAttributes() : array
    {
        return [];
    }
}
