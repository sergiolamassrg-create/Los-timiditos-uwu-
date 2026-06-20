<?php
$e = fn($value) => htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
$short = fn($value) => function_exists('mb_strimwidth')
    ? mb_strimwidth((string) $value, 0, 90, '...')
    : substr((string) $value, 0, 87) . (strlen((string) $value) > 87 ? '...' : '');
$fabrics = $fabrics ?? [];
$colors = $colors ?? [];
$fabricColors = $fabricColors ?? [];
$catalogOptionsReady = (bool) ($catalogOptionsReady ?? false);
?>
<!doctype html>
<html lang="es-AR">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="theme-color" content="#f6f4ef" />
  <title>ABM Catálogo TAPISUR</title>
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;700&family=Outfit:wght@500;600;700&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="/css/admin.css" />
</head>
<body>
  <main class="admin-shell">
    <header class="admin-topbar">
      <div>
        <p class="eyebrow">Panel protegido</p>
        <h1>ABM de catálogo</h1>
        <p class="muted">Sesión: <?= $e($adminUser['name'] ?? 'Admin') ?></p>
      </div>
      <div class="topbar-actions">
        <a class="btn btn-ghost" href="/catalogo" target="_blank" rel="noopener">Ver catálogo</a>
        <form method="post" action="/admin/logout">
          <button class="btn btn-ghost" type="submit">Cerrar sesión</button>
        </form>
      </div>
    </header>

    <?php if (!empty($message)): ?>
      <p class="alert alert-ok"><?= $e($message) ?></p>
    <?php endif; ?>

    <?php if (!empty($error)): ?>
      <p class="alert alert-error"><?= $e($error) ?></p>
    <?php endif; ?>

    <?php if (!$catalogOptionsReady): ?>
      <p class="alert alert-error">Para administrar telas y colores importá primero `database/schema_v2_telas_colores.sql` o aplicá las tablas V2 sobre la base actual.</p>
    <?php endif; ?>

    <section class="admin-card">
      <div class="section-head">
        <div>
          <h2>Productos</h2>
          <p class="muted">Los productos ya no guardan telas ni colores propios. Esas opciones se administran globalmente abajo.</p>
        </div>
        <a class="btn" href="/admin/catalogo/crear">Nuevo producto</a>
      </div>

      <div class="table-wrap">
        <table>
          <thead>
            <tr>
              <th>Producto</th>
              <th>Categoría</th>
              <th>Capacidad</th>
              <th>Destacado</th>
              <th>Estado</th>
              <th>Imagen</th>
              <th>Acciones</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($products as $product): ?>
              <tr>
                <td>
                  <strong><?= $e($product['nombre']) ?></strong>
                  <span><?= $e($short($product['descripcion'])) ?></span>
                </td>
                <td><?= $e($product['categoria']) ?></td>
                <td><?= (int) $product['capacidad'] ?></td>
                <td><?= ((int) $product['destacado'] === 1) ? 'Sí' : 'No' ?></td>
                <td>
                  <span class="status <?= ((int) $product['activo'] === 1) ? 'is-active' : 'is-inactive' ?>">
                    <?= ((int) $product['activo'] === 1) ? 'Activo' : 'Inactivo' ?>
                  </span>
                </td>
                <td><code><?= $e($product['imagen'] ?: 'Sin imagen') ?></code></td>
                <td class="row-actions">
                  <a class="btn btn-small btn-ghost" href="/admin/catalogo/<?= (int) $product['id_producto'] ?>/editar">Editar</a>
                  <?php if ((int) $product['activo'] === 1): ?>
                    <form method="post" action="/admin/catalogo/<?= (int) $product['id_producto'] ?>/eliminar" onsubmit="return confirm('¿Desactivar este producto?');">
                      <button class="btn btn-small btn-danger" type="submit">Desactivar</button>
                    </form>
                  <?php endif; ?>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </section>

    <section class="admin-card admin-card-spaced">
      <div class="section-head">
        <div>
          <h2>Telas</h2>
          <p class="muted">Catálogo central de telas disponible para todos los sillones.</p>
        </div>
      </div>

      <form class="inline-create" method="post" action="/admin/telas/crear">
        <input name="name" type="text" placeholder="Nombre de tela" <?= $catalogOptionsReady ? '' : 'disabled' ?> required />
        <input name="description" type="text" placeholder="Descripción opcional" <?= $catalogOptionsReady ? '' : 'disabled' ?> />
        <label class="inline-check"><input name="active" type="checkbox" checked <?= $catalogOptionsReady ? '' : 'disabled' ?> /> Activa</label>
        <button type="submit" <?= $catalogOptionsReady ? '' : 'disabled' ?>>Crear tela</button>
      </form>

      <div class="table-wrap table-wrap-compact">
        <table>
          <thead>
            <tr>
              <th>Tela</th>
              <th>Descripción</th>
              <th>Estado</th>
              <th>Acciones</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($fabrics as $fabric): ?>
              <?php $fabricFormId = 'fabric-form-' . (int) $fabric['id_tela']; ?>
              <tr>
                <td><input form="<?= $fabricFormId ?>" name="name" type="text" value="<?= $e($fabric['nombre']) ?>" required /></td>
                <td><input form="<?= $fabricFormId ?>" name="description" type="text" value="<?= $e($fabric['descripcion'] ?? '') ?>" /></td>
                <td>
                  <label class="inline-check"><input form="<?= $fabricFormId ?>" name="active" type="checkbox" <?= ((int) $fabric['activo'] === 1) ? 'checked' : '' ?> /> Activa</label>
                </td>
                <td class="row-actions">
                  <form id="<?= $fabricFormId ?>" method="post" action="/admin/telas/<?= (int) $fabric['id_tela'] ?>/editar"></form>
                  <button class="btn-small" form="<?= $fabricFormId ?>" type="submit">Guardar</button>
                  <?php if ((int) $fabric['activo'] === 1): ?>
                    <form method="post" action="/admin/telas/<?= (int) $fabric['id_tela'] ?>/eliminar" onsubmit="return confirm('¿Desactivar esta tela?');">
                      <button class="btn btn-small btn-danger" type="submit">Desactivar</button>
                    </form>
                  <?php endif; ?>
                </td>
              </tr>
            <?php endforeach; ?>
            <?php if (!$fabrics): ?>
              <tr><td colspan="4">No hay telas cargadas.</td></tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </section>

    <section class="admin-card admin-card-spaced">
      <div class="section-head">
        <div>
          <h2>Colores</h2>
          <p class="muted">Colores globales. Luego se combinan con cada tela disponible.</p>
        </div>
      </div>

      <form class="inline-create" method="post" action="/admin/colores/crear">
        <input name="name" type="text" placeholder="Nombre de color" <?= $catalogOptionsReady ? '' : 'disabled' ?> required />
        <label class="visual-color-field">
          <span>Color visual <small>opcional</small></span>
          <input name="hex" type="color" value="#d8c6ad" <?= $catalogOptionsReady ? '' : 'disabled' ?> />
          <label class="inline-check"><input name="use_hex" type="checkbox" <?= $catalogOptionsReady ? '' : 'disabled' ?> /> Usar muestra</label>
        </label>
        <label class="inline-check"><input name="active" type="checkbox" checked <?= $catalogOptionsReady ? '' : 'disabled' ?> /> Activo</label>
        <button type="submit" <?= $catalogOptionsReady ? '' : 'disabled' ?>>Crear color</button>
      </form>

      <div class="table-wrap table-wrap-compact">
        <table>
          <thead>
            <tr>
              <th>Color</th>
              <th>Color visual</th>
              <th>Estado</th>
              <th>Acciones</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($colors as $color): ?>
              <?php $colorFormId = 'color-form-' . (int) $color['id_color']; ?>
              <?php $hasVisualColor = !empty($color['codigo_hex']); ?>
              <tr>
                <td><input form="<?= $colorFormId ?>" name="name" type="text" value="<?= $e($color['nombre']) ?>" required /></td>
                <td>
                  <label class="visual-color-field visual-color-field--row">
                    <input form="<?= $colorFormId ?>" name="hex" type="color" value="<?= $e($color['codigo_hex'] ?: '#d8c6ad') ?>" />
                    <label class="inline-check"><input form="<?= $colorFormId ?>" name="use_hex" type="checkbox" <?= $hasVisualColor ? 'checked' : '' ?> /> Usar muestra</label>
                  </label>
                </td>
                <td>
                  <label class="inline-check"><input form="<?= $colorFormId ?>" name="active" type="checkbox" <?= ((int) $color['activo'] === 1) ? 'checked' : '' ?> /> Activo</label>
                </td>
                <td class="row-actions">
                  <form id="<?= $colorFormId ?>" method="post" action="/admin/colores/<?= (int) $color['id_color'] ?>/editar"></form>
                  <button class="btn-small" form="<?= $colorFormId ?>" type="submit">Guardar</button>
                  <?php if ((int) $color['activo'] === 1): ?>
                    <form method="post" action="/admin/colores/<?= (int) $color['id_color'] ?>/eliminar" onsubmit="return confirm('¿Desactivar este color?');">
                      <button class="btn btn-small btn-danger" type="submit">Desactivar</button>
                    </form>
                  <?php endif; ?>
                </td>
              </tr>
            <?php endforeach; ?>
            <?php if (!$colors): ?>
              <tr><td colspan="4">No hay colores cargados.</td></tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </section>

    <section class="admin-card admin-card-spaced">
      <div class="section-head">
        <div>
          <h2>Combinaciones tela/color</h2>
          <p class="muted">Elegí una tela y un color para indicar que esa variante existe.</p>
        </div>
      </div>

      <form class="inline-create inline-create--compact" method="post" action="/admin/tela-colores/crear">
        <select name="fabric_id" <?= $catalogOptionsReady ? '' : 'disabled' ?> required>
          <option value="">Tela</option>
          <?php foreach ($fabrics as $fabric): ?>
            <?php if ((int) $fabric['activo'] === 1): ?>
              <option value="<?= (int) $fabric['id_tela'] ?>"><?= $e($fabric['nombre']) ?></option>
            <?php endif; ?>
          <?php endforeach; ?>
        </select>
        <select name="color_id" <?= $catalogOptionsReady ? '' : 'disabled' ?> required>
          <option value="">Color</option>
          <?php foreach ($colors as $color): ?>
            <?php if ((int) $color['activo'] === 1): ?>
              <option value="<?= (int) $color['id_color'] ?>"><?= $e($color['nombre']) ?></option>
            <?php endif; ?>
          <?php endforeach; ?>
        </select>
        <button type="submit" <?= $catalogOptionsReady ? '' : 'disabled' ?>>Crear combinación</button>
      </form>

      <div class="table-wrap table-wrap-compact">
        <table>
          <thead>
            <tr>
              <th>Tela</th>
              <th>Color</th>
              <th>Estado</th>
              <th>Acciones</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($fabricColors as $fabricColor): ?>
              <tr>
                <td><?= $e($fabricColor['tela']) ?></td>
                <td>
                  <span class="color-chip">
                    <?= $e($fabricColor['color']) ?>
                  </span>
                </td>
                <td>
                  <span class="status <?= ((int) $fabricColor['disponible'] === 1) ? 'is-active' : 'is-inactive' ?>">
                    <?= ((int) $fabricColor['disponible'] === 1) ? 'Disponible' : 'Inactiva' ?>
                  </span>
                </td>
                <td class="row-actions">
                  <?php if ((int) $fabricColor['disponible'] === 1): ?>
                    <form method="post" action="/admin/tela-colores/<?= (int) $fabricColor['id_tela_color'] ?>/eliminar" onsubmit="return confirm('¿Desactivar esta combinación?');">
                      <button class="btn btn-small btn-danger" type="submit">Desactivar</button>
                    </form>
                  <?php endif; ?>
                </td>
              </tr>
            <?php endforeach; ?>
            <?php if (!$fabricColors): ?>
              <tr><td colspan="4">No hay combinaciones cargadas.</td></tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </section>
  </main>
</body>
</html>
