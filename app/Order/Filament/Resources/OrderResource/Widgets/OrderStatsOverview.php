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
                    ->label('Transaksi Bulan Ini')
                    ->description('Dihitung dari semua transaksi bulan ini')
                    ->icon('heroicon-o-shopping-bag')
                    ->value(function () {
                        return Order::monthly(now())->count();
                    });
            }),

            fi_wi_stat(static function (Stat $stat) {
                $stat
                    ->label('Pendapatan Kotor Bulan Ini')
                    ->description('Dihitung dari semua transaksi bulan ini')
                    ->icon('heroicon-o-banknotes')
                    ->value(function () {
                        return number(Order::monthly(now())->sum('amount'))->abbr();
                    });
            }),

            fi_wi_stat(static function (Stat $stat) {
                $stat
                    ->label('Total Transaksi')
                    ->description('Dihitung dari semua transaksi')
                    ->icon('heroicon-o-shopping-bag')
                    ->value(function () {
                        return Order::count();
                    });
            }),

            fi_wi_stat(static function (Stat $stat) {
                $stat
                    ->label('Total Pendapatan Kotor')
                    ->description('Dihitung dari semua transaksi')
                    ->icon('heroicon-o-banknotes')
                    ->value(function () {
                        return number(Order::sum('amount'))->abbr();
                    });
            }),
        ];
    }
}
