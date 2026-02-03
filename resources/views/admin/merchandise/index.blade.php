@extends('layouts.base')

@section('title', 'Manajemen Merchandise')

@section('custom_css')
{{-- Tambahkan custom CSS di sini jika perlu --}}
@endsection

@section('content')
<div class="container mt-4">
    {{-- Form Tambah --}}
    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center bg-primary text-white">
            <strong>Tambah Merchandise</strong>
            <button class="btn btn-sm btn-outline text-white" type="button" data-bs-toggle="collapse" data-bs-target="#formTipeMembership" aria-expanded="true">
                <i class="bi bi-dash-lg"></i>
            </button>
        </div>
        <div class="collapse show" id="formTipeMembership">
            <div class="card-body">
                <form method="POST" action="{{ route('merchandise.store') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="merchandise" class="form-label">Nama Merchandise</label>
                        <input type="text" name="merchandise" id="merchandise" class="form-control @error('merchandise') is-invalid @enderror" value="{{ old('merchandise') }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary">Tambah</button>
                </form>
            </div>
        </div>
    </div>

    {{-- Tabel List --}}
    <div class="card">
        <div class="card-header bg-primary text-white"><strong> Merchandise : </strong></div>
        <div class="card-body table-responsive">
            <table class="table table-bordered align-middle datatable">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Nama</th>
                        <th style="width: 100px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($merchandise as $merchan)

                        <div class="modal fade" id="editModal{{ $merchan->id }}" tabindex="-1" aria-labelledby="editModalLabel{{ $merchan->id }}" aria-hidden="true">
                            <div class="modal-dialog">
                                <form method="POST" action="{{ route('merchandise.update', $merchan->id) }}">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="editModalLabel{{ $merchan->id }}">Edit Merchandise</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label class="form-label">Nama</label>
                                                <input type="text" name="merchandise" value="{{ $merchan->name }}" class="form-control" required>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            </div>
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $merchan->name }}</td>
                            <td>
                                <div class="d-flex justify-content-center">
                                    <button type="button" class="btn btn-sm btn-warning me-2" data-bs-toggle="modal" data-bs-target="#editModal{{ $merchan->id }}">
                                        <i class="bi bi-pencil-square"></i>Edit
                                    </button>
                                    <form method="POST" action="{{ route('merchandise.destroy', $merchan->id) }}" class="form-delete">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">
                                            <i class="bi bi-trash"></i>Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="3" class="text-center">Belum ada merchandise.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
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
<script>
    $(document).on('shown.bs.modal', function (e) {
        var $modal = $(e.target);
        $('body').append($modal);
    });
</script>
@endsection

