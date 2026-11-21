/* DAS Panadería · Catálogo: categorías, preferencias, precio, búsqueda y orden. Todo se aplica al instante. */
const state = { cat: "Todo", prefs: new Set(), max: 20000, q: "", sort: "rec" };
const catList = $("#cat-list");
const prefsBox = $("#prefs");
const grid = $("#grid");
const count = $("#count");
const empty = $("#empty");
const endNote = $("#end-note");
const priceInput = $("#price");
const priceOut = $("#price-out");
const filters = $("#filters");
const toggle = $("#filters-toggle");

function renderCats() {
  const items = [["Todo", "Todo el obrador", PRODUCTS.length], ...CATEGORIES.map(c => [c, c, PRODUCTS.filter(p => p.cat === c).length])];
  catList.innerHTML = items.map(([key, label, n]) =>
    `<li><button type="button" class="cat-item" data-cat="${esc(key)}" aria-pressed="${state.cat === key}">${esc(label)}<small>${pad(n)}</small></button></li>`).join("");
}
function renderPrefs() {
  prefsBox.innerHTML = Object.entries(PREFS).map(([key, label]) =>
    `<label class="pref"><input type="checkbox" value="${key}" ${state.prefs.has(key) ? "checked" : ""}>${esc(label)}</label>`).join("");
}
function matches(p) {
  if (state.cat !== "Todo" && p.cat !== state.cat) return false;
  for (const k of state.prefs) if (!p.prefs.includes(k)) return false;
  if (p.price > state.max) return false;
  if (state.q.trim()) {
    const hay = norm([p.name, p.meta, p.cat, p.chip, p.ing, p.desc].join(" "));
    if (!norm(state.q).split(/\s+/).filter(Boolean).every(w => hay.includes(w))) return false;
  }
  return true;
}
function render() {
  const list = PRODUCTS.filter(matches);
  if (state.sort === "asc") list.sort((a, b) => a.price - b.price);
  if (state.sort === "desc") list.sort((a, b) => b.price - a.price);
  if (state.sort === "az") list.sort((a, b) => a.name.localeCompare(b.name, "es"));
  mount(grid, list.map(productCard).join(""));
  count.textContent = `${list.length} ${list.length === 1 ? "producto" : "productos"} · Hechos con calma`;
  empty.hidden = list.length > 0;
  endNote.hidden = list.length === 0;
}
function reset() {
  state.cat = "Todo"; state.prefs = new Set(); state.max = 20000; state.q = ""; state.sort = "rec";
  $("#q").value = ""; $("#sort").value = "rec"; priceInput.value = 20000;
  priceOut.textContent = money(20000);
  renderCats(); renderPrefs(); render();
}

catList.addEventListener("click", e => {
  const b = e.target.closest("[data-cat]");
  if (!b) return;
  state.cat = b.dataset.cat;
  renderCats(); render();
});
prefsBox.addEventListener("change", e => {
  if (e.target.checked) state.prefs.add(e.target.value); else state.prefs.delete(e.target.value);
  render();
});
priceInput.addEventListener("input", () => { state.max = Number(priceInput.value); priceOut.textContent = money(state.max); render(); });
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

priceOut.textContent = money(state.max);
renderCats();
renderPrefs();
render();