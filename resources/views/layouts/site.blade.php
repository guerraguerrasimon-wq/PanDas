<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="theme-color" content="#f4f3ec">
  <title>@yield('title', 'DAS Panadería · Buenos días. Mejor pan.')</title>
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
  @yield('styles')
  <script src="{{ asset('assets/js/global.js') }}" defer></script>
  <script src="{{ asset('assets/js/components/feedback.js') }}" defer></script>
  <script src="{{ asset('assets/js/components/validation.js') }}" defer></script>
  <script src="{{ asset('assets/js/components/navbar.js') }}" defer></script>
  @yield('scripts')
</head>
<body data-area="presentation" data-page="@yield('page', 'inicio')">
  <header class="site-header">
    <div class="wrap header-in">
      <a class="brand" href="/" aria-label="DAS Panadería, inicio"><strong>DAS</strong><small>PANADERÍA</small></a>
      <nav class="main-nav" id="main-nav" aria-label="Navegación principal">
        <div class="nav-links">
          <a href="/" data-nav="inicio">Inicio</a>
          <a href="/catalogo" data-nav="catalogo">Nuestro Catálogo</a>
          <a href="/nosotros" data-nav="nosotros">Nosotros</a>
          <a href="/ubicaciones#envios" data-nav="envios">Envíos y Entregas</a>
          <a href="/ubicaciones" data-nav="ubicaciones">Visítanos</a>
        </div>
        <div class="account-actions">
          <a class="btn btn-olive" href="/register">Registrarse</a>
          <a class="btn btn-soft" href="/login">Iniciar sesión</a>
        </div>
      </nav>
      <button class="menu-toggle" type="button" aria-label="Abrir menú" aria-expanded="false" aria-controls="main-nav">☰</button>
    </div>
  </header>

  <main>
    @yield('content')
  </main>

  <footer class="site-footer">
    <div class="wrap footer-in">
      <div class="footer-brand"><strong>DAS</strong><span>PANADERÍA</span></div>
      <p class="footer-copy">© {{ date('Y') }} DAS Panadería. Todos los derechos reservados.</p>
    </div>
  </footer>
</body>
</html>
