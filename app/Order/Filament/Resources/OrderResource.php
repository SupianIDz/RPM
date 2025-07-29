<?php

namespace App\Order\Filament\Resources;

use App\Order\Filament\Resources\OrderResource\Pages;
use App\Order\Models\Order;
use Filament\Resources\Resource;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $slug = 'orders';

    protected static ?string $navigationIcon = 'lucide-shopping-cart';

    public static function getPages() : array
    {
        return [
            'index'  => Pages\ListOrders::route('/'),
        ];
    }
}
