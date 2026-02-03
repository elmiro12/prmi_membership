@extends('layouts.base')

@section('title', 'Daftar Stream Membership')

@section('content')
<div class="container">
    <div class="table-responsive">
        <table class="table table-bordered datatable">
        <thead>
            <tr>
                <th>Nama Member</th>
                <th>Tipe Stream</th>
                <th>Expiry Date</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($members as $member)
                @php
                    $stream = $member->streamMemberships;
                @endphp
                <tr>
                    <td>{{ $member->fullname }}</td>
                    <td>{{ $stream ? $stream->streamType->name : '-' }}</td>
                    <td>
                        @if($stream && $stream->expiry_date)
                            @tanggalIndo($stream->expiry_date)
                        @else
                            -
                        @endif
                    </td>
                    <td>
                        @if($stream)
                            @if(is_null($stream->expiry_date) || \Carbon\Carbon::parse($stream->expiry_date)->isPast())
                                <span class="badge bg-danger">Expired</span>
                            @else
                                <span class="badge bg-success">Aktif</span>
                            @endif
                        @else
                            <span class="badge bg-secondary">Belum Berlangganan</span>
                        @endif
                    </td>
                    <td>
                        @if(!$stream || ($stream->expiry_date && \Carbon\Carbon::parse($stream->expiry_date)->isPast()))
                            <a href="{{ route('stream.perpanjang', $member->id) }}" class="btn btn-sm btn-primary">
                                Perpanjang
                            </a>
                        @else
                            @if(is_null($stream->expiry_date))
                                <span class="badge bg-warning">Menunggu Konfirmasi</span>
                            @else
                                <span class="badge bg-success">Aktif</span>
                            @endif
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    </div>
</div>
@endsection

@section('custom_js')
<script>
 @if (session('success'))
    Swal.fire({
        icon: 'success',
        title: 'Berhasil!',
        text: '{{ session("success") }}',
        showConfirmButton: false,
        timer: 2000
    });
@endif

@if ($errors->any())
    Swal.fire({
        icon: 'error',
        title: 'Terjadi kesalahan!',
        html: `{!! implode('<br>', $errors->all()) !!}`,
    });
@endif
</script>
@endsection
