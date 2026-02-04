@extends('layouts.base')
@section('title', 'Manajemen Tipe Stream Membership')

@section('content')
<div class="container-fluid">

    <div class="card shadow mb-4">
        <div class="card-header d-flex justify-content-between align-items-center bg-primary text-white">
            <strong>Tambah Tipe Stream</strong>
            <button class="btn btn-sm btn-outline text-white" type="button" data-bs-toggle="collapse" data-bs-target="#formTambah" aria-expanded="true">
                <i class="bi bi-dash-lg"></i>
            </button>
        </div>
        <div class="collapse show" id="formTambah">
            <div class="card-body">
                <form action="{{ route('stream-type.store') }}" method="POST">
                    @csrf
                    <div class="row g-2">
                        <div class="col-md-6">
                            <label for="name" class="form-label">Nama Tipe</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label for="amount" class="form-label">Biaya (Rp)</label>
                            <input type="number" name="amount" class="form-control" required min="0">
                        </div>
                    </div>
                    <div class="mt-3">
                        <button class="btn btn-primary" type="submit">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Table -->
    <div class="card shadow mb-4">
        <div class="card-header d-flex justify-content-between align-items-center bg-primary text-white">
            <strong>Daftar Tipe Stream</strong>
        </div>
        <div class="card-body">
            <table class="table table-bordered" id="dataTable">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nama Tipe</th>
                        <th>Biaya</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($streamTypes as $i => $type)
                    <tr>
                        <td>{{ $i+1 }}</td>
                        <td>{{ $type->name }}</td>
                        <td>Rp {{ number_format($type->amount, 0, ',', '.') }}</td>
                        <td>
                            <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editModal{{ $type->id }}">
                                Edit
                            </button>
                            <form action="{{ route('stream-type.destroy', $type->id) }}" method="POST" style="display:inline-block;" class="form-delete">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger">Hapus</button>
                            </form>
                        </td>
                    </tr>

                    <!-- Modal Edit -->
                    <div class="modal fade" id="editModal{{ $type->id }}" tabindex="-1" aria-labelledby="editModalLabel{{ $type->id }}" aria-hidden="true">
                        <div class="modal-dialog">
                            <form action="{{ route('stream-type.update', $type->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Edit Tipe Stream Membership</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label for="type" class="form-label">Nama Tipe</label>
                                            <input type="text" name="name" class="form-control" value="{{ $type->name }}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="amount" class="form-label">Biaya (Rp)</label>
                                            <input type="number" name="amount" class="form-control" value="{{ $type->amount }}" required min="0">
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
                    @endforeach
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

$(document).on('shown.bs.modal', function (e) {
    var $modal = $(e.target);
    $('body').append($modal);
});

});
</script>
@endsection
