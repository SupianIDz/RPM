<!DOCTYPE html>
<html lang="id">
    <head>
        <meta charset="UTF-8"/>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1"/>
        <title>{{ $order->invoice }}</title>
        <style>
            @page {
                size: A4 landscape;
                margin: 10mm 10mm;
            }

            body {
                font-family: Arial, sans-serif;
                max-width: 900px;
                margin: 0 auto;
                padding: 8px;
                color: #333;
                font-size: 13px;
            }

            /* Header pakai table tanpa border */
            .header-table {
                width: 100%;
                border-collapse: collapse;
                margin-bottom: 10px;
                border: none;
            }

            .header-table td {
                border: none;
                vertical-align: top;
                padding-right: 10px;
            }

            .header-left {
                width: 70%;
            }

            .company-name {
                font-size: 24px !important;
                font-weight: bold;
                margin-bottom: 4px;
            }

            .header-right {
                width: 30%;
                font-size: 26px;
                font-weight: bold;
                text-align: right;
                vertical-align: top;
                padding-right: 0;
            }

            .info {
                margin-bottom: 10px;
            }

            /* Tabel info */
            .info-table {
                width: 100%;
                margin-bottom: 10px;
                font-size: 13px;
                border-collapse: collapse;
            }

            .info-table td {
                padding: 4px 4px;
                border: none;
                vertical-align: top;
            }

            .info-label {
                font-weight: bold;
                min-width: 90px;
                width: 10%;
            }

            .info-separator {
                width: 5px;
                text-align: center;
                padding: 0;
            }

            /* Tabel utama */
            table {
                width: 100%;
                border-collapse: collapse;
                margin-bottom: 10px;
            }

            thead {
                background-color: #f2f2f2;
            }

            th, td {
                border: 1px solid #ddd;
                padding: 5px 6px;
                text-align: left;
                vertical-align: middle;
            }

            th {
                font-weight: bold;
            }

            .right {
                text-align: right;
            }

            /* Quantity cell nowrap */
            .nowrap {
                white-space: nowrap;
            }

            /* Center cell */
            .center {
                text-align: center;
            }

            /* Style untuk tabel totals */
            .totals {
                max-width: 200px;
                margin-left: auto;
                font-size: 13px;
            }

            .totals table {
                width: 100%;
                border-collapse: collapse;
                border: none;
            }

            .totals td {
                padding: 4px 6px;
                text-align: left;
                border: none;
            }

            .totals td.value {
                text-align: right;
            }

            .totals tr.grand-total td {
                font-weight: bold;
                padding-top: 6px;
            }
        </style>
    </head>
    <body>

        <table class="header-table">
            <tr>
                <td class="header-left">
                    <div class="company-name">Bengkel RPM</div>
                    <div>Jl. Trikora, Guntungmanggis, Kec. Landasan Ulin, Kalimantan Selatan</div>
                    <div>Telp: 0853-8725-0820</div>
                </td>
                <td class="header-right">Receipt</td>
            </tr>
        </table>

        <div class="info">
            <table class="info-table">
                <tbody>
                    <tr>
                        <td class="info-label">Invoice</td>
                        <td class="info-separator">:</td>
                        <td>{{ $order->invoice }}</td>
                    </tr>
                    @if($order->customer)
                        <tr>
                            <td class="info-label">Customer</td>
                            <td class="info-separator">:</td>
                            <td>{{ $order->customer->name }}</td>
                        </tr>
                    @endif

                    @if($order->vehicle)
                        <tr>
                            <td class="info-label">Vehicle</td>
                            <td class="info-separator">:</td>
                            <td>{{ $order->vehicle->name }}</td>
                        </tr>

                        <tr>
                            <td class="info-label">Plate Number</td>
                            <td class="info-separator">:</td>
                            <td>{{ $order->vehicle->plate }}</td>
                        </tr>
                    @endif

                    <tr>
                        <td class="info-label">Date</td>
                        <td class="info-separator">:</td>
                        <td>{{ $order->date->locale('id')->isoFormat('dddd, DD MMMM YYYY HH:mm') }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <table>
            <thead>
                <tr>
                    <th class="center" style="width:3%;">#</th>
                    <th style="width:50%;">Product</th>
                    <th style="width:19%;">Price</th>
                    <th class="nowrap center" style="width:8%;">Quantity</th>
                    <th style="width:20%;">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->items as $item)
                    <tr>
                        <td class="center">{{ $loop->index + 1 }}</td>
                        <td>{{ $item->full_name }}</td>
                        <td>{{ str($item->amount)->rupiah() }}</td>
                        <td class="nowrap center">{{ $item->quantity }}</td>
                        <td class="right">{{ str($item->total)->rupiah() }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="totals">
            <table role="presentation" aria-label="Summary of totals">
                <tbody>
                    <tr>
                        <td>Total:</td>
                        <td class="value">{{ str($order->amount)->rupiah() }}</td>
                    </tr>
                    <tr>
                        <td>Discount:</td>
                        <td class="value">{{ str($order->discount)->rupiah() }}</td>
                    </tr>
                    <tr class="grand-total">
                        <td>Grand Total:</td>
                        <td class="value">{{ str($order->total)->rupiah() }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

    </body>
</html>
