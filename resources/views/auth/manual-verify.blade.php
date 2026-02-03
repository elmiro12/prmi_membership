@extends('layouts.auth-layout')

@section ('title','Verifikasi Akun')

@section('content')
<h4 class="text-center text-white">Verifikasi Akun</h4>

@if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

@if ($errors->any())
    <div class="alert alert-danger">{{ $errors->first() }}</div>
@endif

<div class="alert alert-info">
    <p>Masukan Token yang dikirim ke email anda ?</p>
    <form id="resend-token-form">
        <div class="input-group">
            <input type="email" name="email" class="form-control" placeholder="Masukkan email" required>
            <button type="submit" class="btn btn-warning">Kirim Ulang Token</button>
        </div>
        <div class="form-text text-muted">Token hanya akan dikirim jika email belum terverifikasi.</div>
    </form>
    <div id="resend-token-response" class="mt-2"></div>
</div>
<form method="POST" action="{{ url('/verifikasi') }}">
    @csrf
    <label>Kode Token</label>
    <input type="text" name="token" class="form-control mb-3" required>

    <div class="d-grid">
        <button class="btn btn-warning">Verifikasi</button>
    </div>
</form>
<div class="text-center py-4">
    <a class="text-white" href="/login"><i class="bi bi-arrow-return-left me-2"></i> Kembali Login </a>
</div>
@endsection
@section('custom_js')
<script>
document.getElementById('resend-token-form').addEventListener('submit', function(e) {
    e.preventDefault();

    const form = e.target;
    const email = form.email.value;
    const responseEl = document.getElementById('resend-token-response');
    
    responseEl.innerHTML = 'Mengirim ulang token...';

    fetch("{{ url('/resend-token') }}", {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
        },
        body: JSON.stringify({ email })
    })
    .then(res => res.json())
    .then(data => {
        responseEl.innerHTML = data.message;
    })
    .catch(err => {
        console.error(err);
        responseEl.innerHTML = 'Terjadi kesalahan.';
    });
});
</script>
@endsection
