<?php

namespace App\Vehicle\Models;

use App\Vehicle\Observers\VehicleObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

#[ObservedBy([VehicleObserver::class])]
class Vehicle extends Model
{
    use HasUuids;

    protected $fillable = [
        'plate', 'brand', 'model',
    ];
}
