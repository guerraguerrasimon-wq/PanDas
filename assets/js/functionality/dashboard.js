/* DAS Panadería · área de la persona: panel, perfil, configuración y favoritos.
   Todo se guarda en este navegador, por usuario, hasta que exista el backend. */
(function () {
  const session = requireSession();
  if (!session) return;
  const email = session.email;
  const page = document.body.dataset.page;
  const first = (session.name || "").split(" ")[0] || "";
  const accountOf = () => getAccounts()[email] || {};
  const prefsKey = `das-prefs:${email}`;
  const getPrefs = () => ({ novedades: true, promos: false, store: "", ...readJSON(prefsKey, {}) });
  const setPrefs = prefs => store.set(prefsKey, JSON.stringify(prefs));
  const photoKey = `das-avatar:${email}`;
  const LANG_LABEL = { "CO-es": "Colombia · Español", "US-en": "Estados Unidos · English" };
  const greeting = () => { const h = new Date().getHours(); return h < 12 ? "Buenos días" : h < 19 ? "Buenas tardes" : "Buenas noches"; };
  const favProducts = () => getFavs().map(id => PRODUCTS.find(p => p.id === id)).filter(Boolean);
  const phoneText = acc => (acc.phone && acc.phone.number ? `${acc.phone.prefix} ${formatPhone(acc.phone.country, acc.phone.number)}` : "Sin teléfono");

  /* Actualiza el nombre que se ve en el encabezado */
  function refreshChip(name) {
    const ini = $(".chip-ini"), nm = $(".chip-name");
    if (ini) ini.textContent = initialsOf(name);
    if (nm) nm.textContent = name.split(" ")[0];
  }

  /* ---------- Panel ---------- */
  function initDashboard() {
    $("#greet").textContent = `${greeting()}${first ? ", " + first : ""}.`;

    function renderFavs() {
      const list = favProducts();
      $("#fav-count").textContent = String(list.length);
      $("#fav-text").textContent = list.length === 1 ? "producto guardado" : "productos guardados";
      $("#fav-empty").hidden = list.length > 0;
      mount($("#fav-preview"), list.slice(0, 4).map(productCard).join(""));
    }
    renderFavs();
    document.addEventListener("das-favs", renderFavs);

    /* Punto DAS preferido */
    const select = $("#store-select");
    const info = $("#store-info");
    STORES.forEach(s => select.insertAdjacentHTML("beforeend", `<option value="${esc(s.id)}">DAS ${esc(s.name)} · ${esc(s.localidad)}</option>`));
    function showStore() {
      const s = STORES.find(x => x.id === select.value);
      info.innerHTML = s
        ? `<strong>DAS ${esc(s.name)}</strong><span>${esc(s.tag)} · ${esc(s.localidad)}</span><span>${HORARIO.semana}</span><span>${HORARIO.domingo}</span><a class="link-arrow" href="${PAGE.ubicaciones}">Ver ubicaciones ${ARROW}</a>`
        : '<span class="muted">Elige el DAS donde sueles pasar y lo tendremos a la mano.</span>';
    }
    select.value = getPrefs().store || "";
    select.addEventListener("change", () => { const p = getPrefs(); p.store = select.value; setPrefs(p); showStore(); toast("Guardamos tu punto preferido."); });
    showStore();

    /* Resumen de la cuenta */
    const acc = accountOf();
    $("#sum-name").textContent = acc.name || session.name || "";
    $("#sum-mail").textContent = email;
    $("#sum-phone").textContent = phoneText(acc);
    $("#sum-lang").textContent = LANG_LABEL[`${acc.country}-${acc.lang}`] || "Sin definir";
  }

  /* ---------- Perfil ---------- */
  function initPerfil() {
    const form = $("#profile-form");
    const acc = accountOf();
    const el = { first: $("#p-first"), last: $("#p-last"), email: $("#p-email"), country: $("#p-country"), number: $("#p-number"), lang: $("#p-lang"), notes: $("#p-notes") };
    el.first.value = acc.first || ""; el.last.value = acc.last || ""; el.email.value = email;
    el.country.value = acc.phone ? acc.phone.country : "";
    el.number.value = acc.phone ? formatPhone(acc.phone.country, acc.phone.number) : "";
    el.lang.value = acc.country && acc.lang ? `${acc.country}-${acc.lang}` : "";
    el.notes.value = readJSON(`das-notes:${email}`, "");
    const syncPhone = () => {
      const info = PHONE[el.country.value];
      $("#p-prefix").textContent = info ? info.prefix : "+";
      if (info) el.number.placeholder = info.placeholder;
    };
    syncPhone();
    el.country.addEventListener("change", () => { syncPhone(); el.number.value = formatPhone(el.country.value, el.number.value); });
    el.number.addEventListener("input", () => { el.number.value = formatPhone(el.country.value, el.number.value); });

    const rules = {
      first: () => validateName(el.first.value, "nombre"),
      last: () => validateName(el.last.value, "apellido"),
      phone: () => validatePhone(el.country.value, el.number.value),
      lang: () => (el.lang.value ? "" : "Elige tu país e idioma.")
    };
    const holder = k => (k === "phone" ? el.number : el[k]).closest(".field");
    const run = k => { const err = rules[k](); setState(holder(k), err, !err); return !err; };
    Object.keys(rules).forEach(k => (k === "phone" ? [el.country, el.number] : [el[k]]).forEach(i => i.addEventListener("blur", () => run(k))));

    /* Foto de perfil (la sube la propia persona) */
    const avatar = $("#p-avatar");
    function paintAvatar() {
      const photo = store.get(photoKey);
      avatar.innerHTML = photo ? `<img src="${esc(photo)}" alt="Tu foto de perfil">` : `<span>${esc(initialsOf(accountOf().name || session.name))}</span>`;
    }
    paintAvatar();
    $("#p-photo-btn").addEventListener("click", () => $("#p-photo-file").click());
    $("#p-photo-file").addEventListener("change", e => {
      const file = e.target.files[0];
      if (!file) return;
      const reader = new FileReader();
      reader.onload = () => {
        const img = new Image();
        img.onload = () => {
          const scale = Math.min(1, 320 / Math.max(img.width, img.height));
          const canvas = document.createElement("canvas");
          canvas.width = Math.round(img.width * scale); canvas.height = Math.round(img.height * scale);
          canvas.getContext("2d").drawImage(img, 0, 0, canvas.width, canvas.height);
          store.set(photoKey, canvas.toDataURL("image/jpeg", 0.85));
          paintAvatar();
          toast("Foto actualizada.");
        };
        img.onerror = () => toast("No se pudo leer esa imagen.");
        img.src = reader.result;
      };
      reader.readAsDataURL(file);
      e.target.value = "";
    });

    form.addEventListener("submit", e => {
      e.preventDefault();
      const ok = Object.keys(rules).map(run);
      if (ok.includes(false)) { shake(form); return; }
      const accounts = getAccounts();
      const a = accounts[email];
      a.first = el.first.value.trim(); a.last = el.last.value.trim(); a.name = `${a.first} ${a.last}`;
      a.phone = { country: el.country.value, prefix: PHONE[el.country.value].prefix, number: digits(el.number.value) };
      [a.country, a.lang] = el.lang.value.split("-");
      saveAccounts(accounts);
      store.set(`das-notes:${email}`, JSON.stringify(el.notes.value.trim().slice(0, 300)));
      startSession(email, a.name);
      refreshChip(a.name);
      paintAvatar();
      toast("Cambios guardados.");
    });
  }

  /* ---------- Configuración ---------- */
  function initConfig() {
    const prefs = getPrefs();
    $("#pref-novedades").checked = !!prefs.novedades;
    $("#pref-promos").checked = !!prefs.promos;
    const acc = accountOf();
    $("#pref-lang").value = acc.lang || "es";
    ["pref-novedades", "pref-promos"].forEach(id => $("#" + id).addEventListener("change", () => {
      const p = getPrefs();
      p.novedades = $("#pref-novedades").checked;
      p.promos = $("#pref-promos").checked;
      setPrefs(p);
      toast("Preferencias guardadas.");
    }));
    $("#pref-lang").addEventListener("change", e => {
      const accounts = getAccounts();
      accounts[email].lang = e.target.value;
      saveAccounts(accounts);
      store.set("das-lang", e.target.value);
      toast("Idioma guardado.");
    });

    /* Cambiar contraseña */
    const form = $("#pw-form");
    const cur = $("#pw-current"), n1 = $("#pw-new"), n2 = $("#pw-new2");
    bindMeter(n1, $("#meter"), $("#meter-label"), "Mínimo 8 caracteres.");
    form.addEventListener("submit", async e => {
      e.preventDefault();
      const msg = $("#pw-msg");
      msg.className = "form-msg";
      const errCur = cur.value ? "" : "Escribe tu contraseña actual.";
      const errNew = validateNewPassword(n1.value);
      const errSame = n2.value === n1.value && n2.value ? "" : "Las contraseñas no coinciden.";
      setState(cur.closest(".field"), errCur, false);
      setState(n1.closest(".field"), errNew, !errNew);
      setState(n2.closest(".field"), errSame, !errSame);
      if (errCur || errNew || errSame) { shake(form); return; }
      const accounts = getAccounts();
      if (!(await passwordMatches(accounts[email], cur.value, email))) {
        setState(cur.closest(".field"), "Esa no es tu contraseña actual.", false);
        shake(form);
        return;
      }
      accounts[email].hash = await hashPassword(n1.value, email);
      saveAccounts(accounts);
      form.reset();
      $$(".field", form).forEach(f => setState(f, "", false));
      $("#meter").dataset.level = "";
      $("#meter-label").textContent = "Mínimo 8 caracteres.";
      msg.className = "form-msg ok";
      msg.textContent = "Contraseña actualizada.";
    });

    $("#logout-btn").addEventListener("click", () => { endSession(); location.href = PAGE.inicio; });
    $("#delete-btn").addEventListener("click", () => {
      if (!confirm("¿Eliminar tu cuenta? Se borrarán tus datos, favoritos y preferencias de este navegador. Esta acción no se puede deshacer.")) return;
      const accounts = getAccounts();
      delete accounts[email];
      saveAccounts(accounts);
      [`das-favs:${email}`, prefsKey, photoKey, `das-notes:${email}`].forEach(k => store.remove(k));
      endSession();
      location.href = PAGE.inicio;
    });
  }

  /* ---------- Favoritos ---------- */
  function initFavoritos() {
    function render() {
      const list = favProducts();
      $("#favs-count").textContent = `${list.length} ${list.length === 1 ? "favorito" : "favoritos"}`;
      $("#favs-empty").hidden = list.length > 0;
      mount($("#favs-grid"), list.map(productCard).join(""));
    }
    render();
    document.addEventListener("das-favs", render);
  }

  const pages = { dashboard: initDashboard, perfil: initPerfil, configuracion: initConfig, favoritos: initFavoritos };
  if (pages[page]) pages[page]();
})();