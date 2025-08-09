<?php

namespace App\Order\Filament\Resources\OrderResource\Widgets;

use App\Order\Models\Order;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class OrderStatsOverview extends BaseWidget
{
    /**
     * @return array|Stat[]
     */
    protected function getStats() : array
    {
        return [
            fi_wi_stat(static function (Stat $stat) {
                $stat
                    ->label('Orders This Month')
                    ->description('Number of orders placed this month')
                    ->icon('heroicon-o-shopping-bag')
                    ->value(function () {
                        return Order::monthly(now())->count();
                    });
            }),

            fi_wi_stat(static function (Stat $stat) {
                $stat
                    ->label('Revenue This Month')
                    ->description('Total order amount this month')
                    ->icon('heroicon-o-banknotes')
                    ->value(function () {
                        return number(Order::monthly(now())->sum('amount'))->abbr();
                    });
            }),

            fi_wi_stat(static function (Stat $stat) {
                $stat
                    ->label('Total Orders')
                    ->description('Number of orders since the beginning')
                    ->icon('heroicon-o-shopping-bag')
                    ->value(function () {
                        return Order::count();
                    });
            }),

            fi_wi_stat(static function (Stat $stat) {
                $stat
                    ->label('Total Revenue')
                    ->description('Total order amount since the beginning')
                    ->icon('heroicon-o-banknotes')
                    ->value(function () {
                        return number(Order::sum('amount'))->abbr();
                    });
            }),
        ];
    }
}
