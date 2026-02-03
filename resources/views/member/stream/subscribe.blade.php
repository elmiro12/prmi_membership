@extends('layouts.base')

@section('title', 'Langganan Streaming')

@section('content')
<div class="container mt-4">
    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Perhatian!</strong> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
        </div>
    @endif
    @if($paymentBelumUpload)
         <div class="alert alert-info alert-dismissible fade show" role="alert">
            <strong>Ada pembayaran stream anda yang belum selesai</strong>
            <a href="{{ route('member.payment.history') }}" class="btn btn-sm btn-warning">
                        Lanjutkan Pembayaran
            </a>
        </div>
    @else
    <div class="card border-primary shadow">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Berlangganan Streaming</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('member.stream.subscribe.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="idStreamType" class="form-label">Pilih Tipe Langganan</label>
                    <select name="idStreamType" id="idStreamType" class="form-select" required>
                        <option value="">-- Pilih Tipe --</option>
                        @foreach($streamTypes as $type)
                            <option value="{{ $type->id }}">{{ $type->name }} - Rp {{ number_format($type->amount, 0, ',', '.') }}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-broadcast me-1"></i> Lanjutkan Langganan
                </button>
            </form>
        </div>
    </div>
    @endif
</div>
@endsection
