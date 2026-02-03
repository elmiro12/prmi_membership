{{-- resources/views/errors/403.blade.php --}}
@extends('layouts.base') {{-- atau layout yang kamu gunakan --}}
@section('title', 'Hak Akses Dilarang')
@section('content')
<div class="container text-center mt-5">
    <h1 class="display-4 text-danger">403 - Akses Ditolak</h1>
    <p class="lead">Maaf, Anda tidak memiliki izin untuk mengakses halaman ini.</p>
    <p class="lead">Hubungi Super Admin !!</p>
    <a href="{{ url()->previous() }}" class="btn btn-primary mt-3">Kembali</a>
</div>
@endsection
