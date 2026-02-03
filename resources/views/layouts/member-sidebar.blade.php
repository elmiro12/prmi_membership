@php
    use Illuminate\Support\Facades\Auth;
@endphp
<!-- Sidebar Admin -->
<nav class="navbar-vertical navbar no-border shadow-none">
  <div class="nav-scroller bg-white">
    <a class="navbar-brand fw-bold text-primary brand-wrap text-center" href="/">
        <img src="{{ \App\Helpers\AppSetting::logo() }}" alt="Logo" height="100" class="brand-logo me-2" />
        <br>{{ \App\Helpers\AppSetting::name() }}
    </a>
    <hr class="border-2 border-top border-primary">
<ul class="navbar-nav flex-column px-2" id="sideNavbar">
    <li class="nav-item">
      <a href="{{ route('member.dashboard') }}" class="nav-link text-primary {{ Request::is('member/dashboard') ? 'active rounded shadow' : '' }}">
        <i class="bi bi-speedometer2 me-2"></i><span class="sidebar-label">Dashboard</span>
      </a>
    </li>

    <li class="nav-item">
      <a href="{{ route('member.announcements') }}" class="nav-link text-primary {{ Request::is('member/pengumuman*') ? 'active rounded shadow' : '' }}">
        <i class="bi bi-megaphone-fill me-2"></i><span class="sidebar-label">Pengumuman</span>
      </a>
    </li>

    <li class="nav-item">
      <a href="{{ route('member.profile') }}" class="nav-link text-primary {{ Request::is('member/profil*') ? 'active rounded shadow' : '' }}">
        <i class="bi bi-person-circle me-2"></i><span class="sidebar-label">Profil</span>
      </a>
    </li>

    <li class="nav-item">
      <a href="{{ route('member.extension') }}" class="nav-link text-primary {{ Request::is('member/extension*') ? 'active rounded shadow' : '' }}">
        <i class="bi bi-arrow-repeat me-2"></i><span class="sidebar-label">Perpanjangan</span>
      </a>
    </li>

    <li class="nav-item">
      <a href="{{ route('member.stream') }}" class="nav-link text-primary {{ Request::is('member/stream*') ? 'active rounded shadow' : '' }}">
        <i class="bi bi-camera-video-fill me-2"></i><span class="sidebar-label">Stream Member</span>
      </a>
    </li>

    <li class="nav-item">
    <a href="{{ route('member.fixtures') }}" class="nav-link text-primary {{ Request::is('member/fixtures*') ? 'active rounded shadow' : '' }}">
        <i class="bi bi-calendar-event me-2"></i><span class="sidebar-label">Jadwal LiveStream</span>
    </a>
    </li>

    <li class="nav-item">
      <a href="{{ route('member.payment.history') }}" class="nav-link text-primary {{ Request::is('member/payment*') ? 'active rounded shadow' : '' }}">
        <i class="bi bi-cash-coin me-2"></i><span class="sidebar-label">Pembayaran Saya</span>
      </a>
    </li>
    <li class="nav-item">
        <a href="#submenu-setting" class="nav-link text-primary collapsed"
            data-bs-toggle="collapse" href="#!" data-bs-target="#submenu-setting" aria-expanded="false" aria-controls="submenu-setting" >
            <i class="bi bi-gear me-2"></i><span class="sidebar-label">Pengaturan</span>
            <i class="bi bi-chevron-down ms-auto transition toggle-icon"></i>
        </a>
        <div class="collapse" id="submenu-setting">
            <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small ps-4">
                <li class="nav-item mb-2">
                  <a href="{{ route('member.setting') }}" class="nav-link text-primary {{ Request::is('member/setting*') ? 'active rounded shadow' : '' }}">
                    <i class="bi bi-file-person me-2"></i><span class="sidebar-label">Ganti Password</span>
                  </a>
                </li>
                <li class="nav-item mb-2">
                  <a href="{{ route('download') }}" class="nav-link text-primary {{ Request::is('download') ? 'active rounded shadow' : '' }}">
                    <i class="bi bi-download me-2"></i><span class="sidebar-label">Download APK</span>
                  </a>
                </li>
            </ul>
        </div>
    </li>

    <li class="nav-item mt-4 px-2">
      <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button class="btn btn-warning w-100">
          <i class="bi bi-box-arrow-right me-2"></i><span class="sidebar-label"> Logout </span>
        </button>
      </form>
    </li>
  </ul>
    </div>
</nav>
