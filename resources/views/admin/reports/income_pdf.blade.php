@php
    use Carbon\Carbon;
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Laporan Pendapatan Membership</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        h4, h5 { margin: 0; padding: 0; }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        th, td {
            border: 1px solid #444;
            padding: 6px;
            text-align: left;
        }
        thead {
            background-color: #f2f2f2;
        }
        .total {
            font-weight: bold;
            background-color: #eee;
        }
    </style>
</head>
<body>

    <h4 style="text-align: center;">Laporan Pendapatan Membership dan Stream</h4>
    <p style="text-align: center;">Dari tanggal @tanggalIndo($from) sampai dengan @tanggalIndo($to)</p>
    <h5 style="text-align: left;">Laporan Pendapatan Membership</h5>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Tipe Membership</th>
                <th>Jumlah Member</th>
                <th>Total Pendapatan</th>
            </tr>
        </thead>
        <tbody>
            @foreach($reportDataMembership as $i => $item)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $item['name'] }}</td>
                    <td>{{ $item['count'] }}</td>
                    <td>Rp {{ number_format($item['total'], 0, ',', '.') }}</td>
                </tr>
            @endforeach
            <tr class="total">
                <td colspan="3" style="text-align: right;">Total Membership</td>
                <td>Rp {{ number_format($totalMembership, 0, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>
    <br>
    <h5 style="text-align: left;">Laporan Pendapatan Stream</h5>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Tipe Stream</th>
                <th>Jumlah Member</th>
                <th>Total Pendapatan</th>
            </tr>
        </thead>
        <tbody>
            @foreach($reportDataMembership as $i => $item)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $item['name'] }}</td>
                    <td>{{ $item['count'] }}</td>
                    <td>Rp {{ number_format($item['total'], 0, ',', '.') }}</td>
                </tr>
            @endforeach
            <tr class="total">
                <td colspan="3" style="text-align: right;">Total Stream</td>
                <td>Rp {{ number_format($totalStream, 0, ',', '.') }}</td>
            </tr>
            <tr class="total">
                <td colspan="3" style="text-align: right;">Grand Total (Membership + Stream)</td>
                <td>Rp {{ number_format($grandTotal, 0, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>

</body>
</html>
