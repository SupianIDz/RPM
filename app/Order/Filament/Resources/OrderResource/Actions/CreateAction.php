<?php

namespace App\Order\Filament\Resources\OrderResource\Actions;

use App\Customer;
use App\Order\Models\Order;
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

        /**
         * array:7 [▼ // app/Order/Filament/Resources/OrderResource/Actions/CreateAction.php:23
         *  "products" => array:1 [▼
         *  0 => array:3 [▶]
         * ]
         * "services" => array:2 [▼
         * 0 => array:3 [▼
         * "service_type" => "TURNING"
         * "price" => "200"
         * "quantity" => 1
         * ]
         * 1 => array:4 [▼
         * "service_type" => "OTHER"
         * "service_name" => "Foo"
         * "price" => "2000"
         * "quantity" => 1
         * ]
         * ]
         * "invoice" => "INV20250731-DMBC"
         * "payment" =>
         * App\Order\Enums
         * \
         * Payment
         * {#1604 ▶}
         * "name" => "Foo"
         * "phone" => null
         * "vehicle_id" =>
         * App\Vehicle\Models
         * \
         * Vehicle
         * {#1449 ▶}
         * ]
         */
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
                        $customer = new Customer\Services\CreateService()->handle($data['name'], $data['phone']);
                    }

                    if ($customer && filled($data['vehicle_id'])) {
                        $customer->vehicles()->updateOrCreate([
                            'vehicle_id' => $data['vehicle_id'],
                        ]);
                    }

                    Order::create(array_merge($data, [
                        'customer_id' => $customer?->id,
                    ]));
                });
            });
    }
}
