/*
SQLyog Community v13.3.0 (64 bit)
MySQL - 8.3.0 : Database - sysweb
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`sysweb` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;

USE `sysweb`;

/*Table structure for table `ajuste_inventario` */

DROP TABLE IF EXISTS `ajuste_inventario`;

CREATE TABLE `ajuste_inventario` (
  `cod_ajuste` int NOT NULL,
  `fecha_ajuste` date NOT NULL,
  `motivo` varchar(25) NOT NULL,
  `estado` varchar(30) NOT NULL,
  PRIMARY KEY (`cod_ajuste`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*Data for the table `ajuste_inventario` */

/*Table structure for table `ciudad` */

DROP TABLE IF EXISTS `ciudad`;

CREATE TABLE `ciudad` (
  `cod_ciudad` int NOT NULL,
  `descrip_ciudad` varchar(25) DEFAULT NULL,
  `id_departamento` int NOT NULL,
  PRIMARY KEY (`cod_ciudad`),
  KEY `id_departamento` (`id_departamento`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*Data for the table `ciudad` */

insert  into `ciudad`(`cod_ciudad`,`descrip_ciudad`,`id_departamento`) values 
(1,'Asunción',1),
(2,'Capiatá',1),
(3,'Hernandarias',2),
(4,'San Ignacio',3),
(5,'Nueva italia',1);

/*Table structure for table `clientes` */

DROP TABLE IF EXISTS `clientes`;

CREATE TABLE `clientes` (
  `id_cliente` int NOT NULL,
  `cod_ciudad` int DEFAULT NULL,
  `ci_ruc` varchar(10) NOT NULL,
  `cli_nombre` varchar(30) NOT NULL,
  `cli_apellido` varchar(50) NOT NULL,
  `cli_direccion` varchar(50) DEFAULT NULL,
  `cli_telefono` int DEFAULT NULL,
  PRIMARY KEY (`id_cliente`),
  KEY `clientes_cod_ciudad_fkey` (`cod_ciudad`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*Data for the table `clientes` */

insert  into `clientes`(`id_cliente`,`cod_ciudad`,`ci_ruc`,`cli_nombre`,`cli_apellido`,`cli_direccion`,`cli_telefono`) values 
(1,1,'5629997','Carlos','Ortiz','Capiata km27',976524098),
(2,2,'5628992','Aldo','Marin','Barrio san Agustin',992356262),
(3,4,'5863952','Adrian','Gimenez','Calle B',993626538);

/*Table structure for table `compra` */

DROP TABLE IF EXISTS `compra`;

CREATE TABLE `compra` (
  `cod_compra` int NOT NULL,
  `cod_proveedor` int NOT NULL,
  `id_user` int NOT NULL,
  `id_orden` int NOT NULL,
  `id_timbrado` int NOT NULL,
  `nro_factura` int NOT NULL,
  `fecha` date NOT NULL,
  `estado` varchar(15) NOT NULL,
  `hora` time NOT NULL,
  PRIMARY KEY (`cod_compra`),
  KEY `cod_proveedor` (`cod_proveedor`),
  KEY `id_orden_fk` (`id_orden`),
  KEY `id_timbrado_fk` (`id_timbrado`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*Data for the table `compra` */

insert  into `compra`(`cod_compra`,`cod_proveedor`,`id_user`,`id_orden`,`id_timbrado`,`nro_factura`,`fecha`,`estado`,`hora`) values 
(1,2,1,1,1,1,'2025-01-13','activo','17:55:05'),
(2,2,1,1,1,2,'2025-01-13','activo','18:16:57'),
(3,2,1,1,1,3,'2025-01-13','activo','18:32:03'),
(4,2,1,1,1,4,'2025-01-13','activo','18:32:56'),
(5,2,1,1,1,5,'2025-01-13','activo','18:38:01'),
(6,2,1,1,1,6,'2025-01-13','activo','18:50:34'),
(7,2,1,1,1,7,'2025-01-13','activo','18:57:04'),
(8,2,1,1,1,8,'2025-01-13','activo','19:11:55'),
(9,1,1,2,1,9,'2025-01-14','activo','16:13:52'),
(10,1,1,2,1,10,'2025-01-15','activo','01:47:16');

/*Table structure for table `cuentas_a_pagar` */

DROP TABLE IF EXISTS `cuentas_a_pagar`;

CREATE TABLE `cuentas_a_pagar` (
  `cod_cuenta` int NOT NULL AUTO_INCREMENT,
  `cod_compra` int NOT NULL,
  `cod_proveedor` int NOT NULL,
  `fecha_emision` date NOT NULL,
  `fecha_vencimiento` date NOT NULL,
  `estado` varchar(20) NOT NULL,
  PRIMARY KEY (`cod_cuenta`),
  KEY `cod_compra_fk` (`cod_compra`),
  KEY `cod_prove_fk` (`cod_proveedor`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*Data for the table `cuentas_a_pagar` */

insert  into `cuentas_a_pagar`(`cod_cuenta`,`cod_compra`,`cod_proveedor`,`fecha_emision`,`fecha_vencimiento`,`estado`) values 
(2,2,2,'2025-01-13','2025-04-13','pendiente'),
(1,1,2,'2025-01-13','2025-04-13','pendiente'),
(3,3,2,'2025-01-13','2025-04-13','pendiente'),
(4,4,2,'2025-01-13','2025-04-13','pendiente'),
(5,5,2,'2025-01-13','2025-04-13','pendiente'),
(6,6,2,'2025-01-13','2025-04-13','pendiente'),
(7,7,2,'2025-01-13','2025-04-13','pendiente'),
(8,8,2,'2025-01-13','2025-04-13','pendiente'),
(9,9,1,'2025-01-14','2025-04-14','pendiente'),
(10,10,1,'2025-01-14','2025-04-14','pendiente');

/*Table structure for table `departamento` */

DROP TABLE IF EXISTS `departamento`;

CREATE TABLE `departamento` (
  `id_departamento` int NOT NULL,
  `dep_descripcion` varchar(35) DEFAULT NULL,
  PRIMARY KEY (`id_departamento`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*Data for the table `departamento` */

insert  into `departamento`(`id_departamento`,`dep_descripcion`) values 
(1,'Central'),
(2,'Alto Paraná'),
(3,'Misiones');

/*Table structure for table `deposito` */

DROP TABLE IF EXISTS `deposito`;

CREATE TABLE `deposito` (
  `cod_deposito` int NOT NULL,
  `descrip` varchar(50) NOT NULL,
  PRIMARY KEY (`cod_deposito`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*Data for the table `deposito` */

insert  into `deposito`(`cod_deposito`,`descrip`) values 
(1,'Depo Central'),
(2,'Depo 2');

/*Table structure for table `det_ajuste` */

DROP TABLE IF EXISTS `det_ajuste`;

CREATE TABLE `det_ajuste` (
  `cod_ajuste` int NOT NULL,
  `cod_producto` int NOT NULL,
  `id_user` int NOT NULL,
  `cantidad_ajustada` int NOT NULL,
  `cantidad_anterior` int NOT NULL,
  `cantidad_final` int NOT NULL,
  PRIMARY KEY (`cod_ajuste`,`cod_producto`,`id_user`),
  KEY `usuarios_det_ajuste_fk` (`id_user`),
  KEY `producto_det_ajuste_fk` (`cod_producto`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*Data for the table `det_ajuste` */

/*Table structure for table `det_cuentas` */

DROP TABLE IF EXISTS `det_cuentas`;

CREATE TABLE `det_cuentas` (
  `cod_cuenta` int NOT NULL,
  `monto_total` int NOT NULL,
  `monto_pagado` int NOT NULL,
  PRIMARY KEY (`cod_cuenta`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*Data for the table `det_cuentas` */

insert  into `det_cuentas`(`cod_cuenta`,`monto_total`,`monto_pagado`) values 
(1,108000,0),
(2,180000,0),
(3,90000,0),
(4,45000,0),
(5,72000,0),
(6,99000,0),
(7,54000,0),
(8,9000,0),
(9,11000,0),
(10,120000,0);

/*Table structure for table `det_nota` */

DROP TABLE IF EXISTS `det_nota`;

CREATE TABLE `det_nota` (
  `id_nota` int NOT NULL,
  `cod_proveedor` int NOT NULL,
  `cod_producto` int NOT NULL,
  `cod_deposito` int NOT NULL,
  `monto` varchar(30) DEFAULT NULL,
  `razon` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `cantidad` int NOT NULL,
  PRIMARY KEY (`id_nota`),
  KEY `cod_proveedor_fk` (`cod_proveedor`),
  KEY `cod_producto_fk` (`cod_producto`),
  KEY `cod_deposito_fk` (`cod_deposito`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*Data for the table `det_nota` */

insert  into `det_nota`(`id_nota`,`cod_proveedor`,`cod_producto`,`cod_deposito`,`monto`,`razon`,`cantidad`) values 
(1,2,3,1,'27000','productos con defecto',3),
(2,1,1,1,'5500','Producto incrementado',1);

/*Table structure for table `det_orden_comp` */

DROP TABLE IF EXISTS `det_orden_comp`;

CREATE TABLE `det_orden_comp` (
  `id_orden` int NOT NULL,
  `cod_producto` int NOT NULL,
  `cant_aprob` int NOT NULL,
  `precio_unit` varchar(30) NOT NULL,
  PRIMARY KEY (`cod_producto`,`id_orden`),
  KEY `orden_compra_det_orden_comp_fk` (`id_orden`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*Data for the table `det_orden_comp` */

insert  into `det_orden_comp`(`id_orden`,`cod_producto`,`cant_aprob`,`precio_unit`) values 
(2,1,1,'5500'),
(1,3,150,'7500');

/*Table structure for table `det_pedido` */

DROP TABLE IF EXISTS `det_pedido`;

CREATE TABLE `det_pedido` (
  `id_pedido` int NOT NULL,
  `cod_deposito` int NOT NULL,
  `cod_producto` int NOT NULL,
  `cantidad` varchar(30) NOT NULL,
  PRIMARY KEY (`cod_deposito`,`cod_producto`,`id_pedido`),
  KEY `pedido_det_pedido_fk` (`id_pedido`),
  KEY `producto_det_pedido_fk` (`cod_producto`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*Data for the table `det_pedido` */

insert  into `det_pedido`(`id_pedido`,`cod_deposito`,`cod_producto`,`cantidad`) values 
(2,1,1,'1'),
(1,1,3,'150');

/*Table structure for table `det_presu` */

DROP TABLE IF EXISTS `det_presu`;

CREATE TABLE `det_presu` (
  `id_presupuesto` int NOT NULL,
  `cod_producto` int NOT NULL,
  `cantidad` int NOT NULL,
  `precio_unit` varchar(30) NOT NULL,
  KEY `producto_det_presu_fk` (`cod_producto`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*Data for the table `det_presu` */

insert  into `det_presu`(`id_presupuesto`,`cod_producto`,`cantidad`,`precio_unit`) values 
(2,1,1,'5500'),
(1,3,150,'7500');

/*Table structure for table `det_venta` */

DROP TABLE IF EXISTS `det_venta`;

CREATE TABLE `det_venta` (
  `cod_producto` int NOT NULL,
  `cod_venta` int NOT NULL,
  `cod_deposito` int NOT NULL,
  `det_precio_unit` int NOT NULL,
  `det_cantidad` int NOT NULL,
  PRIMARY KEY (`cod_producto`,`cod_venta`),
  KEY `deposito_det_venta_fk` (`cod_deposito`),
  KEY `venta_det_venta_fk` (`cod_venta`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*Data for the table `det_venta` */

insert  into `det_venta`(`cod_producto`,`cod_venta`,`cod_deposito`,`det_precio_unit`,`det_cantidad`) values 
(2,1,1,9500,1),
(1,1,1,8000,3),
(2,3,1,9500,3),
(1,2,1,8000,3),
(3,4,2,9000,12),
(3,5,1,9000,1),
(2,5,1,9500,1),
(1,5,1,8000,1),
(2,6,1,9500,1);

/*Table structure for table `detalle_compra` */

DROP TABLE IF EXISTS `detalle_compra`;

CREATE TABLE `detalle_compra` (
  `cod_producto` int NOT NULL,
  `cod_compra` int NOT NULL,
  `cod_deposito` int NOT NULL,
  `precio` int NOT NULL,
  `cantidad` int NOT NULL,
  PRIMARY KEY (`cod_producto`,`cod_compra`),
  KEY `compra_detalle_compra_fk` (`cod_compra`),
  KEY `deposito_detalle_compra_fk` (`cod_deposito`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*Data for the table `detalle_compra` */

insert  into `detalle_compra`(`cod_producto`,`cod_compra`,`cod_deposito`,`precio`,`cantidad`) values 
(1,10,2,8000,15),
(1,9,1,5500,1),
(3,8,1,9000,1),
(3,7,1,9000,6),
(3,6,1,9000,11),
(3,5,1,9000,8),
(3,4,1,9000,5),
(3,3,1,9000,10),
(3,2,1,9000,20),
(3,1,1,9000,15);

/*Table structure for table `nota_credito_debito` */

DROP TABLE IF EXISTS `nota_credito_debito`;

CREATE TABLE `nota_credito_debito` (
  `id_nota` int NOT NULL,
  `cod_compra` int NOT NULL,
  `id_user` int NOT NULL,
  `tipo` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `fecha_emision` date NOT NULL,
  `estado` varchar(30) NOT NULL,
  PRIMARY KEY (`id_nota`),
  KEY `cod_compra_fk` (`cod_compra`),
  KEY `id_user_fk` (`id_user`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*Data for the table `nota_credito_debito` */

insert  into `nota_credito_debito`(`id_nota`,`cod_compra`,`id_user`,`tipo`,`fecha_emision`,`estado`) values 
(1,1,1,'credito','2025-01-13','Aprobado'),
(2,9,1,'debito','2025-01-14','Aprobado');

/*Table structure for table `orden_compra` */

DROP TABLE IF EXISTS `orden_compra`;

CREATE TABLE `orden_compra` (
  `id_orden` int NOT NULL,
  `id_presupuesto` int NOT NULL,
  `id_user` int NOT NULL,
  `fecha` date NOT NULL,
  `hora` time NOT NULL,
  `estado` varchar(30) NOT NULL,
  PRIMARY KEY (`id_orden`),
  KEY `id_presupuesto_fk` (`id_presupuesto`),
  KEY `id_user_fk` (`id_user`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*Data for the table `orden_compra` */

insert  into `orden_compra`(`id_orden`,`id_presupuesto`,`id_user`,`fecha`,`hora`,`estado`) values 
(2,2,1,'2025-01-14','15:52:50','Aprobado'),
(1,1,1,'2025-01-13','17:54:32','Aprobado');

/*Table structure for table `password_resets` */

DROP TABLE IF EXISTS `password_resets`;

CREATE TABLE `password_resets` (
  `id` int NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=43 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*Data for the table `password_resets` */

insert  into `password_resets`(`id`,`email`,`token`,`created_at`) values 
(33,'emanuelortizferreiracarlos546@gmail.com','d6e6196317c723477a950df03910b126800958f5ea49cf1d74d357793a1524c1','2024-12-01 22:40:23'),
(32,'emanuelortizferreiracarlos546@gmail.com','2c924857135bce96d2f508fa90003b1cc287af28754de749306c2d6eca43430c','2024-12-01 22:36:51'),
(31,'emanuelortizferreiracarlos546@gmail.com','5078d3a9fd66258cd151c68fc2e97e485a224aa36abda13bb8b6b9fb6233f6d3','2024-12-01 22:28:05'),
(30,'emanuelortizferreiracarlos546@gmail.com','7bed2306468196bcfb9f08818a1004f3672b9c4fc65e357087a1f8a79f14f18a','2024-12-01 22:25:05'),
(29,'emanuelortizferreiracarlos546@gmail.com','19e4a0e96c317440a1237c7bc85577b59eb5afac60433522ca6852d344f7b6a0','2024-12-01 22:21:50'),
(28,'emanuelortizferreiracarlos546@gmail.com','f1362c5098e096be3f90d3cb276994d6bede03384b5628e7901be1fccc00c653','2024-12-01 22:20:30'),
(27,'emanuelortizferreiracarlos546@gmail.com','a1c8e41e8032d1303234de8559e1cb6c5993e226efe3e5ad989f6b0a14a3a048','2024-12-01 22:15:53'),
(34,'emanuelortizferreiracarlos546@gmail.com','d0b41959c6264dabeccee1db2f3c6b3f180c26df1849de2c77ff7fec1a264d27','2024-12-01 22:45:01'),
(35,'emanuelortizferreiracarlos546@gmail.com','4808d5674de025af040c9b6d8490dbd171d650566799efaf9ce3e3f5464e7638','2024-12-01 22:51:13'),
(36,'emanuelortizferreiracarlos546@gmail.com','07aeb63c970eadff59ee76b137c8e1d1b50a4b2252d514e01092f3894d24e9fa','2024-12-01 22:55:30'),
(37,'emanuelortizferreiracarlos546@gmail.com','2849a9c59b35333b0f76e4d757b5b25247878d77001ff10782e946542e8110cd','2024-12-04 15:43:24'),
(38,'emanuelortizferreiracarlos546@gmail.com','832496515418bf88425aa990b493f6764992ba046fa12b9c321e3cf5cb7c12d1','2024-12-11 16:16:26'),
(39,'emanuelortizferreiracarlos546@gmail.com','b91407849ea21205064d2f8d077bdda1472d2bdcc12908312e32af5a712ae2d5','2025-01-14 11:52:27'),
(40,'emanuelortizferreiracarlos546@gmail.com','ce612ea7cc192f1b485b33529b05962420abebe91c0f55eda71744a172228183','2025-01-14 11:55:39'),
(41,'emanuelortizferreiracarlos546@gmail.com','196d89340c3a62f283eeecb9e626e0d2604f18ff699c4d6b9cf8bdf7b50d7a92','2025-01-14 11:57:21'),
(42,'emanuelortizferreiracarlos546@gmail.com','f95a0c45e937ef87089c5d5caf0d301ca209111e19caa4b8f73cfe754fd43f2a','2025-01-14 11:59:52');

/*Table structure for table `pedido` */

DROP TABLE IF EXISTS `pedido`;

CREATE TABLE `pedido` (
  `id_pedido` int NOT NULL,
  `id_user` int NOT NULL,
  `fecha` date NOT NULL,
  `hora` time NOT NULL,
  `estado` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  PRIMARY KEY (`id_pedido`),
  KEY `id_user_pedido_fk` (`id_user`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*Data for the table `pedido` */

insert  into `pedido`(`id_pedido`,`id_user`,`fecha`,`hora`,`estado`) values 
(2,1,'2025-01-14','15:22:48','Aprobado'),
(1,1,'2025-01-13','17:53:48','Aprobado');

/*Table structure for table `presupuesto` */

DROP TABLE IF EXISTS `presupuesto`;

CREATE TABLE `presupuesto` (
  `id_presupuesto` int NOT NULL,
  `id_pedido` int NOT NULL,
  `cod_proveedor` int NOT NULL,
  `fecha_inicio` date NOT NULL,
  `fecha_venci` date NOT NULL,
  `estado` varchar(20) NOT NULL,
  PRIMARY KEY (`id_presupuesto`,`id_pedido`),
  KEY `proveedor_presu_prov_fk` (`cod_proveedor`),
  KEY `pedido_presupuesto_fk` (`id_pedido`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*Data for the table `presupuesto` */

insert  into `presupuesto`(`id_presupuesto`,`id_pedido`,`cod_proveedor`,`fecha_inicio`,`fecha_venci`,`estado`) values 
(2,2,1,'2025-01-14','2025-02-14','Aprobado'),
(1,1,2,'2025-01-13','2025-01-13','Aprobado');

/*Table structure for table `producto` */

DROP TABLE IF EXISTS `producto`;

CREATE TABLE `producto` (
  `cod_producto` int NOT NULL,
  `cod_tipo_prod` int NOT NULL,
  `id_u_medida` int NOT NULL,
  `p_descrip` varchar(50) NOT NULL,
  `precio` int NOT NULL,
  PRIMARY KEY (`cod_producto`),
  KEY `tipo_producto_producto_fk` (`cod_tipo_prod`),
  KEY `u_medida_producto_fk` (`id_u_medida`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*Data for the table `producto` */

insert  into `producto`(`cod_producto`,`cod_tipo_prod`,`id_u_medida`,`p_descrip`,`precio`) values 
(1,1,1,'Yogurt lactolanda',8000),
(2,2,2,'Coca Cola',9500),
(3,2,2,'Skol',9000);

/*Table structure for table `proveedor` */

DROP TABLE IF EXISTS `proveedor`;

CREATE TABLE `proveedor` (
  `cod_proveedor` int NOT NULL,
  `razon_social` varchar(75) NOT NULL,
  `ruc` varchar(9) NOT NULL,
  `direccion` varchar(50) DEFAULT NULL,
  `telefono` int NOT NULL,
  PRIMARY KEY (`cod_proveedor`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*Data for the table `proveedor` */

insert  into `proveedor`(`cod_proveedor`,`razon_social`,`ruc`,`direccion`,`telefono`) values 
(1,'Empresa de lacteos','5892365','Calle X',985361242),
(2,'Cervepar','80023269','Calle D',982555623);

/*Table structure for table `stock` */

DROP TABLE IF EXISTS `stock`;

CREATE TABLE `stock` (
  `cod_deposito` int NOT NULL,
  `cod_producto` int NOT NULL,
  `cantidad` int NOT NULL,
  PRIMARY KEY (`cod_deposito`,`cod_producto`),
  KEY `producto_stock_fk` (`cod_producto`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*Data for the table `stock` */

insert  into `stock`(`cod_deposito`,`cod_producto`,`cantidad`) values 
(1,1,72),
(1,2,12),
(2,1,15),
(2,2,0),
(2,3,18),
(1,3,158);

/*Table structure for table `timbrado_compra` */

DROP TABLE IF EXISTS `timbrado_compra`;

CREATE TABLE `timbrado_compra` (
  `id_timbrado` int NOT NULL AUTO_INCREMENT,
  `numero_timbrado` int NOT NULL,
  `rango_inicio` int NOT NULL,
  `rango_fin` int NOT NULL,
  `fecha_inicio` date NOT NULL,
  `fecha_fin` date NOT NULL,
  `estado` varchar(30) NOT NULL,
  PRIMARY KEY (`id_timbrado`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*Data for the table `timbrado_compra` */

insert  into `timbrado_compra`(`id_timbrado`,`numero_timbrado`,`rango_inicio`,`rango_fin`,`fecha_inicio`,`fecha_fin`,`estado`) values 
(1,110659398,1,99999999,'2025-01-01','2025-12-31','activo');

/*Table structure for table `tipo_producto` */

DROP TABLE IF EXISTS `tipo_producto`;

CREATE TABLE `tipo_producto` (
  `cod_tipo_prod` int NOT NULL,
  `t_p_descrip` varchar(50) NOT NULL,
  PRIMARY KEY (`cod_tipo_prod`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*Data for the table `tipo_producto` */

insert  into `tipo_producto`(`cod_tipo_prod`,`t_p_descrip`) values 
(1,'Lacteos'),
(2,'Bebidas');

/*Table structure for table `tmp` */

DROP TABLE IF EXISTS `tmp`;

CREATE TABLE `tmp` (
  `id_tmp` int NOT NULL AUTO_INCREMENT,
  `id_producto` int NOT NULL,
  `cantidad_tmp` int NOT NULL,
  `precio_tmp` int NOT NULL,
  `session_id` varchar(765) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  PRIMARY KEY (`id_tmp`)
) ENGINE=MyISAM AUTO_INCREMENT=213 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*Data for the table `tmp` */

/*Table structure for table `tmp_nota` */

DROP TABLE IF EXISTS `tmp_nota`;

CREATE TABLE `tmp_nota` (
  `id_tmp` int NOT NULL AUTO_INCREMENT,
  `cod_compra` int NOT NULL,
  `session_id` varchar(765) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  KEY `cod_compra_fk` (`cod_compra`),
  KEY `id_tmp` (`id_tmp`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*Data for the table `tmp_nota` */

/*Table structure for table `tmp_orden` */

DROP TABLE IF EXISTS `tmp_orden`;

CREATE TABLE `tmp_orden` (
  `id_tmp` int NOT NULL AUTO_INCREMENT,
  `id_presupuesto` int NOT NULL,
  `session_id` varchar(795) NOT NULL,
  PRIMARY KEY (`id_tmp`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*Data for the table `tmp_orden` */

/*Table structure for table `tmp_presu` */

DROP TABLE IF EXISTS `tmp_presu`;

CREATE TABLE `tmp_presu` (
  `id_tmp` int NOT NULL AUTO_INCREMENT,
  `id_pedido` int NOT NULL,
  `session_id` varchar(765) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  PRIMARY KEY (`id_tmp`)
) ENGINE=MyISAM AUTO_INCREMENT=104 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*Data for the table `tmp_presu` */

/*Table structure for table `u_medida` */

DROP TABLE IF EXISTS `u_medida`;

CREATE TABLE `u_medida` (
  `id_u_medida` int NOT NULL,
  `u_descrip` varchar(20) NOT NULL,
  PRIMARY KEY (`id_u_medida`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*Data for the table `u_medida` */

insert  into `u_medida`(`id_u_medida`,`u_descrip`) values 
(1,'1 Litro'),
(2,'1/2 Litro');

/*Table structure for table `usuarios` */

DROP TABLE IF EXISTS `usuarios`;

CREATE TABLE `usuarios` (
  `id_user` int NOT NULL AUTO_INCREMENT,
  `username` varchar(150) DEFAULT NULL,
  `name_user` varchar(150) DEFAULT NULL,
  `password` varchar(150) DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  `telefono` varchar(39) DEFAULT NULL,
  `foto` varchar(300) DEFAULT NULL,
  `permisos_acceso` varchar(300) DEFAULT NULL,
  `status` char(27) DEFAULT NULL,
  KEY `id_user` (`id_user`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*Data for the table `usuarios` */

insert  into `usuarios`(`id_user`,`username`,`name_user`,`password`,`email`,`telefono`,`foto`,`permisos_acceso`,`status`) values 
(1,'OrtizG','Carlos Ortiz','21232f297a57a5a743894a0e4a801fc3','emanuelortizferreiracarlos546@gmail.com','0976524098','WhatsApp Image 2024-11-07 at 18.58.56 (1).jpeg','Super Admin','activo'),
(2,'Ucompras','Usuario de compras','a82a2df07e8039ee4d5a1f46b3f03416','usuariocompras@gmail.com','0987654321','3135768.png','Compras','activo'),
(3,'Uventas','Usuario de ventas','530b350d414da3378a15b3149b322908','uventas@gmail.com','0123654789','3135768.png','Ventas','activo');

/*Table structure for table `venta` */

DROP TABLE IF EXISTS `venta`;

CREATE TABLE `venta` (
  `cod_venta` int NOT NULL,
  `id_cliente` int NOT NULL,
  `id_user` int NOT NULL,
  `cod_deposito` int NOT NULL,
  `fecha` date NOT NULL,
  `total_venta` int NOT NULL,
  `estado` varchar(15) NOT NULL,
  `hora` time NOT NULL,
  `nro_factura` int DEFAULT NULL,
  PRIMARY KEY (`cod_venta`),
  KEY `clientes_venta_fk` (`id_cliente`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*Data for the table `venta` */

insert  into `venta`(`cod_venta`,`id_cliente`,`id_user`,`cod_deposito`,`fecha`,`total_venta`,`estado`,`hora`,`nro_factura`) values 
(1,1,1,1,'2424-11-25',33500,'activo','01:07:47',1),
(2,1,1,1,'2424-11-26',24000,'activo','13:35:33',2),
(3,1,1,1,'2424-11-26',28500,'activo','13:35:51',3),
(4,2,1,2,'2424-11-26',108000,'activo','13:45:08',4),
(5,2,3,1,'2424-11-26',26500,'anulado','19:57:01',5),
(6,1,1,1,'2024-12-11',9500,'anulado','16:07:31',6);

/* Trigger structure for table `compra` */

DELIMITER $$

/*!50003 DROP TRIGGER*//*!50032 IF EXISTS */ /*!50003 `borrar_temp` */$$

/*!50003 CREATE */ /*!50017 DEFINER = 'root'@'localhost' */ /*!50003 TRIGGER `borrar_temp` AFTER INSERT ON `compra` FOR EACH ROW BEGIN
   DELETE FROM tmp;
    END */$$


DELIMITER ;

/* Trigger structure for table `nota_credito_debito` */

DELIMITER $$

/*!50003 DROP TRIGGER*//*!50032 IF EXISTS */ /*!50003 `borrar_tmp_nota` */$$

/*!50003 CREATE */ /*!50017 DEFINER = 'root'@'localhost' */ /*!50003 TRIGGER `borrar_tmp_nota` AFTER INSERT ON `nota_credito_debito` FOR EACH ROW BEGIN
	delete from tmp_nota;
    END */$$


DELIMITER ;

/* Trigger structure for table `orden_compra` */

DELIMITER $$

/*!50003 DROP TRIGGER*//*!50032 IF EXISTS */ /*!50003 `borrar_tmp_orden` */$$

/*!50003 CREATE */ /*!50017 DEFINER = 'root'@'localhost' */ /*!50003 TRIGGER `borrar_tmp_orden` AFTER INSERT ON `orden_compra` FOR EACH ROW BEGIN
	delete from tmp_orden;
    END */$$


DELIMITER ;

/* Trigger structure for table `pedido` */

DELIMITER $$

/*!50003 DROP TRIGGER*//*!50032 IF EXISTS */ /*!50003 `borrar_tmp_p` */$$

/*!50003 CREATE */ /*!50017 DEFINER = 'root'@'localhost' */ /*!50003 TRIGGER `borrar_tmp_p` AFTER INSERT ON `pedido` FOR EACH ROW begin
delete from tmp;
end */$$


DELIMITER ;

/* Trigger structure for table `presupuesto` */

DELIMITER $$

/*!50003 DROP TRIGGER*//*!50032 IF EXISTS */ /*!50003 `borrar_tmps_presu` */$$

/*!50003 CREATE */ /*!50017 DEFINER = 'root'@'localhost' */ /*!50003 TRIGGER `borrar_tmps_presu` AFTER INSERT ON `presupuesto` FOR EACH ROW BEGIN
    -- Eliminar todos los registros de la tabla tmp
    DELETE FROM tmp;

    -- Eliminar todos los registros de la tabla tmp_presu
    DELETE FROM tmp_presu;
END */$$


DELIMITER ;

/* Trigger structure for table `venta` */

DELIMITER $$

/*!50003 DROP TRIGGER*//*!50032 IF EXISTS */ /*!50003 `borrar_tmp_v` */$$

/*!50003 CREATE */ /*!50017 DEFINER = 'root'@'localhost' */ /*!50003 TRIGGER `borrar_tmp_v` AFTER INSERT ON `venta` FOR EACH ROW BEGIN
   DELETE FROM tmp;
    END */$$


DELIMITER ;

/*Table structure for table `v_clientes` */

DROP TABLE IF EXISTS `v_clientes`;

/*!50001 DROP VIEW IF EXISTS `v_clientes` */;
/*!50001 DROP TABLE IF EXISTS `v_clientes` */;

/*!50001 CREATE TABLE  `v_clientes`(
 `id_cliente` int ,
 `ci_ruc` varchar(10) ,
 `cli_nombre` varchar(30) ,
 `cli_apellido` varchar(50) ,
 `cli_direccion` varchar(50) ,
 `cli_telefono` int ,
 `cod_ciudad` int ,
 `descrip_ciudad` varchar(25) ,
 `id_departamento` int ,
 `dep_descripcion` varchar(35) 
)*/;

/*Table structure for table `v_compras` */

DROP TABLE IF EXISTS `v_compras`;

/*!50001 DROP VIEW IF EXISTS `v_compras` */;
/*!50001 DROP TABLE IF EXISTS `v_compras` */;

/*!50001 CREATE TABLE  `v_compras`(
 `cod_compra` int ,
 `cod_proveedor` int ,
 `razon_social` varchar(75) ,
 `id_orden` int ,
 `nro_factura` int ,
 `cod_producto` int ,
 `p_descrip` varchar(50) ,
 `cantidad` int ,
 `precio` int ,
 `fecha` date ,
 `hora` time ,
 `estado` varchar(15) ,
 `id_user` int ,
 `name_user` varchar(150) ,
 `cod_deposito` int ,
 `descrip` varchar(50) 
)*/;

/*Table structure for table `v_cuentas` */

DROP TABLE IF EXISTS `v_cuentas`;

/*!50001 DROP VIEW IF EXISTS `v_cuentas` */;
/*!50001 DROP TABLE IF EXISTS `v_cuentas` */;

/*!50001 CREATE TABLE  `v_cuentas`(
 `cod_cuenta` int ,
 `fecha_emision` date ,
 `fecha_vencimiento` date ,
 `estado` varchar(20) ,
 `cod_compra` int ,
 `cod_proveedor` int ,
 `razon_social` varchar(75) ,
 `monto_total` int ,
 `monto_pagado` int 
)*/;

/*Table structure for table `v_det_compra` */

DROP TABLE IF EXISTS `v_det_compra`;

/*!50001 DROP VIEW IF EXISTS `v_det_compra` */;
/*!50001 DROP TABLE IF EXISTS `v_det_compra` */;

/*!50001 CREATE TABLE  `v_det_compra`(
 `cod_compra` int ,
 `cod_producto` int ,
 `t_p_descrip` varchar(50) ,
 `u_descrip` varchar(20) ,
 `p_descrip` varchar(50) ,
 `precio` int ,
 `cantidad` int 
)*/;

/*Table structure for table `v_det_venta` */

DROP TABLE IF EXISTS `v_det_venta`;

/*!50001 DROP VIEW IF EXISTS `v_det_venta` */;
/*!50001 DROP TABLE IF EXISTS `v_det_venta` */;

/*!50001 CREATE TABLE  `v_det_venta`(
 `cod_venta` int ,
 `cod_producto` int ,
 `t_p_descrip` varchar(50) ,
 `u_descrip` varchar(20) ,
 `p_descrip` varchar(50) ,
 `det_precio_unit` int ,
 `det_cantidad` int 
)*/;

/*Table structure for table `v_nota` */

DROP TABLE IF EXISTS `v_nota`;

/*!50001 DROP VIEW IF EXISTS `v_nota` */;
/*!50001 DROP TABLE IF EXISTS `v_nota` */;

/*!50001 CREATE TABLE  `v_nota`(
 `id_nota` int ,
 `cod_compra` int ,
 `id_user` int ,
 `name_user` varchar(150) ,
 `cod_proveedor` int ,
 `razon_social` varchar(75) ,
 `cod_producto` int ,
 `p_descrip` varchar(50) ,
 `cod_deposito` int ,
 `descrip` varchar(50) ,
 `fecha_emision` date ,
 `tipo` varchar(15) ,
 `monto` varchar(30) ,
 `cantidad` int ,
 `razon` varchar(100) ,
 `estado` varchar(30) 
)*/;

/*Table structure for table `v_orden` */

DROP TABLE IF EXISTS `v_orden`;

/*!50001 DROP VIEW IF EXISTS `v_orden` */;
/*!50001 DROP TABLE IF EXISTS `v_orden` */;

/*!50001 CREATE TABLE  `v_orden`(
 `id_orden` int ,
 `cod_producto` int ,
 `p_descrip` varchar(50) ,
 `id_presupuesto` int ,
 `id_user` int ,
 `name_user` varchar(150) ,
 `fecha` date ,
 `hora` time ,
 `estado` varchar(30) ,
 `cant_aprob` int ,
 `precio_unit` varchar(30) 
)*/;

/*Table structure for table `v_pedido` */

DROP TABLE IF EXISTS `v_pedido`;

/*!50001 DROP VIEW IF EXISTS `v_pedido` */;
/*!50001 DROP TABLE IF EXISTS `v_pedido` */;

/*!50001 CREATE TABLE  `v_pedido`(
 `id_pedido` int ,
 `id_user` int ,
 `name_user` varchar(150) ,
 `fecha` date ,
 `hora` time ,
 `cod_producto` int ,
 `p_descrip` varchar(50) ,
 `cantidad` varchar(30) ,
 `estado` varchar(30) 
)*/;

/*Table structure for table `v_presu` */

DROP TABLE IF EXISTS `v_presu`;

/*!50001 DROP VIEW IF EXISTS `v_presu` */;
/*!50001 DROP TABLE IF EXISTS `v_presu` */;

/*!50001 CREATE TABLE  `v_presu`(
 `id_presupuesto` int ,
 `id_pedido` int ,
 `cod_proveedor` int ,
 `razon_social` varchar(75) ,
 `fecha_inicio` date ,
 `fecha_venci` date ,
 `cod_producto` int ,
 `p_descrip` varchar(50) ,
 `cantidad` int ,
 `precio_unit` varchar(30) ,
 `estado` varchar(20) 
)*/;

/*Table structure for table `v_producto` */

DROP TABLE IF EXISTS `v_producto`;

/*!50001 DROP VIEW IF EXISTS `v_producto` */;
/*!50001 DROP TABLE IF EXISTS `v_producto` */;

/*!50001 CREATE TABLE  `v_producto`(
 `cod_producto` int ,
 `p_descrip` varchar(50) ,
 `cod_tipo_prod` int ,
 `t_p_descrip` varchar(50) ,
 `id_u_medida` int ,
 `u_descrip` varchar(20) ,
 `precio` int 
)*/;

/*Table structure for table `v_stock` */

DROP TABLE IF EXISTS `v_stock`;

/*!50001 DROP VIEW IF EXISTS `v_stock` */;
/*!50001 DROP TABLE IF EXISTS `v_stock` */;

/*!50001 CREATE TABLE  `v_stock`(
 `cod_producto` int ,
 `p_descrip` varchar(50) ,
 `cod_deposito` int ,
 `descrip` varchar(50) ,
 `t_p_descrip` varchar(50) ,
 `u_descrip` varchar(20) ,
 `cantidad` int 
)*/;

/*Table structure for table `v_ventas` */

DROP TABLE IF EXISTS `v_ventas`;

/*!50001 DROP VIEW IF EXISTS `v_ventas` */;
/*!50001 DROP TABLE IF EXISTS `v_ventas` */;

/*!50001 CREATE TABLE  `v_ventas`(
 `cod_venta` int ,
 `id_cliente` int ,
 `cli_nombre` varchar(30) ,
 `cod_deposito` int ,
 `descrip` varchar(50) ,
 `nro_factura` int ,
 `fecha` date ,
 `estado` varchar(15) ,
 `hora` time ,
 `total_venta` int ,
 `id_user` int ,
 `name_user` varchar(150) 
)*/;

/*View structure for view v_clientes */

/*!50001 DROP TABLE IF EXISTS `v_clientes` */;
/*!50001 DROP VIEW IF EXISTS `v_clientes` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_clientes` AS select `cli`.`id_cliente` AS `id_cliente`,`cli`.`ci_ruc` AS `ci_ruc`,`cli`.`cli_nombre` AS `cli_nombre`,`cli`.`cli_apellido` AS `cli_apellido`,`cli`.`cli_direccion` AS `cli_direccion`,`cli`.`cli_telefono` AS `cli_telefono`,`ciu`.`cod_ciudad` AS `cod_ciudad`,`ciu`.`descrip_ciudad` AS `descrip_ciudad`,`dep`.`id_departamento` AS `id_departamento`,`dep`.`dep_descripcion` AS `dep_descripcion` from ((`clientes` `cli` join `departamento` `dep`) join `ciudad` `ciu`) where ((`cli`.`cod_ciudad` = `ciu`.`cod_ciudad`) and (`ciu`.`id_departamento` = `dep`.`id_departamento`)) */;

/*View structure for view v_compras */

/*!50001 DROP TABLE IF EXISTS `v_compras` */;
/*!50001 DROP VIEW IF EXISTS `v_compras` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_compras` AS select `comp`.`cod_compra` AS `cod_compra`,`prov`.`cod_proveedor` AS `cod_proveedor`,`prov`.`razon_social` AS `razon_social`,`ord`.`id_orden` AS `id_orden`,`comp`.`nro_factura` AS `nro_factura`,`pro`.`cod_producto` AS `cod_producto`,`pro`.`p_descrip` AS `p_descrip`,`det`.`cantidad` AS `cantidad`,`det`.`precio` AS `precio`,`comp`.`fecha` AS `fecha`,`comp`.`hora` AS `hora`,`comp`.`estado` AS `estado`,`usu`.`id_user` AS `id_user`,`usu`.`name_user` AS `name_user`,`dep`.`cod_deposito` AS `cod_deposito`,`dep`.`descrip` AS `descrip` from ((((((`compra` `comp` join `proveedor` `prov`) join `usuarios` `usu`) join `orden_compra` `ord`) join `producto` `pro`) join `detalle_compra` `det`) join `deposito` `dep`) where ((`comp`.`cod_proveedor` = `prov`.`cod_proveedor`) and (`comp`.`id_user` = `usu`.`id_user`) and (`comp`.`id_orden` = `ord`.`id_orden`) and (`det`.`cod_producto` = `pro`.`cod_producto`) and (`det`.`cod_deposito` = `dep`.`cod_deposito`) and (`comp`.`cod_compra` = `det`.`cod_compra`)) */;

/*View structure for view v_cuentas */

/*!50001 DROP TABLE IF EXISTS `v_cuentas` */;
/*!50001 DROP VIEW IF EXISTS `v_cuentas` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_cuentas` AS select `cap`.`cod_cuenta` AS `cod_cuenta`,`cap`.`fecha_emision` AS `fecha_emision`,`cap`.`fecha_vencimiento` AS `fecha_vencimiento`,`cap`.`estado` AS `estado`,`cap`.`cod_compra` AS `cod_compra`,`cap`.`cod_proveedor` AS `cod_proveedor`,`prov`.`razon_social` AS `razon_social`,`dcap`.`monto_total` AS `monto_total`,`dcap`.`monto_pagado` AS `monto_pagado` from (((`cuentas_a_pagar` `cap` join `det_cuentas` `dcap`) join `proveedor` `prov`) join `compra` `com`) where ((`cap`.`cod_cuenta` = `dcap`.`cod_cuenta`) and (`cap`.`cod_proveedor` = `prov`.`cod_proveedor`) and (`cap`.`cod_compra` = `com`.`cod_compra`)) */;

/*View structure for view v_det_compra */

/*!50001 DROP TABLE IF EXISTS `v_det_compra` */;
/*!50001 DROP VIEW IF EXISTS `v_det_compra` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_det_compra` AS select `comp`.`cod_compra` AS `cod_compra`,`pro`.`cod_producto` AS `cod_producto`,`tpro`.`t_p_descrip` AS `t_p_descrip`,`um`.`u_descrip` AS `u_descrip`,`pro`.`p_descrip` AS `p_descrip`,`det`.`precio` AS `precio`,`det`.`cantidad` AS `cantidad` from ((((`detalle_compra` `det` join `compra` `comp`) join `producto` `pro`) join `tipo_producto` `tpro`) join `u_medida` `um`) where ((`det`.`cod_compra` = `comp`.`cod_compra`) and (`det`.`cod_producto` = `pro`.`cod_producto`) and (`pro`.`cod_tipo_prod` = `tpro`.`cod_tipo_prod`) and (`pro`.`id_u_medida` = `um`.`id_u_medida`)) */;

/*View structure for view v_det_venta */

/*!50001 DROP TABLE IF EXISTS `v_det_venta` */;
/*!50001 DROP VIEW IF EXISTS `v_det_venta` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_det_venta` AS select `vent`.`cod_venta` AS `cod_venta`,`pro`.`cod_producto` AS `cod_producto`,`tpro`.`t_p_descrip` AS `t_p_descrip`,`um`.`u_descrip` AS `u_descrip`,`pro`.`p_descrip` AS `p_descrip`,`det`.`det_precio_unit` AS `det_precio_unit`,`det`.`det_cantidad` AS `det_cantidad` from ((((`det_venta` `det` join `venta` `vent`) join `producto` `pro`) join `tipo_producto` `tpro`) join `u_medida` `um`) where ((`det`.`cod_venta` = `vent`.`cod_venta`) and (`det`.`cod_producto` = `pro`.`cod_producto`) and (`pro`.`cod_tipo_prod` = `tpro`.`cod_tipo_prod`) and (`pro`.`id_u_medida` = `um`.`id_u_medida`)) */;

/*View structure for view v_nota */

/*!50001 DROP TABLE IF EXISTS `v_nota` */;
/*!50001 DROP VIEW IF EXISTS `v_nota` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_nota` AS select `ncd`.`id_nota` AS `id_nota`,`comp`.`cod_compra` AS `cod_compra`,`usu`.`id_user` AS `id_user`,`usu`.`name_user` AS `name_user`,`prov`.`cod_proveedor` AS `cod_proveedor`,`prov`.`razon_social` AS `razon_social`,`prod`.`cod_producto` AS `cod_producto`,`prod`.`p_descrip` AS `p_descrip`,`dep`.`cod_deposito` AS `cod_deposito`,`dep`.`descrip` AS `descrip`,`ncd`.`fecha_emision` AS `fecha_emision`,`ncd`.`tipo` AS `tipo`,`d_not`.`monto` AS `monto`,`d_not`.`cantidad` AS `cantidad`,`d_not`.`razon` AS `razon`,`ncd`.`estado` AS `estado` from ((((((`nota_credito_debito` `ncd` join `compra` `comp`) join `usuarios` `usu`) join `proveedor` `prov`) join `producto` `prod`) join `deposito` `dep`) join `det_nota` `d_not`) where ((`ncd`.`cod_compra` = `comp`.`cod_compra`) and (`ncd`.`id_nota` = `d_not`.`id_nota`) and (`ncd`.`id_user` = `usu`.`id_user`) and (`d_not`.`cod_proveedor` = `prov`.`cod_proveedor`) and (`d_not`.`cod_producto` = `prod`.`cod_producto`) and (`d_not`.`cod_deposito` = `dep`.`cod_deposito`)) */;

/*View structure for view v_orden */

/*!50001 DROP TABLE IF EXISTS `v_orden` */;
/*!50001 DROP VIEW IF EXISTS `v_orden` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_orden` AS select `orn`.`id_orden` AS `id_orden`,`pro`.`cod_producto` AS `cod_producto`,`pro`.`p_descrip` AS `p_descrip`,`pre`.`id_presupuesto` AS `id_presupuesto`,`usu`.`id_user` AS `id_user`,`usu`.`name_user` AS `name_user`,`orn`.`fecha` AS `fecha`,`orn`.`hora` AS `hora`,`orn`.`estado` AS `estado`,`det`.`cant_aprob` AS `cant_aprob`,`det`.`precio_unit` AS `precio_unit` from ((((`orden_compra` `orn` join `det_orden_comp` `det`) join `usuarios` `usu`) join `producto` `pro`) join `presupuesto` `pre`) where ((`orn`.`id_orden` = `det`.`id_orden`) and (`orn`.`id_user` = `usu`.`id_user`) and (`det`.`cod_producto` = `pro`.`cod_producto`) and (`orn`.`id_presupuesto` = `pre`.`id_presupuesto`)) */;

/*View structure for view v_pedido */

/*!50001 DROP TABLE IF EXISTS `v_pedido` */;
/*!50001 DROP VIEW IF EXISTS `v_pedido` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_pedido` AS select `p`.`id_pedido` AS `id_pedido`,`usu`.`id_user` AS `id_user`,`usu`.`name_user` AS `name_user`,`p`.`fecha` AS `fecha`,`p`.`hora` AS `hora`,`prod`.`cod_producto` AS `cod_producto`,`prod`.`p_descrip` AS `p_descrip`,`det`.`cantidad` AS `cantidad`,`p`.`estado` AS `estado` from (((`pedido` `p` join `usuarios` `usu`) join `producto` `prod`) join `det_pedido` `det`) where ((`det`.`id_pedido` = `p`.`id_pedido`) and (`det`.`cod_producto` = `prod`.`cod_producto`) and (`usu`.`id_user` = `p`.`id_user`)) */;

/*View structure for view v_presu */

/*!50001 DROP TABLE IF EXISTS `v_presu` */;
/*!50001 DROP VIEW IF EXISTS `v_presu` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_presu` AS select `pre`.`id_presupuesto` AS `id_presupuesto`,`ped`.`id_pedido` AS `id_pedido`,`prov`.`cod_proveedor` AS `cod_proveedor`,`prov`.`razon_social` AS `razon_social`,`pre`.`fecha_inicio` AS `fecha_inicio`,`pre`.`fecha_venci` AS `fecha_venci`,`prod`.`cod_producto` AS `cod_producto`,`prod`.`p_descrip` AS `p_descrip`,`det`.`cantidad` AS `cantidad`,`det`.`precio_unit` AS `precio_unit`,`pre`.`estado` AS `estado` from ((((`presupuesto` `pre` join `proveedor` `prov`) join `producto` `prod`) join `det_presu` `det`) join `pedido` `ped`) where ((`ped`.`id_pedido` = `pre`.`id_pedido`) and (`prov`.`cod_proveedor` = `pre`.`cod_proveedor`) and (`det`.`id_presupuesto` = `pre`.`id_presupuesto`) and (`det`.`cod_producto` = `prod`.`cod_producto`)) */;

/*View structure for view v_producto */

/*!50001 DROP TABLE IF EXISTS `v_producto` */;
/*!50001 DROP VIEW IF EXISTS `v_producto` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_producto` AS select `pro`.`cod_producto` AS `cod_producto`,`pro`.`p_descrip` AS `p_descrip`,`tp`.`cod_tipo_prod` AS `cod_tipo_prod`,`tp`.`t_p_descrip` AS `t_p_descrip`,`um`.`id_u_medida` AS `id_u_medida`,`um`.`u_descrip` AS `u_descrip`,`pro`.`precio` AS `precio` from ((`producto` `pro` join `tipo_producto` `tp`) join `u_medida` `um`) where ((`tp`.`cod_tipo_prod` = `pro`.`cod_tipo_prod`) and (`um`.`id_u_medida` = `pro`.`id_u_medida`)) */;

/*View structure for view v_stock */

/*!50001 DROP TABLE IF EXISTS `v_stock` */;
/*!50001 DROP VIEW IF EXISTS `v_stock` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_stock` AS select `pro`.`cod_producto` AS `cod_producto`,`pro`.`p_descrip` AS `p_descrip`,`dep`.`cod_deposito` AS `cod_deposito`,`dep`.`descrip` AS `descrip`,`tpro`.`t_p_descrip` AS `t_p_descrip`,`um`.`u_descrip` AS `u_descrip`,`st`.`cantidad` AS `cantidad` from ((((`stock` `st` join `producto` `pro`) join `tipo_producto` `tpro`) join `u_medida` `um`) join `deposito` `dep`) where ((`st`.`cod_producto` = `pro`.`cod_producto`) and (`st`.`cod_deposito` = `dep`.`cod_deposito`) and (`pro`.`cod_tipo_prod` = `tpro`.`cod_tipo_prod`) and (`pro`.`id_u_medida` = `um`.`id_u_medida`)) */;

/*View structure for view v_ventas */

/*!50001 DROP TABLE IF EXISTS `v_ventas` */;
/*!50001 DROP VIEW IF EXISTS `v_ventas` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_ventas` AS select `vent`.`cod_venta` AS `cod_venta`,`cli`.`id_cliente` AS `id_cliente`,`cli`.`cli_nombre` AS `cli_nombre`,`dep`.`cod_deposito` AS `cod_deposito`,`dep`.`descrip` AS `descrip`,`vent`.`nro_factura` AS `nro_factura`,`vent`.`fecha` AS `fecha`,`vent`.`estado` AS `estado`,`vent`.`hora` AS `hora`,`vent`.`total_venta` AS `total_venta`,`usu`.`id_user` AS `id_user`,`usu`.`name_user` AS `name_user` from (((`venta` `vent` join `clientes` `cli`) join `deposito` `dep`) join `usuarios` `usu`) where ((`vent`.`id_cliente` = `cli`.`id_cliente`) and (`vent`.`cod_deposito` = `dep`.`cod_deposito`) and (`vent`.`id_user` = `usu`.`id_user`)) */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
