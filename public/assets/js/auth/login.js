/* DAS Panadería · inicio de sesión (demostración en el navegador hasta que exista el backend). */
const form = $("#login-form");
const submitButton = $("#submit");
const formMessage = $("#form-msg");
const emailInput = $("#email");
const passwordInput = $("#password");
const emailField = $("#email-field");
const passwordField = $("#password-field");

const rules = {
email: () => validateEmail(emailInput.value),
password: () => (passwordInput.value ? "" : "Escribe tu contraseña.")
};
const fields = { email: [emailField, emailInput], password: [passwordField, passwordInput] };
const touched = new Set();
function validate(name, show = true) {
const error = rules[name]();
if (show) setState(fields[name][0], error, name === "email" && !error);
return !error;
}
Object.entries(fields).forEach(([name, [, input]]) => {
input.addEventListener("input", () => { formMessage.textContent = ""; if (touched.has(name)) validate(name); });
input.addEventListener("blur", () => { touched.add(name); validate(name); });
});

let sending = false;
form.addEventListener("submit", async event => {
event.preventDefault();
if (sending) return;
touched.add("email"); touched.add("password");
const emailOk = validate("email");
const passOk = validate("password");
if (!emailOk || !passOk) {
    (emailOk ? passwordInput : emailInput).focus();
    shake(form);
    return;
}
sending = true;
formMessage.textContent = "";
setLoading(submitButton, true);
const email = emailInput.value.trim().toLowerCase();
const account = getAccounts()[email];
await sleep(600);
if (account && await passwordMatches(account, passwordInput.value, email)) {
    if (account.verified === false) {
    sending = false;
    setLoading(submitButton, false);
    formMessage.textContent = "Aún no verificas tu correo. ";
    const again = document.createElement("button");
    again.type = "button";
    again.className = "link-btn";
    again.textContent = "Verificar ahora";
    again.addEventListener("click", () => { createPending(email, "registro"); location.href = PAGE.verificar; });
    formMessage.appendChild(again);
    return;
    }
    startSession(email, account.name);
    const first = (account.first || account.name || "").split(" ")[0];
    showSuccess("¡Bienvenido de nuevo!", first ? `Hola, ${first}. Entrando a tu panel…` : "Entrando a tu panel…", PAGE.panel, 1500);
    return;
}
sending = false;
setLoading(submitButton, false);
formMessage.textContent = "Correo o contraseña incorrectos. Si no tienes cuenta, regístrate.";
shake(form);
});