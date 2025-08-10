<?php

namespace App\Recap\Filament\Resources;

use App\Recap\Filament\Resources\RecapResource\Pages;
use App\Recap\Models\Recap;
use Filament\Pages\SubNavigationPosition;
use Filament\Resources\Pages\PageRegistration;
use Filament\Resources\Resource;

class RecapMonthlyResource extends Resource
{
    /**
     * @var string|null
     */
    protected static ?string $model = Recap::class;

    /**
     * @var string|null
     */
    protected static ?string $cluster = \App\Recap\Filament\Clusters\Recap::class;

    /**
     * @var string|null
     */
    protected static ?string $slug = 'monthly';

    /**
     * @var string|null
     */
    protected static ?string $breadcrumb = 'Monthly';

    /**
     * @var string|null
     */
    protected static ?string $navigationIcon = 'lucide-calendar-clock';

    /**
     * @var string|null
     */
    protected static ?string $navigationLabel = 'MONTHLY';

    /**
     * @var int|null
     */
    protected static ?int $navigationSort = 1;

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
            'index' => Pages\ListRecapMonthlies::route('/'),
        ];
    }
}
