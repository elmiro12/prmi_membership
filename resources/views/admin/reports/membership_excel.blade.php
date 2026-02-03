<div class="container mt-4">
    @isset($memberships)
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
                        <td>{{ $item->reg_date ? \Carbon\Carbon::parse($item->reg_date)->format('d-m-Y') : '-' }}</td>
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
