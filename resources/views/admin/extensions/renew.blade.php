@extends('layouts.base')

@section('title', 'Perpanjangan Membership')

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Form Perpanjangan Membership</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('extensions.processRenew', $extension->id) }}" method="POST">
            @csrf

            <div class="mb-3">
                <label>Nama Member</label>
                <input type="text" class="form-control" value="{{ $extension->membership->member->fullname }}" readonly>
            </div>

            <div class="mb-3">
                <label>Nomor Membership</label>
                <input type="text" class="form-control" value="{{ $extension->membership->membership_number }}" readonly>
            </div>

            <div class="mb-3">
                <label>Tipe Membership</label>
                <select name="membership_type" id="membership_type" class="form-select" required>
                    <option value="">-- Pilih Tipe Membership --</option>
                    @foreach ($membershipTypes as $type)
                        <option value="{{ $type->id }}" {{ $extension->membership->tipe_member == $type->id ? 'selected' : '' }}>
                            {{ $type->type }} - Rp{{ number_format($type->amount) }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label>Pilih Bank Pembayaran</label>
                <select name="bank_id" class="form-select" required>
                    <option value="">-- Pilih Bank --</option>
                    @foreach ($banks as $bank)
                        <option value="{{ $bank->id }}">{{ $bank->namaBank }} ({{ $bank->noRekening }} a.n {{ $bank->namaPemilik }})</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label>Jumlah Pembayaran</label>
                <input type="text" class="form-control" id="amount" readonly>
            </div>

            <button type="submit" class="btn btn-primary">Konfirmasi Perpanjangan</button>
        </form>
    </div>
</div>
@endsection

@section('custom_js')
<script>
    const membershipTypes = @json($membershipTypes);

    document.getElementById('membership_type').addEventListener('change', function () {
        const selected = this.value;
        const selectedType = membershipTypes.find(type => type.id == selected);
        document.getElementById('amount').value = selectedType ? 'Rp' + selectedType.amount.toLocaleString() : '';
    });

    // Trigger awal
    document.getElementById('membership_type').dispatchEvent(new Event('change'));
</script>
@endsection
