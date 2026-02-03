@extends('layouts.base')

@section('title', 'Edit Profil')

@section('content')
<div class="container-fluid">
    <form action="{{ route('member.profile.update') }}" method="POST" enctype="multipart/form-data" class="card shadow-sm border-0 p-4">
        @csrf
        <div class="row">
            <div class="col-md-4 text-center mb-4">
                @php
                    $photoPath = 'uploads/member_photos/' . $member->photo;
                    if (!$member->photo || $member->photo === 'default.jpg') {
                        $photoPath = $member->gender === 'Female'
                            ? 'images/default-female.png'
                            : 'images/default-male.png';
                    }
                @endphp

                <img src="{{ asset($photoPath) }}" class="img-thumbnail rounded-circle shadow-sm mb-3" width="180" alt="Foto Sekarang">
                <div>
                    <label class="form-label">Ubah Foto (Opsional)</label>
                    <input type="file" name="photo" class="form-control">
                    <small class="text-muted">Max 2MB. JPG/PNG</small>
                </div>
            </div>

            <div class="col-md-8">
                <div class="mb-3">
                    <label for="fullname" class="form-label">Nama Lengkap</label>
                    <input type="text" name="fullname" class="form-control" value="{{ old('fullname', $member->fullname) }}" required>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="dob" class="form-label">Tanggal Lahir</label>
                        <input type="date" name="dob" class="form-control" value="{{ old('dob', $member->dob) }}" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="gender" class="form-label">Jenis Kelamin</label>
                        <select name="gender" class="form-select" required>
                            <option value="Male" {{ $member->gender === 'Male' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="Female" {{ $member->gender === 'Female' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="contact_number" class="form-label">No. Kontak</label>
                    <input type="text" name="contact_number" class="form-control" value="{{ old('contact_number', $member->contact_number) }}" required>
                </div>

                <div class="mb-3">
                    <label for="instagram" class="form-label">Instagram</label>
                    <input type="text" name="instagram" class="form-control" value="{{ old('instagram', $member->instagram) }}">
                </div>

                <div class="mb-3">
                    <label for="occupation" class="form-label">Pekerjaan</label>
                    <input type="text" name="occupation" class="form-control" value="{{ old('occupation', $member->occupation) }}">
                </div>

                <div class="mb-3">
                    <label for="address" class="form-label">Alamat</label>
                    <textarea name="address" class="form-control" rows="3" required>{{ old('address', $member->address) }}</textarea>
                </div>

                <div class="mb-3">
                    <label for="postcode" class="form-label">Kode Pos</label>
                    <input type="text" name="postcode" class="form-control" value="{{ old('postcode', $member->postcode) }}">
                </div>

                <div class="d-flex justify-content-end">
                    <a href="{{ route('member.profile') }}" class="btn btn-secondary me-2">Batal</a>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@section('custom_js')
<script>
@if ($errors->any())
    Swal.fire({
        icon: 'error',
        title: 'Terjadi kesalahan!',
        html: `{!! implode('<br>', $errors->all()) !!}`,
    });
@endif
</script>
@endsection
