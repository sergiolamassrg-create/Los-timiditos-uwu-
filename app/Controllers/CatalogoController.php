<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Database;
use PDOException;

class CatalogoController extends Controller
{
    public function index()
    {
        return $this->view('pages/catalogo', [
            'title' => 'Catalogo TAPISUR',
            'catalogItems' => $this->getCatalogItems(),
        ]);
    }

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

    private function mapCatalogItem(array $row, array $options): array
    {
        $features = $options['featuresByProduct'][(int) $row['id_producto']] ?? ['A medida'];
        $sizes = $options['sizesByProduct'][(int) $row['id_producto']] ?? ['Personalizada'];

        if ((int) $row['destacado'] === 1) {
            $features[] = 'Destacado';
        }

        return [
            'id' => 'producto-' . (int) $row['id_producto'],
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
