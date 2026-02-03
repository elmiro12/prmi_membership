@extends('layouts.base')

@section('title', 'Form Tambah Tipe Membership')

@section('content')
<div class="container">
    <form action="{{ route('membership-types.store') }}" method="POST">
        @csrf
        @include('admin.membership_types.form')
        <button class="btn btn-primary">Simpan</button>
    </form>
</div>
@endsection
