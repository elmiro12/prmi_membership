@extends('layouts.base')

@section('title', 'Perpanjangan Membership')

@section('content')
<div class="card shadow-sm">
    <div class="card-header bg-primary d-flex justify-content-between align-items-center">
        <h5 class="mb-0 text-white">Data Membership Anda</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
        <table class="table table-bordered mb-0">
            <tr>
                <th>Nomor Membership</th>
                <td class="text-break">{{ $membership->membership_number }}</td>
            </tr>
            <tr>
                <th>Tipe Membership</th>
                <td>{{ $type->type }}</td>
            </tr>
            <tr>
                <th>Merchandise</th>
                <td style="font-size:1.2em">
                    <div class="row">
                    @if($merchand->isEmpty())
                        <span class="badge bg-danger">Belum ada merchandise.</span>
                    @else
                        @foreach($merchand as $merchan)
                        <div class="col-md-4">
                        <span class="badge bg-success">{{ $merchan->name }}</span>
                        </div>
                        @endforeach
                    @endif
                    </div>
                </td>
            </tr>
            <tr>
                <th>Tanggal Registrasi</th>
                <td>@tanggalIndo($membership->reg_date)</td>
            </tr>
            <tr>
                <th>Tanggal Perpanjangan Terakhir</th>
                <td>
                    @if($extension && $extension->updated_at)
                        @tanggalIndo($extension->updated_at)
                    @else
                        -
                    @endif
                </td>
            </tr>
            <tr>
                <th>Tanggal Expired</th>
                <td>@tanggalIndo($membership->expiry_date)</td>
            </tr>
            <tr>
                <th>Status</th>
                <td>
                    @if($status == 'Expired')
                        <span class="badge bg-danger">Expired</span>
                    @else
                        <span class="badge bg-success">Active</span>
                    @endif
                </td>
            </tr>
        </table>
        </div>
            <div class="mt-4">
                <a href="{{ route('member.extension.form') }}" class="btn btn-primary">
                    <i class="bi bi-arrow-repeat"></i> Perpanjang Membership
                </a>
            </div>
    </div>
</div>
@endsection
@section('custom_js')
<script>
@if(session('success'))
    Swal.fire({
        icon: 'success',
        title: 'Berhasil!',
        text: '{{ session("success") }}',
        showConfirmButton: false,
        timer: 2000
    });
@endif
@if (session('error'))
    Swal.fire({
        icon: 'error',
        title: 'Maaf!',
        text: '{{ session("error") }}',
        showConfirmButton: true,
    });
@endif
</script>
@endsection
