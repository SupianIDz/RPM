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
            ->mutateRecordDataUsing(function (Order $record, array $data) {
                return array_merge($data, [
                    'plate' => $record->vehicle?->plate,
                ]);
            })
            ->after(function (Order $record, array $data) {
                new OrderService($record)->sync();
            });
    }
}
