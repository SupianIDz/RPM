<?php

namespace App\Product\Filament\Resources;

use App\Product\Filament\Resources\CategoryResource\Pages;
use App\Product\Models\Category;
use App\Setting\Filament\Clusters\Setting;
use Filament\Pages\SubNavigationPosition;
use Filament\Resources\Resource;

class CategoryResource extends Resource
{
    protected static ?string $model = Category::class;

    protected static ?string $cluster = Setting::class;

    protected static ?string $slug = 'categories';

    protected static ?string $navigationIcon = 'lucide-tags';

    protected static ?string $navigationLabel = 'CATEGORIES';

    protected static SubNavigationPosition $subNavigationPosition = SubNavigationPosition::Top;


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
