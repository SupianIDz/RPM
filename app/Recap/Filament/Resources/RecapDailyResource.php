<?php

namespace App\Recap\Filament\Resources;

use App\Recap\Filament\Clusters\Recap;
use App\Recap\Filament\Resources\RecapDailyResource\Pages;
use App\Recap\Filament\Resources\RecapDailyResource\RelationManagers\FooRelationManager;
use App\Recap\Models\RecapDaily;
use Filament\Pages\SubNavigationPosition;
use Filament\Resources\Pages\PageRegistration;
use Filament\Resources\Resource;

class RecapDailyResource extends Resource
{
    /**
     * @var string|null
     */
    protected static ?string $model = RecapDaily::class;

    /**
     * @var string|null
     */
    protected static ?string $cluster = Recap::class;

    /**
     * @var string|null
     */
    protected static ?string $slug = 'dailies';

    protected static ?string $recordRouteKeyName = 'period';

    /**
     * @var string|null
     */
    protected static ?string $breadcrumb = 'Daily';

    /**
     * @var string|null
     */
    protected static ?string $navigationIcon = 'lucide-calendar-range';

    /**
     * @var string|null
     */
    protected static ?string $navigationLabel = 'DAILY';

    /**
     * @var int|null
     */
    protected static ?int $navigationSort = 0;

    /**
     * @var SubNavigationPosition
     */
    protected static SubNavigationPosition $subNavigationPosition = SubNavigationPosition::Top;

    /**
     * @return PageRegistration[]
     */
    public static function getPages() : array
    {
        return [
            'index' => Pages\ListRecapDailies::route('/'),
            'show'  => Pages\DailySoldProduct::route('/{record:period}'),
        ];
    }
}
