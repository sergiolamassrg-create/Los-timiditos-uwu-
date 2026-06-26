<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Database;
use PDOException;

/**
 * CatalogoController
 *
 * Controlador de la página pública "Catálogo".
 * Consulta la base de datos para obtener los productos activos
 * con sus categorías, imágenes, medidas, características y
 * opciones de telas/colores. Entrega los datos al frontend
 * para renderizado dinámico con filtros.
 *
 * Ruta asociada: GET /catalogo
 */
class CatalogoController extends Controller
{
    /**
     * Renderiza la vista del catálogo con los productos desde la DB.
     *
     * Pasa al template un array `catalogItems` con la estructura
     * que espera el módulo JS `catalogo-module.js` para renderizar
     * las cards y aplicar filtros del lado del cliente.
     *
     * @return void Emite el HTML de la página al navegador.
     */
    public function index()
    {
        return $this->view('pages/catalogo', [
            'title' => 'Catalogo TAPISUR',
            'catalogItems' => $this->getCatalogItems(),
        ]);
    }

    public function show($id)
    {
        $productId = (int) $id;
        $item = null;

        foreach ($this->getCatalogItems() as $catalogItem) {
            if ((int) ($catalogItem['productId'] ?? 0) === $productId) {
                $item = $catalogItem;
                break;
            }
        }

        if (!$item) {
            http_response_code(404);
            return $this->view('pages/catalogo-detalle', [
                'item' => null,
            ]);
        }

        return $this->view('pages/catalogo-detalle', [
            'item' => $item,
        ]);
    }

    /**
     * Obtiene todos los productos activos formateados para el catálogo.
     *
     * Consulta la tabla `productos` con JOIN a `categorias_producto`
     * y subquery para la imagen principal. Luego obtiene las opciones
     * globales (telas, colores, medidas, características) y mapea
     * cada producto a la estructura esperada por el frontend.
     *
     * @return array Lista de productos formateados. Array vacío si hay error DB.
     */
    private function getCatalogItems(): array
    {
        try {
            $pdo = Database::connect();
            $stmt = $pdo->query("
                SELECT
                    p.id_producto,
                    p.nombre,
                    p.descripcion,
                    p.capacidad,
                    p.destacado,
                    c.nombre AS categoria,
                    c.descripcion AS categoria_descripcion,
                    (
                        SELECT pi.ruta
                        FROM producto_imagenes pi
                        WHERE pi.id_producto = p.id_producto
                          AND pi.activo = 1
                        ORDER BY pi.principal DESC, pi.orden ASC, pi.id_imagen ASC
                        LIMIT 1
                    ) AS imagen
                FROM productos p
                INNER JOIN categorias_producto c
                    ON c.id_categoria_producto = p.id_categoria_producto
                WHERE p.activo = 1
                  AND c.activo = 1
                ORDER BY p.destacado DESC, p.nombre ASC
            ");

            $options = $this->getGlobalCatalogOptions($pdo);

            return array_map(fn ($row) => $this->mapCatalogItem($row, $options), $stmt->fetchAll());
        } catch (PDOException $e) {
            error_log('Catalogo DB Error: ' . $e->getMessage());
            return [];
        }
    }

    /**
     * Transforma un row de la DB en la estructura esperada por el frontend.
     *
     * Estructura resultante por item:
     *  - id: string ('producto-{id}')
     *  - name, category, subcategory, image, description: strings
     *  - seats: int (capacidad de asientos)
     *  - featured: bool
     *  - features: array de strings (características + 'Destacado' si aplica)
     *  - materials: array de strings (nombres de telas disponibles)
     *  - colors: array de strings (nombres de colores disponibles)
     *  - sizes: array de strings (descripciones de medidas)
     *
     * @param array $row     Fila de la consulta SQL con datos del producto.
     * @param array $options Opciones globales (materials, colors, sizesByProduct, featuresByProduct).
     *
     * @return array Producto formateado para consumo del frontend.
     */
    private function mapCatalogItem(array $row, array $options): array
    {
        $features = $options['featuresByProduct'][(int) $row['id_producto']] ?? ['A medida'];
        $sizes = $options['sizesByProduct'][(int) $row['id_producto']] ?? ['Personalizada'];

        if ((int) $row['destacado'] === 1) {
            $features[] = 'Destacado';
        }

        return [
            'id' => 'producto-' . (int) $row['id_producto'],
            'productId' => (int) $row['id_producto'],
            'name' => $row['nombre'],
            'category' => $row['categoria'],
            'subcategory' => $row['categoria_descripcion'] ?: 'Catalogo TAPISUR',
            'image' => $this->normalizeImagePath($row['imagen'] ?? ''),
            'seats' => (int) $row['capacidad'],
            'featured' => (int) $row['destacado'] === 1,
            'features' => array_values(array_unique($features)),
            'materials' => $options['materials'] ?: ['A definir'],
            'colors' => $options['colors'] ?: ['A elección'],
            'sizes' => $sizes,
            'description' => $row['descripcion'],
        ];
    }

    /**
     * Obtiene las opciones globales del catálogo desde la DB.
     *
     * Consulta:
     *  - Telas activas y disponibles → lista de materiales
     *  - Colores activos y disponibles → lista de colores
     *  - Medidas por producto → mapa id_producto => [descripciones]
     *  - Características por producto → mapa id_producto => [nombres]
     *
     * Cada consulta verifica que la tabla exista antes de ejecutarse
     * (soporte para bases de datos parciales durante desarrollo).
     *
     * @param \PDO $pdo Instancia de conexión PDO activa.
     *
     * @return array Estructura con claves: materials, colors, sizesByProduct, featuresByProduct.
     */
    private function getGlobalCatalogOptions($pdo): array
    {
        $options = [
            'materials' => [],
            'colors' => [],
            'sizesByProduct' => [],
            'featuresByProduct' => [],
        ];

        if ($this->tableExists($pdo, 'telas') && $this->tableExists($pdo, 'tela_colores') && $this->tableExists($pdo, 'colores')) {
            $materials = $pdo->query("
                SELECT DISTINCT t.nombre
                FROM tela_colores tc
                INNER JOIN telas t ON t.id_tela = tc.id_tela
                INNER JOIN colores c ON c.id_color = tc.id_color
                WHERE tc.disponible = 1
                  AND t.activo = 1
                  AND c.activo = 1
                ORDER BY t.orden ASC, t.nombre ASC
            ")->fetchAll();

            $colors = $pdo->query("
                SELECT DISTINCT c.nombre
                FROM tela_colores tc
                INNER JOIN telas t ON t.id_tela = tc.id_tela
                INNER JOIN colores c ON c.id_color = tc.id_color
                WHERE tc.disponible = 1
                  AND t.activo = 1
                  AND c.activo = 1
                ORDER BY c.orden ASC, c.nombre ASC
            ")->fetchAll();

            $options['materials'] = array_column($materials, 'nombre');
            $options['colors'] = array_column($colors, 'nombre');
        }

        if ($this->tableExists($pdo, 'producto_medidas')) {
            $rows = $pdo->query("
                SELECT id_producto, descripcion
                FROM producto_medidas
                WHERE activo = 1
                ORDER BY id_producto ASC, orden ASC, id_medida ASC
            ")->fetchAll();

            foreach ($rows as $row) {
                $options['sizesByProduct'][(int) $row['id_producto']][] = $row['descripcion'];
            }
        }

        if ($this->tableExists($pdo, 'producto_caracteristicas')) {
            $rows = $pdo->query("
                SELECT id_producto, nombre
                FROM producto_caracteristicas
                WHERE activo = 1
                ORDER BY id_producto ASC, orden ASC, id_caracteristica ASC
            ")->fetchAll();

            foreach ($rows as $row) {
                $options['featuresByProduct'][(int) $row['id_producto']][] = $row['nombre'];
            }
        }

        return $options;
    }

    /**
     * Verifica si una tabla existe en la base de datos actual.
     *
     * Cachea el resultado en memoria estática para evitar consultas
     * repetidas durante el mismo request.
     *
     * @param \PDO   $pdo   Instancia de conexión.
     * @param string $table Nombre de la tabla a verificar.
     *
     * @return bool True si la tabla existe.
     */
    private function tableExists($pdo, string $table): bool
    {
        static $cache = [];

        if (array_key_exists($table, $cache)) {
            return $cache[$table];
        }

        $stmt = $pdo->prepare("
            SELECT COUNT(*)
            FROM information_schema.TABLES
            WHERE TABLE_SCHEMA = DATABASE()
              AND TABLE_NAME = :table
        ");
        $stmt->execute(['table' => $table]);
        $cache[$table] = (int) $stmt->fetchColumn() > 0;

        return $cache[$table];
    }

    /**
     * Normaliza la ruta de una imagen de producto.
     *
     * Reglas:
     *  - Si está vacía: retorna imagen por defecto del catálogo.
     *  - Reemplaza backslashes por forward slashes.
     *  - Remueve el prefijo 'public/' si está presente.
     *  - Asegura que comience con '/'.
     *
     * @param string|null $path Ruta almacenada en la DB.
     *
     * @return string Ruta normalizada relativa a la carpeta public.
     */
    private function normalizeImagePath(?string $path): string
    {
        $path = trim((string) $path);

        if ($path === '') {
            return '/img/catalogo/page02_img01.jpeg';
        }

        $path = str_replace('\\', '/', $path);

        if (str_starts_with($path, 'public/')) {
            $path = substr($path, strlen('public'));
        }

        return str_starts_with($path, '/') ? $path : '/' . $path;
    }
}
