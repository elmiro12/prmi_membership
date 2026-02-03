@extends('layouts.base')

@section('title', 'Daftar Stream Membership')

@section('content')
<div class="card shadow-sm">
    <div class="card-header bg-primary d-flex justify-content-between align-items-center">
        <h5 class="mb-0 text-white">Data Membership Anda</h5>
    </div>
    <div class="card-body">
        @if($member->streamMemberships)
            <table class="table table-borderless mb-0">
                <tr>
                    <th width="30%">Nomor Membership</th>
                    <td>{{ $member->streamMemberships->kode }}</td>
                </tr>
                <tr>
                    <th>Tipe Membership</th>
                    <td><strong>{{ $member->streamMemberships->streamType->name }}</strong></td>
                </tr>
                <tr>
                    <th>Tanggal Registrasi</th>
                    <td>@tanggalIndo($member->streamMemberships->created_at)</td>
                </tr>
                <tr>
                    <th>Tanggal Perpanjangan Terakhir</th>
                    @php
                        $extension = $member->streamMemberships->extension;
                    @endphp
                    <td>
                        @if($extension && $extension->updated_at)
                            @tanggalIndo($extension->updated_at)
                        @else
                            -
                        @endif
                    </td>
                </tr>
                @php
                    $expiry_date = $member->streamMemberships->expiry_date
                @endphp
                <tr>
                    <th>Tanggal Expired</th>
                    <td>
                    @if($expiry_date)
                        <strong>@tanggalIndo($expiry_date)</strong>
                    @else
                        -
                    @endif
                    </td>
                </tr>
                <tr>
                    <th>Status</th>
                    <td>
                        @if(( $expiry_date && \Carbon\Carbon::parse($expiry_date)->isPast()) ||
                            is_null($expiry_date))
                            <span class="badge bg-danger">Expired</span>
                        @else
                            <span class="badge bg-success">Active</span>
                        @endif
                    </td>
                </tr>
            </table>
            <div class="mt-4">
            @if(\Carbon\Carbon::parse($expiry_date)->isPast())
                <a href="{{ route('member.stream.subscribe') }}" class="btn btn-primary">
                        <i class="bi bi-arrow-repeat"></i> Perpanjang Membership
                </a>
            @endif
            </div>
        @else
           <div class="alert alert-warning">
                Belum ada Membership Stream.<br>
                <a href="{{ route('member.stream.subscribe') }}" class="btn btn-primary mt-2">
                    Daftar Membership Stream
                </a>
            </div>
        @endif
    </div>
</div>
@endsection
