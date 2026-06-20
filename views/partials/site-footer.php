  </main>

  <a class="whatsapp-float wa-link" data-wa-message="Hola TAPISUR, quiero hacer una consulta." target="_blank" rel="noopener noreferrer" href="https://wa.me/5491151103419?text=Hola%20TAPISUR%2C%20quiero%20hacer%20una%20consulta." aria-label="Abrir WhatsApp">
    <span class="wa__btn_popup_icon" aria-hidden="true"></span>
    <span class="sr-only">WhatsApp</span>
  </a>

  <footer class="site-footer">
    <div class="container footer-grid">
      <div>
        <a class="brand footer-brand" href="/" aria-label="Ir al inicio">
          <img src="/img/logo-icon.png" alt="Logo Tapisur" />
          <span>Tapisur</span>
        </a>
        <p>Fabricamos sillones, muebles a medida, retapizados y restauraciones con dedicación y experiencia.</p>
      </div>
      <div>
        <h3>Navegación</h3>
        <ul class="footer-list">
          <li><a href="/">Inicio</a></li>
          <li><a href="/catalogo">Catálogo</a></li>
          <li><a href="/servicios">Servicios</a></li>
          <li><a href="/nosotros">Nosotros</a></li>
          <li><a href="/contacto">Contacto</a></li>
        </ul>
      </div>
      <div>
        <h3>Contacto</h3>
        <ul class="footer-list">
          <li><span class="footer-icon footer-icon-location" aria-hidden="true"></span><span class="address-text">Juan Esteban Pedernera 1462, Lanús Este, Buenos Aires</span></li>
          <li><span class="footer-icon footer-icon-truck" aria-hidden="true"></span><span>Entregas en todo el país</span></li>
          <li><span class="footer-icon footer-icon-whatsapp" aria-hidden="true"></span><a class="phone1-link" href="tel:+541151103419">11 5110-3419</a></li>
          <li><span class="footer-icon footer-icon-instagram" aria-hidden="true"></span><a class="instagram-link" target="_blank" rel="noopener noreferrer" href="https://www.instagram.com/tapisur_/">Instagram @tapisur_</a></li>
        </ul>
      </div>
      <div>
        <h3>Horarios de atención</h3>
        <ul class="footer-list">
          <li><span class="footer-icon footer-icon-clock" aria-hidden="true"></span><span>Lunes a Viernes<br>9:00 a 18:00 hs</span></li>
          <li><span class="footer-icon footer-icon-clock" aria-hidden="true"></span><span>Sábados<br>9:00 a 13:00 hs</span></li>
        </ul>
      </div>
    </div>
    <div class="footer-legal">
      <div class="container footer-legal-inner">
        <p>&copy; <span id="year"></span> Tapisur. Todos los derechos reservados.</p>
        <nav class="footer-legal-links" aria-label="Enlaces legales">
          <a href="#">Política de privacidad</a>
          <a href="/garantia">Garantías</a>
          <a href="/entregas">Entregas</a>
          <a href="/contacto">Presupuestos</a>
          <a href="#">Términos y condiciones</a>
        </nav>
      </div>
    </div>
  </footer>

  <script src="/js/site-defaults.js"></script>
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
