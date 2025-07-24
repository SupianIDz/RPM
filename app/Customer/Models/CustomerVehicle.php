<?php

namespace App\Customer\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class CustomerVehicle extends Model
{
    use HasUuids;

    protected $fillable = [
        'customer_id', 'vehicle_id',
    ];
}
