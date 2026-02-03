@extends('layouts.base')

@section('title', 'Edit Bank')

@section('content')
    @include('admin.banks._form', ['bank' => $bank])
@endsection

@section('card-footer-action')
<button type="submit" class="btn btn-primary" form="addEditForm">{{ isset($bank) ? 'Update' : 'Simpan' }}</button>
@endsection