-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 06-11-2021 a las 17:58:25
-- Versión del servidor: 10.4.18-MariaDB
-- Versión de PHP: 8.0.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `private_server`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `files`
--

CREATE TABLE `files` (
  `id` int(60) NOT NULL,
  `fld` varchar(50) NOT NULL,
  `url` varchar(300) NOT NULL,
  `name` varchar(60) NOT NULL,
  `state` varchar(60) NOT NULL,
  `extension` varchar(30) NOT NULL,
  `id_user` int(30) NOT NULL,
  `token_user` varchar(50) NOT NULL,
  `cid` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `files`
--

INSERT INTO `files` (`id`, `fld`, `url`, `name`, `state`, `extension`, `id_user`, `token_user`, `cid`) VALUES
(1, 'root', '../files/private/014cf62136dc51532ad064e9c029e302/root/horario.jpeg', 'horario.jpeg', 'normal', 'jpeg', 1, '014cf62136dc51532ad064e9c029e302', '5d519008fa52f828921c51eb445f8d02');


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `folders`
--

CREATE TABLE `folders` (
  `id` int(30) NOT NULL,
  `fld` varchar(50) NOT NULL,
  `url` varchar(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `id_user` int(50) NOT NULL,
  `token_user` varchar(50) NOT NULL,
  `cid` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `folders`
--

INSERT INTO `folders` (`id`, `fld`, `url`, `name`, `id_user`, `token_user`, `cid`) VALUES
(1, 'root', 'files/private/014cf62136dc51532ad064e9c029e302/root', 'root', 1, '014cf62136dc51532ad064e9c029e302', 'root');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(15) NOT NULL,
  `usuario` varchar(60) CHARACTER SET utf8 NOT NULL,
  `password` varchar(130) CHARACTER SET utf8 NOT NULL,
  `nombre` varchar(100) CHARACTER SET utf8 NOT NULL,
  `correo` varchar(80) CHARACTER SET utf8 NOT NULL,
  `last_session` datetime DEFAULT NULL,
  `activacion` int(11) NOT NULL DEFAULT 0,
  `token` varchar(40) CHARACTER SET utf8 NOT NULL,
  `token_password` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `password_request` int(11) DEFAULT 0,
  `id_tipo` int(11) NOT NULL,
  `imagen` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `usuario`, `password`, `nombre`, `correo`, `last_session`, `activacion`, `token`, `token_password`, `password_request`, `id_tipo`, `imagen`) VALUES
(1, 'admin', '$2y$10$8efv5XBgdU6Es9E04YbqfeywQ/0k6oDiE21fGe/.r3phurpki8Rv.', 'admin', 'admin@gmail.com', '2021-08-21 21:42:47', 1, '014cf62136dc51532ad064e9c029e302', '', 0, 1, 'user/images/default/user.png');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `files`
--
ALTER TABLE `files`
  ADD PRIMARY KEY (`id`);

--  
-- Indices de la tabla `folders`
--
ALTER TABLE `folders`
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
-- AUTO_INCREMENT de la tabla `files`
--
ALTER TABLE `files`
  MODIFY `id` int(60) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `folders`
--
ALTER TABLE `folders`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(15) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;