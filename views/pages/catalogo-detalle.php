<?php
$e = fn($value) => htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
$item = $item ?? null;
$pageTitle = $item ? $item['name'] . ' | Catalogo TAPISUR' : 'Producto no encontrado | TAPISUR';
$pageDescription = $item ? 'Ficha de ' . $item['name'] . ' para consultar por material, color y medida.' : 'Producto no encontrado en el catalogo de TAPISUR.';
$ogImage = $item['image'] ?? '/img/catalogo/page11_img03.jpeg';
$bodyClass = 'catalog-page catalog-detail-page';
$activePage = 'catalogo';
$extraStyles = ['/css/catalogo-module.css?v=' . filemtime(__DIR__ . '/../../public/css/catalogo-module.css')];
$siteSettings = \App\Core\SiteSettings::all();
$whatsapp = \App\Core\SiteSettings::normalizeWhatsapp($siteSettings['whatsapp_number'] ?? '');
require __DIR__ . '/../partials/site-header.php';
?>

<?php if (!$item): ?>
  <section class="catalog-detail-shell">
    <div class="container catalog-detail-empty">
      <h1>Producto no encontrado</h1>
      <p>El modelo solicitado no esta disponible o fue desactivado del catalogo.</p>
      <a class="btn btn-primary" href="/catalogo">Volver al catalogo</a>
    </div>
  </section>
<?php else: ?>
  <section class="catalog-detail-shell">
    <div class="container catalog-detail-view">
      <a class="catalog-back-link" href="/catalogo">Volver al catalogo</a>

      <figure class="catalog-detail-media">
        <img src="<?= $e($item['image']) ?>" alt="<?= $e($item['name']) ?>" />
      </figure>

      <article class="catalog-detail-info">
        <p class="card-overline"><?= $e($item['category']) ?> · <?= $e($item['subcategory']) ?></p>
        <h1><?= $e($item['name']) ?></h1>
        <p class="catalog-detail-description"><?= $e($item['description']) ?></p>

        <div class="badges catalog-detail-badges">
          <?php foreach (($item['features'] ?? []) as $feature): ?>
            <span class="badge"><?= $e($feature) ?></span>
          <?php endforeach; ?>
        </div>

        <form class="catalog-detail-form" data-detail-form>
          <label>
            Tela / material
            <select name="material" data-detail-material>
              <?php foreach (($item['materials'] ?? ['A definir']) as $material): ?>
                <option value="<?= $e($material) ?>"><?= $e($material) ?></option>
              <?php endforeach; ?>
            </select>
          </label>

          <p class="detail-fabric-note" data-fabric-note>Elegimos la tela segun uso, estilo del ambiente y mantenimiento esperado.</p>

          <label>
            Color
            <select name="color">
              <?php foreach (($item['colors'] ?? ['A eleccion']) as $color): ?>
                <option value="<?= $e($color) ?>"><?= $e($color) ?></option>
              <?php endforeach; ?>
            </select>
          </label>

          <label>
            Medida
            <select name="size">
              <?php foreach (($item['sizes'] ?? ['Personalizada']) as $size): ?>
                <option value="<?= $e($size) ?>"><?= $e($size) ?></option>
              <?php endforeach; ?>
            </select>
          </label>

          <button class="btn btn-primary detail-budget-btn" type="button" data-budget-button>
            <i class="bi bi-whatsapp" aria-hidden="true"></i>
            Pedir presupuesto por WhatsApp
          </button>
        </form>
      </article>
    </div>
  </section>

  <script>
    window.__TAPISUR_DETAIL__ = <?= json_encode($item, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT) ?>;
    window.__TAPISUR_WHATSAPP__ = <?= json_encode($whatsapp) ?>;
  </script>
  <script src="/js/catalogo-detalle.js?v=<?= filemtime(__DIR__ . '/../../public/js/catalogo-detalle.js') ?>"></script>
<?php endif; ?>

<?php require __DIR__ . '/../partials/site-footer.php'; ?>
