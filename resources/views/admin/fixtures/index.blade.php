@php
    use Illuminate\Support\Facades\Auth;
@endphp

@extends('layouts.base')

@section('title', 'Daftar Jadwal Pertandingan');

@section('card-action')
<a href="{{ route('fixtures.create') }}" class="btn btn-light btn-sm text-primary">
    <i class="bi bi-plus-lg"></i>Tambah Jadwal</a>
@endsection

@section('content')
<div class="container">
    <table class="table table-bordered text-center datatable">
        <thead>
            <tr>
                <th>#</th>
                <th>Tanggal</th>
                <th>Kick Off</th>
                <th>Pertandingan</th>
                <th>Venu</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($fixtures as $fixture)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>@tanggalIndo($fixture->match_date)</td>
                    <td>{{ $fixture->match_time }} WIT</td>
                    <td>
                        <div class="row">
                        <div class="col-sm-4">
                        <img src="{{ asset('uploads/logo_club/'.$fixture->homeClub->logo) }}" height="40px" alt="home"/><br>
                        {{ $fixture->homeClub->name }} </div>
                         <div class="col-sm-4"><br>vs </div>
                         <div class="col-sm-4">
                        <img src="{{ asset('uploads/logo_club/'.$fixture->awayClub->logo) }}" height="40px" alt="home"/><br>
                        {{ $fixture->awayClub->name }}
                         </div>
                        </div>
                    </td>
                    <td>{{ $fixture->venue }}</td>
                    <td>
                        <form action="{{ route('fixtures.destroy', $fixture->id) }}" method="POST" class="form-delete d-inline">
                            @csrf @method('DELETE')
                            <a href="{{ route('fixtures.show', $fixture->id) }}" class="btn btn-info btn-sm">
                                <i class="bi bi-eye me-2"></i> Detail</a>
                            @if(Auth::user()->tipeUser == 'super_admin')
                            <a href="{{ route('fixtures.edit', $fixture->id) }}" class="btn btn-success btn-sm">
                                <i class="bi bi-pencil me-2"></i> Edit</a>
                            <div class="mt-2">
                            <button class="btn btn-danger btn-sm"><i class="bi bi-trash me-2"></i> Hapus</button>
                            </div>
                            @endif
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
