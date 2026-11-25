<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="theme-color" content="#f4f3ec">
  <title>@yield('title', 'Acceso · DAS Panadería')</title>
  <script>document.documentElement.classList.add("js")</script>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('assets/css/variables.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/global.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/components/feedback.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/auth/auth.css') }}">
  @yield('styles')
  <script src="{{ asset('assets/js/global.js') }}" defer></script>
  <script src="{{ asset('assets/js/components/feedback.js') }}" defer></script>
  <script src="{{ asset('assets/js/components/validation.js') }}" defer></script>
  @yield('scripts')
</head>
<body class="auth-body" data-area="presentation" data-page="@yield('page', 'auth')">
  @yield('content')
</body>
</html>
