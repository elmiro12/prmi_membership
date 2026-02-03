@extends('layouts.base')

@section('title', 'Edit Member')

@section('custom_css')
<style>
    .table td, .table th {
        vertical-align: middle;
    }
</style>
@endsection
@section('content')
    <form action="{{ route('members.update', $member->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        {{-- Bagian 1: Data Diri --}}
        <div class="card mb-4 shadow-sm">
            <div class="card-header bg-primary text-white">Data Diri Member</div>
            <div class="card-body row g-3">
                <div class="col-md-6">
                    <label>Nama Lengkap</label>
                    <input type="text" name="fullname" class="form-control" value="{{ $member->fullname }}">
                </div>
                <div class="col-md-3">
                    <label>Tanggal Lahir</label>
                    <input type="date" name="dob" class="form-control" value="{{ $member->dob }}">
                </div>
                <div class="col-md-3">
                    <label>Jenis Kelamin</label>
                    <select name="gender" class="form-control">
                        <option value="L" {{ $member->gender == 'L' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="P" {{ $member->gender == 'P' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label>No. Kontak</label>
                    <input type="text" name="contact_number" class="form-control" value="{{ $member->contact_number }}">
                </div>
                <div class="col-md-6">
                    <label>Instagram</label>
                    <input type="text" name="instagram" class="form-control" value="{{ $member->instagram }}">
                </div>
                <div class="col-md-6">
                    <label>Alamat</label>
                    <input type="text" name="address" class="form-control" value="{{ $member->address }}">
                </div>
                <div class="col-md-3">
                    <label>Kode Pos</label>
                    <input type="text" name="postcode" class="form-control" value="{{ $member->postcode }}">
                </div>
                <div class="col-md-3">
                    <label>Pekerjaan</label>
                    <input type="text" name="occupation" class="form-control" value="{{ $member->occupation }}">
                </div>
                <div class="col-md-6">
                    <label>Foto Profil</label>
                    <input type="file" name="photo" class="form-control">
                    <small class="form-text text-muted">Kosongkan jika tidak ingin mengubah foto</small>
                </div>
            </div>
        </div>

        {{-- Bagian 2: Data Membership --}}
        <div class="card mb-4 shadow-sm">
            <div class="card-header bg-primary text-white">Data Membership</div>
            <div class="card-body row g-3">
                <div class="col-md-4">
                    <label>Kode Member</label>
                    <input type="text" name="membership_number" class="form-control" value="{{ $member->membership->membership_number }}">
                </div>
                <div class="col-md-4">
                    <label>Tipe Membership</label>
                    <select name="membership_type" class="form-control">
                        @foreach ($membershipTypes as $type)
                            <option value="{{ $type->id }}" {{ $member->membership->tipe_member == $type->id ? 'selected' : '' }}>{{ $type->type }} - {{ $type->amount }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label>Tanggal Daftar</label>
                    <input type="date" name="reg_date" class="form-control" value="{{ $member->membership->reg_date }}">
                </div>
                <div class="col-md-2">
                    <label>Tanggal Expired</label>
                    <input type="date" name="expiry_date" class="form-control" value="{{ $member->membership->expiry_date }}">
                </div>
            </div>
        </div>

        {{-- Bagian 3: Data Akun --}}
        <div class="card mb-4 shadow-sm">
            <div class="card-header bg-primary text-white">Data Akun</div>
            <div class="card-body row g-3">
                <div class="col-md-6">
                    <label>Email</label>
                    <input type="email" name="email" class="form-control" value="{{ $member->user->email }}">
                </div>
                <div class="col-md-6">
                    <label>Password</label>
                    <input type="password" name="password" class="form-control">
                    <small class="form-text text-muted">Kosongkan jika tidak ingin mengubah password</small>
                </div>
            </div>
        </div>

        <div class="text-end">
            <button type="submit" class="btn btn-success">Simpan Perubahan</button>
        </div>
    </form>
@endsection
