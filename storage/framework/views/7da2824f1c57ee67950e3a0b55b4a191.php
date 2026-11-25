<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="theme-color" content="#f4f3ec">
  <title>Crear cuenta · DAS Panadería</title>
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
  <script src="/assets/js/auth/register.js" defer></script>
</head>
<body class="auth-body" data-area="presentation" data-page="register">
  <div class="auth-page">
    <aside class="auth-panel" aria-label="Presentación de DAS">
      <div class="img-slot panel-img"><img class="slot-img" src="/assets/images/general/registro-panel.jpg" alt=""></div>
      <div class="panel-content">
        <div class="panel-brand"><strong>DAS</strong><span>PANADERÍA</span></div>
        <h2>Únete a DAS</h2>
        <p>Crea tu cuenta para guardar tus favoritos y enterarte de lo que sale del horno.</p>
        <ol class="steps" id="steps">
          <li class="step is-active" data-step="1"><span class="num">1</span>Tus datos</li>
          <li class="step" data-step="2"><span class="num">2</span>Tu contraseña</li>
          <li class="step" data-step="3"><span class="num">3</span>Listo para entrar</li>
        </ol>
      </div>
    </aside>

    <main class="auth-main">
      <div class="auth-top">
        <a class="back-link" href="../index.html">← Volver al sitio</a>
      </div>
      <section class="auth-card">
        <div class="m-hero">
          <div class="img-slot"><img class="slot-img" src="/assets/images/general/registro-celular.jpg" alt=""></div>
        </div>

        <div class="welcome">
          <h1 class="auth-title">Crea tu cuenta</h1>
          <p class="auth-sub">Guarda tus favoritos y entérate de lo que sale del horno. Regístrate en menos de un minuto.</p>
          <div class="seg-progress" aria-hidden="true"><i class="on"></i><i></i><i></i></div>
          <div class="stack">
            <button type="button" class="social-btn" data-provider="google"><svg viewBox="0 0 48 48" aria-hidden="true"><path fill="#EA4335" d="M24 9.5c3.54 0 6.71 1.22 9.21 3.6l6.85-6.85C35.9 2.38 30.47 0 24 0 14.62 0 6.51 5.38 2.56 13.22l7.98 6.19C12.43 13.72 17.74 9.5 24 9.5z"/><path fill="#4285F4" d="M46.98 24.55c0-1.57-.15-3.09-.38-4.55H24v9.02h12.94c-.58 2.96-2.26 5.48-4.78 7.18l7.73 6c4.51-4.18 7.09-10.36 7.09-17.65z"/><path fill="#FBBC05" d="M10.53 28.59c-.48-1.45-.76-2.99-.76-4.59s.27-3.14.76-4.59l-7.98-6.19C.92 16.46 0 20.12 0 24c0 3.88.92 7.54 2.56 10.78l7.97-6.19z"/><path fill="#34A853" d="M24 48c6.48 0 11.93-2.13 15.89-5.81l-7.73-6c-2.15 1.45-4.92 2.3-8.16 2.3-6.26 0-11.57-4.22-13.47-9.91l-7.98 6.19C6.51 42.62 14.62 48 24 48z"/></svg><span>Continuar con Google</span></button>
            <button type="button" class="social-btn" data-provider="microsoft"><svg viewBox="0 0 23 23" aria-hidden="true"><path fill="#f25022" d="M1 1h10v10H1z"/><path fill="#7fba00" d="M12 1h10v10H12z"/><path fill="#00a4ef" d="M1 12h10v10H1z"/><path fill="#ffb900" d="M12 12h10v10H12z"/></svg><span>Continuar con Microsoft</span></button>
            <button type="button" class="submit" id="go-form">Registrarme con correo <b aria-hidden="true">→</b></button>
          </div>
          <p class="switch-line">¿Ya tienes cuenta? <a href="login.html">Inicia sesión</a></p>
        </div>

        <div class="form-wrap">
          <button type="button" class="back-step" id="back-welcome">← Atrás</button>
          <h1 class="auth-title">Crea tu cuenta</h1>
          <p class="auth-sub">Ingresa tus datos para registrarte en DAS.</p>
          <div class="seg-progress" id="seg-progress" aria-hidden="true"><i class="on"></i><i></i><i></i></div>
          <div class="social-row desktop-only">
            <button type="button" class="social-btn" data-provider="google"><svg viewBox="0 0 48 48" aria-hidden="true"><path fill="#EA4335" d="M24 9.5c3.54 0 6.71 1.22 9.21 3.6l6.85-6.85C35.9 2.38 30.47 0 24 0 14.62 0 6.51 5.38 2.56 13.22l7.98 6.19C12.43 13.72 17.74 9.5 24 9.5z"/><path fill="#4285F4" d="M46.98 24.55c0-1.57-.15-3.09-.38-4.55H24v9.02h12.94c-.58 2.96-2.26 5.48-4.78 7.18l7.73 6c4.51-4.18 7.09-10.36 7.09-17.65z"/><path fill="#FBBC05" d="M10.53 28.59c-.48-1.45-.76-2.99-.76-4.59s.27-3.14.76-4.59l-7.98-6.19C.92 16.46 0 20.12 0 24c0 3.88.92 7.54 2.56 10.78l7.97-6.19z"/><path fill="#34A853" d="M24 48c6.48 0 11.93-2.13 15.89-5.81l-7.73-6c-2.15 1.45-4.92 2.3-8.16 2.3-6.26 0-11.57-4.22-13.47-9.91l-7.98 6.19C6.51 42.62 14.62 48 24 48z"/></svg><span>Google</span></button>
            <button type="button" class="social-btn" data-provider="microsoft"><svg viewBox="0 0 23 23" aria-hidden="true"><path fill="#f25022" d="M1 1h10v10H1z"/><path fill="#7fba00" d="M12 1h10v10H12z"/><path fill="#00a4ef" d="M1 12h10v10H1z"/><path fill="#ffb900" d="M12 12h10v10H12z"/></svg><span>Microsoft</span></button>
          </div>
          <div class="divider desktop-only"><span>o</span></div>
          <form id="register-form" novalidate>
          <div class="two-col">
            <div class="field" id="first-field">
            <label class="label" for="first">Nombre</label>
            <div class="control"><input id="first" name="first" type="text" placeholder="Ej. Camila" autocomplete="given-name" autocapitalize="words" required><span class="ok-icon" aria-hidden="true">✓</span></div>
            <p class="field-error" id="first-error"></p>
          </div>
            <div class="field" id="last-field">
            <label class="label" for="last">Apellido</label>
            <div class="control"><input id="last" name="last" type="text" placeholder="Ej. Rojas" autocomplete="family-name" autocapitalize="words" required><span class="ok-icon" aria-hidden="true">✓</span></div>
            <p class="field-error" id="last-error"></p>
          </div>
          </div>
          <div class="field" id="email-field">
            <label class="label" for="email">Correo</label>
            <div class="control"><input id="email" name="email" type="email" inputmode="email" placeholder="Ej. camila@correo.com" autocomplete="email" autocapitalize="none" spellcheck="false" required><span class="ok-icon" aria-hidden="true">✓</span></div>
            <p class="field-error" id="email-error"></p>
          </div>
          <div class="field" id="phone-field">
            <label class="label" for="phone-country">Teléfono</label>
            <div class="control select"><select id="phone-country" required><option value="" disabled selected hidden>Selecciona el país</option><option value="CO">Colombia (+57)</option><option value="US">Estados Unidos (+1)</option></select></div>
            <div class="reveal" id="phone-reveal" inert>
              <div>
                <div class="control prefixed"><span class="prefix" id="phone-prefix">+57</span><input id="phone-number" name="phone" type="tel" inputmode="numeric" pattern="[0-9]*" autocomplete="tel-national" enterkeyhint="next" maxlength="14" placeholder="300 123 4567" aria-label="Número de teléfono"><span class="ok-icon" aria-hidden="true">✓</span></div>
              </div>
            </div>
            <p class="field-error" id="phone-error"></p>
          </div>
          <div class="field" id="lang-field">
            <label class="label" for="lang">País / Idioma</label>
            <div class="control select"><select id="lang" required><option value="" disabled selected hidden>Selecciona tu país e idioma</option><option value="CO-es">Colombia · Español</option><option value="US-en">Estados Unidos · English</option></select><span class="ok-icon" aria-hidden="true">✓</span></div>
            <p class="field-error" id="lang-error"></p>
          </div>
          <div class="field" id="password-field">
            <label class="label" for="password">Contraseña</label>
            <div class="control has-toggle"><input id="password" name="password" type="password" placeholder="Crea una contraseña" autocomplete="new-password" required><span class="ok-icon" aria-hidden="true">✓</span><button type="button" class="eye" data-toggle-password aria-label="Mostrar contraseña" aria-pressed="false"><svg class="on-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M2 12s3.6-7 10-7 10 7 10 7-3.6 7-10 7S2 12 2 12z"/><circle cx="12" cy="12" r="3"/></svg><svg class="off" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M3 3l18 18"/><path d="M10.6 6.2A10.7 10.7 0 0 1 12 6c6.4 0 10 6 10 6a17 17 0 0 1-3.2 3.9M6.6 7.7A16.6 16.6 0 0 0 2 12s3.6 6 10 6c1.6 0 3-.4 4.3-1"/><path d="M9.9 10a3 3 0 0 0 4.1 4.1"/></svg></button></div>
            <div class="meter" id="meter" data-level=""><i></i><i></i><i></i></div>
            <p class="meter-label" id="meter-label">Mínimo 8 caracteres.</p>
            <p class="field-error" id="password-error"></p>
          </div>
          <div class="field" id="terms-field">
            <label class="check"><input type="checkbox" id="terms"><span>Acepto los <a href="#" data-soon="Los términos de uso estarán disponibles pronto.">términos de uso</a> y la <a href="#" data-soon="La política de tratamiento de datos estará disponible pronto.">política de tratamiento de datos</a>.</span></label>
            <p class="field-error" id="terms-error"></p>
          </div>
          <p class="form-msg" id="form-msg" aria-live="polite"></p>
          <button class="submit" id="submit" type="submit"><span class="spinner" aria-hidden="true"></span><span class="submit-label">Crear cuenta</span><b class="arrow" aria-hidden="true">→</b></button>
        </form>
          <p class="switch-line">¿Ya tienes cuenta? <a href="login.html">Inicia sesión</a></p>
        </div>
      </section>
    </main>
  </div>
</body>
</html><?php /**PATH C:\Users\simon\PanDas_V2\resources\views/auth/register.blade.php ENDPATH**/ ?>