<?php
$pageTitle = 'Contacto Tapisur | WhatsApp, teléfono y ubicación';
$pageDescription = 'Canales de contacto de Tapisur: WhatsApp, teléfonos, dirección, Instagram y mapa del taller.';
$bodyClass = 'page-contact contact-reference-page';
$activePage = 'contacto';
$siteSettings = \App\Core\SiteSettings::all();
$phone1 = $siteSettings['phone_1'] ?? '11 5110-3419';
$phone2 = $siteSettings['phone_2'] ?? '11 6767-5200';
$address = $siteSettings['address'] ?? 'Juan Esteban Pedernera 1462, Lanús Este, Buenos Aires';
$instagram = $siteSettings['instagram_url'] ?? 'https://www.instagram.com/tapisur_/';
$instagramLabel = '@' . trim(basename(parse_url($instagram, PHP_URL_PATH) ?: 'tapisur_'), '/');
$whatsapp = \App\Core\SiteSettings::normalizeWhatsapp($siteSettings['whatsapp_number'] ?? '+54 9 11 5110-3419');
$phone1Tel = \App\Core\SiteSettings::normalizeTel($phone1);
$phone2Tel = \App\Core\SiteSettings::normalizeTel($phone2);
require __DIR__ . '/../partials/site-header.php';
?>

    <section class="contact-reference">
      <div class="container">
        <div class="contact-reference-grid">
          <div class="contact-copy">
            <p class="kicker">Contacto</p>
            <h1>Estamos para acompañarte</h1>
            <p>Estamos disponibles para ayudarte a hacer realidad tu proyecto.</p>
            <p>Comunicate con nosotros por WhatsApp o teléfono, o coordiná una visita a nuestro taller.</p>
            <a class="contact-visit-cta wa-link" data-wa-message="Hola Tapisur, quiero coordinar una visita." target="_blank" rel="noopener noreferrer" href="https://wa.me/<?= htmlspecialchars($whatsapp, ENT_QUOTES, 'UTF-8') ?>?text=Hola%20Tapisur%2C%20quiero%20coordinar%20una%20visita.">
              <span><i class="bi bi-calendar3" aria-hidden="true"></i></span>
              <span class="contact-visit-cta-copy">
                <strong>Coordiná una visita</strong>
                <small>Conversamos tu idea y te asesoramos de forma personalizada.</small>
              </span>
              <i class="bi bi-arrow-right" aria-hidden="true"></i>
            </a>
          </div>

          <div class="contact-map">
            <iframe title="Mapa de Tapisur" loading="lazy" referrerpolicy="no-referrer-when-downgrade" src="https://www.google.com/maps?q=Juan+Esteban+Pedernera+1462,+Lan%C3%BAs+Este,+Buenos+Aires&output=embed"></iframe>
          </div>
        </div>
      </div>
    </section>

    <section class="contact-reference-bottom">
      <div class="container">
        <div class="row g-4">
          <div class="col-lg-6">
            <article class="contact-channels-panel">
              <h2>Canales disponibles</h2>
              <div class="contact-channel-row">
                <a class="contact-channel wa-link" data-wa-message="Hola Tapisur, quiero hacer una consulta." target="_blank" rel="noopener noreferrer" href="https://wa.me/<?= htmlspecialchars($whatsapp, ENT_QUOTES, 'UTF-8') ?>?text=Hola%20Tapisur%2C%20quiero%20hacer%20una%20consulta.">
                  <i class="bi bi-whatsapp" aria-hidden="true"></i>
                  <span><small>WhatsApp / Teléfono</small><strong class="phone1-text"><?= htmlspecialchars($phone1, ENT_QUOTES, 'UTF-8') ?></strong></span>
                </a>
                <a class="contact-channel" href="tel:<?= htmlspecialchars($phone2Tel, ENT_QUOTES, 'UTF-8') ?>">
                  <i class="bi bi-telephone" aria-hidden="true"></i>
                  <span><small>Teléfono</small><strong class="phone2-text"><?= htmlspecialchars($phone2, ENT_QUOTES, 'UTF-8') ?></strong></span>
                </a>
                <a class="contact-channel instagram-link" target="_blank" rel="noopener noreferrer" href="<?= htmlspecialchars($instagram, ENT_QUOTES, 'UTF-8') ?>">
                  <i class="bi bi-instagram" aria-hidden="true"></i>
                  <span><small>Instagram</small><strong><?= htmlspecialchars($instagramLabel, ENT_QUOTES, 'UTF-8') ?></strong></span>
                </a>
              </div>
              <div class="contact-phone-note">
                <i class="bi bi-headset" aria-hidden="true"></i>
                <div>
                  <strong>Atención por teléfono y WhatsApp</strong>
                  <p>Respuesta cercana para acompañar tus consultas, presupuestos y coordinaciones.</p>
                </div>
              </div>
            </article>
          </div>

          <div class="col-lg-6">
            <article class="contact-visit-panel">
              <div class="contact-visit-copy">
                <span class="contact-visit-icon"><i class="bi bi-calendar-week" aria-hidden="true"></i></span>
                <h2>Coordiná una visita con nosotros</h2>
                <p>Te esperamos en nuestro taller para conocer tu proyecto, ver materiales y encontrar juntos la mejor solución.</p>
                <ul>
                  <li><i class="bi bi-search" aria-hidden="true"></i> Asesoramiento personalizado</li>
                  <li><i class="bi bi-palette" aria-hidden="true"></i> Conocé telas, colores y terminaciones</li>
                  <li><i class="bi bi-clipboard-check" aria-hidden="true"></i> Presupuestos sin compromiso</li>
                </ul>
              </div>
              <img src="/img/home-hero-reference.png" alt="Living con sillón Tapisur" loading="lazy" />
            </article>
          </div>
        </div>
      </div>
    </section>

<?php require __DIR__ . '/../partials/site-footer.php'; ?>
