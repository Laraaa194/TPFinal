-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3307
-- Tiempo de generación: 07-07-2025 a las 21:34:42
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
-- Base de datos: `tpfinal`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categoria`
--

CREATE TABLE `categoria` (
  `id` int(10) NOT NULL,
  `nombre` varchar(30) NOT NULL,
  `color` varchar(20) NOT NULL,
  `color_fondo` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `categoria`
--

INSERT INTO `categoria` (`id`, `nombre`, `color`, `color_fondo`) VALUES
(1, 'Ciencia', '#178a2c', '#e1fae4'),
(2, 'Deporte', '#ff5500', '#fbded3'),
(3, 'Geografía', '#2626c2', '#bcc3df'),
(4, 'Arte', '#c92e2e', '#fae2e2'),
(5, 'Historia', '#ffcc4d', '#f6db91'),
(6, 'Entretenimiento', '#c43e93', '#fadfec');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `dificultad`
--

CREATE TABLE `dificultad` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `dificultad`
--

INSERT INTO `dificultad` (`id`, `nombre`) VALUES
(1, 'baja'),
(2, 'media'),
(3, 'alta');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historial_moderacion`
--

CREATE TABLE `historial_moderacion` (
  `id` int(11) NOT NULL,
  `id_editor` int(11) DEFAULT NULL,
  `tipo_accion` varchar(50) NOT NULL,
  `detalle` text NOT NULL,
  `fecha` datetime DEFAULT current_timestamp(),
  `categoria_pregunta` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `historial_moderacion`
--

INSERT INTO `historial_moderacion` (`id`, `id_editor`, `tipo_accion`, `detalle`, `fecha`, `categoria_pregunta`) VALUES
(68, 100, 'Agregar Pregunta', 'Se agregó una nueva pregunta: \"¿Qué jugador argentino hizo el último penal en la final del mundial 2022?\" y pasa a estar activa.', '2025-06-22 20:20:59', 2),
(69, 100, 'Aceptar Solicitud', 'Se aceptó la pregunta sugerida: \"¿Cómo se llama el mejor amigo de Harry Potter?\" y se añadió como pregunta activa.', '2025-06-29 14:46:59', 6),
(71, 100, 'Editar Pregunta', 'Se efectuaron cambios en la pregunta: \"¿Quién pintó la “Mona Lisa”?\".', '2025-06-29 15:35:50', 4),
(73, 100, 'Aceptar Solicitud', 'Se aceptó la pregunta sugerida: \"¿Cómo se llama el hechizo de Harry Potter que te asesina?\" y se añadió como pregunta activa.', '2025-06-29 15:39:13', 6),
(74, 100, 'Aceptar Solicitud', 'Se aceptó la pregunta sugerida: \"¿De qué país es originario el Taekwondo?\" y se añadió como pregunta activa.', '2025-06-29 16:04:31', 2),
(75, 100, 'Agregar Pregunta', 'Se agregó una nueva pregunta: \"¿Quién fue el Libertador de Argentina?\" y pasa a estar activa.', '2025-07-04 16:40:34', 5);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `partida`
--

CREATE TABLE `partida` (
  `id` int(11) NOT NULL,
  `fecha` datetime DEFAULT current_timestamp(),
  `puntaje_total` int(11) DEFAULT 0,
  `id_jugador` int(11) NOT NULL,
  `esta_activa` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `partida`
--

INSERT INTO `partida` (`id`, `fecha`, `puntaje_total`, `id_jugador`, `esta_activa`) VALUES
(119, '2025-06-06 14:40:22', 0, 1, 0),
(120, '2025-06-06 14:45:25', 0, 1, 0),
(121, '2025-06-06 14:45:55', 0, 1, 0),
(122, '2025-06-06 14:46:12', 21, 1, 0),
(123, '2025-06-06 14:53:33', 2, 1, 0),
(124, '2025-06-06 14:58:01', 1, 1, 0),
(125, '2025-06-06 15:16:57', 4, 1, 0),
(126, '2025-06-06 15:20:39', 26, 1, 0),
(127, '2025-06-06 15:28:51', 18, 1, 0),
(128, '2025-06-06 15:48:50', 1, 7, 0),
(129, '2025-06-06 15:49:09', 1, 7, 0),
(130, '2025-06-06 15:49:30', 1, 7, 0),
(131, '2025-06-06 15:49:56', 1, 7, 0),
(132, '2025-06-06 15:52:31', 0, 8, 0),
(133, '2025-06-06 15:52:49', 0, 8, 0),
(134, '2025-06-06 15:53:01', 1, 8, 0),
(135, '2025-06-06 15:54:01', 5, 8, 0),
(136, '2025-06-06 15:57:10', 0, 9, 0),
(137, '2025-06-06 15:57:27', 0, 9, 0),
(138, '2025-06-06 15:57:38', 4, 9, 0),
(139, '2025-06-06 15:58:27', 0, 9, 0),
(140, '2025-06-06 15:59:49', 3, 9, 0),
(141, '2025-06-06 16:00:29', 0, 9, 0),
(142, '2025-06-06 16:00:35', 1, 9, 0),
(143, '2025-06-06 16:00:52', 1, 9, 0),
(144, '2025-06-06 16:01:08', 0, 9, 0),
(145, '2025-06-06 16:02:38', 0, 10, 0),
(146, '2025-06-06 16:02:44', 1, 10, 0),
(147, '2025-06-06 16:02:58', 3, 10, 0),
(148, '2025-06-06 16:03:29', 2, 10, 0),
(149, '2025-06-06 16:03:49', 1, 10, 0),
(150, '2025-06-06 16:04:34', 2, 10, 0),
(151, '2025-06-06 16:06:55', 1, 11, 0),
(152, '2025-06-06 16:07:06', 0, 11, 0),
(153, '2025-06-06 16:07:13', 1, 11, 0),
(154, '2025-06-06 16:07:27', 3, 11, 0),
(155, '2025-06-06 16:07:53', 2, 11, 0),
(156, '2025-06-06 16:08:11', 1, 11, 0),
(157, '2025-06-06 16:08:23', 2, 11, 0),
(158, '2025-06-06 16:09:03', 0, 11, 0),
(159, '2025-06-06 16:10:12', 2, 11, 0),
(160, '2025-06-06 16:12:25', 0, 11, 0),
(161, '2025-06-06 16:15:39', 1, 12, 1),
(162, '2025-06-06 16:18:47', 0, 9, 0),
(163, '2025-06-06 16:25:59', 0, 9, 0),
(164, '2025-06-06 16:26:12', 5, 9, 0),
(165, '2025-06-06 16:36:28', 0, 9, 1),
(166, '2025-06-07 21:53:32', 0, 1, 0),
(167, '2025-06-07 21:54:01', 0, 1, 0),
(168, '2025-06-07 21:54:27', 0, 1, 0),
(169, '2025-06-07 21:54:52', 0, 1, 0),
(170, '2025-06-07 21:55:11', 0, 1, 0),
(171, '2025-06-07 21:55:27', 0, 1, 0),
(172, '2025-06-07 21:59:10', 0, 1, 0),
(173, '2025-06-07 22:18:09', 0, 1, 0),
(174, '2025-06-07 22:18:58', 1, 1, 0),
(175, '2025-06-07 22:19:37', 0, 1, 0),
(176, '2025-06-07 22:19:57', 0, 1, 0),
(177, '2025-06-07 22:20:17', 3, 1, 0),
(178, '2025-06-07 22:21:32', 0, 1, 0),
(179, '2025-06-10 13:57:20', 0, 1, 0),
(180, '2025-06-10 13:57:55', 0, 1, 0),
(181, '2025-06-10 15:39:57', 0, 1, 0),
(182, '2025-06-10 17:28:36', 0, 1, 0),
(183, '2025-06-13 19:32:59', 0, 1, 0),
(184, '2025-06-13 19:33:15', 1, 1, 0),
(185, '2025-06-13 19:33:48', 0, 1, 0),
(186, '2025-06-13 19:34:00', 0, 1, 0),
(187, '2025-06-13 19:34:14', 1, 1, 0),
(188, '2025-06-17 18:08:18', 0, 1, 0),
(189, '2025-06-21 20:35:13', 0, 1, 0),
(190, '2025-06-21 21:40:53', 0, 1, 0),
(191, '2025-06-21 21:44:49', 0, 101, 0),
(192, '2025-06-21 21:45:06', 0, 101, 0),
(193, '2025-06-22 16:14:56', 0, 101, 0),
(194, '2025-06-22 16:15:18', 0, 101, 0),
(195, '2025-06-22 17:42:22', 0, 101, 0),
(196, '2025-06-22 17:42:47', 0, 101, 0),
(197, '2025-06-23 20:12:41', 0, 1, 0),
(198, '2025-07-04 15:23:40', 0, 121, 0),
(199, '2025-07-04 16:09:09', 1, 121, 0),
(200, '2025-07-06 20:07:05', 0, 121, 0),
(201, '2025-07-06 20:47:24', 0, 121, 0),
(202, '2025-07-06 20:47:34', 2, 121, 0),
(203, '2025-07-07 14:08:53', 0, 121, 0),
(204, '2025-07-07 14:09:08', 3, 121, 0),
(205, '2025-07-07 14:14:37', 0, 121, 0),
(206, '2025-07-07 14:15:27', 0, 121, 0),
(207, '2025-07-07 14:26:48', 0, 121, 0),
(208, '2025-07-07 14:29:53', 0, 121, 0),
(209, '2025-07-07 14:34:23', 0, 121, 0),
(210, '2025-07-07 14:35:29', 0, 121, 0),
(211, '2025-07-07 14:42:41', 0, 121, 0),
(212, '2025-07-07 14:44:23', 0, 121, 0),
(213, '2025-07-07 15:13:56', 0, 121, 0),
(214, '2025-07-07 15:15:08', 0, 121, 0),
(215, '2025-07-07 15:17:07', 0, 121, 0),
(216, '2025-07-07 15:21:32', 0, 121, 0),
(217, '2025-07-07 15:28:59', 0, 121, 0),
(218, '2025-07-07 15:29:53', 1, 121, 0),
(219, '2025-07-07 15:34:10', 0, 121, 0),
(220, '2025-07-07 15:40:47', 0, 121, 0),
(221, '2025-07-07 15:45:01', 0, 121, 0),
(222, '2025-07-07 15:47:01', 0, 121, 0),
(223, '2025-07-07 15:47:23', 0, 121, 0),
(224, '2025-07-07 15:51:23', 0, 121, 0),
(225, '2025-07-07 15:58:21', 0, 121, 0),
(226, '2025-07-07 15:58:50', 0, 121, 0),
(227, '2025-07-07 16:04:38', 0, 121, 0),
(228, '2025-07-07 16:05:18', 0, 121, 0),
(229, '2025-07-07 16:06:35', 0, 121, 0),
(230, '2025-07-07 16:07:22', 0, 121, 0),
(231, '2025-07-07 16:11:41', 0, 121, 0),
(232, '2025-07-07 16:13:54', 0, 121, 0),
(233, '2025-07-07 16:15:38', 0, 121, 0),
(234, '2025-07-07 16:16:05', 0, 121, 0),
(235, '2025-07-07 16:16:41', 0, 121, 0),
(236, '2025-07-07 16:17:34', 0, 121, 0),
(237, '2025-07-07 16:18:23', 0, 121, 0),
(238, '2025-07-07 16:19:24', 3, 121, 0),
(239, '2025-07-07 16:29:21', 1, 121, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `partida_pregunta`
--

CREATE TABLE `partida_pregunta` (
  `id` int(11) NOT NULL,
  `id_partida` int(11) NOT NULL,
  `id_pregunta` bigint(20) UNSIGNED NOT NULL,
  `respondida_correctamente` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `partida_pregunta`
--

INSERT INTO `partida_pregunta` (`id`, `id_partida`, `id_pregunta`, `respondida_correctamente`) VALUES
(406, 183, 364, 0),
(407, 184, 451, 1),
(408, 184, 363, 0),
(409, 185, 226, 0),
(410, 186, 427, 0),
(411, 187, 131, 1),
(412, 187, 236, 0),
(413, 198, 109, 0),
(414, 199, 400, 0),
(415, 199, 118, 1),
(416, 200, 32, 0),
(417, 201, 444, 0),
(418, 202, 30, 1),
(419, 202, 97, 1),
(420, 203, 147, 0),
(421, 204, 181, 1),
(422, 204, 31, 1),
(423, 204, 112, 1),
(424, 204, 399, 0),
(425, 206, 447, 0),
(426, 212, 35, 0),
(427, 212, 35, 0),
(428, 212, 35, 0),
(429, 213, 231, 0),
(430, 214, 345, 0),
(431, 215, 222, 0),
(432, 216, 110, 0),
(433, 217, 1, 0),
(434, 218, 61, 1),
(435, 218, 56, 0),
(436, 228, 90, 0),
(437, 233, 379, 0),
(438, 234, 77, 0),
(439, 235, 92, 0),
(440, 236, 116, 0),
(441, 237, 186, 0),
(442, 238, 277, 0),
(443, 238, 26, 1),
(444, 238, 59, 1),
(445, 238, 94, 1),
(446, 239, 432, 0),
(447, 239, 6, 0),
(448, 239, 93, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pregunta`
--

CREATE TABLE `pregunta` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_categoria` int(11) DEFAULT NULL,
  `enunciado` text NOT NULL,
  `id_dificultad` int(11) NOT NULL DEFAULT 2
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pregunta`
--

INSERT INTO `pregunta` (`id`, `id_categoria`, `enunciado`, `id_dificultad`) VALUES
(1, 1, '¿Cuál es el símbolo químico del oro?', 1),
(2, 1, '¿Cuántos planetas hay en el sistema solar?', 1),
(3, 1, '¿Qué gas es esencial para la respiración humana?', 1),
(4, 1, '¿Qué órgano bombea la sangre en el cuerpo humano?', 1),
(5, 1, '¿Cómo se llama el proceso por el que las plantas hacen su alimento?', 1),
(6, 1, '¿Qué tipo de animal es una orca?', 1),
(7, 1, '¿Cuál es el hueso más largo del cuerpo humano?', 1),
(8, 1, '¿Qué científico formuló la teoría de la relatividad?', 2),
(9, 1, '¿Cuál es el planeta más cercano al Sol?', 1),
(13, 1, '¿Cuántos sentidos tiene el ser humano tradicionalmente?', 1),
(21, 1, '¿Qué planeta es conocido como el planeta rojo?', 1),
(22, 1, '¿Qué estado de la materia es el aire?', 1),
(24, 1, '¿Qué gas exhalan los humanos al respirar?', 1),
(25, 1, '¿Qué órgano usamos para ver?', 1),
(26, 1, '¿Cuál es el líquido que transporta oxígeno en el cuerpo?', 1),
(27, 1, '¿Cómo se llama la fuerza que nos mantiene en la Tierra?', 1),
(28, 1, '¿Qué astro da luz y calor a la Tierra?', 1),
(29, 1, '¿Qué tipo de animal es una rana?', 2),
(30, 1, '¿Cuál es el órgano que filtra la sangre?', 2),
(31, 1, '¿Cuál es el número atómico del carbono?', 2),
(32, 1, '¿Qué parte del cerebro controla el equilibrio?', 2),
(33, 1, '¿Qué partícula subatómica tiene carga negativa?', 2),
(34, 1, '¿Qué es el ADN?', 2),
(35, 1, '¿Qué tipo de energía se almacena en los alimentos?', 2),
(36, 1, '¿Qué científico propuso la teoría de la evolución?', 2),
(37, 1, '¿Cuál es el proceso por el que un líquido pasa a gas?', 2),
(38, 1, '¿Qué es una célula procariota?', 2),
(39, 1, '¿Cuál es la fórmula del agua?', 2),
(40, 1, '¿Qué tipo de enlace une a los átomos de agua?', 2),
(41, 1, '¿Qué órgano produce insulina?', 2),
(42, 1, '¿Qué es la mitocondria?', 2),
(43, 1, '¿Cuál es el símbolo químico del sodio?', 2),
(44, 1, '¿Qué capa de la atmósfera nos protege del sol?', 3),
(45, 1, '¿Cómo se llama el cambio de estado de gas a líquido?', 3),
(46, 1, '¿Qué célula transporta oxígeno en la sangre?', 3),
(47, 1, '¿Qué fenómeno explica la propagación de la luz?', 3),
(48, 1, '¿Qué significa \"pH\"?', 3),
(49, 1, '¿Qué vitamina se produce con la exposición al sol?', 3),
(50, 1, '¿Cuál es la unidad de medida de la energía?', 3),
(51, 2, '¿Cuántos minutos dura un partido de fútbol profesional?', 1),
(52, 2, '¿Quién tiene el récord de más goles en mundiales de fútbol?', 3),
(53, 2, '¿Dónde se celebraron los Juegos Olímpicos de 2016?', 2),
(54, 2, '¿Qué país ha ganado más Copas del Mundo de fútbol?', 2),
(55, 2, '¿En qué deporte se destaca Serena Williams?', 1),
(56, 2, '¿Cómo se llama la liga de baloncesto profesional de EE. UU.?', 1),
(57, 2, '¿Qué país organiza el Tour de Francia?', 2),
(58, 2, '¿Qué deporte se juega con una tabla y olas?', 1),
(59, 2, '¿En qué deporte compite Lewis Hamilton?', 1),
(60, 2, '¿Cuál es el apodo de Diego Maradona?', 2),
(61, 2, '¿En qué deporte se usa una raqueta y una pelota amarilla?', 1),
(62, 2, '¿Cuál es el deporte más popular del mundo?', 1),
(63, 2, '¿Qué país ganó el Mundial de Fútbol en 2022?', 2),
(64, 2, '¿Cuántos jugadores tiene un equipo de fútbol en el campo?', 1),
(65, 2, '¿Qué equipo de la NBA tiene como apodo \"Los Lakers\"?', 1),
(66, 2, '¿Qué deporte practica Usain Bolt?', 1),
(67, 2, '¿Qué deporte se juega con un palo y un disco?', 2),
(68, 2, '¿Qué país es famoso por el sumo?', 2),
(69, 2, '¿Qué selección ganó el Mundial 2014?', 3),
(70, 2, '¿Cuántos puntos vale un triple en básquet?', 1),
(71, 2, '¿Qué deporte se juega en un campo con 18 hoyos?', 1),
(72, 2, '¿Cuál es el nombre del trofeo de la Copa Mundial de Fútbol?', 2),
(73, 2, '¿En qué deporte se usa una red alta y una pelota para pasar por encima?', 2),
(74, 2, '¿Qué país ganó la Copa América 2021?', 3),
(75, 2, '¿Qué deportista argentino es conocido como “la pulga”?', 1),
(76, 2, '¿Qué color lleva el maillot del líder del Tour de Francia?', 3),
(77, 2, '¿Qué deporte se juega con un bate y una pelota?', 1),
(78, 2, '¿Cuál es el país anfitrión de los Juegos Olímpicos 2024?', 3),
(79, 2, '¿En qué deporte compitió Michael Phelps?', 1),
(80, 2, '¿Qué selección de fútbol tiene cinco Copas del Mundo?', 2),
(81, 2, '¿Dónde se originó el baloncesto?', 3),
(82, 2, '¿Cuál es el nombre del estadio del Real Madrid?', 3),
(83, 2, '¿Cuántos aros hay en el logo olímpico?', 1),
(84, 2, '¿Qué país ganó la Eurocopa 2020?', 3),
(85, 2, '¿Qué deporte se juega principalmente sobre hielo?', 2),
(86, 2, '¿Qué deporte combina esquí, tiro y resistencia?', 3),
(87, 2, '¿Qué instrumento se utiliza para medir el tiempo en una carrera?', 2),
(88, 2, '¿Cuál es el deporte nacional de Japón?', 3),
(89, 2, '¿Qué deporte se practica en un velódromo?', 2),
(90, 2, '¿Cuál es el objeto que se lanza en el bowling?', 1),
(91, 2, '¿Qué deporte se practica en una cancha con red y raquetas?', 1),
(92, 2, '¿Cuántos jugadores tiene un equipo de básquet en cancha?', 1),
(93, 2, '¿Con qué parte del cuerpo no se puede tocar el balón en fútbol?', 1),
(94, 2, '¿En qué deporte se utilizan cloro, gorro y gafas?', 1),
(95, 2, '¿Qué deporte se juega principalmente en una cancha de césped?', 1),
(96, 2, '¿Qué deporte se practica sobre hielo con patines y un disco?', 2),
(97, 2, '¿Qué jugador de fútbol argentino ganó el Mundial 2022?', 2),
(98, 2, '¿Qué deporte combina carrera, natación y ciclismo?', 2),
(99, 2, '¿Qué deporte se juega con raqueta en una cancha dividida por una red alta?', 2),
(100, 2, '¿Qué color representa el primer lugar en una medalla olímpica?', 1),
(101, 3, '¿Cuál es la capital de Australia?', 3),
(102, 3, '¿Qué país tiene forma de bota?', 1),
(103, 3, '¿Dónde se encuentra el Monte Everest?', 2),
(104, 3, '¿Qué río es el más largo del mundo?', 2),
(105, 3, '¿Cuál es el país más grande del mundo en superficie?', 1),
(106, 3, '¿En qué continente está Egipto?', 1),
(107, 3, '¿Qué país tiene más islas en el mundo?', 3),
(108, 3, '¿Cuál es la capital de Marruecos?', 2),
(109, 3, '¿Qué océano está al este de África?', 2),
(110, 3, '¿Cuál es el país más poblado del mundo?', 1),
(111, 3, '¿Cuál es la capital de Francia?', 1),
(112, 3, '¿Qué océano está entre África y Australia?', 2),
(113, 3, '¿Cuál es el continente más pequeño?', 1),
(114, 3, '¿Qué país tiene forma de una hoja de arce en su bandera?', 1),
(115, 3, '¿Dónde se encuentra la Torre Eiffel?', 1),
(116, 3, '¿Qué país tiene la ciudad de Tokio como capital?', 1),
(117, 3, '¿Qué desierto cubre gran parte del norte de África?', 2),
(118, 3, '¿Qué mar baña las costas de Italia?', 2),
(119, 3, '¿En qué continente está Brasil?', 1),
(120, 3, '¿Cuál es el país con más población de América del Sur?', 1),
(121, 3, '¿Qué país limita al norte con Estados Unidos?', 1),
(122, 3, '¿Qué isla es famosa por sus moáis?', 2),
(123, 3, '¿Cuál es la capital de España?', 1),
(124, 3, '¿Cuál es el río que cruza Egipto?', 2),
(125, 3, '¿En qué continente está Sudáfrica?', 1),
(126, 3, '¿Cuál es el país más grande de América del Norte?', 2),
(127, 3, '¿Qué cordillera atraviesa América del Sur de norte a sur?', 2),
(128, 3, '¿Qué país tiene como capital a Berlín?', 1),
(129, 3, '¿Cuál es el idioma oficial de Brasil?', 1),
(130, 3, '¿Qué país tiene forma alargada en América del Sur?', 2),
(131, 3, '¿Cuál es el país más montañoso del mundo?', 3),
(132, 3, '¿Qué país tiene la ciudad más austral del mundo?', 3),
(133, 3, '¿Cuál es el lago más profundo del mundo?', 3),
(134, 3, '¿Qué isla es la más grande del mundo?', 3),
(135, 3, '¿Cuál es el desierto más frío del mundo?', 3),
(136, 3, '¿En qué país está el Cabo de Buena Esperanza?', 2),
(137, 3, '¿Qué línea divide la Tierra en hemisferio norte y sur?', 1),
(138, 3, '¿Cuál es el país más pequeño del mundo?', 2),
(139, 3, '¿Qué país tiene más fronteras terrestres con otros países?', 3),
(140, 3, '¿Cuál es la capital de Kazajistán?', 3),
(141, 3, '¿Qué país tiene más volcanes activos?', 3),
(142, 3, '¿Qué cordillera separa Europa de Asia?', 2),
(143, 3, '¿Qué país se extiende en dos continentes?', 2),
(144, 3, '¿Cuál es la ciudad más alta del mundo?', 3),
(145, 3, '¿Qué río cruza más países?', 3),
(146, 3, '¿Qué país no tiene salida al mar?', 2),
(147, 3, '¿Dónde se encuentra el Mar Muerto?', 2),
(148, 3, '¿Qué archipiélago pertenece a Ecuador?', 1),
(149, 3, '¿En qué país están los fiordos más conocidos?', 1),
(150, 3, '¿Cuál es la capital de Mongolia?', 3),
(181, 4, '¿Quién pintó la “Mona Lisa”?', 2),
(182, 4, '¿A qué estilo artístico pertenece Salvador Dalí?', 2),
(183, 4, '¿En qué país nació Pablo Picasso?', 2),
(184, 4, '¿Qué obra pintó Edvard Munch?', 2),
(185, 4, '¿Qué instrumento toca un violinista?', 1),
(186, 4, '¿Qué pintor es famoso por sus girasoles?', 1),
(187, 4, '¿Quién escribió “La Divina Comedia”?', 3),
(188, 4, '¿Qué arquitecto diseñó la Sagrada Familia en Barcelona?', 2),
(189, 4, '¿Cuál de estos no es un movimiento artístico?', 2),
(190, 4, '¿Qué técnica artística usa pinceles y pigmentos?', 1),
(191, 4, '¿Quién pintó “El jardín de las delicias”?', 3),
(192, 4, '¿Qué artista es reconocido por su técnica del puntillismo?', 3),
(193, 4, '¿Qué danza se originó en Brasil con raíces africanas?', 1),
(194, 4, '¿Qué es un tríptico?', 1),
(195, 4, '¿Qué artista creó la serie de latas de sopa Campbell?', 3),
(196, 4, '¿Qué corriente artística buscaba representar el subconsciente?', 3),
(197, 4, '¿Qué es una sinfonía?', 1),
(198, 4, '¿Qué técnica utiliza madera para imprimir imágenes?', 2),
(199, 4, '¿Quién compuso “La Traviata”?', 3),
(200, 4, '¿Cuál fue una característica del arte gótico?', 1),
(221, 6, '¿Qué saga cinematográfica incluye a un personaje llamado Frodo?', 1),
(222, 6, '¿Quién canta la canción \"Thriller\"?', 1),
(223, 6, '¿Qué serie se desarrolla en el mundo ficticio de Westeros?', 2),
(224, 6, '¿Cuál de estos personajes es un superhéroe de Marvel?', 1),
(225, 6, '¿Qué película ganó el Óscar a Mejor Película en 2020?', 2),
(226, 6, '¿Quién interpreta a Jack en “Titanic”?', 3),
(227, 6, '¿Cuál de estas bandas es británica?', 2),
(228, 6, '¿En qué serie aparece el personaje Sheldon Cooper?', 2),
(229, 6, '¿Qué película de Disney incluye la canción “Libre soy”?', 1),
(230, 6, '¿Quién dirigió la trilogía original de “Star Wars”?', 2),
(231, 6, '¿Qué estrella del pop fue parte del grupo *NSYNC?', 1),
(232, 6, '¿En qué serie aparece el personaje Eleven?', 2),
(233, 6, '¿Qué instrumento toca Lisa Simpson?', 1),
(234, 6, '¿Qué serie fue la primera en ganar un Emmy como \"Mejor Serie Dramática\"?', 2),
(235, 6, '¿Quién compuso la música de la película “Interstellar”?', 3),
(236, 6, '¿Cuál fue la primera película en ganar 11 premios Óscar?', 3),
(237, 6, '¿Qué película de Studio Ghibli ganó el Óscar a mejor animación?', 3),
(238, 6, '¿Quién interpreta a Hannibal Lecter en “El silencio de los inocentes”?', 3),
(239, 6, '¿Qué famosa artista interpretó a Ally en “Nace una estrella”?', 1),
(240, 6, '¿Qué película tiene la frase: “Houston, tenemos un problema”?', 3),
(277, 4, '¿Qué instrumento se asocia con Ludwig van Beethoven?', 1),
(342, 6, '¿Qué pintor es famoso por cortarse una oreja?', 1),
(343, 6, '¿Cuál es el instrumento principal en un concierto de piano?', 1),
(344, 6, '¿Quién pintó la Mona Lisa?', 1),
(345, 6, '¿Qué instrumento musical tiene cuerdas?', 1),
(346, 6, '¿En qué ciudad está el Museo del Louvre?', 1),
(347, 6, '¿Qué color se obtiene mezclando azul y amarillo?', 1),
(348, 6, '¿Qué personaje de Disney es una sirena?', 1),
(349, 6, '¿Quién escribió la obra “Romeo y Julieta”?', 1),
(350, 6, '¿Qué película cuenta la historia de juguetes que cobran vida?', 1),
(351, 6, '¿Cuál es el nombre del ratón más famoso de Disney?', 1),
(352, 6, '¿Quién dirigió la película \"El Gran Hotel Budapest\"?', 2),
(353, 6, '¿Qué banda compuso el álbum \"The Dark Side of the Moon\"?', 2),
(354, 6, '¿Qué director es conocido por la trilogía “El Señor de los Anillos”?', 2),
(355, 6, '¿Quién protagoniza la película “Forrest Gump”?', 2),
(356, 6, '¿Cuál de estos músicos es famoso por su \"moonwalk\"?', 2),
(358, 6, '¿Quién interpreta al personaje Tony Stark en Marvel?', 2),
(359, 6, '¿Qué actor protagonizó “La La Land”?', 2),
(360, 6, '¿Qué saga tiene casas como Gryffindor y Slytherin?', 2),
(361, 6, '¿Qué película popular gira en torno a los sueños dentro de sueños?', 2),
(362, 6, '¿Qué película experimental fue dirigida por David Lynch y se estrenó en 2001?', 3),
(363, 6, '¿Qué director ganó el Óscar a Mejor Dirección por \"La forma del agua\"?', 3),
(364, 6, '¿Cuál fue el primer largometraje animado producido por Walt Disney?', 3),
(365, 6, '¿Quién interpretó a Truman Capote en la película \"Capote\" de 2005?', 3),
(366, 6, '¿Qué banda sonora fue compuesta por Vangelis y ganó un Óscar en 1982?', 3),
(367, 6, '¿Qué película ganó el León de Oro en el Festival de Venecia en 2019?', 3),
(368, 6, '¿Qué serie fue la primera en ganar un Emmy por tener un elenco completamente afroamericano?', 3),
(369, 6, '¿Qué compositor creó la música para \"La naranja mecánica\"?', 3),
(370, 6, '¿En qué año se emitió por primera vez \"The Twilight Zone\"?', 3),
(371, 6, '¿Cuál es el nombre completo del personaje interpretado por Uma Thurman en \"Kill Bill\"?', 3),
(372, 5, '¿Quién fue el primer presidente de los Estados Unidos?', 1),
(373, 5, '¿En qué año terminó la Segunda Guerra Mundial?', 1),
(374, 5, '¿Qué civilización construyó las pirámides de Egipto?', 1),
(375, 5, '¿Quién descubrió América en 1492?', 1),
(376, 5, '¿Qué muro cayó en 1989?', 1),
(377, 5, '¿Qué país era gobernado por los zares?', 1),
(378, 5, '¿Qué guerra terminó con la derrota de Napoleón Bonaparte?', 1),
(379, 5, '¿Qué famosa declaración se firmó en 1776?', 1),
(380, 5, '¿Cuál fue el imperio liderado por Julio César?', 1),
(381, 5, '¿Qué ciudad fue destruida por el volcán Vesubio en el año 79 d.C.?', 1),
(382, 5, '¿Qué famosa reina egipcia se relacionó con Julio César y Marco Antonio?', 1),
(383, 5, '¿Qué país inició la Revolución Industrial?', 1),
(384, 5, '¿Quién fue conocido como el Libertador de América del Sur?', 1),
(385, 5, '¿Qué guerra ocurrió entre el norte y el sur de Estados Unidos?', 1),
(386, 5, '¿Quién lideró a los nazis durante la Segunda Guerra Mundial?', 1),
(387, 5, '¿Qué país fue invadido por Alemania en 1939, iniciando la Segunda Guerra Mundial?', 1),
(388, 5, '¿Qué civilización construyó Machu Picchu?', 1),
(389, 5, '¿Qué imperio fue liderado por Gengis Kan? ', 2),
(390, 5, '¿Qué tratado puso fin a la Primera Guerra Mundial?', 2),
(391, 5, '¿Qué ciudad fue capital del Imperio Bizantino?', 2),
(392, 5, '¿Quién fue el líder soviético durante la Segunda Guerra Mundial?', 2),
(393, 5, '¿Cuál fue la causa principal de la Revolución Francesa?', 2),
(394, 5, '¿Qué guerra involucró a Vietnam del Norte y del Sur?', 2),
(395, 5, '¿Cuál fue el conflicto entre Estados Unidos y la URSS conocido por su tensión nuclear?', 2),
(396, 5, '¿Qué imperio fue derrotado en la Batalla de Waterloo?', 2),
(397, 5, '¿Qué país lideró la conquista de América en el siglo XVI?', 2),
(398, 5, '¿Cuál fue la primera civilización en desarrollar la escritura?', 2),
(399, 5, '¿Qué evento marcó el inicio de la Edad Media?', 2),
(400, 5, '¿Quién fue el emperador romano cuando se construyó el Coliseo?', 2),
(401, 5, '¿Qué conflicto bélico se desarrolló entre 1914 y 1918?', 2),
(402, 5, '¿Qué evento histórico ocurrió en 1789 en Francia?', 2),
(403, 5, '¿Quién fue el dictador español durante gran parte del siglo XX?', 2),
(404, 5, '¿Qué revolución dio origen a la URSS?', 2),
(405, 5, '¿En qué país tuvo lugar la Revolución Meiji?', 2),
(406, 5, '¿En qué año se sancionó la Constitución Nacional Argentina?', 3),
(407, 5, '¿Qué evento marcó el inicio de la independencia de México?', 3),
(408, 5, '¿Qué presidente chileno fue derrocado por un golpe de Estado en 1973?', 3),
(409, 5, '¿Qué movimiento fue liderado por Emiliano Zapata en México?', 3),
(410, 5, '¿En qué país ocurrió la Revolución Sandinista?', 3),
(411, 5, '¿Qué evento marcó el inicio de la Revolución Rusa en 1917?', 3),
(412, 5, '¿Cuál fue la principal causa de la Guerra de Secesión en Estados Unidos?', 3),
(413, 5, '¿Quién fue el principal autor de \"El Príncipe\", obra clave del Renacimiento político?', 3),
(414, 5, '¿En qué año se firmó la Paz de Westfalia, que puso fin a la Guerra de los Treinta Años?', 3),
(415, 5, '¿Qué emperador romano legalizó el cristianismo con el Edicto de Milán?', 3),
(416, 5, '¿Qué tratado dividió el mundo entre España y Portugal en 1494?', 3),
(417, 5, '¿Cuál fue el nombre del código legal del Imperio Bizantino?', 3),
(418, 5, '¿Qué filósofo ilustrado escribió \"El contrato social\"?', 3),
(419, 5, '¿Cuál fue la causa principal de la Guerra de los Cien Años?', 3),
(420, 5, '¿Quién fue la reina que estableció la monarquía absoluta en Francia?', 3),
(421, 5, '¿Qué tratado puso fin a la Guerra Franco-Prusiana y fue precursor de la unificación alemana?', 3),
(422, 1, '¿Qué tipo de célula es responsable de la defensa inmunológica?', 2),
(423, 1, '¿Cuál es la función principal del retículo endoplasmático rugoso?', 3),
(424, 1, '¿Qué ley de Mendel establece que los alelos se segregan independientemente?', 3),
(425, 1, '¿Qué científico propuso la teoría celular?', 3),
(426, 1, '¿Qué estructura celular está presente en células animales pero no en vegetales?', 3),
(427, 1, '¿Qué nombre recibe el proceso de división celular que produce gametos?', 3),
(428, 1, '¿Cuál es el principal pigmento fotosintético en las plantas?', 3),
(429, 1, '¿Qué tipo de enlace químico implica la transferencia de electrones?', 3),
(430, 1, '¿Cuál es la función del complejo de Golgi en la célula?', 3),
(431, 1, '¿Qué partícula subatómica tiene carga positiva?', 3),
(432, 4, '¿Cuál es el instrumento musical de cuerda más pequeño?', 1),
(433, 4, '¿Qué color se obtiene mezclando rojo y azul?', 1),
(434, 4, '¿Quién es el autor del “Guernica”?', 1),
(435, 4, '¿Qué danza clásica es originaria de Francia?', 1),
(436, 4, '¿Qué material se usa comúnmente para esculpir?', 1),
(437, 4, '¿Qué instrumento tiene teclas y cuerdas?', 1),
(438, 4, '¿Cómo se llama el estilo artístico con formas geométricas?', 1),
(439, 4, '¿Cuál es la capital mundial del arte moderno?', 1),
(440, 4, '¿Qué artista es famoso por sus pinturas de girasoles?', 1),
(441, 4, '¿Cuál fue el movimiento artístico que surgió como respuesta al impresionismo?', 2),
(442, 4, '¿Quién es el autor del Guernica?', 2),
(443, 4, '¿Qué escritor argentino ganó el Premio Cervantes en 2009?', 2),
(444, 4, '¿Cuál es la obra más famosa de Miguel Ángel en la Capilla Sixtina?', 2),
(445, 4, '¿Quién fue el compositor del ballet “El lago de los cisnes”?', 2),
(446, 4, '¿Qué corriente artística se caracteriza por lo irracional y lo onírico?', 2),
(447, 4, '¿Cuál es la nacionalidad del pintor Gustav Klimt?', 2),
(448, 4, '¿En qué siglo vivió William Shakespeare?', 2),
(449, 4, '¿Qué material usaban los escultores griegos clásicos?', 2),
(450, 4, '¿Qué obra literaria comienza con la frase “En un lugar de La Mancha…”?', 2),
(451, 4, '¿Quién fue el creador del mural “El hombre controlador del universo”?', 3),
(452, 4, '¿Qué compositor es conocido por su obra “Bolero”?', 3),
(453, 4, '¿Cuál fue el objetivo principal del movimiento Dadaísta?', 3),
(454, 4, '¿Qué escultor renacentista creó la obra “David” en mármol?', 3),
(455, 4, '¿Qué escritor escribió la obra “Esperando a Godot”?', 3),
(456, 4, '¿Qué filósofo griego es el autor de “La República”?', 3),
(457, 4, '¿Qué corriente artística del siglo XX emplea la repetición y el uso de imágenes populares?', 3),
(458, 4, '¿Cuál es el estilo arquitectónico de la catedral de Notre Dame?', 3),
(459, 4, '¿Qué poeta chileno recibió el Premio Nobel de Literatura en 1971?', 3),
(460, 4, '¿Qué obra teatral es considerada el máximo exponente del teatro del absurdo?', 3),
(461, 0, '¿Qué comen las plantas carnívoras?', 2),
(462, 0, '¿Cuál fue la selección campeona del mundo en fútbol masculino en 2014?', 2),
(463, 0, '¿Quién es el máximo ganador del Balón de Oro (Premio al mejor futbolista del año)?', 2),
(480, 0, '¿Qué serie popular está ambientada en Hawkins, Indiana?', 2),
(481, 1, '¿Qué energía se obtiene del sol?', 2),
(482, 2, '¿Qué jugador argentino hizo el último penal en la final del mundial 2022?', 2),
(483, 0, '¿Cómo se llama el mejor amigo de Harry Potter?', 2),
(484, 0, '¿Cómo se llama el hechizo de Harry Potter que te asesina?', 2),
(485, 0, '¿Cómo se llama el hechizo de Harry Potter que te asesina?', 2),
(486, 6, '¿Cómo se llama el hechizo de Harry Potter que te asesina?', 2),
(487, 2, '¿De qué país es originario el Taekwondo?', 2),
(488, 5, '¿Quién fue el Libertador de Argentina?', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pregunta_reportada`
--

CREATE TABLE `pregunta_reportada` (
  `id` int(11) NOT NULL,
  `idPregunta` int(11) NOT NULL,
  `idReporteMotivo` int(11) DEFAULT NULL,
  `fechaReporte` datetime DEFAULT current_timestamp(),
  `estaVerificada` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pregunta_reportada`
--

INSERT INTO `pregunta_reportada` (`id`, `idPregunta`, `idReporteMotivo`, `fechaReporte`, `estaVerificada`) VALUES
(19, 400, 3, '2025-07-04 21:34:43', 0),
(20, 277, 3, '2025-07-07 21:21:20', 0),
(21, 6, 4, '2025-07-07 21:30:36', 0),
(22, 93, 2, '2025-07-07 21:30:58', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pregunta_solicitada`
--

CREATE TABLE `pregunta_solicitada` (
  `id` int(11) NOT NULL,
  `id_categoria` int(11) NOT NULL,
  `enunciado` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pregunta_solicitada`
--

INSERT INTO `pregunta_solicitada` (`id`, `id_categoria`, `enunciado`) VALUES
(26, 3, '¿Cuántos continentes hay en el mundo?'),
(27, 2, '¿De qué material está hecha una pelota de Rugby?'),
(28, 1, '¿Cuál de las siguientes células no existe?'),
(29, 4, '¿De qué banda es la canción \"Back in black\"?');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pregunta_usuario`
--

CREATE TABLE `pregunta_usuario` (
  `id` int(11) NOT NULL,
  `idusuario` int(11) NOT NULL,
  `idpregunta` bigint(20) UNSIGNED NOT NULL,
  `id_respuesta_elegida` bigint(20) UNSIGNED DEFAULT NULL,
  `es_correcta` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pregunta_usuario`
--

INSERT INTO `pregunta_usuario` (`id`, `idusuario`, `idpregunta`, `id_respuesta_elegida`, `es_correcta`) VALUES
(223, 1, 364, 1455, 0),
(224, 1, 451, 1801, 1),
(225, 1, 363, 1449, 0),
(226, 1, 226, 901, 0),
(227, 1, 427, 1706, 0),
(228, 1, 131, 523, 1),
(229, 1, 236, 943, 0),
(230, 121, 109, 433, 0),
(231, 121, 400, 1598, 0),
(232, 121, 118, 470, 1),
(233, 121, 32, 126, 0),
(234, 121, 444, 1774, 0),
(235, 121, 30, 120, 1),
(236, 121, 97, 385, 1),
(237, 121, 147, 585, 0),
(238, 121, 181, 722, 1),
(239, 121, 31, 122, 1),
(240, 121, 112, 446, 1),
(241, 121, 399, 1595, 0),
(242, 121, 447, 1786, 0),
(244, 121, 35, NULL, 0),
(245, 121, 231, NULL, 0),
(246, 121, 345, NULL, 0),
(247, 121, 222, NULL, 0),
(248, 121, 110, NULL, 0),
(249, 121, 1, NULL, 0),
(250, 121, 61, 242, 1),
(251, 121, 56, 221, 0),
(252, 121, 90, NULL, 0),
(253, 121, 379, NULL, 0),
(254, 121, 77, NULL, 0),
(255, 121, 92, NULL, 0),
(256, 121, 116, NULL, 0),
(257, 121, 186, 743, 0),
(258, 121, 277, 1144, 0),
(259, 121, 26, 103, 1),
(260, 121, 59, 234, 1),
(261, 121, 94, 373, 1),
(262, 121, 432, NULL, 0),
(263, 121, 6, 24, 0),
(264, 121, 93, 369, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reporte_motivo`
--

CREATE TABLE `reporte_motivo` (
  `id` int(11) NOT NULL,
  `descripcion` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `reporte_motivo`
--

INSERT INTO `reporte_motivo` (`id`, `descripcion`) VALUES
(1, 'Esta mal formulada/No se entiende'),
(2, 'Tiene faltas de ortografía'),
(3, 'La respuesta es incorrecta'),
(4, 'Contenido inapropiado'),
(5, 'Otro motivo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `respuesta`
--

CREATE TABLE `respuesta` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_pregunta` int(11) NOT NULL,
  `texto` text NOT NULL,
  `es_correcta` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `respuesta`
--

INSERT INTO `respuesta` (`id`, `id_pregunta`, `texto`, `es_correcta`) VALUES
(1, 1, 'Ag', 0),
(2, 1, 'Au', 1),
(3, 1, 'Gd', 0),
(4, 1, 'Fe', 0),
(5, 2, '9', 0),
(6, 2, '8', 1),
(7, 2, '7', 0),
(8, 2, '10', 0),
(9, 3, 'Nitrógeno', 0),
(10, 3, 'Oxígeno', 1),
(11, 3, 'Dióxido de carbono', 0),
(12, 3, 'Hidrógeno', 0),
(13, 4, 'Pulmón', 0),
(14, 4, 'Corazón', 1),
(15, 4, 'Hígado', 0),
(16, 4, 'Riñón', 0),
(17, 5, 'Germinación', 0),
(18, 5, 'Respiración', 0),
(19, 5, 'Fotosíntesis', 1),
(20, 5, 'Digestión', 0),
(21, 6, 'Pez', 0),
(22, 6, 'Delfín', 1),
(23, 6, 'Tiburón', 0),
(24, 6, 'Ballena', 0),
(25, 7, 'Radio', 0),
(26, 7, 'Fémur', 1),
(27, 7, 'Tibia', 0),
(28, 7, 'Húmero', 0),
(29, 8, 'Isaac Newton', 0),
(30, 8, 'Albert Einstein', 1),
(31, 8, 'Nikola Tesla', 0),
(32, 8, 'Galileo Galilei', 0),
(33, 9, 'Venus', 0),
(34, 9, 'Mercurio', 1),
(35, 9, 'Marte', 0),
(36, 9, 'Tierra', 0),
(37, 10, 'Eléctrica', 0),
(38, 10, 'Térmica', 0),
(39, 10, 'Solar', 1),
(40, 10, 'Eólica', 0),
(49, 13, '4', 0),
(50, 13, '5', 1),
(51, 13, '6', 0),
(52, 13, '7', 0),
(81, 21, 'Júpiter', 0),
(82, 21, 'Marte', 1),
(83, 21, 'Saturno', 0),
(84, 21, 'Neptuno', 0),
(85, 22, 'Sólido', 0),
(86, 22, 'Líquido', 0),
(87, 22, 'Gaseoso', 1),
(88, 22, 'Plasma', 0),
(93, 24, 'Oxígeno', 0),
(94, 24, 'Nitrógeno', 0),
(95, 24, 'Dióxido de carbono', 1),
(96, 24, 'Helio', 0),
(97, 25, 'Pulmón', 0),
(98, 25, 'Ojo', 1),
(99, 25, 'Riñón', 0),
(100, 25, 'Hígado', 0),
(101, 26, 'Agua', 0),
(102, 26, 'Linfa', 0),
(103, 26, 'Sangre', 1),
(104, 26, 'Jugo gástrico', 0),
(105, 27, 'Fricción', 0),
(106, 27, 'Tensión', 0),
(107, 27, 'Gravedad', 1),
(108, 27, 'Presión', 0),
(109, 28, 'La Luna', 0),
(110, 28, 'El Sol', 1),
(111, 28, 'Venus', 0),
(112, 28, 'Marte', 0),
(113, 29, 'Reptil', 0),
(114, 29, 'Anfibio', 1),
(115, 29, 'Ave', 0),
(116, 29, 'Mamífero', 0),
(117, 30, 'Estómago', 0),
(118, 30, 'Hígado', 0),
(119, 30, 'Páncreas', 0),
(120, 30, 'Riñón', 1),
(121, 31, '12', 0),
(122, 31, '6', 1),
(123, 31, '8', 0),
(124, 31, '14', 0),
(125, 32, 'Tálamo', 0),
(126, 32, 'Hipotálamo', 0),
(127, 32, 'Cerebelo', 1),
(128, 32, 'Bulbo raquídeo', 0),
(129, 33, 'Protón', 0),
(130, 33, 'Neutrón', 0),
(131, 33, 'Electrón', 1),
(132, 33, 'Quark', 0),
(133, 34, 'Ácido nucleico', 1),
(134, 34, 'Proteína', 0),
(135, 34, 'Hormona', 0),
(136, 34, 'Enzima', 0),
(137, 35, 'Nuclear', 0),
(138, 35, 'Cinética', 0),
(139, 35, 'Química', 1),
(140, 35, 'Eléctrica', 0),
(141, 36, 'Newton', 0),
(142, 36, 'Pasteur', 0),
(143, 36, 'Darwin', 1),
(144, 36, 'Curie', 0),
(145, 37, 'Condensación', 0),
(146, 37, 'Fusión', 0),
(147, 37, 'Evaporación', 1),
(148, 37, 'Solidificación', 0),
(149, 38, 'Sin núcleo definido', 1),
(150, 38, 'Con núcleo', 0),
(151, 38, 'Multicelular', 0),
(152, 38, 'Vegetal', 0),
(153, 39, 'CO₂', 0),
(154, 39, 'H₂O', 1),
(155, 39, 'O₂', 0),
(156, 39, 'CH₄', 0),
(157, 40, 'Iónico', 0),
(158, 40, 'Covalente', 1),
(159, 40, 'Metálico', 0),
(160, 40, 'Puente de hidrógeno', 0),
(161, 41, 'Hígado', 0),
(162, 41, 'Riñón', 0),
(163, 41, 'Páncreas', 1),
(164, 41, 'Estómago', 0),
(165, 42, 'Centro de control', 0),
(166, 42, 'Fábrica de proteínas', 0),
(167, 42, 'Organelo que produce energía', 1),
(168, 42, 'Receptor hormonal', 0),
(169, 43, 'So', 0),
(170, 43, 'Na', 1),
(171, 43, 'Sd', 0),
(172, 43, 'S', 0),
(173, 44, 'Estratósfera', 0),
(174, 44, 'Ozono', 1),
(175, 44, 'Troposfera', 0),
(176, 44, 'Exósfera', 0),
(177, 45, 'Sublimación', 0),
(178, 45, 'Condensación', 1),
(179, 45, 'Fusión', 0),
(180, 45, 'Evaporación', 0),
(181, 46, 'Glóbulo blanco', 0),
(182, 46, 'Glóbulo rojo', 1),
(183, 46, 'Plaqueta', 0),
(184, 46, 'Linfocito', 0),
(185, 47, 'Difracción', 0),
(186, 47, 'Reflexión', 0),
(187, 47, 'Refracción', 1),
(188, 47, 'Absorción', 0),
(189, 48, 'Potencial de hidrógeno', 1),
(190, 48, 'Peso hormonal', 0),
(191, 48, 'Potencia hidrostática', 0),
(192, 48, 'Punto de hervor', 0),
(193, 49, 'A', 0),
(194, 49, 'B12', 0),
(195, 49, 'C', 0),
(196, 49, 'D', 1),
(197, 50, 'Voltio', 0),
(198, 50, 'Newton', 0),
(199, 50, 'Julio', 1),
(200, 50, 'Pascal', 0),
(201, 51, '80', 0),
(202, 51, '90', 1),
(203, 51, '100', 0),
(204, 51, '120', 0),
(205, 52, 'Pelé', 0),
(206, 52, 'Miroslav Klose', 1),
(207, 52, 'Cristiano Ronaldo', 0),
(208, 52, 'Lionel Messi', 0),
(209, 53, 'Tokio', 0),
(210, 53, 'Londres', 0),
(211, 53, 'Río de Janeiro', 1),
(212, 53, 'Atenas', 0),
(213, 54, 'Alemania', 0),
(214, 54, 'Argentina', 0),
(215, 54, 'Brasil', 1),
(216, 54, 'Italia', 0),
(217, 55, 'Atletismo', 0),
(218, 55, 'Natación', 0),
(219, 55, 'Gimnasia', 0),
(220, 55, 'Tenis', 1),
(221, 56, 'NFL', 0),
(222, 56, 'NHL', 0),
(223, 56, 'NBA', 1),
(224, 56, 'MLB', 0),
(225, 57, 'Alemania', 0),
(226, 57, 'Italia', 0),
(227, 57, 'Francia', 1),
(228, 57, 'España', 0),
(229, 58, 'Surf', 1),
(230, 58, 'Snowboard', 0),
(231, 58, 'Skateboard', 0),
(232, 58, 'Windsurf', 0),
(233, 59, 'Motociclismo', 0),
(234, 59, 'Fórmula 1', 1),
(235, 59, 'Rally', 0),
(236, 59, 'NASCAR', 0),
(237, 60, 'El Tigre', 0),
(238, 60, 'El Pibe de Oro', 1),
(239, 60, 'El Mago', 0),
(240, 60, 'El Matador', 0),
(241, 61, 'Fútbol', 0),
(242, 61, 'Tenis', 1),
(243, 61, 'Golf', 0),
(244, 61, 'Hockey', 0),
(245, 62, 'Baloncesto', 0),
(246, 62, 'Tenis', 0),
(247, 62, 'Fútbol', 1),
(248, 62, 'Béisbol', 0),
(249, 63, 'Brasil', 0),
(250, 63, 'Alemania', 0),
(251, 63, 'Francia', 0),
(252, 63, 'Argentina', 1),
(253, 64, '10', 0),
(254, 64, '11', 1),
(255, 64, '12', 0),
(256, 64, '9', 0),
(257, 65, 'Boston', 0),
(258, 65, 'Los Ángeles', 1),
(259, 65, 'Miami', 0),
(260, 65, 'Chicago', 0),
(261, 66, 'Natación', 0),
(262, 66, 'Atletismo', 1),
(263, 66, 'Boxeo', 0),
(264, 66, 'Fútbol', 0),
(265, 67, 'Cricket', 0),
(266, 67, 'Hockey sobre hielo', 1),
(267, 67, 'Rugby', 0),
(268, 67, 'Golf', 0),
(269, 68, 'China', 0),
(270, 68, 'Japón', 1),
(271, 68, 'Corea', 0),
(272, 68, 'India', 0),
(273, 69, 'Argentina', 0),
(274, 69, 'Alemania', 1),
(275, 69, 'Francia', 0),
(276, 69, 'España', 0),
(277, 70, '2', 0),
(278, 70, '3', 1),
(279, 70, '1', 0),
(280, 70, '4', 0),
(281, 71, 'Golf', 1),
(282, 71, 'Béisbol', 0),
(283, 71, 'Rugby', 0),
(284, 71, 'Tenis', 0),
(285, 72, 'Copa del Rey', 0),
(286, 72, 'Balón de Oro', 0),
(287, 72, 'Copa FIFA', 1),
(288, 72, 'Liga de Campeones', 0),
(289, 73, 'Vóley', 1),
(290, 73, 'Rugby', 0),
(291, 73, 'Básquet', 0),
(292, 73, 'Cricket', 0),
(293, 74, 'Brasil', 0),
(294, 74, 'Argentina', 1),
(295, 74, 'Uruguay', 0),
(296, 74, 'Chile', 0),
(297, 75, 'Maradona', 0),
(298, 75, 'Riquelme', 0),
(299, 75, 'Messi', 1),
(300, 75, 'Di María', 0),
(301, 76, 'Rojo', 0),
(302, 76, 'Azul', 0),
(303, 76, 'Amarillo', 1),
(304, 76, 'Verde', 0),
(305, 77, 'Béisbol', 1),
(306, 77, 'Vóley', 0),
(307, 77, 'Rugby', 0),
(308, 77, 'Balonmano', 0),
(309, 78, 'Japón', 0),
(310, 78, 'Francia', 1),
(311, 78, 'EE. UU.', 0),
(312, 78, 'China', 0),
(313, 79, 'Atletismo', 0),
(314, 79, 'Natación', 1),
(315, 79, 'Remo', 0),
(316, 79, 'Lucha', 0),
(317, 80, 'Alemania', 0),
(318, 80, 'Italia', 0),
(319, 80, 'Brasil', 1),
(320, 80, 'Francia', 0),
(321, 81, 'Canadá', 0),
(322, 81, 'Estados Unidos', 1),
(323, 81, 'Inglaterra', 0),
(324, 81, 'España', 0),
(325, 82, 'Camp Nou', 0),
(326, 82, 'Santiago Bernabéu', 1),
(327, 82, 'Wanda Metropolitano', 0),
(328, 82, 'Old Trafford', 0),
(329, 83, '4', 0),
(330, 83, '5', 1),
(331, 83, '6', 0),
(332, 83, '3', 0),
(333, 84, 'España', 0),
(334, 84, 'Italia', 1),
(335, 84, 'Inglaterra', 0),
(336, 84, 'Francia', 0),
(337, 85, 'Hockey sobre hielo', 1),
(338, 85, 'Cricket', 0),
(339, 85, 'Rugby', 0),
(340, 85, 'Béisbol', 0),
(341, 86, 'Biatlón', 1),
(342, 86, 'Triatlón', 0),
(343, 86, 'Pentatlón', 0),
(344, 86, 'Esgrima', 0),
(345, 87, 'Barómetro', 0),
(346, 87, 'Cronómetro', 1),
(347, 87, 'Velocímetro', 0),
(348, 87, 'Altímetro', 0),
(349, 88, 'Karate', 0),
(350, 88, 'Sumo', 1),
(351, 88, 'Judo', 0),
(352, 88, 'Béisbol', 0),
(353, 89, 'Ciclismo', 1),
(354, 89, 'Atletismo', 0),
(355, 89, 'Patinaje', 0),
(356, 89, 'Esquí', 0),
(357, 90, 'Pelota', 0),
(358, 90, 'Bola de bolos', 1),
(359, 90, 'Disco', 0),
(360, 90, 'Balón', 0),
(361, 91, 'Tenis', 1),
(362, 91, 'Fútbol', 0),
(363, 91, 'Golf', 0),
(364, 91, 'Béisbol', 0),
(365, 92, '5', 1),
(366, 92, '6', 0),
(367, 92, '7', 0),
(368, 92, '4', 0),
(369, 93, 'Con la mano', 1),
(370, 93, 'Con el pie', 0),
(371, 93, 'Con la cabeza', 0),
(372, 93, 'Con el muslo', 0),
(373, 94, 'Natación', 1),
(374, 94, 'Ciclismo', 0),
(375, 94, 'Boxeo', 0),
(376, 94, 'Esgrima', 0),
(377, 95, 'Fútbol', 1),
(378, 95, 'Básquet', 0),
(379, 95, 'Tenis de mesa', 0),
(380, 95, 'Vóley', 0),
(381, 96, 'Hockey sobre hielo', 1),
(382, 96, 'Esquí', 0),
(383, 96, 'Curling', 0),
(384, 96, 'Patinaje artístico', 0),
(385, 97, 'Lionel Messi', 1),
(386, 97, 'Diego Maradona', 0),
(387, 97, 'Carlos Tevez', 0),
(388, 97, 'Ángel Di María', 0),
(389, 98, 'Triatlón', 1),
(390, 98, 'Pentatlón', 0),
(391, 98, 'Ironman', 0),
(392, 98, 'Duatlón', 0),
(393, 99, 'Bádminton', 1),
(394, 99, 'Tenis', 0),
(395, 99, 'Squash', 0),
(396, 99, 'Fútbol tenis', 0),
(397, 100, 'Oro', 1),
(398, 100, 'Plata', 0),
(399, 100, 'Bronce', 0),
(400, 100, 'Negro', 0),
(401, 101, 'Sídney', 0),
(402, 101, 'Canberra', 1),
(403, 101, 'Melbourne', 0),
(404, 101, 'Brisbane', 0),
(405, 102, 'Grecia', 0),
(406, 102, 'Italia', 1),
(407, 102, 'España', 0),
(408, 102, 'Francia', 0),
(409, 103, 'Nepal', 1),
(410, 103, 'Suiza', 0),
(411, 103, 'India', 0),
(412, 103, 'China', 0),
(413, 104, 'Amazonas', 1),
(414, 104, 'Nilo', 0),
(415, 104, 'Yangtsé', 0),
(416, 104, 'Misisipi', 0),
(417, 105, 'Estados Unidos', 0),
(418, 105, 'China', 0),
(419, 105, 'Rusia', 1),
(420, 105, 'Canadá', 0),
(421, 106, 'Asia', 0),
(422, 106, 'Europa', 0),
(423, 106, 'África', 1),
(424, 106, 'América', 0),
(425, 107, 'Noruega', 0),
(426, 107, 'Filipinas', 0),
(427, 107, 'Suecia', 1),
(428, 107, 'Indonesia', 0),
(429, 108, 'Casablanca', 0),
(430, 108, 'Rabat', 1),
(431, 108, 'Fez', 0),
(432, 108, 'Marrakech', 0),
(433, 109, 'Atlántico', 0),
(434, 109, 'Índico', 1),
(435, 109, 'Pacífico', 0),
(436, 109, 'Ártico', 0),
(437, 110, 'India', 1),
(438, 110, 'China', 0),
(439, 110, 'Estados Unidos', 0),
(440, 110, 'Indonesia', 0),
(441, 111, 'Berlín', 0),
(442, 111, 'Madrid', 0),
(443, 111, 'París', 1),
(444, 111, 'Roma', 0),
(445, 112, 'Atlántico', 0),
(446, 112, 'Índico', 1),
(447, 112, 'Pacífico', 0),
(448, 112, 'Ártico', 0),
(449, 113, 'África', 0),
(450, 113, 'Europa', 0),
(451, 113, 'Oceanía', 1),
(452, 113, 'América del Sur', 0),
(453, 114, 'México', 0),
(454, 114, 'Canadá', 1),
(455, 114, 'Australia', 0),
(456, 114, 'Japón', 0),
(457, 115, 'Londres', 0),
(458, 115, 'Berlín', 0),
(459, 115, 'París', 1),
(460, 115, 'Milán', 0),
(461, 116, 'Corea del Sur', 0),
(462, 116, 'China', 0),
(463, 116, 'Japón', 1),
(464, 116, 'Tailandia', 0),
(465, 117, 'Atacama', 0),
(466, 117, 'Kalahari', 0),
(467, 117, 'Sahara', 1),
(468, 117, 'Gobi', 0),
(469, 118, 'Mar del Norte', 0),
(470, 118, 'Mar Mediterráneo', 1),
(471, 118, 'Mar Rojo', 0),
(472, 118, 'Mar Báltico', 0),
(473, 119, 'África', 0),
(474, 119, 'Europa', 0),
(475, 119, 'América del Sur', 1),
(476, 119, 'Asia', 0),
(477, 120, 'Argentina', 0),
(478, 120, 'Brasil', 1),
(479, 120, 'Colombia', 0),
(480, 120, 'Perú', 0),
(481, 121, 'México', 0),
(482, 121, 'Canadá', 1),
(483, 121, 'Guatemala', 0),
(484, 121, 'Cuba', 0),
(485, 122, 'Galápagos', 0),
(486, 122, 'Pascua', 1),
(487, 122, 'Madagascar', 0),
(488, 122, 'Bali', 0),
(489, 123, 'Barcelona', 0),
(490, 123, 'Sevilla', 0),
(491, 123, 'Valencia', 0),
(492, 123, 'Madrid', 1),
(493, 124, 'Amazonas', 0),
(494, 124, 'Danubio', 0),
(495, 124, 'Nilo', 1),
(496, 124, 'Rin', 0),
(497, 125, 'América', 0),
(498, 125, 'Asia', 0),
(499, 125, 'África', 1),
(500, 125, 'Europa', 0),
(501, 126, 'Estados Unidos', 0),
(502, 126, 'Canadá', 1),
(503, 126, 'México', 0),
(504, 126, 'Cuba', 0),
(505, 127, 'Alpes', 0),
(506, 127, 'Andes', 1),
(507, 127, 'Himalaya', 0),
(508, 127, 'Pirineos', 0),
(509, 128, 'Austria', 0),
(510, 128, 'Alemania', 1),
(511, 128, 'Bélgica', 0),
(512, 128, 'Suiza', 0),
(513, 129, 'Español', 0),
(514, 129, 'Portugués', 1),
(515, 129, 'Francés', 0),
(516, 129, 'Inglés', 0),
(517, 130, 'Bolivia', 0),
(518, 130, 'Perú', 0),
(519, 130, 'Chile', 1),
(520, 130, 'Ecuador', 0),
(521, 131, 'Suiza', 0),
(522, 131, 'Nepal', 0),
(523, 131, 'Bután', 1),
(524, 131, 'Afganistán', 0),
(525, 132, 'Argentina', 1),
(526, 132, 'Chile', 0),
(527, 132, 'Nueva Zelanda', 0),
(528, 132, 'Australia', 0),
(529, 133, 'Lago Titicaca', 0),
(530, 133, 'Lago Ness', 0),
(531, 133, 'Lago Baikal', 1),
(532, 133, 'Lago Superior', 0),
(533, 134, 'Australia', 0),
(534, 134, 'Groenlandia', 1),
(535, 134, 'Madagascar', 0),
(536, 134, 'Borneo', 0),
(537, 135, 'Gobi', 0),
(538, 135, 'Ártico', 0),
(539, 135, 'Antártida', 1),
(540, 135, 'Kalahari', 0),
(541, 136, 'Namibia', 0),
(542, 136, 'Sudáfrica', 1),
(543, 136, 'Mozambique', 0),
(544, 136, 'Angola', 0),
(545, 137, 'Trópico de Cáncer', 0),
(546, 137, 'Trópico de Capricornio', 0),
(547, 137, 'Ecuador', 1),
(548, 137, 'Meridiano de Greenwich', 0),
(549, 138, 'Mónaco', 0),
(550, 138, 'San Marino', 0),
(551, 138, 'Ciudad del Vaticano', 1),
(552, 138, 'Liechtenstein', 0),
(553, 139, 'Rusia', 0),
(554, 139, 'China', 1),
(555, 139, 'Brasil', 0),
(556, 139, 'Alemania', 0),
(557, 140, 'Tashkent', 0),
(558, 140, 'Astana', 1),
(559, 140, 'Bakú', 0),
(560, 140, 'Dusambé', 0),
(561, 141, 'Indonesia', 1),
(562, 141, 'Japón', 0),
(563, 141, 'Islandia', 0),
(564, 141, 'Chile', 0),
(565, 142, 'Himalaya', 0),
(566, 142, 'Cáucaso', 0),
(567, 142, 'Montes Urales', 1),
(568, 142, 'Pirineos', 0),
(569, 143, 'Marruecos', 0),
(570, 143, 'Turquía', 1),
(571, 143, 'Rusia', 0),
(572, 143, 'Grecia', 0),
(573, 144, 'La Paz', 0),
(574, 144, 'Lhasa', 0),
(575, 144, 'El Alto', 1),
(576, 144, 'Quito', 0),
(577, 145, 'Amazonas', 0),
(578, 145, 'Danubio', 1),
(579, 145, 'Misisipi', 0),
(580, 145, 'Yangtsé', 0),
(581, 146, 'Bolivia', 1),
(582, 146, 'Colombia', 0),
(583, 146, 'Venezuela', 0),
(584, 146, 'Uruguay', 0),
(585, 147, 'Irán', 0),
(586, 147, 'Israel', 1),
(587, 147, 'Irak', 0),
(588, 147, 'Egipto', 0),
(589, 148, 'Pascua', 0),
(590, 148, 'Galápagos', 1),
(591, 148, 'Canarias', 0),
(592, 148, 'Maldivas', 0),
(593, 149, 'Islandia', 0),
(594, 149, 'Noruega', 1),
(595, 149, 'Escocia', 0),
(596, 149, 'Canadá', 0),
(597, 150, 'Tashkent', 0),
(598, 150, 'Ulan Bator', 1),
(599, 150, 'Biskek', 0),
(600, 150, 'Astaná', 0),
(721, 181, 'Miguel Ángel', 0),
(722, 181, 'Leonardo da Vinci', 1),
(723, 181, 'Rafael', 0),
(724, 181, 'Donatello', 0),
(725, 182, 'Cubismo', 0),
(726, 182, 'Surrealismo', 1),
(727, 182, 'Impresionismo', 0),
(728, 182, 'Expresionismo', 0),
(729, 183, 'Francia', 0),
(730, 183, 'España', 1),
(731, 183, 'Italia', 0),
(732, 183, 'Portugal', 0),
(733, 184, 'El Guernica', 0),
(734, 184, 'La Noche Estrellada', 0),
(735, 184, 'El Grito', 1),
(736, 184, 'La Última Cena', 0),
(737, 185, 'Piano', 0),
(738, 185, 'Violín', 1),
(739, 185, 'Flauta', 0),
(740, 185, 'Guitarra', 0),
(741, 186, 'Van Gogh', 1),
(742, 186, 'Monet', 0),
(743, 186, 'Dalí', 0),
(744, 186, 'Matisse', 0),
(745, 187, 'Homero', 0),
(746, 187, 'Dante Alighieri', 1),
(747, 187, 'Shakespeare', 0),
(748, 187, 'Virgilio', 0),
(749, 188, 'Calatrava', 0),
(750, 188, 'Gaudí', 1),
(751, 188, 'Gehry', 0),
(752, 188, 'Le Corbusier', 0),
(753, 189, 'Realismo', 0),
(754, 189, 'Cubismo', 0),
(755, 189, 'Romanticismo', 0),
(756, 189, 'Dinamismo', 1),
(757, 190, 'Escultura', 0),
(758, 190, 'Pintura', 1),
(759, 190, 'Grabado', 0),
(760, 190, 'Arquitectura', 0),
(761, 191, 'El Bosco', 1),
(762, 191, 'Durero', 0),
(763, 191, 'Rembrandt', 0),
(764, 191, 'Rubens', 0),
(765, 192, 'Seurat', 1),
(766, 192, 'Gauguin', 0),
(767, 192, 'Cezanne', 0),
(768, 192, 'Renoir', 0),
(769, 193, 'Capoeira', 1),
(770, 193, 'Samba', 0),
(771, 193, 'Lambada', 0),
(772, 193, 'Zouk', 0),
(773, 194, 'Una escultura con tres partes', 0),
(774, 194, 'Una pintura en tres paneles', 1),
(775, 194, 'Una técnica de grabado', 0),
(776, 194, 'Un mural circular', 0),
(777, 195, 'Warhol', 1),
(778, 195, 'Lichtenstein', 0),
(779, 195, 'Duchamp', 0),
(780, 195, 'Pollock', 0),
(781, 196, 'Fauvismo', 0),
(782, 196, 'Surrealismo', 1),
(783, 196, 'Impresionismo', 0),
(784, 196, 'Constructivismo', 0),
(785, 197, 'Obra de teatro', 0),
(786, 197, 'Composición orquestal extensa', 1),
(787, 197, 'Canción religiosa', 0),
(788, 197, 'Ballet', 0),
(789, 198, 'Litografía', 0),
(790, 198, 'Xilografía', 1),
(791, 198, 'Aguafuerte', 0),
(792, 198, 'Serigrafía', 0),
(793, 199, 'Rossini', 0),
(794, 199, 'Verdi', 1),
(795, 199, 'Puccini', 0),
(796, 199, 'Bizet', 0),
(797, 200, 'Cúpulas grandes', 0),
(798, 200, 'Columnas dóricas', 0),
(799, 200, 'Vitrales y arcos apuntados', 1),
(800, 200, 'Pintura mural', 0),
(881, 221, 'Harry Potter', 0),
(882, 221, 'Star Wars', 0),
(883, 221, 'El Señor de los Anillos', 1),
(884, 221, 'Juego de Tronos', 0),
(885, 222, 'Prince', 0),
(886, 222, 'Michael Jackson', 1),
(887, 222, 'Bruno Mars', 0),
(888, 222, 'Justin Timberlake', 0),
(889, 223, 'The Witcher', 0),
(890, 223, 'Juego de Tronos', 1),
(891, 223, 'Vikings', 0),
(892, 223, 'The Mandalorian', 0),
(893, 224, 'Batman', 0),
(894, 224, 'Superman', 0),
(895, 224, 'Iron Man', 1),
(896, 224, 'Flash', 0),
(897, 225, '1917', 0),
(898, 225, 'Joker', 0),
(899, 225, 'Parásitos', 1),
(900, 225, 'Jojo Rabbit', 0),
(901, 226, 'Brad Pitt', 0),
(902, 226, 'Leonardo DiCaprio', 1),
(903, 226, 'Tom Hanks', 0),
(904, 226, 'Matt Damon', 0),
(905, 227, 'Nirvana', 0),
(906, 227, 'Queen', 1),
(907, 227, 'The Killers', 0),
(908, 227, 'Foo Fighters', 0),
(909, 228, 'How I Met Your Mother', 0),
(910, 228, 'Friends', 0),
(911, 228, 'The Big Bang Theory', 1),
(912, 228, 'Modern Family', 0),
(913, 229, 'Enredados', 0),
(914, 229, 'Frozen', 1),
(915, 229, 'Moana', 0),
(916, 229, 'Valiente', 0),
(917, 230, 'Steven Spielberg', 0),
(918, 230, 'George Lucas', 1),
(919, 230, 'J.J. Abrams', 0),
(920, 230, 'James Cameron', 0),
(921, 231, 'Justin Timberlake', 1),
(922, 231, 'Nick Carter', 0),
(923, 231, 'Ricky Martin', 0),
(924, 231, 'Zayn Malik', 0),
(925, 232, 'Dark', 0),
(926, 232, 'Stranger Things', 1),
(927, 232, 'The 100', 0),
(928, 232, 'Black Mirror', 0),
(929, 233, 'Piano', 0),
(930, 233, 'Violín', 0),
(931, 233, 'Saxofón', 1),
(932, 233, 'Guitarra', 0),
(933, 234, 'Mad Men', 0),
(934, 234, 'The West Wing', 0),
(935, 234, 'The Sopranos', 0),
(936, 234, 'Hill Street Blues', 1),
(937, 235, 'Hans Zimmer', 1),
(938, 235, 'John Williams', 0),
(939, 235, 'Danny Elfman', 0),
(940, 235, 'Alan Silvestri', 0),
(941, 236, 'Ben-Hur', 1),
(942, 236, 'Titanic', 0),
(943, 236, 'Lo que el viento se llevó', 0),
(944, 236, 'El Señor de los Anillos', 0),
(945, 237, 'La tumba de las luciérnagas', 0),
(946, 237, 'Mi vecino Totoro', 0),
(947, 237, 'El viaje de Chihiro', 1),
(948, 237, 'Ponyo', 0),
(949, 238, 'Anthony Hopkins', 1),
(950, 238, 'Jack Nicholson', 0),
(951, 238, 'Al Pacino', 0),
(952, 238, 'Gary Oldman', 0),
(953, 239, 'Lady Gaga', 1),
(954, 239, 'Adele', 0),
(955, 239, 'Madonna', 0),
(956, 239, 'Beyoncé', 0),
(957, 240, 'Gravity', 0),
(958, 240, 'Apolo 13', 1),
(959, 240, 'Interestelar', 0),
(960, 240, 'Armageddon', 0),
(1141, 277, 'Acuarela', 0),
(1142, 277, 'Grabado', 0),
(1143, 277, 'Cerámica', 1),
(1144, 277, 'Fotografía', 0),
(1365, 342, 'Vincent van Gogh', 1),
(1366, 342, 'Pablo Picasso', 0),
(1367, 342, 'Salvador Dalí', 0),
(1368, 342, 'Claude Monet', 0),
(1369, 343, 'Violín', 0),
(1370, 343, 'Piano', 1),
(1371, 343, 'Guitarra', 0),
(1372, 343, 'Batería', 0),
(1373, 344, 'Rafael', 0),
(1374, 344, 'Leonardo da Vinci', 1),
(1375, 344, 'Miguel Ángel', 0),
(1376, 344, 'Caravaggio', 0),
(1377, 345, 'Trompeta', 0),
(1378, 345, 'Violín', 1),
(1379, 345, 'Flauta', 0),
(1380, 345, 'Tambor', 0),
(1381, 346, 'Madrid', 0),
(1382, 346, 'París', 1),
(1383, 346, 'Londres', 0),
(1384, 346, 'Roma', 0),
(1385, 347, 'Verde', 1),
(1386, 347, 'Marrón', 0),
(1387, 347, 'Naranja', 0),
(1388, 347, 'Morado', 0),
(1389, 348, 'Bella', 0),
(1390, 348, 'Moana', 0),
(1391, 348, 'Ariel', 1),
(1392, 348, 'Elsa', 0),
(1393, 349, 'Oscar Wilde', 0),
(1394, 349, 'Jane Austen', 0),
(1395, 349, 'Charles Dickens', 0),
(1396, 349, 'William Shakespeare', 1),
(1397, 350, 'Shrek', 0),
(1398, 350, 'Toy Story', 1),
(1399, 350, 'Cars', 0),
(1400, 350, 'Ratatouille', 0),
(1401, 351, 'Pluto', 0),
(1402, 351, 'Goofy', 0),
(1403, 351, 'Donald Duck', 0),
(1404, 351, 'Mickey Mouse', 1),
(1405, 352, 'Wes Anderson', 1),
(1406, 352, 'Quentin Tarantino', 0),
(1407, 352, 'Martin Scorsese', 0),
(1408, 352, 'Christopher Nolan', 0),
(1409, 353, 'The Beatles', 0),
(1410, 353, 'Pink Floyd', 1),
(1411, 353, 'Led Zeppelin', 0),
(1412, 353, 'Queen', 0),
(1413, 354, 'Steven Spielberg', 0),
(1414, 354, 'Peter Jackson', 1),
(1415, 354, 'James Cameron', 0),
(1416, 354, 'George Lucas', 0),
(1417, 355, 'Tom Hanks', 1),
(1418, 355, 'Brad Pitt', 0),
(1419, 355, 'Matt Damon', 0),
(1420, 355, 'Leonardo DiCaprio', 0),
(1421, 356, 'Michael Jackson', 1),
(1422, 356, 'Elvis Presley', 0),
(1423, 356, 'Prince', 0),
(1424, 356, 'Freddie Mercury', 0),
(1429, 358, 'Chris Hemsworth', 0),
(1430, 358, 'Robert Downey Jr.', 1),
(1431, 358, 'Chris Evans', 0),
(1432, 358, 'Mark Ruffalo', 0),
(1433, 359, 'Ryan Gosling', 1),
(1434, 359, 'Bradley Cooper', 0),
(1435, 359, 'Tom Hardy', 0),
(1436, 359, 'Jake Gyllenhaal', 0),
(1437, 360, 'El Hobbit', 0),
(1438, 360, 'Harry Potter', 1),
(1439, 360, 'Crónicas de Narnia', 0),
(1440, 360, 'Percy Jackson', 0),
(1441, 361, 'Origen', 1),
(1442, 361, 'Avatar', 0),
(1443, 361, 'Matrix', 0),
(1444, 361, 'Interstellar', 0),
(1445, 362, 'Mulholland Drive', 1),
(1446, 362, 'Eraserhead', 0),
(1447, 362, 'Blue Velvet', 0),
(1448, 362, 'Lost Highway', 0),
(1449, 363, 'Alejandro G. Iñárritu', 0),
(1450, 363, 'Alfonso Cuarón', 0),
(1451, 363, 'Guillermo del Toro', 1),
(1452, 363, 'Pedro Almodóvar', 0),
(1453, 364, 'Fantasía', 0),
(1454, 364, 'Blancanieves y los siete enanitos', 1),
(1455, 364, 'Pinocho', 0),
(1456, 364, 'Bambi', 0),
(1457, 365, 'Sean Penn', 0),
(1458, 365, 'Joaquin Phoenix', 0),
(1459, 365, 'Daniel Day-Lewis', 0),
(1460, 365, 'Philip Seymour Hoffman', 1),
(1461, 366, 'Blade Runner', 0),
(1462, 366, 'La misión', 0),
(1463, 366, 'Carros de fuego', 1),
(1464, 366, '1984', 0),
(1465, 367, 'Joker', 1),
(1466, 367, 'Parásito', 0),
(1467, 367, '1917', 0),
(1468, 367, 'Once Upon a Time in Hollywood', 0),
(1469, 368, 'The Cosby Show', 0),
(1470, 368, 'Empire', 0),
(1471, 368, 'Insecure', 0),
(1472, 368, 'The Jeffersons', 1),
(1473, 369, 'Hans Zimmer', 0),
(1474, 369, 'Wendy Carlos', 1),
(1475, 369, 'John Williams', 0),
(1476, 369, 'Ennio Morricone', 0),
(1477, 370, '1962', 0),
(1478, 370, '1955', 0),
(1479, 370, '1959', 1),
(1480, 370, '1960', 0),
(1481, 371, 'Beatrix Kiddo', 1),
(1482, 371, 'Elle Driver', 0),
(1483, 371, 'O-Ren Ishii', 0),
(1484, 371, 'Sofie Fatale', 0),
(1485, 372, 'Abraham Lincoln', 0),
(1486, 372, 'George Washington', 1),
(1487, 372, 'John Adams', 0),
(1488, 372, 'Thomas Jefferson', 0),
(1489, 373, '1945', 1),
(1490, 373, '1918', 0),
(1491, 373, '1950', 0),
(1492, 373, '1939', 0),
(1493, 374, 'Romana', 0),
(1494, 374, 'Griega', 0),
(1495, 374, 'Egipcia', 1),
(1496, 374, 'Maya', 0),
(1497, 375, 'Fernando de Magallanes', 0),
(1498, 375, 'Américo Vespucio', 0),
(1499, 375, 'Cristóbal Colón', 1),
(1500, 375, 'Marco Polo', 0),
(1501, 376, 'El Muro de Berlín', 1),
(1502, 376, 'La Muralla China', 0),
(1503, 376, 'El Muro de los Lamentos', 0),
(1504, 376, 'El Muro de Adriano', 0),
(1505, 377, 'Italia', 0),
(1506, 377, 'Francia', 0),
(1507, 377, 'Rusia', 1),
(1508, 377, 'Alemania', 0),
(1509, 378, 'Primera Guerra Mundial', 0),
(1510, 378, 'Guerras Napoleónicas', 1),
(1511, 378, 'Guerra Civil Española', 0),
(1512, 378, 'Guerra de Crimea', 0),
(1513, 379, 'La Carta Magna', 0),
(1514, 379, 'La Declaración de los Derechos del Hombre', 0),
(1515, 379, 'La Declaración de Independencia de EE.UU.', 1),
(1516, 379, 'El Tratado de Versalles', 0),
(1517, 380, 'El Imperio Griego', 0),
(1518, 380, 'El Imperio Otomano', 0),
(1519, 380, 'El Imperio Romano', 1),
(1520, 380, 'El Imperio Persa', 0),
(1521, 381, 'Pompeya', 1),
(1522, 381, 'Roma', 0),
(1523, 381, 'Atenas', 0),
(1524, 381, 'Cartago', 0),
(1525, 382, 'Hatshepsut', 0),
(1526, 382, 'Cleopatra', 1),
(1527, 382, 'Nefertiti', 0),
(1528, 382, 'Isis', 0),
(1529, 383, 'Estados Unidos', 0),
(1530, 383, 'Reino Unido', 1),
(1531, 383, 'Francia', 0),
(1532, 383, 'Alemania', 0),
(1533, 384, 'José Martí', 0),
(1534, 384, 'Simón Bolívar', 1),
(1535, 384, 'José de San Martín', 0),
(1536, 384, 'Bernardo O’Higgins', 0),
(1537, 385, 'La Guerra de Corea', 0),
(1538, 385, 'La Guerra de Independencia', 0),
(1539, 385, 'La Guerra Civil', 1),
(1540, 385, 'La Guerra de Vietnam', 0),
(1541, 386, 'Joseph Stalin', 0),
(1542, 386, 'Benito Mussolini', 0),
(1543, 386, 'Winston Churchill', 0),
(1544, 386, 'Adolf Hitler', 1),
(1545, 387, 'Austria', 0),
(1546, 387, 'Francia', 0),
(1547, 387, 'Polonia', 1),
(1548, 387, 'Rusia', 0),
(1549, 388, 'Los Toltecas', 0),
(1550, 388, 'Los Incas', 1),
(1551, 388, 'Los Mayas', 0),
(1552, 388, 'Los Aztecas', 0),
(1553, 389, 'Imperio Otomano', 0),
(1554, 389, 'Imperio Mongol', 1),
(1555, 389, 'Imperio Persa', 0),
(1556, 389, 'Imperio Bizantino', 0),
(1557, 390, 'Tratado de Tordesillas', 0),
(1558, 390, 'Tratado de París', 0),
(1559, 390, 'Tratado de Utrecht', 0),
(1560, 390, 'Tratado de Versalles', 1),
(1561, 391, 'Constantinopla', 1),
(1562, 391, 'Roma', 0),
(1563, 391, 'Atenas', 0),
(1564, 391, 'Jerusalén', 0),
(1565, 392, 'Lenin', 0),
(1566, 392, 'Trotsky', 0),
(1567, 392, 'Stalin', 1),
(1568, 392, 'Putin', 0),
(1569, 393, 'El feudalismo', 0),
(1570, 393, 'La monarquía absoluta y la desigualdad social', 1),
(1571, 393, 'La invasión de Napoleón', 0),
(1572, 393, 'El comunismo', 0),
(1573, 394, 'Guerra de Corea', 0),
(1574, 394, 'Guerra de Vietnam', 1),
(1575, 394, 'Segunda Guerra Mundial', 0),
(1576, 394, 'Guerra Civil China', 0),
(1577, 395, 'La Guerra Civil', 0),
(1578, 395, 'La Guerra de Vietnam', 0),
(1579, 395, 'La Guerra Fría', 1),
(1580, 395, 'La Guerra de Irak', 0),
(1581, 396, 'Imperio Ruso', 0),
(1582, 396, 'Imperio Francés de Napoleón', 1),
(1583, 396, 'Imperio Otomano', 0),
(1584, 396, 'Imperio Británico', 0),
(1585, 397, 'Portugal', 0),
(1586, 397, 'Francia', 0),
(1587, 397, 'Italia', 0),
(1588, 397, 'España', 1),
(1589, 398, 'Egipcia', 0),
(1590, 398, 'Sumeria', 1),
(1591, 398, 'China', 0),
(1592, 398, 'Fenicia', 0),
(1593, 399, 'Caída del Imperio Romano de Occidente', 1),
(1594, 399, 'Inicio de las Cruzadas', 0),
(1595, 399, 'Descubrimiento de América', 0),
(1596, 399, 'Reforma protestante', 0),
(1597, 400, 'Vespasiano', 1),
(1598, 400, 'Nerón', 0),
(1599, 400, 'Trajano', 0),
(1600, 400, 'César Augusto', 0),
(1601, 401, 'Segunda Guerra Mundial', 0),
(1602, 401, 'Primera Guerra Mundial', 1),
(1603, 401, 'Guerra de Vietnam', 0),
(1604, 401, 'Guerra de los Siete Años', 0),
(1605, 402, 'Coronación de Napoleón', 0),
(1606, 402, 'Caída del Muro de Berlín', 0),
(1607, 402, 'Revolución Francesa', 1),
(1608, 402, 'Inicio del Imperio Francés', 0),
(1609, 403, 'Antonio Salazar', 0),
(1610, 403, 'Benito Mussolini', 0),
(1611, 403, 'Leopoldo Galtieri', 0),
(1612, 403, 'Francisco Franco', 1),
(1613, 404, 'Revolución Francesa', 0),
(1614, 404, 'Revolución Rusa', 1),
(1615, 404, 'Revolución Industrial', 0),
(1616, 404, 'Revolución China', 0),
(1617, 405, 'China', 0),
(1618, 405, 'India', 0),
(1619, 405, 'Japón', 1),
(1620, 405, 'Corea', 0),
(1621, 406, '1853', 1),
(1622, 406, '1810', 0),
(1623, 406, '1910', 0),
(1624, 406, '1860', 0),
(1625, 407, 'Grito de Dolores', 1),
(1626, 407, 'Batalla de Puebla', 0),
(1627, 407, 'Revolución Mexicana', 0),
(1628, 407, 'Independencia de Texas', 0),
(1629, 408, 'Augusto Pinochet', 0),
(1630, 408, 'Patricio Aylwin', 0),
(1631, 408, 'Salvador Allende', 1),
(1632, 408, 'Ricardo Lagos', 0),
(1633, 409, 'Revolución Mexicana', 0),
(1634, 409, 'Movimiento Zapatista', 1),
(1635, 409, 'Guerra de Independencia', 0),
(1636, 409, 'Guerra Cristera', 0),
(1637, 410, 'Nicaragua', 1),
(1638, 410, 'Cuba', 0),
(1639, 410, 'Honduras', 0),
(1640, 410, 'Guatemala', 0),
(1641, 411, 'Revolución de Octubre', 0),
(1642, 411, 'Guerra Civil Rusa', 0),
(1643, 411, 'Golpe de Estado de Kerensky', 0),
(1644, 411, 'Revolución de Febrero', 1),
(1645, 412, 'La esclavitud', 1),
(1646, 412, 'La expansión territorial', 0),
(1647, 412, 'El poder del presidente', 0),
(1648, 412, 'Las políticas económicas', 0),
(1649, 413, 'Machiavelli', 1),
(1650, 413, 'Maquiavelo', 0),
(1651, 413, 'Dante Alighieri', 0),
(1652, 413, 'Giotto', 0),
(1653, 414, '1648', 0),
(1654, 414, '1650', 0),
(1655, 414, '1648', 1),
(1656, 414, '1635', 0),
(1657, 415, 'Constantino', 0),
(1658, 415, 'Teodosio', 0),
(1659, 415, 'Constantino', 1),
(1660, 415, 'Nerón', 0),
(1661, 416, 'Tratado de Tordesillas', 0),
(1662, 416, 'Tratado de Zaragoza', 0),
(1663, 416, 'Tratado de Tordesillas', 1),
(1664, 416, 'Tratado de París', 0),
(1665, 417, 'Código de Hammurabi', 0),
(1666, 417, 'Código Justiniano', 1),
(1667, 417, 'Código de Napoleón', 0),
(1668, 417, 'Código Romano', 0),
(1669, 418, 'Rousseau', 1),
(1670, 418, 'Voltaire', 0),
(1671, 418, 'Locke', 0),
(1672, 418, 'Montesquieu', 0),
(1673, 419, 'Conflicto dinástico entre Inglaterra y Francia', 1),
(1674, 419, 'Disputas religiosas', 0),
(1675, 419, 'Conflicto comercial', 0),
(1676, 419, 'Disputas territoriales en Alemania', 0),
(1677, 420, 'María Antonieta', 0),
(1678, 420, 'Catalina de Médici', 0),
(1679, 420, 'Ana de Austria', 0),
(1680, 420, 'Luisa de Lorena', 1),
(1681, 421, 'Tratado de Frankfurt', 0),
(1682, 421, 'Tratado de Versalles', 0),
(1683, 421, 'Tratado de Frankfurt', 1),
(1684, 421, 'Tratado de Viena', 0),
(1685, 422, 'Glóbulo blanco', 1),
(1686, 422, 'Glóbulo rojo', 0),
(1687, 422, 'Neurona', 0),
(1688, 422, 'Plaqueta', 0),
(1689, 423, 'Síntesis de proteínas', 1),
(1690, 423, 'Producción de energía', 0),
(1691, 423, 'Transporte de lípidos', 0),
(1692, 423, 'Almacenamiento de agua', 0),
(1693, 424, 'Dominancia incompleta', 0),
(1694, 424, 'Codominancia', 0),
(1695, 424, 'Segregación independiente', 1),
(1696, 424, 'Herencia ligada al sexo', 0),
(1697, 425, 'Schleiden y Schwann', 1),
(1698, 425, 'Darwin', 0),
(1699, 425, 'Pasteur', 0),
(1700, 425, 'Hooke', 0),
(1701, 426, 'Cloroplastos', 0),
(1702, 426, 'Pared celular', 0),
(1703, 426, 'Vacuola', 0),
(1704, 426, 'Centriolos', 1),
(1705, 427, 'Mitosis', 0),
(1706, 427, 'Fisión binaria', 0),
(1707, 427, 'Meiosis', 1),
(1708, 427, 'Gemación', 0),
(1709, 428, 'Clorofila', 1),
(1710, 428, 'Caroteno', 0),
(1711, 428, 'Xantofila', 0),
(1712, 428, 'Antocianina', 0),
(1713, 429, 'Covalente', 0),
(1714, 429, 'Metálico', 0),
(1715, 429, 'De hidrógeno', 0),
(1716, 429, 'Iónico', 1),
(1717, 430, 'Síntesis de lípidos', 0),
(1718, 430, 'Producción de ATP', 0),
(1719, 430, 'Modificación y empaquetamiento de proteínas', 1),
(1720, 430, 'Transporte de agua', 0),
(1721, 431, 'Neutrón', 0),
(1722, 431, 'Protón', 1),
(1723, 431, 'Electrón', 0),
(1724, 431, 'Quark', 0),
(1725, 432, 'Chelo', 0),
(1726, 432, 'Ukelele', 1),
(1727, 432, 'Violín', 0),
(1728, 432, 'Guitarra', 0),
(1729, 433, 'Verde', 0),
(1730, 433, 'Morado', 1),
(1731, 433, 'Naranja', 0),
(1732, 433, 'Rosa', 0),
(1733, 434, 'Vincent van Gogh', 0),
(1734, 434, 'Salvador Dalí', 0),
(1735, 434, 'Pablo Picasso', 1),
(1736, 434, 'Claude Monet', 0),
(1737, 435, 'Salsa', 0),
(1738, 435, 'Tango', 0),
(1739, 435, 'Ballet', 1),
(1740, 435, 'Samba', 0),
(1741, 436, 'Tela', 0),
(1742, 436, 'Mármol', 1),
(1743, 436, 'Papel', 0),
(1744, 436, 'Madera', 0),
(1745, 437, 'Piano', 1),
(1746, 437, 'Flauta', 0),
(1747, 437, 'Violín', 0),
(1748, 437, 'Batería', 0),
(1749, 438, 'Cubismo', 1),
(1750, 438, 'Renacimiento', 0),
(1751, 438, 'Romanticismo', 0),
(1752, 438, 'Barroco', 0),
(1753, 439, 'Roma', 0),
(1754, 439, 'París', 1),
(1755, 439, 'Nueva York', 0),
(1756, 439, 'Londres', 0),
(1757, 440, 'Claude Monet', 0),
(1758, 440, 'Salvador Dalí', 0),
(1759, 440, 'Pablo Picasso', 0),
(1760, 440, 'Vincent van Gogh', 1),
(1761, 441, 'Postimpresionismo', 1),
(1762, 441, 'Expresionismo', 0),
(1763, 441, 'Cubismo', 0),
(1764, 441, 'Barroco', 0),
(1765, 442, 'Pablo Picasso', 1),
(1766, 442, 'Joan Miró', 0),
(1767, 442, 'Salvador Dalí', 0),
(1768, 442, 'Francisco de Goya', 0),
(1769, 443, 'Juan Gelman', 1),
(1770, 443, 'Jorge Luis Borges', 0),
(1771, 443, 'Julio Cortázar', 0),
(1772, 443, 'Ricardo Piglia', 0),
(1773, 444, 'El Juicio Final', 1),
(1774, 444, 'La Última Cena', 0),
(1775, 444, 'La Escuela de Atenas', 0),
(1776, 444, 'La Creación de Eva', 0),
(1777, 445, 'Piotr Ilich Tchaikovsky', 1),
(1778, 445, 'Ludwig van Beethoven', 0),
(1779, 445, 'Johann Strauss', 0),
(1780, 445, 'Franz Schubert', 0),
(1781, 446, 'Surrealismo', 1),
(1782, 446, 'Impresionismo', 0),
(1783, 446, 'Futurismo', 0),
(1784, 446, 'Romanticismo', 0),
(1785, 447, 'Austriaca', 1),
(1786, 447, 'Alemana', 0),
(1787, 447, 'Suiza', 0),
(1788, 447, 'Danesa', 0),
(1789, 448, 'Siglo XVI - XVII', 1),
(1790, 448, 'Siglo XV', 0),
(1791, 448, 'Siglo XVIII', 0),
(1792, 448, 'Siglo XIV', 0),
(1793, 449, 'Mármol', 1),
(1794, 449, 'Hierro', 0),
(1795, 449, 'Bronce fundido', 0),
(1796, 449, 'Arcilla cocida', 0),
(1797, 450, 'Don Quijote de la Mancha', 1),
(1798, 450, 'Cien años de soledad', 0),
(1799, 450, 'La Celestina', 0),
(1800, 450, 'El Lazarillo de Tormes', 0),
(1801, 451, 'Diego Rivera', 1),
(1802, 451, 'Frida Kahlo', 0),
(1803, 451, 'José Clemente Orozco', 0),
(1804, 451, 'David Alfaro Siqueiros', 0),
(1805, 452, 'Maurice Ravel', 1),
(1806, 452, 'Claude Debussy', 0),
(1807, 452, 'Erik Satie', 0),
(1808, 452, 'Camille Saint-Saëns', 0),
(1809, 453, 'Rechazar la lógica y el arte tradicional', 1),
(1810, 453, 'Promover la belleza clásica', 0),
(1811, 453, 'Representar emociones intensas', 0),
(1812, 453, 'Difundir el simbolismo religioso', 0),
(1813, 454, 'Miguel Ángel', 1),
(1814, 454, 'Donatello', 0),
(1815, 454, 'Bernini', 0),
(1816, 454, 'Brunelleschi', 0),
(1817, 455, 'Samuel Beckett', 1),
(1818, 455, 'Harold Pinter', 0),
(1819, 455, 'Tennessee Williams', 0),
(1820, 455, 'Eugene Ionesco', 0),
(1821, 456, 'Platón', 1),
(1822, 456, 'Sócrates', 0),
(1823, 456, 'Aristóteles', 0),
(1824, 456, 'Heráclito', 0),
(1825, 457, 'Pop Art', 1),
(1826, 457, 'Cubismo', 0),
(1827, 457, 'Constructivismo', 0),
(1828, 457, 'Art Nouveau', 0),
(1829, 458, 'Gótico', 1),
(1830, 458, 'Románico', 0),
(1831, 458, 'Renacentista', 0),
(1832, 458, 'Barroco', 0),
(1833, 459, 'Pablo Neruda', 1),
(1834, 459, 'Gabriela Mistral', 0),
(1835, 459, 'Vicente Huidobro', 0),
(1836, 459, 'Nicanor Parra', 0),
(1837, 460, 'Esperando a Godot', 1),
(1838, 460, 'La cantante calva', 0),
(1839, 460, 'Un tranvía llamado deseo', 0),
(1840, 460, 'Muerte de un viajante', 0),
(1841, 461, 'Insectos', 0),
(1842, 461, 'Animales pequeños', 0),
(1843, 461, 'Las respuestas 1 y 2 son correctas', 1),
(1844, 461, 'Víboras', 0),
(1845, 462, 'Argentina', 0),
(1846, 462, 'Brasil', 0),
(1847, 462, 'Japón', 0),
(1848, 462, 'Alemania', 1),
(1849, 463, 'Diego Maradona', 0),
(1850, 463, 'Lionel Messi', 1),
(1851, 463, 'Cristiano Ronaldo', 0),
(1852, 463, 'Ronaldinho', 0),
(1853, 464, 'aaaa', 0),
(1854, 464, 'aaa', 0),
(1855, 464, 'aaa22', 1),
(1856, 464, 'a', 0),
(1857, 465, '11', 0),
(1858, 465, '1', 1),
(1859, 465, '22', 0),
(1860, 465, '33', 0),
(1861, 468, 'aaaa', 0),
(1862, 468, 'aaa', 0),
(1863, 468, 'a', 1),
(1864, 468, 'aa', 0),
(1865, 469, 'aa', 0),
(1866, 469, '2', 0),
(1867, 469, 'a', 1),
(1868, 469, '4', 0),
(1869, 470, '213412', 1),
(1870, 470, '555', 0),
(1871, 470, '55566', 0),
(1872, 470, '666', 0),
(1873, 471, '213412', 1),
(1874, 471, '555', 0),
(1875, 471, '55566', 0),
(1876, 471, '666', 0),
(1877, 472, 'sssss', 1),
(1878, 472, 'sss', 0),
(1879, 472, 'ddd', 0),
(1880, 472, 'ffff', 0),
(1881, 473, '156415', 0),
(1882, 473, '232', 0),
(1883, 473, '165', 1),
(1884, 473, '61', 0),
(1885, 474, 'd21312', 0),
(1886, 474, '312312', 0),
(1887, 474, '5', 1),
(1888, 474, '66', 0),
(1889, 475, '222', 0),
(1890, 475, '333', 0),
(1891, 475, '444', 0),
(1892, 475, '555', 1),
(1893, 476, '11111', 0),
(1894, 476, '1111', 0),
(1895, 476, '222', 1),
(1896, 476, '2333', 0),
(1897, 477, 'aa556', 1),
(1898, 477, '6677', 0),
(1899, 477, '778', 0),
(1900, 477, '888', 0),
(1901, 478, 'aaa', 0),
(1902, 478, 'aaaa', 0),
(1903, 478, 'sss', 1),
(1904, 478, 'ssss', 0),
(1905, 480, 'Stranger Things', 1),
(1906, 480, 'Breaking Bad', 0),
(1907, 480, 'The Walking Dead', 0),
(1908, 480, 'The Witcher', 0),
(1909, 483, 'Drako', 0),
(1910, 483, 'Ron', 1),
(1911, 483, 'Severus', 0),
(1912, 483, 'Sirius', 0),
(1913, 484, 'Crucio', 0),
(1914, 484, 'Expelliarmus', 0),
(1915, 484, 'Expecto Patronum', 0),
(1916, 484, 'Avada Kedavra', 1),
(1917, 485, 'Crucio', 0),
(1918, 485, 'Expelliarmus', 0),
(1919, 485, 'Expecto Patronum', 0),
(1920, 485, 'Avada Kedavra', 1),
(1921, 486, 'Crucio', 0),
(1922, 486, 'Expelliarmus', 0),
(1923, 486, 'Expecto Patronum', 0),
(1924, 486, 'Avada Kedavra', 1),
(1925, 487, 'China', 0),
(1926, 487, 'Japon', 0),
(1927, 487, 'Corea', 1),
(1928, 487, 'Filipinas', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `respuesta_solicitada`
--

CREATE TABLE `respuesta_solicitada` (
  `id` int(11) NOT NULL,
  `id_pregunta` int(11) NOT NULL,
  `texto` varchar(255) NOT NULL,
  `es_correcta` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `respuesta_solicitada`
--

INSERT INTO `respuesta_solicitada` (`id`, `id_pregunta`, `texto`, `es_correcta`) VALUES
(98, 26, '13', 0),
(99, 26, '4', 0),
(100, 26, '6', 1),
(101, 26, '2', 0),
(102, 27, 'Madera', 0),
(103, 27, 'Goma', 0),
(104, 27, 'Papel', 0),
(105, 27, 'Cuero', 1),
(106, 28, 'Procariota', 0),
(107, 28, 'Eucariota', 0),
(108, 28, 'Monocariota', 1),
(109, 28, 'Todas las anteriores existen', 0),
(110, 29, 'Rolling Stones', 0),
(111, 29, 'AC/DC', 1),
(112, 29, 'Led Zeppelin', 0),
(113, 29, 'Black Sabbath', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sexo`
--

CREATE TABLE `sexo` (
  `id_sexo` int(11) NOT NULL,
  `descripcion` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `sexo`
--

INSERT INTO `sexo` (`id_sexo`, `descripcion`) VALUES
(1, 'Femenino'),
(2, 'Masculino'),
(3, 'No contesta');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_usuario`
--

CREATE TABLE `tipo_usuario` (
  `id` int(10) NOT NULL,
  `nombre` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tipo_usuario`
--

INSERT INTO `tipo_usuario` (`id`, `nombre`) VALUES
(1, 'jugador'),
(2, 'editor'),
(3, 'administrador');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `id_usuario` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `apellido` varchar(100) NOT NULL,
  `anio_nacimiento` year(4) NOT NULL,
  `id_sexo` int(11) DEFAULT NULL,
  `email` varchar(150) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nombre_usuario` varchar(50) NOT NULL,
  `foto_perfil` varchar(255) DEFAULT NULL,
  `preguntas_recibidas` int(11) DEFAULT 0,
  `preguntas_acertadas` int(11) DEFAULT 0,
  `id_tipo` int(11) DEFAULT NULL,
  `fecha_registro` datetime NOT NULL DEFAULT current_timestamp(),
  `token` int(11) NOT NULL,
  `es_valido` tinyint(1) NOT NULL,
  `latitud` decimal(10,8) DEFAULT NULL,
  `longitud` decimal(11,8) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id_usuario`, `nombre`, `apellido`, `anio_nacimiento`, `id_sexo`, `email`, `password`, `nombre_usuario`, `foto_perfil`, `preguntas_recibidas`, `preguntas_acertadas`, `id_tipo`, `fecha_registro`, `token`, `es_valido`, `latitud`, `longitud`) VALUES
(1, 'Usuario', 'Usuario', '2000', 3, 'usuario@gmail.com', '$2y$10$kV4qh27UFOLq1bO0MrUJm.T54ENvsWU6.lwG2vZyOZ.siWyHCKoh6', 'usuario1', 'usuario1_1748618131.png', 118, 87, 1, '2025-04-01 09:00:00', 0, 1, -35.00000000, -64.00000000),
(2, 'Matías', 'Fernández', '1993', 2, 'matias.fernandez@example.com', '$2b$12$vqzBDPgL6IPvyLlZQEPjL.K7vQDscnvKBZLleDz7jojJa5Mi37fSC', 'matefan', NULL, 0, 0, 1, '2025-05-02 10:15:00', 0, 0, -34.60370000, -58.38160000),
(7, 'Lucía', 'Martínez', '1998', 1, 'lucia.martinez@example.com', '$2b$12$Gsurp6ym/.N3LvZ2/GNHLe3fdN2OsX7WZ.rBRB0RJ3Q4ZtzBtfdp6', 'lucia98', NULL, 8, 4, 1, '2025-05-02 11:30:00', 0, 0, -31.42010000, -64.18880000),
(8, 'Tomás', 'Gómez', '2001', 2, 'tomas.gomez@example.com', '$2b$12$q62pq.RF3NRVMWO/4/WvOugp6enr89thrAd.Od2ZieYAOOJvJG.n.', 'tomi2001', NULL, 10, 6, 1, '2025-05-04 12:45:00', 0, 0, -32.94420000, -60.65050000),
(9, 'Julieta', 'Rodríguez', '1995', 1, 'julieta.rod@example.com', '$2b$12$rOcX/YSw1vJ4Yw.kW4Nq8Ool.5WazBchu3LpijnQD4.rzqcu2xrNO', 'julirod', NULL, 35, 14, 1, '2025-05-10 14:00:00', 0, 0, -24.78210000, -65.42320000),
(10, 'Mariano', 'Fernández', '2010', 3, 'mariano.fer@example.com', '$2b$12$vOX9/4bSg9MjbJKjwT/2KeBu5xz625bC.meysTeQs7QXNeBmV61QW', 'marifer99', NULL, 15, 9, 1, '2025-06-20 20:15:00', 0, 0, -38.00550000, -62.27000000),
(11, 'Carla', 'Pérez', '2002', 1, 'carla.perez@example.com', '$2b$12$HYi2IP.FFTSkkWS.wRAitOOm4guMbcL1G.wmZbf4RhqZaDtEoIw4m', 'carli02', NULL, 25, 12, 1, '2025-06-06 15:15:00', 0, 0, -27.46060000, -58.57440000),
(12, 'Nicolás', 'Suárez', '1997', 2, 'nicolas.suarez@example.com', '$2b$12$WmaYySG9a3OAxbW2cqKcRe6dlus8M3MpoVxRQ4KIzE46ne1xUDxMq', 'nicos', NULL, 3, 1, 1, '2025-06-15 16:30:00', 0, 0, -31.53750000, -65.21760000),
(13, 'Agustina', 'López', '2000', 1, 'agustina.lopez@example.com', '$2b$12$36U7oxtAUoKPWiAFPeXbvu/x7wnMDm4.ElLT0497PNsBt0FyVdqQm', 'agus00', NULL, 0, 0, 1, '2025-06-29 17:22:29', 0, 0, -26.82410000, -65.22260000),
(14, 'Sofía', 'Ruiz', '1940', 1, 'sofia.ruiz@example.com', '$2b$12$Vjlf8TLic5UUov1aICkyw.lgxDiC5pNdMv779Fyx7va47Q1pEMe.2', 'sofiruiz', NULL, 0, 0, 1, '2025-06-15 19:00:00', 0, 0, -33.29500000, -68.34520000),
(15, 'Federico', 'Cabrera', '1994', 2, 'fede.cabrera@example.com', '$2b$12$ks.eaIhZmZXX5Duvy.NLPeMTEztVC49Hx4/h4lrQNCdsxZOPt3NTq', 'fede94', NULL, 0, 0, 1, '2025-06-29 17:22:29', 0, 0, -29.41310000, -66.85580000),
(17, 'rocio', 'gonzales', '2000', 3, 'ro123@gmail.com', '$2y$10$YNsOf.343fz2A6qpv8Q4X.z/g9q6gNGYyCkZDxlZbMR5oaXUG9R6i', 'roo12', NULL, 0, 0, 1, '2025-06-29 17:22:29', 0, 0, -34.92140000, -57.95440000),
(100, 'Juan', 'Perez', '1990', 2, 'juancito@gmail.com', '$2y$10$eOURax3ZVLt1uZrhgoJOt.guEVHYsPMv0f6xUpHmLi7ZcIBGPepiq', 'juan', NULL, 0, 0, 2, '2025-06-29 17:22:29', 0, 1, -37.32570000, -57.95450000),
(101, 'facu', 'vare', '1998', 2, 'facu@unlam.com', '$2y$10$/bIQmTnOmrpsSssIBy2uW.uYIu6uYVCY7lfQUb7v/97REJPa7s0fC', 'facu1', NULL, 6, 0, 1, '2025-06-29 17:22:29', 0, 0, -28.46960000, -59.00460000),
(102, 'María', 'Gómez', '1990', 1, 'maria.gomez@example.com', '$2y$10$o9bj4ZQ3o4HyYoFzEmuPLe5JfWIk3lwdmNgNLld9MMqLcHHrMZq3i', 'maria', NULL, 0, 0, 3, '2025-06-29 17:22:29', 0, 1, -30.94460000, -60.65250000),
(103, 'Carlos', 'Dominguez', '1980', 2, 'carlos14@gmail.com', '$2y$10$57AvsZ7Xvp9UIJpLCTU5relLEtL6T4KR0N4s8sLEseqzkrZyiFLOC', 'carlos', NULL, 0, 0, 1, '2025-06-29 17:22:29', 0, 0, -26.40750000, -65.71880000),
(104, 'Martina', 'Gomez', '2002', 1, 'mar10@gmail.com', '$2y$10$nKl6r/Sm9Uvb3/yoLLpIJOciJlUXQkK12c8uDvEAusA2zvQqwSKo.', 'maaar', NULL, 0, 0, 1, '2025-06-29 17:22:29', 0, 0, -34.72650000, -59.10710000),
(118, 'sdfa', 'Di Nubila', '2000', 2, 'robertosabia01@gmail.com', '$2y$10$Mylp8/c4UzIK0rgu0PXHkOqySVJnAeQm8UjniYFtZ2pV4HrzX0yjG', 'RobertoSabia', NULL, 0, 0, 1, '2025-07-01 23:48:24', 0, 1, -27.79510000, -60.98140000),
(121, 'Laura', 'Gonzalez', '1990', 1, 'lauritagonzalez12331@gmail.com', '$2y$10$xmhZARWT5Ib7YGGvMfXlX.slrQs9t9WNArXhzd4ee6tujgmuFhEvK', 'Laurita', NULL, 51, 11, 1, '2025-07-04 14:53:54', 0, 1, -34.82550196, -58.39318693);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categoria`
--
ALTER TABLE `categoria`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `dificultad`
--
ALTER TABLE `dificultad`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `historial_moderacion`
--
ALTER TABLE `historial_moderacion`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_categoria_pregunta` (`categoria_pregunta`);

--
-- Indices de la tabla `partida`
--
ALTER TABLE `partida`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_jugador` (`id_jugador`);

--
-- Indices de la tabla `partida_pregunta`
--
ALTER TABLE `partida_pregunta`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_partida` (`id_partida`),
  ADD KEY `id_pregunta` (`id_pregunta`);

--
-- Indices de la tabla `pregunta`
--
ALTER TABLE `pregunta`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_pregunta_dificultad` (`id_dificultad`);

--
-- Indices de la tabla `pregunta_reportada`
--
ALTER TABLE `pregunta_reportada`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idReporteMotivo` (`idReporteMotivo`);

--
-- Indices de la tabla `pregunta_solicitada`
--
ALTER TABLE `pregunta_solicitada`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_categoria` (`id_categoria`);

--
-- Indices de la tabla `pregunta_usuario`
--
ALTER TABLE `pregunta_usuario`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idusuario` (`idusuario`),
  ADD KEY `idpregunta` (`idpregunta`),
  ADD KEY `id_respuesta_elegida` (`id_respuesta_elegida`);

--
-- Indices de la tabla `reporte_motivo`
--
ALTER TABLE `reporte_motivo`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `respuesta`
--
ALTER TABLE `respuesta`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `respuesta_solicitada`
--
ALTER TABLE `respuesta_solicitada`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_pregunta` (`id_pregunta`);

--
-- Indices de la tabla `sexo`
--
ALTER TABLE `sexo`
  ADD PRIMARY KEY (`id_sexo`);

--
-- Indices de la tabla `tipo_usuario`
--
ALTER TABLE `tipo_usuario`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id_usuario`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `nombre_usuario` (`nombre_usuario`),
  ADD KEY `id_sexo` (`id_sexo`),
  ADD KEY `fk_usuario_tipo` (`id_tipo`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categoria`
--
ALTER TABLE `categoria`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `dificultad`
--
ALTER TABLE `dificultad`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `historial_moderacion`
--
ALTER TABLE `historial_moderacion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=76;

--
-- AUTO_INCREMENT de la tabla `partida`
--
ALTER TABLE `partida`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=240;

--
-- AUTO_INCREMENT de la tabla `partida_pregunta`
--
ALTER TABLE `partida_pregunta`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=449;

--
-- AUTO_INCREMENT de la tabla `pregunta`
--
ALTER TABLE `pregunta`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=489;

--
-- AUTO_INCREMENT de la tabla `pregunta_reportada`
--
ALTER TABLE `pregunta_reportada`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT de la tabla `pregunta_solicitada`
--
ALTER TABLE `pregunta_solicitada`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT de la tabla `pregunta_usuario`
--
ALTER TABLE `pregunta_usuario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=265;

--
-- AUTO_INCREMENT de la tabla `reporte_motivo`
--
ALTER TABLE `reporte_motivo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `respuesta`
--
ALTER TABLE `respuesta`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1929;

--
-- AUTO_INCREMENT de la tabla `respuesta_solicitada`
--
ALTER TABLE `respuesta_solicitada`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=114;

--
-- AUTO_INCREMENT de la tabla `sexo`
--
ALTER TABLE `sexo`
  MODIFY `id_sexo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `tipo_usuario`
--
ALTER TABLE `tipo_usuario`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=122;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `historial_moderacion`
--
ALTER TABLE `historial_moderacion`
  ADD CONSTRAINT `fk_categoria_pregunta` FOREIGN KEY (`categoria_pregunta`) REFERENCES `categoria` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Filtros para la tabla `partida`
--
ALTER TABLE `partida`
  ADD CONSTRAINT `partida_ibfk_1` FOREIGN KEY (`id_jugador`) REFERENCES `usuario` (`id_usuario`);

--
-- Filtros para la tabla `partida_pregunta`
--
ALTER TABLE `partida_pregunta`
  ADD CONSTRAINT `partida_pregunta_ibfk_1` FOREIGN KEY (`id_partida`) REFERENCES `partida` (`id`),
  ADD CONSTRAINT `partida_pregunta_ibfk_2` FOREIGN KEY (`id_pregunta`) REFERENCES `pregunta` (`id`);

--
-- Filtros para la tabla `pregunta`
--
ALTER TABLE `pregunta`
  ADD CONSTRAINT `fk_pregunta_dificultad` FOREIGN KEY (`id_dificultad`) REFERENCES `dificultad` (`id`);

--
-- Filtros para la tabla `pregunta_solicitada`
--
ALTER TABLE `pregunta_solicitada`
  ADD CONSTRAINT `pregunta_solicitada_ibfk_1` FOREIGN KEY (`id_categoria`) REFERENCES `categoria` (`id`);

--
-- Filtros para la tabla `pregunta_usuario`
--
ALTER TABLE `pregunta_usuario`
  ADD CONSTRAINT `pregunta_usuario_ibfk_1` FOREIGN KEY (`idusuario`) REFERENCES `usuario` (`id_usuario`),
  ADD CONSTRAINT `pregunta_usuario_ibfk_2` FOREIGN KEY (`idpregunta`) REFERENCES `pregunta` (`id`),
  ADD CONSTRAINT `pregunta_usuario_ibfk_3` FOREIGN KEY (`id_respuesta_elegida`) REFERENCES `respuesta` (`id`);

--
-- Filtros para la tabla `respuesta_solicitada`
--
ALTER TABLE `respuesta_solicitada`
  ADD CONSTRAINT `respuesta_solicitada_ibfk_1` FOREIGN KEY (`id_pregunta`) REFERENCES `pregunta_solicitada` (`id`);

--
-- Filtros para la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `fk_usuario_tipo` FOREIGN KEY (`id_tipo`) REFERENCES `tipo_usuario` (`id`),
  ADD CONSTRAINT `usuario_ibfk_1` FOREIGN KEY (`id_sexo`) REFERENCES `sexo` (`id_sexo`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
