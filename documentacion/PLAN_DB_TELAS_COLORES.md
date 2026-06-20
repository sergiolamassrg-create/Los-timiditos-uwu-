# Plan DB V2 - Telas, colores y catalogo

Fecha: 2026-06-14

## Archivo SQL generado

`database/schema_v2_telas_colores.sql`

Este SQL crea la base `db_tapisur` desde cero con datos de prueba.

Fue validado importandolo en una base temporal `db_tapisur_v2_test`.

Datos de prueba validados:

- `10` productos
- `4` telas
- `10` colores
- `12` combinaciones tela-color disponibles
- `37` relaciones producto/tela/color

## Cambio conceptual

Antes, cada producto tenia texto libre:

- `productos.materiales`
- `productos.colores`
- `productos.medidas_sugeridas`

Eso obliga a editar producto por producto cuando cambia una tela o color.

Ahora, el modelo propone:

- `telas`: catalogo central de telas.
- `colores`: catalogo central de colores.
- `tela_colores`: colores disponibles para cada tela.
- `producto_tela_colores`: que combinaciones tela/color puede usar cada producto.
- `producto_medidas`: medidas sugeridas por producto.
- `producto_caracteristicas`: caracteristicas por producto.

## Flujo esperado

1. El administrador carga telas.
2. El administrador carga colores.
3. El administrador define que colores existen para cada tela.
4. Al editar un producto, solo selecciona combinaciones disponibles de tela/color.
5. Si una tela o color cambia, se ajusta en un solo lugar.

## Impacto en catalogo publico

`CatalogoController` debe dejar de leer:

```sql
p.materiales,
p.colores,
p.medidas_sugeridas
```

Y pasar a consultar relaciones:

```sql
productos
producto_tela_colores
tela_colores
telas
colores
producto_medidas
producto_caracteristicas
producto_imagenes
categorias_producto
```

El JSON final para el frontend puede mantenerse parecido:

```js
{
  materials: ["Chenille", "Pana"],
  colors: ["Beige", "Gris claro"],
  sizes: ["2.10 x 0.85 m", "Personalizada"],
  features: ["A medida", "Estructura reforzada"]
}
```

Pero esos arrays salen desde tablas normalizadas, no desde texto libre.

## Impacto en admin

El ABM actual de productos todavia tiene inputs de texto:

- Materiales
- Colores
- Medidas sugeridas

Con la DB V2 deberia cambiar a:

- Checkboxes/select multiple de combinaciones tela-color.
- ABM simple de telas.
- ABM simple de colores.
- ABM o selector para asociar colores a telas.
- Medidas como filas repetibles o un textarea temporal si queremos migrar por etapas.

## Propuesta de implementacion por etapas

### Etapa 1

- Importar SQL V2 en ambiente de prueba.
- Ajustar `CatalogoController` para leer relaciones nuevas.
- Mantener frontend del catalogo igual.

### Etapa 2

- Ajustar admin de productos para mostrar combinaciones tela/color.
- Guardar relaciones en `producto_tela_colores`.

### Etapa 3

- Crear ABM de telas y colores.
- Crear pantalla para administrar `tela_colores`.

### Etapa 4

- Quitar definitivamente del codigo cualquier dependencia de `productos.materiales`, `productos.colores` y `productos.medidas_sugeridas`.

