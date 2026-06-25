<?php
$pageTitle = 'Entregas y fletes | Tapisur';
$pageDescription = 'Información sobre entregas, retiros, fletes y transportes para trabajos de Tapisur en Lanús, GBA, CABA e interior del país.';
$bodyClass = 'page-shell page-entregas legal-info-page';
$activePage = 'entregas';
require __DIR__ . '/../partials/site-header.php';
?>

    <section class="section legal-hero delivery-hero">
      <div class="container">
        <div class="row align-items-center g-4">
          <div class="col-lg-8">
            <p class="kicker">Entregas y coordinación</p>
            <h1>Coordinamos cada entrega según el trabajo y la zona</h1>
            <p class="legal-lead">Tapisur trabaja desde Lanús con pedidos a medida, retapizados, reparaciones y restauraciones. La entrega o retiro se define antes de confirmar el trabajo, para que el cliente sepa cómo se mueve el producto y qué costo puede tener.</p>
          </div>
          <div class="col-lg-4">
            <div class="delivery-highlight">
              <i class="bi bi-geo-alt" aria-hidden="true"></i>
              <strong>Lanús, GBA y CABA</strong>
              <span>También se puede coordinar al interior mediante transportista.</span>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section class="section-sm">
      <div class="container delivery-flow">
        <div class="delivery-step">
          <span>1</span>
          <div>
            <h2>Definimos el trabajo</h2>
            <p>Se confirma si es fabricación nueva, mueble a medida, retapizado, reparación o restauración.</p>
          </div>
        </div>
        <div class="delivery-step">
          <span>2</span>
          <div>
            <h2>Revisamos la zona</h2>
            <p>Se evalúa si corresponde entrega propia, flete sugerido, retiro por el cliente o transporte externo.</p>
          </div>
        </div>
        <div class="delivery-step">
          <span>3</span>
          <div>
            <h2>Coordinamos fecha</h2>
            <p>La fecha y franja horaria se acuerdan por WhatsApp o teléfono según agenda del taller.</p>
          </div>
        </div>
      </div>
    </section>

    <section class="section-sm">
      <div class="container delivery-options">
        <div>
          <p class="kicker">Modalidades</p>
          <h2>El cliente puede elegir cómo resolver el traslado</h2>
          <p>La idea es que la logística sea flexible. Según el caso, el cliente puede tomar el flete ofrecido por Tapisur, pasar a retirar el producto terminado, o traer el mueble que necesita reparar, retapizar o restaurar.</p>
        </div>
        <ul class="delivery-list">
          <li><i class="bi bi-truck" aria-hidden="true"></i><span><strong>Flete ofrecido por Tapisur</strong> para Lanús, GBA y CABA, con costo informado antes de confirmar.</span></li>
          <li><i class="bi bi-box-arrow-in-down" aria-hidden="true"></i><span><strong>Retiro o entrega por cuenta del cliente</strong> cuando prefiere pasar por el taller o enviar su propio flete.</span></li>
          <li><i class="bi bi-tools" aria-hidden="true"></i><span><strong>Ingreso de muebles a reparar</strong> para trabajos de refacción, restauración o retapizado coordinados previamente.</span></li>
          <li><i class="bi bi-signpost" aria-hidden="true"></i><span><strong>Interior del país</strong> mediante transportista elegido o coordinado por el cliente. Tapisur no se hace cargo del transporte externo.</span></li>
        </ul>
      </div>
    </section>

    <section class="section-sm">
      <div class="container delivery-note">
        <i class="bi bi-info-circle" aria-hidden="true"></i>
        <div>
          <h2>Información importante</h2>
          <p>Para evitar problemas, el cliente debe avisar medidas del acceso, piso, ascensor, escaleras, restricciones del edificio y cualquier dato que pueda afectar el ingreso o retiro del producto.</p>
        </div>
        <a class="btn btn-primary wa-link" data-wa-message="Hola Tapisur, quiero consultar por una entrega o retiro." target="_blank" rel="noopener noreferrer" href="#">Consultar por WhatsApp</a>
      </div>
    </section>

<?php require __DIR__ . '/../partials/site-footer.php'; ?>
