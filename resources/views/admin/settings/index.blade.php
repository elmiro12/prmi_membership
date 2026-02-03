@php
    use Illuminate\Support\Facades\Auth;
@endphp

@extends('layouts.base') {{-- sesuaikan dengan base layoutmu --}}

@section('title', 'Pengaturan')

@section('content')
<div class="container">

    <div class="row">
        @if(Auth::user()->tipeUser == 'super_admin')
        <!-- Form Pengaturan -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-primary">
                    <span class="text-white">Pengaturan Aplikasi</span>
                </div>
                <div class="card-body">
                    <form action="{{ route('settings.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="system_name" class="form-label">Nama Aplikasi</label>
                            <input type="text" name="system_name" class="form-control" value="{{ old('system_name', $setting->system_name ?? '') }}" required>
                        </div>
                        
                        <div class="mb-3">
                            @php
                                $photoPath = Auth::user()?->photo ? 'uploads/user_photos/'.Auth::user()->photo : 'images/default-male.png';
                            @endphp
                            <img src="{{ asset($photoPath) }}" class="img-thumbnail rounded-circle shadow-sm mb-3" width="100" alt="Foto Sekarang">
                            <div>
                            <label for="profil_pic" class="form-label">Upload Foto Profil</label>
                            <input type="file" name="profil_pic" class="form-control">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="logo" class="form-label">Logo Aplikasi</label><br>
                            @if(!empty($setting->logo))
                                <img src="{{ asset('uploads/logo/' . $setting->logo) }}" alt="Logo" width="100" class="mb-2"><br>
                            @endif
                            <input type="file" name="logo" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="webbg" class="form-label">Background Aplikasi</label><br>
                            @if(!empty($setting->logo))
                                <img src="{{ asset('uploads/webbg/' . $setting->webbg) }}" alt="WebBG" width="100" class="mb-2"><br>
                            @endif
                            <input type="file" name="webbg" class="form-control">
                        </div>

                        <button class="btn btn-primary" type="submit">Simpan Pengaturan</button>
                    </form>
                </div>
            </div>
        </div>
        @endif
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-primary">
                    <span class="text-white">Ganti Password</span>
                </div>
                <div class="card-body">
                <!-- Form Ganti Password -->
                    <form action="{{ route('settings.change-password') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="new_password" class="form-label">Password Baru Admin</label>
                            <input type="password" name="new_password" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="new_password_confirmation" class="form-label">Konfirmasi Password Baru</label>
                            <input type="password" name="new_password_confirmation" class="form-control" required>
                        </div>

                        <button class="btn btn-warning" type="submit">Ubah Password</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('custom_js')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: '{{ session('success') }}',
                timer: 3000,
                confirmButtonText: 'OK'
            });
        @endif
    });
</script>
@endsection
