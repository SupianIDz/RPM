<?php

namespace App\Order\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasUuids;

    protected $fillable = [
        'invoice', 'type', 'total', 'status', 'payment',
        'customer_id', 'vehicle_id', 'created_by', 'deleted_at',
    ];
}
