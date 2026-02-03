@extends('layouts.base')

@section('title', 'Dashboard Member')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        @if($paymentBelumUpload)
                <div class="alert alert-warning d-flex justify-content-between align-items-center">
                    <div>
                        <strong>Perhatian:</strong> Ada pembayaran untuk perpanjangan membership yang belum selesai.
                    </div>
                    <a href="{{ route('member.payment.history') }}" class="btn btn-sm btn-warning">
                        Lanjutkan Pembayaran
                    </a>
                </div>
            @endif
        <div class="col-md-12 mb-3">
            <div class="card bg-white shadow-sm">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="card-title fw-bold text-primary">Halo, {{ $member->fullname }}</h5>
                        <p class="text-muted"> Membership PRMI Anda
                        @if($expire)
                            Sudah expire, silahkan lakukan perpanjangan !!
                        @else
                            berlaku sampai dengan @tanggalIndo($member->membership->expiry_date)
                        @endif
                        </p>
                    </div>
                    <img src="{{ \App\Helpers\AppSetting::logo() }}" alt="Logo" height="100">
                </div>
            </div>
        </div>

        <div class="col-md-6 mb-3">
            <div class="card text-white bg-primary shadow-sm">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="card-title">Total Member</h5>
                        <h3 class="fw-bold text-white">{{ $totalMembers }}</h3>
                    </div>
                    <i class="bi bi-people-fill fs-1"></i>
                </div>
            </div>
        </div>

        <div class="col-md-6 mb-3">
            <div class="card text-white bg-success shadow-sm">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="card-title">Member Baru (7 Hari)</h5>
                        <h3 class="fw-bold text-white">{{ $newMembers }}</h3>
                    </div>
                    <i class="bi bi-person-plus-fill fs-1"></i>
                </div>
            </div>
        </div>
    </div>

    <h5 class="mb-3">Pengumuman Terbaru</h5>
    @forelse ($announcements as $announce)
        <div class="card mb-2 shadow-sm">
            <div class="card-header bg-primary d-flex justify-content-between align-items-center">
                <h6 class="mb-1 text-white">{{ $announce->judul }}</h6>
            </div>
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="mb-1">{{ $announce->deskripsi }}</h6>
                    <small class="text-muted" style="font-size: smaller">@tanggalIndo($announce->created_at)</small>
                </div>
                <a href="{{ route('member.announcements.show', $announce->id) }}" class="btn btn-sm btn-outline-primary">
                    Lihat
                </a>
            </div>
        </div>
    @empty
        <p class="text-muted">Belum ada pengumuman.</p>
    @endforelse
</div>
@endsection
