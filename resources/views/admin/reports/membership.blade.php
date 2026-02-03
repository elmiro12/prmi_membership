@extends('layouts.base')

@section('title', 'Laporan Membership')

@section('custom_css')
{{-- Tambahkan CSS tambahan jika ada --}}
@endsection

@section('content')
<form method="POST" action="{{ url('/reports/membership/generate') }}">
    @csrf
    <div class="row mb-3">
        <div class="col-md-4">
            <label for="from_date">Dari Tanggal</label>
            <input type="date" name="from_date" id="from_date" class="form-control" value="{{ \Carbon\Carbon::parse($from_date)->format('Y-m-d') }}" required>
        </div>
        <div class="col-md-4">
            <label for="to_date">Sampai Tanggal</label>
            <input type="date" name="to_date" id="to_date" class="form-control" value="{{ \Carbon\Carbon::parse($to_date)->format('Y-m-d') }}" required>
        </div>
        <div class="col-md-4 align-self-end">
            <button type="submit" class="btn btn-primary">Generate Laporan</button>
        </div>
    </div>
</form>
@isset($memberships)
<div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center bg-primary">
             <h4 class="text-white">Laporan Bulan : {{ \Carbon\Carbon::parse($from_date)->translatedFormat('F') }}</h4>
             <div class="d-flex justify-content-end">
                 @if(!empty($memberships) && count($memberships) > 0)
                    <div class="d-flex mb-3">
                        <a href="{{ url('/reports/membership/export/pdf?from_date=' . request('from_date') . '&to_date=' . request('to_date')) }}" class="btn btn-danger me-2">
                            <i class="bi bi-file-earmark-pdf"></i> Export PDF
                        </a>
                        <a href="{{ url('/reports/membership/export/excel?from_date=' . request('from_date') . '&to_date=' . request('to_date')) }}" class="btn btn-success">
                            <i class="bi bi-file-earmark-excel"></i> Export Excel
                        </a>
                    </div>
                @endif
             </div>
        </div>
    <div class="card-body">
        <div class="table-responsive mt-4">
            <table class="table table-bordered table-striped datatable">
                <thead class="table-primary">
                    <tr>
                        <th>Nama Member</th>
                        <th>Kode Member</th>
                        <th>Tipe Membership</th>
                        <th>Tanggal Registrasi</th>
                        <th>Status Member</th>
                        <th>Status Expire</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($memberships as $item)
                        <tr>
                            <td>{{ $item->member->fullname }}</td>
                            <td>{{ $item->membership_number }}</td>
                            <td>{{ $item->membershipType->type }}</td>
                            <td>{{ $item->reg_date ? \Carbon\Carbon::parse($item->reg_date)->format('d-m-Y') : '-' }}</td>
                            <td>{{ ucfirst($item->exsist) }}</td>
                            <td>
                                @if ($item->expiry_date < \Carbon\Carbon::now())
                                    <span class="badge bg-danger">Expired</span>
                                @else
                                    <span class="badge bg-success">Aktif</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endisset
@endsection

@section('custom_js')
@if ($errors->any())
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            html: `{!! implode('<br>', $errors->all()) !!}`
        });
    </script>
@endif
@endsection
