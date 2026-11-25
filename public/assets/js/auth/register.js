/* DAS Panadería · registro: validación campo por campo, teléfono por país, pasos y creación de cuenta (demostración). */
const form = $("#register-form");
const submitButton = $("#submit");
const formMessage = $("#form-msg");
const el = {
  first: $("#first"), last: $("#last"), email: $("#email"),
  country: $("#phone-country"), number: $("#phone-number"),
  lang: $("#lang"), password: $("#password"), terms: $("#terms")
};
const fieldOf = {
  first: $("#first-field"), last: $("#last-field"), email: $("#email-field"),
  phone: $("#phone-field"), lang: $("#lang-field"), password: $("#password-field"), terms: $("#terms-field")
};
const inputsOf = {
  first: [el.first], last: [el.last], email: [el.email],
  phone: [el.country, el.number], lang: [el.lang], password: [el.password], terms: [el.terms]
};

const rules = {
  first: () => validateName(el.first.value, "nombre"),
  last: () => validateName(el.last.value, "apellido"),
  email: () => validateEmail(el.email.value),
  phone: () => validatePhone(el.country.value, el.number.value),
  lang: () => (el.lang.value ? "" : "Elige tu país e idioma."),
  password: () => validateNewPassword(el.password.value),
  terms: () => (el.terms.checked ? "" : "Debes aceptar para continuar.")
};
const touched = new Set();
function validate(name, show = true) {
  const error = rules[name]();
  if (show) setState(fieldOf[name], error, !error);
  return !error;
}

/* Pasos del panel y barra del celular */
const steps = $$("#steps .step");
const segments = $$("#seg-progress i");
function updateSteps() {
  const dataOk = ["first", "last", "email", "phone", "lang"].every(n => !rules[n]());
  const passOk = !rules.password();
  const active = !dataOk ? 1 : !passOk ? 2 : 3;
  const ready = active === 3 && !rules.terms();
  steps.forEach(li => {
    const n = Number(li.dataset.step);
    const done = n < active || (n === 3 && ready);
    li.classList.toggle("is-active", n === active && !done);
    li.classList.toggle("is-done", done);
    $(".num", li).textContent = done ? "✓" : String(n);
  });
  segments.forEach((seg, i) => seg.classList.toggle("on", i < active));
}

Object.entries(inputsOf).forEach(([name, inputs]) => {
  inputs.forEach(input => {
    input.addEventListener(input.type === "checkbox" || input.tagName === "SELECT" ? "change" : "input", () => {
      if (touched.has(name)) validate(name);
      updateSteps();
    });
    input.addEventListener("blur", () => {
      if (name === "phone" && input === el.country && !el.number.value) return;
      touched.add(name);
      validate(name);
      updateSteps();
    });
  });
});

/* Teléfono: al elegir el país aparece la casilla del número con el teclado numérico */
const phoneReveal = $("#phone-reveal");
el.country.addEventListener("change", () => {
  const info = PHONE[el.country.value];
  if (!info) return;
  $("#phone-prefix").textContent = info.prefix;
  el.number.placeholder = info.placeholder;
  el.number.value = formatPhone(el.country.value, el.number.value);
  phoneReveal.inert = false;
  phoneReveal.classList.add("open");
  setTimeout(() => el.number.focus(), 160);
  if (touched.has("phone")) validate("phone");
});
el.number.addEventListener("input", () => {
  el.number.value = formatPhone(el.country.value, el.number.value);
});

bindMeter(el.password, $("#meter"), $("#meter-label"), "Mínimo 8 caracteres.");

/* Celular: bienvenida → formulario */
$("#go-form").addEventListener("click", () => {
  document.body.classList.add("show-form");
  window.scrollTo({ top: 0, behavior: "smooth" });
});
$("#back-welcome").addEventListener("click", () => {
  document.body.classList.remove("show-form");
  window.scrollTo({ top: 0, behavior: "smooth" });
});

/* Enviar */
let sending = false;
form.addEventListener("submit", async event => {
  event.preventDefault();
  if (sending) return;
  const order = ["first", "last", "email", "phone", "lang", "password", "terms"];
  let firstBad = null;
  order.forEach(name => {
    touched.add(name);
    if (!validate(name) && !firstBad) firstBad = name;
  });
  updateSteps();
  if (firstBad) {
    formMessage.textContent = "Revisa los campos marcados.";
    const target = firstBad === "phone" && el.country.value ? el.number : inputsOf[firstBad][0];
    target.focus();
    shake(form);
    return;
  }
  formMessage.textContent = "";
  sending = true;
  setLoading(submitButton, true);

  const email = el.email.value.trim().toLowerCase();
  const accounts = getAccounts();
  await sleep(650);
  if (accounts[email]) {
    sending = false;
    setLoading(submitButton, false);
    setState(fieldOf.email, "Ese correo ya tiene una cuenta. Inicia sesión.", false);
    el.email.focus();
    shake(form);
    return;
  }
  const first = el.first.value.trim();
  const last = el.last.value.trim();
  const [country, lang] = el.lang.value.split("-");
  accounts[email] = {
    name: `${first} ${last}`, first, last,
    phone: { country: el.country.value, prefix: PHONE[el.country.value].prefix, number: digits(el.number.value) },
    country, lang, verified: false, createdAt: Date.now(),
    hash: await hashPassword(el.password.value, email)
  };
  if (!saveAccounts(accounts)) {
    sending = false;
    setLoading(submitButton, false);
    formMessage.textContent = "Tu navegador no permite guardar la cuenta (¿modo privado?). Prueba en una ventana normal.";
    return;
  }
  store.set("das-lang", lang);
  createPending(email, "registro");
  showSuccess("¡Cuenta creada!", `Casi listo, ${first}. Ahora verifica tu correo.`, PAGE.verificar);
});

updateSteps();