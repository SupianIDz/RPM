<?php

namespace App\Vehicle\Models;

use App\Vehicle\Observers\VehicleObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

#[ObservedBy([VehicleObserver::class])]
class Vehicle extends Model
{
    use HasUuids;

    protected $fillable = [
        'plate', 'brand', 'model',
    ];

    /**
     * @return Attribute
     */
    protected function name() : Attribute
    {
        return Attribute::make(function () {
            $arr = [];
            $arr[] = $this->brand;
            $arr[] = $this->model;

            $arr = array_filter($arr);

            return implode('  ', $arr);
        });
    }

    /**
     * @return Attribute
     */
    protected function plate() : Attribute
    {
        return
            Attribute::make(static function ($value) {
                return preg_replace('/(?<=[A-Za-z])(?=\d)|(?<=\d)(?=[A-Za-z])/', ' ', $value);
            });
    }
}
