<?php
$siteSettings = \App\Core\SiteSettings::all();
$siteName = $siteSettings['site_name'] ?? 'Tapisur';
$defaultTitle = $siteSettings['meta_title'] ?? 'Tapisur | Sillones y muebles a medida';
$defaultDescription = $siteSettings['meta_description'] ?? 'Tapisur fabrica sillones, muebles a medida, retapizados y restauraciones.';
\App\Core\SiteAnalytics::trackPageView($activePage ?? ($pageTitle ?? 'publica'));
?>
<!doctype html>
<html lang="es-AR">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="theme-color" content="#f8f3eb" />
  <title><?= htmlspecialchars($pageTitle ?? $defaultTitle, ENT_QUOTES, 'UTF-8') ?></title>
  <meta name="description" content="<?= htmlspecialchars($pageDescription ?? $defaultDescription, ENT_QUOTES, 'UTF-8') ?>" />
  <meta property="og:title" content="<?= htmlspecialchars($pageTitle ?? $defaultTitle, ENT_QUOTES, 'UTF-8') ?>" />
  <meta property="og:description" content="<?= htmlspecialchars($pageDescription ?? $defaultDescription, ENT_QUOTES, 'UTF-8') ?>" />
  <meta property="og:type" content="website" />
  <meta property="og:image" content="<?= htmlspecialchars($ogImage ?? '/img/catalogo/page11_img03.jpeg', ENT_QUOTES, 'UTF-8') ?>" />
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;700&family=Outfit:wght@400;500;600;700&display=swap" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="/css/styles.css" />
  <?php if (!empty($extraStyles)): ?>
    <?php foreach ($extraStyles as $style): ?>
      <link rel="stylesheet" href="<?= htmlspecialchars($style, ENT_QUOTES, 'UTF-8') ?>" />
    <?php endforeach; ?>
  <?php endif; ?>
  <link rel="icon" href="/img/favicon-tapisur.svg" type="image/svg+xml" />
  <link rel="alternate icon" href="/img/logo-icon.png" type="image/png" />
</head>
<body class="<?= htmlspecialchars($bodyClass ?? '', ENT_QUOTES, 'UTF-8') ?>">
  <a class="skip-link" href="#contenido">Saltar al contenido</a>

  <header class="site-header" id="top">
    <div class="container nav-wrap">
      <a class="brand" href="/" aria-label="Ir al inicio">
        <img src="/img/logo-icon.png" alt="Logo Tapisur" />
          <span><?= htmlspecialchars($siteName, ENT_QUOTES, 'UTF-8') ?></span>
      </a>
      <button class="menu-toggle" aria-expanded="false" aria-controls="site-nav" aria-label="Abrir menú"><i class="bi bi-list" aria-hidden="true"></i><span>Menú</span></button>
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




