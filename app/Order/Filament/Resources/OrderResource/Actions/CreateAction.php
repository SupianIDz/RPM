<?php

namespace App\Order\Filament\Resources\OrderResource\Actions;

use App\Customer;
use App\Order\Models\Order;
use App\Order\Models\OrderItem;
use App\Product\Models\Product;
use App\Support\Filament\Actions\CreateAction as Action;
use App\Vehicle\Models\Vehicle;
use Filament\Support\Enums\MaxWidth;
use Illuminate\Support\Facades\DB;

class CreateAction extends Action
{
    /**
     * @return void
     */
    protected function setUp() : void
    {
        parent::setUp();

        $this
            ->modalWidth(MaxWidth::SixExtraLarge)
            ->form(new Forms\Form()->configure($this));

        $this
            ->mutateFormDataUsing(function (array $data) {
                if ($data['vehicle_id'] instanceof Vehicle) {
                    $data['vehicle_id'] = $data['vehicle_id']->id;
                }

                return array_merge($data, [
                    'status'     => 'PAID',
                    'created_by' => auth()->id(),
                ]);
            })
            ->action(function (array $data) {
                DB::transaction(function () use ($data) {
                    $customer = null;
                    if (filled($data['name'])) {
                        $customer = new Customer\Services\CreateService()->handle(Customer\Data\CustomerData::from($data));
                    }

                    if ($customer && filled($data['vehicle_id'])) {
                        $customer->vehicles()->updateOrCreate([
                            'vehicle_id' => $data['vehicle_id'],
                        ]);
                    }

                    /**
                     * @var Order $order
                     */
                    $order = Order::create(array_merge($data, [
                        'customer_id' => $customer?->id,
                    ]));

                    foreach ($data['products'] as $item) {
                        /**
                         * @var  Product $product
                         */
                        $product = Product::findOrFail($item['product_id']);

                        $order->items()->create([
                            'name'             => $product->name,
                            'product_id'       => $product->id,
                            'amount'           => $product->price->amount,
                            'product_price_id' => $product->price->id,
                            'quantity'         => $item['quantity'],
                            'type'             => \App\Order\Enums\Type::PRODUCT,
                        ]);
                    }

                    // Services
                    foreach ($data['services'] as $item) {
                        $order->items()->create(array_merge($item, [
                            'name' => $item['name'] ?? $item['type'],
                        ]));
                    }

                    $total = $order->items->sum(function (OrderItem $item) {
                        return $item->quantity * $item->amount;
                    });

                    $order->update([
                        'amount' => $total,
                    ]);
                });
            });
    }
}
