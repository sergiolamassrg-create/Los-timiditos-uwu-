-- Tapisur - Esquema V2 con telas, colores y variantes administrables
-- Fecha: 2026-06-14
-- Uso sugerido para instalar desde cero:
--   mysql -u root -p < database/schema_v2_telas_colores.sql
--
-- IMPORTANTE:
-- Este script recrea las tablas de la base indicada abajo.
-- Antes de importarlo sobre una base con datos reales, hacer backup.

CREATE DATABASE IF NOT EXISTS db_tapisur
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE db_tapisur;

SET FOREIGN_KEY_CHECKS = 0;

DROP TABLE IF EXISTS venta_detalles;
DROP TABLE IF EXISTS ventas;
DROP TABLE IF EXISTS interacciones;
DROP TABLE IF EXISTS clientes;
DROP TABLE IF EXISTS contenidos_sitio;
DROP TABLE IF EXISTS servicio_imagenes;
DROP TABLE IF EXISTS servicios;
DROP TABLE IF EXISTS categorias_servicio;
DROP TABLE IF EXISTS producto_medidas;
DROP TABLE IF EXISTS producto_caracteristicas;
DROP TABLE IF EXISTS producto_tela_colores;
DROP TABLE IF EXISTS tela_colores;
DROP TABLE IF EXISTS colores;
DROP TABLE IF EXISTS telas;
DROP TABLE IF EXISTS producto_imagenes;
DROP TABLE IF EXISTS productos;
DROP TABLE IF EXISTS categorias_producto;
DROP TABLE IF EXISTS usuarios;
DROP TABLE IF EXISTS roles;

SET FOREIGN_KEY_CHECKS = 1;

CREATE TABLE roles (
  id_rol INT AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(50) NOT NULL,
  descripcion VARCHAR(255) NULL,
  activo TINYINT(1) NOT NULL DEFAULT 1,
  creado_en DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  actualizado_en DATETIME NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  UNIQUE KEY uq_roles_nombre (nombre)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE usuarios (
  id_usuario INT AUTO_INCREMENT PRIMARY KEY,
  id_rol INT NOT NULL,
  nombre VARCHAR(120) NOT NULL,
  email VARCHAR(160) NOT NULL,
  usuario VARCHAR(80) NOT NULL,
  password_hash VARCHAR(255) NOT NULL,
  activo TINYINT(1) NOT NULL DEFAULT 1,
  creado_en DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  actualizado_en DATETIME NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  UNIQUE KEY uq_usuarios_email (email),
  UNIQUE KEY uq_usuarios_usuario (usuario),
  KEY idx_usuarios_id_rol (id_rol),
  CONSTRAINT fk_usuarios_roles
    FOREIGN KEY (id_rol) REFERENCES roles (id_rol)
    ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE categorias_producto (
  id_categoria_producto INT AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(100) NOT NULL,
  descripcion VARCHAR(255) NULL,
  activo TINYINT(1) NOT NULL DEFAULT 1,
  creado_en DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  actualizado_en DATETIME NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  UNIQUE KEY uq_categorias_producto_nombre (nombre)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE productos (
  id_producto INT AUTO_INCREMENT PRIMARY KEY,
  id_categoria_producto INT NOT NULL,
  nombre VARCHAR(140) NOT NULL,
  descripcion TEXT NOT NULL,
  capacidad INT NOT NULL DEFAULT 0,
  destacado TINYINT(1) NOT NULL DEFAULT 0,
  activo TINYINT(1) NOT NULL DEFAULT 1,
  creado_en DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  actualizado_en DATETIME NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  KEY idx_productos_categoria (id_categoria_producto),
  KEY idx_productos_activo_destacado (activo, destacado),
  CONSTRAINT fk_productos_categorias_producto
    FOREIGN KEY (id_categoria_producto) REFERENCES categorias_producto (id_categoria_producto)
    ON UPDATE CASCADE,
  CONSTRAINT chk_productos_capacidad CHECK (capacidad >= 0)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE producto_imagenes (
  id_imagen INT AUTO_INCREMENT PRIMARY KEY,
  id_producto INT NOT NULL,
  ruta VARCHAR(255) NOT NULL,
  texto_alt VARCHAR(180) NULL,
  orden INT NOT NULL DEFAULT 0,
  principal TINYINT(1) NOT NULL DEFAULT 0,
  activo TINYINT(1) NOT NULL DEFAULT 1,
  creado_en DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  actualizado_en DATETIME NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  KEY idx_producto_imagenes_producto (id_producto),
  CONSTRAINT fk_producto_imagenes_productos
    FOREIGN KEY (id_producto) REFERENCES productos (id_producto)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT chk_producto_imagenes_orden CHECK (orden >= 0)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE telas (
  id_tela INT AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(100) NOT NULL,
  descripcion VARCHAR(255) NULL,
  orden INT NOT NULL DEFAULT 0,
  activo TINYINT(1) NOT NULL DEFAULT 1,
  creado_en DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  actualizado_en DATETIME NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  UNIQUE KEY uq_telas_nombre (nombre),
  KEY idx_telas_activo_orden (activo, orden)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE colores (
  id_color INT AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(100) NOT NULL,
  codigo_hex CHAR(7) NULL,
  orden INT NOT NULL DEFAULT 0,
  activo TINYINT(1) NOT NULL DEFAULT 1,
  creado_en DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  actualizado_en DATETIME NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  UNIQUE KEY uq_colores_nombre (nombre),
  KEY idx_colores_activo_orden (activo, orden),
  CONSTRAINT chk_colores_codigo_hex
    CHECK (codigo_hex IS NULL OR codigo_hex REGEXP '^#[0-9A-Fa-f]{6}$')
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Colores disponibles por cada tela.
-- Ejemplo: Chenille puede existir en Beige y Gris, pero Cuerina no necesariamente.
CREATE TABLE tela_colores (
  id_tela_color INT AUTO_INCREMENT PRIMARY KEY,
  id_tela INT NOT NULL,
  id_color INT NOT NULL,
  codigo_proveedor VARCHAR(80) NULL,
  disponible TINYINT(1) NOT NULL DEFAULT 1,
  orden INT NOT NULL DEFAULT 0,
  creado_en DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  actualizado_en DATETIME NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  UNIQUE KEY uq_tela_colores_tela_color (id_tela, id_color),
  KEY idx_tela_colores_color (id_color),
  KEY idx_tela_colores_disponible (disponible),
  CONSTRAINT fk_tela_colores_telas
    FOREIGN KEY (id_tela) REFERENCES telas (id_tela)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT fk_tela_colores_colores
    FOREIGN KEY (id_color) REFERENCES colores (id_color)
    ON DELETE RESTRICT
    ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Relaciona productos con combinaciones reales tela-color.
-- Si una combinacion deja de estar disponible, se desactiva en tela_colores
-- y no hace falta editar producto por producto.
CREATE TABLE producto_tela_colores (
  id_producto INT NOT NULL,
  id_tela_color INT NOT NULL,
  destacado TINYINT(1) NOT NULL DEFAULT 0,
  activo TINYINT(1) NOT NULL DEFAULT 1,
  creado_en DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id_producto, id_tela_color),
  KEY idx_producto_tela_colores_tela_color (id_tela_color),
  KEY idx_producto_tela_colores_activo (activo),
  CONSTRAINT fk_producto_tela_colores_productos
    FOREIGN KEY (id_producto) REFERENCES productos (id_producto)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT fk_producto_tela_colores_tela_colores
    FOREIGN KEY (id_tela_color) REFERENCES tela_colores (id_tela_color)
    ON DELETE RESTRICT
    ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE producto_medidas (
  id_medida INT AUTO_INCREMENT PRIMARY KEY,
  id_producto INT NOT NULL,
  descripcion VARCHAR(120) NOT NULL,
  ancho_cm DECIMAL(8,2) NULL,
  profundidad_cm DECIMAL(8,2) NULL,
  alto_cm DECIMAL(8,2) NULL,
  orden INT NOT NULL DEFAULT 0,
  activo TINYINT(1) NOT NULL DEFAULT 1,
  creado_en DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  actualizado_en DATETIME NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  KEY idx_producto_medidas_producto (id_producto),
  CONSTRAINT fk_producto_medidas_productos
    FOREIGN KEY (id_producto) REFERENCES productos (id_producto)
    ON DELETE CASCADE
    ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE producto_caracteristicas (
  id_caracteristica INT AUTO_INCREMENT PRIMARY KEY,
  id_producto INT NOT NULL,
  nombre VARCHAR(120) NOT NULL,
  orden INT NOT NULL DEFAULT 0,
  activo TINYINT(1) NOT NULL DEFAULT 1,
  creado_en DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  actualizado_en DATETIME NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  KEY idx_producto_caracteristicas_producto (id_producto),
  CONSTRAINT fk_producto_caracteristicas_productos
    FOREIGN KEY (id_producto) REFERENCES productos (id_producto)
    ON DELETE CASCADE
    ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE categorias_servicio (
  id_categoria_servicio INT AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(100) NOT NULL,
  descripcion VARCHAR(255) NULL,
  activo TINYINT(1) NOT NULL DEFAULT 1,
  creado_en DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  actualizado_en DATETIME NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  UNIQUE KEY uq_categorias_servicio_nombre (nombre)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE servicios (
  id_servicio INT AUTO_INCREMENT PRIMARY KEY,
  id_categoria_servicio INT NOT NULL,
  nombre VARCHAR(140) NOT NULL,
  descripcion TEXT NOT NULL,
  destacado TINYINT(1) NOT NULL DEFAULT 0,
  activo TINYINT(1) NOT NULL DEFAULT 1,
  creado_en DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  actualizado_en DATETIME NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  KEY idx_servicios_categoria (id_categoria_servicio),
  CONSTRAINT fk_servicios_categorias_servicio
    FOREIGN KEY (id_categoria_servicio) REFERENCES categorias_servicio (id_categoria_servicio)
    ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE servicio_imagenes (
  id_imagen INT AUTO_INCREMENT PRIMARY KEY,
  id_servicio INT NOT NULL,
  ruta VARCHAR(255) NOT NULL,
  texto_alt VARCHAR(180) NULL,
  orden INT NOT NULL DEFAULT 0,
  principal TINYINT(1) NOT NULL DEFAULT 0,
  activo TINYINT(1) NOT NULL DEFAULT 1,
  creado_en DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  actualizado_en DATETIME NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  KEY idx_servicio_imagenes_servicio (id_servicio),
  CONSTRAINT fk_servicio_imagenes_servicios
    FOREIGN KEY (id_servicio) REFERENCES servicios (id_servicio)
    ON DELETE CASCADE
    ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE clientes (
  id_cliente INT AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(140) NOT NULL,
  telefono VARCHAR(40) NOT NULL,
  email VARCHAR(160) NULL,
  direccion VARCHAR(200) NULL,
  origen VARCHAR(60) NULL,
  notas TEXT NULL,
  activo TINYINT(1) NOT NULL DEFAULT 1,
  creado_en DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  actualizado_en DATETIME NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  KEY idx_clientes_telefono (telefono)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE ventas (
  id_venta INT AUTO_INCREMENT PRIMARY KEY,
  id_cliente INT NULL,
  id_usuario INT NULL,
  fecha DATE NOT NULL,
  estado ENUM('presupuesto', 'confirmada', 'entregada', 'cancelada') NOT NULL DEFAULT 'presupuesto',
  total DECIMAL(12,2) NOT NULL DEFAULT 0,
  notas TEXT NULL,
  creado_en DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  actualizado_en DATETIME NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  KEY idx_ventas_cliente (id_cliente),
  KEY idx_ventas_usuario (id_usuario),
  KEY idx_ventas_fecha (fecha),
  CONSTRAINT fk_ventas_clientes
    FOREIGN KEY (id_cliente) REFERENCES clientes (id_cliente)
    ON DELETE SET NULL
    ON UPDATE CASCADE,
  CONSTRAINT fk_ventas_usuarios
    FOREIGN KEY (id_usuario) REFERENCES usuarios (id_usuario)
    ON DELETE SET NULL
    ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE venta_detalles (
  id_detalle INT AUTO_INCREMENT PRIMARY KEY,
  id_venta INT NOT NULL,
  id_producto INT NULL,
  id_servicio INT NULL,
  descripcion VARCHAR(180) NOT NULL,
  cantidad INT NOT NULL DEFAULT 1,
  precio_unitario DECIMAL(12,2) NOT NULL DEFAULT 0,
  subtotal DECIMAL(12,2) NOT NULL DEFAULT 0,
  creado_en DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  KEY idx_venta_detalles_venta (id_venta),
  CONSTRAINT fk_venta_detalles_ventas
    FOREIGN KEY (id_venta) REFERENCES ventas (id_venta)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT fk_venta_detalles_productos
    FOREIGN KEY (id_producto) REFERENCES productos (id_producto)
    ON DELETE SET NULL
    ON UPDATE CASCADE,
  CONSTRAINT fk_venta_detalles_servicios
    FOREIGN KEY (id_servicio) REFERENCES servicios (id_servicio)
    ON DELETE SET NULL
    ON UPDATE CASCADE,
  CONSTRAINT chk_venta_detalles_cantidad CHECK (cantidad > 0)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE interacciones (
  id_interaccion INT AUTO_INCREMENT PRIMARY KEY,
  id_cliente INT NULL,
  id_producto INT NULL,
  id_servicio INT NULL,
  canal ENUM('web', 'whatsapp', 'telefono', 'instagram', 'local', 'otro') NOT NULL DEFAULT 'web',
  estado ENUM('nueva', 'contactada', 'presupuestada', 'cerrada', 'descartada') NOT NULL DEFAULT 'nueva',
  nombre_contacto VARCHAR(140) NULL,
  telefono_contacto VARCHAR(40) NULL,
  mensaje TEXT NULL,
  pagina_origen VARCHAR(120) NULL,
  creado_en DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  actualizado_en DATETIME NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  KEY idx_interacciones_estado (estado),
  KEY idx_interacciones_producto (id_producto),
  CONSTRAINT fk_interacciones_clientes
    FOREIGN KEY (id_cliente) REFERENCES clientes (id_cliente)
    ON DELETE SET NULL
    ON UPDATE CASCADE,
  CONSTRAINT fk_interacciones_productos
    FOREIGN KEY (id_producto) REFERENCES productos (id_producto)
    ON DELETE SET NULL
    ON UPDATE CASCADE,
  CONSTRAINT fk_interacciones_servicios
    FOREIGN KEY (id_servicio) REFERENCES servicios (id_servicio)
    ON DELETE SET NULL
    ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE contenidos_sitio (
  id_contenido INT AUTO_INCREMENT PRIMARY KEY,
  clave VARCHAR(100) NOT NULL,
  valor TEXT NOT NULL,
  tipo VARCHAR(40) NOT NULL DEFAULT 'texto',
  descripcion VARCHAR(255) NULL,
  publico TINYINT(1) NOT NULL DEFAULT 1,
  creado_en DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  actualizado_en DATETIME NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  UNIQUE KEY uq_contenidos_sitio_clave (clave)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Datos de prueba

INSERT INTO roles (id_rol, nombre, descripcion) VALUES
  (1, 'administrador', 'Acceso completo al panel.'),
  (2, 'vendedor', 'Gestion comercial y consultas.');

-- Clave temporal para ambos usuarios de prueba: Cambiar123!
INSERT INTO usuarios (id_usuario, id_rol, nombre, email, usuario, password_hash) VALUES
  (1, 1, 'Administrador Tapisur', 'admin@tapisur.local', 'admin', '$2y$10$Q4d9vM3fYqXf4m3kN9LrYOwByNnqS.rnpeAq58oPGr.8UIuJXx3va'),
  (2, 2, 'Vendedor Demo', 'vendedor@tapisur.local', 'vendedor', '$2y$10$Q4d9vM3fYqXf4m3kN9LrYOwByNnqS.rnpeAq58oPGr.8UIuJXx3va');

INSERT INTO categorias_producto (id_categoria_producto, nombre, descripcion) VALUES
  (1, 'Sofas', 'Sillones de dos o mas cuerpos.'),
  (2, 'Chesterfield', 'Modelos capitone clasicos.'),
  (3, 'Rinconeros', 'Sillones en L y esquineros.'),
  (4, 'Sillones cama', 'Modelos con funcion de cama.'),
  (5, 'Individuales', 'Sillones de un cuerpo.'),
  (6, 'Baules', 'Baules tapizados.'),
  (7, 'Respaldos', 'Respaldos para sommier y cama.');

INSERT INTO productos (id_producto, id_categoria_producto, nombre, descripcion, capacidad, destacado) VALUES
  (1, 1, 'Modelo 22 - Sofa 3 cuerpos', 'Sofa amplio para living principal, fabricado a medida y con excelente confort diario.', 3, 1),
  (2, 1, 'Modelo 22 - Sofa 2 cuerpos', 'Version compacta del Modelo 22 para departamentos y ambientes reducidos.', 2, 1),
  (3, 5, 'Modelo 22 - Sillon individual', 'Sillon de apoyo ideal para completar juegos de living.', 1, 0),
  (4, 2, 'Chesterfield - Sofa 3 cuerpos', 'Estilo clasico con fuerte presencia y terminacion capitone.', 3, 1),
  (5, 2, 'Chesterfield - Sofa 2 cuerpos', 'Version de dos cuerpos del Chesterfield con terminaciones de alta calidad.', 2, 0),
  (6, 4, 'Chesterfield - Sofa cama 3 cuerpos', 'Solucion premium de doble funcion: living y descanso.', 3, 1),
  (7, 3, 'Rinconero 3 cuerpos con camastro', 'Gran capacidad para familias y espacios integrados.', 4, 1),
  (8, 3, 'Rinconero clasico', 'Configuracion rinconera adaptable al ambiente.', 4, 0),
  (9, 6, 'Baul tapizado 1.00', 'Baul amplio para guardar mantas, almohadones y objetos del living.', 0, 1),
  (10, 7, 'Respaldo sommier capitone', 'Respaldo tapizado para cama con terminacion elegante.', 0, 1);

INSERT INTO producto_imagenes (id_producto, ruta, texto_alt, orden, principal) VALUES
  (1, '/img/catalogo/page02_img01.jpeg', 'Modelo 22 Sofa 3 cuerpos Tapisur', 1, 1),
  (2, '/img/catalogo/page02_img01.jpeg', 'Modelo 22 Sofa 2 cuerpos Tapisur', 1, 1),
  (3, '/img/catalogo/page05_img02.jpeg', 'Sillon individual Tapisur', 1, 1),
  (4, '/img/catalogo/page03_img01.jpeg', 'Chesterfield 3 cuerpos Tapisur', 1, 1),
  (5, '/img/catalogo/page03_img01.jpeg', 'Chesterfield 2 cuerpos Tapisur', 1, 1),
  (6, '/img/catalogo/page06_img01.jpeg', 'Chesterfield sofa cama Tapisur', 1, 1),
  (7, '/img/catalogo/page04_img01.jpeg', 'Rinconero con camastro Tapisur', 1, 1),
  (8, '/img/catalogo/page04_img02.jpeg', 'Rinconero clasico Tapisur', 1, 1),
  (9, '/img/catalogo/page08_img01.jpeg', 'Baul tapizado Tapisur', 1, 1),
  (10, '/img/catalogo/page09_img01.jpeg', 'Respaldo sommier capitone Tapisur', 1, 1);

INSERT INTO telas (id_tela, nombre, descripcion, orden) VALUES
  (1, 'Chenille', 'Tela suave y resistente para uso diario.', 10),
  (2, 'Pana', 'Textura marcada y terminacion calida.', 20),
  (3, 'Cuerina', 'Material facil de limpiar y de acabado moderno.', 30),
  (4, 'Boucle', 'Textura tendencia para piezas decorativas.', 40);

INSERT INTO colores (id_color, nombre, codigo_hex, orden) VALUES
  (1, 'Beige', '#D8C6AD', 10),
  (2, 'Gris claro', '#B9B8B2', 20),
  (3, 'Oliva', '#6F7A55', 30),
  (4, 'Grafito', '#4B4B4B', 40),
  (5, 'Arena', '#C9B79C', 50),
  (6, 'Tierra', '#8B6A4F', 60),
  (7, 'Negro', '#1E1E1E', 70),
  (8, 'Suela', '#9B5B32', 80),
  (9, 'Verde ingles', '#2E4B34', 90),
  (10, 'Crema', '#EFE2C6', 100);

INSERT INTO tela_colores (id_tela_color, id_tela, id_color, codigo_proveedor, orden) VALUES
  (1, 1, 1, 'CH-BEI', 10),
  (2, 1, 2, 'CH-GCL', 20),
  (3, 1, 3, 'CH-OLI', 30),
  (4, 1, 4, 'CH-GRA', 40),
  (5, 2, 5, 'PA-ARE', 10),
  (6, 2, 6, 'PA-TIE', 20),
  (7, 2, 9, 'PA-VEI', 30),
  (8, 3, 7, 'CU-NEG', 10),
  (9, 3, 8, 'CU-SUE', 20),
  (10, 3, 10, 'CU-CRE', 30),
  (11, 4, 1, 'BO-BEI', 10),
  (12, 4, 10, 'BO-CRE', 20);

-- Productos con combinaciones permitidas de tela/color.
INSERT INTO producto_tela_colores (id_producto, id_tela_color, destacado) VALUES
  (1, 1, 1), (1, 2, 0), (1, 3, 1), (1, 4, 0), (1, 5, 0), (1, 8, 0),
  (2, 1, 1), (2, 2, 0), (2, 5, 0), (2, 6, 0),
  (3, 1, 1), (3, 6, 0), (3, 11, 1), (3, 12, 0),
  (4, 5, 0), (4, 7, 1), (4, 8, 0), (4, 9, 1),
  (5, 5, 0), (5, 8, 1), (5, 10, 0),
  (6, 5, 0), (6, 8, 1), (6, 9, 0),
  (7, 1, 1), (7, 2, 0), (7, 3, 1), (7, 8, 0),
  (8, 1, 0), (8, 2, 1), (8, 4, 0),
  (9, 1, 0), (9, 5, 1), (9, 8, 0),
  (10, 5, 1), (10, 6, 0), (10, 11, 0);

INSERT INTO producto_medidas (id_producto, descripcion, ancho_cm, profundidad_cm, alto_cm, orden) VALUES
  (1, '2.10 x 0.85 m', 210, 85, 85, 10),
  (1, '2.30 x 0.90 m', 230, 90, 85, 20),
  (1, 'Personalizada', NULL, NULL, NULL, 30),
  (2, '1.60 x 0.85 m', 160, 85, 85, 10),
  (2, '1.80 x 0.90 m', 180, 90, 85, 20),
  (3, '0.90 x 0.80 m', 90, 80, 85, 10),
  (4, '2.15 x 0.90 m', 215, 90, 82, 10),
  (5, '1.75 x 0.90 m', 175, 90, 82, 10),
  (6, '2.10 x 0.90 m', 210, 90, 82, 10),
  (7, '2.60 x 1.65 m', 260, 165, 85, 10),
  (8, '2.40 x 1.60 m', 240, 160, 85, 10),
  (9, '1.00 x 0.45 m', 100, 45, 45, 10),
  (10, '1.40 x 1.20 m', 140, 8, 120, 10);

INSERT INTO producto_caracteristicas (id_producto, nombre, orden) VALUES
  (1, 'A medida', 10), (1, 'Estructura reforzada', 20),
  (2, 'A medida', 10), (2, 'Compacto', 20),
  (3, 'A medida', 10), (3, 'Individual', 20),
  (4, 'Capitone', 10), (4, 'A medida', 20),
  (5, 'Capitone', 10), (5, 'A medida', 20),
  (6, 'Con cama', 10), (6, 'Capitone', 20), (6, 'A medida', 30),
  (7, 'Con camastro', 10), (7, 'A medida', 20),
  (8, 'A medida', 10),
  (9, 'Guardado extra', 10), (9, 'A medida', 20),
  (10, 'Capitone', 10), (10, 'A medida', 20);

INSERT INTO categorias_servicio (id_categoria_servicio, nombre, descripcion) VALUES
  (1, 'Retapizado', 'Renovacion de tapizados existentes.'),
  (2, 'Reparacion', 'Arreglos de estructura y soporte.'),
  (3, 'Restauracion', 'Recuperacion y puesta en valor.'),
  (4, 'Fabricacion a medida', 'Desarrollo de piezas nuevas.');

INSERT INTO servicios (id_servicio, id_categoria_servicio, nombre, descripcion, destacado) VALUES
  (1, 1, 'Retapizado de sillones', 'Renovacion completa de sillones con eleccion de tela y color.', 1),
  (2, 2, 'Reparacion estructural', 'Arreglo de estructura, patas, bases y soportes internos.', 1),
  (3, 3, 'Restauracion de muebles', 'Recuperacion de piezas con historia y valor sentimental.', 0),
  (4, 4, 'Fabricacion personalizada', 'Sillones, respaldos, baules y piezas a medida.', 1);

INSERT INTO clientes (id_cliente, nombre, telefono, email, direccion, origen, notas) VALUES
  (1, 'Cliente Demo Particular', '11 5555-1111', 'cliente.demo@mail.local', 'Lanus Este', 'web', 'Cliente de prueba.'),
  (2, 'Estudio Interiorismo Demo', '11 5555-2222', 'estudio.demo@mail.local', 'CABA', 'instagram', 'Consulta por alianzas.');

INSERT INTO ventas (id_venta, id_cliente, id_usuario, fecha, estado, total, notas) VALUES
  (1, 1, 1, CURRENT_DATE, 'presupuesto', 0, 'Presupuesto demo sin precio cerrado.');

INSERT INTO venta_detalles (id_venta, id_producto, descripcion, cantidad, precio_unitario, subtotal) VALUES
  (1, 1, 'Modelo 22 - Sofa 3 cuerpos en Chenille Beige', 1, 0, 0);

INSERT INTO contenidos_sitio (clave, valor, tipo, descripcion) VALUES
  ('phone_1', '11 5110-3419', 'telefono', 'Telefono principal'),
  ('phone_2', '11 6767-5200', 'telefono', 'Telefono secundario'),
  ('whatsapp_number', '5491151103419', 'telefono', 'Numero para enlaces de WhatsApp'),
  ('address', 'Juan Esteban Pedernera 1462, Lanus Este, Buenos Aires', 'texto', 'Direccion del local'),
  ('instagram_url', 'https://www.instagram.com/tapisur_/', 'url', 'Instagram oficial');

