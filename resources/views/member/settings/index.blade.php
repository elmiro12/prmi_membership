@php
    use Illuminate\Support\Facades\Auth;
@endphp

@extends('layouts.base') {{-- sesuaikan dengan base layoutmu --}}

@section('title', 'Pengaturan User')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header bg-primary">
                <span class="text-white">Ganti Password</span>
            </div>
            <div class="card-body">
            <!-- Form Ganti Password -->
                <form action="{{ route('member.setting.store') }}" method="POST">
                    @csrf
                    <div class="row mb-3">
                        <div class="col-4">
                            <span class="">Nama Member</span>
                        </div>
                        <div class="col-8">
                            <span class="fw-bold">: {{ $member->fullname }}</span>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-4">
                            <span class="">Tanggal Pendaftaran</span>
                        </div>
                        <div class="col-8">
                            <span class="text-muted">: @tanggalIndo(Auth::user()->registration_date)</span>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email Terdaftar : </label>
                        <input type="email" name="email" class="form-control" value="{{ Auth::user()->email }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="new_password" class="form-label">Password Baru : </label>
                        <input type="password" name="new_password" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="new_password_confirmation" class="form-label">Konfirmasi Password Baru</label>
                        <input type="password" name="new_password_confirmation" class="form-control" required>
                    </div>

                    <button class="btn btn-warning" type="submit">Update</button>
                </form>
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
@endsection
