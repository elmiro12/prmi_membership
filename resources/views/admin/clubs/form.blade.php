<div class="mb-3">
    <label for="nama" class="form-label">Nama Club</label>
    <input type="text" name="nama" class="form-control" value="{{ old('nama', $club->name ?? '') }}" required>
</div>
<div class="mb-3">
    <label for="logo" class="form-label">Logo</label>
    <input type="file" name="logo" class="form-control">
    @if(!empty($club->logo))
        <img src="{{ asset('uploads/logo_club/'.$club->logo) }}" width="100" class="mt-2">
    @endif
</div>
@if (!$primaryExists)
    <div class="form-check mb-3">
        <input class="form-check-input" type="checkbox" name="is_primary" value="1" id="is_primary">
        <label class="form-check-label" for="is_primary">
            Jadikan sebagai klub utama
        </label>
    </div>
@endif
