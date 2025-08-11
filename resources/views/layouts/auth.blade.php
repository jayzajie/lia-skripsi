<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  
  <title>{{ config('app.name', 'Laravel') }}</title>
  
  <link rel="shortcut icon" type="image/png" href="{{ asset('assets/images/logos/favicon.png') }}" />
  <link rel="stylesheet" href="{{ asset('assets/css/styles.min.css') }}" />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
  
  <!-- Additional Styles -->
  <style>
    :root {
      --primary: #22c55e;
      --primary-dark: #16a34a;
      --accent: #fbbf24;
      --text: #222;
      --bg: #fff;
      --shadow: 0 4px 24px rgba(34,197,94,0.10);
      --shadow-hover: 0 8px 32px rgba(34,197,94,0.18);
    }
    
    body {
      font-family: 'Poppins', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }
    
    .card {
      box-shadow: var(--shadow);
      border-radius: 15px;
      border: none;
    }
    
    .card:hover {
      box-shadow: var(--shadow-hover);
    }
    
    .btn-primary {
      background-color: var(--primary) !important;
      border-color: var(--primary) !important;
    }
    
    .btn-primary:hover {
      background-color: var(--primary-dark) !important;
      border-color: var(--primary-dark) !important;
    }
    
    .form-control:focus {
      border-color: var(--primary);
      box-shadow: 0 0 0 0.25rem rgba(34, 197, 94, 0.25);
    }
    
    .form-check-input:checked {
      background-color: var(--primary);
      border-color: var(--primary);
    }
    
    .text-primary {
      color: var(--primary) !important;
    }
    
    .page-wrapper {
      background: linear-gradient(135deg, #f3f4f6 0%, #ffffff 100%);
    }
    
    .logo-img img {
      max-height: 70px;
    }
  </style>
  
  @yield('styles')
</head>

<body>
  @yield('content')
  
  <script src="{{ asset('assets/libs/jquery/dist/jquery.min.js') }}"></script>
  <script src="{{ asset('assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
  <!-- solar icons -->
  <script src="https://cdn.jsdelivr.net/npm/iconify-icon@1.0.8/dist/iconify-icon.min.js"></script>
  
  <!-- Additional Scripts -->
  @yield('scripts')
</body>

</html> 