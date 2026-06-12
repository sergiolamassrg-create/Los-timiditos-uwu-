# Sistema web de gestión comercial y administrativa para Tapisur

Proyecto universitario desarrollado por el equipo **DataFour / Los timiditos uwu** para la materia **Práctica Profesionalizante II**.

## Objetivo

Desarrollar un sistema web simple para acompañar la gestión comercial y administrativa de Tapisur, un emprendimiento dedicado a la fabricación de sillones, muebles a medida, tapicería, retapizados y restauraciones.

El sistema busca ordenar la información del negocio, mostrar productos y servicios, facilitar consultas por WhatsApp y brindar un panel administrador para gestionar contenido, clientes y ventas simples.

## Cliente

Tapisur es un emprendimiento familiar con trayectoria en fabricación de sillones y trabajos de tapicería. Su operatoria se basa principalmente en pedidos personalizados y comunicación directa por WhatsApp.

## Equipo

| Integrante | Rol |
|---|---|
| Lamas Sergio | Product Owner |
| Celeste Moioli | Scrum Master |
| Sebastian Pryjmak | Product Manager |
| Rodrigo D'Arena | Desarrollador Frontend |
| Sebastian Colaiacovo | Desarrollador Frontend |
| Gonzalo Erceg | Desarrollador Backend |
| Julio Jeremy Castañeda Samaniego | QA |

## Alcance inicial del MVP

- Sitio web institucional.
- Catálogo público de productos.
- Sección de servicios.
- Consulta por WhatsApp desde productos y servicios.
- Login de administrador.
- ABM de productos.
- ABM de servicios.
- Administración básica de contenido.
- Registro interno de clientes.
- Clasificación de clientes minoristas, mayoristas y revendedores.
- Registro simple de ventas.

## Fuera del alcance inicial

- Carrito de compras.
- Checkout online.
- Pasarela de pagos.
- Facturación electrónica.
- Gestión avanzada de stock.
- Logística avanzada.
- Integración técnica directa con Tienda Nube.

## Tecnologías previstas

- Frontend: HTML, CSS y JavaScript.
- Backend: PHP.
- Base de datos: MySQL.
- Dependencias PHP: Composer.
- Gestión de tareas: Trello.
- Control de versiones: GitHub.

## Repositorio y tablero

- GitHub: https://github.com/sergiolamassrg-create/Los-timiditos-uwu-
- Trello: https://trello.com/b/UaVeKqwR/los-timiditos-uwu%F0%9F%91%89%F0%9F%8F%BB%F0%9F%91%88%F0%9F%8F%BB

## Cómo ejecutar el proyecto

Estado actual: en preparación / desarrollo inicial.

El proyecto está preparado para correr en un entorno compatible con PHP.

### Opción con servidor PHP local

Desde la raíz del proyecto:

```bash
composer install
php -S localhost:8000 dev-router.php
```

Luego abrir:

```text
http://localhost:8000
```

### Opción con XAMPP o Laragon

1. Copiar el proyecto dentro de la carpeta del servidor local.
2. Configurar el host local o acceder desde la ruta correspondiente.
3. Crear la base de datos MySQL cuando el script SQL definitivo esté disponible.
4. Configurar credenciales en `.env`.
5. Abrir el sitio desde el navegador.

## Documentación

La documentación administrativa y funcional se encuentra en:

- `documentacion/`
- `database/`

Documentos principales:

- Documento de especificación de requisitos de software.
- Minuta de relevamiento y validación con cliente.
- Criterios de entrega del MVP.
- Backlog inicial para Trello.
- Modelo inicial de base de datos.

## Estado del proyecto

El proyecto cuenta con alcance MVP definido, documentación base, tablero Trello y modelo inicial de base de datos en proceso de validación.
