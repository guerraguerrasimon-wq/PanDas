<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="theme-color" content="#f4f3ec">
  <title>@yield('title', 'Mi panel · DAS Panadería')</title>
  <script>document.documentElement.classList.add("js")</script>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('assets/css/variables.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/global.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/components/navbar.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/components/footer.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/components/cards.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/components/feedback.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/functionality/dashboard.css') }}">
  @yield('styles')
  <script src="{{ asset('assets/js/global.js') }}" defer></script>
  <script src="{{ asset('assets/js/components/feedback.js') }}" defer></script>
  <script src="{{ asset('assets/js/components/validation.js') }}" defer></script>
  <script src="{{ asset('assets/js/components/navbar.js') }}" defer></script>
  @yield('scripts')
</head>
<body data-area="functionality" data-page="@yield('page', 'panel')">
  <header class="site-header">
    <div class="wrap header-in">
      <a class="brand" href="/dashboard" aria-label="DAS Panadería, inicio"><strong>DAS</strong><small>PANADERÍA</small></a>
      <nav class="main-nav" id="main-nav" aria-label="Navegación de usuario">
        <div class="nav-links">
          <a href="/dashboard" data-nav="panel">Mi panel</a>
          <a href="/favoritos" data-nav="favoritos">Favoritos</a>
          <a href="/carrito" data-nav="carrito">Carrito</a>
          <a href="/pedidos" data-nav="pedidos">Mis Pedidos</a>
          <a href="/perfil" data-nav="perfil">Mi perfil</a>
          <a href="/configuracion" data-nav="configuracion">Configuración</a>
        </div>
        <div class="nav-extra">
          <a class="btn btn-soft" href="/">Ver el sitio</a>
        </div>
      </nav>
      <button class="menu-toggle" type="button" aria-label="Abrir menú" aria-expanded="false" aria-controls="main-nav">☰</button>
    </div>
  </header>

  <main class="wrap">
    @yield('content')
  </main>
</body>
</html>
