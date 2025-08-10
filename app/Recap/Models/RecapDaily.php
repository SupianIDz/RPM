<?php

namespace App\Recap\Models;

use App\Recap\Observers\RecapDailyObserver;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

#[ObservedBy(RecapDailyObserver::class)]
class RecapDaily extends Model
{
    use HasUuids;

    /**
     * @var string[]
     */
    protected $fillable = [
        'period', 'total_order_c', 'total_value_c', 'total_order_t', 'total_value_t', 'total_order_m', 'total_value_m',
    ];

    /**
     * @return string[]
     */
    protected function casts() : array
    {
        return [
            'period' => 'date',
        ];
    }

    /**
     * @return Attribute
     */
    protected function totalOrder() : Attribute
    {
        return Attribute::make(function () {
            return $this->total_order_c + $this->total_order_t + $this->total_order_m;
        });
    }

    /**
     * @return Attribute
     */
    protected function totalValue() : Attribute
    {
        return Attribute::make(function () {
            return $this->total_value_c + $this->total_value_t + $this->total_value_m;
        });
    }

    /**
     * @param  Builder $query
     * @param  Carbon  $date
     * @return Builder
     */
    #[Scope]
    protected function period(Builder $query, Carbon $date) : Builder
    {
        return
            $query
                ->whereMonth('period', $date->month)
                ->whereYear('period', $date->year);
    }
}
