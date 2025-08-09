<?php

namespace App\Order\Models;

use App\Customer\Models\Customer;
use App\Order\Enums\Payment;
use App\Order\Observers\OrderObserver;
use App\Product\Enums\Type;
use App\User\Models\User;
use App\Vehicle\Models\Vehicle;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;
use LaravelIdea\Helper\App\Order\Models\_IH_OrderItem_QB;

#[ObservedBy([OrderObserver::class])]
class Order extends Model
{
    use HasUuids;

    /**
     * @var string[]
     */
    protected $fillable = [
        'invoice', 'type', 'amount', 'status', 'payment', 'date', 'discount',
        'customer_id', 'vehicle_id', 'created_by', 'deleted_at',
    ];

    /**
     * @var string[]
     */
    protected $appends = [
        'total',
    ];

    /**
     * @return string[]
     */
    protected function casts() : array
    {
        return [
            'date'    => 'date',
            'payment' => Payment::class,
        ];
    }

    /**
     * @return string
     */
    public function getRouteKeyName() : string
    {
        return 'invoice';
    }

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
     * @param  Builder    $query
     * @param  Carbon|int $month
     * @return Builder
     */
    #[Scope]
    protected function monthly(Builder $query, Carbon|int $month) : Builder
    {
        return $query->whereMonth('date', $month instanceof Carbon ? $month->month : $month);
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

    /**
     * @return HasMany|Order
     */
    public function items() : Order|HasMany
    {
        return $this->hasMany(OrderItem::class, 'invoice', 'invoice');
    }

    /**
     * @return HasMany|_IH_OrderItem_QB|Order
     */
    public function services() : HasMany|_IH_OrderItem_QB|Order
    {
        return $this->items()->whereNot('type', Type::PRODUCT);
    }

    /**
     * @return HasMany|_IH_OrderItem_QB|Order
     */
    public function products() : HasMany|_IH_OrderItem_QB|Order
    {
        return $this->items()->where('type', Type::PRODUCT);
    }
}
