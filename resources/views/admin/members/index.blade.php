@php
    use Illuminate\Support\Facades\Auth;
@endphp

@extends('layouts.base')

@section('title', 'Daftar Member')

@section('custom_css')
<style>
    .table td, .table th {
        vertical-align: middle;
    }
</style>
@endsection

@section('card-action')
<a href="{{ route('members.export.pdf') }}" class="btn btn-sm btn-danger me-2">
    <i class="bi bi-file-earmark-pdf me-2"></i> Export PDF
</a>
<a href="{{ route('members.export.excel') }}" class="btn btn-sm btn-success">
    <i class="bi bi-file-earmark-excel me-2"></i> Export Excel
</a>
@endsection

@section('content')
    <div class="table-responsive">
        <table class="table table-bordered mb-0 datatable">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Kode Member PRMI</th>
                    <th>Nama Lengkap</th>
                    <th>Kontak</th>
                    <th>Email</th>
                    <th>Alamat</th>
                    <th>Tipe Membership</th>
                    <th>Member PRMI</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($members as $index => $member)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $member->membership->membership_number }}</td>
                        <td>{{ $member->fullname }}</td>
                        <td>{{ $member->contact_number }}</td>
                        <td>{{ $member->user->email }}</td>
                        <td>{{ $member->address }}</td>
                        <td>{{ $member->membership->membershipType->type ?? '-' }}</td>
                        <td>
                            @if ($member->membership->exsist == 'lama')
                                <span class="badge bg-warning">Member Lama</span>
                            @else
                                <span class="badge bg-success">Member Baru</span>
                            @endif
                        </td>
                        <td>
                            @if ($member->membership && $member->membership->expiry_date > now())
                                <span class="badge bg-success">Aktif</span>
                            @else
                                <span class="badge bg-secondary">Nonaktif</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('members.edit', $member->id) }}" class="btn btn-sm btn-warning me-1">
                                <i class="bi bi-pencil-square"></i> Edit
                            </a>
                            @if(Auth::user()->tipeUser == 'super_admin')
                            <form action="{{ route('members.destroy', $member->id) }}" method="POST" class="d-inline form-delete">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger">
                                    <i class="bi bi-trash"></i> Hapus
                                </button>
                            </form>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="10" class="text-center">Tidak ada data member</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection

@section('custom_js')
<script>
@if(session('success'))
    document.addEventListener('DOMContentLoaded', function () {
        Swal.fire({
            title: 'Berhasil!',
            text: '{{ session('success') }}',
            icon: 'success',
            confirmButtonText: 'OK'
        });

    });
@endif
</script>
@endsection
