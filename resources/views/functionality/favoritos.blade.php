<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="theme-color" content="#f4f3ec">
  <title>Favoritos · DAS Panadería</title>
  <script>document.documentElement.classList.add("js")</script>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="..//assets/css/variables.css">
  <link rel="stylesheet" href="..//assets/css/global.css">
  <link rel="stylesheet" href="..//assets/css/components/navbar.css">
  <link rel="stylesheet" href="..//assets/css/components/footer.css">
  <link rel="stylesheet" href="..//assets/css/components/cards.css">
  <link rel="stylesheet" href="..//assets/css/components/feedback.css">
  <link rel="stylesheet" href="..//assets/css/functionality/dashboard.css">
  <script src="..//assets/js/global.js" defer></script>
  <script src="..//assets/js/components/feedback.js" defer></script>
  <script src="..//assets/js/components/validation.js" defer></script>
  <script src="..//assets/js/components/navbar.js" defer></script>
  <script src="..//assets/js/functionality/dashboard.js" defer></script>
</head>
<body data-area="functionality" data-page="favoritos">
  <header class="site-header">
    <div class="wrap header-in">
      <a class="brand" href="../dashboard.html" aria-label="DAS Panadería, inicio"><strong>DAS</strong><small>PANADERÍA</small></a>
      <nav class="main-nav" id="main-nav" aria-label="Navegación principal">
        <div class="nav-links"><a href="../dashboard.html" data-nav="panel">Mi panel</a><a href="favoritos.html" data-nav="favoritos" aria-current="page">Favoritos</a><a href="perfil.html" data-nav="perfil">Mi perfil</a><a href="configuracion.html" data-nav="configuracion">Configuración</a></div>
        <div class="nav-extra"><a class="btn btn-soft" href="../../presentation/index.html">Ver el sitio <span class="ico"><svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M3 8h10M9 4l4 4-4 4"/></svg></span></a></div>
        <div class="account-chip" hidden>
          <button type="button" class="chip-btn" aria-haspopup="true" aria-expanded="false"><span class="chip-ini">DA</span><span class="chip-name">Hola</span></button>
          <div class="chip-menu" hidden><a href="../dashboard.html">Mi panel</a><a href="favoritos.html">Mis favoritos</a><a href="perfil.html">Mi perfil</a><button type="button" data-logout>Cerrar sesión</button></div>
        </div>
      </nav>
      <button class="menu-toggle" type="button" aria-label="Abrir menú" aria-expanded="false" aria-controls="main-nav">☰</button>
    </div>
  </header>

  <main class="wrap">
    <section class="page-hero fade-in">
      <div><p class="crumbs"><a href="../dashboard.html">Mi panel</a> / Favoritos</p><h1>Tus favoritos.</h1></div>
      <div><p>Los panes que más te gustan, siempre a la mano.</p></div>
    </section>

    <div class="favs-head"><span id="favs-count" aria-live="polite">0 favoritos</span><a class="link-arrow" href="../../presentation/pages/catalogo.html">Seguir explorando <svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M3 8h10M9 4l4 4-4 4"/></svg></a></div>
    <div class="grid-4" id="favs-grid"></div>
    <div class="favs-empty" id="favs-empty" hidden><h3>Aún no tienes favoritos.</h3><p>Toca el corazón en cualquier producto del catálogo para guardarlo aquí.</p><a class="btn btn-olive sentence" href="../../presentation/pages/catalogo.html">Ir al catálogo <span class="ico"><svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M3 8h10M9 4l4 4-4 4"/></svg></span></a></div>
  </main>

  <footer class="wrap">
    <div class="site-footer slim">
      <div class="footer-slim-row"><a class="brand" href="../dashboard.html"><strong>DAS</strong></a><nav class="footer-bottom" style="margin:0;padding:0;border:0" aria-label="Enlaces"><a href="../../presentation/index.html">Ver el sitio</a><a href="../../presentation/pages/catalogo.html">Catálogo</a><a href="../../presentation/pages/contacto.html">Contacto</a></nav></div>
      <div class="footer-bottom"><span>© DAS 2026</span><nav aria-label="Legal"><a href="#">Privacidad</a><a href="#">Cookies</a><a href="#">Accesibilidad</a></nav></div>
    </div>
  </footer>
</body>
</html>