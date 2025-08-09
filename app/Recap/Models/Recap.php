<?php

namespace App\Recap\Models;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Attributes\Scope;
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
        'period', 'type', 'total_order', 'total_value',
    ];

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
