<!-- resources/views/layout/dashui.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link rel="manifest" href="{{ asset('manifest.json') }}">
  <meta name="theme-color" content="#624BFF">
  @include('layouts.partials.dashui-head')
  @yield('custom_css')
</head>
<body>
  <div id="db-wrapper" class="fixed-bg-layer min-vh-100">
    @include('layouts.partials.dashui-sidebar')
    <div id="page-content" class="flex-grow-1 min-vh-100">
      @include('layouts.partials.dashui-header')
      <main class="main-content flex-fill" id="main-content">
        <div class="card bg-white-50 w-100 mb-4">
            <div class="card-header bg-primary d-flex justify-content-between align-items-center">
                <h4 class="page-title text-white">@yield('title')</h4>
                <div class="d-flex justify-content-end">
                    @yield('card-action')
                </div>
            </div>
            <div class="card-body">
                @yield('content')
            </div>
            <div class="card-footer d-flex justify-content-between align-items-center">
                @yield('card-footer-action')
                <div class="d-flex justify-content-start align-items-center">
                    <a href="{{ url()->previous() }}" class="btn btn-secondary btn-sm text-white">
                        <i class="bi bi-arrow-left"></i> Kembali
                    </a>
                    <a href="/" class="btn btn-primary btn-sm text-white ms-2">
                        <i class="bi bi-house-fill"></i> Dashboard
                    </a>
                </div>
            </div>
        </div>
              @include('layouts.partials.dashui-footer')
      </main>
    </div>
  </div>
  @include('layouts.partials.dashui-scripts')
  @yield('custom_js')
</body>
</html>
