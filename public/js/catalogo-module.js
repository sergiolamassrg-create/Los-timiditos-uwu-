import { CATALOG } from './catalog-data.js';

const filtersForm = document.getElementById('catalogFilters');
const ACTIVE_CATALOG =
  Array.isArray(window.__TAPISUR_CATALOG__) && window.__TAPISUR_CATALOG__.length
    ? window.__TAPISUR_CATALOG__
    : CATALOG;
const APP_BASE_PATH = window.__APP_BASE_PATH__ || '';
const categoryGroup = document.getElementById('categoryGroup');
const materialGroup = document.getElementById('materialGroup');
const featuresGroup = document.getElementById('featuresGroup');
const searchInput = document.getElementById('searchInput');
const seatsSelect = document.getElementById('seatsSelect');
const sortSelect = document.getElementById('sortSelect');
const featuredOnly = document.getElementById('featuredOnly');
const resetBtn = document.getElementById('resetFilters');
const resultsNode = document.getElementById('resultsCount');
const gridNode = document.getElementById('catalogGrid');
const detailModal = document.getElementById('detailModal');
const modalBody = document.getElementById('modalBody');
const closeModalBtn = document.getElementById('closeModal');
const filtersToggle = document.getElementById('filtersToggle');
const filtersBody = document.getElementById('filtersBody');

const state = {
  search: '',
  categories: new Set(),
  materials: new Set(),
  features: new Set(),
  seats: 'all',
  sort: 'featured',
  featuredOnly: false
};

const fabricDescriptions = {
  chenille: 'Tela suave y resistente, ideal para sillones de uso diario por su textura calida y buen cuerpo.',
  pana: 'Textura aterciopelada y confortable, con una presencia visual mas marcada.',
  cuero: 'Terminacion elegante y facil de limpiar, recomendada para un estilo clasico o moderno.',
  cuerina: 'Alternativa practica de mantenimiento simple para espacios de mucho uso.',
  lino: 'Aspecto natural y fresco, ideal para ambientes claros y livianos.',
  bouclé: 'Tela con textura rizada y tacto mullido, muy usada en diseños contemporaneos.',
  boucle: 'Tela con textura rizada y tacto mullido, muy usada en diseños contemporaneos.',
  velvet: 'Acabado suave con brillo sutil, pensado para una terminacion mas sofisticada.',
  default: 'Material personalizable. TAPISUR puede asesorarte segun uso, estilo del ambiente y mantenimiento esperado.'
};

function optionList(values, selectedValue = '') {
  return values
    .map((value) => `<option value="${value}" ${value === selectedValue ? 'selected' : ''}>${value}</option>`)
    .join('');
}

function fabricDescription(material) {
  const key = String(material || '').trim().toLowerCase();
  return fabricDescriptions[key] || fabricDescriptions.default;
}

function uniqueValues(key) {
  const values = new Set();
  ACTIVE_CATALOG.forEach((item) => {
    const value = item[key];
    if (Array.isArray(value)) value.forEach((v) => values.add(v));
    else values.add(value);
  });
  return [...values].sort((a, b) => String(a).localeCompare(String(b), 'es'));
}

function slug(str) {
  return String(str)
    .toLowerCase()
    .normalize('NFD')
    .replace(/[\u0300-\u036f]/g, '')
    .replace(/[^a-z0-9]+/g, '-')
    .replace(/(^-|-$)/g, '');
}

function buildCheckboxes(container, values, name) {
  container.innerHTML = values
    .map(
      (value) => `
        <label class="check-item" for="${name}-${slug(value)}">
          <input id="${name}-${slug(value)}" type="checkbox" value="${value}" data-group="${name}" />
          <span>${value}</span>
        </label>`
    )
    .join('');
}

function createBadgeList(values) {
  return values.map((v) => `<span class="badge">${v}</span>`).join('');
}

function catalogAsset(path) {
  const value = String(path || '');

  if (/^(https?:)?\/\//.test(value) || value.startsWith('data:')) return value;
  if (APP_BASE_PATH && value.startsWith(`${APP_BASE_PATH}/`)) return value;
  if (value.startsWith('/')) return `${APP_BASE_PATH}${value}`;

  return `${APP_BASE_PATH}/${value}`;
}

function catalogDetailUrl(item) {
  const productId = item.productId || String(item.id || '').replace('producto-', '');
  return `${APP_BASE_PATH}/catalogo/${productId}`;
}

function cardTemplate(item) {
  const materialOptions = item.materials
    .map((m) => `<option value="${m}">${m}</option>`)
    .join('');
  const colorOptions = item.colors
    .map((c) => `<option value="${c}">${c}</option>`)
    .join('');
  const sizeOptions = item.sizes
    .map((s) => `<option value="${s}">${s}</option>`)
    .join('');

  return `
    <article class="catalog-card" data-id="${item.id}">
      <img src="${catalogAsset(item.image)}" alt="${item.name}" loading="lazy" />
      <div class="card-content">
        <p class="card-overline">${item.category} · ${item.subcategory}</p>
        <h3>${item.name}</h3>
        <p>${item.description}</p>
        <div class="badges">${createBadgeList(item.features)}</div>
        <div class="config">
          <label>Material
            <select data-field="material">${materialOptions}</select>
          </label>
          <label>Color
            <select data-field="color">${colorOptions}</select>
          </label>
          <label>Medida
            <select data-field="size">${sizeOptions}</select>
          </label>
        </div>
        <div class="card-actions">
          <a class="btn btn-secondary detail-btn" href="${catalogDetailUrl(item)}">Ver más</a>
          <button class="btn btn-primary interest-btn" type="button" data-action="interest">
  <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="currentColor" viewBox="0 0 16 16" style="margin-right:5px;vertical-align:-2px"><path d="M13.601 2.326A7.854 7.854 0 0 0 7.994 0C3.627 0 .068 3.558.064 7.926c0 1.399.366 2.76 1.057 3.965L0 16l4.204-1.102a7.933 7.933 0 0 0 3.79.965h.004c4.368 0 7.926-3.558 7.93-7.93A7.898 7.898 0 0 0 13.6 2.326zM7.994 14.521a6.573 6.573 0 0 1-3.356-.92l-.24-.144-2.494.654.666-2.433-.156-.251a6.56 6.56 0 0 1-1.007-3.505c0-3.626 2.957-6.584 6.591-6.584a6.56 6.56 0 0 1 4.66 1.931 6.557 6.557 0 0 1 1.928 4.66c-.004 3.639-2.961 6.592-6.592 6.592z"/></svg>
  Me interesa este modelo
</button></div>
      </div>
    </article>`;
}

function parseSeatsFilter(seats, itemSeats) {
  if (seats === 'all') return true;
  if (seats === '0') return itemSeats === 0;
  if (seats === '4+') return itemSeats >= 4;
  return itemSeats === Number(seats);
}

function matchesSets(selectedSet, values) {
  if (selectedSet.size === 0) return true;
  const arr = Array.isArray(values) ? values : [values];
  return [...selectedSet].some((v) => arr.includes(v));
}

function applyFilters() {
  let filtered = ACTIVE_CATALOG.filter((item) => {
    const searchable = `${item.name} ${item.category} ${item.subcategory} ${item.features.join(' ')}`.toLowerCase();
    const matchSearch = searchable.includes(state.search);
    const matchCategory = matchesSets(state.categories, item.category);
    const matchMaterial = matchesSets(state.materials, item.materials);
    const matchFeature = matchesSets(state.features, item.features);
    const matchSeats = parseSeatsFilter(state.seats, item.seats);
    const matchFeatured = !state.featuredOnly || item.featured;

    return matchSearch && matchCategory && matchMaterial && matchFeature && matchSeats && matchFeatured;
  });

  filtered = filtered.sort((a, b) => {
    if (state.sort === 'name-asc') return a.name.localeCompare(b.name, 'es');
    if (state.sort === 'name-desc') return b.name.localeCompare(a.name, 'es');
    if (state.sort === 'seats-desc') return b.seats - a.seats;
    if (state.sort === 'seats-asc') return a.seats - b.seats;
    if (state.sort === 'featured') {
      if (a.featured === b.featured) return a.name.localeCompare(b.name, 'es');
      return a.featured ? -1 : 1;
    }
    return 0;
  });

  resultsNode.textContent = `${filtered.length} modelos encontrados`;
  gridNode.innerHTML = filtered.length
    ? filtered.map(cardTemplate).join('')
    : `<div class="no-results"><h3>Sin resultados</h3><p>Probá limpiar filtros o cambiar la búsqueda.</p></div>`;

  bindCatalogCardActions();
}

function catalogItemById(id) {
  return ACTIVE_CATALOG.find((item) => item.id === id);
}

function bindCatalogCardActions() {
  gridNode.querySelectorAll('.catalog-card').forEach((card) => {
    const item = catalogItemById(card.dataset.id);
    if (!item) return;

    const interestButton = card.querySelector('[data-action="interest"], .interest-btn');

    interestButton?.addEventListener('click', (event) => {
      event.preventDefault();
      event.stopPropagation();
      sendInterest(card, item);
    });

    card.addEventListener('click', (event) => {
      if (!window.matchMedia('(max-width: 760px)').matches) return;
      if (event.target.closest('button, a, select, input')) return;
      window.location.href = catalogDetailUrl(item);
    });
  });
}

function readStateFromForm() {
  state.search = searchInput.value.trim().toLowerCase();
  state.seats = seatsSelect.value;
  state.sort = sortSelect.value;
  state.featuredOnly = featuredOnly.checked;

  state.categories = new Set(
    [...filtersForm.querySelectorAll('input[data-group="category"]:checked')].map((el) => el.value)
  );
  state.materials = new Set(
    [...filtersForm.querySelectorAll('input[data-group="material"]:checked')].map((el) => el.value)
  );
  state.features = new Set(
    [...filtersForm.querySelectorAll('input[data-group="feature"]:checked')].map((el) => el.value)
  );
}

function modalTemplate(item) {
  const defaultMaterial = item.materials[0] || 'A definir';

  return `
    <article class="catalog-detail" data-id="${item.id}">
      <img class="catalog-detail-image" src="${catalogAsset(item.image)}" alt="${item.name}" />
      <div class="catalog-detail-body">
        <p class="card-overline">${item.category} · ${item.subcategory}</p>
        <h3 id="modal-title">${item.name}</h3>
        <p>${item.description}</p>
        <div class="badges">${createBadgeList(item.features)}</div>
        <div class="detail-config">
          <label>Material
            <select data-detail-field="material">${optionList(item.materials)}</select>
          </label>
          <p class="detail-fabric-note" data-fabric-note>${fabricDescription(defaultMaterial)}</p>
          <label>Color
            <select data-detail-field="color">${optionList(item.colors)}</select>
          </label>
          <label>Medida
            <select data-detail-field="size">${optionList(item.sizes)}</select>
          </label>
        </div>
        <button class="btn btn-primary detail-budget-btn" type="button">
          <span aria-hidden="true">WhatsApp</span>
          Pedir presupuesto
        </button>
      </div>
    </article>
  `;
}

function openModal(item) {
  modalBody.innerHTML = modalTemplate(item);
  document.body.classList.add('catalog-modal-open');

  if (typeof detailModal.showModal === 'function') {
    try {
      detailModal.showModal();
      return;
    } catch (_error) {
      // Fallback below keeps the mobile catalog usable if dialog state is inconsistent.
    }
  }

  detailModal.setAttribute('open', '');
  detailModal.classList.add('is-open');
}

function closeCatalogModal() {
  document.body.classList.remove('catalog-modal-open');

  if (typeof detailModal.close === 'function' && detailModal.open) {
    detailModal.close();
    return;
  }

  detailModal.removeAttribute('open');
  detailModal.classList.remove('is-open');
}

function sendDetailInterest(item) {
  const material = modalBody.querySelector('select[data-detail-field="material"]')?.value || 'A definir';
  const color = modalBody.querySelector('select[data-detail-field="color"]')?.value || 'A definir';
  const size = modalBody.querySelector('select[data-detail-field="size"]')?.value || 'A definir';
  const materialNote = fabricDescription(material);

  const text = [
    'Hola TAPISUR, quiero pedir un presupuesto para un producto personalizado.',
    '',
    'Datos del modelo:',
    `- Nombre: ${item.name}`,
    `- Categoria: ${item.category}`,
    `- Linea / tipo: ${item.subcategory}`,
    `- Descripcion: ${item.description}`,
    '',
    'Opciones seleccionadas:',
    `- Tela / material: ${material}`,
    `- Detalle de tela: ${materialNote}`,
    `- Color: ${color}`,
    `- Medida sugerida: ${size}`,
    `- Terminaciones / caracteristicas: ${item.features.join(', ')}`,
    '',
    'Consulta:',
    'Quisiera confirmar disponibilidad de tela y color, medidas finales, tiempo estimado de fabricacion/entrega y precio.',
    '',
    'Gracias.'
  ].join('\n');

  const url = `https://wa.me/5491151103419?text=${encodeURIComponent(text)}`;
  window.open(url, '_blank', 'noopener,noreferrer');
}

function sendInterest(card, item) {
  const material = card.querySelector('select[data-field="material"]').value;
  const color = card.querySelector('select[data-field="color"]').value;
  const size = card.querySelector('select[data-field="size"]').value;

  const text = [
    'Hola TAPISUR, me interesa este modelo:',
    item.name,
    '',
    `Material: ${material}`,
    `Color: ${color}`,
    `Medida: ${size}`,
    '',
    'Quiero recibir asesoramiento y disponibilidad.'
  ].join('\n');

  const url = `https://wa.me/5491151103419?text=${encodeURIComponent(text)}`;
  window.open(url, '_blank', 'noopener,noreferrer');
}

function openCardFromEvent(event) {
  const card = event.target.closest('.catalog-card');
  if (!card) return false;
  const item = ACTIVE_CATALOG.find((x) => x.id === card.dataset.id);
  if (!item) return false;
  const detailButton = event.target.closest('.detail-btn');
  const interestButton = event.target.closest('[data-action="interest"], .interest-btn');

  if (window.matchMedia('(max-width: 760px)').matches && !event.target.closest('button, a, select, input')) {
    window.location.href = catalogDetailUrl(item);
    return true;
  }

  if (detailButton) {
    return false;
  }

  if (interestButton) {
    event.preventDefault();
    sendInterest(card, item);
    return true;
  }

  return false;
}

function onGridAction(event) {
  if (openCardFromEvent(event)) {
    event.stopPropagation();
  }
}

function onModalAction(event) {
  const detail = event.target.closest('.catalog-detail');
  if (!detail) return;
  const item = ACTIVE_CATALOG.find((x) => x.id === detail.dataset.id);
  if (!item) return;

  if (event.target.matches('select[data-detail-field="material"]')) {
    modalBody.querySelector('[data-fabric-note]').textContent = fabricDescription(event.target.value);
  }

  if (event.target.classList.contains('detail-budget-btn')) {
    sendDetailInterest(item);
  }
}

function resetFilters() {
  filtersForm.reset();
  state.search = '';
  state.categories.clear();
  state.materials.clear();
  state.features.clear();
  state.seats = 'all';
  state.sort = 'featured';
  state.featuredOnly = false;
  applyFilters();
}

function init() {
  buildCheckboxes(categoryGroup, uniqueValues('category'), 'category');
  buildCheckboxes(materialGroup, uniqueValues('materials'), 'material');
  buildCheckboxes(featuresGroup, uniqueValues('features'), 'feature');

  const syncFiltersVisibility = () => {
    if (!filtersToggle || !filtersBody) return;
    const isMobile = window.innerWidth <= 880;
    if (!isMobile) {
      filtersBody.hidden = false;
      filtersToggle.setAttribute('aria-expanded', 'true');
      filtersToggle.textContent = 'Filtros';
      return;
    }
    if (!filtersToggle.dataset.initialized) {
      filtersBody.hidden = true;
      filtersToggle.setAttribute('aria-expanded', 'false');
      filtersToggle.textContent = 'Filtrar';
      filtersToggle.dataset.initialized = 'true';
    }
  };

  filtersForm.addEventListener('input', () => {
    readStateFromForm();
    applyFilters();
  });

  filtersForm.addEventListener('change', () => {
    readStateFromForm();
    applyFilters();
  });

  resetBtn.addEventListener('click', resetFilters);
  gridNode.addEventListener('click', onGridAction);
  document.addEventListener('click', (event) => {
    openCardFromEvent(event);
  });
  modalBody.addEventListener('change', onModalAction);
  modalBody.addEventListener('click', onModalAction);

  if (filtersToggle && filtersBody) {
    filtersToggle.addEventListener('click', () => {
      const expanded = filtersToggle.getAttribute('aria-expanded') === 'true';
      filtersBody.hidden = expanded;
      filtersToggle.setAttribute('aria-expanded', String(!expanded));
      filtersToggle.textContent = expanded ? 'Filtrar' : 'Cerrar filtros';
    });
    syncFiltersVisibility();
    window.addEventListener('resize', syncFiltersVisibility, { passive: true });
  }

  closeModalBtn.addEventListener('click', closeCatalogModal);
  detailModal.addEventListener('close', () => {
    document.body.classList.remove('catalog-modal-open');
    detailModal.classList.remove('is-open');
  });
  detailModal.addEventListener('click', (event) => {
    const rect = detailModal.getBoundingClientRect();
    const isOutside =
      event.clientX < rect.left ||
      event.clientX > rect.right ||
      event.clientY < rect.top ||
      event.clientY > rect.bottom;
    if (!isOutside) return;

    closeCatalogModal();
  });

  applyFilters();
}

init();
