-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 26-01-2021 a las 00:33:29
-- Versión del servidor: 5.7.31
-- Versión de PHP: 7.3.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `congreso`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `administradores`
--

DROP TABLE IF EXISTS `administradores`;
CREATE TABLE IF NOT EXISTS `administradores` (
  `id_admin` int(11) NOT NULL AUTO_INCREMENT,
  `correo_admin` varchar(60) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `nombre_admin` varchar(100) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `eliminacion` varchar(20) COLLATE utf8mb4_spanish2_ci DEFAULT NULL,
  `id_user` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_admin`),
  UNIQUE KEY `id_admin` (`id_admin`),
  UNIQUE KEY `correo_admin` (`correo_admin`),
  KEY `IX_Relationship2` (`id_user`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `administradores`
--

INSERT INTO `administradores` (`id_admin`, `correo_admin`, `nombre_admin`, `eliminacion`, `id_user`) VALUES
(1, 'admin', 'administrador', '1', 6);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `admin_carreras`
--

DROP TABLE IF EXISTS `admin_carreras`;
CREATE TABLE IF NOT EXISTS `admin_carreras` (
  `id_adminCarrera` int(11) NOT NULL AUTO_INCREMENT,
  `nombre_adminCarrera` varchar(100) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `estado_registro` int(11) NOT NULL,
  `carrera` varchar(60) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `id_user` int(11) DEFAULT NULL,
  `id_imagen` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_adminCarrera`),
  UNIQUE KEY `id_adminCarrera` (`id_adminCarrera`),
  UNIQUE KEY `carrera` (`carrera`),
  KEY `IX_Relationship4` (`id_user`),
  KEY `IX_Relationship7` (`id_imagen`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `admin_carreras`
--

INSERT INTO `admin_carreras` (`id_adminCarrera`, `nombre_adminCarrera`, `estado_registro`, `carrera`, `id_user`, `id_imagen`) VALUES
(5, 'Ing. Russell Renan Luit Manzanero', 0, 'IngenierÃ­a en sistemas computacionales', 55, 9);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `alumnos`
--

DROP TABLE IF EXISTS `alumnos`;
CREATE TABLE IF NOT EXISTS `alumnos` (
  `id_alumno` int(11) NOT NULL AUTO_INCREMENT,
  `nombre_alumno` varchar(100) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `apellido_alumno` varchar(100) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `matricula` varchar(15) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `semestre_grupo` varchar(20) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `status_alumno` int(2) NOT NULL,
  `comentarios` varchar(200) COLLATE utf8mb4_spanish2_ci DEFAULT NULL,
  `id_user` int(11) NOT NULL,
  `id_adminCarrera` int(11) NOT NULL,
  `id_taller` int(11) DEFAULT NULL,
  `id_concurso` int(11) DEFAULT NULL,
  `id_equipo` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_alumno`,`id_adminCarrera`),
  UNIQUE KEY `id_alumno` (`id_alumno`),
  UNIQUE KEY `matricula` (`matricula`),
  KEY `IX_Relationship5` (`id_user`),
  KEY `Relationship21` (`id_adminCarrera`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `alumnos`
--

INSERT INTO `alumnos` (`id_alumno`, `nombre_alumno`, `apellido_alumno`, `matricula`, `semestre_grupo`, `status_alumno`, `comentarios`, `id_user`, `id_adminCarrera`, `id_taller`, `id_concurso`, `id_equipo`) VALUES
(23, 'Jesus Alberto', 'Medina Dzib', '16070022', '3Âº B', 1, NULL, 58, 5, 7, 8, 2),
(24, 'karina', 'Chiguil', '16070014', '8Âº A', 1, NULL, 59, 5, 8, 8, 2),
(25, 'Minelle', 'Ciau', '16070010', '7Âº A', 1, NULL, 69, 5, 7, 2, NULL),
(26, 'Maria', 'Mercedez', '16070088', '7Âº B', 1, NULL, 70, 5, 7, 8, 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `alumnos_conferencias`
--

DROP TABLE IF EXISTS `alumnos_conferencias`;
CREATE TABLE IF NOT EXISTS `alumnos_conferencias` (
  `id_alumno` int(11) NOT NULL,
  `id_conferencia` int(11) NOT NULL,
  PRIMARY KEY (`id_alumno`,`id_conferencia`),
  KEY `Relationship25` (`id_conferencia`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `alumnos_conferencias`
--

INSERT INTO `alumnos_conferencias` (`id_alumno`, `id_conferencia`) VALUES
(23, 3),
(24, 3),
(25, 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `avisos`
--

DROP TABLE IF EXISTS `avisos`;
CREATE TABLE IF NOT EXISTS `avisos` (
  `id_aviso` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(1000) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `fecha` varchar(50) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `id_adminCarrera` int(11) NOT NULL,
  PRIMARY KEY (`id_aviso`,`id_adminCarrera`),
  UNIQUE KEY `id_aviso` (`id_aviso`),
  KEY `Relationship8` (`id_adminCarrera`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `concursos`
--

DROP TABLE IF EXISTS `concursos`;
CREATE TABLE IF NOT EXISTS `concursos` (
  `id_concurso` int(11) NOT NULL AUTO_INCREMENT,
  `nombre_concurso` varchar(255) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `imagen_concurso` varchar(255) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `lugar_concurso` varchar(50) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `descripcion_concurso` text COLLATE utf8mb4_spanish2_ci NOT NULL,
  `cupo_concurso` int(11) NOT NULL,
  `modalidad` int(2) DEFAULT NULL COMMENT '1=Individual, 2=grupal',
  `max_alumnos_grupal` int(11) DEFAULT NULL,
  `id_instructor` int(11) NOT NULL,
  PRIMARY KEY (`id_concurso`,`id_instructor`),
  UNIQUE KEY `id_concurso` (`id_concurso`),
  KEY `Relationship13` (`id_instructor`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `concursos`
--

INSERT INTO `concursos` (`id_concurso`, `nombre_concurso`, `imagen_concurso`, `lugar_concurso`, `descripcion_concurso`, `cupo_concurso`, `modalidad`, `max_alumnos_grupal`, `id_instructor`) VALUES
(2, 'Primer concurso Virtual de programaciÃ³n ', '853612.jpg', 'Virtual', '<p>asd</p>\r\n', 5, 1, NULL, 6),
(3, 'Concurso de programaciÃ³n', '1524846.jpg', 'Virtual', '<p>asd</p>\r\n', 12, 2, 4, 1),
(8, 'Concurso de programaciÃ³n', '257860.jpg', 'Virtual', '<p>a</p>\r\n\r\n<p>&nbsp;</p>\r\n', 2, 2, 3, 5);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `conferencias`
--

DROP TABLE IF EXISTS `conferencias`;
CREATE TABLE IF NOT EXISTS `conferencias` (
  `id_conferencia` int(11) NOT NULL AUTO_INCREMENT,
  `nombre_conferencia` varchar(100) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `imagen_conferencia` varchar(255) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `lugar_conferencia` varchar(50) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `descripcion_conferencia` text COLLATE utf8mb4_spanish2_ci NOT NULL,
  `cupo_conferencia` int(11) NOT NULL,
  `id_instructor` int(11) NOT NULL,
  PRIMARY KEY (`id_instructor`,`id_conferencia`),
  UNIQUE KEY `id_conferencias` (`id_conferencia`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `conferencias`
--

INSERT INTO `conferencias` (`id_conferencia`, `nombre_conferencia`, `imagen_conferencia`, `lugar_conferencia`, `descripcion_conferencia`, `cupo_conferencia`, `id_instructor`) VALUES
(2, 'Tips para emprendedores', '2323240.jpg', 'Zoom', '<p>a</p>\r\n', 15, 1),
(3, 'Tips para emprendedores II', '1242581.jpg', 'A1', '<p>asd</p>\r\n', 15, 7);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `correos`
--

DROP TABLE IF EXISTS `correos`;
CREATE TABLE IF NOT EXISTS `correos` (
  `id_correo` int(3) NOT NULL AUTO_INCREMENT,
  `correo` varchar(50) COLLATE utf8mb4_spanish2_ci NOT NULL,
  PRIMARY KEY (`id_correo`),
  UNIQUE KEY `id_correo` (`id_correo`),
  UNIQUE KEY `correo` (`correo`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `correos`
--

INSERT INTO `correos` (`id_correo`, `correo`) VALUES
(4, '@gmail.com'),
(3, '@itsva.com'),
(2, '@itsva.edu.mx');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `equipos`
--

DROP TABLE IF EXISTS `equipos`;
CREATE TABLE IF NOT EXISTS `equipos` (
  `id_equipo` int(11) NOT NULL AUTO_INCREMENT,
  `nomEquipo` varchar(200) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `id_jefe_equipo` int(11) NOT NULL,
  `id_concurso` int(11) NOT NULL,
  PRIMARY KEY (`id_equipo`,`id_concurso`),
  UNIQUE KEY `id_equipo` (`id_equipo`),
  KEY `Relationship20` (`id_concurso`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `equipos`
--

INSERT INTO `equipos` (`id_equipo`, `nomEquipo`, `id_jefe_equipo`, `id_concurso`) VALUES
(2, 'Java', 23, 8),
(3, 'C++', 26, 8);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `instructores`
--

DROP TABLE IF EXISTS `instructores`;
CREATE TABLE IF NOT EXISTS `instructores` (
  `id_instructor` int(11) NOT NULL AUTO_INCREMENT,
  `nombre_instructor` varchar(50) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `apellido_instructor` varchar(50) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `clave` varchar(50) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `status_instructor` int(11) NOT NULL,
  `id_user` int(11) DEFAULT NULL,
  `id_adminCarrera` int(11) NOT NULL,
  PRIMARY KEY (`id_instructor`,`id_adminCarrera`),
  UNIQUE KEY `id_instructor` (`id_instructor`),
  KEY `IX_Relationship6` (`id_user`),
  KEY `Relationship22` (`id_adminCarrera`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `instructores`
--

INSERT INTO `instructores` (`id_instructor`, `nombre_instructor`, `apellido_instructor`, `clave`, `status_instructor`, `id_user`, `id_adminCarrera`) VALUES
(1, 'Jorge', 'Pool', '4444', 1, 60, 5),
(5, 'Felipe ', 'Chan', ' ', 1, 65, 5),
(6, 'Pablo Martin ', 'Ramirez Chan', ' ', 1, 66, 5),
(7, 'ING MATILDE ', 'TUN CHI', ' ', 1, 67, 5),
(8, 'Yessenia', 'Cetina Marrufo', ' ', 1, 68, 5);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `logos`
--

DROP TABLE IF EXISTS `logos`;
CREATE TABLE IF NOT EXISTS `logos` (
  `id_imagen` int(11) NOT NULL AUTO_INCREMENT,
  `imagen` varchar(255) COLLATE utf8mb4_spanish2_ci NOT NULL,
  PRIMARY KEY (`id_imagen`),
  UNIQUE KEY `id_imagen` (`id_imagen`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `logos`
--

INSERT INTO `logos` (`id_imagen`, `imagen`) VALUES
(9, '1839042.jpg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

DROP TABLE IF EXISTS `roles`;
CREATE TABLE IF NOT EXISTS `roles` (
  `id_rol` int(11) NOT NULL AUTO_INCREMENT,
  `rol` varchar(50) COLLATE utf8mb4_spanish2_ci NOT NULL,
  PRIMARY KEY (`id_rol`),
  UNIQUE KEY `id_rol` (`id_rol`),
  UNIQUE KEY `rol` (`rol`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`id_rol`, `rol`) VALUES
(1, 'administrador'),
(2, 'administrador_carrera'),
(4, 'alumno'),
(3, 'instructor');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `semestre_grupo`
--

DROP TABLE IF EXISTS `semestre_grupo`;
CREATE TABLE IF NOT EXISTS `semestre_grupo` (
  `id_semestre_grupo` int(11) NOT NULL AUTO_INCREMENT,
  `semestre_grupo` varchar(20) COLLATE latin1_spanish_ci NOT NULL,
  PRIMARY KEY (`id_semestre_grupo`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

--
-- Volcado de datos para la tabla `semestre_grupo`
--

INSERT INTO `semestre_grupo` (`id_semestre_grupo`, `semestre_grupo`) VALUES
(1, '3Âº B'),
(2, '7Âº A'),
(3, '7Âº B'),
(4, '8Âº A'),
(5, '8Â° B'),
(6, '9Â° A');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `talleres`
--

DROP TABLE IF EXISTS `talleres`;
CREATE TABLE IF NOT EXISTS `talleres` (
  `id_taller` int(11) NOT NULL AUTO_INCREMENT,
  `nombre_taller` varchar(255) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `imagen_taller` varchar(200) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `lugar_taller` varchar(200) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `cupo_taller` int(11) NOT NULL,
  `descripcion_taller` text COLLATE utf8mb4_spanish2_ci NOT NULL,
  `id_instructor` int(11) NOT NULL,
  PRIMARY KEY (`id_taller`,`id_instructor`),
  UNIQUE KEY `id_taller` (`id_taller`),
  KEY `Relationship12` (`id_instructor`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `talleres`
--

INSERT INTO `talleres` (`id_taller`, `nombre_taller`, `imagen_taller`, `lugar_taller`, `cupo_taller`, `descripcion_taller`, `id_instructor`) VALUES
(7, 'PHP CON FRAMEWORK YII2', '1633832.jpg', 'VIDEOCONFERENCIA', 13, '<p>lorem ipsum dolor sit amet consectetur adipiscing elit sed do eiusmod tempor incididunt ut labore et&nbsp;</p>\r\n', 8),
(8, 'Herramientas para la nube ', '852454.jpg', 'VIDEOCONFERENCIA', 1, '<p>lorem ipsum dolor sit amet consectetur adipiscing elit sed do eiusmod tempor incididunt ut labore et&nbsp;lorem ipsum dolor sit amet consectetur adipiscing elit sed do eiusmod tempor incididunt ut labore et&nbsp;</p>\r\n', 1),
(9, 'MolÃ©culas de agua ', '886399.jpg', 'VIDEOCONFERENCIA', 15, '<p>lorem ipsum dolor sit amet consectetur adipiscing elit sed do eiusmod tempor incididunt ut labore et&nbsp;</p>\r\n', 6);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id_user` int(11) NOT NULL AUTO_INCREMENT,
  `correo_user` varchar(100) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `password` varchar(150) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `id_rol` int(11) NOT NULL,
  PRIMARY KEY (`id_user`,`id_rol`),
  UNIQUE KEY `id_user` (`id_user`),
  UNIQUE KEY `correo_user` (`correo_user`),
  KEY `Relationship1` (`id_rol`)
) ENGINE=InnoDB AUTO_INCREMENT=71 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id_user`, `correo_user`, `password`, `id_rol`) VALUES
(6, 'administrador', '$2y$15$q6s/5vomkK2zlYrKCJsljuEayp7.plMOQNQFU.IQ4izQgDi3JJayu', 1),
(55, 'sistemas', '$2y$15$rIEcUdOSrtBU76Ae2aGRge0/NcrsmwS8LL5PwvIpV8rmrU.X/mxxa', 2),
(58, 'medina@itsva.edu.mx', '$2y$15$2y.357dNX1VzGd4q6wMo/us4.DXEK3BDaLvN2E8liHq9HProtW3Ga', 4),
(59, 'karina@itsva.edu.mx', '$2y$15$SuVwx1G0Rw76TgGaW/n50uuawFD28YAOdiowtZZ4XB76ywg10m0xO', 4),
(60, 'jorge@itsva.edu.mx', '$2y$15$wql9xoQNkzTMamHUrHwNAOYHo2Wdxa3gvgKLm3PhF25Xn7YHe5cVa', 3),
(65, 'felipe@itsva.edu.mx', '$2y$15$WjtDrTGs2YnukpZk4YpJJ.LdUNts.CBFpXU6Exs9zYRjG1.CsAmQ.', 3),
(66, 'pablo@itsva.edu.mx', '$2y$15$VH7fCuv/Brm1HPg.r0WjCu1NOCcx1a6JAaUCy2Uvgj4lZj7jjKAlW', 3),
(67, 'matilde.tc@gmail.com', '$2y$15$9PlFt.thsZMScjTjPn5/8.NI2dZeKa8oZ8QdN4qJ8l3sqOUsPDGxe', 3),
(68, 'yessenia@itsva.edu.mx', '$2y$15$l3gRmQrSA8gr4yY7pQksC.W/WQ6QLpVfo1SoGG1Tub0/Vd.VtPa1.', 3),
(69, 'minelle@itsva.edu.mx', '$2y$15$mG7cmtvkL4eyOQkeVnPQA.glPk6AcjW8fC/b//u9vA5l7qYAq0NLa', 4),
(70, 'maria@itsva.edu.mx', '$2y$15$40E82NyUuXJj8Ft.epTjTukBoJMTh0cfe09N.aeMiCU7UoFZKRuou', 4);

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `administradores`
--
ALTER TABLE `administradores`
  ADD CONSTRAINT `Relationship2` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`);

--
-- Filtros para la tabla `admin_carreras`
--
ALTER TABLE `admin_carreras`
  ADD CONSTRAINT `Relationship4` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`),
  ADD CONSTRAINT `Relationship7` FOREIGN KEY (`id_imagen`) REFERENCES `logos` (`id_imagen`);

--
-- Filtros para la tabla `alumnos`
--
ALTER TABLE `alumnos`
  ADD CONSTRAINT `Relationship21` FOREIGN KEY (`id_adminCarrera`) REFERENCES `admin_carreras` (`id_adminCarrera`),
  ADD CONSTRAINT `Relationship5` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`);

--
-- Filtros para la tabla `alumnos_conferencias`
--
ALTER TABLE `alumnos_conferencias`
  ADD CONSTRAINT `Relationship24` FOREIGN KEY (`id_alumno`) REFERENCES `alumnos` (`id_alumno`),
  ADD CONSTRAINT `Relationship25` FOREIGN KEY (`id_conferencia`) REFERENCES `conferencias` (`id_conferencia`);

--
-- Filtros para la tabla `avisos`
--
ALTER TABLE `avisos`
  ADD CONSTRAINT `Relationship8` FOREIGN KEY (`id_adminCarrera`) REFERENCES `admin_carreras` (`id_adminCarrera`);

--
-- Filtros para la tabla `concursos`
--
ALTER TABLE `concursos`
  ADD CONSTRAINT `Relationship13` FOREIGN KEY (`id_instructor`) REFERENCES `instructores` (`id_instructor`);

--
-- Filtros para la tabla `conferencias`
--
ALTER TABLE `conferencias`
  ADD CONSTRAINT `Relationship14` FOREIGN KEY (`id_instructor`) REFERENCES `instructores` (`id_instructor`);

--
-- Filtros para la tabla `equipos`
--
ALTER TABLE `equipos`
  ADD CONSTRAINT `Relationship20` FOREIGN KEY (`id_concurso`) REFERENCES `concursos` (`id_concurso`);

--
-- Filtros para la tabla `instructores`
--
ALTER TABLE `instructores`
  ADD CONSTRAINT `Relationship22` FOREIGN KEY (`id_adminCarrera`) REFERENCES `admin_carreras` (`id_adminCarrera`),
  ADD CONSTRAINT `Relationship6` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`);

--
-- Filtros para la tabla `talleres`
--
ALTER TABLE `talleres`
  ADD CONSTRAINT `Relationship12` FOREIGN KEY (`id_instructor`) REFERENCES `instructores` (`id_instructor`);

--
-- Filtros para la tabla `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `Relationship1` FOREIGN KEY (`id_rol`) REFERENCES `roles` (`id_rol`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
