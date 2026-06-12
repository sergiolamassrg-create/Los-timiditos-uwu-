<?php
$e = fn($value) => htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
$short = fn($value) => function_exists('mb_strimwidth')
    ? mb_strimwidth((string) $value, 0, 90, '...')
    : substr((string) $value, 0, 87) . (strlen((string) $value) > 87 ? '...' : '');
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

    <section class="admin-card">
      <div class="section-head">
        <div>
          <h2>Productos</h2>
          <p class="muted">Los cambios impactan en la página pública del catálogo.</p>
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
  </main>
</body>
</html>
