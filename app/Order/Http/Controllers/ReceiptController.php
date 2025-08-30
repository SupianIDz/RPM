<?php

namespace App\Order\Http\Controllers;

use App\Order\Models\Order;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Response;

class ReceiptController
{
    /**
     * @param  Order $order
     * @return Response
     */
    public function __invoke(Order $order)
    {
        $pdf = Pdf::loadView('orders.receipt', compact('order'))->setPaper('a4', 'landscape');

        return $pdf->stream();
    }

    /**
     * @param  Order $order
     * @return View
     */
    public function thermal(Order $order)
    {
        return view('orders.thermal', compact('order'));
    }
}
