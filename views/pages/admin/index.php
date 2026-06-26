<?php
$e = fn($value) => htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
$short = fn($value, $width = 84) => function_exists('mb_strimwidth')
    ? mb_strimwidth((string) $value, 0, $width, '...')
    : substr((string) $value, 0, max(0, $width - 3)) . (strlen((string) $value) > $width ? '...' : '');
$products = $products ?? [];
$productSearch = trim((string) ($productSearch ?? ""));
$categories = $categories ?? [];
$fabrics = $fabrics ?? [];
$colors = $colors ?? [];
$fabricColors = $fabricColors ?? [];
$users = $users ?? [];
$roles = $roles ?? [];
$settings = $settings ?? [];
$stats = $stats ?? [];
$analytics = $analytics ?? ['totalViews' => 0, 'uniqueIps' => 0, 'repeatedIps' => 0, 'rows' => []];
$activeModule = $activeModule ?? 'dashboard';
$catalogOptionsReady = (bool) ($catalogOptionsReady ?? false);
$adminName = $adminUser['name'] ?? 'Administrador';
$isActive = fn($module) => $activeModule === $module ? 'active' : '';
?>
<!doctype html>
<html lang="es-AR">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <link rel="icon" href="/img/favicon-admin.svg" type="image/svg+xml" />
  <link rel="alternate icon" href="/img/logo-icon.png" type="image/png" />
  <title>Panel Admin | Tapisur</title>
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;700&family=Outfit:wght@500;600;700&display=swap" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="/css/admin.css?v=<?= filemtime(__DIR__ . '/../../../public/css/admin.css') ?>" />
</head>
<body class="admin-body">
  <div class="admin-app">
    <aside class="admin-sidebar">
      <a class="admin-brand" href="/admin/dashboard">
        <img src="/img/logo-icon.png" alt="Tapisur" />
        <span>Tapisur</span>
      </a>
      <nav class="admin-nav" aria-label="Navegación admin">
        <a href="/admin/dashboard" class="<?= $isActive('dashboard') ?>"><i class="bi bi-speedometer2"></i> Dashboard</a>
        <a href="/admin/productos" class="<?= $isActive('productos') ?>"><i class="bi bi-box-seam"></i> Productos</a>
        <a href="/admin/telas" class="<?= $isActive('telas') ?>"><i class="bi bi-layers"></i> Telas</a>
        <a href="/admin/colores" class="<?= $isActive('colores') ?>"><i class="bi bi-palette"></i> Colores</a>
        <a href="/admin/combinaciones" class="<?= $isActive('combinaciones') ?>"><i class="bi bi-diagram-3"></i> Combinaciones</a>
      </nav>
      <div class="admin-sidebar-card">
        <strong>Taller Tapisur</strong>
        <span>Juan Esteban Pedernera 1462, Lanús Este</span>
        <a href="/" target="_blank" rel="noopener">Ver sitio <i class="bi bi-box-arrow-up-right"></i></a>
      </div>
    </aside>

    <div class="admin-main">
      <header class="admin-header">
        <button class="btn btn-light d-lg-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobileAdminNav" aria-controls="mobileAdminNav">
          <i class="bi bi-list"></i>
        </button>
        <div>
          <p class="admin-kicker">Panel protegido</p>
          <h1>Gestión Tapisur</h1>
        </div>
        <div class="dropdown">
          <button class="admin-user admin-user-button" type="button" data-bs-toggle="dropdown" aria-expanded="false">
            <span class="admin-user-avatar"><i class="bi bi-person"></i></span>
            <span>
              <strong><?= $e($adminName) ?></strong>
              <small><?= $e($adminUser['role'] ?? 'Admin') ?></small>
            </span>
            <i class="bi bi-chevron-down"></i>
          </button>
          <ul class="dropdown-menu dropdown-menu-end">
            <li><a class="dropdown-item" href="/admin/usuarios"><i class="bi bi-people"></i> Usuarios</a></li>
            <li><a class="dropdown-item" href="/admin/configuracion"><i class="bi bi-gear"></i> Configuración</a></li>
            <li><button class="dropdown-item" type="button" data-bs-toggle="modal" data-bs-target="#passwordModal"><i class="bi bi-key"></i> Cambiar clave</button></li>
            <li><hr class="dropdown-divider"></li>
            <li>
              <form method="post" action="/admin/logout">
                <button class="dropdown-item" type="submit"><i class="bi bi-box-arrow-right"></i> Cerrar sesión</button>
              </form>
            </li>
          </ul>
        </div>
      </header>

      <div class="offcanvas offcanvas-start" tabindex="-1" id="mobileAdminNav" aria-labelledby="mobileAdminNavLabel">
        <div class="offcanvas-header">
          <h5 id="mobileAdminNavLabel">Tapisur</h5>
          <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Cerrar"></button>
        </div>
        <div class="offcanvas-body admin-nav">
          <a href="/admin/dashboard"><i class="bi bi-speedometer2"></i> Dashboard</a>
          <a href="/admin/productos"><i class="bi bi-box-seam"></i> Productos</a>
          <a href="/admin/telas"><i class="bi bi-layers"></i> Telas</a>
          <a href="/admin/colores"><i class="bi bi-palette"></i> Colores</a>
          <a href="/admin/combinaciones"><i class="bi bi-diagram-3"></i> Combinaciones</a>
          <a href="/admin/usuarios"><i class="bi bi-people"></i> Usuarios</a>
          <a href="/admin/configuracion"><i class="bi bi-gear"></i> Configuración</a>
        </div>
      </div>

      <?php if (!empty($message)): ?>
        <div class="alert alert-success"><i class="bi bi-check-circle"></i> <?= $e($message) ?></div>
      <?php endif; ?>

      <?php if (!empty($error)): ?>
        <div class="alert alert-danger"><i class="bi bi-exclamation-triangle"></i> <?= $e($error) ?></div>
      <?php endif; ?>

      <?php if (!$catalogOptionsReady): ?>
        <div class="alert alert-warning"><i class="bi bi-database-exclamation"></i> La base actual no tiene las tablas de telas y colores definidas en schema.sql.</div>
      <?php endif; ?>

      <section id="dashboard" class="admin-section <?= $activeModule === 'dashboard' ? '' : 'd-none' ?>">
        <div class="section-title">
          <div>
            <p>Resumen</p>
            <h2>Dashboard inicial</h2>
          </div>
          <a class="btn btn-outline-dark" href="/catalogo" target="_blank" rel="noopener"><i class="bi bi-eye"></i> Ver catálogo</a>
        </div>
        <div class="row g-3">
          <?php
            $cards = [
              ['Productos activos', $stats['products'] ?? 0, 'bi-box-seam'],
              ['Destacados', $stats['featured'] ?? 0, 'bi-star'],
              ['Inactivos', $stats['inactiveProducts'] ?? 0, 'bi-archive'],
              ['Categorías', $stats['categories'] ?? 0, 'bi-grid'],
              ['Telas', $stats['fabrics'] ?? 0, 'bi-layers'],
              ['Colores', $stats['colors'] ?? 0, 'bi-palette'],
              ['Usuarios', $stats['users'] ?? 0, 'bi-people'],
              ['Visitas hoy', $analytics['totalViews'] ?? 0, 'bi-graph-up'],
              ['IPs únicas hoy', $analytics['uniqueIps'] ?? 0, 'bi-wifi'],
              ['IPs repetidas', $analytics['repeatedIps'] ?? 0, 'bi-arrow-repeat'],
            ];
          ?>
          <?php foreach ($cards as [$label, $value, $icon]): ?>
            <div class="col-12 col-sm-6 col-xl-3">
              <article class="metric-card">
                <span><i class="bi <?= $e($icon) ?>"></i></span>
                <div>
                  <strong><?= (int) $value ?></strong>
                  <small><?= $e($label) ?></small>
                </div>
              </article>
            </div>
          <?php endforeach; ?>
        </div>
        <div class="admin-panel mt-3">
          <div class="section-title section-title--inside">
            <div>
              <p>Analítica diaria</p>
              <h2>Visitas por IP</h2>
            </div>
          </div>
          <div class="table-responsive">
            <table class="table align-middle admin-table">
              <thead>
                <tr>
                  <th>IP</th>
                  <th>Entradas</th>
                  <th>Primera visita</th>
                  <th>Última visita</th>
                  <th>Última página</th>
                  <th>Ubicación aprox.</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach (($analytics['rows'] ?? []) as $visit): ?>
                  <tr>
                    <td data-label="IP"><code><?= $e($visit['ip_address']) ?></code></td>
                    <td data-label="Entradas"><?= (int) $visit['entradas'] ?></td>
                    <td data-label="Primera visita"><?= $e($visit['primera_visita']) ?></td>
                    <td data-label="Última visita"><?= $e($visit['ultima_visita']) ?></td>
                    <td data-label="Última página"><?= $e($visit['ultima_pagina']) ?></td>
                    <td data-label="Ubicación aprox."><?= $e(trim(($visit['ciudad'] ?? '') . ', ' . ($visit['region'] ?? '') . ', ' . ($visit['pais'] ?? ''), ', ')) ?></td>
                  </tr>
                <?php endforeach; ?>
                <?php if (empty($analytics['rows'])): ?>
                  <tr><td colspan="6" class="text-muted">Todavía no hay visitas registradas hoy.</td></tr>
                <?php endif; ?>
              </tbody>
            </table>
          </div>
        </div>
      </section>

      <section id="productos" class="admin-section <?= $activeModule === 'productos' ? '' : 'd-none' ?>">
        <div class="section-title">
          <div>
            <p>Contenido</p>
            <h2>Productos</h2>
          </div>
          <a class="btn btn-primary" href="/admin/productos/crear"><i class="bi bi-plus-lg"></i> Nuevo producto</a>
        </div>
        <div class="admin-panel">
          <form class="admin-toolbar" method="get" action="/admin/productos" role="search">
            <label class="admin-search" for="product-search">
              <i class="bi bi-search" aria-hidden="true"></i>
              <input id="product-search" class="form-control" name="q" type="search" value="<?= $e($productSearch) ?>" placeholder="Buscar por producto, descripción o categoría" autocomplete="off" />
            </label>
            <button class="btn btn-outline-dark" type="submit"><i class="bi bi-search"></i> Buscar</button>
            <?php if ($productSearch !== ''): ?>
              <a class="btn btn-light" href="/admin/productos"><i class="bi bi-x-lg"></i> Limpiar</a>
            <?php endif; ?>
          </form>

          <?php if ($productSearch !== ''): ?>
            <p class="admin-result-note">Resultados para <strong><?= $e($productSearch) ?></strong>: <?= count($products) ?> producto<?= count($products) === 1 ? '' : 's' ?>.</p>
          <?php endif; ?>

          <div class="table-responsive">
            <table class="table align-middle admin-table products-table">
              <thead>
                <tr>
                  <th>Producto</th>
                  <th>Categoría</th>
                  <th>Estado</th>
                  <th>Destacado</th>
                  <th class="text-end">Acciones</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($products as $product): ?>
                  <?php $productId = (int) $product['id_producto']; ?>
                  <?php $isProductActive = (int) $product['activo'] === 1; ?>
                  <tr class="<?= $isProductActive ? '' : 'is-inactive' ?>">
                    <td data-label="Producto">
                      <div class="product-cell">
                        <?php if (!empty($product['imagen'])): ?>
                          <img src="<?= $e($product['imagen']) ?>" alt="<?= $e($product['nombre']) ?>" />
                        <?php else: ?>
                          <span class="product-thumb-empty"><i class="bi bi-image"></i></span>
                        <?php endif; ?>
                        <div>
                          <strong><?= $e($product['nombre']) ?></strong>
                          <small><?= $e($short($product['descripcion'])) ?></small>
                        </div>
                      </div>
                    </td>
                    <td data-label="Categoría"><?= $e($product['categoria']) ?></td>
                    <td data-label="Estado">
                      <form class="product-status-form" method="post" action="/admin/productos/<?= $productId ?>/estado">
                        <?php if ($productSearch !== ''): ?><input type="hidden" name="q" value="<?= $e($productSearch) ?>"><?php endif; ?>
                        <label class="status-switch" title="<?= $isProductActive ? 'Desactivar producto' : 'Activar producto' ?>">
                          <input name="active" type="checkbox" value="1" <?= $isProductActive ? 'checked' : '' ?> onchange="this.form.submit()" />
                          <span class="status-switch-track" aria-hidden="true"><span></span></span>
                          <em><?= $isProductActive ? 'Activo' : 'Inactivo' ?></em>
                        </label>
                      </form>
                    </td>
                    <td data-label="Destacado"><i class="bi <?= ((int) $product['destacado'] === 1) ? 'bi-star-fill text-warning' : 'bi-star text-muted' ?>"></i></td>
                    <td data-label="Acciones">
                      <div class="d-flex justify-content-end gap-2">
                        <a class="btn btn-light btn-icon" href="/admin/productos/<?= $productId ?>/editar" title="Editar" aria-label="Editar <?= $e($product['nombre']) ?>"><i class="bi bi-pencil"></i></a>
                        <form method="post" action="/admin/productos/<?= $productId ?>/eliminar" onsubmit="return confirm('Esta acción elimina el producto definitivamente. ¿Continuar?');">
                          <?php if ($productSearch !== ''): ?><input type="hidden" name="q" value="<?= $e($productSearch) ?>"><?php endif; ?>
                          <button class="btn btn-light btn-icon text-danger" type="submit" title="Eliminar" aria-label="Eliminar <?= $e($product['nombre']) ?>"><i class="bi bi-trash"></i></button>
                        </form>
                      </div>
                    </td>
                  </tr>
                <?php endforeach; ?>
                <?php if (empty($products)): ?>
                  <tr>
                    <td colspan="5" class="text-center text-muted py-4">
                      <i class="bi bi-search"></i> No se encontraron productos<?= $productSearch !== '' ? ' para esa búsqueda.' : '.' ?>
                    </td>
                  </tr>
                <?php endif; ?>
              </tbody>
            </table>
          </div>
        </div>
      </section>
      <section id="materiales" class="admin-section <?= $activeModule === 'telas' ? '' : 'd-none' ?>">
        <div class="section-title">
          <div>
            <p>Catálogo central</p>
            <h2>Telas</h2>
          </div>
        </div>
        <div class="admin-panel">
          <form class="row g-2 align-items-end mb-3" method="post" action="/admin/telas/crear">
            <div class="col-md-4"><label class="form-label">Nombre</label><input class="form-control" name="name" required <?= $catalogOptionsReady ? '' : 'disabled' ?>></div>
            <div class="col-md-5"><label class="form-label">Descripción</label><input class="form-control" name="description" <?= $catalogOptionsReady ? '' : 'disabled' ?>></div>
            <div class="col-md-1 form-check admin-check"><input class="form-check-input" name="active" type="checkbox" checked <?= $catalogOptionsReady ? '' : 'disabled' ?>><label class="form-check-label">Activa</label></div>
            <div class="col-md-2"><button class="btn btn-primary w-100" type="submit" <?= $catalogOptionsReady ? '' : 'disabled' ?>><i class="bi bi-plus-lg"></i> Crear</button></div>
          </form>
          <div class="table-responsive">
            <table class="table align-middle admin-table">
              <thead><tr><th>Tela</th><th>Descripción</th><th>Estado</th><th class="text-end">Acciones</th></tr></thead>
              <tbody>
                <?php foreach ($fabrics as $fabric): ?>
                  <?php $fabricFormId = 'fabric-form-' . (int) $fabric['id_tela']; ?>
                  <tr>
                    <td data-label="Tela"><input class="form-control" form="<?= $fabricFormId ?>" name="name" value="<?= $e($fabric['nombre']) ?>" required></td>
                    <td data-label="Descripción"><input class="form-control" form="<?= $fabricFormId ?>" name="description" value="<?= $e($fabric['descripcion'] ?? '') ?>"></td>
                    <td data-label="Estado"><label class="form-check"><input class="form-check-input" form="<?= $fabricFormId ?>" name="active" type="checkbox" <?= ((int) $fabric['activo'] === 1) ? 'checked' : '' ?>> Activa</label></td>
                    <td data-label="Acciones">
                      <div class="d-flex justify-content-end gap-2">
                        <form id="<?= $fabricFormId ?>" method="post" action="/admin/telas/<?= (int) $fabric['id_tela'] ?>/editar"></form>
                        <button class="btn btn-light btn-icon" form="<?= $fabricFormId ?>" type="submit" title="Guardar"><i class="bi bi-check2"></i></button>
                        <?php if ((int) $fabric['activo'] === 1): ?>
                          <form method="post" action="/admin/telas/<?= (int) $fabric['id_tela'] ?>/eliminar" onsubmit="return confirm('¿Desactivar esta tela?');">
                            <button class="btn btn-light btn-icon text-danger" type="submit" title="Desactivar"><i class="bi bi-trash"></i></button>
                          </form>
                        <?php endif; ?>
                      </div>
                    </td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        </div>
      </section>

      <section id="colores" class="admin-section <?= $activeModule === 'colores' ? '' : 'd-none' ?>">
        <div class="section-title">
          <div>
            <p>Muestras visuales opcionales</p>
            <h2>Colores</h2>
          </div>
        </div>
        <div class="admin-panel">
          <form class="row g-2 align-items-end mb-3" method="post" action="/admin/colores/crear">
            <div class="col-md-4"><label class="form-label">Nombre</label><input class="form-control" name="name" required <?= $catalogOptionsReady ? '' : 'disabled' ?>></div>
            <div class="col-md-2"><label class="form-label">Muestra</label><input class="form-control form-control-color" name="hex" type="color" value="#d8c6ad" <?= $catalogOptionsReady ? '' : 'disabled' ?>></div>
            <div class="col-md-2 form-check admin-check"><input class="form-check-input" name="use_hex" type="checkbox" <?= $catalogOptionsReady ? '' : 'disabled' ?>><label class="form-check-label">Usar muestra</label></div>
            <div class="col-md-2 form-check admin-check"><input class="form-check-input" name="active" type="checkbox" checked <?= $catalogOptionsReady ? '' : 'disabled' ?>><label class="form-check-label">Activo</label></div>
            <div class="col-md-2"><button class="btn btn-primary w-100" type="submit" <?= $catalogOptionsReady ? '' : 'disabled' ?>><i class="bi bi-plus-lg"></i> Crear</button></div>
          </form>
          <div class="table-responsive">
            <table class="table align-middle admin-table">
              <thead><tr><th>Color</th><th>Muestra</th><th>Estado</th><th class="text-end">Acciones</th></tr></thead>
              <tbody>
                <?php foreach ($colors as $color): ?>
                  <?php $colorFormId = 'color-form-' . (int) $color['id_color']; ?>
                  <?php $hasVisualColor = !empty($color['codigo_hex']); ?>
                  <tr>
                    <td data-label="Color"><input class="form-control" form="<?= $colorFormId ?>" name="name" value="<?= $e($color['nombre']) ?>" required></td>
                    <td class="color-edit-cell" data-label="Muestra">
                      <input class="form-control form-control-color" form="<?= $colorFormId ?>" name="hex" type="color" value="<?= $e($color['codigo_hex'] ?: '#d8c6ad') ?>">
                      <label class="form-check"><input class="form-check-input" form="<?= $colorFormId ?>" name="use_hex" type="checkbox" <?= $hasVisualColor ? 'checked' : '' ?>> Usar</label>
                    </td>
                    <td data-label="Estado"><label class="form-check"><input class="form-check-input" form="<?= $colorFormId ?>" name="active" type="checkbox" <?= ((int) $color['activo'] === 1) ? 'checked' : '' ?>> Activo</label></td>
                    <td data-label="Acciones">
                      <div class="d-flex justify-content-end gap-2">
                        <form id="<?= $colorFormId ?>" method="post" action="/admin/colores/<?= (int) $color['id_color'] ?>/editar"></form>
                        <button class="btn btn-light btn-icon" form="<?= $colorFormId ?>" type="submit" title="Guardar"><i class="bi bi-check2"></i></button>
                        <?php if ((int) $color['activo'] === 1): ?>
                          <form method="post" action="/admin/colores/<?= (int) $color['id_color'] ?>/eliminar" onsubmit="return confirm('¿Desactivar este color?');">
                            <button class="btn btn-light btn-icon text-danger" type="submit" title="Desactivar"><i class="bi bi-trash"></i></button>
                          </form>
                        <?php endif; ?>
                      </div>
                    </td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        </div>
      </section>

      <section id="combinaciones" class="admin-section <?= $activeModule === 'combinaciones' ? '' : 'd-none' ?>">
        <div class="section-title">
          <div>
            <p>Disponibilidad global</p>
            <h2>Combinaciones tela/color</h2>
          </div>
        </div>
        <div class="admin-panel">
          <form class="row g-2 align-items-end mb-3" method="post" action="/admin/tela-colores/crear">
            <div class="col-md-4">
              <label class="form-label">Tela</label>
              <select class="form-select" name="fabric_id" <?= $catalogOptionsReady ? '' : 'disabled' ?> required>
                <option value="">Seleccionar</option>
                <?php foreach ($fabrics as $fabric): ?>
                  <?php if ((int) $fabric['activo'] === 1): ?><option value="<?= (int) $fabric['id_tela'] ?>"><?= $e($fabric['nombre']) ?></option><?php endif; ?>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="col-md-4">
              <label class="form-label">Color</label>
              <select class="form-select" name="color_id" <?= $catalogOptionsReady ? '' : 'disabled' ?> required>
                <option value="">Seleccionar</option>
                <?php foreach ($colors as $color): ?>
                  <?php if ((int) $color['activo'] === 1): ?><option value="<?= (int) $color['id_color'] ?>"><?= $e($color['nombre']) ?></option><?php endif; ?>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="col-md-4"><button class="btn btn-primary w-100" type="submit" <?= $catalogOptionsReady ? '' : 'disabled' ?>><i class="bi bi-plus-lg"></i> Crear combinación</button></div>
          </form>
          <div class="table-responsive">
            <table class="table align-middle admin-table">
              <thead><tr><th>Tela</th><th>Color</th><th>Estado</th><th class="text-end">Acciones</th></tr></thead>
              <tbody>
                <?php foreach ($fabricColors as $fabricColor): ?>
                  <tr>
                    <td data-label="Tela"><?= $e($fabricColor['tela']) ?></td>
                    <td data-label="Color"><span class="color-pill"><?php if (!empty($fabricColor['codigo_hex'])): ?><i style="background: <?= $e($fabricColor['codigo_hex']) ?>"></i><?php endif; ?><?= $e($fabricColor['color']) ?></span></td>
                    <td data-label="Estado"><span class="badge rounded-pill <?= ((int) $fabricColor['disponible'] === 1) ? 'text-bg-success-subtle' : 'text-bg-secondary' ?>"><?= ((int) $fabricColor['disponible'] === 1) ? 'Disponible' : 'Inactiva' ?></span></td>
                    <td data-label="Acciones">
                      <div class="d-flex justify-content-end">
                        <?php if ((int) $fabricColor['disponible'] === 1): ?>
                          <form method="post" action="/admin/tela-colores/<?= (int) $fabricColor['id_tela_color'] ?>/eliminar" onsubmit="return confirm('¿Desactivar esta combinación?');">
                            <button class="btn btn-light btn-icon text-danger" type="submit" title="Desactivar"><i class="bi bi-trash"></i></button>
                          </form>
                        <?php endif; ?>
                      </div>
                    </td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        </div>
      </section>

      <section id="usuarios" class="admin-section <?= $activeModule === 'usuarios' ? '' : 'd-none' ?>">
        <div class="section-title">
          <div>
            <p>Gestionar</p>
            <h2>Usuarios</h2>
          </div>
        </div>
        <div class="admin-panel">
          <form class="row g-2 align-items-end mb-3" method="post" action="/admin/usuarios/crear">
            <div class="col-md-2"><label class="form-label">Nombre</label><input class="form-control" name="name" required></div>
            <div class="col-md-2"><label class="form-label">Email</label><input class="form-control" name="email" type="email" required></div>
            <div class="col-md-2"><label class="form-label">Usuario</label><input class="form-control" name="username" required></div>
            <div class="col-md-2"><label class="form-label">Rol</label><select class="form-select" name="role_id" required><?php foreach ($roles as $role): ?><option value="<?= (int) $role['id_rol'] ?>"><?= $e($role['nombre']) ?></option><?php endforeach; ?></select></div>
            <div class="col-md-2"><label class="form-label">Clave inicial</label><input class="form-control" name="password" type="password" minlength="8" required></div>
            <div class="col-md-1 form-check admin-check"><input class="form-check-input" name="active" type="checkbox" checked><label class="form-check-label">Activo</label></div>
            <div class="col-md-1"><button class="btn btn-primary w-100" type="submit"><i class="bi bi-plus-lg"></i></button></div>
          </form>
          <div class="table-responsive">
            <table class="table align-middle admin-table">
              <thead><tr><th>Nombre</th><th>Email</th><th>Usuario</th><th>Rol</th><th>Estado</th><th class="text-end">Acciones</th></tr></thead>
              <tbody>
                <?php foreach ($users as $user): ?>
                  <?php $userFormId = 'user-form-' . (int) $user['id_usuario']; ?>
                  <tr>
                    <td data-label="Nombre"><input class="form-control" form="<?= $userFormId ?>" name="name" value="<?= $e($user['nombre']) ?>" required></td>
                    <td data-label="Email"><input class="form-control" form="<?= $userFormId ?>" name="email" type="email" value="<?= $e($user['email']) ?>" required></td>
                    <td data-label="Usuario"><input class="form-control" form="<?= $userFormId ?>" name="username" value="<?= $e($user['usuario']) ?>" required></td>
                    <td data-label="Rol"><select class="form-select" form="<?= $userFormId ?>" name="role_id" required><?php foreach ($roles as $role): ?><option value="<?= (int) $role['id_rol'] ?>" <?= (int) $role['id_rol'] === (int) $user['id_rol'] ? 'selected' : '' ?>><?= $e($role['nombre']) ?></option><?php endforeach; ?></select></td>
                    <td data-label="Estado"><label class="form-check"><input class="form-check-input" form="<?= $userFormId ?>" name="active" type="checkbox" <?= ((int) $user['activo'] === 1) ? 'checked' : '' ?>> Activo</label></td>
                    <td data-label="Acciones">
                      <div class="d-flex justify-content-end gap-2">
                        <form id="<?= $userFormId ?>" method="post" action="/admin/usuarios/<?= (int) $user['id_usuario'] ?>/editar"></form>
                        <button class="btn btn-light btn-icon" form="<?= $userFormId ?>" type="submit" title="Guardar"><i class="bi bi-check2"></i></button>
                        <?php if ((int) $user['activo'] === 1 && (int) $user['id_usuario'] !== (int) ($adminUser['id'] ?? 0)): ?>
                          <form method="post" action="/admin/usuarios/<?= (int) $user['id_usuario'] ?>/eliminar" onsubmit="return confirm('¿Desactivar este usuario?');">
                            <button class="btn btn-light btn-icon text-danger" type="submit" title="Desactivar"><i class="bi bi-trash"></i></button>
                          </form>
                        <?php endif; ?>
                      </div>
                    </td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        </div>
      </section>

      <section id="configuracion" class="admin-section <?= $activeModule === 'configuracion' ? '' : 'd-none' ?>">
        <div class="section-title">
          <div>
            <p>SEO y contacto</p>
            <h2>Configuración del sitio</h2>
          </div>
        </div>
        <form class="admin-panel" method="post" action="/admin/configuracion">
          <div class="row g-3">
            <div class="col-md-4"><label class="form-label">Nombre comercial</label><input class="form-control" name="site_name" value="<?= $e($settings['site_name'] ?? 'Tapisur') ?>" required></div>
            <div class="col-md-4"><label class="form-label">Email</label><input class="form-control" name="contact_email" type="email" value="<?= $e($settings['contact_email'] ?? '') ?>"></div>
            <div class="col-md-4"><label class="form-label">Zona horaria</label><input class="form-control" name="timezone" value="<?= $e($settings['timezone'] ?? 'America/Argentina/Buenos_Aires') ?>"></div>
            <div class="col-md-4"><label class="form-label">WhatsApp destino</label><input class="form-control" name="whatsapp_number" value="<?= $e($settings['whatsapp_number'] ?? '+54 9 11 5110-3419') ?>" required></div>
            <div class="col-md-4"><label class="form-label">Teléfono principal</label><input class="form-control" name="phone_1" value="<?= $e($settings['phone_1'] ?? '') ?>"></div>
            <div class="col-md-4"><label class="form-label">Teléfono secundario</label><input class="form-control" name="phone_2" value="<?= $e($settings['phone_2'] ?? '') ?>"></div>
            <div class="col-md-6"><label class="form-label">Instagram</label><input class="form-control" name="instagram_url" type="url" value="<?= $e($settings['instagram_url'] ?? '') ?>"></div>
            <div class="col-md-6"><label class="form-label">Dirección</label><input class="form-control" name="address" value="<?= $e($settings['address'] ?? '') ?>"></div>
            <div class="col-md-6"><label class="form-label">Horario lunes a viernes</label><input class="form-control" name="business_hours_weekdays" value="<?= $e($settings['business_hours_weekdays'] ?? '') ?>"></div>
            <div class="col-md-6"><label class="form-label">Horario sábados</label><input class="form-control" name="business_hours_saturday" value="<?= $e($settings['business_hours_saturday'] ?? '') ?>"></div>
            <div class="col-md-6"><label class="form-label">Meta title</label><input class="form-control" name="meta_title" value="<?= $e($settings['meta_title'] ?? '') ?>"></div>
            <div class="col-md-6"><label class="form-label">Meta description</label><textarea class="form-control" name="meta_description" rows="2"><?= $e($settings['meta_description'] ?? '') ?></textarea></div>
          </div>
          <div class="d-flex justify-content-end mt-3">
            <button class="btn btn-primary" type="submit"><i class="bi bi-save"></i> Guardar configuración</button>
          </div>
        </form>
      </section>
    </div>
  </div>

  <div class="modal fade" id="passwordModal" tabindex="-1" aria-labelledby="passwordModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <form class="modal-content" method="post" action="/admin/perfil/clave">
        <div class="modal-header">
          <h2 class="modal-title fs-5" id="passwordModalLabel">Cambiar clave</h2>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>
        <div class="modal-body d-grid gap-3">
          <div>
            <label class="form-label" for="current_password">Clave actual</label>
            <input class="form-control" id="current_password" name="current_password" type="password" autocomplete="current-password" required>
          </div>
          <div>
            <label class="form-label" for="new_password">Clave nueva</label>
            <input class="form-control" id="new_password" name="new_password" type="password" minlength="8" autocomplete="new-password" required>
          </div>
          <div>
            <label class="form-label" for="new_password_confirmation">Repetir clave nueva</label>
            <input class="form-control" id="new_password_confirmation" name="new_password_confirmation" type="password" minlength="8" autocomplete="new-password" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-dark" data-bs-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Guardar clave</button>
        </div>
      </form>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
