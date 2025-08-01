<?php

namespace App\Order\Filament\Resources\OrderResource\Actions;

use App\Customer;
use App\Order\Models\Order;
use App\Order\Services\OrderService;
use Filament\Support\Enums\MaxWidth;

class ModifyAction extends \App\Support\Filament\Tables\Actions\ModifyAction
{
    /**
     * @return void
     */
    protected function setUp() : void
    {
        parent::setUp();

        $this
            ->modalWidth(MaxWidth::SixExtraLarge)
            ->form(new Forms\Form()->configure($this))
            ->after(function (Order $record, array $data) {
                $customer = null;
                if (filled($data['name'])) {
                    $customer = new Customer\Services\CreateService()->handle(Customer\Data\CustomerData::from($data));
                }

                new OrderService($record)->customer($customer)->recalculate();
            });
    }
}
