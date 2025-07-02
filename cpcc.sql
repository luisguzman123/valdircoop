-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 02-07-2025 a las 03:59:56
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
-- Base de datos: `cpcc`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cursos`
--

CREATE TABLE `cursos` (
  `id_curso` int(11) NOT NULL,
  `descripcion` varchar(100) NOT NULL,
  `estado` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `cursos`
--

INSERT INTO `cursos` (`id_curso`, `descripcion`, `estado`) VALUES
(1, 'PRIMERO AÑO', 'ACTIVO'),
(2, 'SEGUNDO AÑO', 'ACTIVO'),
(3, 'TERCER AÑO', 'ACTIVO');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `curso_especialidades`
--

CREATE TABLE `curso_especialidades` (
  `id_curso_especialidad` int(11) NOT NULL,
  `id_curso` int(11) NOT NULL,
  `id_especialidad` int(11) NOT NULL,
  `estado` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `curso_especialidades`
--

INSERT INTO `curso_especialidades` (`id_curso_especialidad`, `id_curso`, `id_especialidad`, `estado`) VALUES
(0, 3, 10, 'ACTIVO');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `especialidades`
--

CREATE TABLE `especialidades` (
  `id_especialidad` int(11) NOT NULL,
  `descripcion` varchar(100) NOT NULL,
  `estado` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `especialidades`
--

INSERT INTO `especialidades` (`id_especialidad`, `descripcion`, `estado`) VALUES
(1, 'CIENCIAS SOCIALES Y HUMANIDADES', 'ACTIVO'),
(2, 'CIENCIAS NATURALES y AMBIENTALES y QUÍMICA', 'ACTIVO'),
(3, 'CIENCIAS DE LA SALUD', 'ACTIVO'),
(4, 'TECNOLOGÍA Y CIENCIAS DE MATERIALES ', 'ACTIVO'),
(5, 'ENSEÑANZA Y DIVULGACIÓN DE LA CIENCIA ', 'ACTIVO'),
(6, 'CONTABILIDAD (Proyectos Internos)', 'ACTIVO'),
(7, 'MECATRÓNICA', 'ACTIVO'),
(8, 'INGENIERIA Y COMPUTACION', 'ACTIVO'),
(9, 'PROYECTOS INTERNOS', 'ACTIVO'),
(10, 'ROBÓTICA', 'ACTIVO');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `indicador_cabecera`
--

CREATE TABLE `indicador_cabecera` (
  `id_indicador_cabecera` int(11) NOT NULL,
  `id_proyecto_curso` int(11) NOT NULL,
  `titulo` varchar(200) NOT NULL,
  `id_plantilla` int(11) NOT NULL,
  `nro_stand` varchar(20) NOT NULL,
  `estado` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `indicador_cabecera`
--

INSERT INTO `indicador_cabecera` (`id_indicador_cabecera`, `id_proyecto_curso`, `titulo`, `id_plantilla`, `nro_stand`, `estado`) VALUES
(8, 2, 'NUEVO', 1, '222', 'ACTIVO');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `indicador_detalle`
--

CREATE TABLE `indicador_detalle` (
  `id_indicador_detalle` int(11) NOT NULL,
  `id_indicador_cabecera` int(11) NOT NULL,
  `id_padre` int(11) NOT NULL,
  `nivel` int(11) NOT NULL,
  `descripcion` varchar(300) NOT NULL,
  `puntaje` int(11) NOT NULL,
  `logrado` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `indicador_detalle`
--

INSERT INTO `indicador_detalle` (`id_indicador_detalle`, `id_indicador_cabecera`, `id_padre`, `nivel`, `descripcion`, `puntaje`, `logrado`) VALUES
(46, 8, 0, 1, 'I.- INFORME', 0, 0),
(47, 8, 46, 2, '1.- Identificación y formulación del problema – Objetivos- Justificación', 0, 0),
(48, 8, 47, 3, '1.1.- El planteamiento del problema es preciso', 1, 1),
(49, 8, 47, 3, '1.2.- Los objetivos del proyecto son claros', 1, 0),
(50, 8, 47, 3, '1.3.- La justificación responde a las preguntas ¿por qué?, ¿para qué? y ¿para quién?', 1, 0),
(51, 8, 46, 2, '2.- Elaboración y utilización de datos', 0, 0),
(52, 8, 51, 3, '2.1.- El Marco Teórico presenta informaciones precisas en relación al tema', 1, 0),
(53, 8, 51, 3, '2.2.- El Marco Teórico presenta las referencias utilizadas', 1, 0),
(54, 8, 51, 3, '2.3.- Describe en forma detallada la Metodología empleada', 1, 0),
(55, 8, 51, 3, '2.4.- Selección y aplicación de instrumentos para la recolección de datos', 1, 0),
(56, 8, 51, 3, '2.5.- Análisis adecuado de los datos', 1, 0),
(57, 8, 46, 2, '3.- Conclusiones', 0, 0),
(58, 8, 57, 3, '3.1.- Es coherente en relación con los objetivos', 1, 0),
(59, 8, 57, 3, '3.2.- Es pertinente en el sostenimiento de los resultados', 1, 0),
(60, 8, 0, 1, 'II.- TEMA', 0, 0),
(61, 8, 60, 2, '1.- Viabilidad y sustentabilidad', 0, 0),
(62, 8, 61, 3, '1.1.- Responde a la necesidad o aporte a la comunidad', 1, 0),
(63, 8, 61, 3, '1.2.- Es económicamente viable', 1, 0),
(64, 8, 60, 2, '2.- Aplicación y Proyección', 0, 0),
(65, 8, 64, 3, '2.1.- Se plantea en forma concreta la posible aplicación y proyección', 1, 0),
(66, 8, 60, 2, '3.- Creatividad y Originalidad', 0, 0),
(67, 8, 66, 3, '3.1.- La investigación es innovadora', 1, 0),
(68, 8, 66, 3, '3.2.- Propone nueva alternativa de solución al problema planteado', 1, 0),
(69, 8, 0, 1, 'III.- EXPOSICIÓN', 0, 0),
(70, 8, 69, 2, '1.- Defensa Oral', 0, 0),
(71, 8, 70, 3, '1.1.- Utiliza correctamente el lenguaje técnico', 1, 0),
(72, 8, 70, 3, '1.2.- Demuestra dominio del tema durante la exposición', 1, 0),
(73, 8, 70, 3, '1.3.- Responde correctamente a las preguntas formuladas por el evaluador', 1, 0),
(74, 8, 70, 3, '1.4.- Explica con claridad los gráficos o diagramas del informe', 1, 0),
(75, 8, 70, 3, '1.5.- Utiliza correctamente el tiempo', 1, 0),
(76, 8, 69, 2, '2.- Valores', 0, 0),
(77, 8, 76, 3, '2.1.- Respeta las normas de seguridad y prohibiciones', 1, 0),
(78, 8, 76, 3, '2.2.- Cumple con el horario establecido por la organización', 1, 0),
(79, 8, 76, 3, '2.3.- El stand demuestra pulcritud y limpieza', 1, 0),
(80, 8, 0, 1, 'IV.- CUADERNO DE CAMPO', 0, 0),
(81, 8, 80, 2, '4.1.- Refleja el trabajo realizado por los estudiantes', 1, 0),
(82, 8, 80, 2, '4.2.- Contiene el registro detallado de las observaciones', 1, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `jurados`
--

CREATE TABLE `jurados` (
  `id_jurado` int(11) NOT NULL,
  `nombre_apellido` varchar(100) DEFAULT NULL,
  `cedula` int(11) DEFAULT NULL,
  `pass` varchar(200) DEFAULT NULL,
  `estado` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `plantilla_indicadores_cabecera`
--

CREATE TABLE `plantilla_indicadores_cabecera` (
  `id_plantilla_indicador_cabecera` int(11) NOT NULL,
  `id_especialidad` int(11) NOT NULL,
  `estado` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `plantilla_indicadores_cabecera`
--

INSERT INTO `plantilla_indicadores_cabecera` (`id_plantilla_indicador_cabecera`, `id_especialidad`, `estado`) VALUES
(1, 9, 'ACTIVO'),
(2, 1, 'ACTIVO'),
(3, 2, 'ACTIVO'),
(4, 3, 'ACTIVO'),
(5, 4, 'ACTIVO'),
(6, 5, 'ACTIVO'),
(7, 6, 'ACTIVO'),
(8, 7, 'ACTIVO'),
(9, 8, 'ACTIVO'),
(10, 10, 'ACTIVO'),
(11, 10, 'ACTIVO'),
(12, 10, 'ACTIVO'),
(13, 10, 'ACTIVO'),
(14, 9, 'ACTIVO'),
(15, 10, 'ACTIVO'),
(16, 1, 'ACTIVO');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `plantilla_indicador_detalle`
--

CREATE TABLE `plantilla_indicador_detalle` (
  `id_plantilla_indicador_detalle` int(11) NOT NULL,
  `id_plantilla_indicador_cabecera` int(11) NOT NULL,
  `id_padre` int(11) NOT NULL,
  `nivel` int(11) NOT NULL,
  `descripcion` varchar(200) NOT NULL,
  `puntaje` int(11) NOT NULL,
  `estado` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `plantilla_indicador_detalle`
--

INSERT INTO `plantilla_indicador_detalle` (`id_plantilla_indicador_detalle`, `id_plantilla_indicador_cabecera`, `id_padre`, `nivel`, `descripcion`, `puntaje`, `estado`) VALUES
(1, 1, 0, 1, 'I.- INFORME', 0, 'activo'),
(2, 1, 1, 2, '1.- Identificación y formulación del problema – Objetivos- Justificación', 0, 'activo'),
(3, 1, 2, 3, '1.1.- El planteamiento del problema es preciso', 1, 'activo'),
(4, 1, 2, 3, '1.2.- Los objetivos del proyecto son claros', 1, 'activo'),
(5, 1, 2, 3, '1.3.- La justificación responde a las preguntas ¿por qué?, ¿para qué? y ¿para quién?', 1, 'activo'),
(6, 1, 1, 2, '2.- Elaboración y utilización de datos', 0, 'activo'),
(7, 1, 6, 3, '2.1.- El Marco Teórico presenta informaciones precisas en relación al tema', 1, 'activo'),
(8, 1, 6, 3, '2.2.- El Marco Teórico presenta las referencias utilizadas', 1, 'activo'),
(9, 1, 6, 3, '2.3.- Describe en forma detallada la Metodología empleada', 1, 'activo'),
(10, 1, 6, 3, '2.4.- Selección y aplicación de instrumentos para la recolección de datos', 1, 'activo'),
(11, 1, 6, 3, '2.5.- Análisis adecuado de los datos', 1, 'activo'),
(12, 1, 1, 2, '3.- Conclusiones', 0, 'activo'),
(13, 1, 12, 3, '3.1.- Es coherente en relación con los objetivos', 1, 'activo'),
(14, 1, 12, 3, '3.2.- Es pertinente en el sostenimiento de los resultados', 1, 'activo'),
(15, 1, 0, 1, 'II.- TEMA', 0, 'activo'),
(16, 1, 15, 2, '1.- Viabilidad y sustentabilidad', 0, 'activo'),
(17, 1, 16, 3, '1.1.- Responde a la necesidad o aporte a la comunidad', 1, 'activo'),
(18, 1, 16, 3, '1.2.- Es económicamente viable', 1, 'activo'),
(19, 1, 15, 2, '2.- Aplicación y Proyección', 0, 'activo'),
(20, 1, 19, 3, '2.1.- Se plantea en forma concreta la posible aplicación y proyección', 1, 'activo'),
(21, 1, 15, 2, '3.- Creatividad y Originalidad', 0, 'activo'),
(22, 1, 21, 3, '3.1.- La investigación es innovadora', 1, 'activo'),
(23, 1, 21, 3, '3.2.- Propone nueva alternativa de solución al problema planteado', 1, 'activo'),
(24, 1, 0, 1, 'III.- EXPOSICIÓN', 0, 'activo'),
(25, 1, 24, 2, '1.- Defensa Oral', 0, 'activo'),
(26, 1, 25, 3, '1.1.- Utiliza correctamente el lenguaje técnico', 1, 'activo'),
(27, 1, 25, 3, '1.2.- Demuestra dominio del tema durante la exposición', 1, 'activo'),
(28, 1, 25, 3, '1.3.- Responde correctamente a las preguntas formuladas por el evaluador', 1, 'activo'),
(29, 1, 25, 3, '1.4.- Explica con claridad los gráficos o diagramas del informe', 1, 'activo'),
(30, 1, 25, 3, '1.5.- Utiliza correctamente el tiempo', 1, 'activo'),
(31, 1, 24, 2, '2.- Valores', 0, 'activo'),
(32, 1, 31, 3, '2.1.- Respeta las normas de seguridad y prohibiciones', 1, 'activo'),
(33, 1, 31, 3, '2.2.- Cumple con el horario establecido por la organización', 1, 'activo'),
(34, 1, 31, 3, '2.3.- El stand demuestra pulcritud y limpieza', 1, 'activo'),
(35, 1, 0, 1, 'IV.- CUADERNO DE CAMPO', 0, 'activo'),
(36, 1, 35, 2, '4.1.- Refleja el trabajo realizado por los estudiantes', 1, 'activo'),
(37, 1, 35, 2, '4.2.- Contiene el registro detallado de las observaciones', 1, 'activo'),
(38, 2, 0, 1, 'I.- INFORME', 0, 'activo'),
(39, 2, 38, 2, '1.- Identificación y formulación del problema – Objetivos- Justificación', 0, 'activo'),
(40, 2, 39, 3, '1.1.- El planteamiento del problema es preciso', 1, 'activo'),
(41, 2, 39, 3, '1.2.- Los objetivos del proyecto son claros', 1, 'activo'),
(42, 2, 39, 3, '1.3.- La justificación responde a las preguntas ¿por qué?, ¿para qué? y ¿para quién?', 1, 'activo'),
(43, 2, 38, 2, '2.- Elaboración y utilización de datos', 0, 'activo'),
(44, 2, 43, 3, '2.1.- El Marco Teórico presenta informaciones precisas en relación al tema', 1, 'activo'),
(45, 2, 43, 3, '2.2.- El Marco Teórico presenta las referencias utilizadas', 1, 'activo'),
(46, 2, 43, 3, '2.3.- Describe en forma detallada la Metodología empleada', 1, 'activo'),
(47, 2, 43, 3, '2.4.- Selección y aplicación de instrumentos para la recolección de datos', 1, 'activo'),
(48, 2, 43, 3, '2.5.- Análisis adecuado de los datos', 1, 'activo'),
(49, 2, 38, 2, '3.- Conclusiones', 0, 'activo'),
(50, 2, 49, 3, '3.1.- Es coherente en relación con los objetivos', 1, 'activo'),
(51, 2, 49, 3, '3.2.- Es pertinente en el sostenimiento de los resultados', 1, 'activo'),
(52, 2, 0, 1, 'II.- TEMA', 0, 'activo'),
(53, 2, 52, 2, '1.- Viabilidad y sustentabilidad', 0, 'activo'),
(54, 2, 53, 3, '1.1.- Responde a la necesidad o aporte a la comunidad', 1, 'activo'),
(55, 2, 53, 3, '1.2.- Es económicamente viable', 1, 'activo'),
(56, 2, 52, 2, '2.- Aplicación y Proyección', 0, 'activo'),
(57, 2, 56, 3, '2.1.- Se plantea en forma concreta la posible aplicación y proyección', 1, 'activo'),
(58, 2, 52, 2, '3.- Creatividad y Originalidad', 0, 'activo'),
(59, 2, 58, 3, '3.1.- La investigación es innovadora', 1, 'activo'),
(60, 2, 58, 3, '3.2.- Propone nueva alternativa de solución al problema planteado', 1, 'activo'),
(61, 2, 0, 1, 'III.- EXPOSICIÓN', 0, 'activo'),
(62, 2, 61, 2, '1.- Defensa Oral', 0, 'activo'),
(63, 2, 62, 3, '1.1.- Utiliza correctamente el lenguaje técnico', 1, 'activo'),
(64, 2, 62, 3, '1.2.- Demuestra dominio del tema durante la exposición', 1, 'activo'),
(65, 2, 62, 3, '1.3.- Responde correctamente a las preguntas formuladas por el evaluador', 1, 'activo'),
(66, 2, 62, 3, '1.4.- Explica con claridad los gráficos o diagramas del informe', 1, 'activo'),
(67, 2, 62, 3, '1.5.- Utiliza correctamente el tiempo', 1, 'activo'),
(68, 2, 61, 2, '2.- Valores', 0, 'activo'),
(69, 2, 68, 3, '2.1.- Respeta las normas de seguridad y prohibiciones', 1, 'activo'),
(70, 2, 68, 3, '2.2.- Cumple con el horario establecido por la organización', 1, 'activo'),
(71, 2, 68, 3, '2.3.- El stand demuestra pulcritud y limpieza', 1, 'activo'),
(72, 2, 0, 1, 'IV.- CUADERNO DE CAMPO', 0, 'activo'),
(73, 2, 72, 2, '4.1.- Refleja el trabajo realizado por los estudiantes', 1, 'activo'),
(74, 2, 72, 2, '4.2.- Contiene el registro detallado de las observaciones', 1, 'activo'),
(75, 3, 0, 1, 'I.- INFORME', 0, 'activo'),
(76, 3, 75, 2, '1.- Identificación y formulación del problema – objetivo – justificación', 0, 'activo'),
(77, 3, 76, 3, '1.1.- El planteamiento del problema es preciso', 1, 'activo'),
(78, 3, 76, 3, '1.2.- Los objetivos están acordes con el problema', 1, 'activo'),
(79, 3, 76, 3, '1.3.- La justificación responde a las preguntas ¿por qué?, ¿para qué? y ¿para quién?', 1, 'activo'),
(80, 3, 75, 2, '2.- Elaboración y utilización de datos', 0, 'activo'),
(81, 3, 80, 3, '2.1.- Describe en forma detallada la Metodología empleada', 1, 'activo'),
(82, 3, 80, 3, '2.2.- Presenta análisis de datos y resultados obtenidos (tablas-gráficos)', 1, 'activo'),
(83, 3, 80, 3, '2.3.- El Marco Teórico presenta informaciones precisas en relación al tema', 1, 'activo'),
(84, 3, 75, 2, '3.- Conclusiones', 0, 'activo'),
(85, 3, 84, 3, '3.1.- Es coherente en relación con los objetivos', 1, 'activo'),
(86, 3, 84, 3, '3.2.- Sostenimiento de los resultados', 1, 'activo'),
(87, 3, 0, 1, 'II.- PRODUCTO/OBJETO', 0, 'activo'),
(88, 3, 87, 2, '1.- Viabilidad y sustentabilidad', 0, 'activo'),
(89, 3, 88, 3, '1.1.- Responde a la necesidad o aporte a la comunidad', 1, 'activo'),
(90, 3, 88, 3, '1.2.- Es económicamente viable', 1, 'activo'),
(91, 3, 87, 2, '2.- Elaboración', 0, 'activo'),
(92, 3, 91, 3, '2.1.- El producto desarrollado es innovador', 1, 'activo'),
(93, 3, 91, 3, '2.2.- El producto elaborado responde al diseño presentado', 1, 'activo'),
(94, 3, 91, 3, '2.3.- Se consideran las normas legales, técnicas y éticas en el proceso de Elaboración', 1, 'activo'),
(95, 3, 91, 3, '2.4.- Se describe en forma sistemática el funcionamiento del objeto', 1, 'activo'),
(96, 3, 91, 3, '2.5.- Se observa el trabajo propio de los investigadores en la elaboración y puesta en funcionamiento del objeto o la aplicación del producto', 1, 'activo'),
(97, 3, 0, 1, 'III.- EXPOSICIÓN', 0, 'activo'),
(98, 3, 97, 2, '3.- Defensa Oral', 0, 'activo'),
(99, 3, 98, 3, '3.1.- Explica con claridad el funcionamiento del objeto o aplicabilidad del producto', 1, 'activo'),
(100, 3, 98, 3, '3.2.- Utiliza correctamente el lenguaje técnico', 1, 'activo'),
(101, 3, 98, 3, '3.3.- Demuestra dominio del tema durante la exposición', 1, 'activo'),
(102, 3, 98, 3, '3.4.- Responde correctamente a las preguntas formuladas por el evaluador', 1, 'activo'),
(103, 3, 98, 3, '3.5.- Explica con claridad los gráficos o diagramas del informe', 1, 'activo'),
(104, 3, 97, 2, '4.- Valores', 0, 'activo'),
(105, 3, 104, 3, '4.1.- Respeta las normas de seguridad y prohibiciones', 1, 'activo'),
(106, 3, 104, 3, '4.2.- Cumple con el horario establecido por la organización', 1, 'activo'),
(107, 3, 104, 3, '4.3.- El stand demuestra pulcritud y limpieza', 1, 'activo'),
(108, 3, 0, 1, 'IV.- CUADERNO DE CAMPO', 0, 'activo'),
(109, 3, 108, 2, '4.1.- Refleja el trabajo realizado por los estudiantes', 1, 'activo'),
(110, 3, 108, 2, '4.2.- Contiene el registro detallado de las observaciones', 1, 'activo'),
(111, 4, 0, 1, 'I.- INFORME', 0, 'activo'),
(112, 4, 111, 2, '1.- Identificación y formulación del problema – Objetivos- Justificación', 0, 'activo'),
(113, 4, 112, 3, '1.1.- El planteamiento del problema es preciso', 1, 'activo'),
(114, 4, 112, 3, '1.2.- Los objetivos del proyecto son claros', 1, 'activo'),
(115, 4, 112, 3, '1.3.- La justificación responde a las preguntas ¿por qué?, ¿para qué? y ¿para quién?', 1, 'activo'),
(116, 4, 111, 2, '2.- Elaboración y utilización de datos', 0, 'activo'),
(117, 4, 116, 3, '2.1.- El Marco Teórico presenta informaciones precisas en relación al tema', 1, 'activo'),
(118, 4, 116, 3, '2.2.- El Marco Teórico presenta las referencias utilizadas', 1, 'activo'),
(119, 4, 116, 3, '2.3.- Describe en forma detallada la Metodología empleada', 1, 'activo'),
(120, 4, 116, 3, '2.4.- Selección y aplicación de instrumentos para la recolección de datos', 1, 'activo'),
(121, 4, 116, 3, '2.5.- Análisis adecuado de los datos', 1, 'activo'),
(122, 4, 111, 2, '3.- Conclusiones', 0, 'activo'),
(123, 4, 122, 3, '3.1.- Es coherente en relación con los objetivos', 1, 'activo'),
(124, 4, 122, 3, '3.2.- Es pertinente en el sostenimiento de los resultados', 1, 'activo'),
(125, 4, 0, 1, 'II.- TEMA', 0, 'activo'),
(126, 4, 125, 2, '1.- Viabilidad y sustentabilidad', 0, 'activo'),
(127, 4, 126, 3, '1.1.- Responde a la necesidad o aporte a la comunidad', 1, 'activo'),
(128, 4, 126, 3, '1.2.- Es económicamente viable', 1, 'activo'),
(129, 4, 125, 2, '2.- Aplicación y Proyección', 0, 'activo'),
(130, 4, 129, 3, '2.1.- Se plantea en forma concreta la posible aplicación y proyección', 1, 'activo'),
(131, 4, 125, 2, '3.- Creatividad y Originalidad', 0, 'activo'),
(132, 4, 131, 3, '3.1.- La investigación es innovadora', 1, 'activo'),
(133, 4, 131, 3, '3.2.- Propone nueva alternativa de solución al problema planteado', 1, 'activo'),
(134, 4, 0, 1, 'III.- EXPOSICIÓN', 0, 'activo'),
(135, 4, 134, 2, '1.- Defensa Oral', 0, 'activo'),
(136, 4, 135, 3, '1.1.- Utiliza correctamente el lenguaje técnico', 1, 'activo'),
(137, 4, 135, 3, '1.2.- Demuestra dominio del tema durante la exposición', 1, 'activo'),
(138, 4, 135, 3, '1.3.- Responde correctamente a las preguntas formuladas por el evaluador', 1, 'activo'),
(139, 4, 135, 3, '1.4.- Explica con claridad los gráficos o diagramas del informe', 1, 'activo'),
(140, 4, 135, 3, '1.5.- Utiliza correctamente el tiempo', 1, 'activo'),
(141, 4, 134, 2, '2.- Valores', 0, 'activo'),
(142, 4, 141, 3, '2.1.- Respeta las normas de seguridad y prohibiciones', 1, 'activo'),
(143, 4, 141, 3, '2.2.- Cumple con el horario establecido por la organización', 1, 'activo'),
(144, 4, 141, 3, '2.3.- El stand demuestra pulcritud y limpieza', 1, 'activo'),
(145, 4, 0, 1, 'IV.- CUADERNO DE CAMPO', 0, 'activo'),
(146, 4, 145, 2, '4.1.- Refleja el trabajo realizado por los estudiantes', 1, 'activo'),
(147, 4, 145, 2, '4.2.- Contiene el registro detallado de las observaciones', 1, 'activo'),
(148, 5, 0, 1, 'I.- INFORME', 0, 'activo'),
(149, 5, 148, 2, '1.- Identificación y formulación del problema – objetivo – justificación', 0, 'activo'),
(150, 5, 149, 3, '1.1.- El planteamiento del problema es preciso', 1, 'activo'),
(151, 5, 149, 3, '1.2.- Los objetivos están acordes con el problema', 1, 'activo'),
(152, 5, 149, 3, '1.3.- La justificación responde a las preguntas ¿por qué?, ¿para qué? y ¿para quién?', 1, 'activo'),
(153, 5, 148, 2, '2.- Elaboración y utilización de datos', 0, 'activo'),
(154, 5, 153, 3, '2.1.- Describe en forma detallada la Metodología empleada', 1, 'activo'),
(155, 5, 153, 3, '2.2.- Presenta análisis de datos y resultados obtenidos (tablas-gráficos)', 1, 'activo'),
(156, 5, 153, 3, '2.3.- El Marco Teórico presenta informaciones precisas en relación al tema', 1, 'activo'),
(157, 5, 148, 2, '3.- Conclusiones', 0, 'activo'),
(158, 5, 157, 3, '3.1.- Es coherente en relación con los objetivos', 1, 'activo'),
(159, 5, 157, 3, '3.2.- Especifica las alternativas de solución al problema planteado', 1, 'activo'),
(160, 5, 0, 1, 'II.- PRODUCTO/OBJETO', 0, 'activo'),
(161, 5, 160, 2, '1.- Viabilidad y sustentabilidad', 0, 'activo'),
(162, 5, 161, 3, '1.1.- Responde a la necesidad o aporte a la comunidad', 1, 'activo'),
(163, 5, 161, 3, '1.2.- Es económicamente viable', 1, 'activo'),
(164, 5, 160, 2, '2.- Elaboración', 0, 'activo'),
(165, 5, 164, 3, '2.1.- El producto desarrollado es innovador', 1, 'activo'),
(166, 5, 164, 3, '2.2.- El producto elaborado responde al diseño presentado', 1, 'activo'),
(167, 5, 164, 3, '2.3.- Se consideran las normas legales, técnicas y éticas en el proceso de Elaboración', 1, 'activo'),
(168, 5, 164, 3, '2.4.- Se describe en forma sistemática el funcionamiento del objeto', 1, 'activo'),
(169, 5, 164, 3, '2.5.- Se observa el trabajo propio de los investigadores en la elaboración y puesta en funcionamiento del objeto o la aplicación del producto', 1, 'activo'),
(170, 5, 0, 1, 'III.- EXPOSISTORES', 0, 'activo'),
(171, 5, 170, 2, '3.- Defensa Oral', 0, 'activo'),
(172, 5, 171, 3, '3.1.- Explica con claridad el funcionamiento del objeto o aplicabilidad del producto', 1, 'activo'),
(173, 5, 171, 3, '3.2.- Utiliza correctamente el lenguaje técnico', 1, 'activo'),
(174, 5, 171, 3, '3.3.- Demuestra dominio del tema durante la exposición', 1, 'activo'),
(175, 5, 171, 3, '3.4.- Responde correctamente a las preguntas formuladas por el evaluador', 1, 'activo'),
(176, 5, 171, 3, '3.5.- Explica con claridad los gráficos o diagramas del informe', 1, 'activo'),
(177, 5, 0, 1, 'IV.- CUADERNO DE CAMPO', 0, 'activo'),
(178, 5, 177, 2, '4.1.- Refleja el trabajo realizado por los estudiantes', 1, 'activo'),
(179, 5, 177, 2, '4.2.- Contiene el registro detallado de las observaciones', 1, 'activo'),
(180, 6, 0, 1, 'I.- INFORME', 0, 'activo'),
(181, 6, 180, 2, '1.- Identificación y formulación del problema – objetivo – hipótesis', 0, 'activo'),
(182, 6, 181, 3, '1.1.- El planteamiento del problema es preciso', 1, 'activo'),
(183, 6, 181, 3, '1.2.- Los objetivos del proyecto son claros', 1, 'activo'),
(184, 6, 181, 3, '1.3.- Los objetivos están acordes con el problema y la hipótesis', 1, 'activo'),
(185, 6, 180, 2, '2.- Elaboración y utilización de datos', 0, 'activo'),
(186, 6, 185, 3, '2.1.- Describe en forma detallada la Metodología empleada', 1, 'activo'),
(187, 6, 185, 3, '2.2.- Presenta análisis de datos y resultados obtenidos (tablas-gráficos)', 1, 'activo'),
(188, 6, 185, 3, '2.3.- El Marco Teórico presenta informaciones precisas en relación al tema', 1, 'activo'),
(189, 6, 180, 2, '3.- Conclusiones', 0, 'activo'),
(190, 6, 189, 3, '3.1.- Es coherente en relación a los objetivos', 1, 'activo'),
(191, 6, 189, 3, '3.2.- Especifica las alternativas de solución al problema planteado', 1, 'activo'),
(192, 6, 0, 1, 'II.- TEMA', 0, 'activo'),
(193, 6, 192, 2, '1.- Viabilidad y sustentabilidad', 0, 'activo'),
(194, 6, 193, 3, '1.1.- Responde a la necesidad o aporte a la comunidad', 1, 'activo'),
(195, 6, 193, 3, '1.2.- Es económicamente viable', 1, 'activo'),
(196, 6, 192, 2, '2.- Aplicación y Proyección', 0, 'activo'),
(197, 6, 196, 3, '2.1.- Se plantea en forma concreta la posible aplicación y proyección', 1, 'activo'),
(198, 6, 192, 2, '3.- Creatividad y Originalidad', 0, 'activo'),
(199, 6, 198, 3, '3.1.- La investigación es innovadora', 1, 'activo'),
(200, 6, 198, 3, '3.2.- Propone nueva alternativa de solución al problema planteado', 1, 'activo'),
(201, 6, 192, 2, '4.- Investigación y Experimentación', 0, 'activo'),
(202, 6, 201, 3, '4.1.- La investigación o la experimentación llevan a la aceptación o rechazo de la hipótesis', 1, 'activo'),
(203, 6, 201, 3, '4.2.- La metodología empleada responde a los objetivos de la investigación', 1, 'activo'),
(204, 6, 201, 3, '4.3.- El análisis de los resultados es consecuencia de la investigación', 1, 'activo'),
(205, 6, 0, 1, 'III.- EXPOSICIÓN', 0, 'activo'),
(206, 6, 205, 2, '1.- Defensa Oral', 0, 'activo'),
(207, 6, 206, 3, '1.1.- Utiliza correctamente el lenguaje técnico', 1, 'activo'),
(208, 6, 206, 3, '1.2.- Demuestra dominio del tema durante la exposición', 1, 'activo'),
(209, 6, 206, 3, '1.3.- Responde correctamente a las preguntas formuladas por el evaluador', 1, 'activo'),
(210, 6, 206, 3, '1.4.- Explica con claridad los gráficos o diagramas del informe', 1, 'activo'),
(211, 6, 206, 3, '1.5.- Utiliza correctamente el tiempo', 1, 'activo'),
(212, 6, 205, 2, '2.- Valores', 0, 'activo'),
(213, 6, 212, 3, '2.1.- Respeta las normas de seguridad y prohibiciones', 1, 'activo'),
(214, 6, 212, 3, '2.2.- Cumple con el horario establecido por la organización', 1, 'activo'),
(215, 6, 212, 3, '2.3.- El stand demuestra pulcritud y limpieza', 1, 'activo'),
(216, 6, 0, 1, 'IV.- CUADERNO DE CAMPO', 0, 'activo'),
(217, 6, 216, 2, '4.1.- Refleja el trabajo realizado por los estudiantes', 1, 'activo'),
(218, 6, 216, 2, '4.2.- Contiene el registro detallado de las observaciones', 1, 'activo'),
(256, 8, 0, 1, 'I.- INFORME', 0, 'activo'),
(257, 8, 256, 2, '1.- Identificación y formulación del problema – objetivos – justificación', 0, 'activo'),
(258, 8, 257, 3, '1.1.- El planteamiento del problema es preciso', 1, 'activo'),
(259, 8, 257, 3, '1.2.- Los objetivos del proyecto son claros', 1, 'activo'),
(260, 8, 257, 3, '1.3.- Los objetivos están acordes con el problema', 1, 'activo'),
(261, 8, 257, 3, '1.4.- Plantea alternativa de solución', 1, 'activo'),
(262, 8, 256, 2, '2.- Elaboración y utilización de datos', 0, 'activo'),
(263, 8, 262, 3, '2.1.- Describe en forma detallada la Metodología empleada', 1, 'activo'),
(264, 8, 262, 3, '2.2.- Presenta análisis de datos y resultados obtenidos (tablas-gráficos)', 1, 'activo'),
(265, 8, 262, 3, '2.3.- El Marco Teórico presenta informaciones precisas en relación al tema', 1, 'activo'),
(266, 8, 256, 2, '3.- Conclusiones', 0, 'activo'),
(267, 8, 266, 3, '3.1.- Presenta conocimiento científico y técnico', 1, 'activo'),
(268, 8, 266, 3, '3.2.- Es coherente en relación al problema planteado', 1, 'activo'),
(269, 8, 0, 1, 'II.- TEMA', 0, 'activo'),
(270, 8, 269, 2, '1.- Viabilidad y sustentabilidad', 0, 'activo'),
(271, 8, 270, 3, '1.1.- Responde a la necesidad o aporte a la comunidad', 1, 'activo'),
(272, 8, 270, 3, '1.2.- Presenta un aporte teórico que detalla los alcances y limitaciones de la investigación', 1, 'activo'),
(273, 8, 269, 2, '2.- Aplicación y Proyección', 0, 'activo'),
(274, 8, 273, 3, '2.1.- Se plantea en forma concreta la posible aplicación y proyección', 1, 'activo'),
(275, 8, 269, 2, '3.- Creatividad y originalidad', 0, 'activo'),
(276, 8, 275, 3, '3.1.- La investigación es innovadora', 1, 'activo'),
(277, 8, 275, 3, '3.2.- Propone nueva alternativa de solución al problema planteado', 1, 'activo'),
(278, 8, 269, 2, '4.- Investigación y experimentación', 0, 'activo'),
(279, 8, 278, 3, '4.1.- Los materiales y métodos llevan a la aceptación o rechazo de la hipótesis', 1, 'activo'),
(280, 8, 278, 3, '4.2.- La metodología empleada responde a los objetivos de la investigación', 1, 'activo'),
(281, 8, 278, 3, '4.3.- El análisis de los resultados es consecuencia de la investigación', 1, 'activo'),
(282, 8, 0, 1, 'III.- EXPOSICIÓN', 0, 'activo'),
(283, 8, 282, 2, '3.- Defensa Oral', 0, 'activo'),
(284, 8, 283, 3, '1.1.- Utiliza correctamente el lenguaje técnico', 1, 'activo'),
(285, 8, 283, 3, '1.2.- Demuestra dominio del tema durante la exposición', 1, 'activo'),
(286, 8, 283, 3, '1.3.- Responde correctamente a las preguntas formuladas por el evaluador', 1, 'activo'),
(287, 8, 283, 3, '1.4.- Explica con claridad los gráficos o diagramas del informe', 1, 'activo'),
(288, 8, 283, 3, '1.5.- Utiliza correctamente el tiempo', 1, 'activo'),
(289, 8, 282, 2, '2.- Valores', 0, 'activo'),
(290, 8, 289, 3, '2.1.- Respeta las normas de seguridad y prohibiciones', 1, 'activo'),
(291, 8, 289, 3, '2.2.- Cumple con el horario establecido por la organización', 1, 'activo'),
(292, 8, 0, 1, 'V.- CUADERNO DE CAMPO', 0, 'activo'),
(293, 8, 292, 2, '4.1.- Refleja el trabajo realizado por los estudiantes', 1, 'activo'),
(294, 8, 292, 2, '4.2.- Contiene el registro detallado de las observaciones', 1, 'activo'),
(295, 9, 0, 1, 'I.- INFORME', 0, 'activo'),
(296, 9, 295, 2, '1.- Identificación y formulación del problema – objetivo – justificación', 0, 'activo'),
(297, 9, 296, 3, '1.1.- El planteamiento del problema es preciso', 1, 'activo'),
(298, 9, 296, 3, '1.2.- Los objetivos del proyecto son claros', 1, 'activo'),
(299, 9, 296, 3, '1.3.- La justificación responde a las preguntas ¿por qué?, ¿para qué? y ¿para quién?', 1, 'activo'),
(300, 9, 295, 2, '2.- Elaboración y utilización de datos', 0, 'activo'),
(301, 9, 300, 3, '2.1.- Describe en forma detallada la Metodología empleada', 1, 'activo'),
(302, 9, 300, 3, '2.2.- Presenta análisis de datos y resultados obtenidos (tablas-gráficos)', 1, 'activo'),
(303, 9, 300, 3, '2.3.- El Marco Teórico presenta informaciones precisas en relación al tema', 1, 'activo'),
(304, 9, 295, 2, '3.- Conclusiones', 0, 'activo'),
(305, 9, 304, 3, '3.1.- Es coherente en relación a los objetivos', 1, 'activo'),
(306, 9, 304, 3, '3.2.- Especifica las alternativas de solución al problema planteado', 1, 'activo'),
(307, 9, 0, 1, 'II.- TEMA', 0, 'activo'),
(308, 9, 307, 2, '1.- Viabilidad y sustentabilidad', 0, 'activo'),
(309, 9, 308, 3, '1.1.- Responde a la necesidad o aporte a la comunidad', 1, 'activo'),
(310, 9, 308, 3, '1.2.- Es económicamente viable', 1, 'activo'),
(311, 9, 307, 2, '2.- Aplicación y Proyección', 0, 'activo'),
(312, 9, 311, 3, '2.1.- Se plantea en forma concreta la posible aplicación y proyección', 1, 'activo'),
(313, 9, 307, 2, '3.- Creatividad y originalidad', 0, 'activo'),
(314, 9, 313, 3, '3.1.- La investigación es innovadora', 1, 'activo'),
(315, 9, 313, 3, '3.2.- Propone nueva alternativa de solución al problema planteado', 1, 'activo'),
(316, 9, 307, 2, '4.- Investigación y experimentación', 0, 'activo'),
(317, 9, 316, 3, '4.1.- Los materiales y métodos llevan a la aceptación o rechazo de la hipótesis', 1, 'activo'),
(318, 9, 316, 3, '4.2.- La metodología empleada responde a los objetivos de la investigación', 1, 'activo'),
(319, 9, 316, 3, '4.3.- El análisis de los resultados es consecuencia de la investigación', 1, 'activo'),
(320, 9, 0, 1, 'III.- EXPOSICIÓN', 0, 'activo'),
(321, 9, 320, 2, '3.- Defensa Oral', 0, 'activo'),
(322, 9, 321, 3, '3.1.- Explica con claridad el funcionamiento del objeto o aplicabilidad del producto', 1, 'activo'),
(323, 9, 321, 3, '3.2.- Utiliza correctamente el lenguaje técnico', 1, 'activo'),
(324, 9, 321, 3, '3.3.- Demuestra dominio del tema durante la exposición', 1, 'activo'),
(325, 9, 321, 3, '3.4.- Responde correctamente a las preguntas formuladas por el evaluador', 1, 'activo'),
(326, 9, 321, 3, '3.5.- Explica con claridad los gráficos o diagramas del informe', 1, 'activo'),
(327, 9, 320, 2, '2.- Valores', 0, 'activo'),
(328, 9, 327, 3, '2.1.- Respeta las normas de seguridad y prohibiciones', 1, 'activo'),
(329, 9, 327, 3, '2.2.- Cumple con el horario establecido por la organización', 1, 'activo'),
(330, 9, 0, 1, 'V.- CUADERNO DE CAMPO', 0, 'activo'),
(331, 9, 330, 2, '4.1.- Refleja el trabajo realizado por los estudiantes', 1, 'activo'),
(332, 9, 330, 2, '4.2.- Contiene el registro detallado de las observaciones', 1, 'activo'),
(333, 10, 0, 1, 'I.- INFORME', 0, 'activo'),
(334, 10, 333, 2, '1.- Identificación y formulación del problema – objetivo – justificación', 0, 'activo'),
(335, 10, 334, 3, '1.1.- El planteamiento del problema es preciso', 1, 'activo'),
(336, 10, 334, 3, '1.2.- Los objetivos están acordes con el problema', 1, 'activo'),
(337, 10, 334, 3, '1.3.- La justificación responde a las preguntas ¿por qué?, ¿para qué? y ¿para quién?', 1, 'activo'),
(338, 10, 334, 3, '1.4.- Plantea alternativa de solución', 1, 'activo'),
(339, 10, 333, 2, '2.- Elaboración y utilización de datos', 0, 'activo'),
(340, 10, 339, 3, '2.1.- Describe en forma detallada la Metodología empleada', 1, 'activo'),
(341, 10, 339, 3, '2.2.- Presenta análisis de datos y resultados obtenidos (tablas-gráficos)', 1, 'activo'),
(342, 10, 339, 3, '2.3.- El Marco Teórico presenta informaciones precisas en relación al tema', 1, 'activo'),
(343, 10, 333, 2, '3.- Conclusiones', 0, 'activo'),
(344, 10, 343, 3, '3.1.- Presenta conocimiento científico y técnico', 1, 'activo'),
(345, 10, 343, 3, '3.2.- Es coherente en relación al problema planteado', 1, 'activo'),
(346, 10, 0, 1, 'II.- TEMA', 0, 'activo'),
(347, 10, 346, 2, '1.- Viabilidad y sustentabilidad', 0, 'activo'),
(348, 10, 347, 3, '1.1.- Responde a la necesidad o aporte a la comunidad', 1, 'activo'),
(349, 10, 347, 3, '1.2.- Presenta un aporte teórico detalla los alcances y limitaciones de la investigación', 1, 'activo'),
(350, 10, 346, 2, '2.- Aplicación y Proyección', 0, 'activo'),
(351, 10, 350, 3, '2.1.- Se plantea en forma concreta la posible aplicación y proyección', 1, 'activo'),
(352, 10, 346, 2, '3.- Creatividad y originalidad', 0, 'activo'),
(353, 10, 352, 3, '3.1.- La investigación es innovadora', 1, 'activo'),
(354, 10, 352, 3, '3.2.- Propone nueva alternativa de solución al problema planteado', 1, 'activo'),
(355, 10, 346, 2, '4.- Investigación y experimentación', 0, 'activo'),
(356, 10, 355, 3, '4.1.- Los materiales y métodos llevan a la aceptación o rechazo de la hipótesis', 1, 'activo'),
(357, 10, 355, 3, '4.2.- La metodología empleada responde a los objetivos de la investigación', 1, 'activo'),
(358, 10, 355, 3, '4.3.- El análisis de los resultados es consecuencia de la investigación', 1, 'activo'),
(359, 10, 0, 1, 'III.- EXPOSICIÓN', 0, 'activo'),
(360, 10, 359, 2, '3.- Defensa Oral', 0, 'activo'),
(361, 10, 360, 3, '3.1.- Explica con claridad el funcionamiento del objeto o aplicabilidad del producto', 1, 'activo'),
(362, 10, 360, 3, '3.2.- Utiliza correctamente el lenguaje técnico', 1, 'activo'),
(363, 10, 360, 3, '3.3.- Demuestra dominio del tema durante la exposición', 1, 'activo'),
(364, 10, 360, 3, '3.4.- Responde correctamente a las preguntas formuladas por el evaluador', 1, 'activo'),
(365, 10, 360, 3, '3.5.- Explica con claridad los gráficos o diagramas del informe', 1, 'activo'),
(366, 10, 359, 2, '2.- Valores', 0, 'activo'),
(367, 10, 366, 3, '2.1.- Respeta las normas de seguridad y prohibiciones', 1, 'activo'),
(368, 10, 366, 3, '2.2.- Cumple con el horario establecido por la organización', 1, 'activo'),
(369, 10, 0, 1, 'V.- CUADERNO DE CAMPO', 0, 'activo'),
(370, 10, 369, 2, '4.1.- Refleja el trabajo realizado por los estudiantes', 1, 'activo'),
(371, 10, 369, 2, '4.2.- Contiene el registro detallado de las observaciones', 1, 'activo'),
(372, 11, 0, 1, 'asdasdasd', 11, 'ACTIVO'),
(373, 11, 0, 1, 'ddddd', 22, 'ACTIVO'),
(374, 14, 0, 0, 'aaaaaa', 0, 'ACTIVO'),
(375, 15, 0, 0, 'dddddddd', 0, 'ACTIVO'),
(376, 15, 375, 1, 'ssss', 2, 'ACTIVO'),
(377, 16, 0, 1, 'INFORME', 0, 'ACTIVO'),
(378, 16, 377, 1, '1. Identificación y formulación del problema – Objetivos- Justificación ', 0, 'ACTIVO');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proyectos`
--

CREATE TABLE `proyectos` (
  `id_proyecto` int(11) NOT NULL,
  `descripcion` varchar(100) NOT NULL,
  `estado` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `proyectos`
--

INSERT INTO `proyectos` (`id_proyecto`, `descripcion`, `estado`) VALUES
(1, 'PROYECTO 1', 'ACTIVO'),
(2, 'PROYECTO 2', 'ACTIVO');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proyecto_curso`
--

CREATE TABLE `proyecto_curso` (
  `id_proyecto_curso` int(11) NOT NULL,
  `id_curso` int(11) NOT NULL,
  `id_proyecto` int(11) NOT NULL,
  `estado` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `proyecto_curso`
--

INSERT INTO `proyecto_curso` (`id_proyecto_curso`, `id_curso`, `id_proyecto`, `estado`) VALUES
(1, 1, 1, 'ACTIVO'),
(2, 1, 2, 'ACTIVO');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usuario` int(11) NOT NULL,
  `nombreyapellido` varchar(100) NOT NULL,
  `cedula` int(11) NOT NULL,
  `contrasena` varchar(100) NOT NULL,
  `rol` varchar(50) NOT NULL,
  `estado` varchar(100) NOT NULL,
  `intentos` int(11) DEFAULT 0,
  `limite_intentos` int(11) DEFAULT 3
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `nombreyapellido`, `cedula`, `contrasena`, `rol`, `estado`, `intentos`, `limite_intentos`) VALUES
(1, 'LUIS GUZMAN', 5431319, '202cb962ac59075b964b07152d234b70', 'ADMINISTRADOR', 'ACTIVO', 0, 3);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `cursos`
--
ALTER TABLE `cursos`
  ADD PRIMARY KEY (`id_curso`);

--
-- Indices de la tabla `curso_especialidades`
--
ALTER TABLE `curso_especialidades`
  ADD KEY `id_curso` (`id_curso`),
  ADD KEY `id_especialidad` (`id_especialidad`);

--
-- Indices de la tabla `especialidades`
--
ALTER TABLE `especialidades`
  ADD PRIMARY KEY (`id_especialidad`);

--
-- Indices de la tabla `indicador_cabecera`
--
ALTER TABLE `indicador_cabecera`
  ADD PRIMARY KEY (`id_indicador_cabecera`);

--
-- Indices de la tabla `indicador_detalle`
--
ALTER TABLE `indicador_detalle`
  ADD PRIMARY KEY (`id_indicador_detalle`,`id_indicador_cabecera`,`id_padre`) USING BTREE;

--
-- Indices de la tabla `jurados`
--
ALTER TABLE `jurados`
  ADD PRIMARY KEY (`id_jurado`);

--
-- Indices de la tabla `plantilla_indicadores_cabecera`
--
ALTER TABLE `plantilla_indicadores_cabecera`
  ADD PRIMARY KEY (`id_plantilla_indicador_cabecera`),
  ADD KEY `id_especialidad` (`id_especialidad`);

--
-- Indices de la tabla `plantilla_indicador_detalle`
--
ALTER TABLE `plantilla_indicador_detalle`
  ADD PRIMARY KEY (`id_plantilla_indicador_detalle`);

--
-- Indices de la tabla `proyectos`
--
ALTER TABLE `proyectos`
  ADD PRIMARY KEY (`id_proyecto`);

--
-- Indices de la tabla `proyecto_curso`
--
ALTER TABLE `proyecto_curso`
  ADD PRIMARY KEY (`id_proyecto_curso`),
  ADD KEY `id_curso` (`id_curso`),
  ADD KEY `id_proyecto` (`id_proyecto`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `cursos`
--
ALTER TABLE `cursos`
  MODIFY `id_curso` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `especialidades`
--
ALTER TABLE `especialidades`
  MODIFY `id_especialidad` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `indicador_cabecera`
--
ALTER TABLE `indicador_cabecera`
  MODIFY `id_indicador_cabecera` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `indicador_detalle`
--
ALTER TABLE `indicador_detalle`
  MODIFY `id_indicador_detalle` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=83;

--
-- AUTO_INCREMENT de la tabla `jurados`
--
ALTER TABLE `jurados`
  MODIFY `id_jurado` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `plantilla_indicadores_cabecera`
--
ALTER TABLE `plantilla_indicadores_cabecera`
  MODIFY `id_plantilla_indicador_cabecera` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de la tabla `plantilla_indicador_detalle`
--
ALTER TABLE `plantilla_indicador_detalle`
  MODIFY `id_plantilla_indicador_detalle` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=379;

--
-- AUTO_INCREMENT de la tabla `proyectos`
--
ALTER TABLE `proyectos`
  MODIFY `id_proyecto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `proyecto_curso`
--
ALTER TABLE `proyecto_curso`
  MODIFY `id_proyecto_curso` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `curso_especialidades`
--
ALTER TABLE `curso_especialidades`
  ADD CONSTRAINT `curso_especialidades_ibfk_1` FOREIGN KEY (`id_curso`) REFERENCES `cursos` (`id_curso`),
  ADD CONSTRAINT `curso_especialidades_ibfk_2` FOREIGN KEY (`id_especialidad`) REFERENCES `especialidades` (`id_especialidad`);

--
-- Filtros para la tabla `plantilla_indicadores_cabecera`
--
ALTER TABLE `plantilla_indicadores_cabecera`
  ADD CONSTRAINT `plantilla_indicadores_cabecera_ibfk_1` FOREIGN KEY (`id_especialidad`) REFERENCES `especialidades` (`id_especialidad`);

--
-- Filtros para la tabla `proyecto_curso`
--
ALTER TABLE `proyecto_curso`
  ADD CONSTRAINT `proyecto_curso_ibfk_1` FOREIGN KEY (`id_curso`) REFERENCES `cursos` (`id_curso`),
  ADD CONSTRAINT `proyecto_curso_ibfk_2` FOREIGN KEY (`id_proyecto`) REFERENCES `proyectos` (`id_proyecto`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
