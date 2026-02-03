@extends('layouts.auth-layout')

@section('title', 'Login - '.\App\Helpers\AppSetting::name())

@section('content')
<div class="container">
<div class="header-text mb-4">
    <h2 class="text-bold ">!Hala Madrid!</h2>
    <p>Silahkan login dengan dengan akun anda : </p>
</div>
 @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
 @endif
<form method="POST" action="{{ url('/login') }}">
    @csrf
    <div class="form-group mb-3">
        <label class="mb-2">Email : </label>
        <input type="email" name="email" class="form-control fs-6" required autofocus>
    </div>
    <div class="form-group mb-3">
        <label class="mb-2">Password</label>
        <input type="password" name="password" class="form-control fs-6" required>
    </div>
    @if($errors->any())
        <div class="alert alert-danger small py-2">{{ $errors->first() }}</div>
    @endif
    <div class="form-group">
        <button class="btn btn-warning w-100">Login</button>
    </div>
</form>
<div class="form-group mb-3 d-flex justify-content-end">
    <a href="{{ route('forgot.password.form') }}" class="text-white" >Lupa Password</a>
</div>
<div class="form-group d-flex justify-content-between">
    <a href="{{ url('/register') }}" class="btn btn-sm btn-success text-white">Daftar Member</a>
    <a href="{{ route('manual.verify') }}" class="text-white"><i class="bi bi-person-fill-check me-1"></i>Verify Akun</a>
</div>
</div>
@endsection
