@extends('layouts.base')

@section('title', 'Form Perpanjangan Membership')

@section('content')
<div class="container">
    <form action="{{ route('member.extension.submit') }}" method="POST">
        @csrf
        <div class="card shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Form Pengajuan Membership</h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label for="membership_number" class="form-label">Nomor Membership</label>
                    <input type="text" readonly class="form-control" value="{{ $membership->membership_number }}">
                </div>

                <div class="mb-3">
                    <label for="reg_date" class="form-label">Tanggal Registrasi</label>
                    <input type="text" readonly class="form-control" value="@tanggalIndo($reg_date)">
                </div>

                <div class="mb-3">
                    <label for="expiry_date" class="form-label">Tanggal Expired Baru</label>
                    <input type="text" readonly class="form-control" value="@tanggalIndo($expiry_date)">
                </div>
                
                @php
                    // Kirim data tipe membership sebagai JSON ke JS
                    $typesJson = $types->keyBy('id')->toJson();
                @endphp

                <div class="mb-3">
                    <label for="tipe_member" class="form-label">Tipe Membership Baru</label>
                    <select name="tipe_member" id="tipe_member" class="form-select" required>
                        <option value="">-- Pilih Tipe Membership --</option>
                        @foreach($types as $type)
                            <option value="{{ $type->id }}"
                                {{ $type->id == $membership->tipe_member ? 'selected' : '' }}>
                                {{ $type->type }} - Rp{{ number_format($type->amount, 0, ',', '.') }}

                            </option>
                        @endforeach
                    </select>
                    <div id="merchandise-list" class="mb-3"></div>
                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-arrow-repeat"></i> Lanjutkan Perpanjangan
                </button>
            </div>
        </div>
    </form>
</div>
@endsection

@section('custom_js')
<script>
    document.addEventListener("DOMContentLoaded", function() {
        //update merhcandise
        const types = {!! $typesJson !!}; // data dari Laravel
        const allMerchandise = @json($merchandise); // semua merchandise
    
        const select = document.getElementById('tipe_member');
        const merchListDiv = document.getElementById('merchandise-list');
    
        select.addEventListener('change', function () {
            const selectedType = this.value;
            merchListDiv.innerHTML = ''; // kosongkan dulu
    
            if (!selectedType || !types[selectedType]?.merchandise?.length) {
                merchListDiv.innerHTML = '<div class="alert alert-warning">Tidak ada merchandise untuk tipe ini.</div>';
                return;
            }
    
            const merchIds = types[selectedType].merchandise.map(String); // pastikan string untuk pencocokan
            const tipe = types[selectedType].type;
            const filteredMerch = allMerchandise.filter(m => merchIds.includes(String(m.id)));
    
            if (filteredMerch.length === 0) {
                merchListDiv.innerHTML = '<div class="alert alert-warning">Merchandise tidak ditemukan.</div>';
                return;
            }
    
            const listItems = filteredMerch.map(m => `<div class="col-md-4"><span class="badge bg-success">${m.name}</span></div>`).join('<br>');
            merchListDiv.innerHTML = `<div class="card mt-3">
                                        <div class="card-header bg-primary text-white">
                                            <label for='merchan'>Merchandise ${tipe} : </label>
                                        </div>
                                        <div class="card-body bg-white">
                                            <div class='row'>
                                                ${listItems}
                                            </div>
                                        </div>
                                      </div>`;
        });
        select.dispatchEvent(new Event('change'));
    });
</script>
@endsection
