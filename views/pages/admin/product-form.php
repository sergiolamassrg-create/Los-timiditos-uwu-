<?php
$e = fn($value) => htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
$product = $product ?? [];
$selectedCategory = (int) ($product['id_categoria_producto'] ?? 0);
$isActive = !array_key_exists('activo', $product) || (int) $product['activo'] === 1;
$isFeatured = (int) ($product['destacado'] ?? 0) === 1;
?>
<!doctype html>
<html lang="es-AR">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="theme-color" content="#f6f4ef" />
  <title><?= $e($title) ?> | Admin TAPISUR</title>
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;700&family=Outfit:wght@500;600;700&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="/css/admin.css" />
</head>
<body>
  <main class="admin-shell">
    <header class="admin-topbar">
      <div>
        <p class="eyebrow">Catálogo</p>
        <h1><?= $e($title) ?></h1>
        <p class="muted">Los campos se guardan en `productos` y la imagen principal en `producto_imagenes`.</p>
      </div>
      <div class="topbar-actions">
        <a class="btn btn-ghost" href="/admin/catalogo">Volver</a>
        <form method="post" action="/admin/logout">
          <button class="btn btn-ghost" type="submit">Cerrar sesión</button>
        </form>
      </div>
    </header>

    <?php if (!empty($error)): ?>
      <p class="alert alert-error"><?= $e($error) ?></p>
    <?php endif; ?>

    <section class="admin-card">
      <form class="form-grid form-grid--wide" method="post" action="<?= $e($formAction) ?>">
        <label for="category_id">Categoría</label>
        <select id="category_id" name="category_id" required>
          <option value="">Seleccionar</option>
          <?php foreach ($categories as $category): ?>
            <option value="<?= (int) $category['id_categoria_producto'] ?>" <?= $selectedCategory === (int) $category['id_categoria_producto'] ? 'selected' : '' ?>>
              <?= $e($category['nombre']) ?>
            </option>
          <?php endforeach; ?>
        </select>

        <label for="name">Nombre</label>
        <input id="name" name="name" type="text" value="<?= $e($product['nombre'] ?? '') ?>" required />

        <label for="description">Descripción</label>
        <textarea id="description" name="description" rows="4" required><?= $e($product['descripcion'] ?? '') ?></textarea>

        <label for="materials">Materiales</label>
        <input id="materials" name="materials" type="text" value="<?= $e($product['materiales'] ?? '') ?>" placeholder="Chenille, pana, cuerina" />

        <label for="colors">Colores</label>
        <input id="colors" name="colors" type="text" value="<?= $e($product['colores'] ?? '') ?>" placeholder="Beige, gris, oliva" />

        <label for="sizes">Medidas sugeridas</label>
        <input id="sizes" name="sizes" type="text" value="<?= $e($product['medidas_sugeridas'] ?? '') ?>" placeholder="2.10 x 0.85 m, personalizada" />

        <label for="capacity">Capacidad</label>
        <input id="capacity" name="capacity" type="number" min="0" value="<?= (int) ($product['capacidad'] ?? 0) ?>" />

        <label for="image_path">Imagen principal</label>
        <input id="image_path" name="image_path" type="text" value="<?= $e($product['imagen'] ?? '') ?>" placeholder="/img/catalogo/page01_img01.jpeg" />

        <div class="toggle-row">
          <label><input name="featured" type="checkbox" <?= $isFeatured ? 'checked' : '' ?> /> Destacado</label>
          <label><input name="active" type="checkbox" <?= $isActive ? 'checked' : '' ?> /> Activo</label>
        </div>

        <div class="actions">
          <button type="submit">Guardar</button>
          <a class="btn btn-ghost" href="/admin/catalogo">Cancelar</a>
        </div>
      </form>
    </section>
  </main>
</body>
</html>
