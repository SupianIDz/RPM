<?php

namespace App\Order\Filament\Resources\OrderResource\Pages;

use App\Order\Filament\Resources\OrderResource;
use App\Order\Filament\Resources\OrderResource\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListOrders extends ListRecords
{
    protected static string $resource = OrderResource::class;

    /**
     * @return array
     */
    protected function getHeaderActions() : array
    {
        return [
            fi_action(function (CreateAction $action) {
                //
            }),
        ];
    }
}
