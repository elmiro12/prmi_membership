@extends('layouts.base') {{-- Sesuaikan layout --}}

@section('title', 'Laporan Pendapatan Membership')

@section('content')
<div class="container mt-4">
    <form method="GET" class="row g-3 mb-3">
        <div class="col-md-3">
            <label>Dari Tanggal</label>
            <input type="date" name="from_date" class="form-control" value="{{ $from }}">
        </div>
        <div class="col-md-3">
            <label>Sampai Tanggal</label>
            <input type="date" name="to_date" class="form-control" value="{{ $to }}">
        </div>
        <div class="col-md-3 align-self-end">
            <button class="btn btn-primary" type="submit">Filter</button>
        </div>
        <div class="col-md-3 align-self-end text-end">
            <a href="{{ route('report.income.pdf', ['from_date' => $from, 'to_date' => $to]) }}" class="btn btn-danger">Export PDF</a>
        </div>
    </form>
    <div class="table-responsive">
        <h4>Data Pendapatan Membership</h4>
        <table class="table table-bordered mb-2">
            <thead class="table-light">
                <tr>
                    <th>No</th>
                    <th>Nama Tipe Membership</th>
                    <th>Jumlah Member</th>
                    <th>Total Pendapatan</th>
                </tr>
            </thead>
            <tbody>
                @foreach($reportDataMembership as $i => $item)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $item['name'] }}</td>
                    <td>{{ $item['count'] }}</td>
                    <td>Rp {{ number_format($item['total'], 0, ',', '.') }}</td>
                </tr>
                @endforeach
                <tr class="fw-bold bg-light">
                    <td colspan="3" class="text-end">Total Membership</td>
                    <td>Rp {{ number_format($totalMembership, 0, ',', '.') }}</td>
                </tr>
            </tbody>
        </table>
        <h4 class="mt-2">Data Pendapatan Stream</h4>
        <table class="table table-bordered mb-2">
            <thead class="table-light">
                <tr>
                    <th>No</th>
                    <th>Nama Tipe Stream</th>
                    <th>Jumlah Member</th>
                    <th>Total Pendapatan</th>
                </tr>
            </thead>
            <tbody>
                @foreach($reportDataStream as $i => $item)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $item['name'] }}</td>
                    <td>{{ $item['count'] }}</td>
                    <td>Rp {{ number_format($item['total'], 0, ',', '.') }}</td>
                </tr>
                @endforeach
                <tr class="fw-bold bg-light">
                    <td colspan="3" class="text-end">Total Stream</td>
                    <td>Rp {{ number_format($totalStream, 0, ',', '.') }}</td>
                </tr>
                <tr class="fw-bold bg-light">
                    <td colspan="3" class="text-end">Grand Total (Membership + Stream)</td>
                    <td>Rp {{ number_format($grandTotal, 0, ',', '.') }}</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
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
