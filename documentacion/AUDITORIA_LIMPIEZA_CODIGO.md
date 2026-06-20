# Auditoria de limpieza de codigo y archivos

Fecha: 2026-06-14  
Repo analizado: `C:\xampp\htdocs\Los-timiditos-uwu-`

## Objetivo

Identificar archivos, rutas y codigo que aparentan no usarse actualmente para revisar antes de eliminar.  
No se borro nada durante esta auditoria.

## Estado actual confirmado

- Las paginas publicas ya usan `views/partials/site-header.php` y `views/partials/site-footer.php`.
- Las rutas publicas principales responden con 1 header y 1 footer comunes:
  - `/`
  - `/catalogo`
  - `/servicios`
  - `/nosotros`
  - `/contacto`
  - `/entregas`
  - `/garantia`
  - `/alianzas`
- El admin mantiene layout propio y no entra en el header/footer publico.

## Candidatos claros para borrar luego de aprobacion

### 1. Carpeta `old/`

Motivo: contiene la version HTML estatica anterior y assets duplicados. El sitio actual ya trabaja con PHP, controladores, vistas en `views/pages`, assets en `public/` y parciales comunes.

Contenido detectado:

- HTML legacy:
  - `old/index.html`
  - `old/catalogo.html`
  - `old/servicios.html`
  - `old/nosotros.html`
  - `old/contacto.html`
  - `old/entregas.html`
  - `old/garantia.html`
  - `old/alianzas.html`
  - `old/panel-tapisur-admin.html`
- Assets legacy:
  - `old/assets/css/*`
  - `old/assets/js/*`
  - `old/assets/img/*`

Peso aproximado: `1.43 MB` en `43` archivos.

Recomendacion: borrar carpeta completa cuando confirmemos que no se necesita como backup historico. Si se quiere conservar por referencia, mover fuera del repo o dejarlo documentado como archivo historico.

### 2. Carpeta `tmp-screens/`

Motivo: contiene capturas generadas durante pruebas visuales. No son necesarias para ejecutar el proyecto.

Peso aproximado: `19.82 MB` en `33` archivos.

Recomendacion: borrar cuando ya no se necesiten para comparar avances visuales. Tambien conviene agregar `tmp-screens/` al `.gitignore` para que no vuelva a ensuciar el repo.

### 3. Rutas y archivos de ejemplo

Motivo: parecen scaffold/pruebas de desarrollo y no forman parte del MVP Tapisur.

Rutas detectadas en `routes/web.php`:

```php
$router->get('/example',"ExampleController@index");
$router->get('/example/{id}','ExampleController@exampleID');
$router->get('/example/{id}/{TwoID}','ExampleController@exampleIDTWO');
```

Archivos asociados:

- `app/Controllers/ExampleController.php`
- `views/pages/example.php`
- `views/pages/exampleID.php`
- `views/pages/exampleIDTWO.php`
- `public/js/example.js`

Riesgo: bajo si nadie usa esas rutas.  
Recomendacion: eliminar rutas, controlador, vistas y JS de ejemplo despues de aprobacion.

### 4. `public/js/admin-panel.js`

Motivo: no aparece referenciado por las vistas admin actuales. Parece provenir del panel estatico viejo.

Evidencia:

- Las vistas admin actuales cargan solo `/css/admin.css`.
- No se encontro referencia activa a `/js/admin-panel.js`.

Recomendacion: borrar si confirmamos que el admin actual es el PHP/MySQL y no el panel anterior con localStorage.

### 5. `public/img/home-icons/contact-sofa.png`

Motivo: el inicio actual usa `public/img/home-icons/contact-sofa.svg`.

Uso actual:

```html
<img class="home-contact-icon" src="/img/home-icons/contact-sofa.svg" ...>
```

Recomendacion: borrar el PNG si damos por aprobado el SVG nuevo.

### 6. Imagenes/logo no referenciados directamente

Archivos sin referencia exacta activa detectada:

- `public/img/logo.jpg`
- `public/img/logo-icon.jpg`
- `public/img/whatsapp.svg`

Uso actual confirmado:

- Header/footer usan `public/img/logo-icon.png`.
- WhatsApp visual usa `public/img/whatsapp-icon-white.svg`.

Recomendacion: revisar antes de borrar. Pueden ser archivos fuente, backups o variantes utiles. Si no tienen uso real, se pueden eliminar.

## Candidatos a revisar antes de borrar o corregir

### 1. API de posts de ejemplo

Archivo:

- `routes/api.php`
- `app/Controllers/Api/PostController.php`

Rutas:

```php
$router->get('/api/posts', 'Api\PostController@index');
$router->post('/api/posts', 'Api\PostController@store');
```

Observacion:

- `PostController` tiene `index()`.
- No se encontro metodo `store()`, aunque la ruta POST existe.
- Parece API de ejemplo y no parte del MVP actual.

Opciones:

- Eliminar `routes/api.php` del bootstrap si no se usa ninguna API.
- Eliminar solo `/api/posts` y `PostController`.
- O completar `store()` si realmente se planea usar esa API.

Recomendacion: tratar como candidato a limpieza, pero confirmar primero si el equipo quiere dejar una API base para futuro.

### 2. `Nuevo diseño Front/`

Motivo: contiene las imagenes de referencia del nuevo diseno.

Archivos:

- `Inicio.png`
- `Catalogo.png`
- `Servicios.png`
- `Nosotros.png`
- `Contacto.png`
- `Logo.jpg`

Peso aproximado: `9.06 MB`.

Recomendacion: no borrar por ahora. Todavia sirve como referencia visual para seguir ajustando modulos. Cuando el rediseño quede aprobado, se puede mover a documentacion historica o fuera del repo.

### 3. `public/js/catalog-data.js`

Motivo: aunque el catalogo usa datos de MySQL cuando existen, `catalogo-module.js` importa `catalog-data.js` como fallback.

Uso:

```js
import { CATALOG } from './catalog-data.js';
```

Recomendacion: no borrar todavia. Solo eliminar si confirmamos que el catalogo siempre dependera de base de datos y no necesita fallback local.

### 4. Imagenes de `public/img/catalogo/`

Motivo: algunas referencias pueden venir desde base de datos, no solo desde busqueda textual en PHP/JS.

Recomendacion: no borrar por busqueda automatica. Revisar contra tabla `producto_imagenes` o contra seed/data real antes de tocar.

## No borrar aunque parezca "no codigo"

Estos elementos no son candidatos por ahora:

- `documentacion/`: memoria funcional y criterios del proyecto.
- `database/schema.sql`: estructura de base de datos y soporte para reproducir ambiente.
- `database/README.md`: guia tecnica de base.
- `composer.json` y `composer.lock`: dependencias PHP.
- `vendor/`: necesario si no se ejecuta `composer install` en cada ambiente. Se puede ignorar en repo si se define flujo Composer, pero no borrar sin acordarlo.
- `.env.example`: plantilla de configuracion.
- `.htaccess`: necesario para Apache/XAMPP.
- `dev-router.php`: util para servidor local PHP.

## Propuesta de limpieza por etapas

### Etapa 1: Limpieza segura visual/legacy

1. Borrar `tmp-screens/`.
2. Agregar `tmp-screens/` a `.gitignore`.
3. Borrar `old/` completo si no se quiere conservar backup historico.

### Etapa 2: Limpieza de scaffold

1. Eliminar rutas `/example`.
2. Eliminar `ExampleController`.
3. Eliminar vistas `example*.php`.
4. Eliminar `public/js/example.js`.

### Etapa 3: Limpieza de JS/assets no usados

1. Eliminar `public/js/admin-panel.js` si se confirma que no se usa el panel viejo.
2. Eliminar `public/img/home-icons/contact-sofa.png` si se aprueba el SVG.
3. Revisar y decidir sobre `logo.jpg`, `logo-icon.jpg` y `whatsapp.svg`.

### Etapa 4: API de ejemplo

1. Decidir si `/api/posts` queda como base futura o se borra.
2. Si se borra, remover `routes/api.php` o al menos las rutas `api/posts`.
3. Eliminar `app/Controllers/Api/PostController.php` si no queda ninguna API.

## Checklist antes de borrar

- Correr `rg` para confirmar que el archivo/ruta no tenga referencias activas.
- Probar rutas publicas principales.
- Probar `/admin/login` y `/admin/catalogo` si se tocan archivos admin.
- Mantener un commit o backup antes de borrar carpetas completas.

