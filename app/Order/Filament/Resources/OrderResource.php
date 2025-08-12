<?php

namespace App\Order\Filament\Resources;

use App\Order\Filament\Resources\OrderResource\Pages;
use App\Order\Models\Order;
use Filament\Resources\Pages\PageRegistration;
use Filament\Resources\Resource;

class OrderResource extends Resource
{
    /**
     * @var string|null
     */
    protected static ?string $model = Order::class;

    /**
     * @var string|null
     */
    protected static ?string $slug = 'orders';

    /**
     * @var string|null
     */
    protected static ?string $navigationIcon = 'lucide-shopping-cart';

    /**
     * @var int|null
     */
    protected static ?int $navigationSort = 2;

    /**
     * @return array|PageRegistration[]
     */
    public static function getPages() : array
    {
        return [
            'index' => Pages\ListOrders::route('/'),
        ];
    }
}
