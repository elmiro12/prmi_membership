{{-- resources/views/admin/announcement/edit.blade.php --}}
@extends('layouts.base')

@section('title', 'Edit Pengumuman')

@section('content')
<form action="{{ route('announcement.update', $announcement->id) }}" method="POST" enctype="multipart/form-data" id="addEditForm">
    @method('PUT')
    @include('admin.announcement.form', ['announcement' => $announcement])
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
