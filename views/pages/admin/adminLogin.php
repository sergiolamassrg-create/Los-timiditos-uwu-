<!doctype html>
<html lang="es-AR">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="theme-color" content="#f6f4ef" />
  <title>Panel Admin TAPISUR</title>
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;700&family=Outfit:wght@500;600;700&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="/css/admin.css" />
</head>
<body>
  <main class="admin-wrap">
    <section id="loginView" class="card">
      <p class="eyebrow">Acceso privado</p>
      <h1>Panel Admin TAPISUR</h1>
      <p>Ingreso para dueño/responsable del sitio.</p>
      <form id="loginForm" class="form-grid" novalidate>
        <label for="username">Usuario</label>
        <input id="username" name="username" type="text" autocomplete="username" required />
        <label for="password">Clave</label>
        <input id="password" name="password" type="password" autocomplete="current-password" required />
        <button type="submit">Ingresar</button>
      </form>
      <p id="loginMsg" class="msg" aria-live="polite"></p>
    </section>

    <section id="panelView" class="card" hidden>
      <div class="panel-head">
        <div>
          <p class="eyebrow">Configuracion</p>
          <h2>Contenido editable</h2>
          <p>Esta maqueta guarda cambios en este navegador (localStorage).</p>
        </div>
        <button id="logoutBtn" class="btn-ghost" type="button">Cerrar sesion</button>
      </div>

      <form id="contentForm" class="form-grid" novalidate>
        <h3>Textos Home</h3>
        <label for="hero_title">Titulo principal</label>
        <input id="hero_title" name="hero_title" type="text" />
        <label for="hero_subtitle">Subtitulo principal</label>
        <textarea id="hero_subtitle" name="hero_subtitle" rows="3"></textarea>

        <label for="about_title">Titulo Sobre TAPISUR</label>
        <input id="about_title" name="about_title" type="text" />
        <label for="about_p1">Texto Sobre (parrafo 1)</label>
        <textarea id="about_p1" name="about_p1" rows="3"></textarea>
        <label for="about_p2">Texto Sobre (parrafo 2)</label>
        <textarea id="about_p2" name="about_p2" rows="3"></textarea>

        <h3>Textos Catalogo</h3>
        <label for="catalog_title">Titulo modulo catalogo</label>
        <input id="catalog_title" name="catalog_title" type="text" />
        <label for="catalog_subtitle">Subtitulo modulo catalogo</label>
        <textarea id="catalog_subtitle" name="catalog_subtitle" rows="3"></textarea>

        <h3>Contacto y Redes</h3>
        <label for="phone_1">Telefono 1 (visible)</label>
        <input id="phone_1" name="phone_1" type="text" />
        <label for="phone_2">Telefono 2 (visible)</label>
        <input id="phone_2" name="phone_2" type="text" />
        <label for="whatsapp_number">WhatsApp (solo numeros, ej 5491151103419)</label>
        <input id="whatsapp_number" name="whatsapp_number" type="text" />
        <label for="address">Direccion</label>
        <input id="address" name="address" type="text" />
        <label for="instagram_url">URL Instagram</label>
        <input id="instagram_url" name="instagram_url" type="url" />

        <div class="actions">
          <button type="submit">Guardar cambios</button>
          <button id="restoreBtn" class="btn-ghost" type="button">Restaurar default</button>
          <button id="exportBtn" class="btn-ghost" type="button">Exportar JSON</button>
          <button id="importBtn" class="btn-ghost" type="button">Importar JSON</button>
          <input id="importFile" type="file" accept="application/json" hidden />
        </div>
      </form>

      <p id="saveMsg" class="msg" aria-live="polite"></p>
      <div class="help">
        <p><strong>URL especial del panel:</strong> <code>panel-tapisur-admin.html</code></p>
        <p>Despues de guardar, recarga <code>index.html</code> y <code>catalogo.html</code> para ver los cambios.</p>
      </div>
    </section>
  </main>

  <script src="/js/site-defaults.js"></script>
  <script src="/js/admin-panel.js"></script>
</body>
</html>
