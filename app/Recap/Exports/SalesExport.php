<?php

namespace App\Recap\Exports;

use App\Order\Models\OrderItem;
use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class SalesExport implements FromQuery, WithMapping, WithHeadings, ShouldAutoSize
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
            'INVOICE', 'NAME', 'QTY', 'SPARE PART', 'SERVICE', 'BUBUT', 'BENSOL', 'DATE',
        ];
    }

    /**
     * @param  OrderItem $row
     * @return array
     */
    public function map($row) : array
    {
        return [
            $row->order->invoice,
            $row->name,
            $row->quantity,
            $row->product_total,
            $row->service_total,
            $row->turning_total,
            $row->benzene_total,
            $row->order->date,
        ];
    }

    /**
     * @return Builder
     */
    public function query() : Builder
    {
        return
            OrderItem::query()->whereHas('order', function ($query) {
                $query->whereBetween('date', [$this->str, $this->end]);
            });
    }
}
