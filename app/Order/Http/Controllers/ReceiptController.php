<?php

namespace App\Order\Http\Controllers;

use App\Order\Models\Order;
use Barryvdh\DomPDF\Facade\Pdf;

class ReceiptController
{
    public function __invoke(Order $order)
    {
        $pdf = Pdf::loadView('orders.receipt', compact('order'))->setPaper('a4', 'landscape');

        return $pdf->stream();
    }
}
