@php
   use Illuminate\Support\Str;
@endphp

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Daftar Member Terdaftar</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #444; padding: 6px; text-align: left; }
    </style>
</head>
<body>
    <h3>Daftar Member</h3>
    <table>
        <thead>
            <tr>
                <th>Nama</th>
                <th>Kode Member</th>
                <th>Tipe Membership</th>
                <th>Status Member PRMI </th>
                <th>Tanggal Registrasi</th>
                <th>Tanggal Expired</th>
            </tr>
        </thead>
        <tbody>
            @foreach($members as $member)
                <tr>
                    <td>{{ $member->fullname }}</td>
                    <td>{{ $member->membership->membership_number ?? '-' }}</td>
                    <td>{{ $member->membership->membershipType->type ?? '-' }}</td>
                    <td>
                        @if(Str::startsWith($member->membership->membership_number, 'MA'))
                            Non-PRMI
                        @else
                            Member PRMI
                        @endif
                    </td>
                    <td>
                        @if($member->membership->reg_date)
                            @tanggalIndo($member->membership->reg_date)
                        @else
                            -
                        @endif
                    </td>
                    <td>
                        @if($member->membership->expiry_date)
                            @tanggalIndo($member->membership->expiry_date)
                        @else
                            -
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
