@extends('layouts.base') {{-- atau layout yang kamu gunakan --}}

@section('title', 'Daftar Perpanjangan Membership')

@section('content')
<table class="table table-bordered datatable" style="width:100%">
    <thead>
        <tr>
            <th>Nama Member</th>
            <th>Tipe Membership</th>
            <th>Tanggak Registrasi</th>
            <th>Status Member</th>
            <th>Status Expire</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($extensions as $ext)
            @if($ext->membership)
                @php
                    $membership = $ext->membership;
                    $member = $membership->member ?? null;
                    $tipe = $membership->membershipType ?? null;
                    $isExpired = \Carbon\Carbon::parse($membership->expiry_date)->isPast();
                @endphp
                <tr>
                    <td>{{ $member->fullname ?? '-' }}</td>
                    <td>{{ $tipe->type ?? '-' }}</td>
                    <td>
                        @if($membership->reg_date)
                            @tanggalIndo($membership->reg_date)
                        @else
                            -
                        @endif
                    </td>
                    @php
                        $badge = 'secondary';
                        $status = 'Member Lama';
                        if($membership->exsist == 'baru'){
                            $badge = 'success';
                            $status = 'Member Baru';
                        }
                    @endphp
                    <td><span class="badge bg-{{$badge}}">{{ $status }}</span></td>
                    <td>
                        @if ($isExpired)
                            <span class="badge bg-danger">Expired</span>
                        @else
                            <span class="badge bg-success">Aktif</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('extensions.renew', $ext->id) }}" class="btn btn-sm btn-warning">
                            <i class="bi bi-arrow-repeat"></i> Perpanjang
                        </a>
                    </td>
                </tr>
            @elseif(empty($extensions))
                    <tr>
                        <td colspan="6" class="text-center">Tidak ada data perpanjangan.</td>
                    </tr>
            @endif
        @endforeach
    </tbody>
</table>
@endsection

