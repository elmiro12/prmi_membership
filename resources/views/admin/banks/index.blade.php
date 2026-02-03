@extends('layouts.base')

@section('title', 'Manajemen Bank')

@section('card-action')
<a href="{{ route('banks.create') }}" class="btn btn-light text-primary btn-sm">
    <i class="bi bi-plus-lg"></i>Tambah Bank</a>
@endsection

@section('content')
    <table class="table table-bordered datatable">
        <thead>
            <tr>
                <th>Nama Bank</th>
                <th>No. Rekening</th>
                <th>Nama Pemilik</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($banks as $bank)
            <tr>
                <td>{{ $bank->namaBank }}</td>
                <td>{{ $bank->noRekening }}</td>
                <td>{{ $bank->namaPemilik }}</td>
                <td>
                    <span class="badge {{ $bank->statusAktif ? 'bg-success' : 'bg-secondary' }}">
                        {{ $bank->statusAktif ? 'Aktif' : 'Tidak Aktif' }}
                    </span>
                </td>
                <td>
                    <a href="{{ route('banks.edit', $bank->id) }}" class="btn btn-sm btn-warning"><i class="bi bi-pencil-square"></i> Edit</a>
                    <form action="{{ route('banks.destroy', $bank->id) }}" method="POST" class="form-delete d-inline">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-danger">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
@endsection

@section('custom_js')
<script>
$(document).ready(function () {

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
});
</script>

@endsection
