<div class="mb-3">
    <label for="type" class="form-label">Nama Tipe</label>
    <input type="text" name="type" id="type" class="form-control @error('type') is-invalid @enderror" value="{{ old('type', $type->type ?? '') }}" required>
    @error('type')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
<div class="mb-3">
    <label for="amount" class="form-label">Biaya (Rp)</label>
    <input type="number" name="amount" id="amount" class="form-control @error('amount') is-invalid @enderror" value="{{ old('amount', $type->amount ?? '') }}" required>
    @error('amount')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
<div class=" row mb-3">
    <label for="merchandise" class="form-label">Pilih Merchandise :</label>
     @forelse($merchandise as $index => $merchan)
        <div class="col-md-4 p-2">
            <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" role="switch" 
                       name="merchandise[]" 
                       value="{{ $merchan->id }}" 
                       id="merchandise_{{ $index }}"
                       {{ in_array($merchan->id, $type->merchandise ?? []) ? 'checked' : '' }}>
                <label class="form-check-label" for="merchandise_{{ $index }}">
                    {{ $merchan->name }}
                </label>
            </div>
        </div>
    @empty
        <div class="col-12">
            <label class="form-label">Belum ada merchandise.</label>
        </div>
    @endforelse
    
    @error('merchandise')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>