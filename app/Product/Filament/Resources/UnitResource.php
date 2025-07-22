<?php

namespace App\Product\Filament\Resources;

use App\Product\Filament\Resources\UnitResource\Pages;
use App\Product\Models\Unit;
use App\Setting\Filament\Clusters\Setting;
use Filament\Pages\SubNavigationPosition;
use Filament\Resources\Resource;

class UnitResource extends Resource
{
    protected static ?string $model = Unit::class;

    protected static ?string $cluster = Setting::class;

    protected static ?string $slug = 'units';

    protected static ?string $navigationIcon = 'lucide-ungroup';

    protected static ?string $navigationLabel = 'UNITS';

    protected static SubNavigationPosition $subNavigationPosition = SubNavigationPosition::Top;

    /**
     * @return array
     */
    public static function getPages() : array
    {
        return [
            'index' => Pages\ListUnits::route('/'),
        ];
    }

    /**
     * @return string[]
     */
    public static function getGloballySearchableAttributes() : array
    {
        return ['name'];
    }
}
