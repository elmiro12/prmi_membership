@extends('layouts.base')

@section('title', $announcement->judul)

@section('content')
<div class="container-fluid">
    <small class="text-muted">@tanggalIndo($announcement->created_at)</small>
    <div class="mt-3">
        {!! $announcement->isi !!}
    </div>

    @if ($announcement->file)
        <a href="{{ asset('uploads/announcement/' . $announcement->file) }}" target="_blank" class="btn btn-outline-secondary mt-3">
            <i class="bi bi-download"></i> Download Lampiran
        </a>
    @endif

    <div class="mt-4">
        <a href="{{ route('member.announcements') }}" class="btn btn-sm btn-secondary">Kembali ke Daftar</a>
    </div>
</div>
@endsection
