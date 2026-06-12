-- Tapisur - Esquema inicial MySQL
-- Fecha: 09/05/2026
-- Equipo: DataFour
-- Uso sugerido:
--   mysql -u root -p < database/schema.sql

CREATE DATABASE IF NOT EXISTS tapisur_db
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE tapisur_db;

SET FOREIGN_KEY_CHECKS = 0;

DROP TABLE IF EXISTS audit_logs;
DROP TABLE IF EXISTS site_settings;
DROP TABLE IF EXISTS inquiry_status_history;
DROP TABLE IF EXISTS inquiries;
DROP TABLE IF EXISTS sale_items;
DROP TABLE IF EXISTS sales;
DROP TABLE IF EXISTS service_images;
DROP TABLE IF EXISTS services;
DROP TABLE IF EXISTS service_categories;
DROP TABLE IF EXISTS product_attribute_values;
DROP TABLE IF EXISTS attribute_values;
DROP TABLE IF EXISTS attributes;
DROP TABLE IF EXISTS product_images;
DROP TABLE IF EXISTS products;
DROP TABLE IF EXISTS product_categories;
DROP TABLE IF EXISTS customers;
DROP TABLE IF EXISTS user_permissions;
DROP TABLE IF EXISTS role_permissions;
DROP TABLE IF EXISTS permissions;
DROP TABLE IF EXISTS users;
DROP TABLE IF EXISTS roles;

SET FOREIGN_KEY_CHECKS = 1;

CREATE TABLE roles (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(60) NOT NULL UNIQUE,
  label VARCHAR(100) NOT NULL,
  description VARCHAR(255) NULL,
  is_active TINYINT(1) NOT NULL DEFAULT 1,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE permissions (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL UNIQUE,
  label VARCHAR(120) NOT NULL,
  module VARCHAR(60) NOT NULL,
  description VARCHAR(255) NULL,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE role_permissions (
  role_id BIGINT UNSIGNED NOT NULL,
  permission_id BIGINT UNSIGNED NOT NULL,
  PRIMARY KEY (role_id, permission_id),
  CONSTRAINT fk_role_permissions_role
    FOREIGN KEY (role_id) REFERENCES roles(id)
    ON DELETE CASCADE,
  CONSTRAINT fk_role_permissions_permission
    FOREIGN KEY (permission_id) REFERENCES permissions(id)
    ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE users (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  role_id BIGINT UNSIGNED NOT NULL,
  first_name VARCHAR(80) NOT NULL,
  last_name VARCHAR(80) NOT NULL,
  email VARCHAR(160) NOT NULL UNIQUE,
  username VARCHAR(80) NOT NULL UNIQUE,
  password_hash VARCHAR(255) NOT NULL,
  contact_phone VARCHAR(40) NULL,
  whatsapp_phone VARCHAR(40) NULL,
  document_number VARCHAR(30) NULL,
  employee_code VARCHAR(40) NULL,
  notes TEXT NULL,
  last_login_at TIMESTAMP NULL,
  is_active TINYINT(1) NOT NULL DEFAULT 1,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  CONSTRAINT fk_users_role
    FOREIGN KEY (role_id) REFERENCES roles(id)
    ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE user_permissions (
  user_id BIGINT UNSIGNED NOT NULL,
  permission_id BIGINT UNSIGNED NOT NULL,
  allowed TINYINT(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (user_id, permission_id),
  CONSTRAINT fk_user_permissions_user
    FOREIGN KEY (user_id) REFERENCES users(id)
    ON DELETE CASCADE,
  CONSTRAINT fk_user_permissions_permission
    FOREIGN KEY (permission_id) REFERENCES permissions(id)
    ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE customers (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  full_name VARCHAR(140) NOT NULL,
  primary_phone VARCHAR(40) NOT NULL,
  secondary_phone VARCHAR(40) NULL,
  email VARCHAR(160) NULL,
  customer_type ENUM('minorista', 'mayorista', 'revendedor') NOT NULL DEFAULT 'minorista',
  origin ENUM('web', 'whatsapp', 'local', 'instagram', 'recomendado', 'otro') NOT NULL DEFAULT 'whatsapp',
  address VARCHAR(200) NULL,
  city VARCHAR(100) NULL,
  province VARCHAR(100) NULL,
  notes TEXT NULL,
  is_active TINYINT(1) NOT NULL DEFAULT 1,
  created_by BIGINT UNSIGNED NULL,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  CONSTRAINT fk_customers_created_by
    FOREIGN KEY (created_by) REFERENCES users(id)
    ON DELETE SET NULL,
  INDEX idx_customers_phone (primary_phone),
  INDEX idx_customers_type (customer_type)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE product_categories (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  parent_id BIGINT UNSIGNED NULL,
  name VARCHAR(100) NOT NULL,
  slug VARCHAR(120) NOT NULL UNIQUE,
  description VARCHAR(255) NULL,
  display_order INT NOT NULL DEFAULT 0,
  is_active TINYINT(1) NOT NULL DEFAULT 1,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  CONSTRAINT fk_product_categories_parent
    FOREIGN KEY (parent_id) REFERENCES product_categories(id)
    ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE products (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  category_id BIGINT UNSIGNED NOT NULL,
  name VARCHAR(150) NOT NULL,
  slug VARCHAR(170) NOT NULL UNIQUE,
  short_description VARCHAR(255) NULL,
  description TEXT NOT NULL,
  reference_code VARCHAR(60) NULL,
  seats INT UNSIGNED NULL,
  estimated_price DECIMAL(12,2) NULL,
  price_note VARCHAR(160) NULL DEFAULT 'Precio a presupuestar segun medidas y materiales',
  has_stock TINYINT(1) NOT NULL DEFAULT 0,
  stock_quantity INT UNSIGNED NULL,
  is_featured TINYINT(1) NOT NULL DEFAULT 0,
  is_active TINYINT(1) NOT NULL DEFAULT 1,
  display_order INT NOT NULL DEFAULT 0,
  created_by BIGINT UNSIGNED NULL,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  deleted_at TIMESTAMP NULL,
  CONSTRAINT fk_products_category
    FOREIGN KEY (category_id) REFERENCES product_categories(id)
    ON DELETE RESTRICT,
  CONSTRAINT fk_products_created_by
    FOREIGN KEY (created_by) REFERENCES users(id)
    ON DELETE SET NULL,
  INDEX idx_products_active_featured (is_active, is_featured),
  INDEX idx_products_category (category_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE product_images (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  product_id BIGINT UNSIGNED NOT NULL,
  path VARCHAR(255) NOT NULL,
  alt_text VARCHAR(180) NULL,
  is_main TINYINT(1) NOT NULL DEFAULT 0,
  display_order INT NOT NULL DEFAULT 0,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT fk_product_images_product
    FOREIGN KEY (product_id) REFERENCES products(id)
    ON DELETE CASCADE,
  INDEX idx_product_images_product (product_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE attributes (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(80) NOT NULL UNIQUE,
  label VARCHAR(100) NOT NULL,
  type ENUM('material', 'color', 'medida', 'caracteristica') NOT NULL,
  is_active TINYINT(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE attribute_values (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  attribute_id BIGINT UNSIGNED NOT NULL,
  value VARCHAR(120) NOT NULL,
  display_order INT NOT NULL DEFAULT 0,
  is_active TINYINT(1) NOT NULL DEFAULT 1,
  CONSTRAINT fk_attribute_values_attribute
    FOREIGN KEY (attribute_id) REFERENCES attributes(id)
    ON DELETE CASCADE,
  UNIQUE KEY uq_attribute_value (attribute_id, value)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE product_attribute_values (
  product_id BIGINT UNSIGNED NOT NULL,
  attribute_value_id BIGINT UNSIGNED NOT NULL,
  PRIMARY KEY (product_id, attribute_value_id),
  CONSTRAINT fk_product_attribute_values_product
    FOREIGN KEY (product_id) REFERENCES products(id)
    ON DELETE CASCADE,
  CONSTRAINT fk_product_attribute_values_value
    FOREIGN KEY (attribute_value_id) REFERENCES attribute_values(id)
    ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE service_categories (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  slug VARCHAR(120) NOT NULL UNIQUE,
  description VARCHAR(255) NULL,
  display_order INT NOT NULL DEFAULT 0,
  is_active TINYINT(1) NOT NULL DEFAULT 1,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE services (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  category_id BIGINT UNSIGNED NOT NULL,
  name VARCHAR(150) NOT NULL,
  slug VARCHAR(170) NOT NULL UNIQUE,
  short_description VARCHAR(255) NULL,
  description TEXT NOT NULL,
  requires_budget TINYINT(1) NOT NULL DEFAULT 1,
  estimated_price DECIMAL(12,2) NULL,
  is_featured TINYINT(1) NOT NULL DEFAULT 0,
  is_active TINYINT(1) NOT NULL DEFAULT 1,
  display_order INT NOT NULL DEFAULT 0,
  created_by BIGINT UNSIGNED NULL,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  deleted_at TIMESTAMP NULL,
  CONSTRAINT fk_services_category
    FOREIGN KEY (category_id) REFERENCES service_categories(id)
    ON DELETE RESTRICT,
  CONSTRAINT fk_services_created_by
    FOREIGN KEY (created_by) REFERENCES users(id)
    ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE service_images (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  service_id BIGINT UNSIGNED NOT NULL,
  path VARCHAR(255) NOT NULL,
  alt_text VARCHAR(180) NULL,
  is_main TINYINT(1) NOT NULL DEFAULT 0,
  display_order INT NOT NULL DEFAULT 0,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT fk_service_images_service
    FOREIGN KEY (service_id) REFERENCES services(id)
    ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE sales (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  customer_id BIGINT UNSIGNED NOT NULL,
  seller_id BIGINT UNSIGNED NOT NULL,
  sale_date DATE NOT NULL,
  status ENUM('registrada', 'confirmada', 'cancelada') NOT NULL DEFAULT 'registrada',
  subtotal DECIMAL(12,2) NOT NULL DEFAULT 0,
  discount DECIMAL(12,2) NOT NULL DEFAULT 0,
  total DECIMAL(12,2) NOT NULL DEFAULT 0,
  notes TEXT NULL,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  CONSTRAINT fk_sales_customer
    FOREIGN KEY (customer_id) REFERENCES customers(id)
    ON DELETE RESTRICT,
  CONSTRAINT fk_sales_seller
    FOREIGN KEY (seller_id) REFERENCES users(id)
    ON DELETE RESTRICT,
  INDEX idx_sales_date (sale_date),
  INDEX idx_sales_seller (seller_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE sale_items (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  sale_id BIGINT UNSIGNED NOT NULL,
  item_type ENUM('producto', 'servicio', 'personalizado') NOT NULL,
  product_id BIGINT UNSIGNED NULL,
  service_id BIGINT UNSIGNED NULL,
  description VARCHAR(180) NOT NULL,
  quantity INT UNSIGNED NOT NULL DEFAULT 1,
  unit_price DECIMAL(12,2) NOT NULL DEFAULT 0,
  total DECIMAL(12,2) NOT NULL DEFAULT 0,
  CONSTRAINT fk_sale_items_sale
    FOREIGN KEY (sale_id) REFERENCES sales(id)
    ON DELETE CASCADE,
  CONSTRAINT fk_sale_items_product
    FOREIGN KEY (product_id) REFERENCES products(id)
    ON DELETE SET NULL,
  CONSTRAINT fk_sale_items_service
    FOREIGN KEY (service_id) REFERENCES services(id)
    ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE inquiries (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  customer_id BIGINT UNSIGNED NULL,
  product_id BIGINT UNSIGNED NULL,
  service_id BIGINT UNSIGNED NULL,
  assigned_user_id BIGINT UNSIGNED NULL,
  source ENUM('web', 'whatsapp', 'telefono', 'instagram', 'local', 'otro') NOT NULL DEFAULT 'web',
  status ENUM('nueva', 'contactada', 'presupuestada', 'cerrada', 'descartada') NOT NULL DEFAULT 'nueva',
  contact_name VARCHAR(140) NULL,
  contact_phone VARCHAR(40) NULL,
  contact_email VARCHAR(160) NULL,
  message TEXT NULL,
  generated_whatsapp_text TEXT NULL,
  origin_page VARCHAR(120) NULL,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  CONSTRAINT fk_inquiries_customer
    FOREIGN KEY (customer_id) REFERENCES customers(id)
    ON DELETE SET NULL,
  CONSTRAINT fk_inquiries_product
    FOREIGN KEY (product_id) REFERENCES products(id)
    ON DELETE SET NULL,
  CONSTRAINT fk_inquiries_service
    FOREIGN KEY (service_id) REFERENCES services(id)
    ON DELETE SET NULL,
  CONSTRAINT fk_inquiries_assigned_user
    FOREIGN KEY (assigned_user_id) REFERENCES users(id)
    ON DELETE SET NULL,
  INDEX idx_inquiries_status (status),
  INDEX idx_inquiries_source (source)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE inquiry_status_history (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  inquiry_id BIGINT UNSIGNED NOT NULL,
  user_id BIGINT UNSIGNED NULL,
  previous_status VARCHAR(40) NULL,
  new_status VARCHAR(40) NOT NULL,
  notes VARCHAR(255) NULL,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT fk_inquiry_status_history_inquiry
    FOREIGN KEY (inquiry_id) REFERENCES inquiries(id)
    ON DELETE CASCADE,
  CONSTRAINT fk_inquiry_status_history_user
    FOREIGN KEY (user_id) REFERENCES users(id)
    ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE site_settings (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  setting_key VARCHAR(100) NOT NULL UNIQUE,
  setting_value TEXT NOT NULL,
  setting_type ENUM('text', 'textarea', 'url', 'phone', 'email', 'json') NOT NULL DEFAULT 'text',
  label VARCHAR(120) NOT NULL,
  description VARCHAR(255) NULL,
  is_public TINYINT(1) NOT NULL DEFAULT 1,
  updated_by BIGINT UNSIGNED NULL,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  CONSTRAINT fk_site_settings_updated_by
    FOREIGN KEY (updated_by) REFERENCES users(id)
    ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE audit_logs (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  user_id BIGINT UNSIGNED NULL,
  action VARCHAR(80) NOT NULL,
  entity_type VARCHAR(80) NOT NULL,
  entity_id BIGINT UNSIGNED NULL,
  old_values JSON NULL,
  new_values JSON NULL,
  ip_address VARCHAR(45) NULL,
  user_agent VARCHAR(255) NULL,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT fk_audit_logs_user
    FOREIGN KEY (user_id) REFERENCES users(id)
    ON DELETE SET NULL,
  INDEX idx_audit_logs_entity (entity_type, entity_id),
  INDEX idx_audit_logs_user (user_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Datos iniciales

INSERT INTO roles (id, name, label, description) VALUES
  (1, 'administrador', 'Administrador', 'Acceso completo al panel y configuracion.'),
  (2, 'vendedor', 'Vendedor', 'Registra clientes, consultas y ventas.'),
  (3, 'editor', 'Editor', 'Administra catalogo, servicios y contenido.');

INSERT INTO permissions (name, label, module) VALUES
  ('usuarios.ver', 'Ver usuarios', 'usuarios'),
  ('usuarios.crear', 'Crear usuarios', 'usuarios'),
  ('usuarios.editar', 'Editar usuarios', 'usuarios'),
  ('roles.ver', 'Ver roles', 'roles'),
  ('roles.editar', 'Editar roles', 'roles'),
  ('productos.ver', 'Ver productos', 'productos'),
  ('productos.crear', 'Crear productos', 'productos'),
  ('productos.editar', 'Editar productos', 'productos'),
  ('productos.eliminar', 'Eliminar productos', 'productos'),
  ('servicios.ver', 'Ver servicios', 'servicios'),
  ('servicios.crear', 'Crear servicios', 'servicios'),
  ('servicios.editar', 'Editar servicios', 'servicios'),
  ('servicios.eliminar', 'Eliminar servicios', 'servicios'),
  ('clientes.ver', 'Ver clientes', 'clientes'),
  ('clientes.crear', 'Crear clientes', 'clientes'),
  ('clientes.editar', 'Editar clientes', 'clientes'),
  ('ventas.ver', 'Ver ventas', 'ventas'),
  ('ventas.crear', 'Crear ventas', 'ventas'),
  ('ventas.editar', 'Editar ventas', 'ventas'),
  ('consultas.ver', 'Ver consultas', 'consultas'),
  ('consultas.crear', 'Crear consultas', 'consultas'),
  ('consultas.editar', 'Editar consultas', 'consultas'),
  ('contenido.ver', 'Ver contenido', 'contenido'),
  ('contenido.editar', 'Editar contenido', 'contenido');

INSERT INTO role_permissions (role_id, permission_id)
SELECT 1, id FROM permissions;

INSERT INTO role_permissions (role_id, permission_id)
SELECT 2, id FROM permissions
WHERE name IN (
  'productos.ver',
  'servicios.ver',
  'clientes.ver',
  'clientes.crear',
  'clientes.editar',
  'ventas.ver',
  'ventas.crear',
  'consultas.ver',
  'consultas.crear',
  'consultas.editar'
);

INSERT INTO role_permissions (role_id, permission_id)
SELECT 3, id FROM permissions
WHERE name IN (
  'productos.ver',
  'productos.crear',
  'productos.editar',
  'servicios.ver',
  'servicios.crear',
  'servicios.editar',
  'contenido.ver',
  'contenido.editar'
);

-- Usuario inicial.
-- Cambiar la clave luego de instalar. Hash compatible con password_hash de PHP.
-- Usuario: admin
-- Clave temporal documentada: Cambiar123!
INSERT INTO users (
  id,
  role_id,
  first_name,
  last_name,
  email,
  username,
  password_hash,
  contact_phone,
  whatsapp_phone,
  employee_code
) VALUES (
  1,
  1,
  'Admin',
  'Tapisur',
  'admin@tapisur.local',
  'admin',
  '$2y$10$Q4d9vM3fYqXf4m3kN9LrYOwByNnqS.rnpeAq58oPGr.8UIuJXx3va',
  '11 5110-3419',
  '5491151103419',
  'ADM-001'
);

INSERT INTO product_categories (id, parent_id, name, slug, display_order) VALUES
  (1, NULL, 'Sofas', 'sofas', 10),
  (2, NULL, 'Chesterfield', 'chesterfield', 20),
  (3, NULL, 'Rinconeros', 'rinconeros', 30),
  (4, NULL, 'Sillones cama', 'sillones-cama', 40),
  (5, NULL, 'Individuales', 'individuales', 50),
  (6, NULL, 'Mesas', 'mesas', 60),
  (7, NULL, 'Baules', 'baules', 70),
  (8, NULL, 'Respaldos', 'respaldos', 80);

INSERT INTO attributes (id, name, label, type) VALUES
  (1, 'material', 'Material', 'material'),
  (2, 'color', 'Color', 'color'),
  (3, 'medida', 'Medida', 'medida'),
  (4, 'caracteristica', 'Caracteristica', 'caracteristica');

INSERT INTO attribute_values (attribute_id, value, display_order) VALUES
  (1, 'Chenille', 10),
  (1, 'Pana', 20),
  (1, 'Cuerina', 30),
  (2, 'Beige', 10),
  (2, 'Gris claro', 20),
  (2, 'Oliva', 30),
  (2, 'Grafito', 40),
  (3, 'Personalizada', 10),
  (4, 'A medida', 10),
  (4, 'Estructura reforzada', 20),
  (4, 'Capitone', 30),
  (4, 'Con cama', 40);

INSERT INTO products (
  id,
  category_id,
  name,
  slug,
  short_description,
  description,
  seats,
  is_featured,
  display_order,
  created_by
) VALUES
  (1, 1, 'Modelo 22 - Sofa 3 Cuerpos', 'modelo-22-sofa-3-cuerpos', 'Sofa amplio para living principal.', 'Sofa amplio para living principal, con excelente confort diario. Fabricacion a medida y presupuesto personalizado.', 3, 1, 10, 1),
  (2, 1, 'Modelo 22 - Sofa 2 Cuerpos', 'modelo-22-sofa-2-cuerpos', 'Version compacta del Modelo 22.', 'Version compacta del Modelo 22 para departamentos y ambientes reducidos.', 2, 1, 20, 1),
  (3, 2, 'Chesterfield - Sofa 3 Cuerpos', 'chesterfield-sofa-3-cuerpos', 'Estilo clasico con fuerte presencia.', 'Estilo clasico con fuerte presencia para livings de diseno.', 3, 1, 30, 1),
  (4, 3, 'Rinconero 3 Cuerpos con Camastro', 'rinconero-3-cuerpos-con-camastro', 'Gran capacidad para espacios integrados.', 'Gran capacidad para familias y espacios integrados.', 4, 1, 40, 1),
  (5, 4, 'Sillon Cama 1.15 con Brazos', 'sillon-cama-115-con-brazos', 'Solucion practica de doble funcion.', 'Mayor ancho de descanso sin perder estetica de living.', 1, 1, 50, 1),
  (6, 7, 'Baul Tapizado 1.00', 'baul-tapizado-100', 'Baul amplio para guardado extra.', 'Baul amplio para guardar mantas y almohadones.', 0, 1, 60, 1),
  (7, 8, 'Respaldo Sommier Capitone', 'respaldo-sommier-capitone', 'Respaldo de cama con terminacion capitone.', 'Respaldo de cama con capitone para un acabado elegante.', 0, 1, 70, 1);

INSERT INTO product_images (product_id, path, alt_text, is_main, display_order) VALUES
  (1, '/img/catalogo/page02_img01.jpeg', 'Modelo 22 Sofa 3 Cuerpos', 1, 10),
  (2, '/img/catalogo/page02_img01.jpeg', 'Modelo 22 Sofa 2 Cuerpos', 1, 10),
  (3, '/img/catalogo/page03_img01.jpeg', 'Chesterfield Sofa 3 Cuerpos', 1, 10),
  (4, '/img/catalogo/page04_img01.jpeg', 'Rinconero con camastro', 1, 10),
  (5, '/img/catalogo/page06_img02.jpeg', 'Sillon cama con brazos', 1, 10),
  (6, '/img/catalogo/page08_img01.jpeg', 'Baul tapizado', 1, 10),
  (7, '/img/catalogo/page09_img01.jpeg', 'Respaldo sommier capitone', 1, 10);

INSERT INTO service_categories (id, name, slug, display_order) VALUES
  (1, 'Retapizado', 'retapizado', 10),
  (2, 'Reparacion', 'reparacion', 20),
  (3, 'Restauracion', 'restauracion', 30),
  (4, 'Fabricacion a medida', 'fabricacion-a-medida', 40);

INSERT INTO services (
  id,
  category_id,
  name,
  slug,
  short_description,
  description,
  requires_budget,
  is_featured,
  display_order,
  created_by
) VALUES
  (1, 1, 'Retapizado de sillones', 'retapizado-de-sillones', 'Renovacion de tapizados existentes.', 'Servicio de retapizado de sillones con evaluacion del estado actual, materiales y medidas.', 1, 1, 10, 1),
  (2, 2, 'Reparacion estructural', 'reparacion-estructural', 'Arreglos de estructura y soporte.', 'Reparacion de estructuras, bases, apoyos y componentes internos segun revision previa.', 1, 1, 20, 1),
  (3, 3, 'Restauracion de muebles', 'restauracion-de-muebles', 'Recuperacion y puesta en valor.', 'Restauracion de muebles tapizados y piezas con valor sentimental o comercial.', 1, 0, 30, 1),
  (4, 4, 'Fabricacion personalizada', 'fabricacion-personalizada', 'Fabricacion segun medidas del cliente.', 'Fabricacion de sillones, respaldos, baules y piezas a medida.', 1, 1, 40, 1);

INSERT INTO site_settings (setting_key, setting_value, setting_type, label, description) VALUES
  ('hero_title', 'Fabricamos sillones a medida, pensados para durar', 'text', 'Titulo principal', 'Titulo de la home'),
  ('hero_subtitle', 'Nos encargamos de todo: desde la fabricacion a medida hasta la entrega en la puerta de tu casa, con atencion directa en cada etapa.', 'textarea', 'Subtitulo principal', 'Subtitulo de la home'),
  ('phone_1', '11 5110-3419', 'phone', 'Telefono 1', 'Telefono visible principal'),
  ('phone_2', '11 6767-5200', 'phone', 'Telefono 2', 'Telefono visible secundario'),
  ('whatsapp_number', '5491151103419', 'phone', 'WhatsApp', 'Numero usado para enlaces wa.me'),
  ('address', 'Juan Esteban Pedernera 1462, Lanus Este, Buenos Aires', 'text', 'Direccion', 'Direccion visible del local'),
  ('instagram_url', 'https://www.instagram.com/tapisur_/', 'url', 'Instagram', 'URL de Instagram');
