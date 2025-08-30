<?php

namespace App\Order\Filament\Resources\OrderResource\Actions;

use App\Order\Models\Order;
use Filament\Support\Enums\IconSize;
use Filament\Tables\Actions\Action;

class ReceiptAction extends Action
{
    /**
     * @return void
     */
    protected function setUp() : void
    {
        parent::setUp();

        $this
            ->hiddenLabel()
            ->tooltip('RECEIPT')
            ->icon('lucide-printer')
            ->iconSize(IconSize::Medium);

        $this
            ->link()
            ->url(function (Order $record) {
                return route('orders.thermal', $record->invoice);
            })
            ->openUrlInNewTab();
    }
}
