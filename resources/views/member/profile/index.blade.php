@extends('layouts.base')

@section('title', 'Profil Saya')

@section('content')
<div class="container-fluid">
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body">
            <div class="row">
                <div class="col-md-4 text-center mb-3">
                    @php
                        $photoPath = 'uploads/member_photos/' . $member->photo;
                        if (!$member->photo || $member->photo === 'default.jpg') {
                            $photoPath = $member->gender === 'Perempuan'
                                ? 'images/default-female.png'
                                : 'images/default-male.png';
                        }
                    @endphp
                    <img src="{{ asset($photoPath) }}" alt="Foto Profil" class="img-thumbnail rounded-circle shadow-sm" width="180">
    
                    <h5 class="mt-3">{{ $member->fullname }}</h5>
                    <p class="text-muted mb-0">{{ $member->membership->membershipType->type ?? 'Tipe Member Tidak Ditemukan' }}</p>
                    <span class="badge bg-primary mt-1">
                        Nomor Member : {{ $member->membership->membership_number ?? '-' }}
                    </span>
                </div>
    
                <div class="col-md-4">
                    <h5 class="border-bottom pb-2 mb-3">Informasi Pribadi</h5>
                    <div class="row mb-2">
                        <div class="col-5 text-muted">Tanggal Lahir</div>
                        <div class="col-7">@tanggalIndo($member->dob)</div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-5 text-muted">Jenis Kelamin</div>
                        <div class="col-7">{{ $member->gender }}</div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-5 text-muted">No. Kontak</div>
                        <div class="col-7">{{ $member->contact_number }}</div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-5 text-muted">Instagram</div>
                        <div class="col-7">{{ $member->instagram ?? '-' }}</div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-5 text-muted">Pekerjaan</div>
                        <div class="col-7">{{ $member->occupation ?? '-' }}</div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-5 text-muted">Alamat</div>
                        <div class="col-7">{{ $member->address }}, {{ $member->postcode }}</div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-5 text-muted">Berlaku Hingga</div>
                        <div class="col-7">
                        @if($status == 'Expired' && !$member->membership?->expiry_date)
                            <span class="badge bg-danger">Expired</span>
                        @else
                            <strong>@tanggalIndo($member->membership?->expiry_date)</strong>
                        @endif
                        </div>
                    </div>
    
                    <div class="row mt-4">
                        <div class="col-md-12">
                            <a href="{{ route('member.profile.edit') }}" class="btn btn-primary me-2">
                                <i class="bi bi-pencil-square"></i> Edit
                            </a>
                            <a href="{{ route('member.profile.card') }}" target="_blank" class="btn btn-outline-secondary">
                                <i class="bi bi-printer"></i> Kartu
                            </a>
                            <button type="button" class="btn bg-info text-dark" id="previewButton"><i class="bi bi-eye"></i> Preview Kartu</button>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 d-flex justify-content-center align-items-center" id="previewCard" style="display : none">
                    <iframe 
                        src="{{ route('member.profile.card-preview') }}" 
                        width="400px" 
                        height="250px" 
                        class="bg-white" 
                        style="border: none; box-shadow: 0 0 10px rgba(0,0,0,0.1);">
                    </iframe>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('custom_js')
<script>
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
</script>
<script>
$(document).ready(function() {
        $("#previewButton").click(function() {
            $("#previewCard").toggle();
        });
    });
</script>
@endsection
