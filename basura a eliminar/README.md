# Basura a eliminar

Carpeta de cuarentena creada antes de borrar archivos definitivamente.

Fecha: 2026-06-14

## Movido a `legacy/`

- `old/`

Motivo: HTML y assets estaticos viejos reemplazados por vistas PHP, controladores y assets en `public/`.

## Movido a `capturas/`

- `tmp-screens/`

Motivo: capturas temporales de pruebas visuales.

## Movido a `scaffold-example/`

- `app/Controllers/ExampleController.php`
- `views/pages/example.php`
- `views/pages/exampleID.php`
- `views/pages/exampleIDTWO.php`
- `public/js/example.js`

Motivo: rutas y vistas de ejemplo que no forman parte del MVP Tapisur.

Nota: todavia quedan rutas `/example` declaradas en `routes/web.php`. Antes de borrar definitivamente esta carpeta, conviene eliminar esas rutas del archivo.

## Movido a `assets-sin-uso/`

- `public/js/admin-panel.js`
- `public/img/home-icons/contact-sofa.png`

Motivo: `admin-panel.js` corresponde al panel estatico viejo; el icono PNG fue reemplazado por `contact-sofa.svg`.

## Movido a `revisar/`

- `public/img/logo.jpg`
- `public/img/logo-icon.jpg`
- `public/img/whatsapp.svg`

Motivo: no se encontraron referencias activas exactas. Se dejaron en revision porque pueden servir como fuentes o variantes.

