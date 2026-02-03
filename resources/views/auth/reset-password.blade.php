@extends('layouts.auth-layout')
@section('title', 'Reset Password')

@section('content')
<div class="container">
    <h2>Reset Password</h2>

    @if(session('message'))
        <div class="alert alert-success">{{ session('message') }}</div>
    @endif
    <div class="alert alert-info">
    @if(isset($token))
        Silahkan masukan password baru anda
    @else
        Silahkan masukan token yang telah dikirim ke email anda !
    @endif
    </div>
    <form method="POST" action="{{ route('reset.password') }}">
        @csrf

        {{-- Token --}}
        <div class="mb-3">
            <div id="alert-box"></div>
            <label>Token</label>
            <input type="text" name="token" id="tokenInput" class="form-control"
                value="{{ old('token', $token ?? '') }}"
                    {{ isset($token) ? 'readonly' : '' }}
                    required>
            @error('token')<small class="text-white">{{ $message }}</small>@enderror
            <div class="d-flex align-items-right">
            @if(!isset($token))
                <button type="button" class="btn btn-warning mt-2" id="verifyBtn">Verifikasi Token</button>
            @endif
            </div>
        </div>
        <div id="formNewPassword" style="display:none">
            {{-- Password Baru --}}
            <div class="mb-3">
                <label>Password Baru</label>
                <input type="password" name="password" class="form-control" required>
                @error('password') <small class="text-white">{{ $message }}</small> @enderror
            </div>
    
            {{-- Konfirmasi --}}
            <div class="mb-3">
                <label>Konfirmasi Password Baru</label>
                <input type="password" name="password_confirmation" class="form-control" required>
            </div>
            <div class="d-flex justify-content-between">
            <a class="text-white" href="/login"><i class="bi bi-arrow-return-left me-2"></i> Kembali Login </a>
            <button type="submit" class="btn btn-success">Reset Password</button>
            </div>
        </div>
    </form>
</div>
@endsection

@section('custom_js')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
       $.ajaxSetup({
            headers: {
              'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        });
    $('#verifyBtn').click(function () {
        var token = $('#tokenInput').val();
        $.ajax({
            url: '{{ route("verify.token") }}',
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                token: token
            },
            success: function (response) {
                if (response.status === 'valid') {
                    $('#alert-box').html('<div class="alert alert-success">' + response.message + '</div>');
                    $('#tokenInput').prop('readonly', true);
                    $('#verifyBtn').prop('disabled', true);
                    $("#formNewPassword").show();
                } else {
                    $('#alert-box').html('<div class="alert alert-danger">' + response.message + '</div>');
                    if($("#formNewPassword").is(":visible")){
                        $("#formNewPassword").hide();
                    }
                }
            },
            error: function (xhr) {
                console.log(xhr.responseText);
            }
        });
    });
</script>
@endsection
