@extends('layouts.base')
@section('title', 'Verifikasi Membership')

@section('content')
<div class="container mt-4">
    <div class="table-responsive">
        <table class="table table-bordered table-hover datatable">
            <thead class="table-light">
                <tr>
                    <th>Nama Member</th>
                    <th>Kode Membership</th>
                    <th>Reg. Date</th>
                    <th>Expiry Date</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($memberships as $item)
                <tr>
                    <td>{{ $item->member->fullname }}</td>
                    <td>{{ $item->membership_number }}</td>
                    <td>
                        @if($item->reg_date)
                            @tanggalIndo($item->reg_date)
                        @else
                            -
                        @endif
                    </td>
                    <td>
                        @if($item->expiry_date)
                            @tanggalIndo($item->expiry_date)
                        @else
                            -
                        @endif
                    </td>
                    <td>
                        @if($item->expiry_date && \Carbon\Carbon::parse($item->expiry_date)->isPast())
                            <span class="badge bg-danger">Expired</span>
                        @else
                            <span class="badge bg-success">Aktif</span>
                        @endif
                    </td>
                    <td>
                        <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#verifyModal{{ $item->id }}">
                            Verifikasi
                        </button>
                    </td>
                </tr>

                <!-- Modal -->
                <div class="modal fade" id="verifyModal{{ $item->id }}" tabindex="-1" aria-labelledby="verifyModalLabel{{ $item->id }}" aria-hidden="true">
                    <div class="modal-dialog">
                        <form action="{{ route('verify-membership.update', $item->id) }}" method="POST">
                            @csrf
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="verifyModalLabel{{ $item->id }}">Verifikasi Membership - {{ $item->member->fullname }}</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">

                                    <div class="mb-3">
                                        <label for="membership_number{{ $item->id }}" class="form-label">Kode Membership</label>
                                        <input type="text" class="form-control" name="membership_number" id="membership_number{{ $item->id }}" value="{{ $item->membership_number }}" required>
                                    </div>

                                    <div class="form-check form-switch mb-3">
                                        <input class="form-check-input verify-toggle" type="checkbox" name="verify" id="verifySwitch{{ $item->id }}" data-id="{{ $item->id }}">
                                        <label class="form-check-label" for="verifySwitch{{ $item->id }}">Aktifkan Verifikasi</label>
                                    </div>

                                    <div id="verifyFields{{ $item->id }}" style="display: none;">
                                        <div class="mb-3">
                                            <label for="reg_date{{ $item->id }}" class="form-label">Tanggal Registrasi</label>
                                            <input type="date" class="form-control" name="reg_date" id="reg_date{{ $item->id }}" value="{{ $item->reg_date }}">
                                        </div>
                                        <div class="mb-3">
                                            <label for="expiry_date{{ $item->id }}" class="form-label">Tanggal Expired</label>
                                            <input type="date" class="form-control" name="expiry_date" id="expiry_date{{ $item->id }}" value="{{ $item->expiry_date }}">
                                        </div>
                                    </div>

                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-success">Simpan</button>
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

@section('custom_js')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.verify-toggle').forEach(function(toggle) {
            toggle.addEventListener('change', function() {
                const id = this.dataset.id;
                const fields = document.getElementById('verifyFields' + id);
                fields.style.display = this.checked ? 'block' : 'none';
            });
        });
    });
</script>
@if (session('success'))
<script>
    Swal.fire({
        icon: 'success',
        title: 'Berhasil!',
        text: '{{ session("success") }}',
        showConfirmButton: false,
        timer: 2000
    });
</script>
@endif

@if ($errors->any())
<script>
    Swal.fire({
        icon: 'error',
        title: 'Terjadi kesalahan!',
        html: `{!! implode('<br>', $errors->all()) !!}`,
    });
</script>
@endif
<script>
    $(document).on('shown.bs.modal', function (e) {
        var $modal = $(e.target);
        $('body').append($modal);
    });
</script>
@endsection
