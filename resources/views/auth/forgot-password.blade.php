@extends('layouts.auth-layout')
@section('title', 'Lupa Password')

@section('content')
<div class="container">
    <h2>Lupa Password</h2>
    @if(session('message'))
        <div class="alert alert-success">{{ session('message') }}</div>
    @endif

    <form method="POST" action="{{ route('forgot.password') }}">
        @csrf

        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" required value="{{ old('email') }}">
            @error('email') <small class="text-white py-1">{{ $message }}</small> @enderror
        </div>
        <button type="submit" class="btn btn-warning">Kirim Token</button>
    </form>
    <div class="d-flex justify-content-between mt-3">
        <span class="text-white">Sudah Punya Token ? </span>
        <a href="{{ url('/reset-password') }}" class="text-white"><i class="bi bi-arrow-repeat me-1"></i>Reset Password</a>
    </div>
</div>
@endsection
