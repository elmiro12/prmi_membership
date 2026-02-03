@csrf
<div class="mb-3">
    <label for="judul" class="form-label">Judul</label>
    <input type="text" name="judul" class="form-control" value="{{ old('judul', $announcement->judul ?? '') }}" required>
</div>
<div class="mb-3">
    <label for="deskripsi" class="form-label">Deskripsi</label>
    <textarea name="deskripsi" class="form-control" rows="2" required>{{ old('deskripsi', $announcement->deskripsi ?? '') }}</textarea>
</div>
<div class="mb-3">
    <label for="isi" class="form-label">Isi Pengumuman</label>
    <textarea name="isi" id="isi" class="form-control" rows="2" required>{{ old('isi', $announcement->isi ?? '') }}</textarea>
</div>
<div class="mb-3">
    <label for="namaFile" class="form-label">File Lampiran</label>
    <input type="file" name="namaFile" class="form-control">
    @if (!empty($announcement->namaFile))
        <small class="text-muted">File saat ini: <a href="{{ asset('uploads/pengumuman/' . $announcement->namaFile) }}" target="_blank">{{ $announcement->namaFile }}</a></small>
    @endif
</div>
<div class="form-check mb-3">
    <input class="form-check-input" type="checkbox" name="status" id="status" value="1"
        {{ old('status', $announcement->status ?? false) ? 'checked' : '' }}>
    <label class="form-check-label" for="status">
        Publish sekarang
    </label>
</div>

