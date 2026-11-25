/* DAS Panadería · Inicio, Nosotros y Contacto. */
const favGrid = $("#fav-grid");
if (favGrid) mount(favGrid, PRODUCTS.filter(p => p.fav).map(productCard).join(""));

/* Formulario de contacto (se guarda en este navegador hasta que exista el backend) */
const contactForm = $("#contact-form");
if (contactForm) {
const fields = { name: $("#cf-name"), mail: $("#cf-mail"), topic: $("#cf-topic"), msg: $("#cf-msg") };
const rules = {
    name: () => validateName(fields.name.value, "nombre"),
    mail: () => validateEmail(fields.mail.value),
    topic: () => (fields.topic.value ? "" : "Elige el tema de tu mensaje."),
    msg: () => (fields.msg.value.trim().length >= 10 ? "" : "Cuéntanos un poco más (mínimo 10 caracteres).")
};
const show = (key, error) => {
    const wrap = fields[key].closest(".cf-field");
    wrap.classList.toggle("bad", !!error);
    $(".cf-err", wrap).textContent = error;
};
const session = getSession();
if (session) { fields.name.value = session.name || ""; fields.mail.value = session.email || ""; }
Object.keys(fields).forEach(k => fields[k].addEventListener("blur", () => show(k, rules[k]())));
contactForm.addEventListener("submit", e => {
    e.preventDefault();
    const feedback = $("#cf-feedback");
    let first = null;
    Object.keys(rules).forEach(k => { const err = rules[k](); show(k, err); if (err && !first) first = k; });
    if (first) { fields[first].focus(); feedback.textContent = ""; return; }
    const list = readJSON("das-mensajes", []);
    list.push({ nombre: fields.name.value.trim(), correo: fields.mail.value.trim(), tema: fields.topic.value, mensaje: fields.msg.value.trim(), ts: Date.now() });
    store.set("das-mensajes", JSON.stringify(list));
    feedback.textContent = `¡Gracias, ${fields.name.value.trim().split(" ")[0]}! Te responderemos en horario de tienda.`;
    contactForm.reset();
    if (session) { fields.name.value = session.name || ""; fields.mail.value = session.email || ""; }
});
}