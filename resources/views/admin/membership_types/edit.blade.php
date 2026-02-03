@extends('layouts.base')

@section('title', 'Form Edit Tipe Membership')

@section('content')
<div class="container">
    <form action="{{ route('membership-types.update', $type->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        @include('admin.membership_types.form')
        <button class="btn btn-primary">Update</button>
    </form>
</div>
@endsection
