/* DAS Panadería · núcleo común de todas las páginas: rutas, datos del negocio, cuentas, favoritos y tarjetas.
   Las rutas se calculan desde la ubicación de este archivo, así funcionan desde cualquier carpeta. */
const SCRIPT_SRC = (document.currentScript && document.currentScript.src) || (document.querySelector('script[src$="global.js"]') || {}).src || location.href;
const SITE_ROOT = new URL("../../", SCRIPT_SRC).href;
const siteUrl = path => new URL(path, SITE_ROOT).href;
const PAGE = {
  inicio: siteUrl("presentation/index.html"),
  catalogo: siteUrl("presentation/pages/catalogo.html"),
  ubicaciones: siteUrl("presentation/pages/ubicaciones.html"),
  envios: siteUrl("presentation/pages/ubicaciones.html#envios"),
  nosotros: siteUrl("presentation/pages/nosotros.html"),
  contacto: siteUrl("presentation/pages/contacto.html"),
  login: siteUrl("presentation/auth/login.html"),
  registro: siteUrl("presentation/auth/register.html"),
  recuperar: siteUrl("presentation/auth/recuperar-password.html"),
  verificar: siteUrl("presentation/auth/verificar-correo.html"),
  nueva: siteUrl("presentation/auth/nueva-password.html"),
  confirmacion: siteUrl("presentation/auth/confirmacion.html"),
  panel: siteUrl("functionality/dashboard.html"),
  favoritos: siteUrl("functionality/pages/favoritos.html"),
  perfil: siteUrl("functionality/pages/perfil.html"),
  configuracion: siteUrl("functionality/pages/configuracion.html")
};
const IMG = siteUrl("assets/images/");

/* ---------- Ayudas ---------- */
const $ = (selector, root = document) => root.querySelector(selector);
const $$ = (selector, root = document) => [...root.querySelectorAll(selector)];
const esc = s => String(s).replace(/[&<>"']/g, c => ({ "&": "&amp;", "<": "&lt;", ">": "&gt;", '"': "&quot;", "'": "&#39;" }[c]));
const pad = n => String(n).padStart(2, "0");
const norm = s => String(s).normalize("NFD").replace(/[\u0300-\u036f]/g, "").toLowerCase();
const sleep = ms => new Promise(resolve => setTimeout(resolve, ms));
const store = {
  get(key) { try { return localStorage.getItem(key); } catch { return null; } },
  set(key, value) { try { localStorage.setItem(key, value); return true; } catch { return false; } },
  remove(key) { try { localStorage.removeItem(key); } catch {} }
};
const readJSON = (key, fallback) => { try { const v = JSON.parse(store.get(key)); return v == null ? fallback : v; } catch { return fallback; } };
const ARROW = '<svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M3 8h10M9 4l4 4-4 4"/></svg>';
const HEART = '<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 20.5s-7.5-4.6-7.5-10.2A4.3 4.3 0 0 1 12 7.6a4.3 4.3 0 0 1 7.5 2.7c0 5.6-7.5 10.2-7.5 10.2z"/></svg>';

/* ---------- Datos del negocio (cámbialos aquí y se actualizan todas las páginas) ---------- */
const CURRENCY = { locale: "es-CO", code: "COP" };
const money = n => new Intl.NumberFormat(CURRENCY.locale, { style: "currency", currency: CURRENCY.code, maximumFractionDigits: 0 }).format(n);
const HORARIO = { semana: "Lun–sáb · 07:30–20:00", domingo: "Dom · 08:00–14:00" };
const LOCALIDADES = ["Usaquén", "Chapinero", "Kennedy", "Usme"];
const STORES = [
  { id: "patio-bonito", name: "Patio Bonito", tag: "Hogar principal", localidad: "Kennedy", address: "", phone: "", img: "loc-patio-bonito" },
  { id: "usme", name: "Usme", tag: "Nuevo hogar", localidad: "Usme", address: "", phone: "", img: "loc-usme" }
];
const CATEGORIES = ["Panes artesanos", "Bollería", "Dulces", "De temporada"];
const PREFS = { "masa-madre": "Masa madre", "integral": "Integral", "sin-lacteos": "Sin ingredientes lácteos" };
/* Información de ejemplo: confirma ingredientes y alérgenos reales con el obrador antes de publicar. */
const PRODUCTS = [
  { id: "hogaza", name: "Hogaza de la casa", cat: "Panes artesanos", chip: "Masa madre", meta: "Trigo · 750 g · Masa madre", price: 18500, prefs: ["masa-madre", "sin-lacteos"], fav: true, img: "pan-hogaza",
    desc: "Nuestra pieza insignia: 24 horas de fermentación lenta, corteza crujiente y una miga abierta y jugosa.", ing: "Harina de trigo, agua, sal y masa madre." },
  { id: "croissant", name: "Croissant de mantequilla", cat: "Bollería", chip: "Bollería", meta: "Mantequilla · 80 g · Hojaldre", price: 7500, prefs: [], fav: true, img: "pan-croissant",
    desc: "Hojaldre dorado y ligero, laminado a mano con mantequilla.", ing: "Harina de trigo, mantequilla, leche, huevo, azúcar, levadura y sal." },
  { id: "semillas", name: "Pan de semillas", cat: "Panes artesanos", chip: "Integral", meta: "Integral · 600 g · Multicereal", price: 16000, prefs: ["integral", "masa-madre", "sin-lacteos"], fav: true, img: "pan-semillas",
    desc: "Pan integral con una mezcla de semillas que le da sabor profundo y mucha textura.", ing: "Harina integral, harina de trigo, semillas variadas, agua, sal y masa madre." },
  { id: "roll", name: "Roll de canela", cat: "Bollería", chip: "Bollería", meta: "Canela · 120 g · Horneado hoy", price: 9500, prefs: [], fav: true, img: "pan-roll-canela",
    desc: "Masa suave enrollada con canela y azúcar, horneada cada mañana.", ing: "Harina de trigo, mantequilla, leche, huevo, azúcar, canela, levadura y sal." },
  { id: "baguette", name: "Baguette rústica", cat: "Panes artesanos", chip: "Pan artesano", meta: "Trigo · 250 g · Corteza fina", price: 6500, prefs: ["sin-lacteos"], fav: false, img: "pan-baguette",
    desc: "Corteza fina que cruje y miga ligera. Perfecta para compartir.", ing: "Harina de trigo, agua, sal y levadura." },
  { id: "napolitana", name: "Napolitana de chocolate", cat: "Bollería", chip: "Bollería", meta: "Chocolate · 100 g · Hojaldre", price: 8500, prefs: [], fav: false, img: "pan-napolitana",
    desc: "Hojaldre crujiente relleno de chocolate.", ing: "Harina de trigo, mantequilla, chocolate, leche, azúcar, levadura y sal." }
];
const productImg = p => `${IMG}products/${p.img}.jpg`;
const storeImg = s => `${IMG}locations/${s.img}.jpg`;

/* ---------- Sesión y cuentas (demostración en el navegador hasta que exista el backend) ---------- */
function getSession() { return readJSON("das-session", null); }
function startSession(email, name) { store.set("das-session", JSON.stringify({ email, name })); }
function endSession() { store.remove("das-session"); }
function requireSession() {
  const s = getSession();
  if (!s) { location.replace(PAGE.login); return null; }
  return s;
}
function initialsOf(name) {
  const parts = String(name || "").trim().split(/\s+/).filter(Boolean);
  if (!parts.length) return "DA";
  return (parts[0][0] + (parts[1] ? parts[1][0] : "")).toUpperCase();
}
function getAccounts() { return readJSON("das-accounts", {}); }
function saveAccounts(accounts) { return store.set("das-accounts", JSON.stringify(accounts)); }

/* SHA-256 escrito a mano: se usa solo si el navegador no ofrece crypto.subtle (por ejemplo, fuera de https o localhost).
   Así la contraseña nunca se guarda en texto claro. */
function sha256Hex(text) {
  const K = [
    0x428a2f98, 0x71374491, 0xb5c0fbcf, 0xe9b5dba5, 0x3956c25b, 0x59f111f1, 0x923f82a4, 0xab1c5ed5,
    0xd807aa98, 0x12835b01, 0x243185be, 0x550c7dc3, 0x72be5d74, 0x80deb1fe, 0x9bdc06a7, 0xc19bf174,
    0xe49b69c1, 0xefbe4786, 0x0fc19dc6, 0x240ca1cc, 0x2de92c6f, 0x4a7484aa, 0x5cb0a9dc, 0x76f988da,
    0x983e5152, 0xa831c66d, 0xb00327c8, 0xbf597fc7, 0xc6e00bf3, 0xd5a79147, 0x06ca6351, 0x14292967,
    0x27b70a85, 0x2e1b2138, 0x4d2c6dfc, 0x53380d13, 0x650a7354, 0x766a0abb, 0x81c2c92e, 0x92722c85,
    0xa2bfe8a1, 0xa81a664b, 0xc24b8b70, 0xc76c51a3, 0xd192e819, 0xd6990624, 0xf40e3585, 0x106aa070,
    0x19a4c116, 0x1e376c08, 0x2748774c, 0x34b0bcb5, 0x391c0cb3, 0x4ed8aa4a, 0x5b9cca4f, 0x682e6ff3,
    0x748f82ee, 0x78a5636f, 0x84c87814, 0x8cc70208, 0x90befffa, 0xa4506ceb, 0xbef9a3f7, 0xc67178f2
  ];
  const rotr = (x, n) => (x >>> n) | (x << (32 - n));
  const data = new TextEncoder().encode(text);
  const len = data.length;
  const padded = new Uint8Array(((len + 9 + 63) >> 6) << 6);
  padded.set(data);
  padded[len] = 0x80;
  const view = new DataView(padded.buffer);
  view.setUint32(padded.length - 8, Math.floor((len * 8) / 2 ** 32));
  view.setUint32(padded.length - 4, (len * 8) >>> 0);
  const H = [0x6a09e667, 0xbb67ae85, 0x3c6ef372, 0xa54ff53a, 0x510e527f, 0x9b05688c, 0x1f83d9ab, 0x5be0cd19];
  const w = new Uint32Array(64);
  for (let off = 0; off < padded.length; off += 64) {
    for (let i = 0; i < 16; i++) w[i] = view.getUint32(off + i * 4);
    for (let i = 16; i < 64; i++) {
      const s0 = rotr(w[i - 15], 7) ^ rotr(w[i - 15], 18) ^ (w[i - 15] >>> 3);
      const s1 = rotr(w[i - 2], 17) ^ rotr(w[i - 2], 19) ^ (w[i - 2] >>> 10);
      w[i] = (w[i - 16] + s0 + w[i - 7] + s1) >>> 0;
    }
    let [a, b, c, d, e, f, g, h] = H;
    for (let i = 0; i < 64; i++) {
      const S1 = rotr(e, 6) ^ rotr(e, 11) ^ rotr(e, 25);
      const ch = (e & f) ^ (~e & g);
      const t1 = (h + S1 + ch + K[i] + w[i]) >>> 0;
      const S0 = rotr(a, 2) ^ rotr(a, 13) ^ rotr(a, 22);
      const maj = (a & b) ^ (a & c) ^ (b & c);
      const t2 = (S0 + maj) >>> 0;
      h = g; g = f; f = e; e = (d + t1) >>> 0; d = c; c = b; b = a; a = (t1 + t2) >>> 0;
    }
    [a, b, c, d, e, f, g, h].forEach((v, i) => { H[i] = (H[i] + v) >>> 0; });
  }
  return H.map(x => x.toString(16).padStart(8, "0")).join("");
}
async function hashPassword(password, email) {
  const text = email + "::" + password;
  if (window.crypto && crypto.subtle) {
    const digest = await crypto.subtle.digest("SHA-256", new TextEncoder().encode(text));
    return "sha256:" + [...new Uint8Array(digest)].map(b => b.toString(16).padStart(2, "0")).join("");
  }
  return "sha256:" + sha256Hex(text);
}
async function passwordMatches(account, password, email) {
  if (account.hash.startsWith("plain:")) return account.hash === "plain:" + password;
  return account.hash === await hashPassword(password, email);
}

/* ---------- Favoritos (por usuario) ---------- */
const favKey = () => { const s = getSession(); return s ? "das-favs:" + s.email : null; };
function getFavs() { const k = favKey(); return k ? readJSON(k, []) : []; }
function isFav(id) { return getFavs().includes(id); }
function toggleFav(id) {
  const k = favKey();
  if (!k) return null;
  const list = getFavs();
  const i = list.indexOf(id);
  if (i >= 0) list.splice(i, 1); else list.push(id);
  store.set(k, JSON.stringify(list));
  document.dispatchEvent(new CustomEvent("das-favs"));
  return i < 0;
}
document.addEventListener("click", e => {
  const button = e.target.closest("[data-fav]");
  if (!button) return;
  e.preventDefault();
  e.stopPropagation();
  const state = toggleFav(button.dataset.fav);
  if (state === null) { toast("Inicia sesión para guardar tus favoritos.", { label: "Iniciar sesión", href: PAGE.login }); return; }
  $$(`[data-fav="${button.dataset.fav}"]`).forEach(b => { b.classList.toggle("on", state); b.setAttribute("aria-pressed", String(state)); });
  toast(state ? "Guardado en tus favoritos." : "Quitado de tus favoritos.");
});

/* ---------- Imágenes: si un archivo no existe se oculta y queda el fondo cálido ---------- */
function hideBroken(root = document) {
  $$("img", root).forEach(img => {
    if (img.dataset.watched) return;
    img.dataset.watched = "1";
    const hide = () => { img.style.display = "none"; };
    if (img.complete && img.naturalWidth === 0 && img.getAttribute("src")) hide();
    else img.addEventListener("error", hide);
  });
}

/* ---------- Aparición suave al hacer scroll ---------- */
let fadeObserver = null;
function observeFade(root = document) {
  const items = $$(".fade-in:not(.in)", root);
  if (!("IntersectionObserver" in window)) { items.forEach(i => i.classList.add("in")); return; }
  fadeObserver = fadeObserver || new IntersectionObserver(entries => {
    entries.forEach(e => { if (e.isIntersecting) { e.target.classList.add("in"); fadeObserver.unobserve(e.target); } });
  }, { threshold: 0.12 });
  items.forEach(i => fadeObserver.observe(i));
}
function mount(element, html) {
  element.innerHTML = html;
  hideBroken(element);
  observeFade(element);
}

/* ---------- Tarjeta de producto (Inicio, Catálogo, Favoritos y Panel) ---------- */
function productCard(p) {
  const fav = isFav(p.id);
  return `<article class="product fade-in" data-id="${p.id}">
    <div class="thumb"><img src="${productImg(p)}" alt="${esc(p.name)}" loading="lazy"><span class="chip">${esc(p.chip)}</span><button type="button" class="fav ${fav ? "on" : ""}" data-fav="${p.id}" aria-pressed="${fav}" aria-label="Guardar ${esc(p.name)} en favoritos">${HEART}</button></div>
    <h3>${esc(p.name)}</h3>
    <p class="meta">${esc(p.meta)}</p>
    <div class="product-foot"><span class="price">${money(p.price)}</span><button type="button" class="go" data-product="${p.id}" aria-label="Ver detalle de ${esc(p.name)}">${ARROW}</button></div>
  </article>`;
}

hideBroken();
observeFade();

/* ---------- Verificación de correo y recuperación (demostración sin servidor de correo) ---------- */
const PENDING_KEY = "das-pending";
const RESET_KEY = "das-reset";
const CODE_MINUTES = 10;
function randomCode() {
  const array = new Uint32Array(1);
  if (window.crypto && crypto.getRandomValues) crypto.getRandomValues(array); else array[0] = Math.floor(Math.random() * 4294967295);
  return String(100000 + (array[0] % 900000));
}
/* withCode=false se usa cuando el correo no tiene cuenta: se sigue el mismo camino pero no hay código. */
function createPending(email, flow, withCode = true) {
  const pending = { email, flow, code: withCode ? randomCode() : null, ts: Date.now(), attempts: 0 };
  store.set(PENDING_KEY, JSON.stringify(pending));
  return pending;
}
function getPending() {
  const pending = readJSON(PENDING_KEY, null);
  if (!pending) return null;
  if (Date.now() - pending.ts > CODE_MINUTES * 60 * 1000) { store.remove(PENDING_KEY); return null; }
  return pending;
}
function savePending(pending) { store.set(PENDING_KEY, JSON.stringify(pending)); }
function clearPending() { store.remove(PENDING_KEY); }
function maskEmail(email) {
  const [user, domain] = String(email).split("@");
  if (!domain) return email;
  return user.slice(0, 1) + "•••" + "@" + domain;
}