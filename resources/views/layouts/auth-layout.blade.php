<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="manifest" href="{{ asset('manifest.json') }}">
    <title>@yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    
    <link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>
    <style>
        body {
            background-color: #f0f8ff;
            font-family: 'Poppins';
            background-image: url('{{\App\Helpers\AppSetting::webbg()}}');
        }
        .box-area {
          width: 100%;
          max-width: 930px;
          border-radius: 2rem; /* Rounded sudut */
          overflow: hidden; /* Biar rounded rapi kalau ada bg */
        }
        .logo-img {
          max-width: 200px; /* default */
        }
        .bg-box{
          background-image: url('uploads/webbg/bg-logins.jpg');
          background-size: cover;
        }
        .bg-blue-50 {
          background-color: rgba(0, 0, 255, 0.7);
        }
        .bg-white-50 {
          background-color: rgba(255, 255, 255, 0.5);
        }
        .left-box {
          border-start-start-radius: 2em;
          border-end-start-radius: 2em;
          padding: 5rem; /* default */
        }
        .right-box{
          border-start-end-radius: 2em;
          border-end-end-radius: 2em;    
        }
        @media (max-width: 768px) {
          .logo-img {
            max-width: 125px; /* di HP, logo mengecil */
          }
          .left-box {
            border-end-start-radius: 0;
            border-start-end-radius: 2em;
            padding: 1.5rem; /* di HP, padding mengecil */
          }
          .right-box{
            border-start-end-radius: 0;
            border-end-start-radius: 2em;
          }
        }
    </style>
</head>
<body>
<div class="container d-flex justify-content-center align-items-center min-vh-100">
    <div class="row g-0 box-area shadow bg-box">    
        <div class="col-12 col-md-6 text-center left-box bg-white-50">
            <div class="featured-image">
                <img class="img-fluid logo-img" src="{{ \App\Helpers\AppSetting::logo() }}" alt="Logo">
            </div>
              <!-- Desktop version -->
              <h2 class="text-bold mt-2 text-primary text-wrap text-center d-none d-md-block">
                {{ \App\Helpers\AppSetting::name() }}
              </h2>
              <!-- Mobile version -->
              <span class="fw-bold text-primary d-block d-md-none">
                {{ \App\Helpers\AppSetting::name() }}
              </span>
        </div>
        <div class="col-12 col-md-6 p-5 bg-blue-50 text-white right-box">
                @yield('content')
        </div>
    </div>
</div>
@yield('custom_js')
</body>
<footer class="bg-white-50 text-center text-primary py-1 fixed-bottom border-none">
    <div class="container">
        <small>&copy; {{ date('Y') }} PRMI Membership System. by :
        <a href="https://instagram.com/el_miro23" target="_blank" class="fw-bold">
            <i class="bi bi-instagram"></i> <small>Hendrik Samkay</small>
        </a>
        </small>
    </div>
</footer>
</html>
