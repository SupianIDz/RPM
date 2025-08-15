<?php

namespace App\Recap\Http\Controllers;

use App\Recap\Exports\OrderExport;
use App\Recap\Exports\SalesExport;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class RecapController
{
    /**
     * @param  Request $request
     * @return Response|BinaryFileResponse
     */
    public function sales(Request $request)
    {
        $name = str($request->get('date'))->replace('/', '-')->prepend('sales-');

        [$str, $end] = $this->date($request);

        return new SalesExport($str, $end)->download($name . '.xlsx');
    }

    /**
     * @param  Request $request
     * @return Response|BinaryFileResponse
     */
    public function order(Request $request)
    {
        $name = str($request->get('date'))->replace('/', '-')->prepend('order-');

        [$str, $end] = $this->date($request);

        return new OrderExport($str, $end)->download($name . '.xlsx');
    }

    /**
     * @param  Request $request
     * @return null[]
     */
    private function date(Request $request) : array
    {
        $date = $request->get('date');
        [$str, $end] = array_pad(explode(' - ', $date), 2, null);

        $end ??= $str; // if end is null, set it to str

        $str = Carbon::createFromFormat('d/m/Y', trim($str))?->format('Y-m-d');
        $end = Carbon::createFromFormat('d/m/Y', trim($end))?->format('Y-m-d');

        return [$str, $end];
    }
}
