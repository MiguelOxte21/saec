-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 21-10-2022 a las 22:39:40
-- Versión del servidor: 10.4.24-MariaDB
-- Versión de PHP: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `congreso-test`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `administradores`
--

CREATE TABLE `administradores` (
  `id_admin` int(11) NOT NULL,
  `correo_admin` varchar(60) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `nombre_admin` varchar(100) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `eliminacion` varchar(20) COLLATE utf8mb4_spanish2_ci DEFAULT NULL,
  `id_user` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `administradores`
--

INSERT INTO `administradores` (`id_admin`, `correo_admin`, `nombre_admin`, `eliminacion`, `id_user`) VALUES
(1, 'admin', 'administrador', '1', 6);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `admin_carreras`
--

CREATE TABLE `admin_carreras` (
  `id_adminCarrera` int(11) NOT NULL,
  `nombre_adminCarrera` varchar(100) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `estado_registro` int(11) NOT NULL,
  `carrera` varchar(60) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `id_user` int(11) DEFAULT NULL,
  `id_imagen` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `admin_carreras`
--

INSERT INTO `admin_carreras` (`id_adminCarrera`, `nombre_adminCarrera`, `estado_registro`, `carrera`, `id_user`, `id_imagen`) VALUES
(5, 'Ing. Russell Renan Luit Manzanero', 0, 'IngenierÃ­a en sistemas computacionales', 55, 9);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `alumnos`
--

CREATE TABLE `alumnos` (
  `id_alumno` int(11) NOT NULL,
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
  `grupo_etnico` varchar(100) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `promediolengua` varchar(100) COLLATE utf8mb4_spanish2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `alumnos`
--

INSERT INTO `alumnos` (`id_alumno`, `nombre_alumno`, `apellido_alumno`, `matricula`, `semestre_grupo`, `status_alumno`, `comentarios`, `id_user`, `id_adminCarrera`, `id_taller`, `id_concurso`, `id_equipo`, `grupo_etnico`, `promediolengua`) VALUES
(23, 'Jesus Alberto', 'Medina Dzib', '16070022', '3Âº B', 1, NULL, 58, 5, 7, 8, 2, '', ''),
(24, 'karina', 'Chiguil', '16070014', '8Âº A', 1, NULL, 59, 5, 8, 8, 2, '', ''),
(25, 'Minelle', 'Ciau', '16070010', '7Âº A', 1, NULL, 69, 5, 7, 2, NULL, '', ''),
(26, 'Maria', 'Mercedez', '16070088', '7Âº B', 1, NULL, 70, 5, 7, 8, 3, '', ''),
(34, 'Jesus Reyes', 'Tuz Acosta', '18070076', '3Âº B', 1, NULL, 87, 5, NULL, NULL, NULL, 'MAYA', 'Entre el 31% al 50%'),
(35, 'felipe', 'lopez', '18070026', '9Â° A', 0, NULL, 89, 5, NULL, NULL, NULL, 'CHOL', 'Porcentaje del idioma Étnico que hablas:');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `alumnos_conferencias`
--

CREATE TABLE `alumnos_conferencias` (
  `id_alumno` int(11) NOT NULL,
  `id_conferencia` int(11) NOT NULL
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

CREATE TABLE `avisos` (
  `id_aviso` int(11) NOT NULL,
  `descripcion` varchar(1000) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `fecha` varchar(50) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `id_adminCarrera` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `concursos`
--

CREATE TABLE `concursos` (
  `id_concurso` int(11) NOT NULL,
  `nombre_concurso` varchar(255) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `imagen_concurso` varchar(255) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `lugar_concurso` varchar(50) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `descripcion_concurso` text COLLATE utf8mb4_spanish2_ci NOT NULL,
  `cupo_concurso` int(11) NOT NULL,
  `modalidad` int(2) DEFAULT NULL COMMENT '1=Individual, 2=grupal',
  `max_alumnos_grupal` int(11) DEFAULT NULL,
  `id_instructor` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

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

CREATE TABLE `conferencias` (
  `id_conferencia` int(11) NOT NULL,
  `nombre_conferencia` varchar(100) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `imagen_conferencia` varchar(255) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `lugar_conferencia` varchar(50) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `descripcion_conferencia` text COLLATE utf8mb4_spanish2_ci NOT NULL,
  `cupo_conferencia` int(11) NOT NULL,
  `id_instructor` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

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

CREATE TABLE `correos` (
  `id_correo` int(3) NOT NULL,
  `correo` varchar(50) COLLATE utf8mb4_spanish2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

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

CREATE TABLE `equipos` (
  `id_equipo` int(11) NOT NULL,
  `nomEquipo` varchar(200) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `id_jefe_equipo` int(11) NOT NULL,
  `id_concurso` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `equipos`
--

INSERT INTO `equipos` (`id_equipo`, `nomEquipo`, `id_jefe_equipo`, `id_concurso`) VALUES
(2, 'Java', 23, 8),
(3, 'C++', 26, 8);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `grupo_etnico`
--

CREATE TABLE `grupo_etnico` (
  `id_grupo_etnico` int(11) NOT NULL,
  `grupo_etnico` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `grupo_etnico`
--

INSERT INTO `grupo_etnico` (`id_grupo_etnico`, `grupo_etnico`) VALUES
(1, 'Grupo étnico al que perteneces '),
(2, 'NINGUNO'),
(3, 'MAYA'),
(4, 'CHOL'),
(5, 'NAHUAT');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `instructores`
--

CREATE TABLE `instructores` (
  `id_instructor` int(11) NOT NULL,
  `nombre_instructor` varchar(50) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `apellido_instructor` varchar(50) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `clave` varchar(50) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `status_instructor` int(11) NOT NULL,
  `id_user` int(11) DEFAULT NULL,
  `id_adminCarrera` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

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

CREATE TABLE `logos` (
  `id_imagen` int(11) NOT NULL,
  `imagen` varchar(255) COLLATE utf8mb4_spanish2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `logos`
--

INSERT INTO `logos` (`id_imagen`, `imagen`) VALUES
(9, '1839042.jpg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `passwords`
--

CREATE TABLE `passwords` (
  `id` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `token` varchar(200) NOT NULL,
  `codigo` int(11) NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `passwords`
--

INSERT INTO `passwords` (`id`, `email`, `token`, `codigo`, `fecha`) VALUES
(4, 'jesusreyestuzacosta@gmail.com', '6f3637bec3', 7982, '2022-10-03 23:23:34'),
(5, 'jesusreyestuzacosta@gmail.com', '1394bfd41c', 8978, '2022-10-04 04:06:58'),
(6, 'jesusreyestuzacosta@gmail.com', '5590289304', 2070, '2022-10-04 04:14:57'),
(7, 'jesusreyestuzacosta@gmail.com', '72f27c0395', 9508, '2022-10-04 04:16:40'),
(8, 'jesusreyestuzacosta@gmail.com', 'ffea577c88', 4800, '2022-10-04 15:52:22'),
(9, 'jesusreyestuzacosta@gmail.com', '1548bcec32', 4788, '2022-10-04 15:52:24'),
(10, 'jesusreyestuzacosta@gmail.com', 'dcce8a704d', 2188, '2022-10-04 15:52:24'),
(11, 'jesusreyestuzacosta@gmail.com', '6f4a92a2cb', 7521, '2022-10-05 18:32:09'),
(12, 'jesusreyestuzacosta@gmail.com', '1b51760c1a', 5485, '2022-10-05 18:38:09'),
(13, 'jesusreyestuzacosta@gmail.com', '339b51fe3f', 4454, '2022-10-06 22:44:29'),
(14, 'jesusreyestuzacosta@gmail.com', 'ca494ca31c', 4537, '2022-10-07 02:00:00'),
(15, 'mendezfelipe451@gmail.com', '60e5982e94', 4198, '2022-10-07 04:05:56'),
(16, 'jesusreyestuzacosta@gmail.com', '2106e7194b', 2138, '2022-10-11 15:42:21'),
(17, 'jesusreyestuzacosta@gmail.com', 'be279d16ce', 6934, '2022-10-11 15:49:23'),
(18, 'jesusreyestuzacosta@gmail.com', '238bfef7ad', 8941, '2022-10-11 21:46:01');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `promediolengua`
--

CREATE TABLE `promediolengua` (
  `id_promediolengua` int(100) NOT NULL,
  `promediolengua` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `promediolengua`
--

INSERT INTO `promediolengua` (`id_promediolengua`, `promediolengua`) VALUES
(1, 'Porcentaje del idioma Étnico que hablas:'),
(2, 'No hablo'),
(3, 'Menos del 10%'),
(4, 'Entre el 11% al 30%'),
(5, 'Entre el 31% al 50%'),
(6, 'Entre el 51% al 70%'),
(7, 'Entre el% 71 al 90%'),
(8, 'Mas del 90%');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `id_rol` int(11) NOT NULL,
  `rol` varchar(50) COLLATE utf8mb4_spanish2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

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

CREATE TABLE `semestre_grupo` (
  `id_semestre_grupo` int(11) NOT NULL,
  `semestre_grupo` varchar(20) COLLATE latin1_spanish_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

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

CREATE TABLE `talleres` (
  `id_taller` int(11) NOT NULL,
  `nombre_taller` varchar(255) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `imagen_taller` varchar(200) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `lugar_taller` varchar(200) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `cupo_taller` int(11) NOT NULL,
  `descripcion_taller` text COLLATE utf8mb4_spanish2_ci NOT NULL,
  `id_instructor` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

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

CREATE TABLE `users` (
  `id_user` int(11) NOT NULL,
  `correo_user` varchar(100) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `password` varchar(150) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `id_rol` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

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
(68, 'yessenia@itsva.edu.mx', './php/cambiarpassword.php', 3),
(69, 'minelle@itsva.edu.mx', '$2y$15$mG7cmtvkL4eyOQkeVnPQA.glPk6AcjW8fC/b//u9vA5l7qYAq0NLa', 4),
(70, 'maria@itsva.edu.mx', '$2y$15$40E82NyUuXJj8Ft.epTjTukBoJMTh0cfe09N.aeMiCU7UoFZKRuou', 4),
(87, 'jesusreyestuzacosta@gmail.com', '$2y$15$1Oa7lo/F5AF3rA5ADQ3xVO6OqsoHyVzosYibPW.ukLF5ICygWRa56', 4),
(89, 'mendezfelipe451@gmail.com', '$2y$15$qgNiRsnBn1fS6DcP2erDQOq.moJXJLrZ18eWlgvmdmQ4TyD6ZlQ9C', 4);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `administradores`
--
ALTER TABLE `administradores`
  ADD PRIMARY KEY (`id_admin`),
  ADD UNIQUE KEY `id_admin` (`id_admin`),
  ADD UNIQUE KEY `correo_admin` (`correo_admin`),
  ADD KEY `IX_Relationship2` (`id_user`);

--
-- Indices de la tabla `admin_carreras`
--
ALTER TABLE `admin_carreras`
  ADD PRIMARY KEY (`id_adminCarrera`),
  ADD UNIQUE KEY `id_adminCarrera` (`id_adminCarrera`),
  ADD UNIQUE KEY `carrera` (`carrera`),
  ADD KEY `IX_Relationship4` (`id_user`),
  ADD KEY `IX_Relationship7` (`id_imagen`);

--
-- Indices de la tabla `alumnos`
--
ALTER TABLE `alumnos`
  ADD PRIMARY KEY (`id_alumno`,`id_adminCarrera`),
  ADD UNIQUE KEY `id_alumno` (`id_alumno`),
  ADD UNIQUE KEY `matricula` (`matricula`),
  ADD KEY `IX_Relationship5` (`id_user`),
  ADD KEY `Relationship21` (`id_adminCarrera`);

--
-- Indices de la tabla `alumnos_conferencias`
--
ALTER TABLE `alumnos_conferencias`
  ADD PRIMARY KEY (`id_alumno`,`id_conferencia`),
  ADD KEY `Relationship25` (`id_conferencia`);

--
-- Indices de la tabla `avisos`
--
ALTER TABLE `avisos`
  ADD PRIMARY KEY (`id_aviso`,`id_adminCarrera`),
  ADD UNIQUE KEY `id_aviso` (`id_aviso`),
  ADD KEY `Relationship8` (`id_adminCarrera`);

--
-- Indices de la tabla `concursos`
--
ALTER TABLE `concursos`
  ADD PRIMARY KEY (`id_concurso`,`id_instructor`),
  ADD UNIQUE KEY `id_concurso` (`id_concurso`),
  ADD KEY `Relationship13` (`id_instructor`);

--
-- Indices de la tabla `conferencias`
--
ALTER TABLE `conferencias`
  ADD PRIMARY KEY (`id_instructor`,`id_conferencia`),
  ADD UNIQUE KEY `id_conferencias` (`id_conferencia`);

--
-- Indices de la tabla `correos`
--
ALTER TABLE `correos`
  ADD PRIMARY KEY (`id_correo`),
  ADD UNIQUE KEY `id_correo` (`id_correo`),
  ADD UNIQUE KEY `correo` (`correo`);

--
-- Indices de la tabla `equipos`
--
ALTER TABLE `equipos`
  ADD PRIMARY KEY (`id_equipo`,`id_concurso`),
  ADD UNIQUE KEY `id_equipo` (`id_equipo`),
  ADD KEY `Relationship20` (`id_concurso`);

--
-- Indices de la tabla `grupo_etnico`
--
ALTER TABLE `grupo_etnico`
  ADD PRIMARY KEY (`id_grupo_etnico`);

--
-- Indices de la tabla `instructores`
--
ALTER TABLE `instructores`
  ADD PRIMARY KEY (`id_instructor`,`id_adminCarrera`),
  ADD UNIQUE KEY `id_instructor` (`id_instructor`),
  ADD KEY `IX_Relationship6` (`id_user`),
  ADD KEY `Relationship22` (`id_adminCarrera`);

--
-- Indices de la tabla `logos`
--
ALTER TABLE `logos`
  ADD PRIMARY KEY (`id_imagen`),
  ADD UNIQUE KEY `id_imagen` (`id_imagen`);

--
-- Indices de la tabla `passwords`
--
ALTER TABLE `passwords`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `promediolengua`
--
ALTER TABLE `promediolengua`
  ADD PRIMARY KEY (`id_promediolengua`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id_rol`),
  ADD UNIQUE KEY `id_rol` (`id_rol`),
  ADD UNIQUE KEY `rol` (`rol`);

--
-- Indices de la tabla `semestre_grupo`
--
ALTER TABLE `semestre_grupo`
  ADD PRIMARY KEY (`id_semestre_grupo`);

--
-- Indices de la tabla `talleres`
--
ALTER TABLE `talleres`
  ADD PRIMARY KEY (`id_taller`,`id_instructor`),
  ADD UNIQUE KEY `id_taller` (`id_taller`),
  ADD KEY `Relationship12` (`id_instructor`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`,`id_rol`),
  ADD UNIQUE KEY `id_user` (`id_user`),
  ADD UNIQUE KEY `correo_user` (`correo_user`),
  ADD KEY `Relationship1` (`id_rol`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `administradores`
--
ALTER TABLE `administradores`
  MODIFY `id_admin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `admin_carreras`
--
ALTER TABLE `admin_carreras`
  MODIFY `id_adminCarrera` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `alumnos`
--
ALTER TABLE `alumnos`
  MODIFY `id_alumno` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT de la tabla `avisos`
--
ALTER TABLE `avisos`
  MODIFY `id_aviso` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `concursos`
--
ALTER TABLE `concursos`
  MODIFY `id_concurso` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `conferencias`
--
ALTER TABLE `conferencias`
  MODIFY `id_conferencia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `correos`
--
ALTER TABLE `correos`
  MODIFY `id_correo` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `equipos`
--
ALTER TABLE `equipos`
  MODIFY `id_equipo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `grupo_etnico`
--
ALTER TABLE `grupo_etnico`
  MODIFY `id_grupo_etnico` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `instructores`
--
ALTER TABLE `instructores`
  MODIFY `id_instructor` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `logos`
--
ALTER TABLE `logos`
  MODIFY `id_imagen` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `passwords`
--
ALTER TABLE `passwords`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT de la tabla `promediolengua`
--
ALTER TABLE `promediolengua`
  MODIFY `id_promediolengua` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `id_rol` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `semestre_grupo`
--
ALTER TABLE `semestre_grupo`
  MODIFY `id_semestre_grupo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `talleres`
--
ALTER TABLE `talleres`
  MODIFY `id_taller` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=90;

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
