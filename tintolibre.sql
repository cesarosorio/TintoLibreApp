-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 12-02-2022 a las 09:36:59
-- Versión del servidor: 10.4.20-MariaDB
-- Versión de PHP: 7.4.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `tintolibre`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `conformacion_semilla`
--

CREATE TABLE `conformacion_semilla` (
  `id_semilla` int(11) NOT NULL,
  `Nombre_Semilla` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `Lider_Semilla` int(11) NOT NULL,
  `aportesocial` int(10) NOT NULL,
  `Estado_Semilla` int(11) NOT NULL,
  `Fecha_Creacion` date NOT NULL,
  `FechaCierre` date DEFAULT NULL,
  `DiaMaximoPago` int(11) NOT NULL,
  `ActaSemilla` text COLLATE utf8_unicode_ci NOT NULL,
  `Ultima_Modificacion` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `conformacion_semilla`
--

INSERT INTO `conformacion_semilla` (`id_semilla`, `Nombre_Semilla`, `Lider_Semilla`, `aportesocial`, `Estado_Semilla`, `Fecha_Creacion`, `FechaCierre`, `DiaMaximoPago`, `ActaSemilla`, `Ultima_Modificacion`) VALUES
(1, 'Amigos de Tinto Libre', 1130622414, 4800, 1, '2022-02-08', '2022-05-31', 4, '../../Documentos/ActasSemillas/Amigos de Tinto Libre/Logo Palmeras.png', '2022-02-08');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estadosemillas`
--

CREATE TABLE `estadosemillas` (
  `Id_Estado` int(11) NOT NULL,
  `Nombre_Estado` varchar(30) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `estadosemillas`
--

INSERT INTO `estadosemillas` (`Id_Estado`, `Nombre_Estado`) VALUES
(1, 'En plantación'),
(2, 'En crecimiento'),
(3, 'En cosecha'),
(4, 'Inactiva');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estados_prestamos`
--

CREATE TABLE `estados_prestamos` (
  `Id` int(11) NOT NULL,
  `EstadoPrestamo` varchar(100) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `estados_prestamos`
--

INSERT INTO `estados_prestamos` (`Id`, `EstadoPrestamo`) VALUES
(1, 'En solicitud'),
(2, 'Aprobado'),
(3, 'Denegado'),
(4, 'En curso');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `generos`
--

CREATE TABLE `generos` (
  `Id_Genero` int(11) NOT NULL,
  `Sigla` varchar(2) COLLATE utf8_unicode_ci NOT NULL,
  `Nombre` varchar(10) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `generos`
--

INSERT INTO `generos` (`Id_Genero`, `Sigla`, `Nombre`) VALUES
(1, 'M', 'Masculino'),
(2, 'F', 'Femenino');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `integrantes_semilla`
--

CREATE TABLE `integrantes_semilla` (
  `Id` int(11) NOT NULL,
  `id_semilla` int(11) NOT NULL,
  `Id_persona` int(11) NOT NULL,
  `Rol` int(11) NOT NULL DEFAULT 1,
  `Meta_personal` bigint(20) NOT NULL,
  `Fecha` date NOT NULL,
  `Estado` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `integrantes_semilla`
--

INSERT INTO `integrantes_semilla` (`Id`, `id_semilla`, `Id_persona`, `Rol`, `Meta_personal`, `Fecha`, `Estado`) VALUES
(1, 1, 52371464, 1, 450000, '2022-02-08', 1),
(2, 1, 963258741, 2, 500000, '2022-02-08', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `multas_semilla`
--

CREATE TABLE `multas_semilla` (
  `Id` int(11) NOT NULL,
  `id_semilla` int(11) NOT NULL,
  `Presidente` int(11) NOT NULL,
  `NombreMulta` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `ObserMultas` text COLLATE utf8_unicode_ci NOT NULL,
  `Valor_Multa` int(11) NOT NULL,
  `Fecha_Creacion` date NOT NULL,
  `Estado` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `multas_semilla`
--

INSERT INTO `multas_semilla` (`Id`, `id_semilla`, `Presidente`, `NombreMulta`, `ObserMultas`, `Valor_Multa`, `Fecha_Creacion`, `Estado`) VALUES
(1, 1, 1130622414, 'Irrespeto', 'Esta multa tiene observaciones', 7500, '2022-02-08', 1),
(2, 1, 963258741, 'No votacion', 'esta multa consiste por no particpar', 10000, '2022-02-08', 1),
(3, 1, 1130622414, 'No cumplir funciones', 'Observaciones ', 5000, '2022-02-08', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mv_meta_semilla`
--

CREATE TABLE `mv_meta_semilla` (
  `Id` int(11) NOT NULL,
  `id_semilla` int(11) NOT NULL,
  `Id_usuario` int(11) NOT NULL,
  `Valor` int(11) NOT NULL,
  `aportesocial` decimal(10,0) NOT NULL,
  `Observaciones` text COLLATE utf8_unicode_ci NOT NULL,
  `Fecha` date NOT NULL,
  `Fecha_cp` datetime NOT NULL,
  `Comprobante` text COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `mv_meta_semilla`
--

INSERT INTO `mv_meta_semilla` (`Id`, `id_semilla`, `Id_usuario`, `Valor`, `aportesocial`, `Observaciones`, `Fecha`, `Fecha_cp`, `Comprobante`) VALUES
(1, 1, 963258741, 97700, '4800', 'Este monto corresponde a alguna observacion en particular ', '2022-02-08', '2022-02-08 19:19:20', '../../Documentos/Comprobantes/1-84725/imagen duquesa.jpeg'),
(2, 1, 963258741, 190200, '4800', 'Otra consignacion', '2022-02-03', '2022-02-08 19:28:03', '../../Documentos/Comprobantes/1-1103/pGO alejo.pdf');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mv_multa_semilla`
--

CREATE TABLE `mv_multa_semilla` (
  `Id` int(11) NOT NULL,
  `id_semilla` int(11) NOT NULL,
  `Id_presidente` int(11) NOT NULL,
  `Id_mvto` int(11) NOT NULL,
  `Id_multa` int(11) NOT NULL,
  `Valor_multa` int(11) NOT NULL,
  `Fecha` datetime NOT NULL,
  `Estado` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `mv_multa_semilla`
--

INSERT INTO `mv_multa_semilla` (`Id`, `id_semilla`, `Id_presidente`, `Id_mvto`, `Id_multa`, `Valor_multa`, `Fecha`, `Estado`) VALUES
(1, 1, 963258741, 1, 1, 7500, '2022-02-08 19:20:42', 1),
(2, 1, 963258741, 1, 2, 10000, '2022-02-08 19:22:09', 1),
(3, 1, 1130622414, 1, 3, 5000, '2022-02-08 19:24:48', 1),
(4, 1, 1130622414, 2, 3, 5000, '2022-02-08 19:29:17', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `prestamos`
--

CREATE TABLE `prestamos` (
  `Id` int(11) NOT NULL,
  `Id_responsable` int(11) NOT NULL,
  `id_semilla` int(11) NOT NULL,
  `ValPrestamo` bigint(20) DEFAULT NULL,
  `valcuota` int(11) NOT NULL,
  `FechaSolicitud` datetime NOT NULL,
  `FechaPrestamo` datetime DEFAULT NULL,
  `URLComprobante` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `Estado` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `prestamos`
--

INSERT INTO `prestamos` (`Id`, `Id_responsable`, `id_semilla`, `ValPrestamo`, `valcuota`, `FechaSolicitud`, `FechaPrestamo`, `URLComprobante`, `Estado`) VALUES
(1, 1155993355, 1, 500000, 0, '2022-02-06 16:43:34', NULL, NULL, 1),
(3, 52371464, 1, 300000, 0, '2022-02-08 19:35:47', NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rol`
--

CREATE TABLE `rol` (
  `Id_Rol` int(11) NOT NULL,
  `Nombre_Rol` varchar(50) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `rol`
--

INSERT INTO `rol` (`Id_Rol`, `Nombre_Rol`) VALUES
(1, 'Administrador'),
(2, 'Lider de Semilla'),
(3, 'Presidente'),
(4, 'Auditor(a)'),
(5, 'Integrantes semilla');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rol_semilla`
--

CREATE TABLE `rol_semilla` (
  `Id` int(11) NOT NULL,
  `Nombre` varchar(50) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `rol_semilla`
--

INSERT INTO `rol_semilla` (`Id`, `Nombre`) VALUES
(1, 'Sin Rol'),
(2, 'Presidente');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `Id_usuario` int(11) NOT NULL,
  `Nickname` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `Password` varchar(80) COLLATE utf8_unicode_ci NOT NULL,
  `Name` text COLLATE utf8_unicode_ci NOT NULL,
  `Rol` int(11) NOT NULL,
  `Estado` int(11) NOT NULL,
  `FechaNacimiento` date DEFAULT NULL,
  `Genero` varchar(2) COLLATE utf8_unicode_ci NOT NULL,
  `LiderSemilla` int(11) NOT NULL,
  `Correo` text COLLATE utf8_unicode_ci NOT NULL,
  `Celular` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `FechaInac` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`Id_usuario`, `Nickname`, `Password`, `Name`, `Rol`, `Estado`, `FechaNacimiento`, `Genero`, `LiderSemilla`, `Correo`, `Celular`, `FechaInac`) VALUES
(23456789, 'JRODRIGUEZ89', 'e2ed843d120097c2788f19e6f595e4b4', 'Juan Esteban Rodriguez Castro', 2, 1, '1998-01-05', 'M', 1105689328, '', '0', NULL),
(52371464, 'AMARTINEZ64', '658a6e2cf580d95d38ca6b5764b3dc8b', 'Ana Rosa  Martinez Vargas', 5, 1, '1973-10-04', 'F', 123456789, '', '0', NULL),
(753421869, 'JBERNAL69', '746a9e1dd30323ec80052be6febb69e2', 'Juan  Bernal ', 3, 1, '1980-01-01', 'M', 1105689328, '', '', NULL),
(963258741, 'MMARTINEZ41', 'ddc9d0f60652483382970d6b363ae054', 'Melisa  Martinez Suarez', 5, 1, '1995-05-22', 'F', 123456789, '', '0', NULL),
(1105689328, 'JCASILIMAS28', 'a0e8c58592561bd65c313385df9aba32', 'Jose  Luis Casilimas Martinez', 1, 1, '1996-09-15', 'M', 1105689328, '', '0', NULL),
(1130622414, 'DTELLO14', 'b4e1841fa3f2bb57461a34f3472e317c', 'Daniela Tello Rioja', 2, 1, '2000-01-01', 'F', 1105689328, '', '3174360958', NULL),
(1144179660, 'STELLO60', 'c5ece82c9a6182193a14ef7066b4caf1', 'Santiago  Tello Landazabal', 2, 1, '1994-08-07', 'M', 1105689328, '', '3147994571', NULL),
(1155993355, 'CALBERTO55', '9b62de35288f3e26e17310964304e7c5', 'Carlos  Alberto Rodriguez', 5, 1, '2022-01-05', 'M', 1144179660, '', '0', NULL);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `conformacion_semilla`
--
ALTER TABLE `conformacion_semilla`
  ADD PRIMARY KEY (`id_semilla`);

--
-- Indices de la tabla `estadosemillas`
--
ALTER TABLE `estadosemillas`
  ADD PRIMARY KEY (`Id_Estado`);

--
-- Indices de la tabla `estados_prestamos`
--
ALTER TABLE `estados_prestamos`
  ADD PRIMARY KEY (`Id`);

--
-- Indices de la tabla `generos`
--
ALTER TABLE `generos`
  ADD PRIMARY KEY (`Id_Genero`);

--
-- Indices de la tabla `integrantes_semilla`
--
ALTER TABLE `integrantes_semilla`
  ADD PRIMARY KEY (`Id`);

--
-- Indices de la tabla `multas_semilla`
--
ALTER TABLE `multas_semilla`
  ADD PRIMARY KEY (`Id`);

--
-- Indices de la tabla `mv_meta_semilla`
--
ALTER TABLE `mv_meta_semilla`
  ADD PRIMARY KEY (`Id`);

--
-- Indices de la tabla `mv_multa_semilla`
--
ALTER TABLE `mv_multa_semilla`
  ADD PRIMARY KEY (`Id`);

--
-- Indices de la tabla `prestamos`
--
ALTER TABLE `prestamos`
  ADD PRIMARY KEY (`Id`);

--
-- Indices de la tabla `rol`
--
ALTER TABLE `rol`
  ADD PRIMARY KEY (`Id_Rol`);

--
-- Indices de la tabla `rol_semilla`
--
ALTER TABLE `rol_semilla`
  ADD PRIMARY KEY (`Id`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`Id_usuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `conformacion_semilla`
--
ALTER TABLE `conformacion_semilla`
  MODIFY `id_semilla` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `estadosemillas`
--
ALTER TABLE `estadosemillas`
  MODIFY `Id_Estado` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `estados_prestamos`
--
ALTER TABLE `estados_prestamos`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `generos`
--
ALTER TABLE `generos`
  MODIFY `Id_Genero` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `integrantes_semilla`
--
ALTER TABLE `integrantes_semilla`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `multas_semilla`
--
ALTER TABLE `multas_semilla`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `mv_meta_semilla`
--
ALTER TABLE `mv_meta_semilla`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `mv_multa_semilla`
--
ALTER TABLE `mv_multa_semilla`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `prestamos`
--
ALTER TABLE `prestamos`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `rol`
--
ALTER TABLE `rol`
  MODIFY `Id_Rol` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `rol_semilla`
--
ALTER TABLE `rol_semilla`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
