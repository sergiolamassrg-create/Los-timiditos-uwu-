<?php

namespace App\Controllers\admin;

use App\Core\Controller;
use App\Core\Database;
use App\Core\SiteAnalytics;
use App\Core\SiteSettings;
use PDO;
use PDOException;

class AdminController extends Controller
{
    public function login()
    {
        if ($this->isLoggedIn()) {
            return $this->redirect('/admin/productos');
        }

        $error = $_SESSION['admin_error'] ?? null;
        unset($_SESSION['admin_error']);

        return $this->view('pages/admin/adminLogin', [
            'error' => $error,
            'lockedUntil' => $_SESSION['admin_login_locked_until'] ?? null,
            'remainingAttempts' => $this->remainingLoginAttempts(),
        ]);
    }

    public function authenticate()
    {
        $user = trim($_POST['username'] ?? '');
        $password = (string) ($_POST['password'] ?? '');

        if ($this->isLoginLocked()) {
            return $this->backToLogin('Por seguridad, esperá 15 minutos antes de volver a intentar.');
        }

        if ($user === '' || $password === '') {
            return $this->backToLogin('Completá usuario y clave para ingresar.');
        }

        $stmt = Database::connect()->prepare("
            SELECT u.*, r.nombre AS rol
            FROM usuarios u
            INNER JOIN roles r ON r.id_rol = u.id_rol
            WHERE u.usuario = :user
              AND u.activo = 1
              AND r.activo = 1
            LIMIT 1
        ");
        $stmt->execute(['user' => $user]);
        $admin = $stmt->fetch();

        if (!$admin || !password_verify($password, $admin['password_hash'])) {
            $remaining = $this->registerFailedLogin();

            if ($remaining <= 0) {
                return $this->backToLogin('Superaste los 3 intentos permitidos. Por seguridad, esperá 15 minutos para volver a ingresar.');
            }

            return $this->backToLogin('Los datos ingresados no son correctos. Te quedan ' . $remaining . ' intento' . ($remaining === 1 ? '' : 's') . '.');
        }

        session_regenerate_id(true);
        $_SESSION['admin_user'] = [
            'id' => (int) $admin['id_usuario'],
            'name' => $admin['nombre'],
            'username' => $admin['usuario'],
            'role' => $admin['rol'],
        ];
        $this->clearLoginAttempts();
        unset($_SESSION['admin_error']);

        return $this->redirect('/admin/productos');
    }


    private function isLoginLocked(): bool
    {
        $lockedUntil = (int) ($_SESSION['admin_login_locked_until'] ?? 0);

        if ($lockedUntil <= 0) {
            return false;
        }

        if ($lockedUntil <= time()) {
            $this->clearLoginAttempts();
            return false;
        }

        return true;
    }

    private function registerFailedLogin(): int
    {
        $attempts = (int) ($_SESSION['admin_login_attempts'] ?? 0) + 1;
        $_SESSION['admin_login_attempts'] = $attempts;

        if ($attempts >= 3) {
            $_SESSION['admin_login_locked_until'] = time() + (15 * 60);
            return 0;
        }

        return max(0, 3 - $attempts);
    }

    private function remainingLoginAttempts(): int
    {
        if ($this->isLoginLocked()) {
            return 0;
        }

        return max(0, 3 - (int) ($_SESSION['admin_login_attempts'] ?? 0));
    }

    private function clearLoginAttempts(): void
    {
        unset($_SESSION['admin_login_attempts'], $_SESSION['admin_login_locked_until']);
    }

    public function logout()
    {
        unset($_SESSION['admin_user']);
        session_regenerate_id(true);

        return $this->redirect('/admin/login');
    }

    public function dashboard()
    {
        return $this->adminModule('dashboard');
    }

    public function catalog()
    {
        return $this->redirect('/admin/productos');
    }

    public function products()
    {
        return $this->adminModule('productos');
    }

    public function fabrics()
    {
        return $this->adminModule('telas');
    }

    public function colors()
    {
        return $this->adminModule('colores');
    }

    public function combinations()
    {
        return $this->adminModule('combinaciones');
    }

    public function users()
    {
        return $this->adminModule('usuarios');
    }

    public function settings()
    {
        return $this->adminModule('configuracion');
    }

    private function adminModule(string $activeModule)
    {
        $this->requireAdmin();
        $message = $_SESSION['admin_message'] ?? null;
        $error = $_SESSION['admin_error'] ?? null;
        unset($_SESSION['admin_message'], $_SESSION['admin_error']);

        return $this->view('pages/admin/index', [
            'adminUser' => $_SESSION['admin_user'],
            'activeModule' => $activeModule,
            'stats' => $this->getDashboardStats(),
            'analytics' => SiteAnalytics::todaySummary(),
            'products' => $this->getProducts(trim($_GET['q'] ?? '')),
            'productSearch' => trim($_GET['q'] ?? ''),
            'categories' => $this->getCategories(),
            'fabrics' => $this->getFabrics(),
            'colors' => $this->getColors(),
            'fabricColors' => $this->getFabricColors(),
            'users' => $this->getUsers(),
            'roles' => $this->getRoles(),
            'settings' => $this->getSettings(),
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
            'formAction' => '/admin/productos/crear',
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
            return $this->flashRedirect('/admin/productos/crear', $error, true);
        }

        $imageError = $this->productImageUploadError();
        if ($imageError) {
            return $this->flashRedirect('/admin/productos/crear', $imageError, true);
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
            $imagePath = $this->saveProductImageUpload($productId) ?? trim($_POST['image_path'] ?? '');
            $this->upsertMainImage($pdo, $productId, $imagePath, $data['name']);

            $pdo->commit();
            return $this->flashRedirect('/admin/productos', 'Producto creado correctamente.');
        } catch (\Throwable $e) {
            if (isset($pdo) && $pdo->inTransaction()) {
                $pdo->rollBack();
            }
            error_log('Admin product create error: ' . $e->getMessage());
            return $this->flashRedirect('/admin/productos/crear', 'No se pudo crear el producto.', true);
        }
    }

    public function editProduct($id)
    {
        $this->requireAdmin();
        $product = $this->getProduct((int) $id);
        $error = $_SESSION['admin_error'] ?? null;
        unset($_SESSION['admin_error']);

        if (!$product) {
            return $this->flashRedirect('/admin/productos', 'Producto no encontrado.', true);
        }

        return $this->view('pages/admin/product-form', [
            'adminUser' => $_SESSION['admin_user'],
            'categories' => $this->getCategories(),
            'product' => $product,
            'formAction' => '/admin/productos/' . (int) $id . '/editar',
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
            return $this->flashRedirect('/admin/productos/' . $id . '/editar', $error, true);
        }

        $imageError = $this->productImageUploadError();
        if ($imageError) {
            return $this->flashRedirect('/admin/productos/' . $id . '/editar', $imageError, true);
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
            $imagePath = $this->saveProductImageUpload($id) ?? trim($_POST['image_path'] ?? '');
            $this->upsertMainImage($pdo, $id, $imagePath, $data['name']);

            $pdo->commit();
            return $this->flashRedirect('/admin/productos', 'Producto actualizado correctamente.');
        } catch (\Throwable $e) {
            if (isset($pdo) && $pdo->inTransaction()) {
                $pdo->rollBack();
            }
            error_log('Admin product update error: ' . $e->getMessage());
            return $this->flashRedirect('/admin/productos/' . $id . '/editar', 'No se pudo actualizar el producto.', true);
        }
    }

    public function toggleProductStatus($id)
    {
        $this->requireAdmin();

        $id = (int) $id;
        $active = isset($_POST['active']) ? 1 : 0;

        $stmt = Database::connect()->prepare("UPDATE productos SET activo = :active WHERE id_producto = :id");
        $stmt->execute(['active' => $active, 'id' => $id]);

        $message = $active ? 'Producto activado correctamente.' : 'Producto desactivado correctamente.';
        return $this->flashRedirect($this->productsRedirectUrl(), $message);
    }

    public function deleteProduct($id)
    {
        $this->requireAdmin();

        $id = (int) $id;

        try {
            $pdo = Database::connect();
            $pdo->beginTransaction();

            $stmt = $pdo->prepare("DELETE FROM productos WHERE id_producto = :id");
            $stmt->execute(['id' => $id]);

            $pdo->commit();
            return $this->flashRedirect($this->productsRedirectUrl(), 'Producto eliminado correctamente.');
        } catch (PDOException $e) {
            if (isset($pdo) && $pdo->inTransaction()) {
                $pdo->rollBack();
            }
            error_log('Admin product delete error: ' . $e->getMessage());
            return $this->flashRedirect($this->productsRedirectUrl(), 'No se pudo eliminar el producto.', true);
        }
    }

    private function productsRedirectUrl(): string
    {
        $search = trim($_POST['q'] ?? $_GET['q'] ?? '');

        if ($search === '') {
            return '/admin/productos';
        }

        return '/admin/productos?q=' . rawurlencode($search);
    }
    public function storeFabric()
    {
        $this->requireAdmin();

        if (!$this->catalogOptionsReady()) {
            return $this->flashRedirect('/admin/telas', 'La base actual no tiene las tablas de telas y colores de schema.sql.', true);
        }

        $data = [
            'name' => trim($_POST['name'] ?? ''),
            'description' => trim($_POST['description'] ?? ''),
            'order' => $this->nextOrder('telas'),
            'active' => isset($_POST['active']) ? 1 : 0,
        ];

        if ($data['name'] === '') {
            return $this->flashRedirect('/admin/telas', 'Ingresá el nombre de la tela.', true);
        }

        try {
            Database::connect()->prepare("
                INSERT INTO telas (nombre, descripcion, orden, activo)
                VALUES (:name, :description, :order, :active)
            ")->execute($data);

            return $this->flashRedirect('/admin/telas', 'Tela creada correctamente.');
        } catch (PDOException $e) {
            error_log('Admin fabric create error: ' . $e->getMessage());
            return $this->flashRedirect('/admin/telas', 'No se pudo crear la tela.', true);
        }
    }

    public function updateFabric($id)
    {
        $this->requireAdmin();

        if (!$this->catalogOptionsReady()) {
            return $this->flashRedirect('/admin/telas', 'La base actual no tiene las tablas de telas y colores de schema.sql.', true);
        }

        $data = [
            'id' => (int) $id,
            'name' => trim($_POST['name'] ?? ''),
            'description' => trim($_POST['description'] ?? ''),
            'active' => isset($_POST['active']) ? 1 : 0,
        ];

        if ($data['name'] === '') {
            return $this->flashRedirect('/admin/telas', 'Ingresá el nombre de la tela.', true);
        }

        try {
            Database::connect()->prepare("
                UPDATE telas
                SET nombre = :name,
                    descripcion = :description,
                    activo = :active
                WHERE id_tela = :id
            ")->execute($data);

            return $this->flashRedirect('/admin/telas', 'Tela actualizada correctamente.');
        } catch (PDOException $e) {
            error_log('Admin fabric update error: ' . $e->getMessage());
            return $this->flashRedirect('/admin/telas', 'No se pudo actualizar la tela.', true);
        }
    }

    public function deleteFabric($id)
    {
        $this->requireAdmin();

        if (!$this->catalogOptionsReady()) {
            return $this->flashRedirect('/admin/telas', 'La base actual no tiene las tablas de telas y colores de schema.sql.', true);
        }

        Database::connect()->prepare("UPDATE telas SET activo = 0 WHERE id_tela = :id")
            ->execute(['id' => (int) $id]);

        return $this->flashRedirect('/admin/telas', 'Tela desactivada correctamente.');
    }

    public function storeColor()
    {
        $this->requireAdmin();

        if (!$this->catalogOptionsReady()) {
            return $this->flashRedirect('/admin/telas', 'La base actual no tiene las tablas de telas y colores de schema.sql.', true);
        }

        $data = [
            'name' => trim($_POST['name'] ?? ''),
            'hex' => isset($_POST['use_hex']) ? $this->normalizeHex($_POST['hex'] ?? '') : null,
            'order' => $this->nextOrder('colores'),
            'active' => isset($_POST['active']) ? 1 : 0,
        ];

        if ($data['name'] === '') {
            return $this->flashRedirect('/admin/colores', 'Ingresá el nombre del color.', true);
        }

        try {
            Database::connect()->prepare("
                INSERT INTO colores (nombre, codigo_hex, orden, activo)
                VALUES (:name, :hex, :order, :active)
            ")->execute($data);

            return $this->flashRedirect('/admin/colores', 'Color creado correctamente.');
        } catch (PDOException $e) {
            error_log('Admin color create error: ' . $e->getMessage());
            return $this->flashRedirect('/admin/colores', 'No se pudo crear el color.', true);
        }
    }

    public function updateColor($id)
    {
        $this->requireAdmin();

        if (!$this->catalogOptionsReady()) {
            return $this->flashRedirect('/admin/telas', 'La base actual no tiene las tablas de telas y colores de schema.sql.', true);
        }

        $data = [
            'id' => (int) $id,
            'name' => trim($_POST['name'] ?? ''),
            'hex' => isset($_POST['use_hex']) ? $this->normalizeHex($_POST['hex'] ?? '') : null,
            'active' => isset($_POST['active']) ? 1 : 0,
        ];

        if ($data['name'] === '') {
            return $this->flashRedirect('/admin/colores', 'Ingresá el nombre del color.', true);
        }

        try {
            Database::connect()->prepare("
                UPDATE colores
                SET nombre = :name,
                    codigo_hex = :hex,
                    activo = :active
                WHERE id_color = :id
            ")->execute($data);

            return $this->flashRedirect('/admin/colores', 'Color actualizado correctamente.');
        } catch (PDOException $e) {
            error_log('Admin color update error: ' . $e->getMessage());
            return $this->flashRedirect('/admin/colores', 'No se pudo actualizar el color.', true);
        }
    }

    public function deleteColor($id)
    {
        $this->requireAdmin();

        if (!$this->catalogOptionsReady()) {
            return $this->flashRedirect('/admin/telas', 'La base actual no tiene las tablas de telas y colores de schema.sql.', true);
        }

        Database::connect()->prepare("UPDATE colores SET activo = 0 WHERE id_color = :id")
            ->execute(['id' => (int) $id]);

        return $this->flashRedirect('/admin/colores', 'Color desactivado correctamente.');
    }

    public function storeFabricColor()
    {
        $this->requireAdmin();

        if (!$this->catalogOptionsReady()) {
            return $this->flashRedirect('/admin/telas', 'La base actual no tiene las tablas de telas y colores de schema.sql.', true);
        }

        $data = [
            'fabric_id' => (int) ($_POST['fabric_id'] ?? 0),
            'color_id' => (int) ($_POST['color_id'] ?? 0),
            'supplier_code' => null,
            'order' => 0,
        ];

        if ($data['fabric_id'] <= 0 || $data['color_id'] <= 0) {
            return $this->flashRedirect('/admin/combinaciones', 'Seleccioná tela y color para crear la combinación.', true);
        }

        try {
            Database::connect()->prepare("
                INSERT INTO tela_colores (id_tela, id_color, codigo_proveedor, orden, disponible)
                VALUES (:fabric_id, :color_id, :supplier_code, :order, 1)
            ")->execute($data);

            return $this->flashRedirect('/admin/combinaciones', 'Combinación tela/color creada correctamente.');
        } catch (PDOException $e) {
            error_log('Admin fabric color create error: ' . $e->getMessage());

            if ($e->getCode() === '23000') {
                return $this->flashRedirect('/admin/combinaciones', 'Esa combinación de tela y color ya está cargada.', true);
            }

            return $this->flashRedirect('/admin/combinaciones', 'No se pudo crear la combinación.', true);
        }
    }

    public function deleteFabricColor($id)
    {
        $this->requireAdmin();

        if (!$this->catalogOptionsReady()) {
            return $this->flashRedirect('/admin/telas', 'La base actual no tiene las tablas de telas y colores de schema.sql.', true);
        }

        Database::connect()->prepare("UPDATE tela_colores SET disponible = 0 WHERE id_tela_color = :id")
            ->execute(['id' => (int) $id]);

        return $this->flashRedirect('/admin/combinaciones', 'Combinación desactivada correctamente.');
    }

    public function storeUser()
    {
        $this->requireAdmin();

        $data = $this->userDataFromRequest();
        $password = (string) ($_POST['password'] ?? '');
        $error = $this->validateUserData($data, $password, true);

        if ($error) {
            return $this->flashRedirect('/admin/usuarios', $error, true);
        }

        $data['password_hash'] = password_hash($password, PASSWORD_DEFAULT);

        try {
            Database::connect()->prepare("
                INSERT INTO usuarios (id_rol, nombre, email, usuario, password_hash, activo)
                VALUES (:role_id, :name, :email, :username, :password_hash, :active)
            ")->execute($data);

            return $this->flashRedirect('/admin/usuarios', 'Usuario creado correctamente.');
        } catch (PDOException $e) {
            error_log('Admin user create error: ' . $e->getMessage());
            return $this->flashRedirect('/admin/usuarios', 'No se pudo crear el usuario. Revisá que usuario/email no estén repetidos.', true);
        }
    }

    public function updateUser($id)
    {
        $this->requireAdmin();

        $id = (int) $id;
        $data = $this->userDataFromRequest();
        $password = (string) ($_POST['password'] ?? '');
        $error = $this->validateUserData($data, $password, false);

        if ($error) {
            return $this->flashRedirect('/admin/usuarios', $error, true);
        }

        $data['id'] = $id;

        try {
            if (trim($password) !== '') {
                $data['password_hash'] = password_hash($password, PASSWORD_DEFAULT);
                $sql = "
                    UPDATE usuarios
                    SET id_rol = :role_id,
                        nombre = :name,
                        email = :email,
                        usuario = :username,
                        password_hash = :password_hash,
                        activo = :active
                    WHERE id_usuario = :id
                ";
            } else {
                $sql = "
                    UPDATE usuarios
                    SET id_rol = :role_id,
                        nombre = :name,
                        email = :email,
                        usuario = :username,
                        activo = :active
                    WHERE id_usuario = :id
                ";
            }

            Database::connect()->prepare($sql)->execute($data);

            if ($id === (int) ($_SESSION['admin_user']['id'] ?? 0)) {
                $_SESSION['admin_user']['name'] = $data['name'];
                $_SESSION['admin_user']['username'] = $data['username'];
            }

            return $this->flashRedirect('/admin/usuarios', 'Usuario actualizado correctamente.');
        } catch (PDOException $e) {
            error_log('Admin user update error: ' . $e->getMessage());
            return $this->flashRedirect('/admin/usuarios', 'No se pudo actualizar el usuario. Revisá que usuario/email no estén repetidos.', true);
        }
    }

    public function deleteUser($id)
    {
        $this->requireAdmin();

        $id = (int) $id;

        if ($id === (int) ($_SESSION['admin_user']['id'] ?? 0)) {
            return $this->flashRedirect('/admin/usuarios', 'No podés desactivar tu propio usuario.', true);
        }

        Database::connect()->prepare("UPDATE usuarios SET activo = 0 WHERE id_usuario = :id")
            ->execute(['id' => $id]);

        return $this->flashRedirect('/admin/usuarios', 'Usuario desactivado correctamente.');
    }

    public function updateSettings()
    {
        $this->requireAdmin();

        $settings = [
            'site_name' => trim($_POST['site_name'] ?? 'Tapisur'),
            'contact_email' => trim($_POST['contact_email'] ?? ''),
            'phone_1' => trim($_POST['phone_1'] ?? ''),
            'phone_2' => trim($_POST['phone_2'] ?? ''),
            'whatsapp_number' => SiteSettings::normalizeWhatsapp($_POST['whatsapp_number'] ?? ''),
            'instagram_url' => trim($_POST['instagram_url'] ?? ''),
            'address' => trim($_POST['address'] ?? ''),
            'business_hours_weekdays' => trim($_POST['business_hours_weekdays'] ?? ''),
            'business_hours_saturday' => trim($_POST['business_hours_saturday'] ?? ''),
            'timezone' => trim($_POST['timezone'] ?? 'America/Argentina/Buenos_Aires'),
            'meta_title' => trim($_POST['meta_title'] ?? ''),
            'meta_description' => trim($_POST['meta_description'] ?? ''),
        ];

        if ($settings['site_name'] === '' || $settings['whatsapp_number'] === '') {
            return $this->flashRedirect('/admin/configuracion', 'Nombre comercial y WhatsApp son obligatorios.', true);
        }

        try {
            $pdo = Database::connect();
            $stmt = $pdo->prepare("
                INSERT INTO contenidos_sitio (clave, valor, tipo, descripcion, publico)
                VALUES (:key_name, :value, :type_name, :description, 1)
                ON DUPLICATE KEY UPDATE
                    valor = VALUES(valor),
                    tipo = VALUES(tipo),
                    descripcion = VALUES(descripcion),
                    publico = 1
            ");

            foreach ($settings as $key => $value) {
                $stmt->execute([
                    'key_name' => $key,
                    'value' => $value,
                    'type_name' => $this->settingType($key),
                    'description' => $this->settingDescription($key),
                ]);
            }

            return $this->flashRedirect('/admin/configuracion', 'Configuración guardada correctamente.');
        } catch (PDOException $e) {
            error_log('Admin settings update error: ' . $e->getMessage());
            return $this->flashRedirect('/admin/configuracion', 'No se pudo guardar la configuración.', true);
        }
    }

    public function updateOwnPassword()
    {
        $this->requireAdmin();

        $current = (string) ($_POST['current_password'] ?? '');
        $new = (string) ($_POST['new_password'] ?? '');
        $confirm = (string) ($_POST['new_password_confirmation'] ?? '');

        if ($current === '' || $new === '' || $confirm === '') {
            return $this->flashRedirect('/admin/dashboard', 'Completá la clave actual, la nueva y la confirmación.', true);
        }

        if ($new !== $confirm) {
            return $this->flashRedirect('/admin/dashboard', 'La clave nueva y la confirmación no coinciden.', true);
        }

        if (strlen($new) < 8) {
            return $this->flashRedirect('/admin/dashboard', 'La clave nueva debe tener al menos 8 caracteres.', true);
        }

        $stmt = Database::connect()->prepare("
            SELECT password_hash
            FROM usuarios
            WHERE id_usuario = :id
            LIMIT 1
        ");
        $stmt->execute(['id' => (int) ($_SESSION['admin_user']['id'] ?? 0)]);
        $user = $stmt->fetch();

        if (!$user || !password_verify($current, $user['password_hash'])) {
            return $this->flashRedirect('/admin/dashboard', 'La clave actual no es correcta.', true);
        }

        Database::connect()->prepare("
            UPDATE usuarios
            SET password_hash = :password_hash
            WHERE id_usuario = :id
        ")->execute([
            'password_hash' => password_hash($new, PASSWORD_DEFAULT),
            'id' => (int) ($_SESSION['admin_user']['id'] ?? 0),
        ]);

        return $this->flashRedirect('/admin/dashboard', 'Clave actualizada correctamente.');
    }

    private function getDashboardStats(): array
    {
        $pdo = Database::connect();

        return [
            'products' => (int) $pdo->query("SELECT COUNT(*) FROM productos WHERE activo = 1")->fetchColumn(),
            'featured' => (int) $pdo->query("SELECT COUNT(*) FROM productos WHERE activo = 1 AND destacado = 1")->fetchColumn(),
            'inactiveProducts' => (int) $pdo->query("SELECT COUNT(*) FROM productos WHERE activo = 0")->fetchColumn(),
            'categories' => (int) $pdo->query("SELECT COUNT(*) FROM categorias_producto WHERE activo = 1")->fetchColumn(),
            'fabrics' => $this->tableExists('telas') ? (int) $pdo->query("SELECT COUNT(*) FROM telas WHERE activo = 1")->fetchColumn() : 0,
            'colors' => $this->tableExists('colores') ? (int) $pdo->query("SELECT COUNT(*) FROM colores WHERE activo = 1")->fetchColumn() : 0,
            'users' => (int) $pdo->query("SELECT COUNT(*) FROM usuarios WHERE activo = 1")->fetchColumn(),
        ];
    }

    private function getProducts(string $search = ''): array
    {
        $params = [];
        $where = '';

        if ($search !== '') {
            $where = "
                WHERE p.nombre LIKE :search
                   OR p.descripcion LIKE :search
                   OR c.nombre LIKE :search
            ";
            $params['search'] = '%' . $search . '%';
        }

        $stmt = Database::connect()->prepare("
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
            $where
            ORDER BY p.activo DESC, p.destacado DESC, p.nombre ASC
        ");
        $stmt->execute($params);

        return $stmt->fetchAll();
    }
private function getUsers(): array
    {
        $stmt = Database::connect()->query("
            SELECT u.id_usuario, u.id_rol, u.nombre, u.email, u.usuario, u.activo, r.nombre AS rol
            FROM usuarios u
            INNER JOIN roles r ON r.id_rol = u.id_rol
            ORDER BY u.activo DESC, u.nombre ASC
        ");

        return $stmt->fetchAll();
    }

    private function getRoles(): array
    {
        $stmt = Database::connect()->query("
            SELECT id_rol, nombre
            FROM roles
            WHERE activo = 1
            ORDER BY nombre ASC
        ");

        return $stmt->fetchAll();
    }

    private function getSettings(): array
    {
        return SiteSettings::all();
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

    private function userDataFromRequest(): array
    {
        return [
            'role_id' => (int) ($_POST['role_id'] ?? 0),
            'name' => trim($_POST['name'] ?? ''),
            'email' => trim($_POST['email'] ?? ''),
            'username' => trim($_POST['username'] ?? ''),
            'active' => isset($_POST['active']) ? 1 : 0,
        ];
    }

    private function validateUserData(array $data, string $password, bool $requirePassword): ?string
    {
        if ($data['role_id'] <= 0) {
            return 'Seleccioná un rol para el usuario.';
        }

        if ($data['name'] === '') {
            return 'Ingresá el nombre del usuario.';
        }

        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            return 'Ingresá un email válido.';
        }

        if ($data['username'] === '') {
            return 'Ingresá el nombre de acceso.';
        }

        if ($requirePassword && trim($password) === '') {
            return 'Ingresá una clave inicial.';
        }

        if (trim($password) !== '' && strlen($password) < 8) {
            return 'La clave debe tener al menos 8 caracteres.';
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

    private function settingType(string $key): string
    {
        return match ($key) {
            'contact_email' => 'email',
            'phone_1', 'phone_2', 'whatsapp_number' => 'telefono',
            'instagram_url' => 'url',
            'meta_description' => 'textarea',
            default => 'texto',
        };
    }

    private function settingDescription(string $key): string
    {
        return match ($key) {
            'site_name' => 'Nombre comercial visible del sitio',
            'contact_email' => 'Email principal de contacto',
            'phone_1' => 'Telefono principal visible',
            'phone_2' => 'Telefono secundario visible',
            'whatsapp_number' => 'Numero destino para enlaces de WhatsApp',
            'instagram_url' => 'URL del perfil de Instagram',
            'address' => 'Direccion comercial',
            'business_hours_weekdays' => 'Horario de atencion de lunes a viernes',
            'business_hours_saturday' => 'Horario de atencion de sabados',
            'timezone' => 'Zona horaria de reportes y estadisticas',
            'meta_title' => 'Titulo SEO principal',
            'meta_description' => 'Descripcion SEO principal',
            default => 'Configuracion del sitio',
        };
    }


    private function productImageUploadError(): ?string
    {
        if (empty($_FILES['product_image']) || ($_FILES['product_image']['error'] ?? UPLOAD_ERR_NO_FILE) === UPLOAD_ERR_NO_FILE) {
            return null;
        }

        if ($_FILES['product_image']['error'] !== UPLOAD_ERR_OK) {
            return 'No se pudo subir la imagen. Probá nuevamente.';
        }

        if ((int) ($_FILES['product_image']['size'] ?? 0) > 5 * 1024 * 1024) {
            return 'La imagen no puede superar los 5 MB.';
        }

        $tmp = $_FILES['product_image']['tmp_name'] ?? '';
        if ($tmp === '' || !is_uploaded_file($tmp)) {
            return 'La imagen subida no es válida.';
        }

        $imageInfo = @getimagesize($tmp);
        if ($imageInfo === false) {
            return 'Subí una imagen válida en formato JPG, PNG o WEBP.';
        }

        $allowed = ['image/jpeg', 'image/png', 'image/webp'];
        if (!in_array($imageInfo['mime'] ?? '', $allowed, true)) {
            return 'Formato no permitido. Usá JPG, PNG o WEBP.';
        }

        return null;
    }

    private function saveProductImageUpload(int $productId): ?string
    {
        if (empty($_FILES['product_image']) || ($_FILES['product_image']['error'] ?? UPLOAD_ERR_NO_FILE) === UPLOAD_ERR_NO_FILE) {
            return null;
        }

        $tmp = $_FILES['product_image']['tmp_name'];
        $imageInfo = @getimagesize($tmp);
        $mime = $imageInfo['mime'] ?? '';
        $extensions = [
            'image/jpeg' => 'jpg',
            'image/png' => 'png',
            'image/webp' => 'webp',
        ];

        if (!isset($extensions[$mime])) {
            throw new \RuntimeException('Formato de imagen no permitido.');
        }

        $uploadDir = dirname(__DIR__, 3) . '/public/uploads/catalogo';
        if (!is_dir($uploadDir) && !mkdir($uploadDir, 0755, true) && !is_dir($uploadDir)) {
            throw new \RuntimeException('No se pudo crear la carpeta de imágenes.');
        }

        $filename = sprintf(
            'producto-%d-%s-%s.%s',
            $productId,
            date('YmdHis'),
            bin2hex(random_bytes(4)),
            $extensions[$mime]
        );
        $destination = $uploadDir . '/' . $filename;

        if (!move_uploaded_file($tmp, $destination)) {
            throw new \RuntimeException('No se pudo guardar la imagen subida.');
        }

        return '/uploads/catalogo/' . $filename;
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
