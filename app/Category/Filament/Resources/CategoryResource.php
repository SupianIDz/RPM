<?php

namespace App\Category\Filament\Resources;

use App\Category\Filament\Resources;
use App\Category\Models\Category;
use App\Product\Filament\Resources\CategoryResource\Pages;
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

    protected static ?int $navigationSort = 2;

    protected static SubNavigationPosition $subNavigationPosition = SubNavigationPosition::Top;

    public static function getPages() : array
    {
        return [
            'index' => Resources\CategoryResource\Pages\ListCategories::route('/'),
        ];
    }
}
