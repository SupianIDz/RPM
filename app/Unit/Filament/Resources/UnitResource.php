<?php

namespace App\Unit\Filament\Resources;

use App\Product\Filament\Resources\UnitResource\Pages;
use App\Setting\Filament\Clusters\Setting;
use App\Unit\Models\Unit;
use Filament\Pages\SubNavigationPosition;
use Filament\Resources\Resource;

class UnitResource extends Resource
{
    protected static ?string $model = Unit::class;

    protected static ?string $cluster = Setting::class;

    protected static ?string $slug = 'units';

    protected static ?string $navigationIcon = 'lucide-ungroup';

    protected static ?string $navigationLabel = 'UNITS';

    protected static ?int $navigationSort = 3;

    protected static SubNavigationPosition $subNavigationPosition = SubNavigationPosition::Top;

    /**
     * @return array
     */
    public static function getPages() : array
    {
        return [
            'index' => UnitResource\Pages\ListUnits::route('/'),
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
