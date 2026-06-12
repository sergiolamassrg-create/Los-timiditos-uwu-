# Base de datos Tapisur

## Archivo principal

El esquema instalable esta en:

```text
database/schema.sql
```

## Instalacion en MySQL

Desde la raiz del proyecto:

```bash
mysql -u root -p < database/schema.sql
```

Tambien se puede importar desde phpMyAdmin seleccionando el archivo `database/schema.sql`.

## Configuracion del proyecto

El `.env` deberia quedar asi:

```env
DB_HOST=localhost
DB_NAME=tapisur_db
DB_USER=root
DB_PASS=
```

## Usuario inicial

El SQL crea un usuario inicial para pruebas:

```text
Usuario: admin
Email: admin@tapisur.local
Rol: administrador
Clave temporal documentada en schema.sql: Cambiar123!
```

Importante: cambiar la clave al implementar login real.

## Tablas principales

- `roles`
- `permissions`
- `role_permissions`
- `users`
- `user_permissions`
- `customers`
- `product_categories`
- `products`
- `product_images`
- `attributes`
- `attribute_values`
- `product_attribute_values`
- `service_categories`
- `services`
- `service_images`
- `sales`
- `sale_items`
- `inquiries`
- `inquiry_status_history`
- `site_settings`
- `audit_logs`

## Por que esta estructura

La base esta pensada para el negocio inicial de Tapisur:

- Catalogo sin stock obligatorio.
- Productos sin precio fijo obligatorio.
- Servicios con presupuesto personalizado.
- Clientes internos sin registro publico.
- Vendedores con telefono y WhatsApp de contacto.
- Ventas simples para historial y metricas futuras.
- Consultas por WhatsApp o web como primer paso comercial.
- Contenido del sitio editable desde panel.

## Siguiente paso tecnico

1. Ajustar `.env.example` a `tapisur_db`.
2. Crear modelos PHP para `User`, `Product`, `Service`, `Customer`, `Sale` e `Inquiry`.
3. Implementar login real con `password_verify`.
4. Reemplazar el catalogo JS estatico por datos desde MySQL.
