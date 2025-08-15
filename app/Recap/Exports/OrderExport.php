<?php

namespace App\Recap\Exports;

use App\Order\Models\Order;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class OrderExport implements FromQuery, WithMapping, WithHeadings, ShouldAutoSize
{
    use Exportable;

    /**
     * @param  string $str
     * @param  string $end
     */
    public function __construct(protected string $str, protected string $end)
    {
        //
    }

    /**
     * @return string[]
     */
    public function headings() : array
    {
        return [
            'INVOICE', 'CUSTOMER', 'PLATE', 'TOTAL', 'PAYMENT', 'CASHIER', 'DATE',
        ];
    }

    /**
     * @param  Order $row
     * @return array
     */
    public function map($row) : array
    {
        return [
            $row->invoice,
            $row->customer?->name,
            $row->vehicle?->plate,
            $row->total,
            $row->payment->value,
            $row->creator->name,
            $row->date,
        ];
    }

    /**
     * @return Builder
     */
    public function query() : Builder
    {
        return
            Order::query()->whereBetween('date', [$this->str, $this->end]);
    }
}
