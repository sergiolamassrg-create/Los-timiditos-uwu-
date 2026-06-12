<!doctype html>
<html lang="es-AR">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="theme-color" content="#f8f3eb" />
  <title><?= htmlspecialchars($pageTitle ?? 'Tapisur', ENT_QUOTES, 'UTF-8') ?></title>
  <meta name="description" content="<?= htmlspecialchars($pageDescription ?? 'Tapisur fabrica sillones, muebles a medida, retapizados y restauraciones.', ENT_QUOTES, 'UTF-8') ?>" />
  <meta property="og:title" content="<?= htmlspecialchars($pageTitle ?? 'Tapisur', ENT_QUOTES, 'UTF-8') ?>" />
  <meta property="og:description" content="<?= htmlspecialchars($pageDescription ?? 'Fabricamos sillones y muebles a medida para transformar tus espacios.', ENT_QUOTES, 'UTF-8') ?>" />
  <meta property="og:type" content="website" />
  <meta property="og:image" content="<?= htmlspecialchars($ogImage ?? '/img/catalogo/page11_img03.jpeg', ENT_QUOTES, 'UTF-8') ?>" />
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;700&family=Outfit:wght@400;500;600;700&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="/css/styles.css" />
  <?php if (!empty($extraStyles)): ?>
    <?php foreach ($extraStyles as $style): ?>
      <link rel="stylesheet" href="<?= htmlspecialchars($style, ENT_QUOTES, 'UTF-8') ?>" />
    <?php endforeach; ?>
  <?php endif; ?>
  <link rel="icon" href="/img/logo-icon.png" type="image/png" />
</head>
<body class="<?= htmlspecialchars($bodyClass ?? '', ENT_QUOTES, 'UTF-8') ?>">
  <a class="skip-link" href="#contenido">Saltar al contenido</a>

  <header class="site-header" id="top">
    <div class="container nav-wrap">
      <a class="brand" href="/" aria-label="Ir al inicio">
        <img src="/img/logo-icon.png" alt="Logo Tapisur" />
        <span>Tapisur</span>
      </a>
      <button class="menu-toggle" aria-expanded="false" aria-controls="site-nav">Menú</button>
      <nav id="site-nav" class="site-nav" aria-label="Navegación principal">
        <a class="<?= ($activePage ?? '') === 'inicio' ? 'active' : '' ?>" href="/">Inicio</a>
        <a class="<?= ($activePage ?? '') === 'catalogo' ? 'active' : '' ?>" href="/catalogo">Catálogo</a>
        <a class="<?= ($activePage ?? '') === 'servicios' ? 'active' : '' ?>" href="/servicios">Servicios</a>
        <a class="<?= ($activePage ?? '') === 'nosotros' ? 'active' : '' ?>" href="/nosotros">Nosotros</a>
        <a class="<?= ($activePage ?? '') === 'contacto' ? 'active' : '' ?>" href="/contacto">Contacto</a>
      </nav>
    </div>
  </header>

  <main id="contenido">
