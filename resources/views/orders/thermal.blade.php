<!DOCTYPE html>
<html lang="id">
    <head>
        <meta charset="UTF-8"/>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1"/>
        <title>{{ $order->invoice }}</title>
        <style>
            :root {
                /* Lebar kertas dan area cetak */
                --paper-width: 80mm;
                --content-width: 72mm; /* aman untuk printable width mayoritas printer 80mm */
            }

            @page {
                size: var(--paper-width) auto;
                margin: 0;
            }

            * {
                box-sizing: border-box;
            }

            body {
                margin: 0;
                color: #000;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
                font-family: ui-monospace, SFMono-Regular, Menlo, Consolas, "Liberation Mono", monospace;
                font-size: 11px; /* ukuran kecil khas thermal */
                line-height: 1.25;
            }

            .receipt {
                width: var(--content-width);
                margin: 0 auto;
                padding: 4mm 2mm;
            }

            .center {
                text-align: center;
            }

            .right {
                text-align: right;
            }

            .bold {
                font-weight: 700;
            }

            .muted {
                opacity: .9;
            }

            /* Header */
            .logo {
                display: block;
                margin: 0 auto 2mm;
                max-width: 48mm;
                max-height: 18mm;
                object-fit: contain;
            }

            .brand {
                font-size: 14px;
                font-weight: 800;
                text-transform: uppercase;
                text-align: center;
                margin: 1mm 0 0.5mm;
            }

            .address {
                text-align: center;
                white-space: pre-line; /* biar \n jadi baris baru jika perlu */
                margin-bottom: 2mm;
            }

            .divider {
                margin: 2mm 0;
                border: 0;
                border-top: 1px dashed #000;
                height: 0;
            }

            /* Meta info (tanggal, kasir, invoice) */
            .meta {
                margin-bottom: 2mm;
            }

            .meta .row {
                display: flex;
                justify-content: space-between;
                gap: 4mm;
            }

            /* Items */
            .items {
                width: 100%;
                border-collapse: collapse;
            }

            .item {
                page-break-inside: avoid;
                margin-bottom: 1mm;
            }

            .item .name {
                word-break: break-word;
            }

            .item .calc {
                display: flex;
                justify-content: space-between;
                gap: 2mm;
                margin-top: 0.5mm;
            }

            /* Totals */
            .totals {
                width: 100%;
                border-collapse: collapse;
            }

            .totals tr {
                page-break-inside: avoid;
            }

            .totals td {
                padding: 0.5mm 0;
            }

            .totals .label {
            }

            .totals .value {
                text-align: right;
            }

            .grand td {
                font-weight: 800;
                padding-top: 1mm;
                border-top: 1px solid #000;
            }

            /* Footer */
            .footer {
                margin-top: 3mm;
                text-align: center;
            }

            .thanks {
                font-weight: 700;
                margin-bottom: 1mm;
            }

            /* Optional: pratinjau layar */
            @media screen {
                body {
                    background: #f5f5f5;
                }

                .receipt {
                    background: #fff;
                    box-shadow: 0 0 0 1px #eee, 0 6px 24px rgba(0, 0, 0, .06);
                }
            }
        </style>
    </head>
    <body>
        <div class="receipt">

            <!-- 1. Logo (center) -->
            @if(!empty($logoUrl ?? null))
                <img class="logo" src="{{ $logoUrl }}" alt="Logo RPM Motor">
            @endif

            <!-- 2. Nama -> RPM Motor -->
            <div class="brand">RPM Motor</div>

            <!-- 3. Alamat -->
            <div class="address muted">
                Bengkel RPM — Jl. Trikora, Guntungmanggis, Kec. Landasan Ulin, Kalimantan Selatan
                <br>Telp: 0853-8725-0820
            </div>

            <hr class="divider">

            <!-- 4. Tanggal - Nama Kasir -->
            <div class="meta">
                <div class="row">
                    <div>Tanggal</div>
                    <div class="right">
                        {{ $order->date->locale('id')->isoFormat('DD/MM/YYYY HH:mm') }}
                    </div>
                </div>
                <div class="row">
                    <div>Kasir</div>
                    <div class="right">
                        {{ $order->cashier?->name ?? '-' }}
                    </div>
                </div>
            </div>

            <!-- 5. Nomor Invoice -->
            <div class="meta">
                <div class="row">
                    <div>No. Invoice</div>
                    <div class="right bold">{{ $order->invoice }}</div>
                </div>
            </div>

            <hr class="divider">

            <!-- 6. Daftar item -->
            <div class="items">
                @foreach($order->items as $item)
                    <div class="item">
                        <div class="name">{{ $item->full_name }}</div>
                        <div class="calc">
                            <div class="muted">{{ $item->quantity }} x {{ str($item->amount)->rupiah() }}</div>
                            <div class="right bold">{{ str($item->total)->rupiah() }}</div>
                        </div>
                    </div>
                @endforeach
            </div>

            <hr class="divider">

            <!-- 7. Total -->
            <table class="totals" role="presentation" aria-label="Ringkasan total">
                <tbody>
                    <tr>
                        <td class="label">Total</td>
                        <td class="value">{{ str($order->amount)->rupiah() }}</td>
                    </tr>
                    <tr>
                        <td class="label">Diskon</td>
                        <td class="value">{{ str($order->discount)->rupiah() }}</td>
                    </tr>
                    <tr class="grand">
                        <td class="label">Grand Total</td>
                        <td class="value">{{ str($order->total)->rupiah() }}</td>
                    </tr>
                </tbody>
            </table>

            <hr class="divider">

            <!-- 8. Ucapan terima kasih & kebijakan -->
            <div class="footer">
                <div class="thanks">Terima kasih 🙏</div>
                <div class="muted">Barang yang dibeli <span class="bold">tidak dapat dikembalikan</span>.</div>
            </div>

        </div>
    </body>
</html>
