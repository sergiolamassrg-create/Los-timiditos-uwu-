-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 25-06-2026 a las 20:15:00
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `db_tapisur`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias_producto`
--

CREATE TABLE `categorias_producto` (
  `id_categoria_producto` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `descripcion` varchar(255) DEFAULT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT 1,
  `creado_en` datetime NOT NULL DEFAULT current_timestamp(),
  `actualizado_en` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `categorias_producto`
--

INSERT INTO `categorias_producto` (`id_categoria_producto`, `nombre`, `descripcion`, `activo`, `creado_en`, `actualizado_en`) VALUES
(1, 'Sofas', 'Sillones de dos o mas cuerpos.', 1, '2026-06-14 06:33:47', NULL),
(2, 'Chesterfield', 'Modelos capitone clasicos.', 1, '2026-06-14 06:33:47', NULL),
(3, 'Rinconeros', 'Sillones en L y esquineros.', 1, '2026-06-14 06:33:47', NULL),
(4, 'Sillones cama', 'Modelos con funcion de cama.', 1, '2026-06-14 06:33:47', NULL),
(5, 'Individuales', 'Sillones de un cuerpo.', 1, '2026-06-14 06:33:47', NULL),
(6, 'Baules', 'Baules tapizados.', 1, '2026-06-14 06:33:47', NULL),
(7, 'Respaldos', 'Respaldos para sommier y cama.', 1, '2026-06-14 06:33:47', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias_servicio`
--

CREATE TABLE `categorias_servicio` (
  `id_categoria_servicio` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `descripcion` varchar(255) DEFAULT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT 1,
  `creado_en` datetime NOT NULL DEFAULT current_timestamp(),
  `actualizado_en` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `categorias_servicio`
--

INSERT INTO `categorias_servicio` (`id_categoria_servicio`, `nombre`, `descripcion`, `activo`, `creado_en`, `actualizado_en`) VALUES
(1, 'Retapizado', 'Renovacion de tapizados existentes.', 1, '2026-06-14 06:33:48', NULL),
(2, 'Reparacion', 'Arreglos de estructura y soporte.', 1, '2026-06-14 06:33:48', NULL),
(3, 'Restauracion', 'Recuperacion y puesta en valor.', 1, '2026-06-14 06:33:48', NULL),
(4, 'Fabricacion a medida', 'Desarrollo de piezas nuevas.', 1, '2026-06-14 06:33:48', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE `clientes` (
  `id_cliente` int(11) NOT NULL,
  `nombre` varchar(140) NOT NULL,
  `telefono` varchar(40) NOT NULL,
  `email` varchar(160) DEFAULT NULL,
  `direccion` varchar(200) DEFAULT NULL,
  `origen` varchar(60) DEFAULT NULL,
  `notas` text DEFAULT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT 1,
  `creado_en` datetime NOT NULL DEFAULT current_timestamp(),
  `actualizado_en` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `clientes`
--

INSERT INTO `clientes` (`id_cliente`, `nombre`, `telefono`, `email`, `direccion`, `origen`, `notas`, `activo`, `creado_en`, `actualizado_en`) VALUES
(1, 'Cliente Demo Particular', '11 5555-1111', 'cliente.demo@mail.local', 'Lanus Este', 'web', 'Cliente de prueba.', 1, '2026-06-14 06:33:48', NULL),
(2, 'Estudio Interiorismo Demo', '11 5555-2222', 'estudio.demo@mail.local', 'CABA', 'instagram', 'Consulta por alianzas.', 1, '2026-06-14 06:33:48', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `colores`
--

CREATE TABLE `colores` (
  `id_color` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `codigo_hex` char(7) DEFAULT NULL,
  `orden` int(11) NOT NULL DEFAULT 0,
  `activo` tinyint(1) NOT NULL DEFAULT 1,
  `creado_en` datetime NOT NULL DEFAULT current_timestamp(),
  `actualizado_en` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ;

--
-- Volcado de datos para la tabla `colores`
--

INSERT INTO `colores` (`id_color`, `nombre`, `codigo_hex`, `orden`, `activo`, `creado_en`, `actualizado_en`) VALUES
(1, 'Beige', '#D8C6AD', 10, 1, '2026-06-14 06:33:48', NULL),
(2, 'Gris claro', '#B9B8B2', 20, 1, '2026-06-14 06:33:48', NULL),
(3, 'Oliva', '#6F7A55', 30, 1, '2026-06-14 06:33:48', NULL),
(4, 'Grafito', '#4B4B4B', 40, 1, '2026-06-14 06:33:48', NULL),
(5, 'Arena', '#C9B79C', 50, 1, '2026-06-14 06:33:48', NULL),
(6, 'Tierra', '#8B6A4F', 60, 1, '2026-06-14 06:33:48', NULL),
(7, 'Negro', '#1E1E1E', 70, 1, '2026-06-14 06:33:48', NULL),
(8, 'Suela', '#9B5B32', 80, 1, '2026-06-14 06:33:48', NULL),
(9, 'Verde ingles', '#2E4B34', 90, 1, '2026-06-14 06:33:48', NULL),
(10, 'Crema', '#EFE2C6', 100, 1, '2026-06-14 06:33:48', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `contenidos_sitio`
--

CREATE TABLE `contenidos_sitio` (
  `id_contenido` int(11) NOT NULL,
  `clave` varchar(100) NOT NULL,
  `valor` text NOT NULL,
  `tipo` varchar(40) NOT NULL DEFAULT 'texto',
  `descripcion` varchar(255) DEFAULT NULL,
  `publico` tinyint(1) NOT NULL DEFAULT 1,
  `creado_en` datetime NOT NULL DEFAULT current_timestamp(),
  `actualizado_en` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `contenidos_sitio`
--

INSERT INTO `contenidos_sitio` (`id_contenido`, `clave`, `valor`, `tipo`, `descripcion`, `publico`, `creado_en`, `actualizado_en`) VALUES
(1, 'phone_1', '11 5110-3419', 'telefono', 'Telefono principal visible', 1, '2026-06-14 06:33:48', '2026-06-20 01:40:13'),
(2, 'phone_2', '11 6767-5200', 'telefono', 'Telefono secundario visible', 1, '2026-06-14 06:33:48', '2026-06-20 01:40:13'),
(3, 'whatsapp_number', '5491151103419', 'telefono', 'Numero destino para enlaces de WhatsApp', 1, '2026-06-14 06:33:48', '2026-06-20 01:40:13'),
(4, 'address', 'Juan Esteban Pedernera 1462, Lanus Este, Buenos Aires', 'texto', 'Direccion comercial', 1, '2026-06-14 06:33:48', '2026-06-20 01:40:13'),
(5, 'instagram_url', 'https://www.instagram.com/tapisur_/', 'url', 'URL del perfil de Instagram', 1, '2026-06-14 06:33:48', '2026-06-20 01:40:13'),
(6, 'site_name', 'Tapisur', 'texto', 'Nombre comercial visible del sitio', 1, '2026-06-20 01:40:13', NULL),
(7, 'contact_email', 'sergio_lamas_93@hotmail.com', 'email', 'Email principal de contacto', 1, '2026-06-20 01:40:13', NULL),
(8, 'business_hours_weekdays', 'Lunes a Viernes 9:00 a 18:00 hs', 'texto', 'Horario de atencion de lunes a viernes', 1, '2026-06-20 01:40:13', NULL),
(9, 'business_hours_saturday', 'Sabados 9:00 a 13:00 hs', 'texto', 'Horario de atencion de sabados', 1, '2026-06-20 01:40:13', NULL),
(10, 'timezone', 'America/Argentina/Buenos_Aires', 'texto', 'Zona horaria de reportes y estadisticas', 1, '2026-06-20 01:40:13', NULL),
(11, 'meta_title', 'Tapisur | Sillones y muebles a medida', 'texto', 'Titulo SEO principal', 1, '2026-06-20 01:40:13', NULL),
(12, 'meta_description', 'Tapisur fabrica sillones, muebles a medida, retapizados y restauraciones en Buenos Aires.', 'textarea', 'Descripcion SEO principal', 1, '2026-06-20 01:40:13', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `interacciones`
--

CREATE TABLE `interacciones` (
  `id_interaccion` int(11) NOT NULL,
  `id_cliente` int(11) DEFAULT NULL,
  `id_producto` int(11) DEFAULT NULL,
  `id_servicio` int(11) DEFAULT NULL,
  `canal` enum('web','whatsapp','telefono','instagram','local','otro') NOT NULL DEFAULT 'web',
  `estado` enum('nueva','contactada','presupuestada','cerrada','descartada') NOT NULL DEFAULT 'nueva',
  `nombre_contacto` varchar(140) DEFAULT NULL,
  `telefono_contacto` varchar(40) DEFAULT NULL,
  `mensaje` text DEFAULT NULL,
  `pagina_origen` varchar(120) DEFAULT NULL,
  `creado_en` datetime NOT NULL DEFAULT current_timestamp(),
  `actualizado_en` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id_producto` int(11) NOT NULL,
  `id_categoria_producto` int(11) NOT NULL,
  `nombre` varchar(140) NOT NULL,
  `descripcion` text NOT NULL,
  `capacidad` int(11) NOT NULL DEFAULT 0,
  `destacado` tinyint(1) NOT NULL DEFAULT 0,
  `activo` tinyint(1) NOT NULL DEFAULT 1,
  `creado_en` datetime NOT NULL DEFAULT current_timestamp(),
  `actualizado_en` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id_producto`, `id_categoria_producto`, `nombre`, `descripcion`, `capacidad`, `destacado`, `activo`, `creado_en`, `actualizado_en`) VALUES
(1, 1, 'Modelo 22 - Sofa 3 cuerpos', 'Sofa amplio para living principal, fabricado a medida y con excelente confort diario.', 3, 1, 1, '2026-06-14 06:33:48', NULL),
(2, 1, 'Modelo 22 - Sofa 2 cuerpos', 'Version compacta del Modelo 22 para departamentos y ambientes reducidos.', 2, 1, 1, '2026-06-14 06:33:48', NULL),
(3, 5, 'Modelo 22 - Sillon individual', 'Sillon de apoyo ideal para completar juegos de living.', 1, 0, 1, '2026-06-14 06:33:48', NULL),
(4, 2, 'Chesterfield - Sofa 3 cuerpos', 'Estilo clasico con fuerte presencia y terminacion capitone.', 3, 1, 1, '2026-06-14 06:33:48', '2026-06-21 05:20:49'),
(5, 2, 'Chesterfield - Sofa 2 cuerpos', 'Version de dos cuerpos del Chesterfield con terminaciones de alta calidad.', 2, 0, 1, '2026-06-14 06:33:48', NULL),
(6, 4, 'Chesterfield - Sofa cama 3 cuerpos', 'Solucion premium de doble funcion: living y descanso.', 3, 1, 1, '2026-06-14 06:33:48', NULL),
(7, 3, 'Rinconero 3 cuerpos con camastro', 'Gran capacidad para familias y espacios integrados.', 4, 1, 1, '2026-06-14 06:33:48', NULL),
(8, 3, 'Rinconero clasico', 'Configuracion rinconera adaptable al ambiente.', 4, 0, 1, '2026-06-14 06:33:48', NULL),
(9, 6, 'Baul tapizado 1.00', 'Baul amplio para guardar mantas, almohadones y objetos del living.', 0, 1, 1, '2026-06-14 06:33:48', '2026-06-21 05:20:47'),
(10, 7, 'Respaldo sommier capitone', 'Respaldo tapizado para cama con terminacion elegante.', 0, 1, 1, '2026-06-14 06:33:48', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto_caracteristicas`
--

CREATE TABLE `producto_caracteristicas` (
  `id_caracteristica` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `nombre` varchar(120) NOT NULL,
  `orden` int(11) NOT NULL DEFAULT 0,
  `activo` tinyint(1) NOT NULL DEFAULT 1,
  `creado_en` datetime NOT NULL DEFAULT current_timestamp(),
  `actualizado_en` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `producto_caracteristicas`
--

INSERT INTO `producto_caracteristicas` (`id_caracteristica`, `id_producto`, `nombre`, `orden`, `activo`, `creado_en`, `actualizado_en`) VALUES
(1, 1, 'A medida', 10, 1, '2026-06-14 06:33:48', NULL),
(2, 1, 'Estructura reforzada', 20, 1, '2026-06-14 06:33:48', NULL),
(3, 2, 'A medida', 10, 1, '2026-06-14 06:33:48', NULL),
(4, 2, 'Compacto', 20, 1, '2026-06-14 06:33:48', NULL),
(5, 3, 'A medida', 10, 1, '2026-06-14 06:33:48', NULL),
(6, 3, 'Individual', 20, 1, '2026-06-14 06:33:48', NULL),
(7, 4, 'Capitone', 10, 1, '2026-06-14 06:33:48', NULL),
(8, 4, 'A medida', 20, 1, '2026-06-14 06:33:48', NULL),
(9, 5, 'Capitone', 10, 1, '2026-06-14 06:33:48', NULL),
(10, 5, 'A medida', 20, 1, '2026-06-14 06:33:48', NULL),
(11, 6, 'Con cama', 10, 1, '2026-06-14 06:33:48', NULL),
(12, 6, 'Capitone', 20, 1, '2026-06-14 06:33:48', NULL),
(13, 6, 'A medida', 30, 1, '2026-06-14 06:33:48', NULL),
(14, 7, 'Con camastro', 10, 1, '2026-06-14 06:33:48', NULL),
(15, 7, 'A medida', 20, 1, '2026-06-14 06:33:48', NULL),
(16, 8, 'A medida', 10, 1, '2026-06-14 06:33:48', NULL),
(17, 9, 'Guardado extra', 10, 1, '2026-06-14 06:33:48', NULL),
(18, 9, 'A medida', 20, 1, '2026-06-14 06:33:48', NULL),
(19, 10, 'Capitone', 10, 1, '2026-06-14 06:33:48', NULL),
(20, 10, 'A medida', 20, 1, '2026-06-14 06:33:48', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto_imagenes`
--

CREATE TABLE `producto_imagenes` (
  `id_imagen` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `ruta` varchar(255) NOT NULL,
  `texto_alt` varchar(180) DEFAULT NULL,
  `orden` int(11) NOT NULL DEFAULT 0,
  `principal` tinyint(1) NOT NULL DEFAULT 0,
  `activo` tinyint(1) NOT NULL DEFAULT 1,
  `creado_en` datetime NOT NULL DEFAULT current_timestamp(),
  `actualizado_en` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ;

--
-- Volcado de datos para la tabla `producto_imagenes`
--

INSERT INTO `producto_imagenes` (`id_imagen`, `id_producto`, `ruta`, `texto_alt`, `orden`, `principal`, `activo`, `creado_en`, `actualizado_en`) VALUES
(1, 1, '/img/catalogo/page02_img01.jpeg', 'Modelo 22 Sofa 3 cuerpos Tapisur', 1, 1, 1, '2026-06-14 06:33:48', NULL),
(2, 2, '/img/catalogo/page02_img01.jpeg', 'Modelo 22 Sofa 2 cuerpos Tapisur', 1, 1, 1, '2026-06-14 06:33:48', NULL),
(3, 3, '/img/catalogo/page05_img02.jpeg', 'Sillon individual Tapisur', 1, 1, 1, '2026-06-14 06:33:48', NULL),
(4, 4, '/img/catalogo/page03_img01.jpeg', 'Chesterfield 3 cuerpos Tapisur', 1, 1, 1, '2026-06-14 06:33:48', NULL),
(5, 5, '/img/catalogo/page03_img01.jpeg', 'Chesterfield 2 cuerpos Tapisur', 1, 1, 1, '2026-06-14 06:33:48', NULL),
(6, 6, '/img/catalogo/page06_img01.jpeg', 'Chesterfield sofa cama Tapisur', 1, 1, 1, '2026-06-14 06:33:48', NULL),
(7, 7, '/img/catalogo/page04_img01.jpeg', 'Rinconero con camastro Tapisur', 1, 1, 1, '2026-06-14 06:33:48', NULL),
(8, 8, '/img/catalogo/page04_img02.jpeg', 'Rinconero clasico Tapisur', 1, 1, 1, '2026-06-14 06:33:48', NULL),
(9, 9, '/img/catalogo/page08_img01.jpeg', 'Baul tapizado Tapisur', 1, 1, 1, '2026-06-14 06:33:48', NULL),
(10, 10, '/img/catalogo/page09_img01.jpeg', 'Respaldo sommier capitone Tapisur', 1, 1, 1, '2026-06-14 06:33:48', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto_medidas`
--

CREATE TABLE `producto_medidas` (
  `id_medida` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `descripcion` varchar(120) NOT NULL,
  `ancho_cm` decimal(8,2) DEFAULT NULL,
  `profundidad_cm` decimal(8,2) DEFAULT NULL,
  `alto_cm` decimal(8,2) DEFAULT NULL,
  `orden` int(11) NOT NULL DEFAULT 0,
  `activo` tinyint(1) NOT NULL DEFAULT 1,
  `creado_en` datetime NOT NULL DEFAULT current_timestamp(),
  `actualizado_en` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `producto_medidas`
--

INSERT INTO `producto_medidas` (`id_medida`, `id_producto`, `descripcion`, `ancho_cm`, `profundidad_cm`, `alto_cm`, `orden`, `activo`, `creado_en`, `actualizado_en`) VALUES
(1, 1, '2.10 x 0.85 m', 210.00, 85.00, 85.00, 10, 1, '2026-06-14 06:33:48', NULL),
(2, 1, '2.30 x 0.90 m', 230.00, 90.00, 85.00, 20, 1, '2026-06-14 06:33:48', NULL),
(3, 1, 'Personalizada', NULL, NULL, NULL, 30, 1, '2026-06-14 06:33:48', NULL),
(4, 2, '1.60 x 0.85 m', 160.00, 85.00, 85.00, 10, 1, '2026-06-14 06:33:48', NULL),
(5, 2, '1.80 x 0.90 m', 180.00, 90.00, 85.00, 20, 1, '2026-06-14 06:33:48', NULL),
(6, 3, '0.90 x 0.80 m', 90.00, 80.00, 85.00, 10, 1, '2026-06-14 06:33:48', NULL),
(7, 4, '2.15 x 0.90 m', 215.00, 90.00, 82.00, 10, 1, '2026-06-14 06:33:48', NULL),
(8, 5, '1.75 x 0.90 m', 175.00, 90.00, 82.00, 10, 1, '2026-06-14 06:33:48', NULL),
(9, 6, '2.10 x 0.90 m', 210.00, 90.00, 82.00, 10, 1, '2026-06-14 06:33:48', NULL),
(10, 7, '2.60 x 1.65 m', 260.00, 165.00, 85.00, 10, 1, '2026-06-14 06:33:48', NULL),
(11, 8, '2.40 x 1.60 m', 240.00, 160.00, 85.00, 10, 1, '2026-06-14 06:33:48', NULL),
(12, 9, '1.00 x 0.45 m', 100.00, 45.00, 45.00, 10, 1, '2026-06-14 06:33:48', NULL),
(13, 10, '1.40 x 1.20 m', 140.00, 8.00, 120.00, 10, 1, '2026-06-14 06:33:48', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto_tela_colores`
--

CREATE TABLE `producto_tela_colores` (
  `id_producto` int(11) NOT NULL,
  `id_tela_color` int(11) NOT NULL,
  `destacado` tinyint(1) NOT NULL DEFAULT 0,
  `activo` tinyint(1) NOT NULL DEFAULT 1,
  `creado_en` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `producto_tela_colores`
--

INSERT INTO `producto_tela_colores` (`id_producto`, `id_tela_color`, `destacado`, `activo`, `creado_en`) VALUES
(1, 1, 1, 1, '2026-06-14 06:33:48'),
(1, 2, 0, 1, '2026-06-14 06:33:48'),
(1, 3, 1, 1, '2026-06-14 06:33:48'),
(1, 4, 0, 1, '2026-06-14 06:33:48'),
(1, 5, 0, 1, '2026-06-14 06:33:48'),
(1, 8, 0, 1, '2026-06-14 06:33:48'),
(2, 1, 1, 1, '2026-06-14 06:33:48'),
(2, 2, 0, 1, '2026-06-14 06:33:48'),
(2, 5, 0, 1, '2026-06-14 06:33:48'),
(2, 6, 0, 1, '2026-06-14 06:33:48'),
(3, 1, 1, 1, '2026-06-14 06:33:48'),
(3, 6, 0, 1, '2026-06-14 06:33:48'),
(3, 11, 1, 1, '2026-06-14 06:33:48'),
(3, 12, 0, 1, '2026-06-14 06:33:48'),
(4, 5, 0, 1, '2026-06-14 06:33:48'),
(4, 7, 1, 1, '2026-06-14 06:33:48'),
(4, 8, 0, 1, '2026-06-14 06:33:48'),
(4, 9, 1, 1, '2026-06-14 06:33:48'),
(5, 5, 0, 1, '2026-06-14 06:33:48'),
(5, 8, 1, 1, '2026-06-14 06:33:48'),
(5, 10, 0, 1, '2026-06-14 06:33:48'),
(6, 5, 0, 1, '2026-06-14 06:33:48'),
(6, 8, 1, 1, '2026-06-14 06:33:48'),
(6, 9, 0, 1, '2026-06-14 06:33:48'),
(7, 1, 1, 1, '2026-06-14 06:33:48'),
(7, 2, 0, 1, '2026-06-14 06:33:48'),
(7, 3, 1, 1, '2026-06-14 06:33:48'),
(7, 8, 0, 1, '2026-06-14 06:33:48'),
(8, 1, 0, 1, '2026-06-14 06:33:48'),
(8, 2, 1, 1, '2026-06-14 06:33:48'),
(8, 4, 0, 1, '2026-06-14 06:33:48'),
(9, 1, 0, 1, '2026-06-14 06:33:48'),
(9, 5, 1, 1, '2026-06-14 06:33:48'),
(9, 8, 0, 1, '2026-06-14 06:33:48'),
(10, 5, 1, 1, '2026-06-14 06:33:48'),
(10, 6, 0, 1, '2026-06-14 06:33:48'),
(10, 11, 0, 1, '2026-06-14 06:33:48');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `id_rol` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `descripcion` varchar(255) DEFAULT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT 1,
  `creado_en` datetime NOT NULL DEFAULT current_timestamp(),
  `actualizado_en` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`id_rol`, `nombre`, `descripcion`, `activo`, `creado_en`, `actualizado_en`) VALUES
(1, 'administrador', 'Acceso completo al panel.', 1, '2026-06-14 06:33:47', NULL),
(2, 'vendedor', 'Gestion comercial y consultas.', 1, '2026-06-14 06:33:47', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `servicios`
--

CREATE TABLE `servicios` (
  `id_servicio` int(11) NOT NULL,
  `id_categoria_servicio` int(11) NOT NULL,
  `nombre` varchar(140) NOT NULL,
  `descripcion` text NOT NULL,
  `destacado` tinyint(1) NOT NULL DEFAULT 0,
  `activo` tinyint(1) NOT NULL DEFAULT 1,
  `creado_en` datetime NOT NULL DEFAULT current_timestamp(),
  `actualizado_en` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `servicios`
--

INSERT INTO `servicios` (`id_servicio`, `id_categoria_servicio`, `nombre`, `descripcion`, `destacado`, `activo`, `creado_en`, `actualizado_en`) VALUES
(1, 1, 'Retapizado de sillones', 'Renovacion completa de sillones con eleccion de tela y color.', 1, 1, '2026-06-14 06:33:48', NULL),
(2, 2, 'Reparacion estructural', 'Arreglo de estructura, patas, bases y soportes internos.', 1, 1, '2026-06-14 06:33:48', NULL),
(3, 3, 'Restauracion de muebles', 'Recuperacion de piezas con historia y valor sentimental.', 0, 1, '2026-06-14 06:33:48', NULL),
(4, 4, 'Fabricacion personalizada', 'Sillones, respaldos, baules y piezas a medida.', 1, 1, '2026-06-14 06:33:48', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `servicio_imagenes`
--

CREATE TABLE `servicio_imagenes` (
  `id_imagen` int(11) NOT NULL,
  `id_servicio` int(11) NOT NULL,
  `ruta` varchar(255) NOT NULL,
  `texto_alt` varchar(180) DEFAULT NULL,
  `orden` int(11) NOT NULL DEFAULT 0,
  `principal` tinyint(1) NOT NULL DEFAULT 0,
  `activo` tinyint(1) NOT NULL DEFAULT 1,
  `creado_en` datetime NOT NULL DEFAULT current_timestamp(),
  `actualizado_en` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `telas`
--

CREATE TABLE `telas` (
  `id_tela` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `descripcion` varchar(255) DEFAULT NULL,
  `orden` int(11) NOT NULL DEFAULT 0,
  `activo` tinyint(1) NOT NULL DEFAULT 1,
  `creado_en` datetime NOT NULL DEFAULT current_timestamp(),
  `actualizado_en` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `telas`
--

INSERT INTO `telas` (`id_tela`, `nombre`, `descripcion`, `orden`, `activo`, `creado_en`, `actualizado_en`) VALUES
(1, 'Chenille', 'Tela suave y resistente para uso diario.', 10, 1, '2026-06-14 06:33:48', NULL),
(2, 'Pana', 'Textura marcada y terminacion calida.', 20, 1, '2026-06-14 06:33:48', NULL),
(3, 'Cuerina', 'Material facil de limpiar y de acabado moderno.', 30, 1, '2026-06-14 06:33:48', NULL),
(4, 'Boucle', 'Textura tendencia para piezas decorativas.', 40, 1, '2026-06-14 06:33:48', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tela_colores`
--

CREATE TABLE `tela_colores` (
  `id_tela_color` int(11) NOT NULL,
  `id_tela` int(11) NOT NULL,
  `id_color` int(11) NOT NULL,
  `codigo_proveedor` varchar(80) DEFAULT NULL,
  `disponible` tinyint(1) NOT NULL DEFAULT 1,
  `orden` int(11) NOT NULL DEFAULT 0,
  `creado_en` datetime NOT NULL DEFAULT current_timestamp(),
  `actualizado_en` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `tela_colores`
--

INSERT INTO `tela_colores` (`id_tela_color`, `id_tela`, `id_color`, `codigo_proveedor`, `disponible`, `orden`, `creado_en`, `actualizado_en`) VALUES
(1, 1, 1, 'CH-BEI', 0, 10, '2026-06-14 06:33:48', '2026-06-19 22:00:54'),
(2, 1, 2, 'CH-GCL', 1, 20, '2026-06-14 06:33:48', NULL),
(3, 1, 3, 'CH-OLI', 1, 30, '2026-06-14 06:33:48', NULL),
(4, 1, 4, 'CH-GRA', 1, 40, '2026-06-14 06:33:48', NULL),
(5, 2, 5, 'PA-ARE', 1, 10, '2026-06-14 06:33:48', NULL),
(6, 2, 6, 'PA-TIE', 1, 20, '2026-06-14 06:33:48', NULL),
(7, 2, 9, 'PA-VEI', 1, 30, '2026-06-14 06:33:48', NULL),
(8, 3, 7, 'CU-NEG', 1, 10, '2026-06-14 06:33:48', NULL),
(9, 3, 8, 'CU-SUE', 1, 20, '2026-06-14 06:33:48', NULL),
(10, 3, 10, 'CU-CRE', 1, 30, '2026-06-14 06:33:48', NULL),
(11, 4, 1, 'BO-BEI', 1, 10, '2026-06-14 06:33:48', NULL),
(12, 4, 10, 'BO-CRE', 1, 20, '2026-06-14 06:33:48', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usuario` int(11) NOT NULL,
  `id_rol` int(11) NOT NULL,
  `nombre` varchar(120) NOT NULL,
  `email` varchar(160) NOT NULL,
  `usuario` varchar(80) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT 1,
  `creado_en` datetime NOT NULL DEFAULT current_timestamp(),
  `actualizado_en` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `id_rol`, `nombre`, `email`, `usuario`, `password_hash`, `activo`, `creado_en`, `actualizado_en`) VALUES
(1, 1, 'Administrador Tapisur', 'admin@tapisur.local', 'admin', '$2y$10$6TWbZZV9kbmlXesC9Ir4CuWiO1MBi4gDKKWA4Ro1SJcRS3FX2EnwG', 1, '2026-06-14 06:33:47', '2026-06-20 02:33:40'),
(2, 2, 'Vendedor Demo', 'vendedor@tapisur.local', 'vendedor', '$2y$10$Q4d9vM3fYqXf4m3kN9LrYOwByNnqS.rnpeAq58oPGr.8UIuJXx3va', 1, '2026-06-14 06:33:47', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ventas`
--

CREATE TABLE `ventas` (
  `id_venta` int(11) NOT NULL,
  `id_cliente` int(11) DEFAULT NULL,
  `id_usuario` int(11) DEFAULT NULL,
  `fecha` date NOT NULL,
  `estado` enum('presupuesto','confirmada','entregada','cancelada') NOT NULL DEFAULT 'presupuesto',
  `total` decimal(12,2) NOT NULL DEFAULT 0.00,
  `notas` text DEFAULT NULL,
  `creado_en` datetime NOT NULL DEFAULT current_timestamp(),
  `actualizado_en` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `ventas`
--

INSERT INTO `ventas` (`id_venta`, `id_cliente`, `id_usuario`, `fecha`, `estado`, `total`, `notas`, `creado_en`, `actualizado_en`) VALUES
(1, 1, 1, '2026-06-14', 'presupuesto', 0.00, 'Presupuesto demo sin precio cerrado.', '2026-06-14 06:33:48', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `venta_detalles`
--

CREATE TABLE `venta_detalles` (
  `id_detalle` int(11) NOT NULL,
  `id_venta` int(11) NOT NULL,
  `id_producto` int(11) DEFAULT NULL,
  `id_servicio` int(11) DEFAULT NULL,
  `descripcion` varchar(180) NOT NULL,
  `cantidad` int(11) NOT NULL DEFAULT 1,
  `precio_unitario` decimal(12,2) NOT NULL DEFAULT 0.00,
  `subtotal` decimal(12,2) NOT NULL DEFAULT 0.00,
  `creado_en` datetime NOT NULL DEFAULT current_timestamp()
) ;

--
-- Volcado de datos para la tabla `venta_detalles`
--

INSERT INTO `venta_detalles` (`id_detalle`, `id_venta`, `id_producto`, `id_servicio`, `descripcion`, `cantidad`, `precio_unitario`, `subtotal`, `creado_en`) VALUES
(1, 1, 1, NULL, 'Modelo 22 - Sofa 3 cuerpos en Chenille Beige', 1, 0.00, 0.00, '2026-06-14 06:33:48');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `visitas_sitio`
--

CREATE TABLE `visitas_sitio` (
  `id_visita` int(11) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `pagina` varchar(160) NOT NULL,
  `user_agent` varchar(255) DEFAULT NULL,
  `pais` varchar(80) DEFAULT NULL,
  `region` varchar(120) DEFAULT NULL,
  `ciudad` varchar(120) DEFAULT NULL,
  `fecha_ingreso` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `visitas_sitio`
--

INSERT INTO `visitas_sitio` (`id_visita`, `ip_address`, `pagina`, `user_agent`, `pais`, `region`, `ciudad`, `fecha_ingreso`) VALUES
(1, '::1', 'inicio', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'Local', 'Buenos Aires', 'Local', '2026-06-20 02:29:00'),
(2, '::1', 'catalogo', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'Local', 'Buenos Aires', 'Local', '2026-06-20 02:29:19'),
(3, '::1', 'servicios', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'Local', 'Buenos Aires', 'Local', '2026-06-20 02:29:23'),
(4, '::1', 'nosotros', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'Local', 'Buenos Aires', 'Local', '2026-06-20 02:29:25'),
(5, '::1', 'contacto', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'Local', 'Buenos Aires', 'Local', '2026-06-20 02:29:28'),
(6, '::1', 'inicio', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'Local', 'Buenos Aires', 'Local', '2026-06-20 02:30:03'),
(7, '::1', 'inicio', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'Local', 'Buenos Aires', 'Local', '2026-06-20 02:30:14'),
(8, '::1', 'servicios', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'Local', 'Buenos Aires', 'Local', '2026-06-20 02:30:16'),
(9, '::1', 'inicio', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'Local', 'Buenos Aires', 'Local', '2026-06-20 02:32:21'),
(10, '::1', 'catalogo', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'Local', 'Buenos Aires', 'Local', '2026-06-20 02:32:23'),
(11, '::1', 'servicios', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'Local', 'Buenos Aires', 'Local', '2026-06-20 02:32:24'),
(12, '::1', 'nosotros', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'Local', 'Buenos Aires', 'Local', '2026-06-20 02:32:24'),
(13, '::1', 'contacto', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'Local', 'Buenos Aires', 'Local', '2026-06-20 02:32:25'),
(14, '::1', 'inicio', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'Local', 'Buenos Aires', 'Local', '2026-06-20 02:32:26'),
(15, '::1', 'inicio', 'Mozilla/5.0 (Windows NT; Windows NT 10.0; es-ES) WindowsPowerShell/5.1.19041.6456', 'Local', 'Buenos Aires', 'Local', '2026-06-20 02:33:13'),
(16, '::1', 'catalogo', 'Mozilla/5.0 (Windows NT; Windows NT 10.0; es-ES) WindowsPowerShell/5.1.19041.6456', 'Local', 'Buenos Aires', 'Local', '2026-06-20 02:33:13'),
(17, '::1', 'servicios', 'Mozilla/5.0 (Windows NT; Windows NT 10.0; es-ES) WindowsPowerShell/5.1.19041.6456', 'Local', 'Buenos Aires', 'Local', '2026-06-20 02:33:13'),
(18, '::1', 'inicio', 'Mozilla/5.0 (Windows NT; Windows NT 10.0; es-ES) WindowsPowerShell/5.1.19041.6456', 'Local', 'Buenos Aires', 'Local', '2026-06-20 02:34:11'),
(19, '::1', 'catalogo', 'Mozilla/5.0 (Windows NT; Windows NT 10.0; es-ES) WindowsPowerShell/5.1.19041.6456', 'Local', 'Buenos Aires', 'Local', '2026-06-20 02:34:12'),
(20, '::1', 'servicios', 'Mozilla/5.0 (Windows NT; Windows NT 10.0; es-ES) WindowsPowerShell/5.1.19041.6456', 'Local', 'Buenos Aires', 'Local', '2026-06-20 02:34:12'),
(21, '::1', 'nosotros', 'Mozilla/5.0 (Windows NT; Windows NT 10.0; es-ES) WindowsPowerShell/5.1.19041.6456', 'Local', 'Buenos Aires', 'Local', '2026-06-20 02:34:12'),
(22, '::1', 'contacto', 'Mozilla/5.0 (Windows NT; Windows NT 10.0; es-ES) WindowsPowerShell/5.1.19041.6456', 'Local', 'Buenos Aires', 'Local', '2026-06-20 02:34:12'),
(23, '::1', 'entregas', 'Mozilla/5.0 (Windows NT; Windows NT 10.0; es-ES) WindowsPowerShell/5.1.19041.6456', 'Local', 'Buenos Aires', 'Local', '2026-06-20 02:34:12'),
(24, '::1', 'garantia', 'Mozilla/5.0 (Windows NT; Windows NT 10.0; es-ES) WindowsPowerShell/5.1.19041.6456', 'Local', 'Buenos Aires', 'Local', '2026-06-20 02:34:12'),
(25, '::1', 'alianzas', 'Mozilla/5.0 (Windows NT; Windows NT 10.0; es-ES) WindowsPowerShell/5.1.19041.6456', 'Local', 'Buenos Aires', 'Local', '2026-06-20 02:34:12'),
(26, '::1', 'inicio', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'Local', 'Buenos Aires', 'Local', '2026-06-20 02:36:24'),
(27, '::1', 'inicio', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'Local', 'Buenos Aires', 'Local', '2026-06-20 18:28:46'),
(28, '::1', 'inicio', 'Mozilla/5.0 (Windows NT; Windows NT 10.0; es-ES) WindowsPowerShell/5.1.19041.6456', 'Local', 'Buenos Aires', 'Local', '2026-06-20 19:20:38'),
(29, '::1', 'catalogo', 'Mozilla/5.0 (Windows NT; Windows NT 10.0; es-ES) WindowsPowerShell/5.1.19041.6456', 'Local', 'Buenos Aires', 'Local', '2026-06-20 19:20:38'),
(30, '::1', 'catalogo', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'Local', 'Buenos Aires', 'Local', '2026-06-20 19:57:56'),
(31, '::1', 'inicio', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'Local', 'Buenos Aires', 'Local', '2026-06-20 19:58:14'),
(32, '::1', 'catalogo', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'Local', 'Buenos Aires', 'Local', '2026-06-20 19:58:16'),
(33, '::1', 'servicios', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'Local', 'Buenos Aires', 'Local', '2026-06-20 19:58:21'),
(34, '::1', 'nosotros', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'Local', 'Buenos Aires', 'Local', '2026-06-20 19:58:23'),
(35, '::1', 'contacto', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'Local', 'Buenos Aires', 'Local', '2026-06-20 19:58:24'),
(36, '::1', 'contacto', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'Local', 'Buenos Aires', 'Local', '2026-06-20 20:13:41'),
(37, '::1', 'inicio', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'Local', 'Buenos Aires', 'Local', '2026-06-20 20:15:45'),
(38, '::1', 'catalogo', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'Local', 'Buenos Aires', 'Local', '2026-06-20 20:15:53'),
(39, '::1', 'servicios', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'Local', 'Buenos Aires', 'Local', '2026-06-20 20:15:54'),
(40, '::1', 'nosotros', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'Local', 'Buenos Aires', 'Local', '2026-06-20 20:15:55'),
(41, '::1', 'contacto', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'Local', 'Buenos Aires', 'Local', '2026-06-20 20:15:56'),
(42, '::1', 'inicio', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'Local', 'Buenos Aires', 'Local', '2026-06-20 20:15:56'),
(43, '::1', 'inicio', 'Mozilla/5.0 (Windows NT; Windows NT 10.0; es-ES) WindowsPowerShell/5.1.19041.6456', 'Local', 'Buenos Aires', 'Local', '2026-06-20 20:16:03'),
(44, '::1', 'inicio', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'Local', 'Buenos Aires', 'Local', '2026-06-20 20:18:40'),
(45, '::1', 'inicio', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'Local', 'Buenos Aires', 'Local', '2026-06-20 20:18:40'),
(46, '::1', 'inicio', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'Local', 'Buenos Aires', 'Local', '2026-06-20 20:18:40'),
(47, '::1', 'catalogo', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'Local', 'Buenos Aires', 'Local', '2026-06-20 20:18:42'),
(48, '::1', 'inicio', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'Local', 'Buenos Aires', 'Local', '2026-06-20 20:18:43'),
(49, '::1', 'inicio', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'Local', 'Buenos Aires', 'Local', '2026-06-20 20:18:46'),
(50, '::1', 'inicio', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'Local', 'Buenos Aires', 'Local', '2026-06-20 20:18:46'),
(51, '::1', 'inicio', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'Local', 'Buenos Aires', 'Local', '2026-06-20 20:18:46'),
(52, '::1', 'inicio', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'Local', 'Buenos Aires', 'Local', '2026-06-20 20:19:04'),
(53, '::1', 'inicio', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'Local', 'Buenos Aires', 'Local', '2026-06-20 20:19:05'),
(54, '::1', 'inicio', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'Local', 'Buenos Aires', 'Local', '2026-06-20 20:19:05'),
(55, '::1', 'inicio', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'Local', 'Buenos Aires', 'Local', '2026-06-20 20:19:05'),
(56, '::1', 'inicio', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'Local', 'Buenos Aires', 'Local', '2026-06-20 20:19:26'),
(57, '::1', 'catalogo', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'Local', 'Buenos Aires', 'Local', '2026-06-20 20:19:29'),
(58, '::1', 'servicios', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'Local', 'Buenos Aires', 'Local', '2026-06-20 20:19:30'),
(59, '::1', 'nosotros', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'Local', 'Buenos Aires', 'Local', '2026-06-20 20:19:30'),
(60, '::1', 'inicio', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'Local', 'Buenos Aires', 'Local', '2026-06-20 20:19:44'),
(61, '::1', 'inicio', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'Local', 'Buenos Aires', 'Local', '2026-06-20 20:19:45'),
(62, '::1', 'catalogo', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'Local', 'Buenos Aires', 'Local', '2026-06-20 20:19:46'),
(63, '::1', 'servicios', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'Local', 'Buenos Aires', 'Local', '2026-06-20 20:19:47'),
(64, '::1', 'contacto', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'Local', 'Buenos Aires', 'Local', '2026-06-20 20:19:48'),
(65, '::1', 'inicio', 'Mozilla/5.0 (Windows NT; Windows NT 10.0; es-ES) WindowsPowerShell/5.1.19041.6456', 'Local', 'Buenos Aires', 'Local', '2026-06-20 20:29:48'),
(66, '::1', 'catalogo', 'Mozilla/5.0 (Windows NT; Windows NT 10.0; es-ES) WindowsPowerShell/5.1.19041.6456', 'Local', 'Buenos Aires', 'Local', '2026-06-20 20:29:48'),
(67, '::1', 'servicios', 'Mozilla/5.0 (Windows NT; Windows NT 10.0; es-ES) WindowsPowerShell/5.1.19041.6456', 'Local', 'Buenos Aires', 'Local', '2026-06-20 20:29:48'),
(68, '::1', 'nosotros', 'Mozilla/5.0 (Windows NT; Windows NT 10.0; es-ES) WindowsPowerShell/5.1.19041.6456', 'Local', 'Buenos Aires', 'Local', '2026-06-20 20:29:48'),
(69, '::1', 'contacto', 'Mozilla/5.0 (Windows NT; Windows NT 10.0; es-ES) WindowsPowerShell/5.1.19041.6456', 'Local', 'Buenos Aires', 'Local', '2026-06-20 20:29:48'),
(70, '::1', 'inicio', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) HeadlessChrome/149.0.0.0 Safari/537.36', 'Local', 'Buenos Aires', 'Local', '2026-06-20 20:30:24'),
(71, '::1', 'inicio', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) HeadlessChrome/149.0.0.0 Safari/537.36', 'Local', 'Buenos Aires', 'Local', '2026-06-20 20:30:24'),
(72, '::1', 'inicio', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) HeadlessChrome/149.0.0.0 Safari/537.36', 'Local', 'Buenos Aires', 'Local', '2026-06-20 20:31:35'),
(73, '::1', 'inicio', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) HeadlessChrome/149.0.0.0 Safari/537.36', 'Local', 'Buenos Aires', 'Local', '2026-06-20 20:31:35'),
(74, '::1', 'inicio', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'Local', 'Buenos Aires', 'Local', '2026-06-20 20:31:44'),
(75, '::1', 'inicio', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) HeadlessChrome/149.0.0.0 Safari/537.36', 'Local', 'Buenos Aires', 'Local', '2026-06-20 20:35:52'),
(76, '::1', 'inicio', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) HeadlessChrome/149.0.0.0 Safari/537.36', 'Local', 'Buenos Aires', 'Local', '2026-06-20 20:45:20'),
(77, '::1', 'inicio', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) HeadlessChrome/149.0.0.0 Safari/537.36', 'Local', 'Buenos Aires', 'Local', '2026-06-20 20:52:30'),
(78, '::1', 'inicio', 'Mozilla/5.0 (Windows NT; Windows NT 10.0; es-ES) WindowsPowerShell/5.1.19041.6456', 'Local', 'Buenos Aires', 'Local', '2026-06-20 21:13:47'),
(79, '::1', 'contacto', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) HeadlessChrome/149.0.0.0 Safari/537.36', 'Local', 'Buenos Aires', 'Local', '2026-06-20 21:14:36'),
(80, '::1', 'contacto', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) HeadlessChrome/149.0.0.0 Safari/537.36', 'Local', 'Buenos Aires', 'Local', '2026-06-20 21:14:36'),
(81, '::1', 'inicio', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'Local', 'Buenos Aires', 'Local', '2026-06-20 21:24:35'),
(82, '::1', 'inicio', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'Local', 'Buenos Aires', 'Local', '2026-06-20 21:24:35'),
(83, '::1', 'inicio', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'Local', 'Buenos Aires', 'Local', '2026-06-20 21:24:35'),
(84, '::1', 'inicio', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'Local', 'Buenos Aires', 'Local', '2026-06-20 21:24:35'),
(85, '::1', 'inicio', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'Local', 'Buenos Aires', 'Local', '2026-06-20 21:24:53'),
(86, '::1', 'inicio', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'Local', 'Buenos Aires', 'Local', '2026-06-20 21:24:53'),
(87, '::1', 'inicio', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'Local', 'Buenos Aires', 'Local', '2026-06-20 21:24:53'),
(88, '::1', 'inicio', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'Local', 'Buenos Aires', 'Local', '2026-06-20 21:24:53'),
(89, '::1', 'inicio', 'Mozilla/5.0 (Windows NT; Windows NT 10.0; es-ES) WindowsPowerShell/5.1.19041.6456', 'Local', 'Buenos Aires', 'Local', '2026-06-20 21:26:23'),
(90, '::1', 'contacto', 'Mozilla/5.0 (Windows NT; Windows NT 10.0; es-ES) WindowsPowerShell/5.1.19041.6456', 'Local', 'Buenos Aires', 'Local', '2026-06-20 21:26:23'),
(91, '::1', 'contacto', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) HeadlessChrome/149.0.0.0 Safari/537.36', 'Local', 'Buenos Aires', 'Local', '2026-06-20 21:30:04'),
(92, '::1', 'inicio', 'Mozilla/5.0 (Windows NT; Windows NT 10.0; es-ES) WindowsPowerShell/5.1.19041.6456', 'Local', 'Buenos Aires', 'Local', '2026-06-20 22:18:09'),
(93, '::1', 'catalogo', 'Mozilla/5.0 (Windows NT; Windows NT 10.0; es-ES) WindowsPowerShell/5.1.19041.6456', 'Local', 'Buenos Aires', 'Local', '2026-06-20 22:18:09'),
(94, '::1', 'servicios', 'Mozilla/5.0 (Windows NT; Windows NT 10.0; es-ES) WindowsPowerShell/5.1.19041.6456', 'Local', 'Buenos Aires', 'Local', '2026-06-20 22:18:09'),
(95, '::1', 'nosotros', 'Mozilla/5.0 (Windows NT; Windows NT 10.0; es-ES) WindowsPowerShell/5.1.19041.6456', 'Local', 'Buenos Aires', 'Local', '2026-06-20 22:18:09'),
(96, '::1', 'contacto', 'Mozilla/5.0 (Windows NT; Windows NT 10.0; es-ES) WindowsPowerShell/5.1.19041.6456', 'Local', 'Buenos Aires', 'Local', '2026-06-20 22:18:09'),
(97, '::1', 'inicio', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'Local', 'Buenos Aires', 'Local', '2026-06-20 22:20:44'),
(98, '::1', 'contacto', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) HeadlessChrome/149.0.0.0 Safari/537.36', 'Local', 'Buenos Aires', 'Local', '2026-06-20 22:26:17'),
(99, '::1', 'contacto', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) HeadlessChrome/149.0.0.0 Safari/537.36', 'Local', 'Buenos Aires', 'Local', '2026-06-20 22:26:17'),
(100, '::1', 'contacto', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) HeadlessChrome/149.0.0.0 Safari/537.36', 'Local', 'Buenos Aires', 'Local', '2026-06-20 22:27:19'),
(101, '::1', 'inicio', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'Local', 'Buenos Aires', 'Local', '2026-06-20 22:30:41'),
(102, '::1', 'contacto', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) HeadlessChrome/149.0.0.0 Safari/537.36', 'Local', 'Buenos Aires', 'Local', '2026-06-20 22:30:51'),
(103, '::1', 'inicio', 'Mozilla/5.0 (Windows NT; Windows NT 10.0; es-ES) WindowsPowerShell/5.1.19041.6456', 'Local', 'Buenos Aires', 'Local', '2026-06-20 22:30:52'),
(104, '::1', 'catalogo', 'Mozilla/5.0 (Windows NT; Windows NT 10.0; es-ES) WindowsPowerShell/5.1.19041.6456', 'Local', 'Buenos Aires', 'Local', '2026-06-20 22:30:52'),
(105, '::1', 'servicios', 'Mozilla/5.0 (Windows NT; Windows NT 10.0; es-ES) WindowsPowerShell/5.1.19041.6456', 'Local', 'Buenos Aires', 'Local', '2026-06-20 22:30:52'),
(106, '::1', 'nosotros', 'Mozilla/5.0 (Windows NT; Windows NT 10.0; es-ES) WindowsPowerShell/5.1.19041.6456', 'Local', 'Buenos Aires', 'Local', '2026-06-20 22:30:52'),
(107, '::1', 'contacto', 'Mozilla/5.0 (Windows NT; Windows NT 10.0; es-ES) WindowsPowerShell/5.1.19041.6456', 'Local', 'Buenos Aires', 'Local', '2026-06-20 22:30:52'),
(108, '::1', 'inicio', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'Local', 'Buenos Aires', 'Local', '2026-06-20 22:30:55'),
(109, '::1', 'inicio', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'Local', 'Buenos Aires', 'Local', '2026-06-20 22:30:56'),
(110, '::1', 'inicio', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'Local', 'Buenos Aires', 'Local', '2026-06-20 22:30:56'),
(111, '::1', 'inicio', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'Local', 'Buenos Aires', 'Local', '2026-06-20 22:30:56'),
(112, '::1', 'inicio', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'Local', 'Buenos Aires', 'Local', '2026-06-20 22:30:56'),
(113, '::1', 'inicio', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'Local', 'Buenos Aires', 'Local', '2026-06-20 22:30:56'),
(114, '::1', 'inicio', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'Local', 'Buenos Aires', 'Local', '2026-06-20 22:30:56'),
(115, '::1', 'inicio', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'Local', 'Buenos Aires', 'Local', '2026-06-20 22:30:56'),
(116, '::1', 'inicio', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'Local', 'Buenos Aires', 'Local', '2026-06-20 22:30:57'),
(117, '::1', 'inicio', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'Local', 'Buenos Aires', 'Local', '2026-06-20 22:30:57'),
(118, '::1', 'inicio', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'Local', 'Buenos Aires', 'Local', '2026-06-20 22:30:57'),
(119, '::1', 'inicio', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'Local', 'Buenos Aires', 'Local', '2026-06-20 22:30:57'),
(120, '::1', 'inicio', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'Local', 'Buenos Aires', 'Local', '2026-06-20 22:30:57'),
(121, '::1', 'inicio', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'Local', 'Buenos Aires', 'Local', '2026-06-20 22:30:57'),
(122, '::1', 'inicio', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'Local', 'Buenos Aires', 'Local', '2026-06-20 22:30:57'),
(123, '::1', 'inicio', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'Local', 'Buenos Aires', 'Local', '2026-06-20 22:30:58'),
(124, '::1', 'inicio', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'Local', 'Buenos Aires', 'Local', '2026-06-20 22:30:58'),
(125, '::1', 'inicio', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'Local', 'Buenos Aires', 'Local', '2026-06-20 22:37:40'),
(126, '::1', 'inicio', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'Local', 'Buenos Aires', 'Local', '2026-06-20 22:37:40'),
(127, '::1', 'inicio', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'Local', 'Buenos Aires', 'Local', '2026-06-20 22:37:40'),
(128, '::1', 'inicio', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'Local', 'Buenos Aires', 'Local', '2026-06-20 22:37:41'),
(129, '::1', 'catalogo', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'Local', 'Buenos Aires', 'Local', '2026-06-20 22:37:53'),
(130, '::1', 'servicios', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'Local', 'Buenos Aires', 'Local', '2026-06-20 22:37:54'),
(131, '::1', 'nosotros', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'Local', 'Buenos Aires', 'Local', '2026-06-20 22:37:55'),
(132, '::1', 'contacto', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'Local', 'Buenos Aires', 'Local', '2026-06-20 22:38:01'),
(133, '::1', 'inicio', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'Local', 'Buenos Aires', 'Local', '2026-06-20 22:38:20'),
(134, '::1', 'catalogo', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'Local', 'Buenos Aires', 'Local', '2026-06-20 22:38:21'),
(135, '::1', 'servicios', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'Local', 'Buenos Aires', 'Local', '2026-06-20 22:38:22'),
(136, '::1', 'nosotros', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'Local', 'Buenos Aires', 'Local', '2026-06-20 22:38:22'),
(137, '::1', 'contacto', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'Local', 'Buenos Aires', 'Local', '2026-06-20 22:38:23'),
(138, '::1', 'inicio', 'Mozilla/5.0 (Windows NT; Windows NT 10.0; es-ES) WindowsPowerShell/5.1.19041.6456', 'Local', 'Buenos Aires', 'Local', '2026-06-20 23:02:03'),
(139, '::1', 'catalogo', 'Mozilla/5.0 (Windows NT; Windows NT 10.0; es-ES) WindowsPowerShell/5.1.19041.6456', 'Local', 'Buenos Aires', 'Local', '2026-06-20 23:02:03'),
(140, '::1', 'servicios', 'Mozilla/5.0 (Windows NT; Windows NT 10.0; es-ES) WindowsPowerShell/5.1.19041.6456', 'Local', 'Buenos Aires', 'Local', '2026-06-20 23:02:03'),
(141, '::1', 'nosotros', 'Mozilla/5.0 (Windows NT; Windows NT 10.0; es-ES) WindowsPowerShell/5.1.19041.6456', 'Local', 'Buenos Aires', 'Local', '2026-06-20 23:02:03'),
(142, '::1', 'contacto', 'Mozilla/5.0 (Windows NT; Windows NT 10.0; es-ES) WindowsPowerShell/5.1.19041.6456', 'Local', 'Buenos Aires', 'Local', '2026-06-20 23:02:03'),
(143, '::1', 'inicio', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'Local', 'Buenos Aires', 'Local', '2026-06-20 23:05:45'),
(144, '::1', 'inicio', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'Local', 'Buenos Aires', 'Local', '2026-06-20 23:05:47'),
(145, '::1', 'inicio', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'Local', 'Buenos Aires', 'Local', '2026-06-20 23:05:48'),
(146, '::1', 'inicio', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'Local', 'Buenos Aires', 'Local', '2026-06-20 23:05:48'),
(147, '::1', 'inicio', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'Local', 'Buenos Aires', 'Local', '2026-06-20 23:05:48'),
(148, '::1', 'inicio', 'Mozilla/5.0 (Windows NT; Windows NT 10.0; es-ES) WindowsPowerShell/5.1.19041.6456', 'Local', 'Buenos Aires', 'Local', '2026-06-20 23:50:25'),
(149, '::1', 'catalogo', 'Mozilla/5.0 (Windows NT; Windows NT 10.0; es-ES) WindowsPowerShell/5.1.19041.6456', 'Local', 'Buenos Aires', 'Local', '2026-06-20 23:50:25'),
(150, '::1', 'servicios', 'Mozilla/5.0 (Windows NT; Windows NT 10.0; es-ES) WindowsPowerShell/5.1.19041.6456', 'Local', 'Buenos Aires', 'Local', '2026-06-20 23:50:25'),
(151, '::1', 'nosotros', 'Mozilla/5.0 (Windows NT; Windows NT 10.0; es-ES) WindowsPowerShell/5.1.19041.6456', 'Local', 'Buenos Aires', 'Local', '2026-06-20 23:50:25'),
(152, '::1', 'contacto', 'Mozilla/5.0 (Windows NT; Windows NT 10.0; es-ES) WindowsPowerShell/5.1.19041.6456', 'Local', 'Buenos Aires', 'Local', '2026-06-20 23:50:25'),
(153, '::1', 'contacto', 'Mozilla/5.0 (Windows NT; Windows NT 10.0; es-ES) WindowsPowerShell/5.1.19041.6456', 'Local', 'Buenos Aires', 'Local', '2026-06-20 23:52:09'),
(154, '::1', 'contacto', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) HeadlessChrome/149.0.0.0 Safari/537.36', 'Local', 'Buenos Aires', 'Local', '2026-06-20 23:53:01'),
(155, '::1', 'contacto', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) HeadlessChrome/149.0.0.0 Safari/537.36', 'Local', 'Buenos Aires', 'Local', '2026-06-20 23:53:01'),
(156, '::1', 'inicio', 'Mozilla/5.0 (Linux; Android 13; Pixel 7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Mobile Safari/537.36', 'Local', 'Buenos Aires', 'Local', '2026-06-20 23:54:29'),
(157, '::1', 'inicio', 'Mozilla/5.0 (Linux; Android 13; Pixel 7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Mobile Safari/537.36', 'Local', 'Buenos Aires', 'Local', '2026-06-20 23:54:29'),
(158, '::1', 'inicio', 'Mozilla/5.0 (Linux; Android 13; Pixel 7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Mobile Safari/537.36', 'Local', 'Buenos Aires', 'Local', '2026-06-20 23:54:29'),
(159, '::1', 'inicio', 'Mozilla/5.0 (Linux; Android 13; Pixel 7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Mobile Safari/537.36', 'Local', 'Buenos Aires', 'Local', '2026-06-20 23:54:29'),
(160, '::1', 'inicio', 'Mozilla/5.0 (Windows NT; Windows NT 10.0; es-ES) WindowsPowerShell/5.1.19041.6456', 'Local', 'Buenos Aires', 'Local', '2026-06-20 23:55:05'),
(161, '::1', 'catalogo', 'Mozilla/5.0 (Windows NT; Windows NT 10.0; es-ES) WindowsPowerShell/5.1.19041.6456', 'Local', 'Buenos Aires', 'Local', '2026-06-20 23:55:05'),
(162, '::1', 'servicios', 'Mozilla/5.0 (Windows NT; Windows NT 10.0; es-ES) WindowsPowerShell/5.1.19041.6456', 'Local', 'Buenos Aires', 'Local', '2026-06-20 23:55:05'),
(163, '::1', 'nosotros', 'Mozilla/5.0 (Windows NT; Windows NT 10.0; es-ES) WindowsPowerShell/5.1.19041.6456', 'Local', 'Buenos Aires', 'Local', '2026-06-20 23:55:05'),
(164, '::1', 'contacto', 'Mozilla/5.0 (Windows NT; Windows NT 10.0; es-ES) WindowsPowerShell/5.1.19041.6456', 'Local', 'Buenos Aires', 'Local', '2026-06-20 23:55:05'),
(165, '::1', 'contacto', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) HeadlessChrome/149.0.0.0 Safari/537.36', 'Local', 'Buenos Aires', 'Local', '2026-06-20 23:55:07'),
(166, '::1', 'contacto', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'Local', 'Buenos Aires', 'Local', '2026-06-21 00:04:21'),
(167, '::1', 'contacto', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'Local', 'Buenos Aires', 'Local', '2026-06-21 00:04:21'),
(168, '::1', 'contacto', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'Local', 'Buenos Aires', 'Local', '2026-06-21 00:04:21'),
(169, '::1', 'inicio', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'Local', 'Buenos Aires', 'Local', '2026-06-21 00:04:22'),
(170, '::1', 'catalogo', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'Local', 'Buenos Aires', 'Local', '2026-06-21 00:04:23'),
(171, '::1', 'servicios', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'Local', 'Buenos Aires', 'Local', '2026-06-21 00:04:24'),
(172, '::1', 'nosotros', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'Local', 'Buenos Aires', 'Local', '2026-06-21 00:04:25'),
(173, '::1', 'contacto', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'Local', 'Buenos Aires', 'Local', '2026-06-21 00:04:25'),
(174, '::1', 'catalogo', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'Local', 'Buenos Aires', 'Local', '2026-06-21 00:04:26'),
(175, '::1', 'inicio', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'Local', 'Buenos Aires', 'Local', '2026-06-21 00:04:27'),
(176, '::1', 'nosotros', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'Local', 'Buenos Aires', 'Local', '2026-06-21 00:04:29'),
(177, '::1', 'catalogo', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'Local', 'Buenos Aires', 'Local', '2026-06-21 00:04:30'),
(178, '::1', 'servicios', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'Local', 'Buenos Aires', 'Local', '2026-06-21 00:04:30'),
(179, '::1', 'contacto', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'Local', 'Buenos Aires', 'Local', '2026-06-21 00:04:31'),
(180, '::1', 'inicio', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'Local', 'Buenos Aires', 'Local', '2026-06-21 00:04:39'),
(181, '::1', 'catalogo', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'Local', 'Buenos Aires', 'Local', '2026-06-21 00:04:41'),
(182, '::1', 'servicios', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'Local', 'Buenos Aires', 'Local', '2026-06-21 00:04:42'),
(183, '::1', 'contacto', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'Local', 'Buenos Aires', 'Local', '2026-06-21 00:04:43'),
(184, '::1', 'inicio', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'Local', 'Buenos Aires', 'Local', '2026-06-21 00:04:45'),
(185, '::1', 'catalogo', 'Mozilla/5.0 (Linux; Android 13; Pixel 7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Mobile Safari/537.36', 'Local', 'Buenos Aires', 'Local', '2026-06-21 00:48:42'),
(186, '::1', 'inicio', 'Mozilla/5.0 (Linux; Android 13; Pixel 7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Mobile Safari/537.36', 'Local', 'Buenos Aires', 'Local', '2026-06-21 00:48:48'),
(187, '::1', 'contacto', 'Mozilla/5.0 (Windows NT; Windows NT 10.0; es-ES) WindowsPowerShell/5.1.19041.6456', 'Local', 'Buenos Aires', 'Local', '2026-06-21 00:50:22'),
(188, '::1', 'inicio', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'Local', 'Buenos Aires', 'Local', '2026-06-21 03:11:22'),
(189, '::1', 'contacto', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'Local', 'Buenos Aires', 'Local', '2026-06-21 05:01:29'),
(190, '::1', 'contacto', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'Local', 'Buenos Aires', 'Local', '2026-06-21 05:14:20'),
(191, '::1', 'contacto', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'Local', 'Buenos Aires', 'Local', '2026-06-21 05:14:22'),
(192, '::1', 'contacto', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'Local', 'Buenos Aires', 'Local', '2026-06-21 05:14:22'),
(193, '::1', 'contacto', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'Local', 'Buenos Aires', 'Local', '2026-06-21 05:14:22'),
(194, '::1', 'inicio', 'Mozilla/5.0 (Windows NT; Windows NT 10.0; es-ES) WindowsPowerShell/5.1.19041.6456', 'Local', 'Buenos Aires', 'Local', '2026-06-21 05:18:55'),
(195, '::1', 'catalogo', 'Mozilla/5.0 (Windows NT; Windows NT 10.0; es-ES) WindowsPowerShell/5.1.19041.6456', 'Local', 'Buenos Aires', 'Local', '2026-06-21 05:18:55'),
(196, '::1', 'contacto', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'Local', 'Buenos Aires', 'Local', '2026-06-21 05:25:59'),
(197, '::1', 'contacto', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'Local', 'Buenos Aires', 'Local', '2026-06-21 05:25:59'),
(198, '::1', 'contacto', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'Local', 'Buenos Aires', 'Local', '2026-06-21 05:25:59'),
(199, '::1', 'contacto', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'Local', 'Buenos Aires', 'Local', '2026-06-21 05:25:59'),
(200, '::1', 'inicio', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'Local', 'Buenos Aires', 'Local', '2026-06-21 05:26:25'),
(201, '::1', 'catalogo', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'Local', 'Buenos Aires', 'Local', '2026-06-21 05:26:30'),
(202, '::1', 'servicios', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'Local', 'Buenos Aires', 'Local', '2026-06-21 05:26:31'),
(203, '::1', 'nosotros', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'Local', 'Buenos Aires', 'Local', '2026-06-21 05:26:32'),
(204, '::1', 'contacto', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'Local', 'Buenos Aires', 'Local', '2026-06-21 05:26:33'),
(205, '::1', 'inicio', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'Local', 'Buenos Aires', 'Local', '2026-06-21 05:26:35'),
(206, '::1', 'catalogo', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'Local', 'Buenos Aires', 'Local', '2026-06-21 05:45:58'),
(207, '::1', 'servicios', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'Local', 'Buenos Aires', 'Local', '2026-06-21 05:46:01'),
(208, '::1', 'nosotros', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'Local', 'Buenos Aires', 'Local', '2026-06-21 05:46:02'),
(209, '::1', 'contacto', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'Local', 'Buenos Aires', 'Local', '2026-06-21 05:46:03'),
(210, '::1', 'catalogo', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'Local', 'Buenos Aires', 'Local', '2026-06-21 05:46:04'),
(211, '::1', 'inicio', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'Local', 'Buenos Aires', 'Local', '2026-06-21 05:46:08'),
(212, '::1', 'inicio', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'Local', 'Buenos Aires', 'Local', '2026-06-21 05:50:49'),
(213, '::1', 'inicio', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'Local', 'Buenos Aires', 'Local', '2026-06-24 01:05:54'),
(214, '::1', 'catalogo', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'Local', 'Buenos Aires', 'Local', '2026-06-24 01:10:10'),
(215, '::1', 'servicios', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'Local', 'Buenos Aires', 'Local', '2026-06-24 01:10:12'),
(216, '::1', 'catalogo', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'Local', 'Buenos Aires', 'Local', '2026-06-24 01:10:12'),
(217, '::1', 'servicios', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'Local', 'Buenos Aires', 'Local', '2026-06-24 01:10:18'),
(218, '::1', 'nosotros', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'Local', 'Buenos Aires', 'Local', '2026-06-24 01:10:20'),
(219, '::1', 'contacto', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'Local', 'Buenos Aires', 'Local', '2026-06-24 01:10:23'),
(220, '::1', 'servicios', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'Local', 'Buenos Aires', 'Local', '2026-06-24 01:10:24'),
(221, '::1', 'nosotros', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'Local', 'Buenos Aires', 'Local', '2026-06-24 01:10:24'),
(222, '::1', 'contacto', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'Local', 'Buenos Aires', 'Local', '2026-06-24 01:10:25'),
(223, '::1', 'servicios', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'Local', 'Buenos Aires', 'Local', '2026-06-24 01:10:28'),
(224, '::1', 'nosotros', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'Local', 'Buenos Aires', 'Local', '2026-06-24 01:10:29'),
(225, '::1', 'contacto', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'Local', 'Buenos Aires', 'Local', '2026-06-24 01:10:29'),
(226, '::1', 'servicios', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'Local', 'Buenos Aires', 'Local', '2026-06-24 01:10:30'),
(227, '::1', 'nosotros', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'Local', 'Buenos Aires', 'Local', '2026-06-24 01:10:31'),
(228, '::1', 'contacto', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'Local', 'Buenos Aires', 'Local', '2026-06-24 01:10:31'),
(229, '::1', 'inicio', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) HeadlessChrome/149.0.0.0 Safari/537.36', 'Local', 'Buenos Aires', 'Local', '2026-06-24 01:10:32'),
(230, '::1', 'servicios', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'Local', 'Buenos Aires', 'Local', '2026-06-24 01:10:43'),
(231, '::1', 'nosotros', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'Local', 'Buenos Aires', 'Local', '2026-06-24 01:10:45'),
(232, '::1', 'catalogo', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'Local', 'Buenos Aires', 'Local', '2026-06-24 01:10:47'),
(233, '::1', 'catalogo', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'Local', 'Buenos Aires', 'Local', '2026-06-24 01:11:10'),
(234, '::1', 'catalogo', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'Local', 'Buenos Aires', 'Local', '2026-06-24 01:11:10'),
(235, '::1', 'catalogo', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'Local', 'Buenos Aires', 'Local', '2026-06-24 01:11:10'),
(236, '::1', 'catalogo', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'Local', 'Buenos Aires', 'Local', '2026-06-24 01:11:10'),
(237, '::1', 'catalogo', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'Local', 'Buenos Aires', 'Local', '2026-06-24 01:11:10'),
(238, '::1', 'catalogo', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'Local', 'Buenos Aires', 'Local', '2026-06-24 01:11:10'),
(239, '::1', 'catalogo', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'Local', 'Buenos Aires', 'Local', '2026-06-24 01:11:11'),
(240, '::1', 'catalogo', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'Local', 'Buenos Aires', 'Local', '2026-06-24 01:11:11'),
(241, '::1', 'catalogo', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'Local', 'Buenos Aires', 'Local', '2026-06-24 01:11:11'),
(242, '::1', 'catalogo', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'Local', 'Buenos Aires', 'Local', '2026-06-24 01:11:11'),
(243, '::1', 'catalogo', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'Local', 'Buenos Aires', 'Local', '2026-06-24 01:11:11'),
(244, '::1', 'catalogo', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'Local', 'Buenos Aires', 'Local', '2026-06-24 01:11:11'),
(245, '::1', 'catalogo', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'Local', 'Buenos Aires', 'Local', '2026-06-24 01:11:11'),
(246, '::1', 'catalogo', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'Local', 'Buenos Aires', 'Local', '2026-06-24 01:11:11'),
(247, '::1', 'catalogo', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'Local', 'Buenos Aires', 'Local', '2026-06-24 01:11:12'),
(248, '::1', 'catalogo', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'Local', 'Buenos Aires', 'Local', '2026-06-24 01:11:12'),
(249, '::1', 'catalogo', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'Local', 'Buenos Aires', 'Local', '2026-06-24 01:11:26'),
(250, '::1', 'catalogo', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'Local', 'Buenos Aires', 'Local', '2026-06-24 01:11:26'),
(251, '::1', 'catalogo', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'Local', 'Buenos Aires', 'Local', '2026-06-24 01:11:26'),
(252, '::1', 'catalogo', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'Local', 'Buenos Aires', 'Local', '2026-06-24 01:11:26'),
(253, '::1', 'catalogo', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'Local', 'Buenos Aires', 'Local', '2026-06-24 01:11:26'),
(254, '::1', 'catalogo', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'Local', 'Buenos Aires', 'Local', '2026-06-24 01:11:26'),
(255, '::1', 'catalogo', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'Local', 'Buenos Aires', 'Local', '2026-06-24 01:11:26'),
(256, '::1', 'catalogo', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'Local', 'Buenos Aires', 'Local', '2026-06-24 01:11:26'),
(257, '::1', 'catalogo', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'Local', 'Buenos Aires', 'Local', '2026-06-24 01:11:26'),
(258, '::1', 'catalogo', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'Local', 'Buenos Aires', 'Local', '2026-06-24 01:11:27'),
(259, '::1', 'catalogo', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'Local', 'Buenos Aires', 'Local', '2026-06-24 01:11:27'),
(260, '::1', 'catalogo', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'Local', 'Buenos Aires', 'Local', '2026-06-24 01:11:27'),
(261, '::1', 'catalogo', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'Local', 'Buenos Aires', 'Local', '2026-06-24 01:11:27'),
(262, '::1', 'catalogo', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'Local', 'Buenos Aires', 'Local', '2026-06-24 01:11:27');
INSERT INTO `visitas_sitio` (`id_visita`, `ip_address`, `pagina`, `user_agent`, `pais`, `region`, `ciudad`, `fecha_ingreso`) VALUES
(263, '::1', 'catalogo', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'Local', 'Buenos Aires', 'Local', '2026-06-24 01:11:27'),
(264, '::1', 'catalogo', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'Local', 'Buenos Aires', 'Local', '2026-06-24 01:11:27'),
(265, '::1', 'catalogo', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'Local', 'Buenos Aires', 'Local', '2026-06-24 01:11:27'),
(266, '::1', 'catalogo', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'Local', 'Buenos Aires', 'Local', '2026-06-24 01:12:10'),
(267, '::1', 'catalogo', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'Local', 'Buenos Aires', 'Local', '2026-06-24 01:12:11'),
(268, '::1', 'catalogo', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'Local', 'Buenos Aires', 'Local', '2026-06-24 01:12:11'),
(269, '::1', 'catalogo', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'Local', 'Buenos Aires', 'Local', '2026-06-24 01:12:11'),
(270, '::1', 'inicio', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) HeadlessChrome/149.0.0.0 Safari/537.36', 'Local', 'Buenos Aires', 'Local', '2026-06-24 01:12:41'),
(271, '::1', 'catalogo', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'Local', 'Buenos Aires', 'Local', '2026-06-24 01:14:17'),
(272, '::1', 'catalogo', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'Local', 'Buenos Aires', 'Local', '2026-06-24 01:14:18'),
(273, '::1', 'catalogo', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'Local', 'Buenos Aires', 'Local', '2026-06-24 01:14:18'),
(274, '::1', 'catalogo', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'Local', 'Buenos Aires', 'Local', '2026-06-24 01:14:58'),
(275, '::1', 'catalogo', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'Local', 'Buenos Aires', 'Local', '2026-06-24 01:14:58'),
(276, '::1', 'catalogo', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'Local', 'Buenos Aires', 'Local', '2026-06-24 01:14:58'),
(277, '::1', 'catalogo', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'Local', 'Buenos Aires', 'Local', '2026-06-24 01:14:58'),
(278, '::1', 'catalogo', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'Local', 'Buenos Aires', 'Local', '2026-06-24 01:14:58'),
(279, '::1', 'catalogo', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'Local', 'Buenos Aires', 'Local', '2026-06-24 01:14:58'),
(280, '::1', 'catalogo', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'Local', 'Buenos Aires', 'Local', '2026-06-24 01:14:58'),
(281, '::1', 'catalogo', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'Local', 'Buenos Aires', 'Local', '2026-06-24 01:14:59'),
(282, '::1', 'inicio', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'Local', 'Buenos Aires', 'Local', '2026-06-24 01:15:00'),
(283, '::1', 'inicio', 'Mozilla/5.0 (Windows NT; Windows NT 10.0; es-ES) WindowsPowerShell/5.1.19041.6456', 'Local', 'Buenos Aires', 'Local', '2026-06-24 01:15:13'),
(284, '::1', 'inicio', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) HeadlessChrome/149.0.0.0 Safari/537.36', 'Local', 'Buenos Aires', 'Local', '2026-06-24 01:15:40'),
(285, '::1', 'inicio', 'Mozilla/5.0 (Windows NT; Windows NT 10.0; es-ES) WindowsPowerShell/5.1.19041.6456', 'Local', 'Buenos Aires', 'Local', '2026-06-24 01:17:05'),
(286, '::1', 'inicio', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'Local', 'Buenos Aires', 'Local', '2026-06-24 01:25:00'),
(287, '::1', 'inicio', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'Local', 'Buenos Aires', 'Local', '2026-06-24 01:25:02'),
(288, '::1', 'inicio', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'Local', 'Buenos Aires', 'Local', '2026-06-24 01:25:02'),
(289, '::1', 'inicio', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'Local', 'Buenos Aires', 'Local', '2026-06-24 01:25:02'),
(290, '::1', 'inicio', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'Local', 'Buenos Aires', 'Local', '2026-06-24 01:25:02'),
(291, '::1', 'inicio', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'Local', 'Buenos Aires', 'Local', '2026-06-24 01:25:02'),
(292, '::1', 'inicio', 'Mozilla/5.0 (Windows NT; Windows NT 10.0; es-ES) WindowsPowerShell/5.1.19041.6456', 'Local', 'Buenos Aires', 'Local', '2026-06-24 01:31:47'),
(293, '::1', 'inicio', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'Local', 'Buenos Aires', 'Local', '2026-06-24 01:31:57'),
(294, '::1', 'inicio', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'Local', 'Buenos Aires', 'Local', '2026-06-24 01:31:57'),
(295, '::1', 'inicio', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'Local', 'Buenos Aires', 'Local', '2026-06-24 01:31:57'),
(296, '::1', 'inicio', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'Local', 'Buenos Aires', 'Local', '2026-06-24 01:31:57'),
(297, '::1', 'inicio', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'Local', 'Buenos Aires', 'Local', '2026-06-24 01:33:04'),
(298, '::1', 'inicio', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'Local', 'Buenos Aires', 'Local', '2026-06-24 01:33:04'),
(299, '::1', 'inicio', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'Local', 'Buenos Aires', 'Local', '2026-06-24 01:33:04'),
(300, '::1', 'inicio', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'Local', 'Buenos Aires', 'Local', '2026-06-24 01:41:11'),
(301, '::1', 'inicio', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'Local', 'Buenos Aires', 'Local', '2026-06-24 01:41:11'),
(302, '::1', 'inicio', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'Local', 'Buenos Aires', 'Local', '2026-06-24 01:41:11'),
(303, '::1', 'inicio', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) HeadlessChrome/149.0.0.0 Safari/537.36', 'Local', 'Buenos Aires', 'Local', '2026-06-24 01:42:16'),
(304, '::1', 'inicio', 'Mozilla/5.0 (Windows NT; Windows NT 10.0; es-ES) WindowsPowerShell/5.1.19041.6456', 'Local', 'Buenos Aires', 'Local', '2026-06-24 01:43:43'),
(305, '::1', 'inicio', 'Mozilla/5.0 (Windows NT; Windows NT 10.0; es-ES) WindowsPowerShell/5.1.19041.6456', 'Local', 'Buenos Aires', 'Local', '2026-06-24 01:46:04'),
(306, '::1', 'inicio', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'Local', 'Buenos Aires', 'Local', '2026-06-24 02:25:20'),
(307, '192.168.0.192', 'inicio', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'Local', 'Buenos Aires', 'Local', '2026-06-24 02:33:10'),
(308, '192.168.0.153', 'inicio', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Mobile Safari/537.36', 'Local', 'Buenos Aires', 'Local', '2026-06-24 02:35:14'),
(309, '192.168.0.192', 'catalogo', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'Local', 'Buenos Aires', 'Local', '2026-06-24 02:35:40'),
(310, '192.168.0.192', 'servicios', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'Local', 'Buenos Aires', 'Local', '2026-06-24 02:35:41'),
(311, '192.168.0.192', 'nosotros', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'Local', 'Buenos Aires', 'Local', '2026-06-24 02:35:43'),
(312, '192.168.0.192', 'contacto', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'Local', 'Buenos Aires', 'Local', '2026-06-24 02:35:44'),
(313, '192.168.0.192', 'servicios', 'Mozilla/5.0 (Linux; Android 13; Pixel 7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Mobile Safari/537.36', 'Local', 'Buenos Aires', 'Local', '2026-06-24 02:35:53'),
(314, '192.168.0.192', 'contacto', 'Mozilla/5.0 (Linux; Android 13; Pixel 7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Mobile Safari/537.36', 'Local', 'Buenos Aires', 'Local', '2026-06-24 02:35:55'),
(315, '::1', 'inicio', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'Local', 'Buenos Aires', 'Local', '2026-06-25 13:40:25'),
(316, '::1', 'inicio', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'Local', 'Buenos Aires', 'Local', '2026-06-25 13:40:28'),
(317, '::1', 'catalogo', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'Local', 'Buenos Aires', 'Local', '2026-06-25 15:02:10'),
(318, '::1', 'servicios', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'Local', 'Buenos Aires', 'Local', '2026-06-25 15:02:11'),
(319, '::1', 'nosotros', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'Local', 'Buenos Aires', 'Local', '2026-06-25 15:02:12'),
(320, '::1', 'contacto', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'Local', 'Buenos Aires', 'Local', '2026-06-25 15:02:15'),
(321, '::1', 'servicios', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'Local', 'Buenos Aires', 'Local', '2026-06-25 15:02:17'),
(322, '::1', 'servicios', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'Local', 'Buenos Aires', 'Local', '2026-06-25 15:02:20'),
(323, '::1', 'entregas', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'Local', 'Buenos Aires', 'Local', '2026-06-25 15:02:20'),
(324, '::1', 'servicios', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'Local', 'Buenos Aires', 'Local', '2026-06-25 15:02:21'),
(325, '::1', 'servicios', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'Local', 'Buenos Aires', 'Local', '2026-06-25 15:05:20'),
(326, '::1', 'entregas', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'Local', 'Buenos Aires', 'Local', '2026-06-25 15:05:27'),
(327, '::1', 'entregas', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'Local', 'Buenos Aires', 'Local', '2026-06-25 15:05:35'),
(328, '::1', 'servicios', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'Local', 'Buenos Aires', 'Local', '2026-06-25 15:05:47'),
(329, '::1', 'entregas', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'Local', 'Buenos Aires', 'Local', '2026-06-25 15:05:55'),
(330, '::1', 'entregas', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'Local', 'Buenos Aires', 'Local', '2026-06-25 15:06:05'),
(331, '::1', 'entregas', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'Local', 'Buenos Aires', 'Local', '2026-06-25 15:07:00');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categorias_producto`
--
ALTER TABLE `categorias_producto`
  ADD PRIMARY KEY (`id_categoria_producto`),
  ADD UNIQUE KEY `uq_categorias_producto_nombre` (`nombre`);

--
-- Indices de la tabla `categorias_servicio`
--
ALTER TABLE `categorias_servicio`
  ADD PRIMARY KEY (`id_categoria_servicio`),
  ADD UNIQUE KEY `uq_categorias_servicio_nombre` (`nombre`);

--
-- Indices de la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id_cliente`),
  ADD KEY `idx_clientes_telefono` (`telefono`);

--
-- Indices de la tabla `colores`
--
ALTER TABLE `colores`
  ADD PRIMARY KEY (`id_color`),
  ADD UNIQUE KEY `uq_colores_nombre` (`nombre`),
  ADD KEY `idx_colores_activo_orden` (`activo`,`orden`);

--
-- Indices de la tabla `contenidos_sitio`
--
ALTER TABLE `contenidos_sitio`
  ADD PRIMARY KEY (`id_contenido`),
  ADD UNIQUE KEY `uq_contenidos_sitio_clave` (`clave`);

--
-- Indices de la tabla `interacciones`
--
ALTER TABLE `interacciones`
  ADD PRIMARY KEY (`id_interaccion`),
  ADD KEY `idx_interacciones_estado` (`estado`),
  ADD KEY `idx_interacciones_producto` (`id_producto`),
  ADD KEY `fk_interacciones_clientes` (`id_cliente`),
  ADD KEY `fk_interacciones_servicios` (`id_servicio`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id_producto`),
  ADD KEY `idx_productos_categoria` (`id_categoria_producto`),
  ADD KEY `idx_productos_activo_destacado` (`activo`,`destacado`);

--
-- Indices de la tabla `producto_caracteristicas`
--
ALTER TABLE `producto_caracteristicas`
  ADD PRIMARY KEY (`id_caracteristica`),
  ADD KEY `idx_producto_caracteristicas_producto` (`id_producto`);

--
-- Indices de la tabla `producto_imagenes`
--
ALTER TABLE `producto_imagenes`
  ADD PRIMARY KEY (`id_imagen`),
  ADD KEY `idx_producto_imagenes_producto` (`id_producto`);

--
-- Indices de la tabla `producto_medidas`
--
ALTER TABLE `producto_medidas`
  ADD PRIMARY KEY (`id_medida`),
  ADD KEY `idx_producto_medidas_producto` (`id_producto`);

--
-- Indices de la tabla `producto_tela_colores`
--
ALTER TABLE `producto_tela_colores`
  ADD PRIMARY KEY (`id_producto`,`id_tela_color`),
  ADD KEY `idx_producto_tela_colores_tela_color` (`id_tela_color`),
  ADD KEY `idx_producto_tela_colores_activo` (`activo`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id_rol`),
  ADD UNIQUE KEY `uq_roles_nombre` (`nombre`);

--
-- Indices de la tabla `servicios`
--
ALTER TABLE `servicios`
  ADD PRIMARY KEY (`id_servicio`),
  ADD KEY `idx_servicios_categoria` (`id_categoria_servicio`);

--
-- Indices de la tabla `servicio_imagenes`
--
ALTER TABLE `servicio_imagenes`
  ADD PRIMARY KEY (`id_imagen`),
  ADD KEY `idx_servicio_imagenes_servicio` (`id_servicio`);

--
-- Indices de la tabla `telas`
--
ALTER TABLE `telas`
  ADD PRIMARY KEY (`id_tela`),
  ADD UNIQUE KEY `uq_telas_nombre` (`nombre`),
  ADD KEY `idx_telas_activo_orden` (`activo`,`orden`);

--
-- Indices de la tabla `tela_colores`
--
ALTER TABLE `tela_colores`
  ADD PRIMARY KEY (`id_tela_color`),
  ADD UNIQUE KEY `uq_tela_colores_tela_color` (`id_tela`,`id_color`),
  ADD KEY `idx_tela_colores_color` (`id_color`),
  ADD KEY `idx_tela_colores_disponible` (`disponible`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`),
  ADD UNIQUE KEY `uq_usuarios_email` (`email`),
  ADD UNIQUE KEY `uq_usuarios_usuario` (`usuario`),
  ADD KEY `idx_usuarios_id_rol` (`id_rol`);

--
-- Indices de la tabla `ventas`
--
ALTER TABLE `ventas`
  ADD PRIMARY KEY (`id_venta`),
  ADD KEY `idx_ventas_cliente` (`id_cliente`),
  ADD KEY `idx_ventas_usuario` (`id_usuario`),
  ADD KEY `idx_ventas_fecha` (`fecha`);

--
-- Indices de la tabla `venta_detalles`
--
ALTER TABLE `venta_detalles`
  ADD PRIMARY KEY (`id_detalle`),
  ADD KEY `idx_venta_detalles_venta` (`id_venta`),
  ADD KEY `fk_venta_detalles_productos` (`id_producto`),
  ADD KEY `fk_venta_detalles_servicios` (`id_servicio`);

--
-- Indices de la tabla `visitas_sitio`
--
ALTER TABLE `visitas_sitio`
  ADD PRIMARY KEY (`id_visita`),
  ADD KEY `idx_visitas_fecha` (`fecha_ingreso`),
  ADD KEY `idx_visitas_ip_fecha` (`ip_address`,`fecha_ingreso`),
  ADD KEY `idx_visitas_pagina` (`pagina`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categorias_producto`
--
ALTER TABLE `categorias_producto`
  MODIFY `id_categoria_producto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `categorias_servicio`
--
ALTER TABLE `categorias_servicio`
  MODIFY `id_categoria_servicio` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id_cliente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `colores`
--
ALTER TABLE `colores`
  MODIFY `id_color` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `contenidos_sitio`
--
ALTER TABLE `contenidos_sitio`
  MODIFY `id_contenido` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT de la tabla `interacciones`
--
ALTER TABLE `interacciones`
  MODIFY `id_interaccion` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id_producto` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `producto_caracteristicas`
--
ALTER TABLE `producto_caracteristicas`
  MODIFY `id_caracteristica` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de la tabla `producto_imagenes`
--
ALTER TABLE `producto_imagenes`
  MODIFY `id_imagen` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `producto_medidas`
--
ALTER TABLE `producto_medidas`
  MODIFY `id_medida` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `id_rol` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `servicios`
--
ALTER TABLE `servicios`
  MODIFY `id_servicio` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `servicio_imagenes`
--
ALTER TABLE `servicio_imagenes`
  MODIFY `id_imagen` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `telas`
--
ALTER TABLE `telas`
  MODIFY `id_tela` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `tela_colores`
--
ALTER TABLE `tela_colores`
  MODIFY `id_tela_color` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `ventas`
--
ALTER TABLE `ventas`
  MODIFY `id_venta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `venta_detalles`
--
ALTER TABLE `venta_detalles`
  MODIFY `id_detalle` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `visitas_sitio`
--
ALTER TABLE `visitas_sitio`
  MODIFY `id_visita` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=332;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `interacciones`
--
ALTER TABLE `interacciones`
  ADD CONSTRAINT `fk_interacciones_clientes` FOREIGN KEY (`id_cliente`) REFERENCES `clientes` (`id_cliente`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_interacciones_productos` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id_producto`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_interacciones_servicios` FOREIGN KEY (`id_servicio`) REFERENCES `servicios` (`id_servicio`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Filtros para la tabla `productos`
--
ALTER TABLE `productos`
  ADD CONSTRAINT `fk_productos_categorias_producto` FOREIGN KEY (`id_categoria_producto`) REFERENCES `categorias_producto` (`id_categoria_producto`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `producto_caracteristicas`
--
ALTER TABLE `producto_caracteristicas`
  ADD CONSTRAINT `fk_producto_caracteristicas_productos` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id_producto`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `producto_imagenes`
--
ALTER TABLE `producto_imagenes`
  ADD CONSTRAINT `fk_producto_imagenes_productos` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id_producto`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `producto_medidas`
--
ALTER TABLE `producto_medidas`
  ADD CONSTRAINT `fk_producto_medidas_productos` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id_producto`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `producto_tela_colores`
--
ALTER TABLE `producto_tela_colores`
  ADD CONSTRAINT `fk_producto_tela_colores_productos` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id_producto`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_producto_tela_colores_tela_colores` FOREIGN KEY (`id_tela_color`) REFERENCES `tela_colores` (`id_tela_color`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `servicios`
--
ALTER TABLE `servicios`
  ADD CONSTRAINT `fk_servicios_categorias_servicio` FOREIGN KEY (`id_categoria_servicio`) REFERENCES `categorias_servicio` (`id_categoria_servicio`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `servicio_imagenes`
--
ALTER TABLE `servicio_imagenes`
  ADD CONSTRAINT `fk_servicio_imagenes_servicios` FOREIGN KEY (`id_servicio`) REFERENCES `servicios` (`id_servicio`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `tela_colores`
--
ALTER TABLE `tela_colores`
  ADD CONSTRAINT `fk_tela_colores_colores` FOREIGN KEY (`id_color`) REFERENCES `colores` (`id_color`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_tela_colores_telas` FOREIGN KEY (`id_tela`) REFERENCES `telas` (`id_tela`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `fk_usuarios_roles` FOREIGN KEY (`id_rol`) REFERENCES `roles` (`id_rol`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `ventas`
--
ALTER TABLE `ventas`
  ADD CONSTRAINT `fk_ventas_clientes` FOREIGN KEY (`id_cliente`) REFERENCES `clientes` (`id_cliente`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_ventas_usuarios` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Filtros para la tabla `venta_detalles`
--
ALTER TABLE `venta_detalles`
  ADD CONSTRAINT `fk_venta_detalles_productos` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id_producto`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_venta_detalles_servicios` FOREIGN KEY (`id_servicio`) REFERENCES `servicios` (`id_servicio`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_venta_detalles_ventas` FOREIGN KEY (`id_venta`) REFERENCES `ventas` (`id_venta`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
