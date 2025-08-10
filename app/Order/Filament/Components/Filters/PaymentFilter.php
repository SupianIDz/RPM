<?php

namespace App\Order\Filament\Components\Filters;

use App\Order\Enums\Payment;
use Filament\Tables\Filters\SelectFilter;

class PaymentFilter extends SelectFilter
{
    protected function setUp() : void
    {
        parent::setUp();

        $this
            ->name('payment')
            ->label('Payment')
            ->searchable()
            ->options(Payment::class);
    }
}
