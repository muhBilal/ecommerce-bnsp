<!DOCTYPE html>
<html>

<head>
    <title>Invoice</title>
    <style>
        body {
            font-family: sans-serif;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #eee;
        }
    </style>
</head>

<body>
    <h2>Invoice Pembelian</h2>
    <p><strong>Toko:</strong> {{ $store_name }}</p>
    <p><strong>Nama Pembeli:</strong> {{ $buyer_name }}</p>
    <p><strong>Alamat:</strong> {{ $address }}</p>
    <p><strong>No. HP:</strong> {{ $phone }}</p>
    <p><strong>Tanggal:</strong> {{ $date }}</p>
    <p><strong>Metode Pembayaran:</strong> {{ $payment_method }}</p>

    <h4>Daftar Belanja:</h4>
    <table>
        <thead>
            <tr>
                <th>Nama Produk</th>
                <th>Qty</th>
                <th>Harga Satuan</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @php $grandTotal = 0; @endphp
            @foreach ($items as $item)
                @php $subtotal = $item->price * $item->quantity; @endphp
                <tr>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                    <td>Rp {{ number_format($subtotal, 0, ',', '.') }}</td>
                </tr>
                @php $grandTotal += $subtotal; @endphp
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th colspan="3" style="text-align: right;">Total</th>
                <th>Rp {{ number_format($grandTotal, 0, ',', '.') }}</th>
            </tr>
        </tfoot>
    </table>
</body>

</html>
