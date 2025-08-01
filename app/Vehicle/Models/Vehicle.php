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
    protected function plate() : Attribute
    {
        return
            Attribute::make(static function ($value) {
                if (preg_match('/^([A-Z]{1,2})(\d{1,4})([A-Z]{0,3})$/', $value, $m)) {
                    return $m[1] . ' ' . $m[2] . ' ' . $m[3];
                }

                return $value;
            });
    }
}
