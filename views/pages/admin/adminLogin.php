<!doctype html>
<html lang="es-AR">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="theme-color" content="#f6f4ef" />
  <title>Login Admin TAPISUR</title>
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;700&family=Outfit:wght@500;600;700&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="/css/admin.css" />
</head>
<body>
  <main class="admin-shell admin-shell--narrow">
    <section class="admin-card">
      <p class="eyebrow">Acceso privado</p>
      <h1>Panel Admin TAPISUR</h1>
      <p class="muted">Ingresá con el usuario administrador para gestionar el catálogo conectado a MySQL.</p>

      <?php if (!empty($error)): ?>
        <p class="alert alert-error"><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></p>
      <?php endif; ?>

      <form class="form-grid" method="post" action="/admin/login">
        <label for="username">Usuario</label>
        <input id="username" name="username" type="text" autocomplete="username" required autofocus />

        <label for="password">Clave</label>
        <input id="password" name="password" type="password" autocomplete="current-password" required />

        <button type="submit">Ingresar</button>
      </form>
    </section>
  </main>
</body>
</html>
