# Criterios de entrega del MVP

Proyecto: Sistema web de gestión comercial y administrativa para Tapisur  
Equipo: DataFour / Los timiditos uwu  
Fecha: 29/05/2026

## Objetivo del MVP

Entregar una primera versión funcional del sistema que permita mostrar la propuesta comercial de Tapisur, consultar productos y servicios por WhatsApp, y administrar información básica desde un panel interno.

El MVP no busca resolver toda la operación del negocio, sino entregar una base usable, clara y ampliable.

## Criterio general de aceptación

El MVP se considera terminado cuando una persona usuaria puede navegar el sitio, ver productos y servicios, consultar por WhatsApp, y un usuario administrador puede gestionar la información principal desde el panel.

## Funcionalidades obligatorias

### 1. Sitio público

Debe funcionar:

- Página principal con información de Tapisur.
- Navegación hacia catálogo, servicios y contacto.
- Visualización correcta en celular y escritorio.
- Datos de contacto visibles.
- Enlaces a WhatsApp funcionando.

### 2. Catálogo de productos

Debe funcionar:

- Listado de productos activos.
- Visualización de nombre, descripción, categoría e imagen.
- Visualización de materiales, colores o medidas sugeridas cuando existan.
- Producto destacado cuando corresponda.
- Botón de consulta por WhatsApp con mensaje contextual.

### 3. Servicios

Debe funcionar:

- Listado de servicios activos.
- Visualización de nombre, descripción, categoría e imagen opcional.
- Botón de consulta por WhatsApp.
- Diferenciación clara entre producto y servicio.

### 4. Login administrador

Debe funcionar:

- Inicio de sesión con usuario y contraseña.
- Rechazo de credenciales inválidas.
- Sesión activa para operar el panel.
- Cierre de sesión.
- Contraseña almacenada como hash en la versión backend.

### 5. ABM de productos

Debe funcionar:

- Crear producto.
- Editar producto.
- Activar o desactivar producto.
- Cargar o asociar imagen principal.
- Validar campos obligatorios.
- Mostrar en catálogo solo productos activos.

### 6. ABM de servicios

Debe funcionar:

- Crear servicio.
- Editar servicio.
- Activar o desactivar servicio.
- Cargar o asociar imagen opcional.
- Validar campos obligatorios.
- Mostrar en la web solo servicios activos.

### 7. Clientes

Debe funcionar:

- Registrar cliente con nombre y teléfono.
- Clasificar cliente como minorista, mayorista o revendedor.
- Guardar observaciones.
- Buscar cliente por nombre o teléfono.
- Evitar duplicados simples por teléfono cuando sea posible.

### 8. Ventas simples

Debe funcionar:

- Registrar venta asociada a cliente.
- Asociar venta a un producto o a un servicio mediante detalle de venta.
- Registrar fecha, vendedor, precio y observaciones.
- Visualizar historial simple de ventas.
- Mantener la regla de que cada detalle tenga producto o servicio, nunca ambos.

### 9. Base de datos

Debe estar definido o implementado:

- Modelo de datos validado.
- Tablas principales creadas.
- Relaciones principales aplicadas.
- Usuarios y roles.
- Productos y categorías.
- Servicios y categorías.
- Clientes.
- Ventas y detalles.
- Imágenes de productos y servicios.
- Contenido básico del sitio.

### 10. QA funcional

Debe estar probado:

- Navegación pública.
- Consulta por WhatsApp.
- Login administrador.
- ABM de productos.
- ABM de servicios.
- Registro de clientes.
- Registro de ventas simples.
- Visualización mobile.

## Criterios no funcionales mínimos

- El sitio debe ser responsive.
- La interfaz debe ser simple y clara.
- El sistema debe poder usarse desde celular.
- Las páginas principales deben cargar de forma liviana.
- El panel administrador debe requerir autenticación.
- El código debe estar organizado para poder continuar el desarrollo.
- El proyecto debe estar subido a GitHub.

## Entregables esperados

- Código fuente en GitHub.
- README actualizado.
- Documento de requisitos en PDF.
- Minuta de cliente.
- Criterios de entrega MVP.
- Modelo de base de datos exportado como imagen o PDF.
- Tablero Trello actualizado.
- Evidencia de pruebas o checklist QA.

## No obligatorio para el MVP

No será necesario para considerar terminado el MVP:

- Facturación electrónica.
- Carrito de compras.
- Pago online.
- Gestión avanzada de stock.
- Reportes avanzados.
- Dashboard de métricas.
- Seguimiento completo de trabajos.
- Integración técnica con Tienda Nube.

## Regla para cambios

Si aparece una tarea nueva durante el desarrollo, se carga en Trello.

Solo se actualiza el documento PDF de requisitos si el cambio modifica el alcance, una regla de negocio, una funcionalidad principal o una decisión importante del proyecto.
