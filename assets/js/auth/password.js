/* DAS Panadería · recuperar contraseña, verificar correo, nueva contraseña y confirmación.
   No hay servidor de correo todavía: el código se muestra en pantalla (modo demostración). */
(function () {
  const page = document.body.dataset.page;
  const formMessage = $("#form-msg");

  /* ---------- 1. Recuperar contraseña ---------- */
  if (page === "recuperar") {
    const form = $("#recover-form");
    const emailInput = $("#email");
    const field = $("#email-field");
    const button = $("#submit");
    emailInput.addEventListener("blur", () => setState(field, validateEmail(emailInput.value), !validateEmail(emailInput.value)));
    form.addEventListener("submit", async e => {
      e.preventDefault();
      const error = validateEmail(emailInput.value);
      setState(field, error, !error);
      if (error) { emailInput.focus(); shake(form); return; }
      setLoading(button, true);
      const email = emailInput.value.trim().toLowerCase();
      await sleep(700);
      /* La respuesta es la misma exista o no la cuenta, para no revelar qué correos están registrados. */
      createPending(email, "recuperacion", !!getAccounts()[email]);
      showSuccess("Revisa tu correo", "Si hay una cuenta con ese correo, te enviamos un código de 6 dígitos.", PAGE.verificar);
    });
  }

  /* ---------- 2. Verificar correo ---------- */
  if (page === "verificar") {
    const card = $("#verify-card");
    const expired = $("#expired");
    const form = $("#verify-form");
    const otp = $$("#otp input");
    const demo = $("#demo-box");
    const resend = $("#resend");
    const button = $("#submit");
    let pending = getPending();
    if (!pending) {
      form.hidden = true; card.hidden = true; expired.hidden = false;
    } else {
      $("#verify-mail").textContent = maskEmail(pending.email);
      $("#verify-title").textContent = pending.flow === "registro" ? "Verifica tu correo" : "Revisa tu correo";
      const showDemo = () => {
        demo.innerHTML = pending.code
          ? `<b>Modo demostración.</b> Todavía no enviamos correos reales. Tu código es <strong>${pending.code}</strong>.`
          : "<b>Modo demostración.</b> Ese correo no tiene una cuenta, por eso no hay código. Vuelve a intentarlo con otro correo.";
      };
      showDemo();
      otp[0].focus();

      otp.forEach((input, i) => {
        input.addEventListener("input", () => {
          input.value = digits(input.value).slice(-1);
          formMessage.textContent = "";
          if (input.value && otp[i + 1]) otp[i + 1].focus();
        });
        input.addEventListener("keydown", e => {
          if (e.key === "Backspace" && !input.value && otp[i - 1]) { otp[i - 1].focus(); otp[i - 1].value = ""; }
          if (e.key === "ArrowLeft" && otp[i - 1]) otp[i - 1].focus();
          if (e.key === "ArrowRight" && otp[i + 1]) otp[i + 1].focus();
        });
        input.addEventListener("paste", e => {
          const text = digits((e.clipboardData || window.clipboardData).getData("text")).slice(0, 6);
          if (!text) return;
          e.preventDefault();
          otp.forEach((o, k) => { o.value = text[k] || ""; });
          (otp[Math.min(text.length, 5)]).focus();
        });
      });

      form.addEventListener("submit", async e => {
        e.preventDefault();
        pending = getPending();
        if (!pending) { location.reload(); return; }
        const code = otp.map(o => o.value).join("");
        if (code.length < 6) { formMessage.textContent = "Escribe los 6 dígitos del código."; shake($("#otp")); return; }
        pending.attempts = (pending.attempts || 0) + 1;
        if (pending.attempts > 5) { clearPending(); formMessage.textContent = "Demasiados intentos. Pide un código nuevo."; resend.disabled = false; return; }
        savePending(pending);
        if (!pending.code || code !== pending.code) {
          formMessage.textContent = `Código incorrecto. Te quedan ${Math.max(0, 5 - pending.attempts)} intentos.`;
          shake($("#otp"));
          otp.forEach(o => { o.value = ""; });
          otp[0].focus();
          return;
        }
        setLoading(button, true);
        await sleep(500);
        const accounts = getAccounts();
        const account = accounts[pending.email];
        if (pending.flow === "registro" && account) {
          account.verified = true;
          saveAccounts(accounts);
          startSession(pending.email, account.name);
          clearPending();
          showSuccess("¡Correo verificado!", "Tu cuenta está lista.", PAGE.confirmacion + "?flow=registro");
        } else {
          store.set(RESET_KEY, JSON.stringify({ email: pending.email, ts: Date.now() }));
          clearPending();
          showSuccess("Código correcto", "Ahora crea tu nueva contraseña.", PAGE.nueva);
        }
      });

      /* Reenviar con espera de 30 segundos */
      let wait = 0;
      function cooldown(seconds) {
        wait = seconds;
        resend.disabled = true;
        const tick = () => {
          if (wait <= 0) { resend.disabled = false; resend.textContent = "Reenviar código"; return; }
          resend.textContent = `Reenviar código en ${wait}s`;
          wait--;
          setTimeout(tick, 1000);
        };
        tick();
      }
      cooldown(30);
      resend.addEventListener("click", () => {
        const account = getAccounts()[pending.email];
        pending = createPending(pending.email, pending.flow, pending.flow === "registro" ? true : !!account);
        showDemo();
        otp.forEach(o => { o.value = ""; });
        otp[0].focus();
        formMessage.textContent = "";
        toast("Te enviamos un código nuevo.");
        cooldown(30);
      });
    }
  }

  /* ---------- 3. Nueva contraseña ---------- */
  if (page === "nueva") {
    const form = $("#new-form");
    const token = readJSON(RESET_KEY, null);
    const valid = token && Date.now() - token.ts < CODE_MINUTES * 60 * 1000 && getAccounts()[token.email];
    if (!valid) {
      form.hidden = true; $("#expired").hidden = false;
    } else {
      const pw = $("#password");
      const pw2 = $("#password2");
      const f1 = $("#password-field");
      const f2 = $("#password2-field");
      const button = $("#submit");
      bindMeter(pw, $("#meter"), $("#meter-label"), "Mínimo 8 caracteres.");
      const check1 = () => { const err = validateNewPassword(pw.value); setState(f1, err, !err); return !err; };
      const check2 = () => { const err = pw2.value === pw.value && pw2.value ? "" : "Las contraseñas no coinciden."; setState(f2, err, !err); return !err; };
      pw.addEventListener("blur", check1);
      pw2.addEventListener("input", () => { if (pw2.value) check2(); });
      form.addEventListener("submit", async e => {
        e.preventDefault();
        const ok1 = check1(), ok2 = check2();
        if (!ok1 || !ok2) { shake(form); return; }
        setLoading(button, true);
        const accounts = getAccounts();
        accounts[token.email].hash = await hashPassword(pw.value, token.email);
        saveAccounts(accounts);
        store.remove(RESET_KEY);
        await sleep(500);
        showSuccess("Contraseña actualizada", "Ya puedes iniciar sesión.", PAGE.confirmacion + "?flow=recuperacion");
      });
    }
  }

  /* ---------- 4. Confirmación ---------- */
  if (page === "confirmacion") {
    const flow = new URLSearchParams(location.search).get("flow");
    const session = getSession();
    const texts = {
      registro: { t: "¡Bienvenido a DAS!", p: "Tu correo está verificado y tu cuenta lista. Ya puedes guardar tus favoritos.", cta: "Ir a mi panel", href: session ? PAGE.panel : PAGE.login },
      recuperacion: { t: "Contraseña actualizada", p: "Ya puedes iniciar sesión con tu nueva contraseña.", cta: "Iniciar sesión", href: PAGE.login }
    };
    const t = texts[flow] || { t: "Todo listo", p: "Puedes seguir explorando DAS.", cta: "Ir al inicio", href: PAGE.inicio };
    $("#confirm-title").textContent = t.t;
    $("#confirm-text").textContent = t.p;
    const cta = $("#confirm-cta");
    cta.firstChild.textContent = t.cta + " ";
    cta.href = t.href;
  }
})();