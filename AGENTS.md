# AGENT.md — Guía de contexto para agentes de desarrollo

## Descripción del proyecto

**Tapisur** es el sitio web y panel de administración de una fábrica de sillones y muebles tapizados ubicada en Lanús Este, Buenos Aires. El sistema permite mostrar el catálogo de productos al público, gestionar productos/telas/colores desde un panel admin, y registrar analíticas de visitas.

---

## Stack tecnológico

| Componente | Tecnología |
|-----------|-----------|
| Backend | PHP 8.2 (custom MVC, sin framework) |
| Base de datos | MariaDB 10.4 (MySQL compatible) |
| Servidor | Apache (XAMPP) |
| Frontend | HTML5, CSS3, JavaScript vanilla (ES modules) |
| CSS externo | Bootstrap 5.3.3, Bootstrap Icons 1.11.3 |
| Fonts | Google Fonts (DM Sans, Outfit) |
| Dependencias PHP | vlucas/phpdotenv ^5.6 |
| Autoload | PSR-4 (`App\` → `app/`) |

---

## Estructura del proyecto

```
/
├── index.php                    # Entry point — carga autoloader, .env, rutas, dispatch
├── .htaccess                    # Rewrite rules (assets a public/, todo lo demás a index.php)
├── .env                         # Variables de entorno (DB_HOST, DB_NAME, DB_USER, DB_PASS)
├── composer.json                # Autoload PSR-4 + dependencia phpdotenv
│
├── app/
│   ├── Core/
│   │   ├── Router.php           # Sistema de rutas (GET/POST/PUT/DELETE, grupos, middleware)
│   │   ├── Database.php         # Singleton PDO MySQL
│   │   ├── Controller.php       # Clase base: view() y json()
│   │   ├── SiteSettings.php     # Configuración dinámica desde DB (contenidos_sitio)
│   │   └── SiteAnalytics.php    # Registro de visitas + resumen diario
│   │
│   └── Controllers/
│       ├── HomeController.php
│       ├── CatalogoController.php    # Lógica de catálogo con consultas DB
│       ├── ContactoController.php
│       ├── ServiciosController.php
│       ├── NosotrosController.php
│       ├── AlianzasController.php
│       ├── EntregasController.php
│       ├── GarantiaController.php
│       ├── PrivacidadController.php
│       ├── TerminosController.php
│       ├── Api/
│       │   └── PostController.php    # API demo (JSON)
│       └── admin/
│           └── AdminController.php   # Panel admin completo (auth, CRUD, config)
│
├── routes/
│   ├── web.php                  # Rutas públicas + grupo /admin
│   └── api.php                  # Rutas API (/api/posts)
│
├── views/
│   ├── partials/
│   │   ├── site-header.php      # HTML head, nav, SEO, analytics tracking
│   │   └── site-footer.php      # Footer, WhatsApp flotante, scripts JS
│   └── pages/
│       ├── home.php, catalogo.php, servicios.php, nosotros.php, contacto.php
│       ├── alianzas.php, entregas.php, garantia.php, privacidad.php, terminos.php
│       └── admin/
│           ├── adminLogin.php
│           ├── index.php         # Panel admin (módulos por pestaña)
│           └── product-form.php  # Formulario crear/editar producto
│
├── public/
│   ├── css/
│   │   ├── styles.css           # Estilos principales del sitio público
│   │   ├── catalogo-module.css  # Estilos del módulo catálogo
│   │   └── admin.css            # Estilos del panel admin
│   ├── js/
│   │   ├── site-defaults.js     # Valores por defecto del sitio (window global)
│   │   ├── site-content.js      # Aplica contenido dinámico (localStorage + defaults)
│   │   ├── main.js              # Menú mobile, scroll, parallax, reveal animations
│   │   ├── catalog-data.js      # Catálogo estático (fallback si no hay DB)
│   │   └── catalogo-module.js   # Filtros, cards, modal, WhatsApp integration
│   ├── img/                     # Imágenes del sitio
│   └── uploads/catalogo/        # Imágenes subidas desde admin
│
├── database/
│   └── db_tapisur.sql           # Dump completo de la base de datos
│
└── documentacion/               # Documentación del proyecto
```

---

## Flujo de un request

1. Apache recibe request → `.htaccess` redirige a `index.php` (excepto archivos estáticos)
2. `index.php`: define `APP_ACCESS`, inicia sesión, carga vendor autoload + Router + .env
3. Se cargan `routes/web.php` y `routes/api.php` (registran rutas en el Router)
4. `$router->dispatch()` matchea URI → ejecuta `Controller@método`
5. El controller llama `$this->view('pages/xxx', $data)` → renderiza template PHP
6. `Controller::view()` hace rewrite de paths según base path y emite HTML

---

## Convenciones de código

### PHP
- Namespace: `App\Controllers\`, `App\Core\`
- Clases: PascalCase (`CatalogoController`, `SiteSettings`)
- Métodos: camelCase (`getCatalogItems`, `trackPageView`)
- Propiedades privadas con `$` camelCase
- Métodos privados prefijados semánticamente (`get*`, `validate*`, `normalize*`)
- Rutas en `routes/web.php` formato: `$router->get('/ruta', 'Controller@metodo')`
- Controladores admin usan patrón redirect-after-POST con flash messages en `$_SESSION`
- Consultas SQL: prepared statements con PDO (parameterized queries)
- Manejo de errores: try/catch con `error_log()`, nunca expone errores al usuario

### JavaScript
- Módulos ES (`import/export`) para catálogo
- IIFE para site-content.js (evita globals)
- Variables globales solo en `window.TAPISUR_SITE_DEFAULTS` y `window.__APP_BASE_PATH__`
- Selectores por ID para elementos principales, por clase para grupos
- Event delegation en el grid del catálogo

### Vistas
- Cada página incluye `site-header.php` al inicio y `site-footer.php` al final
- Variables disponibles: `$pageTitle`, `$pageDescription`, `$bodyClass`, `$activePage`, `$extraStyles`, `$extraScripts`
- Escapado con `htmlspecialchars($var, ENT_QUOTES, 'UTF-8')` en todo output

### CSS
- Mobile-first, responsive
- Clases BEM-like (`.home-benefit`, `.catalog-card`, `.footer-brand-block`)
- Variables CSS para colores/spacing en `styles.css`

---

## Base de datos (db_tapisur)

### Tablas principales

| Tabla | Descripción |
|-------|-------------|
| `productos` | Catálogo de productos (nombre, descripción, capacidad, destacado, activo) |
| `categorias_producto` | Categorías: Sofas, Chesterfield, Rinconeros, Sillones cama, Individuales, Baules, Respaldos |
| `producto_imagenes` | Imágenes por producto (ruta, alt, orden, principal) |
| `producto_medidas` | Medidas por producto (ancho, profundidad, alto en cm) |
| `producto_caracteristicas` | Features/tags por producto (A medida, Capitoné, etc.) |
| `telas` | Tipos de tela (Chenille, Pana, Cuerina, Bouclé) |
| `colores` | Colores disponibles con código hex |
| `tela_colores` | Combinaciones tela+color con código proveedor y disponibilidad |
| `producto_tela_colores` | Relación N:M producto ↔ combinación tela-color |
| `servicios` | Servicios ofrecidos (retapizado, reparación, restauración, fabricación) |
| `categorias_servicio` | Categorías de servicio |
| `clientes` | Registro de clientes |
| `interacciones` | Leads/consultas (canal, estado, producto/servicio asociado) |
| `ventas` + `venta_detalles` | Ventas con líneas de detalle |
| `usuarios` | Usuarios admin (bcrypt hash) |
| `roles` | Roles (administrador, vendedor) |
| `contenidos_sitio` | Key-value de configuración del sitio (CMS) |
| `visitas_sitio` | Analytics de visitas (IP, página, user_agent, geolocalización) |

### Relaciones clave
- `productos` → `categorias_producto` (FK)
- `producto_imagenes/medidas/caracteristicas` → `productos` (FK CASCADE)
- `tela_colores` → `telas` + `colores` (FK)
- `producto_tela_colores` → `productos` + `tela_colores` (FK)
- `usuarios` → `roles` (FK)
- `ventas` → `clientes` + `usuarios` (FK)

---

## Rutas registradas

### Públicas (GET)
```
/                → HomeController@index
/catalogo        → CatalogoController@index
/servicios       → ServiciosController@index
/nosotros        → NosotrosController@index
/contacto        → ContactoController@index
/alianzas        → AlianzasController@index
/entregas        → EntregasController@index
/garantia        → GarantiaController@index
/privacidad      → PrivacidadController@index
/terminos        → TerminosController@index
```

### API
```
GET  /api/posts  → Api\PostController@index
POST /api/posts  → Api\PostController@store (no implementado)
```

### Admin (prefijo /admin)
```
GET  /admin/login              → login form
POST /admin/login              → authenticate
POST /admin/logout             → logout
GET  /admin                    → dashboard
GET  /admin/dashboard          → dashboard
GET  /admin/productos          → listado productos
GET  /admin/telas              → gestión telas
GET  /admin/colores            → gestión colores
GET  /admin/combinaciones      → combinaciones tela-color
GET  /admin/usuarios           → gestión usuarios
GET  /admin/configuracion      → settings del sitio
GET  /admin/productos/crear    → form nuevo producto
POST /admin/productos/crear    → guardar producto
GET  /admin/productos/{id}/editar  → form editar
POST /admin/productos/{id}/editar  → actualizar producto
POST /admin/productos/{id}/estado  → toggle activo/inactivo
POST /admin/productos/{id}/eliminar → eliminar producto
POST /admin/telas/crear|{id}/editar|{id}/eliminar
POST /admin/colores/crear|{id}/editar|{id}/eliminar
POST /admin/tela-colores/crear|{id}/eliminar
POST /admin/usuarios/crear|{id}/editar|{id}/eliminar
POST /admin/configuracion      → guardar settings
POST /admin/perfil/clave       → cambiar clave propia
```

---

## Instrucciones para agentes

### Antes de modificar código
1. Leer el archivo completo antes de editarlo
2. Respetar el patrón MVC existente (no introducir frameworks ni dependencias nuevas sin confirmación)
3. Mantener las convenciones de naming y estilo del proyecto
4. Usar prepared statements para toda consulta SQL
5. Escapar todo output HTML con `htmlspecialchars()`

### Para crear una nueva página pública
1. Crear controller en `app/Controllers/NombreController.php` extendiendo `Controller`
2. Crear vista en `views/pages/nombre.php` (incluir header y footer partials)
3. Registrar ruta en `routes/web.php`
4. Agregar link en la navegación si corresponde (`views/partials/site-header.php`)

### Para crear un nuevo módulo admin
1. Agregar método(s) en `AdminController` o crear nuevo controller en `app/Controllers/admin/`
2. Crear vista en `views/pages/admin/`
3. Registrar ruta(s) en el grupo `/admin` de `routes/web.php`
4. Proteger con `$this->requireAdmin()` al inicio del método

### Para modificar la base de datos
1. Modificar `database/db_tapisur.sql` para reflejar los cambios
2. Si se agrega tabla, verificar que los controllers usen `tableExists()` como fallback
3. Mantener naming en español (snake_case): `nombre_tabla`, `nombre_columna`
4. Usar `activo` (tinyint) para soft-delete en lugar de DELETE real

### Para agregar JavaScript
1. Scripts globales van en `public/js/` y se cargan en `site-footer.php`
2. Scripts por página se pasan via `$extraScripts` en el controller
3. Módulos ES usan `type="module"` (ver catalogo-module.js)
4. No usar jQuery — el proyecto es vanilla JS + Bootstrap

### Comandos útiles
```bash
# Instalar dependencias PHP
composer install

# La base de datos se importa manualmente:
# Importar database/db_tapisur.sql en phpMyAdmin o CLI de MySQL

# El servidor se ejecuta via XAMPP (Apache) en http://localhost/
# Para servidor de desarrollo PHP built-in:
php -S localhost:8000 dev-router.php
```

### Variables de entorno (.env)
```
DB_HOST=localhost
DB_NAME=db_tapisur
DB_USER=root
DB_PASS=
```

---

## Restricciones y consideraciones

- **Sin ORM**: las queries son SQL directo con PDO prepared statements
- **Sin sistema de migraciones**: los cambios de schema se hacen en el dump SQL
- **Sesiones PHP nativas**: no hay JWT ni tokens API
- **Imágenes**: se suben a `public/uploads/catalogo/`, max 5MB, formatos JPG/PNG/WEBP
- **Analytics básico**: solo tracking de page views, sin cookies de terceros
- **Idioma del sitio**: español argentino (es-AR)
- **Idioma del código**: nombres de tablas/columnas en español, nombres de clases/métodos en inglés
- **Sin tests automatizados** actualmente
- **Sin build tools** (no webpack, no bundler) — los assets se sirven directamente
