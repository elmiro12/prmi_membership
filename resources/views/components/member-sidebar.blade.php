<!-- Sidebar Member -->
<nav id="sidebar" class="bg-white text-primary vh-100 position-fixed d-flex flex-column shadow-lg" style="width: 250px; transition: width 0.3s;">
  <div class="sidebar-header p-3 d-flex justify-content-between align-items-center border-bottom border-white shadow-sm">
    <img src="{{ \App\Helpers\AppSetting::logo() }}" alt="Logo" height="50" class="me-2">
    <span class="fs-6 fw-bold" id="sidebar-title">{{ \App\Helpers\AppSetting::name() }}</span>
  </div>

  <ul class="nav flex-column px-2 mt-3" id="sidebar-menu">

    <li class="nav-item mb-2">
      <a href="{{ route('member.dashboard') }}" class="nav-link text-white {{ Request::is('member/dashboard') ? 'active rounded shadow' : '' }}">
        <i class="bi bi-speedometer2 me-2"></i><span class="sidebar-label">Dashboard</span>
      </a>
    </li>

    <li class="nav-item mb-2">
      <a href="{{ route('member.announcements') }}" class="nav-link text-white {{ Request::is('member/pengumuman*') ? 'active rounded shadow' : '' }}">
        <i class="bi bi-megaphone-fill me-2"></i><span class="sidebar-label">Pengumuman</span>
      </a>
    </li>

    <li class="nav-item mb-2">
      <a href="{{ route('member.profile') }}" class="nav-link text-white {{ Request::is('member/profil*') ? 'active rounded shadow' : '' }}">
        <i class="bi bi-person-circle me-2"></i><span class="sidebar-label">Profil</span>
      </a>
    </li>

    <li class="nav-item mb-2">
      <a href="{{ route('member.extension') }}" class="nav-link text-white {{ Request::is('member/extension*') ? 'active rounded shadow' : '' }}">
        <i class="bi bi-arrow-repeat me-2"></i><span class="sidebar-label">Perpanjangan</span>
      </a>
    </li>

    <li class="nav-item mb-2">
      <a href="{{ route('member.stream') }}" class="nav-link text-white {{ Request::is('member/stream*') ? 'active rounded shadow' : '' }}">
        <i class="bi bi-camera-video-fill me-2"></i><span class="sidebar-label">Stream Member</span>
      </a>
    </li>

    <li class="nav-item mb-2">
    <a href="{{ route('member.fixtures') }}" class="nav-link {{ Request::is('member/fixtures*') ? 'active rounded shadow' : '' }}">
        <i class="bi bi-calendar-event me-2"></i><span class="sidebar-label">Jadwal LiveStream</span>
    </a>
    </li>

    <li class="nav-item mb-2">
      <a href="{{ route('member.payment.history') }}" class="nav-link text-white {{ Request::is('member/payment*') ? 'active rounded shadow' : '' }}">
        <i class="bi bi-cash-coin me-2"></i><span class="sidebar-label">Pembayaran Saya</span>
      </a>
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
</nav>
