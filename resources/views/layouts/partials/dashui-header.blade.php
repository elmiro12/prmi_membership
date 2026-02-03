@php
    use Illuminate\Support\Facades\Auth;

    $profilPic = 'uploads/';
    $username = 'Admin';
    $linkProfil = '/settings';

    if(Auth::user()->tipeUser != 'member'){
        $profilPic = Auth::user()?->photo ? 'uploads/user_photos/'.Auth::user()->photo : 'images/default-male.png';
    }else{
        $member = Auth::user()->member;
        $profilPic = 'uploads/member_photos/' . $member->photo;
        if (!$member->photo || $member->photo === 'default.jpg') {
            $profilPic = $member->gender === 'Female'
                ? 'images/default-female.png'
                : 'images/default-male.png';
        }
        $username = $member->fullname;
        $linkProfil = route('member.setting');
    }
@endphp
<div class="header">
  <!-- navbar -->
  <nav class="navbar-classic navbar navbar-expand-lg bg-white-no-blur">
    <a id="nav-toggle" href="#" class="h4 text-primary"><i data-feather="menu" class="nav-icon me-2 icon-xs"></i>
        {{ \App\Helpers\AppSetting::name() }}
    </a>
    <div class="ms-lg-3 d-none d-md-none d-lg-block">
      <!-- Form -->
    </div>
    <!--Navbar nav -->
    <ul class="navbar-nav navbar-right-wrap ms-auto d-flex nav-top-wrap">
      <!-- List -->
      <li class="dropdown ms-2">
        <a class="rounded-circle" href="#" role="button" id="dropdownUser"
          data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <div class="avatar avatar-md avatar-indicators avatar-online">
            <img alt="avatar" src="{{ asset($profilPic) }}" class="rounded-circle" />
          </div>
        </a>
        <div class="dropdown-menu dropdown-menu-end"
          aria-labelledby="dropdownUser">
          <div class="px-4 pb-0 pt-2">
            <div class="lh-1 ">
              <h5 class="mb-1">{{ $username }}</h5>
            </div>
            <div class=" dropdown-divider mt-3 mb-2"></div>
          </div>
          <ul class="list-unstyled">
            <li>
              <a class="dropdown-item" href="{{ $linkProfil }} ">
                <i class="bi bi-cogs-fill me-2"
                  data-feather="settings"></i>Pengaturan
              </a>
            </li>
            <li>
              <a class="dropdown-item" href="{{ route('download') }} ">
                <i class="me-2" data-feather="download"></i>Download APK
              </a>
            </li>
            <li>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
              <button class="dropdown-item" href="{{ route('logout') }}">
                <i class="me-2"
                  data-feather="power"></i>Log Out
              </button>
              </form>
            </li>
          </ul>
        </div>
      </li>
    </ul>
  </nav>
</div>
