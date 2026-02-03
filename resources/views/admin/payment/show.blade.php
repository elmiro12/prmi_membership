@extends('layouts.base')

@section('title', 'Detail Pembayaran')

@section('custom_css')
@endsection

@section('content')
<div class="row g-4">
    {{-- Kiri: Info Pembayaran --}}
    <div class="col-md-6">
        <div class="mb-2">
            <strong>Nama Member:</strong><br>
            @if ($payment->extension->membership)
                {{ $payment->extension->membership->member->fullname }}
            @elseif ($payment->extension->streamMembership)
                {{ $payment->extension->streamMembership->member->fullname }}
            @else
                <em>Tidak diketahui</em>
            @endif
        </div>
        <div class="mb-2">
            <strong>Tipe
            @if ($payment->extension->membership)
                Membership :</strong><br>
                {{ $payment->extension->membership->membershipType->type }}
            @elseif ($payment->extension->streamMembership)
                Stream Membership :</strong><br>
                {{ $payment->extension->streamMembership->streamType->name }}
            @else
                <em>Tidak diketahui</em>
            @endif
        </div>
        <div class="mb-2">
            <strong>Bank Tujuan:</strong><br>
            {{ $payment->bank->namaBank }} ({{ $payment->bank->noRekening }})<br>
            a.n {{ $payment->bank->namaPemilik }}
        </div>
        <div class="mb-2">
            <strong>Status Pembayaran:</strong><br>
            @if(is_null($payment->status))
                <span class="badge bg-warning">Belum Diverifikasi</span>
            @elseif($payment->status)
                <span class="badge bg-success">Terverifikasi</span>
            @else
                <span class="badge bg-danger">Tidak Diterima</span>
            @endif
        </div>
    </div>

    {{-- Kanan: Bukti dan Tombol --}}
    <div class="col-md-6 d-flex flex-column justify-content-between">
        <div>
            <strong>Bukti Pembayaran:</strong><br>
            @if($payment->bukti && file_exists(custom_public_path('uploads/bukti/' . $payment->bukti)))
                <img src="{{ asset('uploads/bukti/' . $payment->bukti) }}"
                    class="img-fluid rounded border"
                    style="max-height: 300px;"
                    alt="Bukti Pembayaran">
            @else
                <div class="text-muted fst-italic">Bukti belum diupload</div>
            @endif
        </div>

        @if(!$payment->status || is_null($payment->status))
        <div class="d-flex justify-content-end mt-4 gap-2">
            <form action="{{ route('payments.verify', $payment->id) }}" method="POST">
                @csrf
                <input type="hidden" name="status" value="true">
                <button class="btn btn-success" onclick="return confirm('Verifikasi pembayaran ini?')">
                    <i class="bi bi-check-circle"></i> Verifikasi
                </button>
            </form>
            <form action="{{ route('payments.verify', $payment->id) }}" method="POST">
                @csrf
                <input type="hidden" name="status" value="false">
                <button class="btn btn-danger" onclick="return confirm('Tolak pembayaran ini?')">
                    <i class="bi bi-x-circle"></i> Tolak
                </button>
            </form>
        </div>
        @endif
    </div>
</div>
@endsection

@section('custom_js')
@endsection
