-- phpMyAdmin SQL Dump
-- version 3.1.1
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 12-11-2012 a las 12:12:34
-- Versión del servidor: 5.1.30
-- Versión de PHP: 5.2.8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Base de datos: `codeigniter`
--
CREATE DATABASE `codeigniter` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `codeigniter`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ci_sessions`
--

CREATE TABLE IF NOT EXISTS `ci_sessions` (
  `session_id` varchar(40) NOT NULL DEFAULT '0',
  `ip_address` varchar(45) NOT NULL DEFAULT '0',
  `user_agent` varchar(120) NOT NULL,
  `last_activity` int(10) unsigned NOT NULL DEFAULT '0',
  `user_data` text NOT NULL,
  PRIMARY KEY (`session_id`),
  KEY `last_activity_idx` (`last_activity`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Volcar la base de datos para la tabla `ci_sessions`
--

--
-- Estructura de tabla para la tabla `privilegios`
--

CREATE TABLE IF NOT EXISTS `privilegios` (
  `id_privilegio` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `id_padre` int(10) unsigned NOT NULL,
  `mostrar_menu` tinyint(1) NOT NULL DEFAULT '1',
  `url_accion` varchar(100) NOT NULL,
  `url_icono` varchar(100) NOT NULL,
  `target_blank` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_privilegio`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Volcar la base de datos para la tabla `privilegios`
--

INSERT INTO `privilegios` (`id_privilegio`, `nombre`, `id_padre`, `mostrar_menu`, `url_accion`, `url_icono`, `target_blank`) VALUES
(1, 'Privilegios', 0, 1, 'privilegios/', 'lock', 0),
(2, 'Agregar', 1, 1, 'privilegios/agregar/', 'plus', 0),
(3, 'Eliminar', 1, 0, 'privilegios/eliminar/', 'remove', 0),
(4, 'Modificar', 1, 0, 'privilegios/modificar/', 'edit', 0),
(5, 'Usuarios', 0, 1, 'usuarios/', 'user', 0),
(6, 'Agregar', 5, 1, 'usuarios/agregar/', 'plus', 0),
(7, 'Modificar', 5, 0, 'usuarios/modificar/', 'edit', 0),
(8, 'Eliminar', 5, 0, 'usuarios/eliminar/', 'remove', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE IF NOT EXISTS `usuarios` (
  `id_usuario` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(110) NOT NULL,
  `email` varchar(70) NOT NULL,
  `pass` varchar(35) NOT NULL,
  `fecha_registro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `tipo` enum('admin','usuario') NOT NULL DEFAULT 'usuario',
  `facebook_user_id` varchar(100) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1:activo, 0:eliminado',
  PRIMARY KEY (`id_usuario`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Volcar la base de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `nombre`, `email`, `pass`, `fecha_registro`, `tipo`, `facebook_user_id`, `status`) VALUES
(1, 'Admin', 'admin', '12345', '2012-11-07 21:56:37', 'admin', NULL, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios_privilegios`
--

CREATE TABLE IF NOT EXISTS `usuarios_privilegios` (
  `id_usuario` bigint(20) unsigned NOT NULL,
  `id_privilegio` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id_usuario`,`id_privilegio`),
  KEY `id_privilegio` (`id_privilegio`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcar la base de datos para la tabla `usuarios_privilegios`
--

INSERT INTO `usuarios_privilegios` (`id_usuario`, `id_privilegio`) VALUES
(1, 1),
(1, 2),
(1, 3),
(1, 4),
(1, 5),
(1, 6),
(1, 7),
(1, 8);

--
-- Filtros para las tablas descargadas (dump)
--

--
-- Filtros para la tabla `usuarios_privilegios`
--
ALTER TABLE `usuarios_privilegios`
  ADD CONSTRAINT `usuarios_privilegios_ibfk_2` FOREIGN KEY (`id_privilegio`) REFERENCES `privilegios` (`id_privilegio`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `usuarios_privilegios_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`) ON DELETE CASCADE ON UPDATE CASCADE;
