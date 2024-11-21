-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Servidor: sql209.infinityfree.com
-- Tiempo de generación: 21-11-2024 a las 14:26:20
-- Versión del servidor: 10.6.19-MariaDB
-- Versión de PHP: 7.2.22
CREATE DATABASE IF NOT EXISTS `vdesisgeditecphp` CHARACTER SET utf8mb4 COLLATE=utf8mb4_general_ci;
USE `vdesisgeditecphp`;
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `if0_37745487_vdesisgeditecphp`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cliente`
--

CREATE TABLE `cliente` (
  `idusuario` int(11) NOT NULL,
  `idcliente` int(11) NOT NULL,
  `nombreempresa` varchar(45) NOT NULL,
  `nombrecliente` varchar(45) NOT NULL,
  `linea` varchar(45) NOT NULL,
  `direccion` varchar(45) NOT NULL,
  `numerotelefono` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `cliente`
--

INSERT INTO `cliente` (`idusuario`, `idcliente`, `nombreempresa`, `nombrecliente`, `linea`, `direccion`, `numerotelefono`) VALUES
(1, 1, 'Canavaro Streams', 'David Meneses', 'Camaras', 'Diagonal 12 No 12a-56', '3145632588'),
(2, 2, 'Comercializadora JB', 'Juana Espitia', 'Portatiles Acer', 'Dg 14 No. 32- 08 Cali Valle', '3694217666'),
(7, 3, 'Vivi SAS', 'Viviana Obando', 'Varios', 'Local 115 HomeCenter Cali', '3224781425'),
(1, 9, 'EsteMan SAS', 'Esteban Alexander', 'Varios', 'Diag 34 No.21-56 Bogota ', '3228907656'),
(1, 10, 'actualizacion', 'actualizacion', 'ejemplo2', 'ejemplo2', '4444');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedido`
--

CREATE TABLE `pedido` (
  `idusuario` int(11) NOT NULL,
  `idpedido` int(11) NOT NULL,
  `idproveedor` int(11) NOT NULL,
  `idproducto` int(11) NOT NULL,
  `idcliente` int(11) NOT NULL,
  `direccion` varchar(100) NOT NULL,
  `numeroitems` varchar(45) NOT NULL,
  `preciototal` varchar(45) NOT NULL,
  `telefono` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pedido`
--

INSERT INTO `pedido` (`idusuario`, `idpedido`, `idproveedor`, `idproducto`, `idcliente`, `direccion`, `numeroitems`, `preciototal`, `telefono`) VALUES
(1, 4, 2, 1, 1, 'Diagonal 12 No 12a-56', '5', '1250000.00', '3145632587'),
(3, 5, 2, 3, 3, 'Local 115 HomeCenter Cali', '2', '600000.00', '3224781425'),
(1, 6, 2, 3, 2, 'Dg 14 No. 32- 08 Cali', '4', '1200000.00', '3694217614'),
(1, 9, 2, 1, 3, 'Local 115 HomeCenter Cali', '2', '500000.00', '3224781425'),
(4, 10, 1, 2, 2, 'Dg 14 No. 32- 08 Cali Valle', '2', '70000.00', '3694217617'),
(1, 11, 1, 2, 3, 'Local 115 HomeCenter Cali', '78', '2730000.00', '3224781425');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto`
--

CREATE TABLE `producto` (
  `idusuario` int(11) NOT NULL,
  `idproducto` int(11) NOT NULL,
  `idproveedor` int(11) NOT NULL,
  `nombreproducto` varchar(100) NOT NULL,
  `marca` varchar(45) NOT NULL,
  `preciounidad` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `producto`
--

INSERT INTO `producto` (`idusuario`, `idproducto`, `idproveedor`, `nombreproducto`, `marca`, `preciounidad`) VALUES
(1, 1, 2, 'Pantallas Amoles 17 Pulgadas', 'Samsumg', '250000'),
(1, 2, 1, 'Portatil Acer 53G 365', 'Acer', '35000'),
(1, 3, 2, 'Camaras Wifi', 'DaHaSu', '300000'),
(1, 4, 3, 'Control Gaming Pro', 'Invictus', '350000'),
(1, 7, 8, 'actualizadopro', 'ejemploactua', '200000');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedor`
--

CREATE TABLE `proveedor` (
  `idusuario` int(11) NOT NULL,
  `idproveedor` int(11) NOT NULL,
  `nombreproveedor` varchar(45) NOT NULL,
  `telefono` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `proveedor`
--

INSERT INTO `proveedor` (`idusuario`, `idproveedor`, `nombreproveedor`, `telefono`) VALUES
(1, 1, 'Andres Sanchez', '3004567843'),
(1, 2, 'Dilson Mendez', '3224567821'),
(1, 3, 'Marit Beru', '3202004563'),
(1, 4, 'Alejandro Espitia', '3254781403'),
(7, 6, 'Carlos Camacaro', '3225463424'),
(1, 8, 'actualizado', '5555');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `idusuario` int(11) NOT NULL,
  `nombreusuario` varchar(45) NOT NULL,
  `password` varchar(45) NOT NULL,
  `tipousuario` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`idusuario`, `nombreusuario`, `password`, `tipousuario`) VALUES
(1, 'admin', 'admin', 'Administrador'),
(2, 'Juana', '1234', 'Administrador'),
(3, 'Esteban', '220522', 'Cliente'),
(4, 'Olga', '1410', 'Cliente'),
(5, 'David', '1410089', 'Proveedor'),
(7, 'Jose Obando', '220522', 'Administrador'),
(8, 'Carlos Castillo', '1478', 'Proveedor'),
(19, 'ejemplo', '1111', 'Proveedor');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `cliente`
--
ALTER TABLE `cliente`
  ADD PRIMARY KEY (`idcliente`),
  ADD KEY `fk_idusuario_idcliente_idx` (`idusuario`);

--
-- Indices de la tabla `pedido`
--
ALTER TABLE `pedido`
  ADD PRIMARY KEY (`idpedido`),
  ADD KEY `fk_idusuario_pedido_idx` (`idusuario`),
  ADD KEY `fk_idproveeedor_pedido_idx` (`idproveedor`),
  ADD KEY `fk_idproducto_pedido_idx` (`idproducto`),
  ADD KEY `fk_idcliente_pedido_idx` (`idcliente`);

--
-- Indices de la tabla `producto`
--
ALTER TABLE `producto`
  ADD PRIMARY KEY (`idproducto`),
  ADD KEY `fk_idusuario_producto_idx` (`idusuario`),
  ADD KEY `fk_idproveedor_producto_idx` (`idproveedor`);

--
-- Indices de la tabla `proveedor`
--
ALTER TABLE `proveedor`
  ADD PRIMARY KEY (`idproveedor`),
  ADD KEY `fk_idusuario_proveedor_idx` (`idusuario`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`idusuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `cliente`
--
ALTER TABLE `cliente`
  MODIFY `idcliente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `pedido`
--
ALTER TABLE `pedido`
  MODIFY `idpedido` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `producto`
--
ALTER TABLE `producto`
  MODIFY `idproducto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `proveedor`
--
ALTER TABLE `proveedor`
  MODIFY `idproveedor` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `idusuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `cliente`
--
ALTER TABLE `cliente`
  ADD CONSTRAINT `fk_idusuario_idcliente` FOREIGN KEY (`idusuario`) REFERENCES `usuario` (`idusuario`);

--
-- Filtros para la tabla `pedido`
--
ALTER TABLE `pedido`
  ADD CONSTRAINT `fk_idcliente_pedido` FOREIGN KEY (`idcliente`) REFERENCES `cliente` (`idcliente`),
  ADD CONSTRAINT `fk_idproducto_pedido` FOREIGN KEY (`idproducto`) REFERENCES `producto` (`idproducto`),
  ADD CONSTRAINT `fk_idproveeedor_pedido` FOREIGN KEY (`idproveedor`) REFERENCES `proveedor` (`idproveedor`),
  ADD CONSTRAINT `fk_idusuario_pedido` FOREIGN KEY (`idusuario`) REFERENCES `usuario` (`idusuario`);

--
-- Filtros para la tabla `producto`
--
ALTER TABLE `producto`
  ADD CONSTRAINT `fk_idproveedor_producto` FOREIGN KEY (`idproveedor`) REFERENCES `proveedor` (`idproveedor`),
  ADD CONSTRAINT `fk_idusuario_producto` FOREIGN KEY (`idusuario`) REFERENCES `usuario` (`idusuario`);

--
-- Filtros para la tabla `proveedor`
--
ALTER TABLE `proveedor`
  ADD CONSTRAINT `fk_idusuario_proveedor` FOREIGN KEY (`idusuario`) REFERENCES `usuario` (`idusuario`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
