<?php
$pageTitle = 'Tapisur | Sillones a medida';
$pageDescription = 'Tapisur fabrica sillones, muebles a medida, retapizados y restauraciones con atención personalizada.';
$bodyClass = 'home-page home-reference';
$activePage = 'inicio';
require __DIR__ . '/../partials/site-header.php';
?>

    <section class="hero home-hero" id="inicio">
      <div class="hero-bg" role="img" aria-label="Sillon Tapisur en living"></div>
      <div class="container hero-content">
        <p class="kicker">Muebles a medida, tapicería y restauraciones</p>
        <h1>Fabricamos sillones y muebles a medida para</h1>
        <p>Más de 20 años creando muebles personalizados, retapizados y restauraciones con materiales de primera calidad y atención cercana.</p>
        <div class="hero-cta">
          <a class="btn btn-primary btn-arrow" href="/catalogo">
            <span>Ver catálogo</span>
            <span class="btn-arrow-icon" aria-hidden="true"></span>
          </a>
        </div>
      </div>
    </section>

    <section class="home-benefits" aria-label="Diferenciales de Tapisur">
      <div class="container home-benefits-grid">
        <article class="home-benefit">
          <img class="home-icon" src="/img/home-icons/benefit-quality.png" alt="" aria-hidden="true" />
          <div>
            <h3>Calidad garantizada</h3>
            <p>Materiales de primera calidad y mano de obra especializada.</p>
          </div>
        </article>
        <article class="home-benefit">
          <img class="home-icon" src="/img/home-icons/benefit-measure.png" alt="" aria-hidden="true" />
          <div>
            <h3>Hecho a medida</h3>
            <p>Diseñamos y fabricamos según tus necesidades.</p>
          </div>
        </article>
        <article class="home-benefit">
          <img class="home-icon" src="/img/home-icons/benefit-fabric.png" alt="" aria-hidden="true" />
          <div>
            <h3>Variedad de telas</h3>
            <p>Amplia gama de telas y cuerinas en colores y texturas.</p>
          </div>
        </article>
        <article class="home-benefit">
          <img class="home-icon" src="/img/home-icons/benefit-delivery.png" alt="" aria-hidden="true" />
          <div>
            <h3>Entrega coordinada</h3>
            <p>Cumplimos con los tiempos acordados.</p>
          </div>
        </article>
        <article class="home-benefit">
          <img class="home-icon" src="/img/home-icons/benefit-care.png" alt="" aria-hidden="true" />
          <div>
            <h3>Atención personalizada</h3>
            <p>Te asesoramos en cada paso de tu proyecto.</p>
          </div>
        </article>
      </div>
    </section>

    <section class="home-process" aria-label="Así trabajamos">
      <div class="container home-process-panel">
        <h2>Así trabajamos</h2>
        <div class="home-process-grid">
          <article>
            <img class="home-process-icon" src="/img/home-icons/process-idea.png" alt="" aria-hidden="true" />
            <span>1</span>
            <h3>Nos contás tu idea</h3>
            <p>Escuchamos lo que necesitás y te asesoramos.</p>
          </article>
          <article>
            <img class="home-process-icon" src="/img/home-icons/process-define.png" alt="" aria-hidden="true" />
            <span>2</span>
            <h3>Definimos todo</h3>
            <p>Tomamos medidas, elegimos telas y detalles.</p>
          </article>
          <article>
            <img class="home-process-icon" src="/img/home-icons/process-build.png" alt="" aria-hidden="true" />
            <span>3</span>
            <h3>Fabricamos</h3>
            <p>Con dedicación y materiales de primera calidad.</p>
          </article>
          <article>
            <img class="home-process-icon" src="/img/home-icons/process-deliver.png" alt="" aria-hidden="true" />
            <span>4</span>
            <h3>Entregamos</h3>
            <p>Coordinamos la entrega hasta tu hogar.</p>
          </article>
        </div>
      </div>
    </section>

    <section class="home-works" aria-label="Trabajos realizados">
      <div class="container home-works-grid">
        <div class="home-works-copy">
          <h2>Trabajos que hablan por nosotros</h2>
          <p>Cada proyecto es único. Conocé algunos de nuestros trabajos realizados.</p>
        </div>
        <figure><img src="/img/home-reference/work-1.png" alt="Sillón claro realizado por Tapisur" loading="lazy" /></figure>
        <figure><img src="/img/home-reference/work-2.png" alt="Sillón chesterfield verde" loading="lazy" /></figure>
        <figure><img src="/img/home-reference/work-3.png" alt="Rinconero Tapisur" loading="lazy" /></figure>
        <figure><img src="/img/home-reference/work-4.png" alt="Respaldo capitone Tapisur" loading="lazy" /></figure>
        <figure><img src="/img/home-reference/work-5.png" alt="Sillón individual Tapisur" loading="lazy" /></figure>
      </div>
    </section>

    <section class="home-contact-strip">
      <div class="container home-contact-panel">
        <img class="home-contact-icon" src="/img/home-icons/contact-sofa.svg" alt="" aria-hidden="true" />
        <div>
          <h2>Contactanos</h2>
          <p>Contanos tu idea y te ayudamos a encontrar la mejor solución para tu hogar o negocio.</p>
        </div>
        <a class="btn btn-primary btn-whatsapp wa-link" data-wa-message="Hola TAPISUR, quiero hacer una consulta." target="_blank" rel="noopener noreferrer" href="https://wa.me/5491151103419?text=Hola%20TAPISUR%2C%20quiero%20hacer%20una%20consulta.">
          <span class="btn-whatsapp-icon" aria-hidden="true"></span>
          <span>WhatsApp</span>
        </a>
      </div>
    </section>

<?php require __DIR__ . '/../partials/site-footer.php'; ?>
