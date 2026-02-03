@extends('layouts.base')

@section('title', 'Form Tambah Club Baru')

@section('content')
<div class="container">
    <form action="{{ route('clubs.store') }}" method="POST" enctype="multipart/form-data" id="addForm">
        @csrf
        @include('admin.clubs.form')
    </form>
</div>
@endsection

@section('card-footer-action')
<button class="btn btn-primary" form="addForm">Simpan</button>
@endsection
