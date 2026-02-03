@extends('layouts.base')
@section('title', 'Tambah Pertandingan')
@section('content')
<div class="container">
    <form action="{{ route('fixtures.store') }}" method="POST">
        @include('admin.fixtures.form')
        <button class="btn btn-primary">Simpan</button>
    </form>
</div>
@endsection
