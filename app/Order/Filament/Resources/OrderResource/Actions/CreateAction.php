<?php

namespace App\Order\Filament\Resources\OrderResource\Actions;

use App\Customer;
use App\Order\Models\Order;
use App\Order\Services\OrderService;
use App\Support\Filament\Actions\CreateAction as Action;
use App\Vehicle\Models\Vehicle;
use Filament\Support\Enums\MaxWidth;

class CreateAction extends Action
{
    /**
     * @return void
     */
    protected function setUp() : void
    {
        parent::setUp();

        $this
            ->modalWidth(MaxWidth::SevenExtraLarge)
            ->form(new Forms\Form()->configure($this));

        $this
            ->mutateFormDataUsing(function (array $data) {
                $vehicleID = null;
                if (filled($data['plate'])) {
                    $vehicleID =
                        Vehicle::firstOrCreate([
                            'plate' => str($data['plate'])->replaceMatches('/[^a-zA-Z0-9]/', '')->upper(),
                        ])
                            ->getKey();
                }

                return array_merge($data, [
                    'status'     => 'PAID',
                    'vehicle_id' => $vehicleID,
                    'created_by' => auth()->id(),
                ]);
            })
            ->after(function (Order $record, array $data) {
                new OrderService($record)->sync();
            });
    }
}
