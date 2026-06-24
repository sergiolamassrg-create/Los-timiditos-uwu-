<?php
$e = fn($value) => htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
$product = $product ?? [];
$selectedCategory = (int) ($product['id_categoria_producto'] ?? 0);
$isActive = array_key_exists('activo', $product) ? (int) $product['activo'] === 1 : false;
$isFeatured = (int) ($product['destacado'] ?? 0) === 1;
$currentImage = trim((string) ($product['imagen'] ?? ''));
?>
<!doctype html>
<html lang="es-AR">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="icon" href="/img/favicon-admin.svg" type="image/svg+xml" />
  <link rel="alternate icon" href="/img/logo-icon.png" type="image/png" />
  <title><?= $e($title) ?> | Admin Tapisur</title>
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;700&family=Outfit:wght@500;600;700&display=swap" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="/css/admin.css" />
</head>
<body class="admin-body">
  <div class="admin-app">
    <aside class="admin-sidebar">
      <a class="admin-brand" href="/admin/productos">
        <img src="/img/logo-icon.png" alt="Tapisur" />
        <span>Tapisur</span>
      </a>
      <nav class="admin-nav" aria-label="Navegación admin">
        <a href="/admin/dashboard"><i class="bi bi-speedometer2"></i> Dashboard</a>
        <a href="/admin/productos" class="active"><i class="bi bi-box-seam"></i> Productos</a>
        <a href="/admin/telas"><i class="bi bi-layers"></i> Telas</a>
        <a href="/admin/colores"><i class="bi bi-palette"></i> Colores</a>
        <a href="/admin/combinaciones"><i class="bi bi-diagram-3"></i> Combinaciones</a>
      </nav>
    </aside>

    <main class="admin-main">
      <header class="admin-header">
        <div>
          <p class="admin-kicker">Catálogo</p>
          <h1><?= $e($title) ?></h1>
        </div>
        <div class="d-flex gap-2">
          <a class="btn btn-outline-dark" href="/admin/productos"><i class="bi bi-arrow-left"></i> Volver</a>
          <form method="post" action="/admin/logout">
            <button class="btn btn-outline-dark" type="submit" aria-label="Cerrar sesión"><i class="bi bi-box-arrow-right"></i></button>
          </form>
        </div>
      </header>

      <?php if (!empty($error)): ?>
        <div class="alert alert-danger"><i class="bi bi-exclamation-triangle"></i> <?= $e($error) ?></div>
      <?php endif; ?>

      <form class="admin-panel product-editor" method="post" action="<?= $e($formAction) ?>" enctype="multipart/form-data">
        <input type="hidden" name="capacity" value="<?= (int) ($product['capacidad'] ?? 0) ?>" />
        <input type="hidden" id="image_path" name="image_path" value="<?= $e($currentImage) ?>" />

        <div class="product-editor-grid">
          <section class="product-editor-main" aria-label="Datos del producto">
            <div class="row g-3">
              <div class="col-md-5">
                <label class="form-label" for="category_id">Categoría</label>
                <select class="form-select" id="category_id" name="category_id" required>
                  <option value="">Seleccionar</option>
                  <?php foreach ($categories as $category): ?>
                    <option value="<?= (int) $category['id_categoria_producto'] ?>" <?= $selectedCategory === (int) $category['id_categoria_producto'] ? 'selected' : '' ?>>
                      <?= $e($category['nombre']) ?>
                    </option>
                  <?php endforeach; ?>
                </select>
              </div>
              <div class="col-md-7">
                <label class="form-label" for="name">Nombre</label>
                <input class="form-control" id="name" name="name" type="text" value="<?= $e($product['nombre'] ?? '') ?>" placeholder="Ej: Sillón rinconero" required />
              </div>
              <div class="col-12">
                <label class="form-label" for="description">Descripción</label>
                <textarea class="form-control" id="description" name="description" rows="7" placeholder="Contá las características principales del producto." required><?= $e($product['descripcion'] ?? '') ?></textarea>
              </div>
            </div>
          </section>

          <aside class="product-image-panel" aria-label="Imagen principal">
            <div class="product-image-head">
              <div>
                <h2>Imagen principal</h2>
                <p>Arrastrá una imagen o subila desde tu dispositivo.</p>
              </div>
            </div>
            <label class="image-dropzone" for="product_image" data-image-dropzone>
              <input id="product_image" name="product_image" type="file" accept="image/jpeg,image/png,image/webp" data-image-input />
              <span class="image-dropzone-icon"><i class="bi bi-cloud-arrow-up"></i></span>
              <strong>Soltar imagen acá</strong>
              <small>JPG, PNG o WEBP hasta 5 MB</small>
              <span class="btn btn-outline-dark btn-sm" aria-hidden="true">Elegir archivo</span>
            </label>
            <figure class="image-preview <?= $currentImage === '' ? 'is-empty' : '' ?>" data-image-preview>
              <?php if ($currentImage !== ''): ?>
                <img src="<?= $e($currentImage) ?>" alt="Imagen actual del producto" />
              <?php else: ?>
                <span><i class="bi bi-image"></i> Sin imagen cargada</span>
              <?php endif; ?>
            </figure>
            <p class="image-upload-note" data-image-filename><?= $currentImage !== '' ? 'Imagen actual cargada.' : 'Todavía no seleccionaste una imagen.' ?></p>
          </aside>
        </div>

        <div class="product-editor-actions">
          <div class="product-switches">
            <label class="status-switch product-form-switch" title="Publicar u ocultar producto">
              <input name="active" type="checkbox" value="1" <?= $isActive ? 'checked' : '' ?> />
              <span class="status-switch-track" aria-hidden="true"><span></span></span>
              <em>Activo en catálogo</em>
            </label>
            <label class="form-check featured-check">
              <input class="form-check-input" name="featured" type="checkbox" <?= $isFeatured ? 'checked' : '' ?> />
              <span>Destacado</span>
            </label>
          </div>
          <div class="d-flex gap-2">
            <a class="btn btn-outline-dark" href="/admin/productos">Cancelar</a>
            <button class="btn btn-primary" type="submit"><i class="bi bi-save"></i> Guardar producto</button>
          </div>
        </div>
      </form>
    </main>
  </div>

  <script>
    const dropzone = document.querySelector('[data-image-dropzone]');
    const input = document.querySelector('[data-image-input]');
    const preview = document.querySelector('[data-image-preview]');
    const filename = document.querySelector('[data-image-filename]');

    const renderPreview = (file) => {
      if (!file || !file.type.startsWith('image/')) return;
      const reader = new FileReader();
      reader.onload = () => {
        preview.classList.remove('is-empty');
        preview.innerHTML = `<img src="${reader.result}" alt="Vista previa de la imagen seleccionada" />`;
        filename.textContent = file.name;
      };
      reader.readAsDataURL(file);
    };

    input?.addEventListener('change', () => renderPreview(input.files[0]));

    ['dragenter', 'dragover'].forEach((eventName) => {
      dropzone?.addEventListener(eventName, (event) => {
        event.preventDefault();
        dropzone.classList.add('is-dragging');
      });
    });

    ['dragleave', 'drop'].forEach((eventName) => {
      dropzone?.addEventListener(eventName, (event) => {
        event.preventDefault();
        dropzone.classList.remove('is-dragging');
      });
    });

    dropzone?.addEventListener('drop', (event) => {
      const file = event.dataTransfer.files[0];
      if (!file) return;
      const transfer = new DataTransfer();
      transfer.items.add(file);
      input.files = transfer.files;
      renderPreview(file);
    });
  </script>
</body>
</html>
