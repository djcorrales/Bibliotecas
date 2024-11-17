-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 17-11-2024 a las 06:12:33
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `biblioteca`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`id`, `nombre`) VALUES
(1, 'Literatura'),
(2, 'Novela'),
(3, 'Ciencia Ficción');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `libros`
--

CREATE TABLE `libros` (
  `id` int(11) NOT NULL,
  `titulo` varchar(255) NOT NULL,
  `autor` varchar(100) NOT NULL,
  `isbn` varchar(20) DEFAULT NULL,
  `fecha_publicacion` date DEFAULT NULL,
  `categoria` varchar(50) DEFAULT NULL,
  `cantidad` int(11) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `libros`
--

INSERT INTO `libros` (`id`, `titulo`, `autor`, `isbn`, `fecha_publicacion`, `categoria`, `cantidad`) VALUES
(39, 'Cien años de soledad', 'Gabriel García Márquez', '9780060883287', '1967-06-05', 'Novela', 14),
(40, 'Don Quijote de la Mancha', 'Miguel de Cervantes', '9788491051073', '1605-01-16', 'Clásico', 3),
(41, '1984', 'George Orwell', '9780451524935', '1949-06-08', 'Distopía', 4),
(42, 'Orgullo y prejuicio', 'Jane Austen', '9780141199078', '1813-01-28', 'Romance', 6),
(43, 'La Odisea', 'Homero', '9780140268867', '0800-12-01', 'Épico', 2),
(44, 'Crimen y castigo', 'Fiódor Dostoyevski', '9780143058144', '1866-01-01', 'Novela', 3),
(45, 'La Metamorfosis', 'Franz Kafka', '9780140187475', '1915-11-13', 'Ficción', 5),
(46, 'El Gran Gatsby', 'F. Scott Fitzgerald', '9780743273565', '1925-04-10', 'Novela', 7),
(47, 'Fahrenheit 451', 'Ray Bradbury', '9781451673319', '1953-10-19', 'Distopía', 4),
(48, 'Matar a un ruiseñor', 'Harper Lee', '9780061120084', '1960-07-11', 'Ficción', 5),
(49, 'El amor en los tiempos del cólera', 'Gabriel García Márquez', '9780307389732', '1985-12-10', 'Romance', 3),
(50, 'El viejo y el mar', 'Ernest Hemingway', '9780684830490', '1952-09-01', 'Novela', 6),
(51, 'Hamlet', 'William Shakespeare', '9780451526922', '1609-01-01', 'Tragedia', 2),
(52, 'El guardián entre el centeno', 'J.D. Salinger', '9780316769488', '1951-07-16', 'Ficción', 5),
(53, 'La divina comedia', 'Dante Alighieri', '9780140448955', '1320-01-01', 'Poema', 3),
(54, 'Los miserables', 'Victor Hugo', '9780451419439', '1862-01-01', 'Novela', 2),
(55, 'Drácula', 'Bram Stoker', '9780141439846', '1897-05-26', 'Terror', 4),
(56, 'En busca del tiempo perdido', 'Marcel Proust', '9780142437964', '1913-01-01', 'Ficción', 3),
(57, 'El arte de la guerra', 'Sun Tzu', '9780143105756', '0500-01-01', 'Filosofía', 6),
(58, 'Ulises', 'James Joyce', '9780141182803', '1922-02-02', 'Novela', 2),
(90, 'hghhg', 'amor', 'dfgdfg', '2024-11-06', '2', 1),
(91, 'hhhhhh', 'sdfgdfg', '4', '2024-11-05', '2', 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `libros_categorias`
--

CREATE TABLE `libros_categorias` (
  `libro_id` int(11) NOT NULL,
  `categoria_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `prestamos`
--

CREATE TABLE `prestamos` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `libro_id` int(11) NOT NULL,
  `fecha_prestamo` date NOT NULL,
  `fecha_devolucion` date DEFAULT NULL,
  `estado` enum('Prestado','Devuelto') DEFAULT 'Prestado'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `prestamos`
--

INSERT INTO `prestamos` (`id`, `usuario_id`, `libro_id`, `fecha_prestamo`, `fecha_devolucion`, `estado`) VALUES
(100, 67, 45, '2024-11-16', '2024-11-16', 'Devuelto');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`id`, `nombre`) VALUES
(1, 'Administrador'),
(2, 'Usuario'),
(3, 'Moderador');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nombre_completo` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `role_id` int(11) DEFAULT NULL,
  `fecha_registro` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `username`, `password`, `nombre_completo`, `email`, `role_id`, `fecha_registro`) VALUES
(66, 'admin', '$2y$10$DVwNI7ln5RCYYp8i.6uUlu6TbeRCIkDbwgqgFpy446.ytf84RrZA6', 'Dainier', 'djcorrales9@misena.edu.co', 1, '2024-11-16 15:35:44'),
(67, 'usuario', '$2y$10$uOukEFieC2A5vDMEtSLvNuERSI9GWunmVZGQCMxqiU0faAj4dDgGS', 'usuario', 'usuario@gmail.com', 2, '2024-11-16 15:37:03'),
(68, 'admin4', '$2y$10$xj2G6QBpqZeuub0rKQ.VP.LnTERqx3xT8UEzdjz/nAwOB6X9k2x3m', 'corrales...', 'ROMEROALROAL27@GMAIL.COM', 2, '2024-11-16 16:38:25');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `libros`
--
ALTER TABLE `libros`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `isbn` (`isbn`),
  ADD UNIQUE KEY `isbn_2` (`isbn`);

--
-- Indices de la tabla `libros_categorias`
--
ALTER TABLE `libros_categorias`
  ADD PRIMARY KEY (`libro_id`,`categoria_id`),
  ADD KEY `categoria_id` (`categoria_id`);

--
-- Indices de la tabla `prestamos`
--
ALTER TABLE `prestamos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_id` (`usuario_id`),
  ADD KEY `libro_id` (`libro_id`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `role_id` (`role_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `libros`
--
ALTER TABLE `libros`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=92;

--
-- AUTO_INCREMENT de la tabla `prestamos`
--
ALTER TABLE `prestamos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=101;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `libros_categorias`
--
ALTER TABLE `libros_categorias`
  ADD CONSTRAINT `libros_categorias_ibfk_1` FOREIGN KEY (`libro_id`) REFERENCES `libros` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `libros_categorias_ibfk_2` FOREIGN KEY (`categoria_id`) REFERENCES `categorias` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `prestamos`
--
ALTER TABLE `prestamos`
  ADD CONSTRAINT `prestamos_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `prestamos_ibfk_2` FOREIGN KEY (`libro_id`) REFERENCES `libros` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `usuarios_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
