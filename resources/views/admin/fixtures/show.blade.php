@extends('layouts.base')
@section('title', 'Detail Pertandingan')
@section('content')
<div class="container text-center">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-sm-5 ml-5">
                    <img src="{{ asset('uploads/logo_club/'.$fixture->homeClub->logo) }}" height="60px" alt="home"/><br>
                        {{ $fixture->homeClub->name }}
                </div>
                <div class="col-sm-2"><h2><strong>VS</strong></h2></div>
                <div class="col-sm-5 mr-5">
                    <img src="{{ asset('uploads/logo_club/'.$fixture->awayClub->logo) }}" height="60px" alt="home"/><br>
                        {{ $fixture->awayClub->name }}
                </div>
            </div>
            <p><strong>Tanggal:</strong> @tanggalIndo($fixture->match_date)</p>
            <p><strong>Kick Off:</strong> {{ \Carbon\Carbon::parse($fixture->match_time)->format('H:i') }} WIT</p>
            <p><strong>Venue:</strong> {{ $fixture->venue }}</p>
            @if($fixture->embed_url)
                <iframe src='{{ $fixture->embed_url }}' width='100%' height="500" frameborder='0' allowfullscreen="true"></iframe>
                <button id="fullscreenToggle" class="btn btn-primary mt-3">Fullscreen</button>
            @else
                <p class="text-muted">Belum ada video embed.</p>
            @endif
        </div>
    </div>
</div>
@endsection

@section('custom_js')
<script>
$(document).ready(function() {
    $('#fullscreenToggle').on('click', function() {
        var iframe = $('#myIframe')[0]; // Get the DOM element of the iframe

        if (document.fullscreenElement || document.webkitFullscreenElement || document.mozFullScreenElement || document.msFullscreenElement) {
            // If already in fullscreen, exit fullscreen
            if (document.exitFullscreen) {
                document.exitFullscreen();
            } else if (document.webkitExitFullscreen) { // Safari
                document.webkitExitFullscreen();
            } else if (document.mozCancelFullScreen) { // Firefox
                document.mozCancelFullScreen();
            } else if (document.msExitFullscreen) { // IE/Edge
                document.msExitFullscreen();
            }
        } else {
            // If not in fullscreen, request fullscreen for the iframe
            if (iframe.requestFullscreen) {
                iframe.requestFullscreen();
            } else if (iframe.webkitRequestFullscreen) { // Safari
                iframe.webkitRequestFullscreen();
            } else if (iframe.mozRequestFullScreen) { // Firefox
                iframe.mozRequestFullScreen();
            } else if (iframe.msRequestFullscreen) { // IE/Edge
                iframe.msRequestFullscreen();
            }
        }
    });
});
</script>
@endsection
