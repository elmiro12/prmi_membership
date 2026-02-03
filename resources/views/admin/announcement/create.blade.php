{{-- resources/views/admin/announcement/create.blade.php --}}
@extends('layouts.base')

@section('title', 'Tambah Pengumuman')

@section('content')
<form action="{{ route('announcement.store') }}" method="POST" enctype="multipart/form-data" id="addEditForm">
    @include('admin.announcement.form')
</form>
@endsection
@section('card-footer-action')
<button type="submit" class="btn btn-primary" form="addEditForm">
    <i class="bi bi-save"></i> Simpan
</button>
@endsection
@section('custom_js')
<script src="{{ asset('assets/js/tinymce-config.js') }}"></script>
@endsection
