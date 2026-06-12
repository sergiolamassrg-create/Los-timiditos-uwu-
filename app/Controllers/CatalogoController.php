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
                    p.materiales,
                    p.colores,
                    p.medidas_sugeridas,
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

            return array_map([$this, 'mapCatalogItem'], $stmt->fetchAll());
        } catch (PDOException $e) {
            error_log('Catalogo DB Error: ' . $e->getMessage());
            return [];
        }
    }

    private function mapCatalogItem(array $row): array
    {
        $materials = $this->splitList($row['materiales'] ?? '');
        $colors = $this->splitList($row['colores'] ?? '');
        $sizes = $this->splitList($row['medidas_sugeridas'] ?? '');
        $features = ['A medida'];

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
            'features' => $features,
            'materials' => $materials ?: ['A definir'],
            'colors' => $colors ?: ['A eleccion'],
            'sizes' => $sizes ?: ['Personalizada'],
            'description' => $row['descripcion'],
        ];
    }

    private function splitList(?string $value): array
    {
        if (!$value) {
            return [];
        }

        $items = preg_split('/[,;\r\n]+/', $value);

        return array_values(array_filter(array_map('trim', $items)));
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
