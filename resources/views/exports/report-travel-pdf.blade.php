<!DOCTYPE html>
<html>
<head>
    <title>Laporan Travel</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #000; padding: 5px; text-align: left; }
        th { background-color: #eee; }
    </style>
</head>
<body>
    <h3>Laporan Transaksi Travel</h3>
    <p>Periode: {{ $travelStartDate }} s/d {{ $travelEndDate }}</p>

    <table>
        <thead>
            <tr>
                <th>WAKTU TRANSAKSI</th>
                <th>MEMBER</th>
                <th>HARGA</th>
                <th>METODE PEMBAYARAN</th>
                <th>STATUS PEMBAYARAN</th>
                <th>TANGGAL BERANGKAT</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $item)
            <tr>
                <td>{{ $item->created_at }}</td>
                <td>{{ $item->member->name ?? '-' }}</td>
                <td>{{ number_format($item->price) }}</td>
                <td>{{ $item->paymentMethod }}</td>
                <td>{{ $item->paymentStatus }}</td>
                <td>{{ $item->tgl_berangkat }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
