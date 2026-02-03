@extends('layouts.base')

@section('title', 'Daftar Pembayaran Saya')

@section('content')
@if($payments->isEmpty())
    <div class="alert alert-info">Belum ada pembayaran yang tercatat.</div>
@else
    <div class="table-responsive">
        <table class="table table-bordered align-middle datatable">
            <thead class="table-primary">
                <tr>
                    <th>Kode Pembayaran</th>
                    <th>Bank Tujuan</th>
                    <th>Jumlah</th>
                    <th>Tipe Membership</th>
                    <th>Status</th>
                    <th>Bukti</th>
                    <th>Tanggal</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($payments as $pay)
                <tr>
                    <td>{{ $pay->kode }}</td>
                    <td>
                        {{ $pay->bank->namaBank }}<br>
                        {{ $pay->bank->noRekening }}<br>
                        a.n {{ $pay->bank->namaPemilik }}
                    </td>
                    @if ($pay->extension->membership)
                        <td>
                            Rp. {{ number_format($pay->extension->membership->membershipType->amount, 0, ',', '.') }}
                        </td>
                        <td>
                            {{ $pay->extension->membership->membershipType->type }}
                        </td>
                    @elseif($pay->extension->streamMembership)
                        <td>
                            Rp. {{ number_format($pay->extension->streamMembership->streamType->amount, 0, ',', '.') }}
                        </td>
                        <td>
                            {{ $pay->extension->streamMembership->streamType->name }}
                        </td>
                    @endif
                    <td>
                        @if(is_null($pay->status))
                            <span class="badge bg-warning text-dark">Menunggu Verifikasi</span>
                        @elseif($pay->status)
                            <span class="badge bg-success">Diterima</span>
                        @else
                            <span class="badge bg-danger">Tidak Diterima</span>
                        @endif
                    </td>
                    <td>
                        @if(is_null($pay->bukti) && is_null($pay->status))
                            <a href="{{ route('member.payment.form', $pay->id) }}" class="btn btn-sm btn-primary">
                                Upload Pembayaran
                            </a>
                        @else
                        <a href="{{ asset('uploads/bukti/' . $pay->bukti) }}" target="_blank">
                            <img src="{{ asset('uploads/bukti/' . $pay->bukti) }}" width="60" class="img-thumbnail">
                        </a>
                        @endif
                    </td>
                    <td>@tanggalIndo($pay->created_at)</td>
                    <td>
                        <form method="POST" action="{{ route('member.payment.destroy', $pay->id) }}" class="form-delete">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">
                                    <i class="bi bi-trash"></i>
                                </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endif
@endsection
@section('custom_js')
<script>
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
</script>
@endsection
