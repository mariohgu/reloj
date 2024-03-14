-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 02-02-2024 a las 15:50:36
-- Versión del servidor: 10.6.16-MariaDB-cll-lve
-- Versión de PHP: 8.1.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "-05:00";


--
-- Base de datos: `reloj`



-- Estructura de tabla para la tabla `persona`
CREATE TABLE IF NOT EXISTS `persona` (
  `idpersona` int(11) NOT NULL AUTO_INCREMENT,
  `codigo_interno` int(4) DEFAULT NULL,
  `tipo_persona` varchar(20) NOT NULL,
  `nombre` varchar(200) NOT NULL,
  `tipo_documento` varchar(20) DEFAULT NULL,
  `num_documento` varchar(20) DEFAULT NULL,
  `direccion` varchar(70) DEFAULT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `fecha_nac` date DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`idpersona`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Estructura de tabla para la tabla `usuario`
CREATE TABLE IF NOT EXISTS `usuario` (
  `idusuario` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(200) NOT NULL,
  `tipo_documento` varchar(20) NOT NULL,
  `num_documento` varchar(20) NOT NULL,
  `direccion` varchar(230) DEFAULT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `fecha_nac` date DEFAULT NULL,
  `cargo` varchar(20) DEFAULT NULL,
  `login` varchar(20) NOT NULL,
  `clave` varchar(255) NOT NULL, -- Aumentado para permitir almacenar hashes de contraseñas
  `imagen` varchar(255) DEFAULT NULL, -- Cambiado a DEFAULT NULL por si no se proporciona imagen
  `condicion` tinyint(1) NOT NULL DEFAULT 1, -- Cambiado a tinyint(1) para representar booleano
  PRIMARY KEY (`idusuario`),
  UNIQUE KEY `login_UNIQUE` (`login`) -- Asegurar que el login sea único
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcado de datos para la tabla `usuario`
-- INSERT INTO `usuario` (`idusuario`, `nombre`, `tipo_documento`, `num_documento`, `direccion`, `telefono`, `email`, `cargo`, `login`, `clave`, `condicion`, `imagen`) VALUES (...);

INSERT INTO `usuario` (`idusuario`, `nombre`, `tipo_documento`, `num_documento`, `direccion`, `telefono`, `email`, `cargo`, `login`, `clave`, `condicion`, `imagen`) VALUES
(1, 'Mario', 'DNI', '322323323', '', '', '', '', 'mario', '$2y$10$plR/CGhUSVRRujAgy6jmNO1gxBE4zHxFGBora1drZLsJ5fFnsWVja', 1, '');

-- Estructura de tabla para la tabla `permiso`
CREATE TABLE IF NOT EXISTS `permiso` (
  `idpermiso` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`idpermiso`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcado de datos para la tabla `permiso`
-- INSERT INTO `permiso` (`idpermiso`, `nombre`) VALUES (...);
INSERT INTO `permiso` (`idpermiso`, `nombre`) VALUES
(1, 'Paneles Graficos'),
(2, 'Gestion de Productos'),
(3, 'Gestion de Almacen'),
(4, 'Servicios, Ventas y Reservas'),
(5, 'Gestion de Servicio'),
(6, 'Gestion de Usuario'),
(7, 'consulta de compras'),
(8, 'Consultas');


-- Estructura de tabla para la tabla `permisousuario`
CREATE TABLE IF NOT EXISTS `permisousuario` (
  `idpermisousuario` int(11) NOT NULL AUTO_INCREMENT,
  `idusuario` int(11) NOT NULL,
  `idpermiso` int(11) NOT NULL,
  PRIMARY KEY (`idpermisousuario`),
  KEY `fk_permisousuario_usuario_idx` (`idusuario`),
  KEY `fk_permisousuario_permiso_idx` (`idpermiso`),
  CONSTRAINT `fk_permisousuario_permiso` FOREIGN KEY (`idpermiso`) REFERENCES `permiso` (`idpermiso`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_permisousuario_usuario` FOREIGN KEY (`idusuario`) REFERENCES `usuario` (`idusuario`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcado de datos para la tabla `permisousuario`
-- INSERT INTO `permisousuario` (`idpermisousuario`, `idusuario`, `idpermiso`) VALUES (...);

INSERT INTO `permisousuario` (`idpermisousuario`, `idusuario`, `idpermiso`) VALUES
(1, 1, 1),
(2, 1, 2),
(3, 1, 3),
(4, 1, 4),
(5, 1, 5),
(6, 1, 6),
(7, 1, 7),
(8, 1, 8);

-- Estructura de tabla para la tabla `ingreso`
CREATE TABLE IF NOT EXISTS `ingreso` (
  `idingreso` int(11) NOT NULL AUTO_INCREMENT,
  `idpersonal` int(11) NOT NULL,
  `fecha_hora` datetime NOT NULL,
  `latitud` varchar(50) NOT NULL,
  `longitud` varchar(50) DEFAULT NULL,
  `imagen` varchar(255) DEFAULT NULL, -- Cambiado a DEFAULT NULL por si no se proporciona imagen
  `estado` varchar(20) NOT NULL,
  PRIMARY KEY (`idingreso`),
  KEY `fk_ingreso_personal_idx` (`idpersonal`),
  CONSTRAINT `fk_ingreso_persona` FOREIGN KEY (`idpersonal`) REFERENCES `persona` (`idpersona`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
