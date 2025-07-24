<?php

namespace App\Customer\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasUuids;

    /**
     * @var string[]
     */
    protected $fillable = [
        'name', 'phone',
    ];
}
