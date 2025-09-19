<?php

namespace App\Order\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class OrderPayment extends Model
{
    use HasUuids;

    /**
     * @var string[]
     */
    protected $fillable = [
        'invoice', 'type', 'amount',
    ];

    protected function casts() : array
    {
        return [
            'amount' => 'float',
        ];
    }
}
