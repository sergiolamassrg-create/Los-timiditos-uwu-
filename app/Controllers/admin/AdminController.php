<?php

namespace App\Controllers\admin;

use App\Core\Controller;
use App\Core\Database;
use PDO;
use PDOException;

class AdminController extends Controller
{
    public function login()
    {
        if ($this->isLoggedIn()) {
            return $this->redirect('/admin/catalogo');
        }

        $error = $_SESSION['admin_error'] ?? null;
        unset($_SESSION['admin_error']);

        return $this->view('pages/admin/adminLogin', [
            'error' => $error,
        ]);
    }

    public function authenticate()
    {
        $user = trim($_POST['username'] ?? '');
        $password = (string) ($_POST['password'] ?? '');

        if ($user === '' || $password === '') {
            return $this->backToLogin('Ingresá usuario y clave.');
        }

        $stmt = Database::connect()->prepare("
            SELECT u.*, r.label AS rol
            FROM users u
            INNER JOIN roles r ON r.id = u.role_id
            WHERE u.username = :user
              AND u.is_active = 1
              AND r.is_active = 1
            LIMIT 1
        ");
        $stmt->execute(['user' => $user]);
        $admin = $stmt->fetch();

        if (!$admin || !password_verify($password, $admin['password_hash'])) {
            return $this->backToLogin('Usuario o clave incorrectos.');
        }

        session_regenerate_id(true);
        $_SESSION['admin_user'] = [
            'id' => (int) $admin['id'],
            'name' => $admin['first_name'] . ' ' . $admin['last_name'],
            'username' => $admin['username'],
            'role' => $admin['rol'],
        ];
        unset($_SESSION['admin_error']);

        return $this->redirect('/admin/catalogo');
    }

    public function logout()
    {
        unset($_SESSION['admin_user']);
        session_regenerate_id(true);

        return $this->redirect('/admin/login');
    }

    public function dashboard()
    {
        return $this->redirect('/admin/catalogo');
    }

    public function catalog()
    {
        $this->requireAdmin();
        $message = $_SESSION['admin_message'] ?? null;
        $error = $_SESSION['admin_error'] ?? null;
        unset($_SESSION['admin_message'], $_SESSION['admin_error']);

        return $this->view('pages/admin/index', [
            'adminUser' => $_SESSION['admin_user'],
            'products' => $this->getProducts(),
            'categories' => $this->getCategories(),
            'fabrics' => $this->getFabrics(),
            'colors' => $this->getColors(),
            'fabricColors' => $this->getFabricColors(),
            'catalogOptionsReady' => $this->catalogOptionsReady(),
            'message' => $message,
            'error' => $error,
        ]);
    }

    public function createProduct()
    {
        $this->requireAdmin();
        $error = $_SESSION['admin_error'] ?? null;
        unset($_SESSION['admin_error']);

        return $this->view('pages/admin/product-form', [
            'adminUser' => $_SESSION['admin_user'],
            'categories' => $this->getCategories(),
            'product' => null,
            'formAction' => '/admin/catalogo/crear',
            'title' => 'Nuevo producto',
            'error' => $error,
        ]);
    }

    public function storeProduct()
    {
        $this->requireAdmin();

        $data = $this->productDataFromRequest();
        $error = $this->validateProductData($data);

        if ($error) {
            return $this->flashRedirect('/admin/catalogo/crear', $error, true);
        }

        try {
            $pdo = Database::connect();
            $pdo->beginTransaction();

            $stmt = $pdo->prepare("
                INSERT INTO productos (
                    id_categoria_producto, nombre, descripcion,
                    capacidad, destacado, activo
                ) VALUES (
                    :category_id, :name, :description,
                    :capacity, :featured, :active
                )
            ");
            $stmt->execute($data);
            $productId = (int) $pdo->lastInsertId();
            $this->upsertMainImage($pdo, $productId, $_POST['image_path'] ?? '', $data['name']);

            $pdo->commit();
            return $this->flashRedirect('/admin/catalogo', 'Producto creado correctamente.');
        } catch (PDOException $e) {
            if (isset($pdo) && $pdo->inTransaction()) {
                $pdo->rollBack();
            }
            error_log('Admin catalog create error: ' . $e->getMessage());
            return $this->flashRedirect('/admin/catalogo/crear', 'No se pudo crear el producto.', true);
        }
    }

    public function editProduct($id)
    {
        $this->requireAdmin();
        $product = $this->getProduct((int) $id);
        $error = $_SESSION['admin_error'] ?? null;
        unset($_SESSION['admin_error']);

        if (!$product) {
            return $this->flashRedirect('/admin/catalogo', 'Producto no encontrado.', true);
        }

        return $this->view('pages/admin/product-form', [
            'adminUser' => $_SESSION['admin_user'],
            'categories' => $this->getCategories(),
            'product' => $product,
            'formAction' => '/admin/catalogo/' . (int) $id . '/editar',
            'title' => 'Editar producto',
            'error' => $error,
        ]);
    }

    public function updateProduct($id)
    {
        $this->requireAdmin();

        $id = (int) $id;
        $data = $this->productDataFromRequest();
        $error = $this->validateProductData($data);

        if ($error) {
            return $this->flashRedirect('/admin/catalogo/' . $id . '/editar', $error, true);
        }

        try {
            $pdo = Database::connect();
            $pdo->beginTransaction();

            $data['id'] = $id;
            $stmt = $pdo->prepare("
                UPDATE productos
                SET id_categoria_producto = :category_id,
                    nombre = :name,
                    descripcion = :description,
                    capacidad = :capacity,
                    destacado = :featured,
                    activo = :active
                WHERE id_producto = :id
            ");
            $stmt->execute($data);
            $this->upsertMainImage($pdo, $id, $_POST['image_path'] ?? '', $data['name']);

            $pdo->commit();
            return $this->flashRedirect('/admin/catalogo', 'Producto actualizado correctamente.');
        } catch (PDOException $e) {
            if (isset($pdo) && $pdo->inTransaction()) {
                $pdo->rollBack();
            }
            error_log('Admin catalog update error: ' . $e->getMessage());
            return $this->flashRedirect('/admin/catalogo/' . $id . '/editar', 'No se pudo actualizar el producto.', true);
        }
    }

    public function deleteProduct($id)
    {
        $this->requireAdmin();

        $stmt = Database::connect()->prepare("UPDATE productos SET activo = 0 WHERE id_producto = :id");
        $stmt->execute(['id' => (int) $id]);

        return $this->flashRedirect('/admin/catalogo', 'Producto desactivado correctamente.');
    }

    public function storeFabric()
    {
        $this->requireAdmin();

        if (!$this->catalogOptionsReady()) {
            return $this->flashRedirect('/admin/catalogo', 'Primero importá el SQL V2 para administrar telas y colores.', true);
        }

        $data = [
            'name' => trim($_POST['name'] ?? ''),
            'description' => trim($_POST['description'] ?? ''),
            'order' => $this->nextOrder('telas'),
            'active' => isset($_POST['active']) ? 1 : 0,
        ];

        if ($data['name'] === '') {
            return $this->flashRedirect('/admin/catalogo', 'Ingresá el nombre de la tela.', true);
        }

        try {
            Database::connect()->prepare("
                INSERT INTO telas (nombre, descripcion, orden, activo)
                VALUES (:name, :description, :order, :active)
            ")->execute($data);

            return $this->flashRedirect('/admin/catalogo', 'Tela creada correctamente.');
        } catch (PDOException $e) {
            error_log('Admin fabric create error: ' . $e->getMessage());
            return $this->flashRedirect('/admin/catalogo', 'No se pudo crear la tela.', true);
        }
    }

    public function updateFabric($id)
    {
        $this->requireAdmin();

        if (!$this->catalogOptionsReady()) {
            return $this->flashRedirect('/admin/catalogo', 'Primero importá el SQL V2 para administrar telas y colores.', true);
        }

        $data = [
            'id' => (int) $id,
            'name' => trim($_POST['name'] ?? ''),
            'description' => trim($_POST['description'] ?? ''),
            'active' => isset($_POST['active']) ? 1 : 0,
        ];

        if ($data['name'] === '') {
            return $this->flashRedirect('/admin/catalogo', 'Ingresá el nombre de la tela.', true);
        }

        try {
            Database::connect()->prepare("
                UPDATE telas
                SET nombre = :name,
                    descripcion = :description,
                    activo = :active
                WHERE id_tela = :id
            ")->execute($data);

            return $this->flashRedirect('/admin/catalogo', 'Tela actualizada correctamente.');
        } catch (PDOException $e) {
            error_log('Admin fabric update error: ' . $e->getMessage());
            return $this->flashRedirect('/admin/catalogo', 'No se pudo actualizar la tela.', true);
        }
    }

    public function deleteFabric($id)
    {
        $this->requireAdmin();

        if (!$this->catalogOptionsReady()) {
            return $this->flashRedirect('/admin/catalogo', 'Primero importá el SQL V2 para administrar telas y colores.', true);
        }

        Database::connect()->prepare("UPDATE telas SET activo = 0 WHERE id_tela = :id")
            ->execute(['id' => (int) $id]);

        return $this->flashRedirect('/admin/catalogo', 'Tela desactivada correctamente.');
    }

    public function storeColor()
    {
        $this->requireAdmin();

        if (!$this->catalogOptionsReady()) {
            return $this->flashRedirect('/admin/catalogo', 'Primero importá el SQL V2 para administrar telas y colores.', true);
        }

        $data = [
            'name' => trim($_POST['name'] ?? ''),
            'hex' => isset($_POST['use_hex']) ? $this->normalizeHex($_POST['hex'] ?? '') : null,
            'order' => $this->nextOrder('colores'),
            'active' => isset($_POST['active']) ? 1 : 0,
        ];

        if ($data['name'] === '') {
            return $this->flashRedirect('/admin/catalogo', 'Ingresá el nombre del color.', true);
        }

        try {
            Database::connect()->prepare("
                INSERT INTO colores (nombre, codigo_hex, orden, activo)
                VALUES (:name, :hex, :order, :active)
            ")->execute($data);

            return $this->flashRedirect('/admin/catalogo', 'Color creado correctamente.');
        } catch (PDOException $e) {
            error_log('Admin color create error: ' . $e->getMessage());
            return $this->flashRedirect('/admin/catalogo', 'No se pudo crear el color.', true);
        }
    }

    public function updateColor($id)
    {
        $this->requireAdmin();

        if (!$this->catalogOptionsReady()) {
            return $this->flashRedirect('/admin/catalogo', 'Primero importá el SQL V2 para administrar telas y colores.', true);
        }

        $data = [
            'id' => (int) $id,
            'name' => trim($_POST['name'] ?? ''),
            'hex' => isset($_POST['use_hex']) ? $this->normalizeHex($_POST['hex'] ?? '') : null,
            'active' => isset($_POST['active']) ? 1 : 0,
        ];

        if ($data['name'] === '') {
            return $this->flashRedirect('/admin/catalogo', 'Ingresá el nombre del color.', true);
        }

        try {
            Database::connect()->prepare("
                UPDATE colores
                SET nombre = :name,
                    codigo_hex = :hex,
                    activo = :active
                WHERE id_color = :id
            ")->execute($data);

            return $this->flashRedirect('/admin/catalogo', 'Color actualizado correctamente.');
        } catch (PDOException $e) {
            error_log('Admin color update error: ' . $e->getMessage());
            return $this->flashRedirect('/admin/catalogo', 'No se pudo actualizar el color.', true);
        }
    }

    public function deleteColor($id)
    {
        $this->requireAdmin();

        if (!$this->catalogOptionsReady()) {
            return $this->flashRedirect('/admin/catalogo', 'Primero importá el SQL V2 para administrar telas y colores.', true);
        }

        Database::connect()->prepare("UPDATE colores SET activo = 0 WHERE id_color = :id")
            ->execute(['id' => (int) $id]);

        return $this->flashRedirect('/admin/catalogo', 'Color desactivado correctamente.');
    }

    public function storeFabricColor()
    {
        $this->requireAdmin();

        if (!$this->catalogOptionsReady()) {
            return $this->flashRedirect('/admin/catalogo', 'Primero importá el SQL V2 para administrar telas y colores.', true);
        }

        $data = [
            'fabric_id' => (int) ($_POST['fabric_id'] ?? 0),
            'color_id' => (int) ($_POST['color_id'] ?? 0),
            'supplier_code' => null,
            'order' => 0,
        ];

        if ($data['fabric_id'] <= 0 || $data['color_id'] <= 0) {
            return $this->flashRedirect('/admin/catalogo', 'Seleccioná tela y color para crear la combinación.', true);
        }

        try {
            Database::connect()->prepare("
                INSERT INTO tela_colores (id_tela, id_color, codigo_proveedor, orden, disponible)
                VALUES (:fabric_id, :color_id, :supplier_code, :order, 1)
            ")->execute($data);

            return $this->flashRedirect('/admin/catalogo', 'Combinación tela/color creada correctamente.');
        } catch (PDOException $e) {
            error_log('Admin fabric color create error: ' . $e->getMessage());

            if ($e->getCode() === '23000') {
                return $this->flashRedirect('/admin/catalogo', 'Esa combinación de tela y color ya está cargada.', true);
            }

            return $this->flashRedirect('/admin/catalogo', 'No se pudo crear la combinación.', true);
        }
    }

    public function deleteFabricColor($id)
    {
        $this->requireAdmin();

        if (!$this->catalogOptionsReady()) {
            return $this->flashRedirect('/admin/catalogo', 'Primero importá el SQL V2 para administrar telas y colores.', true);
        }

        Database::connect()->prepare("UPDATE tela_colores SET disponible = 0 WHERE id_tela_color = :id")
            ->execute(['id' => (int) $id]);

        return $this->flashRedirect('/admin/catalogo', 'Combinación desactivada correctamente.');
    }

    private function getProducts(): array
    {
        $stmt = Database::connect()->query("
            SELECT
                p.*,
                c.nombre AS categoria,
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
            ORDER BY p.activo DESC, p.destacado DESC, p.nombre ASC
        ");

        return $stmt->fetchAll();
    }

    private function getProduct(int $id): ?array
    {
        $stmt = Database::connect()->prepare("
            SELECT
                p.*,
                (
                    SELECT pi.ruta
                    FROM producto_imagenes pi
                    WHERE pi.id_producto = p.id_producto
                      AND pi.activo = 1
                    ORDER BY pi.principal DESC, pi.orden ASC, pi.id_imagen ASC
                    LIMIT 1
                ) AS imagen
            FROM productos p
            WHERE p.id_producto = :id
            LIMIT 1
        ");
        $stmt->execute(['id' => $id]);
        $product = $stmt->fetch();

        return $product ?: null;
    }

    private function getCategories(): array
    {
        $stmt = Database::connect()->query("
            SELECT id_categoria_producto, nombre
            FROM categorias_producto
            WHERE activo = 1
            ORDER BY nombre ASC
        ");

        return $stmt->fetchAll();
    }

    private function productDataFromRequest(): array
    {
        return [
            'category_id' => (int) ($_POST['category_id'] ?? 0),
            'name' => trim($_POST['name'] ?? ''),
            'description' => trim($_POST['description'] ?? ''),
            'capacity' => max(0, (int) ($_POST['capacity'] ?? 0)),
            'featured' => isset($_POST['featured']) ? 1 : 0,
            'active' => isset($_POST['active']) ? 1 : 0,
        ];
    }

    private function validateProductData(array $data): ?string
    {
        if ($data['category_id'] <= 0) {
            return 'Seleccioná una categoría.';
        }

        if ($data['name'] === '') {
            return 'Ingresá el nombre del producto.';
        }

        if ($data['description'] === '') {
            return 'Ingresá la descripción del producto.';
        }

        return null;
    }

    private function getFabrics(): array
    {
        if (!$this->tableExists('telas')) {
            return [];
        }

        return Database::connect()->query("
            SELECT id_tela, nombre, descripcion, orden, activo
            FROM telas
            ORDER BY activo DESC, orden ASC, nombre ASC
        ")->fetchAll();
    }

    private function getColors(): array
    {
        if (!$this->tableExists('colores')) {
            return [];
        }

        return Database::connect()->query("
            SELECT id_color, nombre, codigo_hex, orden, activo
            FROM colores
            ORDER BY activo DESC, orden ASC, nombre ASC
        ")->fetchAll();
    }

    private function getFabricColors(): array
    {
        if (!$this->catalogOptionsReady()) {
            return [];
        }

        return Database::connect()->query("
            SELECT
                tc.id_tela_color,
                tc.codigo_proveedor,
                tc.disponible,
                tc.orden,
                t.id_tela,
                t.nombre AS tela,
                c.id_color,
                c.nombre AS color,
                c.codigo_hex
            FROM tela_colores tc
            INNER JOIN telas t ON t.id_tela = tc.id_tela
            INNER JOIN colores c ON c.id_color = tc.id_color
            ORDER BY tc.disponible DESC, t.orden ASC, t.nombre ASC, tc.orden ASC, c.nombre ASC
        ")->fetchAll();
    }

    private function catalogOptionsReady(): bool
    {
        return $this->tableExists('telas')
            && $this->tableExists('colores')
            && $this->tableExists('tela_colores');
    }

    private function tableExists(string $table): bool
    {
        static $cache = [];

        if (array_key_exists($table, $cache)) {
            return $cache[$table];
        }

        try {
            $stmt = Database::connect()->prepare("
                SELECT COUNT(*)
                FROM information_schema.TABLES
                WHERE TABLE_SCHEMA = DATABASE()
                  AND TABLE_NAME = :table
            ");
            $stmt->execute(['table' => $table]);
            $cache[$table] = (int) $stmt->fetchColumn() > 0;
        } catch (PDOException $e) {
            error_log('Admin table check error: ' . $e->getMessage());
            $cache[$table] = false;
        }

        return $cache[$table];
    }

    private function normalizeHex(?string $value): ?string
    {
        $value = trim((string) $value);

        if ($value === '') {
            return null;
        }

        if ($value[0] !== '#') {
            $value = '#' . $value;
        }

        return preg_match('/^#[0-9A-Fa-f]{6}$/', $value) ? strtoupper($value) : null;
    }

    private function nextOrder(string $table): int
    {
        $allowedTables = ['telas', 'colores'];

        if (!in_array($table, $allowedTables, true)) {
            return 0;
        }

        $stmt = Database::connect()->query("SELECT COALESCE(MAX(orden), 0) + 10 FROM {$table}");

        return (int) $stmt->fetchColumn();
    }

    private function upsertMainImage(PDO $pdo, int $productId, ?string $path, string $name): void
    {
        $path = trim((string) $path);

        if ($path === '') {
            return;
        }

        $pdo->prepare("
            UPDATE producto_imagenes
            SET principal = 0
            WHERE id_producto = :product_id
        ")->execute(['product_id' => $productId]);

        $stmt = $pdo->prepare("
            SELECT id_imagen
            FROM producto_imagenes
            WHERE id_producto = :product_id
            ORDER BY id_imagen ASC
            LIMIT 1
        ");
        $stmt->execute(['product_id' => $productId]);
        $image = $stmt->fetch();

        if ($image) {
            $pdo->prepare("
                UPDATE producto_imagenes
                SET ruta = :path,
                    texto_alt = :alt,
                    principal = 1,
                    activo = 1
                WHERE id_imagen = :id
            ")->execute([
                'path' => $path,
                'alt' => $name . ' Tapisur',
                'id' => (int) $image['id_imagen'],
            ]);
            return;
        }

        $pdo->prepare("
            INSERT INTO producto_imagenes (id_producto, ruta, texto_alt, orden, principal, activo)
            VALUES (:product_id, :path, :alt, 1, 1, 1)
        ")->execute([
            'product_id' => $productId,
            'path' => $path,
            'alt' => $name . ' Tapisur',
        ]);
    }

    private function isLoggedIn(): bool
    {
        return isset($_SESSION['admin_user']['id']);
    }

    private function requireAdmin(): void
    {
        if (!$this->isLoggedIn()) {
            $this->redirect('/admin/login');
            exit;
        }
    }

    private function backToLogin(string $message)
    {
        $_SESSION['admin_error'] = $message;
        return $this->redirect('/admin/login');
    }

    private function flashRedirect(string $path, string $message, bool $isError = false)
    {
        $_SESSION[$isError ? 'admin_error' : 'admin_message'] = $message;
        return $this->redirect($path);
    }

    private function redirect(string $path)
    {
        $basePath = rtrim(str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'] ?? '')), '/');
        $basePath = $basePath === '.' ? '' : $basePath;

        header('Location: ' . $basePath . $path);
        exit;
    }
}