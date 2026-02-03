@extends('layouts.base')

@section('title', 'Manajemen Tipe Membership')

@section('card-action')
<a class="btn btn-sm bg-light text-primary" href="{{ route('membership-types.create') }}">
    <i class="bi bi-plus"></i>Tambah Tipe
</a>
@endsection

@section('content')
<div class="container mt-4">
    <table class="table table-bordered align-middle datatable">
        <thead class="table-light">
            <tr>
                <th>#</th>
                <th>Nama Tipe</th>
                <th>Biaya</th>
                <th>Merchandise</th>
                <th style="width: 100px;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($types as $type)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $type->type }}</td>
                    <td>Rp {{ number_format($type->amount, 0, ',', '.') }}</td>
                    <td>
                            @php
                                $selected = collect($type->merchandise)->map(fn($id) => (int) $id)->toArray();
                                $displayed = $merchandise->filter(fn($m) => in_array($m->id, $selected));
                            @endphp
                            
                            @if($displayed->isEmpty())
                                    <span class="badge bg-danger">Belum ada merchandise.</span>
                            @else
                                @foreach($displayed as $merchan)
                                        <span class="badge bg-success mb-2" style="font-size:0.9em">{{ $merchan->name }}</span><br>
                                @endforeach
                            @endif
                    </td>
                    <td>
                        <div class="d-flex justify-content-center alignt-items-center">
                        @if($type->amount != 0)
                        <a class="btn btn-sm btn-warning me-2" href="{{ route('membership-types.edit', $type->id) }}">
                            <i class="bi bi-pencil-square"></i> Edit
                        </a>
                        <form method="POST" action="{{ route('membership-types.destroy', $type->id) }}" class="form-delete">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">
                                <i class="bi bi-trash"></i> Hapus
                            </button>
                        </form>
                        @endif
                        </div>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5" class="text-center">Belum ada tipe membership.</td></tr>
            @endforelse
        </tbody>
    </table>
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
@endsection

