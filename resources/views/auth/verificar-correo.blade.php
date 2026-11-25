<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="theme-color" content="#f4f3ec">
  <title>Verificar correo · DAS Panadería</title>
  <script>document.documentElement.classList.add("js")</script>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="/assets/css/variables.css">
  <link rel="stylesheet" href="/assets/css/global.css">
  <link rel="stylesheet" href="/assets/css/components/feedback.css">
  <link rel="stylesheet" href="/assets/css/auth/auth.css">
  <script src="/assets/js/global.js" defer></script>
  <script src="/assets/js/components/feedback.js" defer></script>
  <script src="/assets/js/components/validation.js" defer></script>
  <script src="/assets/js/auth/password.js" defer></script>
</head>
<body class="auth-body" data-area="presentation" data-page="verificar">
  <div class="auth-page">
    <aside class="auth-panel" aria-label="DAS Panadería">
      <div class="img-slot panel-img"><img class="slot-img" src="/assets/images/general/registro-panel.jpg" alt=""></div>
      <div class="panel-content">
        <div class="panel-brand"><strong>DAS</strong><span>PANADERÍA</span></div>
        <h2>Un paso más</h2>
        <p>Verificar tu correo mantiene tu cuenta segura.</p>
        <ul class="feature-list"><li>Código de 6 dígitos</li><li>Válido por 10 minutos</li><li>Puedes pedir uno nuevo</li></ul>
      </div>
    </aside>

    <main class="auth-main">
      <div class="auth-top"><a class="back-link" href="../index.html">← Volver al sitio</a></div>
      <section class="auth-card">
        <div class="m-hero small"><div class="img-slot"><img class="slot-img" src="/assets/images/general/registro-celular.jpg" alt=""></div></div>
        <div id="verify-card">
          <h1 class="auth-title" id="verify-title">Verifica tu correo</h1>
          <p class="auth-sub">Enviamos un código de 6 dígitos a <b id="verify-mail"></b>. Vence en 10 minutos.</p>
          <div class="demo-box" id="demo-box" aria-live="polite"></div>
        </div>
        <form id="verify-form" novalidate>
          <div class="otp" id="otp" role="group" aria-label="Código de 6 dígitos"><input type="text" inputmode="numeric" pattern="[0-9]*" maxlength="1" autocomplete="one-time-code" aria-label="Dígito 1"><input type="text" inputmode="numeric" pattern="[0-9]*" maxlength="1" autocomplete="off" aria-label="Dígito 2"><input type="text" inputmode="numeric" pattern="[0-9]*" maxlength="1" autocomplete="off" aria-label="Dígito 3"><input type="text" inputmode="numeric" pattern="[0-9]*" maxlength="1" autocomplete="off" aria-label="Dígito 4"><input type="text" inputmode="numeric" pattern="[0-9]*" maxlength="1" autocomplete="off" aria-label="Dígito 5"><input type="text" inputmode="numeric" pattern="[0-9]*" maxlength="1" autocomplete="off" aria-label="Dígito 6"></div>
          <p class="form-msg" id="form-msg" aria-live="polite"></p>
          <button class="submit" id="submit" type="submit"><span class="spinner" aria-hidden="true"></span><span class="submit-label">Verificar</span><b class="arrow" aria-hidden="true">→</b></button>
          <p class="switch-line"><button type="button" class="link-btn" id="resend" disabled>Reenviar código</button></p>
        </form>
        <div class="expired" id="expired" hidden>
          <h1 class="auth-title">El código venció</h1>
          <p class="auth-sub">No hay una verificación en curso o el código ya expiró.</p>
          <a class="submit" href="recuperar-password.html">Pedir un código nuevo <b aria-hidden="true">→</b></a>
        </div>
        <p class="switch-line">¿Te equivocaste de correo? <a href="register.html">Volver</a></p>
      </section>
    </main>
  </div>
</body>
</html>