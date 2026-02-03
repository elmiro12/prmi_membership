@extends('layouts.base')

@section('title', 'Upload Bukti Pembayaran')

@section('content')
<div class="container">
    <form action="{{ route('member.payment.submit') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="hidden" id="paymentId" name="paymentId" value="{{ $payment->id }}">
        <div class="card shadow-sm">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Form Upload Bukti</h5>
                </div>
            <div class="card-body">
                <div class="mb-3">
                    <label for="idBank" class="form-label">Transfer ke Bank</label>
                    <select name="idBank" id="idBank" class="form-select" required>
                        <option value="">-- Pilih Bank Tujuan --</option>
                        @foreach($banks as $bank)
                            <option
                                value="{{ $bank->id }}"
                                data-nama="{{ $bank->namaBank }}"
                                data-rekening="{{ $bank->noRekening }}"
                                data-pemilik="{{ $bank->namaPemilik }}"
                            >
                                {{ $bank->namaBank }} - {{ $bank->noRekening }} a.n {{ $bank->namaPemilik }}
                            </option>
                        @endforeach
                    </select>

                    <div id="bank-info" class="mt-3" style="display: none;">
                        <p><strong>Nama Bank:</strong> <span id="namaBank"></span></p>
                        <p><strong>No. Rekening:</strong> <span id="noRekening"></span></p>
                        <p><strong>Atas Nama:</strong> <span id="namaPemilik"></span></p>
                    </div>
                    <div id="payment-info" class="mt-3">
                    @if($extension->membership)
                        <p><strong>Tipe Membership:</strong> {{ $extension->membership->membershipType->type }}</p>
                        <p><strong>Jumlah yang harus dibayar:</strong> Rp{{ number_format($extension->membership->membershipType->amount, 0, ',', '.') }}</p>
                    @else
                        <p><strong>Tipe Stream Membership:</strong> {{ $extension->streamMembership->streamType->name }}</p>
                        <p><strong>Jumlah yang harus dibayar:</strong> Rp{{ number_format($extension->streamMembership->streamType->amount, 0, ',', '.') }}</p>
                    @endif
                    </div>
                </div>

                <div class="mb-3">
                    <label for="bukti" class="form-label">Upload Bukti Pembayaran</label>
                    <input type="file" name="bukti" id="bukti" class="form-control" required>
                    <small class="text-muted">Format gambar: JPG, JPEG, PNG. Maksimal 2MB</small>
                </div>

                <div class="form-check mt-3">
                    <input class="form-check-input" type="checkbox" id="confirmTransfer">
                    <label class="form-check-label" for="confirmTransfer">
                        Saya sudah melakukan transfer ke rekening di atas.
                    </label>
                </div>
                <button type="submit" class="btn btn-success" id="submitBtn" disabled>
                    <i class="bi bi-upload"></i> Upload Pembayaran
                </button>

            </div>
        </div>
    </form>
</div>
@endsection

@section('custom_js')
<script>
    const selectBank = document.getElementById('idBank');
    const namaBank = document.getElementById('namaBank');
    const noRekening = document.getElementById('noRekening');
    const namaPemilik = document.getElementById('namaPemilik');
    const bankInfo = document.getElementById('bank-info');
    const checkbox = document.getElementById('confirmTransfer');
    const submitBtn = document.getElementById('submitBtn');

    selectBank.addEventListener('change', function() {
        const selected = this.options[this.selectedIndex];

        if (selected.value) {
            namaBank.textContent = selected.dataset.nama;
            noRekening.textContent = selected.dataset.rekening;
            namaPemilik.textContent = selected.dataset.pemilik;
            bankInfo.style.display = 'block';
        } else {
            bankInfo.style.display = 'none';
        }

        submitBtn.disabled = !checkbox.checked || !selected.value;
    });

    checkbox.addEventListener('change', function() {
        const selected = selectBank.options[selectBank.selectedIndex];
        const bankDipilih = selected && selected.value !== '';
        const centang = this.checked;

        submitBtn.disabled = !(centang && bankDipilih);
    });
    
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
