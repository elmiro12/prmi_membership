@extends('layouts.base')
@section('title', 'Edit Pertandingan')
@section('content')
<div class="container">
    <h4>Edit Pertandingan</h4>
    <form action="{{ route('fixtures.update', $fixture->id) }}" method="POST">
        @method('PUT')
        @include('admin.fixtures.form')
        <button class="btn btn-success">Update</button>
        <a href="{{ route('fixtures.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
