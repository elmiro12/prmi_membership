@php
    use Illuminate\Support\Facades\Auth;
@endphp

@extends($layout) <!-- layout login dengan sidebar -->

@section('title', 'Download Membership Apk')

@section('content')
<div class="container mt-2 text-center text-dark">
            <h1 class="text-bold text-primary">Download Aplikasi</h1>
            <h3 class="text-bold text-secondary">PRMI Reg. Ambon Membership App</h3>
            <span class="py-3"> Klik tombol download dibawah ini :</span><br>
            <a href="{{ asset('assets/apk/PRMI-Ambon.apk') }}" class="btn btn-primary">Download APK</a>
            <p>Setelah download, jika muncul peringatan <strong>Unknown Sources</strong>, aktifkan izin install dari sumber tidak dikenal di pengaturan HP Anda.</p>
            <p>scan QR Code di bawah ini:</p>
            
            <img class="img-thumbnail rounded" src="https://api.qrserver.com/v1/create-qr-code/?size=180x180&data={{ urlencode(asset('assets/apk/PRMI-Ambon.apk')) }}" alt="QR Code Download">
            <p style="margin-top: 20px;">Versi manual tanpa Play Store.</p>
            
            @if(!Auth::user())
                <a href="{{ route('login') }}" class="btn btn-secondary">Login App</a>
            @endif
</div>
@endsection