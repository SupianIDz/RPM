<?php

namespace App\Vehicle\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    use HasUuids;

    protected $fillable = [
        'plate', 'brand', 'model',
    ];
}
