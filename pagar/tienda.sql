-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 06-10-2020 a las 02:17:04
-- Versión del servidor: 5.7.26
-- Versión de PHP: 7.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `tienda`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbldetalleventa`
--

DROP TABLE IF EXISTS `tbldetalleventa`;
CREATE TABLE IF NOT EXISTS `tbldetalleventa` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `IDVENTA` int(11) NOT NULL,
  `IDPRODUCTO` int(11) NOT NULL,
  `PRECIOUNITARIO` double(20,2) NOT NULL,
  `CANTIDAD` int(11) NOT NULL,
  `DESCARGADO` int(1) NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `IDVENTA` (`IDVENTA`),
  KEY `IDPRODUCTO` (`IDPRODUCTO`)
) ENGINE=MyISAM AUTO_INCREMENT=22 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `tbldetalleventa`
--

INSERT INTO `tbldetalleventa` (`ID`, `IDVENTA`, `IDPRODUCTO`, `PRECIOUNITARIO`, `CANTIDAD`, `DESCARGADO`) VALUES
(1, 5, 1, 300.00, 1, 0),
(2, 5, 2, 400.00, 1, 0),
(3, 6, 1, 300.00, 1, 0),
(4, 6, 2, 400.00, 1, 0),
(5, 7, 1, 300.00, 1, 0),
(6, 7, 2, 400.00, 1, 0),
(7, 8, 1, 300.00, 1, 0),
(8, 8, 2, 400.00, 1, 0),
(9, 9, 1, 300.00, 1, 0),
(10, 9, 2, 400.00, 1, 0),
(11, 10, 1, 300.00, 1, 0),
(12, 10, 2, 400.00, 1, 0),
(13, 11, 1, 300.00, 1, 0),
(14, 11, 2, 400.00, 1, 0),
(15, 12, 1, 300.00, 1, 0),
(16, 12, 2, 400.00, 1, 0),
(17, 13, 1, 300.00, 1, 0),
(18, 13, 2, 400.00, 1, 0),
(19, 14, 1, 300.00, 1, 0),
(20, 14, 2, 400.00, 1, 0),
(21, 15, 2, 400.00, 1, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tblproductos`
--

DROP TABLE IF EXISTS `tblproductos`;
CREATE TABLE IF NOT EXISTS `tblproductos` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(255) COLLATE utf8_spanish2_ci NOT NULL,
  `Precio` double(20,2) NOT NULL,
  `Descripcion` text COLLATE utf8_spanish2_ci NOT NULL,
  `imagen` varchar(255) COLLATE utf8_spanish2_ci NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `tblproductos`
--

INSERT INTO `tblproductos` (`ID`, `Nombre`, `Precio`, `Descripcion`, `imagen`) VALUES
(1, 'php', 300.00, 'Lorem ipsum, dolor sit amet consectetur adipisicing elit. Voluptatem excepturi non expedita modi molestiae ratione sit earum omnis voluptatum facere dicta rem repellendus corrupti nisi amet, soluta, incidunt dolorem consequuntur.', 'https://d1w7fb2mkkr3kw.cloudfront.net/assets/images/book/lrg/9781/4842/9781484217290.jpg'),
(2, 'java', 400.00, 'Lorem ipsum, dolor sit amet consectetur adipisicing elit. Voluptatem excepturi non expedita modi molestiae ratione sit earum omnis voluptatum facere dicta rem repellendus corrupti nisi amet, soluta, incidunt dolorem consequuntur.', 'https://d1w7fb2mkkr3kw.cloudfront.net/assets/images/book/lrg/9781/4842/9781484217290.jpg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tblventas`
--

DROP TABLE IF EXISTS `tblventas`;
CREATE TABLE IF NOT EXISTS `tblventas` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `ClaveTransaccion` varchar(250) COLLATE utf8_spanish2_ci NOT NULL,
  `PaypalDatos` text COLLATE utf8_spanish2_ci NOT NULL,
  `Fecha` datetime NOT NULL,
  `Correo` varchar(5000) COLLATE utf8_spanish2_ci NOT NULL,
  `Total` double(60,2) NOT NULL,
  `status` varchar(200) COLLATE utf8_spanish2_ci NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `tblventas`
--

INSERT INTO `tblventas` (`ID`, `ClaveTransaccion`, `PaypalDatos`, `Fecha`, `Correo`, `Total`, `status`) VALUES
(1, '1234567890', '', '2020-10-05 00:00:00', 'medina@gmail.com', 300.00, 'Pendiente'),
(2, '1234567890', '', '2020-10-05 00:00:00', 'medina@gmail.com', 300.00, 'Pendiente'),
(3, '0is5jbrksgns42fhngqlglnuqe', '', '2020-10-05 14:12:17', 'medina@itsva.edu.mx', 300.00, 'Pendiente'),
(4, '0is5jbrksgns42fhngqlglnuqe', '', '2020-10-05 14:14:00', 'medina@gmail.com', 700.00, 'Pendiente'),
(5, '0is5jbrksgns42fhngqlglnuqe', '', '2020-10-05 14:44:51', 'medina@gmail.com', 0.00, 'Pendiente'),
(6, '0is5jbrksgns42fhngqlglnuqe', '', '2020-10-05 14:48:04', 'medina@gmail.com', 700.00, 'Pendiente'),
(7, '0is5jbrksgns42fhngqlglnuqe', '', '2020-10-05 15:29:20', 'medina@gmail.com', 700.00, 'Pendiente'),
(8, '0is5jbrksgns42fhngqlglnuqe', '', '2020-10-05 15:37:14', 'medina@gmail.com', 700.00, 'Pendiente'),
(9, '0is5jbrksgns42fhngqlglnuqe', '', '2020-10-05 15:42:22', 'medina@gmail.com', 700.00, 'Pendiente'),
(10, '0is5jbrksgns42fhngqlglnuqe', '', '2020-10-05 15:45:02', 'medina@gmail.com', 700.00, 'Pendiente'),
(11, '0is5jbrksgns42fhngqlglnuqe', '', '2020-10-05 15:45:12', 'medina@gmail.com', 700.00, 'Pendiente'),
(12, '0is5jbrksgns42fhngqlglnuqe', '', '2020-10-05 15:46:44', 'medina@gmail.com', 700.00, 'Pendiente'),
(13, '0is5jbrksgns42fhngqlglnuqe', '', '2020-10-05 15:53:11', 'medina@gmail.com', 700.00, 'Pendiente'),
(14, '0is5jbrksgns42fhngqlglnuqe', '', '2020-10-05 15:54:10', 'medina@gmail.com', 700.00, 'Pendiente'),
(15, '0is5jbrksgns42fhngqlglnuqe', '', '2020-10-05 15:55:33', 'medina@itsva.edu.mx', 400.00, 'Pendiente');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE IF NOT EXISTS `usuarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `usuario` varchar(60) COLLATE utf8_spanish2_ci NOT NULL,
  `nombre` varchar(60) COLLATE utf8_spanish2_ci NOT NULL,
  `apellido` varchar(60) COLLATE utf8_spanish2_ci NOT NULL,
  `telefono` bigint(20) NOT NULL,
  `email` varchar(60) COLLATE utf8_spanish2_ci NOT NULL,
  `password` varchar(100) COLLATE utf8_spanish2_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `usuario`, `nombre`, `apellido`, `telefono`, `email`, `password`) VALUES
(1, 'mario', 'Mario', 'Zapata', 8547222, 'marito23@gmail.com', '202cb962ac59075b964b07152d234b70'),
(3, 'Pedro32', 'Pedro', 'contreras', 4564564, 'pedro4@gmail.com', 'password'),
(4, 'Juan23', 'juan Pablo', 'contreras', 123132, 'juan@h.com', 'dcb82435c8525869fd04b7214118c3d2'),
(5, 'Rober', 'Roberto', 'Contreras', 875454, 'robe@gmail.com', 'e10adc3949ba59abbe56e057f20f883e'),
(6, 'Carlos3', 'Carlos', 'Benites', 456421321, 'carlos@hotmail.com', 'e10adc3949ba59abbe56e057f20f883e'),
(7, 'Pablod', 'Pablo', 'Sarsuri', 1223145, 'pa@gmail.com', 'e10adc3949ba59abbe56e057f20f883e'),
(10, 'fran', 'Francisco', 'ChacÃ³n', 34234, 'das@g.com', '202cb962ac59075b964b07152d234b70'),
(18, 'Ruperto56', 'Rouperto Juan', 'Contreras', 5842, 'ruperto@gmail.com', 'e10adc3949ba59abbe56e057f20f883e'),
(19, 'Mariano22', 'Jose Mariano', 'Berrios ', 5874112, 'Jose32ma@hotmail.com', '5029515650dea33e940095bb8b75a51a'),
(20, 'carlos2', 'Carlos', 'Martinez', 54321321, 'carlos@gmail.com', 'a3f0bec59cebeb60553ec80bbfd5dfdf');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
