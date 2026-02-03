@php
    use Illuminate\Support\Facades\Auth;
@endphp
<!-- Sidebar Admin -->
<nav class="navbar-vertical navbar no-border shadow-none bg-white-50">
  <div class="nav-scroller">
    <a class="navbar-brand fw-bold text-primary brand-wrap text-center" href="/">
        <img src="{{ \App\Helpers\AppSetting::logo() }}" alt="Logo" height="100" class="brand-logo me-2" />
        <br>{{ \App\Helpers\AppSetting::name() }}
    </a>
     <hr class="border-2 border-top border-primary">
  <ul class="navbar-nav flex-column px-2" id="sideNavbar">
    <li class="nav-item">
      <a href="/dashboard" class="nav-link text-primary {{ Request::is('dashboard') ? 'active rounded shadow' : '' }}">
        <i class="bi bi-speedometer2 me-2"></i><span class="sidebar-label">Dashboard</span>
      </a>
    </li>
    <li class="nav-item">
      <a href="/announcement" class="nav-link text-primary {{ (Request::is('announcement') ||  Request::is('announcement/*'))? 'active rounded shadow' : '' }}">
        <i class="bi bi-megaphone-fill me-2"></i><span class="sidebar-label">Pengumuman</span>
      </a>
    </li>
    <li class="nav-item">
      <a href="/members" class="nav-link text-primary {{ Request::is('members') ? 'active rounded shadow' : '' }}">
        <i class="bi bi-people-fill me-2"></i><span class="sidebar-label">Members</span>
      </a>
    </li>
    <li class="nav-item">
      <a href="#submenu-prmi" class="nav-link text-primary collapsed"
        data-bs-toggle="collapse" href="#submenu-prmi" data-bs-target="#submenu-prmi" aria-expanded="false" aria-controls="submenu-prmi" >
        <i class="bi bi-award-fill me-2"></i><span class="sidebar-label">Membership PRMI</span>
        <i class="bi bi-chevron-down ms-auto transition toggle-icon"></i>
      </a>
      <div class="collapse" id="submenu-prmi">
        <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small ps-4">
            <li class="nav-item">
              <a href="/extension" class="nav-link text-primary {{ ( Request::is('extension') || Request::is('*/renew') )  ? 'active rounded shadow' : '' }}">
                <i class="bi bi-card-checklist me-2"></i><span class="sidebar-label">Daftar Member PRMI</span>
              </a>
            </li>
            <li class="nav-item">
                <a href="/verifikasi-membership" class="nav-link text-primary {{ Request::is('verifikasi-membership') ? 'active rounded shadow' : '' }}">
                    <i class="bi bi-patch-check-fill me-2"></i> Verifikasi Membership
                </a>
            </li>
            @if(Auth::user()->tipeUser == 'super_admin')
            <li class="nav-item">
            <a href="/membership-types" class="nav-link text-primary {{ Request::is('membership-types') ? 'active rounded shadow' : '' }}">
                <i class="bi bi-tags-fill me-2"></i><span class="sidebar-label">Tipe Membership</span>
            </a>
            </li>
            @endif
            <li class="nav-item">
            <a href="/merchandise" class="nav-link text-primary {{ Request::is('merchandise') ? 'active rounded shadow' : '' }}">
                <i class="bi bi-bookmark-star-fill me-2"></i><span class="sidebar-label">Merchandise</span>
            </a>
            </li>
        </ul>
      </div>
    </li>

    <li class="nav-item">
    <a class="nav-link text-primary collapsed"
        data-bs-toggle="collapse" href="#submenu-stream" data-bs-target="#submenu-stream" aria-expanded="false" aria-controls="submenu-stream">
        <i class="bi bi-camera-video-fill me-2"></i>
        <span class="sidebar-label">Membership Stream</span>
        <i class="bi bi-chevron-down ms-auto transition toggle-icon"></i>
    </a>
    <div class="collapse" id="submenu-stream">
        <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small ps-4">
        <li class="nav-item mb-2">
            <a href="/stream-membership" class="nav-link text-primary {{ Request::is('stream-membership')  ? 'active rounded shadow' : '' }}">
                <i class="bi bi-camera-video me-2"></i><span class="sidebar-label">Membership Stream</span>
            </a>
            </li>
        <li><a href="{{ route('stream-type.index') }}" class="nav-link text-primary {{ Request::is('stream-type') ? 'active rounded shadow' : '' }}">
            <i class="bi bi-tags-fill me-2"></i><span class="sidebar-label"> Tipe Stream</span></a></li>
        </ul>
    </div>
    </li>
    @if(Auth::user()->tipeUser == 'super_admin')
    <li class="nav-item">
    <a href="/clubs" class="nav-link text-primary {{ Request::is('clubs*') ? 'active rounded shadow' : '' }}">
        <i class="bi bi-shield-fill me-2"></i><span class="sidebar-label">Manajemen Klub</span>
    </a>
    </li>
    @endif
    <li class="nav-item">
    <a href="/fixtures" class="nav-link text-primary {{ Request::is('fixtures*') ? 'active rounded shadow' : '' }}">
        <i class="bi bi-calendar-event me-2"></i><span class="sidebar-label">Jadwal Pertandingan</span>
    </a>
    </li>
    <li class="nav-item">
    <a class="nav-link text-primary collapsed" href="#akunPembayaran"
    data-bs-toggle="collapse" data-bs-target="#akunPembayaran" aria-expanded="false" aria-controls="akunPembayaran">
        <i class="bi bi-credit-card-fill me-2"></i>
        <span class="sidebar-label">Akun Pembayaran</span>
        <i class="bi bi-chevron-down ms-auto transition toggle-icon"></i>
    </a>
    <div class="collapse" id="akunPembayaran">
        <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small ps-4">
        @if(Auth::user()->tipeUser == 'super_admin')
        <li><a href="{{ route('banks.index') }}" class="nav-link text-primary {{ Request::is('banks*') ? 'active rounded shadow' : '' }}">
            <i class="bi bi-bank me-2"></i><span class="sidebar-label"> Bank</span></a></li>
        @endif
        <li><a href="{{ route('payments.index') }}" class="nav-link text-primary {{ Request::is('payments*') ? 'active rounded shadow' : '' }}">
            <i class="bi bi-cash-coin me-2"></i><span class="sidebar-label"> Pembayaran</span></a></li>
        </ul>
    </div>
    </li>

    <li class="nav-item">
        <a class="nav-link text-primary collapsed" href="#reportSubmenu"
            data-bs-toggle="collapse" data-bs-target="#reportSubmenu" aria-expanded="false" aria-controls="reportSubmenu">
            <i class="bi bi-bar-chart-line me-2"></i>
            <span class="sidebar-label">Laporan</span>
            <i class="bi bi-chevron-down ms-auto transition toggle-icon"></i>
        </a>
        <div class="collapse" id="reportSubmenu">
            <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                <li><a href="{{ url('/reports/membership') }}" class="nav-link text-primary {{ (Request::is('reports/membership') ||  Request::is('reports/membership/*'))? 'active rounded shadow' : '' }}">
                    <span class="sidebar-label"><i class="bi bi-clipboard-data me-2"></i> Laporan Membership</span></a></li>
                <li><a href="{{ url('/reports/income') }}" class="nav-link text-primary {{ (Request::is('reports/income') || Request::is('reports/income/*')) ? 'active rounded shadow' : '' }}" >
                    <i class="bi bi-cash me-2"></i><span class="sidebar-label"> Laporan Pendapatan</span></a></li>
            </ul>
        </div>
    </li>
    @if(Auth::user()->tipeUser == 'super_admin')
    <li class="nav-item">
      <a href="/users" class="nav-link text-primary {{ Request::is('users') ? 'active rounded shadow' : '' }}">
        <i class="bi bi-person-fill me-2"></i><span class="sidebar-label"> Users Member</span>
      </a>
    </li>
    @endif
    <li class="nav-item">
      <a href="/settings" class="nav-link text-primary {{ Request::is('settings') ? 'active rounded shadow' : '' }}">
        <i class="bi bi-gear-fill me-2"></i><span class="sidebar-label"> Pengaturan</span>
      </a>
    </li>
    <li class="nav-item mt-3">
      <form action="/logout" method="POST">
        @csrf
        <button class="btn btn-warning w-100">
          <i class="bi bi-box-arrow-right me-2"></i><span class="sidebar-label">Logout</span>
        </button>
      </form>
    </li>
  </ul>
  </div>
</nav>
