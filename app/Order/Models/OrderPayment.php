<?php

namespace App\Order\Models;

use App\Order\Enums\Payment;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
            'type'   => Payment::class,
        ];
    }

    /**
     * @return BelongsTo
     */
    public function order() : BelongsTo
    {
        return $this->belongsTo(Order::class, 'invoice', 'invoice');
    }
}
