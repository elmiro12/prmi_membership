<p>Halo,</p>
<p>Terima kasih telah mendaftar sebagai member.</p>
<p>Token anda adalah : <strong>{{ $token }}</strong></p>
<p>Silakan klik link berikut untuk verifikasi akun Anda:</p>
<p>
    <a href="{{ url('/verify?token=' . $token) }}">
        Verifikasi Sekarang
    </a>
</p>
<p>Jika Anda tidak mendaftar, abaikan email ini.</p>
