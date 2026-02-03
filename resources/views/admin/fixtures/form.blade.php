@csrf
<div class="mb-3">
    <label>Club Home</label>
        @foreach($clubs as $club)
            @if($club->is_primary)
                <input type="hidden" name= "id_club_home" value="{{ $club->id }}"/>
                <input type="text" class="form-control" value="{{ $club->name }}" readonly>
            @endif
        @endforeach
    </select>
</div>

<div class="mb-3">
    <label>Club Away</label>
    <select name="id_club_away" class="form-control" required>
        <option value="">-- Pilih --</option>
        @foreach($clubs as $club)
        @if(!$club->is_primary)
        <option value="{{ $club->id }}" {{ (old('id_club_away', $fixture->id_club_away ?? '') == $club->id) ? 'selected' : '' }}>
            {{ $club->name }}
        </option>
        @endif
        @endforeach
    </select>
</div>

<div class="mb-3">
    <label>Tanggal Pertandingan</label>
    <input type="date" name="match_date" class="form-control"
    value="{{ old('match_date', $fixture->match_date ?? date('Y-m-d')) }}"
    min="{{date('Y-m-d')}}" required>
</div>

<div class="mb-3">
    <label>Waktu Pertandingan</label>
    <input type="time" name="match_time" class="form-control" value="{{ old('match_time', $fixture->match_time ?? '') }}" required>
    WIT
</div>

<div class="mb-3">
    <label>Venue</label>
    <input type="text" name="venue" class="form-control" value="{{old('venue', $fixture->venue ?? '')}}" required>
</div>

<div class="mb-3">
    <label>Embed URL Live Stream (opsional)</label>
    <input type="text" name="embed_url" class="form-control" value="{{ old('embed_url', $fixture->embed_url ?? '') }}">
</div>
