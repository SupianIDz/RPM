<?php

namespace App\Recap\Http\Controllers;

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
        $date = $request->get('date');
        [$str, $end] = array_pad(explode(' - ', $date), 2, null);

        $end ??= $str; // if end is null, set it to str

        $str = Carbon::createFromFormat('d/m/Y', trim($str))?->format('Y-m-d');
        $end = Carbon::createFromFormat('d/m/Y', trim($end))?->format('Y-m-d');

        return new SalesExport($str, $end)->download(str($date)->replace('/', '-') . '.xlsx');
    }
}
