<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Membership App</title>
    
    <!-- Tambahkan icon -->
    <link rel="icon" type="image/png" href="{{ asset('assets/img/favicon.png') }}">
    <!-- Bootstrap 5 -->
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
        .bg-white-50 {
            background-color: rgba(255, 255, 255, 0.3) !important;
            backdrop-filter: blur(4px);                /* efek blur */
            -webkit-backdrop-filter: blur(4px);        /* Safari support */
        }
        label:has(+ input:required)::after,
        label:has(+ select:required)::after,
        label:has(+ textarea:required)::after {
          content: " *"; /* Adds a space and then the asterisk */
          color: red; /* Sets the asterisk color to red */
          margin-left: 0.2em; /* Adds a small space between the label text and the asterisk */
        }
    </style>
</head>
<body>
    <div class="card min-vh-100 bg-transparent">
            <div class="card-header bg-primary">
                <h4 class="page-title text-white">@yield('title')</h4>
            </div>
            <div class="card-body">
                @yield('content')
            </div>
    </div>
</body>
</html>
