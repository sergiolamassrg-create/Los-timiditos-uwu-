<?php
$e = fn($value) => htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
$lockedUntil = (int) ($lockedUntil ?? 0);
$isLocked = $lockedUntil > time();
$minutesLeft = $isLocked ? max(1, (int) ceil(($lockedUntil - time()) / 60)) : 0;
$remainingAttempts = (int) ($remainingAttempts ?? 3);
?>
<!doctype html>
<html lang="es-AR">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  
  <link rel="icon" href="/img/favicon-admin.svg" type="image/svg+xml" />
  <link rel="alternate icon" href="/img/logo-icon.png" type="image/png" />
  <title>Admin | Tapisur</title>
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;700&family=Outfit:wght@500;600;700&display=swap" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="/css/admin.css?v=<?= filemtime(__DIR__ . '/../../../public/css/admin.css') ?>" />
</head>
<body class="login-body">
  <main class="login-screen">
    <section class="login-brand-panel" aria-label="Presentación Tapisur">
      <div class="login-brand-overlay"></div>
      <div class="login-brand-content">
        <div class="login-monogram">
          <img src="/img/logo-icon.png" alt="Logo Tapisur" />
        </div>
        <p class="login-brand-name">Tapisur</p>
        <span class="login-divider"></span>
        <p class="login-brand-copy">Calidad y diseño<br>que transforman</p>
      </div>
      <div class="login-brand-features">
        <div><i class="bi bi-box-seam"></i><strong>Catálogo</strong><span>Gestioná productos</span></div>
        <div><i class="bi bi-tags"></i><strong>Servicios</strong><span>Administrá contenido</span></div>
        <div><i class="bi bi-graph-up-arrow"></i><strong>Estadísticas</strong><span>Analizá ingresos</span></div>
      </div>
    </section>

    <section class="login-form-panel">
      <div class="login-card">
        <div class="login-card-head">
          <span class="login-lock"><i class="bi bi-lock"></i></span>
          <p>Acceso privado</p>
        </div>
        <h1>Panel Admin <strong>Tapisur</strong></h1>
        <p class="login-subtitle">Ingresá para administrar catálogo, contenidos y configuración del sitio.</p>

        <?php if (!empty($error)): ?>
          <div class="alert <?= $isLocked ? 'alert-warning' : 'alert-danger' ?> login-alert" role="alert">
            <i class="bi <?= $isLocked ? 'bi-shield-lock' : 'bi-exclamation-circle' ?>"></i>
            <span><?= $e($error) ?></span>
          </div>
        <?php endif; ?>

        <?php if ($isLocked): ?>
          <p class="login-wait">Podrás volver a intentar en aproximadamente <?= $minutesLeft ?> minuto<?= $minutesLeft === 1 ? '' : 's' ?>.</p>
        <?php elseif ($remainingAttempts < 3): ?>
          <p class="login-attempts">Intentos disponibles: <?= $remainingAttempts ?> de 3.</p>
        <?php endif; ?>

        <form class="login-form" method="post" action="/admin/login">
          <div>
            <label class="form-label" for="username">Usuario</label>
            <div class="login-input-group">
              <span><i class="bi bi-person"></i></span>
              <input id="username" name="username" type="text" autocomplete="username" placeholder="Ingresá tu usuario" required autofocus <?= $isLocked ? 'disabled' : '' ?> />
            </div>
          </div>

          <div>
            <label class="form-label" for="password">Clave</label>
            <div class="login-input-group">
              <span><i class="bi bi-lock"></i></span>
              <input id="password" name="password" type="password" autocomplete="current-password" placeholder="Ingresá tu clave" required <?= $isLocked ? 'disabled' : '' ?> />
              <button class="login-eye" type="button" data-toggle-password aria-label="Mostrar u ocultar clave" <?= $isLocked ? 'disabled' : '' ?>><i class="bi bi-eye"></i></button>
            </div>
          </div>

          <div class="login-options">
            <label><input type="checkbox" name="remember" value="1" <?= $isLocked ? 'disabled' : '' ?> /> Recordarme</label>
            <span>¿Olvidaste tu clave?</span>
          </div>

          <button class="btn btn-primary login-submit" type="submit" <?= $isLocked ? 'disabled' : '' ?>>
            <i class="bi bi-box-arrow-in-right"></i> Ingresar
          </button>
        </form>
      </div>
      <p class="login-footnote"><i class="bi bi-shield-check"></i> Acceso exclusivo para administradores</p>
    </section>
  </main>

  <script>
    document.querySelector('[data-toggle-password]')?.addEventListener('click', function () {
      const input = document.getElementById('password');
      if (!input) return;
      const visible = input.type === 'text';
      input.type = visible ? 'password' : 'text';
      this.innerHTML = visible ? '<i class="bi bi-eye"></i>' : '<i class="bi bi-eye-slash"></i>';
    });
  </script>
</body>
</html>
