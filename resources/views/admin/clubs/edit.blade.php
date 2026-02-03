@extends('layouts.base')

@section('title', 'Form Edit Club')

@section('content')
<div class="container">
    <form action="{{ route('clubs.update', $club->id) }}" method="POST" enctype="multipart/form-data" id="editForm">
        @csrf
        @method('PUT')
        @include('admin.clubs.form')
    </form>
</div>
@endsection

@section('card-footer-action')
<button class="btn btn-primary" form="editForm">Update</button>
@endsection
