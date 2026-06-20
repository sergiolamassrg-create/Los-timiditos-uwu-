<?php
$pageTitle = 'Contacto TAPISUR | WhatsApp, telefono y ubicacion';
$pageDescription = 'Canales de contacto de TAPISUR: WhatsApp, telefonos, direccion y mapa.';
$bodyClass = 'page-contact';
$activePage = 'contacto';
require __DIR__ . '/../partials/site-header.php';
?>


    <section class="page-hero">
      <div class="container page-hero-grid">
        <div class="page-hero-copy reveal">
          <p class="kicker">Contacto</p>
          <h1>Estamos para acompa&ntilde;arte</h1>
          <p>Buscamos que cada consulta tenga una respuesta clara. Podes comunicarte para cotizaciones, servicios, entregas, alianzas o seguimiento.</p>
          <div class="hero-cta">
            <a class="btn btn-primary wa-link" data-wa-message="Hola TAPISUR, quiero hacer una consulta." target="_blank" rel="noopener noreferrer" href="#">Escribir por WhatsApp</a>
            <a class="btn btn-secondary" data-phone-link="1" href="tel:+541151103419">Llamar ahora</a>
          </div>
        </div>
        <div class="map page-hero-map reveal">
          <iframe title="Mapa de TAPISUR" loading="lazy" referrerpolicy="no-referrer-when-downgrade" src="https://www.google.com/maps?q=Juan+Esteban+Pedernera+1462,+Lan%C3%BAs+Este,+Buenos+Aires&output=embed"></iframe>
        </div>
      </div>
    </section>

    <section class="section">
      <div class="container contact-grid">
        <div class="info-card reveal">
          <h3>Canales disponibles</h3>
          <ul class="contact-list">
            <li><strong>Telefono 1:</strong> <a class="phone1-link" href="tel:+541151103419">11 5110-3419</a></li>
            <li><strong>Telefono 2:</strong> <a class="phone2-link" href="tel:+541167675200">11 6767-5200</a></li>
            <li><strong>Direccion:</strong> <span class="address-text">Juan Esteban Pedernera 1462, Lanus Este, Buenos Aires</span></li>
            <li><strong>Instagram:</strong> <a class="instagram-link" target="_blank" rel="noopener noreferrer" href="https://www.instagram.com/tapisur_/">@tapisur_</a></li>
          </ul>
          <p>Atencion por telefono y WhatsApp, con respuesta permanente para acompanar consultas y coordinaciones.</p>
        </div>
        <div class="map reveal">
          <iframe title="Mapa de TAPISUR" loading="lazy" referrerpolicy="no-referrer-when-downgrade" src="https://www.google.com/maps?q=Juan+Esteban+Pedernera+1462,+Lan%C3%BAs+Este,+Buenos+Aires&output=embed"></iframe>
        </div>
      </div>
    </section>

<?php require __DIR__ . '/../partials/site-footer.php'; ?>
