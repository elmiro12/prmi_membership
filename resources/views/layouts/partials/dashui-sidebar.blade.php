@php
    use Illuminate\Support\Facades\Auth;
@endphp
<nav id="sidebar" class="vh-100 position-fixed flex-column shadow-none" style="width: 250px; min-height: 100vh;">
    @if(Auth::user()->tipeUser == 'admin' || Auth::user()->tipeUser == 'super_admin')
        @include('layouts.sidebar')
    <!-- Sidebar Admin -->
    @else
        @include('layouts.member-sidebar')
    @endif
</nav>

