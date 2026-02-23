<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Nota {{ $sale->invoice_no }}</title>
    <style>
        /* Ubah width sesuai printer: 58mm atau 80mm */
        @page { size: 80mm auto; margin: 5mm; }
        body { font-family: Arial, sans-serif; font-size: 12px; color: #111; }
        .center { text-align: center; }
        .row { display: flex; justify-content: space-between; }
        .hr { border-top: 1px dashed #333; margin: 8px 0; }
        table { width: 100%; border-collapse: collapse; }
        td, th { padding: 4px 0; }
        .right { text-align: right; }
        .small { font-size: 11px; color: #444; }
    </style>
</head>
<body onload="window.print()">
    <div class="center">
        <div style="font-weight:700; font-size:14px;">
            {{ $setting->store_name ?? 'Toko Bangunan' }}
        </div>
        <div class="small">{{ $setting->address }}</div>
        <div class="small">{{ $setting->phone }}</div>
    </div>

    <div class="hr"></div>

    <div class="small">
        <div class="row"><span>Invoice</span><span>{{ $sale->invoice_no }}</span></div>
        <div class="row"><span>Tanggal</span><span>{{ $sale->date }}</span></div>
        <div class="row"><span>Kasir</span><span>{{ $sale->user->name }}</span></div>
        <div class="row"><span>Metode</span><span>{{ strtoupper($sale->payment_method) }}</span></div>
        <div class="row"><span>Status</span><span>{{ $sale->status }}</span></div>
    </div>

    <div class="hr"></div>

    <table>
        <thead>
            <tr>
                <th align="left">Item</th>
                <th class="right">Qty</th>
                <th class="right">Harga</th>
                <th class="right">Sub</th>
            </tr>
        </thead>
        <tbody>
            @foreach($sale->items as $it)
                <tr>
                    <td>{{ $it->product->name }}</td>
                    <td class="right">{{ $it->qty }}</td>
                    <td class="right">{{ number_format($it->price,0,',','.') }}</td>
                    <td class="right">{{ number_format($it->subtotal,0,',','.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="hr"></div>

    <div class="small">
        <div class="row"><span>Subtotal</span><span>{{ number_format($sale->subtotal,0,',','.') }}</span></div>
        <div class="row"><span>Diskon</span><span>{{ number_format($sale->discount_total,0,',','.') }}</span></div>
        <div class="row"><span>Pajak</span><span>{{ number_format($sale->tax_amount,0,',','.') }}</span></div>
        <div class="row"><span><b>Total</b></span><span><b>{{ number_format($sale->grand_total,0,',','.') }}</b></span></div>
        <div class="row"><span>Dibayar</span><span>{{ number_format($sale->paid_amount,0,',','.') }}</span></div>
        <div class="row"><span>Kembalian</span><span>{{ number_format($sale->change_amount,0,',','.') }}</span></div>
    </div>

    <div class="hr"></div>
    <div class="center small">Terima kasih 🙏</div>
</body>
</html>
