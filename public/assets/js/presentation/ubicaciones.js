/* DAS Panadería · Visítanos (ubicaciones) y Envíos y entregas (cobertura). */
const state = { loc: "Todas", q: "", sort: "rec" };
const locList = $("#loc-list");
const grid = $("#grid");
const count = $("#count");
const empty = $("#empty");
const filters = $("#filters");
const toggle = $("#filters-toggle");

/* ---------- Ubicaciones ---------- */
function mapsUrl(s) { return "https://www.google.com/maps/search/?api=1&query=" + encodeURIComponent(`DAS Panadería ${s.name} Bogotá`); }
function storeCard(s) {
return `<article class="store fade-in">
    <div class="thumb"><img src="${storeImg(s)}" alt="DAS ${esc(s.name)}" loading="lazy"><span class="chip">${esc(s.tag)}</span></div>
    <h3>${esc(s.name)}</h3>
    <dl>
    <div><dt>Localidad</dt><dd>${esc(s.localidad)}</dd></div>
    <div><dt>Dirección</dt><dd>${s.address ? esc(s.address) : "Por confirmar"}</dd></div>
    <div><dt>Teléfono</dt><dd>${s.phone ? esc(s.phone) : "Por confirmar"}</dd></div>
    <div><dt>Horario</dt><dd>${HORARIO.semana}<br>${HORARIO.domingo}</dd></div>
    </dl>
    <div class="store-foot"><span>Visítanos</span><a class="go" href="${mapsUrl(s)}" target="_blank" rel="noopener noreferrer" aria-label="Cómo llegar a DAS ${esc(s.name)} (se abre en una pestaña nueva)">${ARROW}</a></div>
</article>`;
}
function renderLocs() {
const items = [["Todas", "Todas | Bogotá", STORES.length], ...LOCALIDADES.map(l => [l, l, STORES.filter(s => s.localidad === l).length])];
locList.innerHTML = items.map(([key, label, n]) =>
    `<li><button type="button" class="cat-item" data-loc="${esc(key)}" aria-pressed="${state.loc === key}">${esc(label)}<small>${pad(n)}</small></button></li>`).join("");
}
function render() {
const list = STORES.filter(s => (state.loc === "Todas" || s.localidad === state.loc) &&
    (!state.q.trim() || norm([s.name, s.localidad, s.tag].join(" ")).includes(norm(state.q.trim()))));
if (state.sort === "az") list.sort((a, b) => a.name.localeCompare(b.name, "es"));
mount(grid, list.map(storeCard).join(""));
count.textContent = `${list.length} ${list.length === 1 ? "ubicación" : "ubicaciones"} · Siempre cerca de ti`;
empty.hidden = list.length > 0;
}
function reset() {
state.loc = "Todas"; state.q = ""; state.sort = "rec";
$("#q").value = ""; $("#sort").value = "rec";
renderLocs(); render();
}
locList.addEventListener("click", e => {
const b = e.target.closest("[data-loc]");
if (!b) return;
state.loc = b.dataset.loc;
renderLocs(); render();
});
$("#q").addEventListener("input", e => { state.q = e.target.value; render(); });
$("#sort").addEventListener("change", e => { state.sort = e.target.value; render(); });
$("#clear").addEventListener("click", reset);
$("#empty-clear").addEventListener("click", reset);
$("#apply").addEventListener("click", () => {
filters.classList.remove("open");
toggle.setAttribute("aria-expanded", "false");
grid.scrollIntoView({ behavior: "smooth", block: "start" });
});
toggle.addEventListener("click", () => {
const open = filters.classList.toggle("open");
toggle.setAttribute("aria-expanded", String(open));
});

/* ---------- Sugerencia de nueva ubicación (se guarda en este navegador hasta que exista el backend) ---------- */
const suggestLoc = $("#s-loc");
LOCALIDADES.forEach(l => suggestLoc.insertAdjacentHTML("beforeend", `<option value="${esc(l)}">${esc(l)}</option>`));
$("#sugerir").addEventListener("submit", e => {
  e.preventDefault();
  const msg = $("#s-msg");
  const mail = $("#s-mail").value.trim();
  msg.className = "suggest-msg err";
  if (!suggestLoc.value) { msg.textContent = "Elige tu localidad."; return; }
  const mailError = validateEmail(mail);
  if (mailError) { msg.textContent = mailError; return; }
  const list = readJSON("das-sugerencias", []);
  list.push({ localidad: suggestLoc.value, correo: mail, ts: Date.now() });
  store.set("das-sugerencias", JSON.stringify(list));
  msg.className = "suggest-msg";
  msg.textContent = "¡Gracias! Tendremos en cuenta tu sugerencia.";
  e.target.reset();
});

/* ---------- Envíos y entregas: cobertura por localidad ---------- */
const covSelect = $("#loc");
const covResult = $("#cov-result");
LOCALIDADES.forEach(l => covSelect.insertAdjacentHTML("beforeend", `<option value="${esc(l)}">${esc(l)}</option>`));
function showCoverage(loc) {
  if (!loc) { covResult.className = "cov-result"; covResult.innerHTML = '<p class="muted">Aquí verás las opciones para tu localidad.</p>'; return; }
  const found = STORES.find(s => s.localidad === loc);
  if (found) {
    covResult.className = "cov-result ok";
    covResult.innerHTML = `<strong>¡Sí llegamos a ${esc(loc)}!</strong>Hacemos domicilios desde DAS ${esc(found.name)}, en dos ventanas: mañana (07:30–10:30) y tarde (15:00–18:00).<div class="chips"><span>Envío a domicilio</span><span>Recogida en ${esc(found.name)}</span></div>`;
  } else {
    const names = STORES.map(s => s.name).join(" o ");
    covResult.className = "cov-result";
    covResult.innerHTML = `<strong>Todavía no llegamos a ${esc(loc)}.</strong>Por ahora puedes recoger tu pedido en ${esc(names)}. ¿Quieres un DAS cerca de ti? <a href="#sugerir">Cuéntanos tu localidad</a>.<div class="chips"><span>Recogida en tienda</span><span>Domicilio: próximamente</span></div>`;
  }
}
covSelect.addEventListener("change", () => showCoverage(covSelect.value));

renderLocs();
render();