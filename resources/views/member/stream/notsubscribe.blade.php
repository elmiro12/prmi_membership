@extends('layouts.base')

@section('title', 'Langganan Streaming')

@section('content')
<div class="container mt-4">
    @if(session('error'))
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <strong>Perhatian!</strong> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
        </div>
    @endif
    <div class="card border-primary shadow">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Langganan Streaming Diperlukan</h5>
        </div>
        <div class="card-body">
            <p class="card-text">
                Untuk mengakses layanan streaming, Anda perlu memiliki langganan yang aktif.
            </p>
            <a href="{{ route('stream.perpanjang') }}" class="btn btn-primary">
                <i class="bi bi-broadcast-pin me-1"></i> Berlangganan Sekarang
            </a>
        </div>
    </div>
</div>
@endsection
