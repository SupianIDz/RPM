<?php

namespace App\Order\Models;

use App\Customer\Models\Customer;
use App\User\Models\User;
use App\Vehicle\Models\Vehicle;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Order extends Model
{
    use HasUuids;

    protected $fillable = [
        'invoice', 'type', 'total', 'status', 'payment', 'date',
        'customer_id', 'vehicle_id', 'created_by', 'deleted_at',
    ];

    /**
     * @return Attribute
     */
    protected function total() : Attribute
    {
        return Attribute::get(function () {
            return $this->amount - $this->discount;
        });
    }

    /**
     * @return BelongsTo
     */
    public function creator() : BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    /**
     * @return BelongsTo
     */
    public function vehicle() : BelongsTo
    {
        return $this->belongsTo(Vehicle::class);
    }

    /**
     * @return BelongsTo
     */
    public function customer() : BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }
}
