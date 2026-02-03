@extends('layouts.download-layout')

@section('title', 'Form Registrasi Member')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow bg-white-50">
                <div class="card-body">
                    <div class="text-center mb-4">
                        <img src="{{ \App\Helpers\AppSetting::logo() }}" width="80">
                        <h4 class="mt-2 text-primary">Formulir Registrasi Anggota</h4>
                        <h5 class="text-secondary">Pena Real Madrid de Indonesia (PRMI) Regional Ambon</h5>
                    </div>
                    <form method="POST" action="{{ route('register.submit') }}" enctype="multipart/form-data">
                        @csrf

                        {{-- ================= BAGIAN 1: Data Diri ================ --}}
                        <h5 class="text-primary">1. Data Diri Member</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <label>Nama Lengkap</label>
                                <input type="text" name="fullname" class="form-control mb-2" value="{{ old('fullname') }}" required>

                                <label>Tanggal Lahir</label>
                                <input type="date" name="dob" class="form-control mb-2" value="{{ old('dob') }}" required>

                                <label>Jenis Kelamin</label>
                                <select name="gender" class="form-control mb-2" required>
                                    <option value="">Pilih</option>
                                    <option value="L">Laki-laki</option>
                                    <option value="P">Perempuan</option>
                                </select>

                                <label>Nomor HP</label>
                                <input type="text" name="contact_number" class="form-control mb-2" value="{{ old('contact_number') }}" required>
                                <label>Instagram</label>
                                <input type="text" name="instagram" class="form-control mb-2" value="{{ old('instagram') }}" required>
                            </div>

                            <div class="col-md-6">
                                <label>Alamat</label>
                                <input type="text" name="address" class="form-control mb-2" value="{{ old('address') }}" required>

                                <label>Kode Pos</label>
                                <input type="text" name="postcode" class="form-control mb-2" value="{{ old('postcode') }}">

                                <label>Pekerjaan</label>
                                <input type="text" name="occupation" class="form-control mb-2" value="{{ old('occupation') }}">

                                <label>Foto Profil</label>
                                <input type="file" name="photo" class="form-control mb-2">
                            </div>
                        </div>

                        {{-- ================= BAGIAN 2: Data Membership ================ --}}
                        <h5 class="text-primary mt-4">2. Data Membership</h5>
                        <div class="form-check form-switch mb-3">
                            <input class="form-check-input" type="checkbox" id="hasPrmi" name="has_prmi" value="1">
                            <label class="form-check-label" for="hasPrmi">Saya sudah punya kode member PRMI</label>
                        </div>

                        <div id="prmiSection" style="display:none;">
                            <div class="row">
                                <div class="col-md-4">
                                    <label>Kode Member</label>
                                    <input type="text" name="kode_member" id="kode_member" class="form-control mb-2">
                                    <small class="text-muted">nomor member pada kartu PRMI</small>
                                </div>
                                <div class="col-md-4">
                                    <label>Tanggal Registrasi</label>
                                    <input type="date" name="reg_date" id="reg_date" class="form-control mb-2">
                                    <small class="text-muted">Isikan dengan tanggal awal bulan terdaftar</small>
                                </div>
                                <div class="col-md-4">
                                    <label>Tanggal Expired</label>
                                    <input type="date" name="expiry_date" id="expiry_date" class="form-control mb-2">
                                    <small class="text-muted">Isikan dengan tanggal akhir bulan expire</small>
                                </div>
                            </div>
                            <input type="hidden" name="tipe_member_fixed" value="{{ $prmiType->id }}">
                            <div class="alert alert-success small mt-3">
                                Tipe Member: <strong>{{ $prmiType->type }}</strong> (Gratis)
                            </div>
                        </div>
                        
                        @php
                            // Kirim data tipe membership sebagai JSON ke JS
                            $typesJson = $types->keyBy('id')->toJson();
                        @endphp

                        <div id="typeSelectSection">
                            <label>Pilih Paket Tipe Membership</label>
                            <select name="tipe_member_select" id="tipe_member_select" class="form-control mb-3" required>
                                <option value="">-- Pilih Tipe Membership --</option>
                                @foreach ($types as $type)
                                    <option value="{{ $type->id }}">{{ $type->type }} (Rp{{ number_format($type->amount) }})</option>
                                @endforeach
                            </select>
                            <div id="merchandise-list" class="mb-3"></div>
                        </div>

                        {{-- ================= BAGIAN 3: Data Akun ================ --}}
                        <h5 class="text-primary mt-4">3. Data Akun Member</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <label>Email</label>
                                <input type="email" name="email" class="form-control mb-2" value="{{ old('email') }}" required>
                            </div>
                            <div class="col-md-6">
                                <label>Password</label>
                                <input type="password" name="password" class="form-control mb-2" required>
                                <label>Konfirmasi Password</label>
                                <input type="password" name="password_confirmation" class="form-control mb-2" required>
                            </div>
                        </div>

                        @if ($errors->any())
                            <div class="alert alert-danger">{{ $errors->first() }}</div>
                        @endif

                        <div class="d-grid mt-3">
                            <button class="btn btn-primary">Daftar Sekarang</button>
                        </div>

                        <div class="text-center mt-3">
                            <a href="{{ route('login') }}">← Kembali ke Login</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    const checkbox = document.getElementById('hasPrmi');
    const prmiSection = document.getElementById('prmiSection');
    const typeSelectSection = document.getElementById('typeSelectSection');
    const kodeMemberInput = document.getElementById('kode_member');
    const regDateInput = document.getElementById('reg_date');
    const expiryDateInput = document.getElementById('expiry_date');
    const tipeSelect = document.getElementById('tipe_member_select');
    
    checkbox.addEventListener('change', function () {
        if (this.checked) {
            prmiSection.style.display = 'block';
            typeSelectSection.style.display = 'none';
            kodeMemberInput.setAttribute('required','');
            regDateInput.setAttribute('required','');
            expiryDateInput.setAttribute('required','');
            tipeSelect.removeAttribute('required');
        } else {
            prmiSection.style.display = 'none';
            typeSelectSection.style.display = 'block';
            kodeMemberInput.removeAttribute('required');
            regDateInput.removeAttribute('required');
            expiryDateInput.removeAttribute('required');
            tipeSelect.setAttribute('required','');
        }
    });
    
    //update merhcandise
    const types = {!! $typesJson !!}; // data dari Laravel
    const allMerchandise = @json($merchandise); // semua merchandise

    const select = document.getElementById('tipe_member_select');
    const merchListDiv = document.getElementById('merchandise-list');

    select.addEventListener('change', function () {
        const selectedType = this.value;
        merchListDiv.innerHTML = ''; // kosongkan dulu

        if (!selectedType || !types[selectedType]?.merchandise?.length) {
            merchListDiv.innerHTML = '<div class="alert alert-warning">Tidak ada merchandise untuk tipe ini.</div>';
            return;
        }

        const merchIds = types[selectedType].merchandise.map(String); // pastikan string untuk pencocokan
        const tipe = types[selectedType].type;
        const filteredMerch = allMerchandise.filter(m => merchIds.includes(String(m.id)));

        if (filteredMerch.length === 0) {
            merchListDiv.innerHTML = '<div class="alert alert-warning">Merchandise tidak ditemukan.</div>';
            return;
        }

        const listItems = filteredMerch.map(m => `<div class="col-md-4"><span class="badge bg-success">${m.name}</span></div>`).join('<br>');
        merchListDiv.innerHTML = `<div class="card mt-3">
                                        <div class="card-header bg-primary text-white">
                                            <label for='merchan'>Merchandise ${tipe} : </label>
                                        </div>
                                        <div class="card-body bg-white">
                                            <div class='row'>
                                                ${listItems}
                                            </div>
                                        </div>
                                      </div>`;
    });
</script>
@endsection
