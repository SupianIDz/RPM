<?php

namespace App\Product\Filament\Resources\ProductResource\Widgets;

use App\Product\Models\Product;
use App\Support\Filament\Widgets\Concerns\HasFakeChart;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Database\Eloquent\Builder;
use LaravelIdea\Helper\App\Product\Models\_IH_Product_QB;
use Random\RandomException;

class ProductOverview extends BaseWidget
{
    use HasFakeChart;

    /**
     * @return Stat[]
     * @throws RandomException
     */
    protected function getStats() : array
    {
        return [
            fi_wi_stat(function (Stat $stat) {
                $stat->label('Total Products')->value(function () {
                    return $this->query()->count();
                });

                $this->applyDefaultStyling($stat, 'primary');
            }),

            fi_wi_stat(function (Stat $stat) {
                $stat->label('Active Products')->value(function () {
                    return $this->query()->active()->count();
                });

                $this->applyDefaultStyling($stat, 'success');
            }),

            fi_wi_stat(function (Stat $stat) {
                $stat->label('Inactive Products')->value(function () {
                    return $this->query()->active(false)->count();
                });

                $this->applyDefaultStyling($stat, 'danger');
            }),
        ];
    }

    /**
     * @param  Stat   $stat
     * @param  string $color
     * @return void
     * @throws RandomException
     */
    private function applyDefaultStyling(Stat $stat, string $color) : void
    {
        $this
            ->fakeChart($stat)
            ->color($color);
    }

    /**
     * @return Builder|_IH_Product_QB
     */
    private function query() : Builder|_IH_Product_QB
    {
        return Product::query();
    }
}
