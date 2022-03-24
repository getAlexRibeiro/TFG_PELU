-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
-- Autor: Alexandre Ribeiro Pérola
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 30-11-2021 a las 07:49:48
-- Versión del servidor: 8.0.21
-- Versión de PHP: 7.3.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `peluqueria`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `bookings`
--

DROP TABLE IF EXISTS `bookings`;
CREATE TABLE IF NOT EXISTS `bookings` (
  `id_bookings` int NOT NULL AUTO_INCREMENT,
  `name` varchar(25) NOT NULL,
  `email` varchar(25) DEFAULT NULL,
  `date` date NOT NULL,
  `timeslot` varchar(255) NOT NULL,
  PRIMARY KEY (`id_bookings`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--


-- HOLA VIKERS
DROP TABLE IF EXISTS `clientes`;
CREATE TABLE IF NOT EXISTS `clientes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(25) CHARACTER SET utf8mb4 NOT NULL,
  `email` varchar(25) DEFAULT NULL,
  `password` varchar(25) CHARACTER SET utf8mb4 NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4;


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

DROP TABLE IF EXISTS `productos`;
CREATE TABLE IF NOT EXISTS `productos` (
  `id_productos` int NOT NULL AUTO_INCREMENT,
  `name` varchar(25) NOT NULL,
  `price` int DEFAULT NULL,
  `cantidad` int NOT NULL,
  PRIMARY KEY (`id_productos`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `servicios`
--

INSERT INTO `productos` (`id_productos`, `name`, `price`, `cantidad`) VALUES
(1, 'champú', 10, 100),
(2, 'secador', 10, 100);


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `servicios`
--

DROP TABLE IF EXISTS `servicios`;
CREATE TABLE IF NOT EXISTS `servicios` (
  `id_servicios` int NOT NULL AUTO_INCREMENT,
  `name_servicio` varchar(25) NOT NULL,
  `price_servicio` int NOT NULL,
  PRIMARY KEY (`id_servicios`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `servicios`
--

INSERT INTO `servicios` (`id_servicios`, `name_servicio`, `price_servicio`) VALUES
(1, 'Lavar y Marcar', '15');
INSERT INTO `servicios` (`id_servicios`, `name_servicio`, `price_servicio`) VALUES
(2, 'Cortar Señoras', '12');
INSERT INTO `servicios` (`id_servicios`, `name_servicio`, `price_servicio`) VALUES
(3, 'Cortar Caballeros', '10');
INSERT INTO `servicios` (`id_servicios`, `name_servicio`, `price_servicio`) VALUES
(4, 'Corte niños hasta 7 años', '5');
INSERT INTO `servicios` (`id_servicios`, `name_servicio`, `price_servicio`) VALUES
(5, 'Tinte', '25');
INSERT INTO `servicios` (`id_servicios`, `name_servicio`, `price_servicio`) VALUES
(6, 'Mechas', '32');
INSERT INTO `servicios` (`id_servicios`, `name_servicio`, `price_servicio`) VALUES
(7, 'Tinte y mechas', '40');
INSERT INTO `servicios` (`id_servicios`, `name_servicio`, `price_servicio`) VALUES
(8, 'Moldeador', '35');
INSERT INTO `servicios` (`id_servicios`, `name_servicio`, `price_servicio`) VALUES
(9, 'Recogidos', '32');




COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
