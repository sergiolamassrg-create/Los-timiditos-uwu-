<?php
$pageTitle = 'Catalogo TAPISUR | Modelos y filtros avanzados';
$pageDescription = 'Explora el catalogo completo de TAPISUR con filtros por categoria, material, medida y terminacion. Consulta cada modelo por WhatsApp.';
$ogImage = '/img/catalogo/page11_img03.jpeg';
$bodyClass = 'catalog-page';
$activePage = 'catalogo';
$extraStyles = ['/css/catalogo-module.css?v=' . filemtime(__DIR__ . '/../../public/css/catalogo-module.css')];
$inlineScripts = [
  'window.__TAPISUR_CATALOG__ = ' . json_encode($catalogItems ?? [], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT) . ';',
];
$extraScripts = [['src' => '/js/catalogo-module.js?v=' . filemtime(__DIR__ . '/../../public/js/catalogo-module.js'), 'type' => 'module']];
require __DIR__ . '/../partials/site-header.php';
?>


    <section class="catalog-hero">
      <div class="container catalog-hero-inner">
        <p class="kicker">Tapicería a medida · Entrega en todo el país</p>
<h1 data-content="catalog_title">Encontrá tu sillón ideal</h1>
<p><span data-content="catalog_subtitle">Más de 24 modelos para elegir. Filtrá por categoría, material y medida, y consultanos por WhatsApp en un clic.</span></p>
</div>
    </section>

    <section class="container catalog-layout" aria-label="Catalogo">
      <aside class="filters">
        <div class="filters-head">
          <h2>Filtros</h2>
          <button id="filtersToggle" class="btn btn-secondary filters-toggle" type="button" aria-expanded="true" aria-controls="filtersBody">Filtrar</button>
        </div>
        <form id="catalogFilters" novalidate>
          <div id="filtersBody">
          <div class="field">
            <label for="searchInput">Buscar modelo</label>
            <input id="searchInput" type="search" placeholder="Ej: chesterfield, rinconero..." />
          </div>

          <div class="field">
            <label for="seatsSelect">Capacidad</label>
            <select id="seatsSelect">
              <option value="all">Todos</option>
              <option value="0">Sin plaza (mesas/baules/respaldos)</option>
              <option value="1">1 plaza</option>
              <option value="2">2 plazas</option>
              <option value="3">3 plazas</option>
              <option value="4+">4 o mas</option>
            </select>
          </div>

          <div class="field">
            <label for="sortSelect">Ordenar por</label>
            <select id="sortSelect">
              <option value="featured">Destacados primero</option>
              <option value="name-asc">Nombre (A-Z)</option>
              <option value="name-desc">Nombre (Z-A)</option>
              <option value="seats-desc">Capacidad (mayor a menor)</option>
              <option value="seats-asc">Capacidad (menor a mayor)</option>
            </select>
          </div>

          <div class="field">
            <label>Categorias</label>
            <div id="categoryGroup" class="check-grid"></div>
          </div>

          <div class="field">
            <label>Materiales</label>
            <div id="materialGroup" class="check-grid"></div>
          </div>

          <div class="field">
            <label>Terminaciones / Caracteristicas</label>
            <div id="featuresGroup" class="check-grid"></div>
          </div>

          <label class="featured-toggle" for="featuredOnly">
            <input id="featuredOnly" type="checkbox" />
            <span>Solo modelos destacados</span>
          </label>

          <div class="filter-actions">
            <button id="resetFilters" class="btn btn-secondary" type="button">Limpiar filtros</button>
            <a class="btn btn-primary wa-link" data-wa-message="Hola TAPISUR, quiero asesoramiento para elegir un modelo." target="_blank" rel="noopener noreferrer" href="https://wa.me/5491151103419?text=Hola%20TAPISUR%2C%20quiero%20asesoramiento%20para%20elegir%20modelo.">Asesoria</a>
          </div>
          </div>
        </form>
      </aside>

      <section class="catalog-results">
        <div class="results-head">
          <p id="resultsCount">0 modelos encontrados</p>
          <a class="btn btn-secondary" href="/">Volver al inicio</a>
        </div>
        <div id="catalogGrid" class="catalog-grid"></div>
      </section>
    </section>

<dialog id="detailModal" class="modal" aria-labelledby="modal-title">
    <div class="modal-content" id="modalBody"></div>
    <div class="modal-actions">
      <button id="closeModal" class="btn btn-secondary" type="button">Cerrar</button>
    </div>
  </dialog>

<?php require __DIR__ . '/../partials/site-footer.php'; ?>
