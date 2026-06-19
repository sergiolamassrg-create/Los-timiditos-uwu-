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
                    id_categoria_producto, nombre, descripcion, materiales, colores,
                    medidas_sugeridas, capacidad, destacado, activo
                ) VALUES (
                    :category_id, :name, :description, :materials, :colors,
                    :sizes, :capacity, :featured, :active
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
                    materiales = :materials,
                    colores = :colors,
                    medidas_sugeridas = :sizes,
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
            'materials' => trim($_POST['materials'] ?? ''),
            'colors' => trim($_POST['colors'] ?? ''),
            'sizes' => trim($_POST['sizes'] ?? ''),
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