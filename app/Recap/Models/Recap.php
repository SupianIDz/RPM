<?php

namespace App\Recap\Models;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use LaravelIdea\Helper\App\Recap\Models\_IH_Recap_QB;

class Recap extends Model
{
    use HasUuids;

    /**
     * @var string[]
     */
    protected $fillable = [
        'period', 'total_order_c', 'total_value_c', 'total_order_t', 'total_value_t', 'total_order_m', 'total_value_m',
    ];

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
     * @return Builder|_IH_Recap_QB
     */
    #[Scope]
    protected function period(Builder $query, Carbon $date) : Builder|_IH_Recap_QB
    {
        return
            $query
                ->whereMonth('period', $date->month)
                ->whereYear('period', $date->year);
    }
}
