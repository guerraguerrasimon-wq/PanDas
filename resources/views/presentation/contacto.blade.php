<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="theme-color" content="#f4f3ec">
  <title>Contacto · DAS Panadería</title>
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
  <link rel="stylesheet" href="..//assets/css/presentation/home.css">
  <script src="..//assets/js/global.js" defer></script>
  <script src="..//assets/js/components/feedback.js" defer></script>
  <script src="..//assets/js/components/validation.js" defer></script>
  <script src="..//assets/js/components/navbar.js" defer></script>
  <script src="..//assets/js/presentation/home.js" defer></script>
</head>
<body data-area="presentation" data-page="contacto">
  <header class="site-header">
    <div class="wrap header-in">
      <a class="brand" href="..//" aria-label="DAS Panadería, inicio"><strong>DAS</strong><small>PANADERÍA</small></a>
      <nav class="main-nav" id="main-nav" aria-label="Navegación principal">
        <div class="nav-links"><a href="..//" data-nav="inicio">Inicio</a><a href="catalogo.html" data-nav="catalogo">Nuestro Catálogo</a><a href="nosotros.html" data-nav="nosotros">Nosotros</a><a href="ubicaciones.html#envios" data-nav="envios">Envíos y Entregas</a><a href="ubicaciones.html" data-nav="ubicaciones">Visítanos</a></div>
        <div class="account-actions">
          <a class="btn btn-olive" href="..//register">Registrarse <span class="ico"><svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M3 8h10M9 4l4 4-4 4"/></svg></span></a>
          <a class="btn btn-soft" href="..//login">Iniciar sesión <span class="ico"><svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M3 8h10M9 4l4 4-4 4"/></svg></span></a>
        </div>
        <div class="account-chip" hidden>
          <button type="button" class="chip-btn" aria-haspopup="true" aria-expanded="false"><span class="chip-ini">DA</span><span class="chip-name">Hola</span></button>
          <div class="chip-menu" hidden><a href="../../functionality/dashboard.html">Mi panel</a><a href="../../functionality/pages/favoritos.html">Mis favoritos</a><a href="../../functionality/pages/perfil.html">Mi perfil</a><button type="button" data-logout>Cerrar sesión</button></div>
        </div>
      </nav>
      <button class="menu-toggle" type="button" aria-label="Abrir menú" aria-expanded="false" aria-controls="main-nav">☰</button>
    </div>
  </header>

  <main class="wrap">
    <section class="page-hero fade-in">
      <div><p class="crumbs"><a href="..//">Inicio</a> / Contacto</p><h1>Hablemos<br>de pan.</h1></div>
      <div><p>Escríbenos para dudas sobre ingredientes, alergias, pedidos grandes o sugerencias.</p><small>Respondemos en horario de tienda</small></div>
    </section>

    <div class="contact">
      <form class="contact-form card fade-in" id="contact-form" novalidate>
        <h2>Escríbenos</h2>
        <div class="cf-row">
          <label class="cf-field"><span>Nombre</span><input id="cf-name" type="text" autocomplete="name" placeholder="Tu nombre"><span class="cf-err"></span></label>
          <label class="cf-field"><span>Correo</span><input id="cf-mail" type="email" autocomplete="email" inputmode="email" placeholder="tu@correo.com"><span class="cf-err"></span></label>
        </div>
        <label class="cf-field"><span>Tema</span><select id="cf-topic"><option value="">Elige un tema</option><option>Pregunta sobre un producto</option><option>Alergias e ingredientes</option><option>Pedidos grandes y eventos</option><option>Envíos y recogida</option><option>Sugerencias</option><option>Otro</option></select><span class="cf-err"></span></label>
        <label class="cf-field"><span>Mensaje</span><textarea id="cf-msg" placeholder="Cuéntanos en qué te ayudamos"></textarea><span class="cf-err"></span></label>
        <p class="cf-msg" id="cf-feedback" aria-live="polite"></p>
        <div><button type="submit" class="btn btn-olive sentence">Enviar mensaje <span class="ico"><svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M3 8h10M9 4l4 4-4 4"/></svg></span></button></div>
      </form>
      <div class="contact-info">
        <article class="info-card fade-in"><span class="note-ico"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 4h4l2 5-2.5 1.5a11 11 0 0 0 5 5L15 13l5 2v4a1 1 0 0 1-1 1A15 15 0 0 1 4 5a1 1 0 0 1 1-1z"/></svg></span><div><h3>Teléfono</h3><p>Por confirmar. Mientras tanto, pasa por tu DAS.</p></div></article>
        <article class="info-card fade-in"><span class="note-ico"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="3" y="5" width="18" height="14" rx="2.5"/><path d="M3.5 7l8.5 6 8.5-6"/></svg></span><div><h3>Correo</h3><p>Por confirmar. Usa el formulario y te respondemos.</p></div></article>
        <article class="info-card fade-in"><span class="note-ico"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 2"/></svg></span><div><h3>Horario</h3><p>Lun–sáb · 07:30–20:00<br>Dom · 08:00–14:00</p></div></article>
        <article class="info-card fade-in"><span class="note-ico"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 21s7-6.2 7-11a7 7 0 0 0-14 0c0 4.8 7 11 7 11z"/><circle cx="12" cy="10" r="2.5"/></svg></span><div><h3>Dónde estamos</h3><p>Patio Bonito y Usme. <a href="ubicaciones.html">Ver ubicaciones</a></p></div></article>
      </div>
    </div>

    <section class="band fade-in">
      <div class="band-left"><span class="band-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 2"/></svg></span><div><h2>¿Tienes una alergia?</h2><p>Consulta los ingredientes con nuestro equipo antes de elegir.</p></div></div>
      <a class="link-arrow" href="catalogo.html">Ver el catálogo <svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M3 8h10M9 4l4 4-4 4"/></svg></a>
    </section>
  </main>

  <footer class="wrap">
    <div class="site-footer">
      <div class="footer-grid">
        <div><a class="brand" href="..//"><strong>DAS</strong></a><p class="footer-tag">El pan de siempre.<br>Una forma nueva de vivirlo.</p></div>
        <div><h4>Explora</h4><ul><li><a href="..//">Inicio</a></li><li><a href="catalogo.html">Nuestro pan</a></li><li><a href="nosotros.html">Nosotros</a></li><li><a href="ubicaciones.html#envios">Envíos y entregas</a></li></ul></div>
        <div><h4>Encuéntranos</h4><ul><li>Consulta tu punto de recogida</li><li>Lun–sáb · 07:30–20:00</li><li>Dom · 08:00–14:00</li><li><a href="ubicaciones.html">Ver ubicaciones</a></li><li><a href="contacto.html">Contacto</a></li></ul></div>
        <div><h4>Hecho con calma</h4><ul><li>Harina, agua, tiempo.</li><li>Y mucho oficio.</li></ul></div>
      </div>
      <div class="footer-bottom"><span>© DAS 2026</span><nav aria-label="Legal"><a href="#">Privacidad</a><a href="#">Cookies</a><a href="#">Accesibilidad</a></nav></div>
    </div>
  </footer>
</body>
</html>