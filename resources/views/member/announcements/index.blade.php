@extends('layouts.base')

@section('title', 'Pengumuman Member')

@section('content')
<div class="container-fluid">
    @forelse ($announcements as $item)
        <div class="card mb-3 shadow-sm">
            <div class="card-header bg-primary">
                <h5 class="mb-0 text-white">{{ $item->judul }}</h5>
            </div>
            <div class="card-body">
                <small class="text-muted">@tanggalIndo($item->created_at)</small>
                <p class="mt-2">{{ $item->deskripsi }}</p>
                <a href="{{ route('member.announcements.show', $item->id) }}" class="btn btn-sm btn-outline-primary">
                    Lihat Selengkapnya
                </a>
            </div>
        </div>
    @empty
        <p class="text-muted">Belum ada pengumuman.</p>
    @endforelse

    <div class="mt-3">
        {{ $announcements->links() }}
    </div>
</div>
@endsection

@section('custom_js')
<script>
@if ($errors->any())
    Swal.fire({
        icon: 'error',
        title: 'Terjadi kesalahan!',
        html: `{!! implode('<br>', $errors->all()) !!}`,
    });
@endif
</script>
@endsection
