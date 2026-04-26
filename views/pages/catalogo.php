<!doctype html>
<html lang="es-AR">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="theme-color" content="#f6f4ef" />
  <title>Catalogo TAPISUR | Modelos y filtros avanzados</title>
  <meta name="description" content="Explora el catalogo completo de TAPISUR con filtros por categoria, material, medida y terminacion. Consulta cada modelo por WhatsApp." />
  <meta property="og:title" content="Catalogo TAPISUR" />
  <meta property="og:description" content="Modelos de sillones, rinconeros, chesterfield, baules y respaldos personalizados." />
  <meta property="og:type" content="website" />
  <meta property="og:image" content="/img/catalogo/page11_img03.jpeg" />
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;700&family=Outfit:wght@400;500;600;700&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="/css/styles.css" />
  <link rel="stylesheet" href="/css/catalogo-module.css" />
</head>
<body class="catalog-page">
  <a class="skip-link" href="#contenido">Saltar al contenido</a>
  <header class="site-header" id="top">
    <div class="top-bar">
      <div class="container top-bar-inner">
        <p>Fábrica en Lanús Este · Producción a medida</p>
        <a class="phone1-link" href="tel:+541151103419">11 5110-3419</a>
      </div>
    </div>
    <div class="container nav-wrap">
      <a class="brand" href="/#top" aria-label="Ir al inicio">
        <img src="/img/logo.jpg" alt="Logo TAPISUR" />
        <span>TAPISUR</span>
      </a>
      <button class="menu-toggle" aria-expanded="false" aria-controls="site-nav">Menu</button>
      <nav id="site-nav" class="site-nav" aria-label="Navegacion principal">
        <a href="/">Inicio</a>
        <a href="/catalogo">Catalogo</a>
        <a href="/servicios">Servicios</a>
        <a href="/entregas">Entregas</a>
        <a href="/nosotros">Nosotros</a>
        <a href="/contacto">Contacto</a>
      </nav>
      <a class="btn btn-primary nav-cta wa-link" data-wa-message="Hola TAPISUR, quiero cotizar un modelo." target="_blank" rel="noopener noreferrer" href="https://wa.me/5491151103419?text=Hola%20TAPISUR%2C%20quiero%20cotizar%20un%20modelo.">Cotizar proyecto</a>
    </div>
  </header>

  <main id="contenido">
    <section class="catalog-hero">
      <div class="container catalog-hero-inner">
        <p class="kicker">Modulo Avanzado</p>
        <h1 data-content="catalog_title">Catalogo TAPISUR</h1>
        <p><span data-content="catalog_subtitle">Filtra por categoria, material, capacidad y terminaciones. Configura opciones y envia tu consulta con el boton Me interesa este modelo.</span></p>
      </div>
    </section>

    <section class="container catalog-layout" aria-label="Catalogo">
      <aside class="filters">
        <div class="filters-head">
          <h2>Filtros</h2>
          <button id="filtersToggle" class="btn btn-secondary filters-toggle" type="button" aria-expanded="true" aria-controls="filtersBody">Mostrar/Ocultar</button>
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
  </main>

  <dialog id="detailModal" class="modal" aria-labelledby="modal-title">
    <div class="modal-content" id="modalBody"></div>
    <div class="modal-actions">
      <button id="closeModal" class="btn btn-secondary" type="button">Cerrar</button>
    </div>
  </dialog>

  <a class="whatsapp-float wa-link" data-wa-message="Hola TAPISUR, quiero consultar por el catalogo." target="_blank" rel="noopener noreferrer" href="https://wa.me/5491151103419?text=Hola%20TAPISUR%2C%20quiero%20consultar%20por%20el%20catalogo%20completo." aria-label="Abrir WhatsApp">
    <span class="wa__btn_popup_icon" aria-hidden="true"></span>
    <span class="sr-only">WhatsApp</span>
  </a>

  <footer class="site-footer">
    <div class="container footer-grid">
      <div>
        <a class="brand footer-brand" href="/#top" aria-label="Ir al inicio">
          <img src="/img/logo.jpg" alt="Logo TAPISUR" />
          <span>TAPISUR</span>
        </a>
        <p>Fábrica de sillones en Lanús Este. Diseño, confort y fabricación a medida.</p>
      </div>
      <div>
        <h3>Navegación</h3>
        <ul class="footer-list">
          <li><a href="catalogo">Catalogo</a></li>
          <li><a href="servicios">Servicios</a></li>
          <li><a href="entregas">Entregas</a></li>
          <li><a href="garantia">Garantia</a></li>
        </ul>
      </div>
      <div>
        <h3>Contacto</h3>
        <ul class="footer-list">
          <li><a class="phone1-link" href="tel:+541151103419">11 5110-3419</a></li>
          <li><a class="phone2-link" href="tel:+541167675200">11 6767-5200</a></li>
          <li><span class="address-text">Juan Esteban Pedernera 1462, Lanús Este</span></li>
          <li><a class="instagram-link" target="_blank" rel="noopener noreferrer" href="https://www.instagram.com/tapisur_/">Instagram @tapisur_</a></li>
        </ul>
      </div>
    </div>
    <div class="container footer-bottom">
      <p>© <span id="year"></span> TAPISUR. Todos los derechos reservados.</p>
    </div>
  </footer>

  <script src="/js/site-defaults.js"></script>
  <script src="/js/site-content.js"></script>
  <script src="/js/main.js"></script>
  <script type="module" src="/js/catalogo-module.js"></script>
</body>
</html>

