<?php

namespace App\Customer\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Customer extends Model
{
    use HasUuids;

    /**
     * @var string[]
     */
    protected $fillable = [
        'name', 'phone',
    ];

    /**
     * @return HasMany|Customer
     */
    public function vehicles() : HasMany|Customer
    {
        return $this->hasMany(CustomerVehicle::class);
    }
}
