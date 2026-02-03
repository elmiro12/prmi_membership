@extends('layouts.base')

@section('title', 'Daftar Pembayaran')

@section('custom_css')
@endsection

@section('content')
<table class="table table-bordered datatable nowrap" style="width:100%">
    <thead class="table-light">
        <tr>
            <th>Kode</th>
            <th>Nama Member</th>
            <th>Tipe</th>
            <th>Jumlah</th>
            <th>Bank</th>
            <th>Status</th>
            <th>Bukti</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($payments as $pay)
            <tr>
                <td>{{ $pay->kode }}</td>
                @if ($pay->extension->membership)
                    <td>{{ $pay->extension->membership->member->fullname }}</td>
                    <td>{{ $pay->extension->membership->membershipType->type }}</td>
                    <td>Rp.
                        {{ number_format($pay->extension->membership->membershipType->amount, 0)}}</td>
                @elseif ($pay->extension->streamMembership)
                        <td>{{ $pay->extension->streamMembership->member->fullname }}</td>
                        <td>{{ $pay->extension->streamMembership->streamType->name }}</td>
                        <td>Rp.
                        {{ number_format($pay->extension->streamMembership->streamType->amount,0) }}</td>
                @else
                        <td><em>Tidak diketahui</em></td>
                        <td><em>Tidak diketahui</em></td>
                        <td><em>Tidak diketahui</em></td>
                @endif
                <td>{{ $pay->bank->namaBank ?? '-' }}</td>
                <td>
                    @if (is_null($pay->status))
                        <span class="badge bg-warning">Belum Diverifikasi</span>
                    @elseif ($pay->status)
                        <span class="badge bg-success">Terverifikasi</span>
                    @else
                        <span class="badge bg-danger">Tidak Diterima</span>
                    @endif
                </td>
                <td>
                    @if ($pay->bukti)
                        <a href="{{ asset('uploads/bukti/'.$pay->bukti) }}" target="_blank" class="btn btn-sm btn-info">Lihat</a>
                    @else
                        <span class="text-muted">Tidak Ada Bukti</span>
                    @endif
                </td>
                <td>
                    <div class="d-flex justify-content-center">
                    <!-- tombol verifikasi dan tolak akan kita tambahkan nanti -->
                    <a href="{{ route('payments.show', $pay->id) }}" class="btn btn-info btn-sm me-2">
                        <i class="bi bi-eye"></i>
                    </a>
                    <form method="POST" action="{{ route('payments.destroy', $pay->id) }}" class="form-delete">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">
                                <i class="bi bi-trash"></i>
                            </button>
                    </form>
                    </div>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
@endsection

@section('custom_js')
<script>
    $(document).ready(function () {

        
@if(session('success'))
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
    });
</script>
@endsection
