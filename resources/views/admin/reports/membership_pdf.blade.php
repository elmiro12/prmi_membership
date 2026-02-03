<!DOCTYPE html>
<html>
<head>
    <title>Laporan Membership</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 6px; text-align: left; }
        .header { text-align: center; margin-top: 20px; }
    </style>
</head>
<body>
<div class="container mt-4">
    @isset($memberships)
    <div class="header">
        <h2>Laporan Membership</h2>
        <p>Dari tanggal @tanggalIndo($from) sampai dengan @tanggalIndo($to)</p>
    </div>
    <div class="table-responsive mt-4">
        <table class="table table-bordered table-striped">
            <thead class="table-primary">
                <tr>
                    <th>Nama Member</th>
                    <th>Kode Member</th>
                    <th>Tipe Membership</th>
                    <th>Tanggal Registrasi</th>
                    <th>Status Member</th>
                    <th>Status Expire</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($memberships as $item)
                    <tr>
                        <td>{{ $item->member->fullname }}</td>
                        <td>{{ $item->membership_number }}</td>
                        <td>{{ $item->membershipType->type }}</td>
                        <td>
                            @if($item->reg_date)
                                @tanggalIndo($item->reg_date)
                            @else
                                -
                            @endif
                        </td>
                        <td>{{ ucfirst($item->exsist) }}</td>
                        <td>
                            @if ($item->expiry_date < \Carbon\Carbon::now())
                                <span class="badge bg-danger">Expired</span>
                            @else
                                <span class="badge bg-success">Aktif</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endisset
</div>
</body>
</html>
