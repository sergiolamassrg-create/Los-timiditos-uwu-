# Base de datos Tapisur

## Archivo oficial

La base oficial del proyecto esta en:

```text
database/db_tapisur.sql
```

Este archivo es la referencia unica para adaptar el codigo PHP. Si se recrea la base, importar este SQL y mantener el `.env` apuntando a esa misma base.

## Instalacion en MySQL/XAMPP

Desde la raiz del proyecto:

```bash
mysql -u root db_tapisur < database/db_tapisur.sql
```

Tambien se puede importar desde phpMyAdmin creando primero la base `db_tapisur` y seleccionando `database/db_tapisur.sql`.

## Configuracion del proyecto

El `.env` local esperado es:

```env
DB_HOST=localhost
DB_NAME=db_tapisur
DB_USER=root
DB_PASS=
```

## Usuario inicial

El SQL crea un usuario inicial para pruebas:

```text
Usuario: admin
Clave: Admin123!
Rol: administrador
```

Cambiar esta clave antes de publicar el sistema.

## Tablas principales actuales

- `roles`
- `usuarios`
- `clientes`
- `categorias_producto`
- `productos`
- `producto_imagenes`
- `producto_medidas`
- `producto_caracteristicas`
- `telas`
- `colores`
- `tela_colores`
- `producto_tela_colores`
- `categorias_servicio`
- `servicios`
- `servicio_imagenes`
- `ventas`
- `venta_detalles`
- `interacciones`
- `contenidos_sitio`

## Criterio actual

- El catalogo publico lee productos desde `productos`, categorias desde `categorias_producto` e imagen principal desde `producto_imagenes`.
- El ABM de productos no carga telas ni colores por producto.
- Telas, colores y combinaciones se administran como opciones globales desde `telas`, `colores` y `tela_colores`.
- `producto_tela_colores` queda disponible en el schema para una etapa futura si se decide limitar variantes por producto.
- El login admin usa `usuarios` y `roles` con `password_verify`.