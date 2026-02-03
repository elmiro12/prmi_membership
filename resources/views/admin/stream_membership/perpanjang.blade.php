@extends('layouts.base')
@section('title', 'Perpanjang Stream Membership')
@section('content')

<div class="card">
    <div class="card-header">Form Perpanjangan Stream Membership</div>
    <div class="card-body">
        <form action="{{ route('stream.perpanjang.submit', $member->id) }}" method="POST">
            @csrf

            <div class="mb-3">
                <label>Nama Member</label>
                <input type="text" class="form-control" value="{{ $member->fullname }}" readonly>
            </div>

            <div class="mb-3">
                <label>Tipe Membership</label>
                <select name="idStreamType" class="form-control" required>
                    <option value="">Pilih Tipe</option>
                    @foreach($streamTypes as $type)
                        <option value="{{ $type->id }}"
                            {{ optional($member->streamMembership)->idStreamType == $type->id ? 'selected' : '' }}>
                            {{ $type->name }} - Rp {{ number_format($type->amount, 0, ',', '.') }}
                        </option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Lanjutkan Pembayaran</button>
        </form>
    </div>
</div>

@endsection
