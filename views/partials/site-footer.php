  </main>

  <?php
    $siteSettings = \App\Core\SiteSettings::all();
    $siteName = $siteSettings['site_name'] ?? 'Tapisur';
    $phone1 = $siteSettings['phone_1'] ?? '11 5110-3419';
    $phone2 = $siteSettings['phone_2'] ?? '11 6767-5200';
    $address = $siteSettings['address'] ?? 'Juan Esteban Pedernera 1462, Lanús Este, Buenos Aires';
    $instagram = $siteSettings['instagram_url'] ?? 'https://www.instagram.com/tapisur_/';
    $whatsapp = \App\Core\SiteSettings::normalizeWhatsapp($siteSettings['whatsapp_number'] ?? '');
    $weekdayHours = $siteSettings['business_hours_weekdays'] ?? 'Lunes a Viernes 9:00 a 18:00 hs';
    $saturdayHours = $siteSettings['business_hours_saturday'] ?? 'Sábados 9:00 a 13:00 hs';
  ?>

  <footer class="site-footer site-footer-refined">
    <div class="container footer-main-panel">
      <section class="footer-brand-block" aria-label="Información de Tapisur">
        <a class="brand footer-brand" href="/" aria-label="Ir al inicio">
          <img src="/img/logo-icon.png" alt="Logo Tapisur" />
          <span><?= htmlspecialchars($siteName, ENT_QUOTES, 'UTF-8') ?></span>
        </a>
        <p>Fabricamos sillones, muebles a medida, retapizados y restauraciones con dedicación y experiencia.</p>
      </section>

      <section class="footer-contact-block" aria-label="Contacto">
        <div class="footer-item">
          <span class="footer-icon-pill"><i class="bi bi-geo-alt-fill" aria-hidden="true"></i></span>
          <span class="address-text"><?= htmlspecialchars($address, ENT_QUOTES, 'UTF-8') ?></span>
        </div>
        <div class="footer-item">
          <span class="footer-icon-pill"><i class="bi bi-telephone" aria-hidden="true"></i></span>
          <a class="phone1-link" href="tel:<?= htmlspecialchars(\App\Core\SiteSettings::normalizeTel($phone1), ENT_QUOTES, 'UTF-8') ?>"><?= htmlspecialchars($phone1, ENT_QUOTES, 'UTF-8') ?></a>
        </div>
      </section>

      <section class="footer-hours-block" aria-label="Horarios de atención">
        <div class="footer-item footer-hours-item">
          <span class="footer-icon-pill"><i class="bi bi-clock" aria-hidden="true"></i></span>
          <span><strong>Lunes a Viernes</strong><?= htmlspecialchars(str_replace('Lunes a Viernes', '', $weekdayHours), ENT_QUOTES, 'UTF-8') ?></span>
        </div>
        <div class="footer-hours-detail">
          <strong>Sábados</strong>
          <span><?= htmlspecialchars(str_replace('Sábados', '', $saturdayHours), ENT_QUOTES, 'UTF-8') ?></span>
        </div>
      </section>

      <section class="footer-social-block" aria-label="Redes y consultas">
        <a class="footer-social-link footer-social-whatsapp wa-link" data-wa-message="Hola TAPISUR, quiero hacer una consulta." target="_blank" rel="noopener noreferrer" href="https://wa.me/<?= htmlspecialchars($whatsapp, ENT_QUOTES, 'UTF-8') ?>?text=Hola%20TAPISUR%2C%20quiero%20hacer%20una%20consulta.">
          <span class="footer-social-icon"><i class="bi bi-whatsapp" aria-hidden="true"></i></span>
          <span>WhatsApp</span>
        </a>
        <a class="footer-social-link footer-social-instagram instagram-link" target="_blank" rel="noopener noreferrer" href="<?= htmlspecialchars($instagram, ENT_QUOTES, 'UTF-8') ?>">
          <span class="footer-social-icon"><i class="bi bi-instagram" aria-hidden="true"></i></span>
          <span>Instagram</span>
        </a>
      </section>
    </div>

    <div class="footer-legal footer-legal-refined">
      <div class="container footer-legal-inner">
        <p>&copy; <span id="year"></span> <?= htmlspecialchars($siteName, ENT_QUOTES, 'UTF-8') ?>. Todos los derechos reservados.</p>
        <nav class="footer-legal-links" aria-label="Enlaces legales">
          <a href="#">Política de privacidad</a>
          <a href="/entregas">Entregas</a>
          <a href="#">Términos y condiciones</a>
        </nav>
      </div>
    </div>
  </footer>
  <footer class="footer-mobile-minimal" aria-label="Pie de página mobile">
    <div class="footer-mobile-inner">
      <p class="footer-mobile-location"><i class="bi bi-geo-alt" aria-hidden="true"></i><span>Lanús Este</span></p>
      <div class="footer-mobile-actions" aria-label="Canales de contacto">
        <a class="footer-mobile-action footer-mobile-whatsapp wa-link" data-wa-message="Hola TAPISUR, quiero hacer una consulta." target="_blank" rel="noopener noreferrer" href="https://wa.me/<?= htmlspecialchars($whatsapp, ENT_QUOTES, 'UTF-8') ?>?text=Hola%20TAPISUR%2C%20quiero%20hacer%20una%20consulta." aria-label="Contactar por WhatsApp">
          <i class="bi bi-whatsapp" aria-hidden="true"></i>
          <span>WhatsApp</span>
        </a>
        <a class="footer-mobile-action footer-mobile-instagram instagram-link" target="_blank" rel="noopener noreferrer" href="<?= htmlspecialchars($instagram, ENT_QUOTES, 'UTF-8') ?>" aria-label="Abrir Instagram de Tapisur">
          <i class="bi bi-instagram" aria-hidden="true"></i>
          <span>Instagram</span>
        </a>
      </div>
      <div class="footer-mobile-rule" aria-hidden="true"></div>
      <p class="footer-mobile-copy">&copy; <span id="year-mobile"></span> <?= htmlspecialchars($siteName, ENT_QUOTES, 'UTF-8') ?></p>
      <nav class="footer-mobile-legal" aria-label="Enlaces legales mobile">
        <a href="#">Políticas</a>
        <span aria-hidden="true">·</span>
        <a href="#">Términos</a>
        <span aria-hidden="true">·</span>
        <a href="/entregas">Entregas</a>
      </nav>
    </div>
  </footer>

  <button class="scroll-top-btn" type="button" aria-label="Subir al inicio">
    <i class="bi bi-arrow-up" aria-hidden="true"></i>
  </button>

  <script src="/js/site-defaults.js"></script>
  <script>
    window.TAPISUR_SITE_DEFAULTS = {
      ...(window.TAPISUR_SITE_DEFAULTS || {}),
      site_name: <?= json_encode($siteName) ?>,
      phone_1: <?= json_encode($phone1) ?>,
      phone_2: <?= json_encode($phone2) ?>,
      address: <?= json_encode($address) ?>,
      instagram_url: <?= json_encode($instagram) ?>,
      whatsapp_number: <?= json_encode($whatsapp) ?>
    };
  </script>
  <script src="/js/site-content.js"></script>
  <script src="/js/main.js"></script>
  <?php if (!empty($inlineScripts)): ?>
    <?php foreach ($inlineScripts as $script): ?>
      <script><?= $script ?></script>
    <?php endforeach; ?>
  <?php endif; ?>
  <?php if (!empty($extraScripts)): ?>
    <?php foreach ($extraScripts as $script): ?>
      <?php if (is_array($script)): ?>
        <?php
          $scriptSrc = htmlspecialchars($script['src'] ?? '', ENT_QUOTES, 'UTF-8');
          $scriptType = !empty($script['type']) ? ' type="' . htmlspecialchars($script['type'], ENT_QUOTES, 'UTF-8') . '"' : '';
        ?>
        <script src="<?= $scriptSrc ?>"<?= $scriptType ?>></script>
      <?php else: ?>
        <script src="<?= htmlspecialchars($script, ENT_QUOTES, 'UTF-8') ?>"></script>
      <?php endif; ?>
    <?php endforeach; ?>
  <?php endif; ?>
</body>
</html>




