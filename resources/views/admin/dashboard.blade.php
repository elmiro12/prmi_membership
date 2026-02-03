@extends('layouts.base')

@section('title', 'Hai, Selamat Datang Admin !')


@section('content')
<div class="container-fluid">
    <div class="row">

        {{-- Informasi Kartu --}}
        @php
            $cards = [
                ['label' => 'Total Member', 'value' => $totalMembers, 'icon' => 'people-fill', 'bg' => 'primary'],
                ['label' => 'Member Aktif', 'value' => $totalAktifMembers, 'icon' => 'person-check-fill', 'bg' => 'success'],
                ['label' => 'Tipe Membership', 'value' => $totalMembershipTypes, 'icon' => 'award-fill', 'bg' => 'secondary'],
                ['label' => 'Total Perpanjang', 'value' => $totalExtensions, 'icon' => 'arrow-repeat', 'bg' => 'info'],
                ['label' => 'Total Penghasilan', 'value' => 'Rp ' . number_format($totalIncome, 0, ',', '.'), 'icon' => 'cash-coin', 'bg' => 'warning text-dark'],
                ['label' => 'Bank Aktif', 'value' => $totalActiveBanks, 'icon' => 'bank', 'bg' => 'dark'],
                ['label' => 'Pengumuman Aktif', 'value' => $totalAnnouncements, 'icon' => 'megaphone-fill', 'bg' => 'light text-dark'],
            ];
        @endphp

        @foreach ($cards as $card)
        <div class="col-md-3 mb-4">
            <div class="card bg-{{ $card['bg'] }} shadow-sm h-100">
                <div class="card-body d-flex align-items-center">
                    <i class="bi bi-{{ $card['icon'] }} fs-1 me-3 {{ Str::contains($card['bg'], 'text-dark') ? '' : 'text-white' }}"></i>
                    <div>
                        <h6 class="mb-1 {{ Str::contains($card['bg'], 'text-dark') ? '' : 'text-white' }}">{{ $card['label'] }}</h6>
                        <h4 class="mb-0 {{ Str::contains($card['bg'], 'text-dark') ? '' : 'text-white' }}">{{ $card['value'] }}</h4>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Tren Pendapatan per Bulan ({{ now()->year }})</h5>
            </div>
            <div class="card-body">
                <canvas id="pendapatanChart" height="100"></canvas>
            </div>
    </div>
    {{-- Tabel Pengumuman --}}
    <div class="card mb-4">
    <div class="card-header bg-primary text-white">
        <strong>Pengumuman Terbaru</strong>
    </div>
    <div class="card-body">
        @forelse($latestAnnouncements as $announcement)
            <div class="mb-3">
                <h5 class="mb-1">{{ $announcement->judul }}</h5>
                <p class="mb-1">{{ $announcement->deskripsi }}</p>
                @if($announcement->namaFile)
                    <a href="{{ asset('uploads/pengumuman/' . $announcement->namaFile) }}"
                       class="btn btn-sm btn-outline-primary" target="_blank">
                        <i class="bi bi-download me-1"></i> Download File
                    </a>
                @endif
            </div>
            <hr>
        @empty
            <p class="text-muted">Belum ada pengumuman terbaru.</p>
        @endforelse
    </div>
</div>

    {{-- Tabel Member Baru --}}
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <strong>Member Baru Bergabung (7 Hari Terakhir)</strong>
        </div>
        <div class="card-body p-0 table-wrapper">
            <table class="table mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Nama</th>
                        <th>Kode Member</th>
                        <th>Tipe Membership</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($recentMembers as $member)
                        <tr>
                            <td>{{ $member->nama }}</td>
                            <td>{{ $member->membership_number }}</td>
                            <td>{{ $member->tipe }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center text-muted">Belum ada member baru minggu ini</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section('custom_js')
<script>
    const ctx = document.getElementById('pendapatanChart').getContext('2d');
    const pendapatanChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($labels) !!},
            datasets: [{
                label: 'Total Pendapatan (Rp)',
                data: {!! json_encode($data) !!},
                backgroundColor: 'rgba(54, 162, 235, 0.7)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1,
                borderRadius: 6,
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return 'Rp ' + value.toLocaleString();
                        }
                    }
                }
            }
        }
    });
</script>
@endsection
