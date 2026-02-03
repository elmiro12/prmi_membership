@extends('layouts.base')

@section('title', 'Daftar Club')

@section('card-action')
<a href="{{ route('clubs.create') }}" class="btn btn-light btn-sm text-primary">
    <i class="bi bi-plus-lg"></i>Tambah Club</a>
@endsection

@section('content')
<div class="container">
    <table class="table table-bordered datatable">
        <thead>
            <tr>
                <th>Logo</th>
                <th>Nama Club</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($clubs as $club)
                <tr>
                    <td>
                        @if($club->logo)
                            <img src="{{ asset('uploads/logo_club/' . $club->logo) }}" width="32" alt="logo">
                        @else
                            Tidak ada logo
                        @endif
                    </td>
                    <td>{{ $club->name }}
                        <small class="text-muted">{{($club->is_primary ? 'Klub Utama' : '')}}</small>
                    </td>

                    <td>
                        <a href="{{ route('clubs.edit', $club->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('clubs.destroy', $club->id) }}" method="POST" class="form-delete d-inline">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm">Hapus</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
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
