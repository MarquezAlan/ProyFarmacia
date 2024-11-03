-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 13-06-2024 a las 18:56:43
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
-- Base de datos: `farmacia_ucb`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `contactos`
--

CREATE TABLE `contactos` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `mensaje` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedidos`
--

CREATE TABLE `pedidos` (
  `id` int(11) NOT NULL,
  `numero_pedido` varchar(50) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `precio` decimal(10,2) NOT NULL,
  `costo_envio` decimal(10,2) DEFAULT NULL,
  `total` decimal(10,2) NOT NULL,
  `fecha_entrega` date DEFAULT NULL,
  `usuario` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `pedidos`
--

INSERT INTO `pedidos` (`id`, `numero_pedido`, `id_producto`, `precio`, `costo_envio`, `total`, `fecha_entrega`, `usuario`) VALUES
(19, '1001', 1, 5.99, 56.00, 61.99, '2024-03-20', 'marquez'),
(20, '1002', 2, 7.99, 2545.50, 2553.49, '2024-03-21', 'marquez'),
(21, '1003', 3, 10.99, 3.00, 13.99, '2024-03-22', 'marquez'),
(22, '1004', 4, 8.99, 2.00, 10.99, '2024-03-23', 'marquez'),
(23, '1005', 5, 12.99, 2.50, 15.49, '2024-03-24', 'marquez'),
(24, '1006', 6, 15.99, 3.00, 18.99, '2024-03-25', 'marquez'),
(25, '666b10ea248db', 1, 5.99, 5.00, 10.99, '2024-06-16', 'marquez'),
(26, '666b1f1816d07', 6, 15.99, 5.00, 47.97, '2024-06-16', 'marquez'),
(27, '666b2357e0647', 3, 10.99, 5.00, 10.99, '2024-06-16', 'marquez'),
(28, '666b23c2bf76b', 5, 12.99, 5.00, 12.99, '2024-06-16', 'marquez');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `categoria` varchar(50) NOT NULL,
  `descripcion` text NOT NULL,
  `precio` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id`, `nombre`, `categoria`, `descripcion`, `precio`) VALUES
(1, 'Paracetamol', 'Analgesico', 'Paracetamol es un medicamento utilizado para reducir la fiebre y aliviar el dolor.', 6.00),
(2, 'Ibuprofeno', 'Antiinflamatorio', 'Ibuprofeno es un antiinflamatorio no esteroideo utilizado para reducir el dolor y la inflamación.', 7.99),
(3, 'Omeprazol', 'Gastrointestinal', 'Omeprazol es un medicamento utilizado para reducir la acidez estomacal y tratar el reflujo.', 10.99),
(4, 'Loratadina', 'Antialergico', 'Loratadina es un antihistamínico utilizado para aliviar los síntomas de la alergia.', 8.99),
(5, 'Amoxicilina', 'Antibiotico', 'Amoxicilina es un antibiótico utilizado para tratar diversas infecciones bacterianas.', 12.99),
(6, 'Salbutamol', 'Broncodilatador', 'Salbutamol es un broncodilatador utilizado para aliviar los síntomas del asma y otras enfermedades pulmonares.', 15.99),
(7, 'Metformina', 'Antidiabetico', 'Metformina es un medicamento utilizado para controlar los niveles de azúcar en sangre en pacientes con diabetes tipo 2.', 9.99),
(8, 'Atorvastatina', 'Hipolipemiante', 'Atorvastatina es un medicamento utilizado para reducir los niveles de colesterol en sangre.', 14.99),
(9, 'Aspirina', 'Anticoagulante', 'Aspirina es un medicamento utilizado para aliviar el dolor, reducir la fiebre y como anticoagulante para prevenir ataques cardíacos.', 6.99),
(10, 'Cetirizina', 'Antialergico', 'Cetirizina es un antihistamínico utilizado para aliviar los síntomas de la alergia.', 7.99);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `usuario` varchar(255) NOT NULL,
  `contraseña` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `usuario`, `contraseña`) VALUES
(1, 'marquez', '12345');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `contactos`
--
ALTER TABLE `contactos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_id_producto` (`id_producto`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `contactos`
--
ALTER TABLE `contactos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD CONSTRAINT `fk_id_producto` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
