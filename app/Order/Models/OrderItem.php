<?php

namespace App\Order\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasUuids;

    /**
     * @var string[]
     */
    protected $fillable = [
        'invoice', 'name', 'quantity', 'product_id', 'product_price_id', 'type', 'amount'
    ];
}


