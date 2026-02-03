@extends('layouts.base')

@section('title', 'Daftar Pengumuman')

@section('card-action')
<a href="{{ route('announcement.create') }}" class="btn btn-light btn-sm text-primary">
        <i class="bi bi-plus-lg"></i> Tambah Pengumuman
</a>
@endsection

@section('content')
<table class="table table-bordered table-hover nowrap datatable">
    <thead class="table-light">
        <tr>
            <th>Judul</th>
            <th>Deskripsi</th>
            <th>Lampiran</th>
            <th>Status</th>
            <th>Tanggal</th>
            <th width="120px">Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($announcements as $a)
        <tr>
            <td>{{ $a->judul }}</td>
            <td>{{ $a->deskripsi }}</td>
            <td>
                @if ($a->namaFile)
                    <a href="{{ asset('uploads/pengumuman/' . $a->namaFile) }}" target="_blank">Lihat File</a>
                @else
                    -
                @endif
            </td>
            <td>
                @if ($a->status)
                    <span class="badge bg-success">Published</span>
                @else
                    <span class="badge bg-secondary">Draft</span>
                @endif
            </td>
            <td>@tanggalIndo($a->created_at)</td>
            <td>
                <a href="{{ route('announcement.edit', $a->id) }}" class="btn btn-sm btn-warning">
                    <i class="bi bi-pencil-square"></i>
                </a>
                <form action="{{ route('announcement.destroy', $a->id) }}" method="POST" class="form-delete d-inline">
                    @csrf @method('DELETE')
                    <button class="btn btn-sm btn-danger" onclick="submitForm()">
                        <i class="bi bi-trash"></i>
                    </button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
{{ $announcements->links('pagination::bootstrap-5') }}
@endsection

@section('custom_js')
<script>
    $(document).ready(function () {


@if(session('success'))
    Swal.fire({
        icon: 'success',
        title: 'Berhasil!',
        text: '{{ session("success") }}',
        showConfirmButton: false,
        timer: 2000
    });
@endif
@if ($errors->any())
    Swal.fire({
        icon: 'error',
        title: 'Terjadi kesalahan!',
        html: `{!! implode('<br>', $errors->all()) !!}`,
    });
@endif
    });
</script>
@endsection
