/**
 * catalogo-module.js
 *
 * Módulo ES que gestiona la página de catálogo del sitio público.
 * Implementa un sistema completo de filtrado y renderizado de productos
 * con interacción por WhatsApp.
 *
 * Funcionalidades:
 *  - Filtrado por categoría, material, features (checkboxes)
 *  - Búsqueda por texto libre
 *  - Filtro por cantidad de asientos
 *  - Ordenamiento (nombre, asientos, destacados)
 *  - Toggle "solo destacados"
 *  - Renderizado dinámico de cards con selectores de material/color/medida
 *  - Modal de detalle de producto
 *  - Envío de consulta por WhatsApp con datos de configuración elegida
 *  - Responsive: panel de filtros colapsable en mobile
 *
 * Fuente de datos:
 *  - Prioridad 1: window.__TAPISUR_CATALOG__ (inyectado desde PHP/DB)
 *  - Prioridad 2: CATALOG exportado de catalog-data.js (fallback estático)
 *
 * Dependencias: catalog-data.js (ES module import)
 */
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
          <button class="btn btn-secondary detail-btn" type="button">Ver detalle</button>
          <button class="btn btn-primary interest-btn" type="button">
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
  const text = [
    'Hola TAPISUR, me interesa este modelo:',
    item.name,
    '',
    `Categoria: ${item.category}`,
    `Descripcion: ${item.description}`,
    '',
    'Quiero recibir asesoramiento y disponibilidad.'
  ].join('\n');

  const waUrl = `https://wa.me/5491151103419?text=${encodeURIComponent(text)}`;

  return `
    <h3>${item.name}</h3>
    <p>${item.description}</p>
    <p><strong>Categoria:</strong> ${item.category} / ${item.subcategory}</p>
    <p><strong>Materiales:</strong> ${item.materials.join(', ')}</p>
    <p><strong>Medidas sugeridas:</strong> ${item.sizes.join(' · ')}</p>
    <p><strong>Terminaciones:</strong> ${item.features.join(', ')}</p>
    <a class="btn btn-primary wa-link" href="${waUrl}" target="_blank" rel="noopener noreferrer">
      Me interesa este modelo
    </a>
  `;
}

function openModal(item) {
  modalBody.innerHTML = modalTemplate(item);
  detailModal.showModal();
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

function onGridAction(event) {
  const card = event.target.closest('.catalog-card');
  if (!card) return;
  const item = ACTIVE_CATALOG.find((x) => x.id === card.dataset.id);
  if (!item) return;

  if (event.target.classList.contains('detail-btn')) {
    openModal(item);
  }

  if (event.target.classList.contains('interest-btn')) {
    sendInterest(card, item);
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
      return;
    }
    if (!filtersToggle.dataset.initialized) {
      filtersBody.hidden = true;
      filtersToggle.setAttribute('aria-expanded', 'false');
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

  if (filtersToggle && filtersBody) {
    filtersToggle.addEventListener('click', () => {
      const expanded = filtersToggle.getAttribute('aria-expanded') === 'true';
      filtersBody.hidden = expanded;
      filtersToggle.setAttribute('aria-expanded', String(!expanded));
    });
    syncFiltersVisibility();
    window.addEventListener('resize', syncFiltersVisibility, { passive: true });
  }

  closeModalBtn.addEventListener('click', () => detailModal.close());
  detailModal.addEventListener('click', (event) => {
    const rect = detailModal.getBoundingClientRect();
    const isOutside =
      event.clientX < rect.left ||
      event.clientX > rect.right ||
      event.clientY < rect.top ||
      event.clientY > rect.bottom;
    if (isOutside) detailModal.close();
  });

  applyFilters();
}

init();
