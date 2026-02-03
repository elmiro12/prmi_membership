<form action="{{ isset($bank) ? route('banks.update', $bank->id) : route('banks.store') }}" method="POST" id="addEditForm">
    @csrf
    @if(isset($bank))
        @method('PUT')
    @endif
    <div class="mb-3">
        <label for="namaBank" class="form-label">Nama Bank</label>
        <input type="text" class="form-control" name="namaBank" value="{{ old('namaBank', $bank->namaBank ?? '') }}" required>
    </div>

    <div class="mb-3">
        <label for="noRekening" class="form-label">No. Rekening</label>
        <input type="text" class="form-control" name="noRekening" value="{{ old('noRekening', $bank->noRekening ?? '') }}" required>
    </div>

    <div class="mb-3">
        <label for="namaPemilik" class="form-label">Nama Pemilik</label>
        <input type="text" class="form-control" name="namaPemilik" value="{{ old('namaPemilik', $bank->namaPemilik ?? '') }}" required>
    </div>

    <div class="mb-3">
        <label for="statusAktif" class="form-label">Status Aktif</label>
        <select name="statusAktif" class="form-select" required>
            <option value="1" {{ (old('statusAktif', $bank->statusAktif ?? '') == 1) ? 'selected' : '' }}>Aktif</option>
            <option value="0" {{ (old('statusAktif', $bank->statusAktif ?? '') == 0) ? 'selected' : '' }}>Tidak Aktif</option>
        </select>
    </div>
</form>
