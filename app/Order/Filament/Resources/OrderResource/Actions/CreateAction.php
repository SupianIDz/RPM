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
            });
    }
}
