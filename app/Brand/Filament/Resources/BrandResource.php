<?php

namespace App\Brand\Filament\Resources;

use App\Brand\Models\Brand;
use App\Product\Filament\Resources\BrandResource\Pages;
use App\Setting\Filament\Clusters\Setting;
use Filament\Pages\SubNavigationPosition;
use Filament\Resources\Resource;

class BrandResource extends Resource
{
    protected static ?string $model = Brand::class;

    protected static ?string $cluster = Setting::class;

    protected static ?string $slug = 'brands';

    protected static ?string $navigationIcon = 'lucide-ungroup';

    protected static ?string $navigationLabel = 'BRANDS';

    protected static ?int $navigationSort = 1;

    protected static SubNavigationPosition $subNavigationPosition = SubNavigationPosition::Top;

    public static function getPages() : array
    {
        return [
            'index' => BrandResource\Pages\ListBrands::route('/'),
        ];
    }

    public static function getGloballySearchableAttributes() : array
    {
        return ['name'];
    }
}
