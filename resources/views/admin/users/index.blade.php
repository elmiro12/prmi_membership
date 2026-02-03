@extends('layouts.base')

@section('title', 'Daftar User Member')

@section('content')
<div class="container mt-4">
    <h4 class="mb-3">Daftar User Member</h4>

    <div class="table-responsive">
        <table class="table table-bordered align-middle datatable">
            <thead class="table-light">
                <tr>
                    <th>No</th>
                    <th minwidth="100px">Email</th>
                    <th>Tipe User</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $i => $user)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>
                        <form action="{{ route('users.update-email', $user->id) }}" method="POST" class="d-flex align-items-center">
                            @csrf
                            <input type="email" name="email" value="{{ $user->email }}" class="form-control form-control-sm me-2" required>
                            <button class="btn btn-sm btn-primary" type="submit" title="Update Email">
                                <i class="bi bi-envelope-check"></i>
                            </button>
                        </form>
                    </td>
                    <td>{{ $user->tipeUser }}</td>
                    <td>
                        <form action="{{ route('users.reset-password', $user->id) }}" method="POST" onsubmit="return confirm('Reset password user ini ke default?');">
                            @csrf
                            <button class="btn btn-sm btn-warning" type="submit">
                                <i class="bi bi-arrow-clockwise me-1"></i> Reset Password
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
                @if($users->isEmpty())
                <tr><td colspan="4" class="text-center">Tidak ada user member.</td></tr>
                @endif
            </tbody>
        </table>
    </div>
</div>
@endsection
@section('custom_js')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: '{{ session('success') }}',
                timer: 3000,
                confirmButtonText: 'OK'
            });
        @endif

        @if(session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Gagal Menghapus',
                html: `{!! nl2br(e(session('error'))) !!}`,
                confirmButtonText: 'Mengerti'
            });
        @endif
    });
</script>
@endsection
