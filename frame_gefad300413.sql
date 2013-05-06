-- phpMyAdmin SQL Dump
-- version 3.5.8
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 01-05-2013 a las 00:24:15
-- Versión del servidor: 5.1.69
-- Versión de PHP: 5.4.13

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `frame_gefad`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `gestion_bloque`
--

DROP TABLE IF EXISTS `gestion_bloque`;
CREATE TABLE IF NOT EXISTS `gestion_bloque` (
  `id_bloque` int(5) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) CHARACTER SET latin1 NOT NULL DEFAULT '',
  `descripcion` text CHARACTER SET latin1,
  `grupo` varchar(100) CHARACTER SET latin1 NOT NULL DEFAULT '',
  PRIMARY KEY (`id_bloque`),
  KEY `id_bloque` (`id_bloque`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci PACK_KEYS=0 ROW_FORMAT=DYNAMIC COMMENT='Bloques disponibles' AUTO_INCREMENT=25 ;

--
-- Volcado de datos para la tabla `gestion_bloque`
--

INSERT INTO `gestion_bloque` (`id_bloque`, `nombre`, `descripcion`, `grupo`) VALUES
(1, 'mensaje', 'Bloque para gestionar el contenido estatico de una pagina', ''),
(2, 'registro_usuario', 'Bloque con el formulario de registro de usuarios', 'administracion/usuarios'),
(3, 'pie', 'Pie de pagina', ''),
(4, 'banner', 'Banner para las paginas de contenido', ''),
(5, 'login', 'Formulario principal para el ingreso de nombre de usuario y clave', ''),
(6, 'logout', 'Bloque para gestionar la terminacion de sesiones en el sistema', ''),
(7, 'menu_administrador', 'menu principal para el submodulo de administrador', 'administracion'),
(8, 'borrar_registro', 'Bloque principal para borrar registros', ''),
(9, 'admin_usuario', 'bloque para administracion de usuarios', 'administracion/usuarios'),
(10, 'menu_usuario', 'menu para la administracion de ususarios', 'administracion/usuarios'),
(11, 'menu_general', 'menu general', 'administracion'),
(12, 'admin_general', 'bloque para administracion de los daos basicos', 'administracion'),
(13, 'menu_supervisor', 'menu principal para el submodulo de supervisor', 'nomina/contratistas'),
(14, 'nom_admin_novedad', 'bloque para administracion de novedades', 'nomina/contratistas'),
(15, 'nom_menu_novedad', 'Contiene opciones para las novedades', 'nomina/contratistas'),
(16, 'nom_admin_cumplido_contratista', 'bloque para manejo de cumplidos para los contratistas', 'nomina/contratistas'),
(17, 'menu_contratista', 'menu principal para el submodulo de contratista', 'nomina/contratistas'),
(18, 'nom_admin_cumplido_supervisor', 'bloque para manejo de cumplidos para los supervisores', 'nomina/contratistas'),
(19, 'nom_admin_nomina_ordenador', 'Gestiona nomina por parte del ordenador', 'nomina/contratistas'),
(20, 'menu_ordenador', 'Contiene opciones para el ordenador', 'nomina/contratistas'),
(21, 'admin_asistenteFin', 'Administra la funcionalidad asistencial del area Financiera', 'financiera'),
(22, 'menu_financiero', 'Menu Financiero', 'financiera'),
(23, 'repoFinanciero', 'Bloque que muestra los reportes financieros', 'reportes'),
(24, 'menu_reportesFin', 'Menu reportes sudsitema financiero', 'reportes');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `gestion_bloque_pagina`
--

DROP TABLE IF EXISTS `gestion_bloque_pagina`;
CREATE TABLE IF NOT EXISTS `gestion_bloque_pagina` (
  `id_pagina` int(5) NOT NULL DEFAULT '0',
  `id_bloque` int(5) NOT NULL DEFAULT '0',
  `seccion` char(1) COLLATE utf8_spanish_ci NOT NULL DEFAULT '',
  `posicion` int(2) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci COMMENT='Estructura de bloques de las paginas en el aplicativo';

--
-- Volcado de datos para la tabla `gestion_bloque_pagina`
--

INSERT INTO `gestion_bloque_pagina` (`id_pagina`, `id_bloque`, `seccion`, `posicion`) VALUES
(1, 1, 'C', 1),
(1, 3, 'E', 1),
(1, 4, 'A', 1),
(1, 5, 'B', 2),
(2, 2, 'C', 1),
(3, 1, 'C', 1),
(3, 3, 'E', 1),
(3, 4, 'A', 1),
(3, 7, 'B', 2),
(3, 11, 'B', 1),
(3, 6, 'B', 3),
(4, 6, 'C', 1),
(5, 8, 'C', 1),
(5, 4, 'A', 1),
(5, 3, 'E', 1),
(6, 4, 'A', 1),
(6, 3, 'E', 1),
(6, 6, 'B', 3),
(6, 11, 'B', 1),
(6, 9, 'C', 1),
(6, 10, 'D', 1),
(6, 7, 'B', 2),
(7, 4, 'A', 1),
(7, 3, 'E', 1),
(7, 6, 'B', 2),
(7, 11, 'B', 1),
(7, 12, 'C', 1),
(8, 1, 'C', 1),
(8, 3, 'E', 1),
(8, 4, 'A', 1),
(8, 13, 'B', 2),
(8, 11, 'B', 1),
(8, 6, 'B', 3),
(9, 14, 'C', 1),
(9, 4, 'A', 1),
(9, 3, 'E', 1),
(9, 6, 'B', 3),
(9, 11, 'B', 1),
(9, 13, 'B', 2),
(10, 4, 'A', 1),
(10, 16, 'C', 1),
(11, 1, 'C', 1),
(11, 3, 'E', 1),
(11, 4, 'A', 1),
(11, 11, 'B', 1),
(11, 17, 'B', 2),
(11, 6, 'B', 3),
(10, 11, 'B', 1),
(10, 17, 'B', 2),
(10, 6, 'B', 3),
(12, 4, 'A', 1),
(12, 18, 'C', 1),
(12, 11, 'B', 1),
(12, 13, 'B', 2),
(12, 6, 'B', 3),
(13, 19, 'C', 1),
(13, 4, 'A', 1),
(13, 6, 'B', 3),
(13, 11, 'B', 1),
(13, 20, 'B', 2),
(14, 1, 'C', 1),
(14, 3, 'E', 1),
(14, 4, 'A', 1),
(14, 11, 'B', 1),
(14, 20, 'B', 2),
(14, 6, 'B', 3),
(15, 4, 'A', 1),
(15, 22, 'B', 1),
(15, 6, 'B', 2),
(15, 21, 'C', 1),
(16, 4, 'A', 1),
(16, 22, 'B', 1),
(16, 6, 'B', 2),
(16, 23, 'C', 2),
(16, 24, 'C', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `gestion_configuracion`
--

DROP TABLE IF EXISTS `gestion_configuracion`;
CREATE TABLE IF NOT EXISTS `gestion_configuracion` (
  `id_parametro` int(3) NOT NULL AUTO_INCREMENT,
  `parametro` char(255) COLLATE utf8_spanish_ci NOT NULL DEFAULT '',
  `valor` char(255) COLLATE utf8_spanish_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`id_parametro`),
  KEY `parametro` (`parametro`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci COMMENT='Variables de configuracion' AUTO_INCREMENT=29 ;

--
-- Volcado de datos para la tabla `gestion_configuracion`
--

INSERT INTO `gestion_configuracion` (`id_parametro`, `parametro`, `valor`) VALUES
(1, 'titulo', 'Sistema de Gestión Financiera y Administrativa - Universidad Distrital Francisco José de Caldas'),
(2, 'raiz_documento', '/usr/local/apache/htdocs/gefad'),
(3, 'host', 'http://localhost'),
(4, 'site', '/gefad'),
(5, 'clave', 'gestion'),
(6, 'correo', 'computo@udistrital.edu.co'),
(7, 'prefijo', 'gestion_'),
(8, 'registro', '10'),
(9, 'expiracion', '1440'),
(10, 'wikipedia', 'http://es.wikipedia.org/wiki/'),
(11, 'enlace', 'gefad'),
(12, 'tamanno_gui', '95%'),
(13, 'grafico', '/grafico'),
(14, 'bloques', '/bloque'),
(15, 'javascript', '/funcion'),
(16, 'documento', '/documento'),
(17, 'estilo', '/estilo'),
(18, 'clases', '/clase'),
(19, 'configuracion', '/configuracion'),
(20, 'plugins', '/plugins'),
(24, 'Vtamanno_gui', '80%'),
(25, 'Vtamanno_A', '110'),
(26, 'Vtamanno_E', '8%'),
(27, 'Htamanno_B', '13%'),
(28, 'Htamanno_D', '13%');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `gestion_dbms`
--

DROP TABLE IF EXISTS `gestion_dbms`;
CREATE TABLE IF NOT EXISTS `gestion_dbms` (
  `nombre` char(50) COLLATE utf8_spanish_ci NOT NULL,
  `dbms` char(20) COLLATE utf8_spanish_ci NOT NULL,
  `servidor` char(50) COLLATE utf8_spanish_ci NOT NULL,
  `puerto` int(6) NOT NULL,
  `ssl` char(50) COLLATE utf8_spanish_ci NOT NULL,
  `db` char(100) COLLATE utf8_spanish_ci NOT NULL,
  `usuario` char(100) COLLATE utf8_spanish_ci NOT NULL,
  `password` char(100) COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`nombre`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `gestion_dbms`
--

INSERT INTO `gestion_dbms` (`nombre`, `dbms`, `servidor`, `puerto`, `ssl`, `db`, `usuario`, `password`) VALUES
('localxe', 'oci8', 'localhost', 1521, '', 'XE', 'system', 'system'),
('mysqlFrame', 'mysql', 'localhost', 3306, '0', 'frame_gefad', 'pAGFfiy7SFE8jqhcYMbM247gnA', 'pgH-aiy7SFFDEhI-AlYmuwpC8VudPFI'),
('oracleSIC', 'oci8', '10.20.0.156', 1521, '', 'PRUEBA_SIC', '4QON2E68eVHH9mzaiqVBMg', '4gNQjk68eVErQchONtU'),
('nominapg', 'pgsql', '10.20.0.38', 5432, '0', 'gestionUD', 'DwM6SQ3SSFGDhZQpbTg', 'EANHDA3SSFHh7viOJ60');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `gestion_estilo`
--

DROP TABLE IF EXISTS `gestion_estilo`;
CREATE TABLE IF NOT EXISTS `gestion_estilo` (
  `usuario` char(50) COLLATE utf8_spanish_ci NOT NULL DEFAULT '0',
  `estilo` char(50) COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`usuario`,`estilo`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci COMMENT='Estilo de pagina en el sitio';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `gestion_logger`
--

DROP TABLE IF EXISTS `gestion_logger`;
CREATE TABLE IF NOT EXISTS `gestion_logger` (
  `id_usuario` varchar(5) COLLATE utf8_spanish_ci NOT NULL DEFAULT '',
  `evento` varchar(255) COLLATE utf8_spanish_ci NOT NULL DEFAULT '',
  `fecha` varchar(50) COLLATE utf8_spanish_ci NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci COMMENT='Registro de acceso de los usuarios';

--
-- Volcado de datos para la tabla `gestion_logger`
--

INSERT INTO `gestion_logger` (`id_usuario`, `evento`, `fecha`) VALUES
('1', 'Salida del sistema.', '1360793328'),
('1', 'Salida del sistema.', '1360793682'),
('1', 'Salida del sistema.', '1360871358'),
('1', 'Salida del sistema.', '1360872391'),
('2', 'Salida del sistema.', '1361825079'),
('2', 'Salida del sistema.', '1361825606'),
('2', 'Salida del sistema.', '1362667274'),
('2', 'Salida del sistema.', '1363123673'),
('4', 'Salida del sistema.', '1363124563'),
('4', 'Salida del sistema.', '1363124768'),
('4', 'Salida del sistema.', '1363190679'),
('4', 'Salida del sistema.', '1363190721'),
('4', 'Salida del sistema.', '1363190794'),
('4', 'Salida del sistema.', '1363205115'),
('2', 'Salida del sistema.', '1363205153'),
('4', 'Salida del sistema.', '1363205998'),
('2', 'Salida del sistema.', '1363206715'),
('4', 'Salida del sistema.', '1363274060'),
('4', 'Salida del sistema.', '1363282748'),
('4', 'Salida del sistema.', '1363724732'),
('4', 'Salida del sistema.', '1363727481'),
('1', 'Salida del sistema.', '1363728773'),
('1', 'Salida del sistema.', '1363810581'),
('1', 'Salida del sistema.', '1364839146'),
('5', 'Salida del sistema.', '1364863018'),
('5', 'Salida del sistema.', '1364917593'),
('5', 'Salida del sistema.', '1364917837'),
('5', 'Salida del sistema.', '1364918365'),
('5', 'Salida del sistema.', '1364918374'),
('5', 'Salida del sistema.', '1364919776'),
('4', 'Salida del sistema.', '1364919858'),
('5', 'Salida del sistema.', '1365090228'),
('5', 'Salida del sistema.', '1365204187'),
('5', 'Salida del sistema.', '1365441988'),
('5', 'Salida del sistema.', '1365443107'),
('5', 'Salida del sistema.', '1365447052'),
('5', 'Salida del sistema.', '1365450624'),
('5', 'Salida del sistema.', '1365450786'),
('5', 'Salida del sistema.', '1365451050'),
('5', 'Salida del sistema.', '1366059249'),
('5', 'Salida del sistema.', '1366069179'),
('5', 'Salida del sistema.', '1366344585'),
('5', 'Salida del sistema.', '1366413286'),
('5', 'Salida del sistema.', '1366420491'),
('5', 'Salida del sistema.', '1366760025'),
('5', 'Salida del sistema.', '1366760190'),
('5', 'Salida del sistema.', '1366761088'),
('5', 'Salida del sistema.', '1366761140'),
('4', 'Salida del sistema.', '1366761404'),
('5', 'Salida del sistema.', '1366761499'),
('5', 'Salida del sistema.', '1366761949'),
('5', 'Salida del sistema.', '1367277194'),
('8', 'Salida del sistema.', '1367280524'),
('8', 'Salida del sistema.', '1367341193'),
('8', 'Salida del sistema.', '1367378669'),
('8', 'Salida del sistema.', '1367383589');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `gestion_log_usuario`
--

DROP TABLE IF EXISTS `gestion_log_usuario`;
CREATE TABLE IF NOT EXISTS `gestion_log_usuario` (
  `id_usuario` int(4) NOT NULL,
  `accion` char(100) COLLATE utf8_spanish_ci NOT NULL,
  `id_registro` int(11) NOT NULL,
  `tipo_registro` char(100) COLLATE utf8_spanish_ci NOT NULL,
  `nombre_registro` char(255) COLLATE utf8_spanish_ci NOT NULL,
  `fecha_log` char(100) COLLATE utf8_spanish_ci NOT NULL,
  `descripcion` char(255) COLLATE utf8_spanish_ci NOT NULL,
  KEY `id_usuario` (`id_usuario`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `gestion_pagina`
--

DROP TABLE IF EXISTS `gestion_pagina`;
CREATE TABLE IF NOT EXISTS `gestion_pagina` (
  `id_pagina` int(7) NOT NULL AUTO_INCREMENT,
  `nombre` char(50) COLLATE utf8_spanish_ci NOT NULL DEFAULT '',
  `descripcion` char(250) COLLATE utf8_spanish_ci NOT NULL DEFAULT '',
  `modulo` char(50) COLLATE utf8_spanish_ci NOT NULL DEFAULT '',
  `nivel` int(2) NOT NULL DEFAULT '0',
  `parametro` char(255) COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`id_pagina`),
  UNIQUE KEY `id_pagina` (`id_pagina`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci PACK_KEYS=0 ROW_FORMAT=FIXED COMMENT='Relacion de paginas en el aplicativo' AUTO_INCREMENT=17 ;

--
-- Volcado de datos para la tabla `gestion_pagina`
--

INSERT INTO `gestion_pagina` (`id_pagina`, `nombre`, `descripcion`, `modulo`, `nivel`, `parametro`) VALUES
(1, 'index', 'Pagina Principal del SINOC', 'GENERAL', 0, ''),
(2, 'registroUsuario', 'Pagina Principal con formulario para registro de usuario', 'GENERAL', 0, ''),
(3, 'administrador', 'Pagina principal del subsistema de administracion', 'ADMINISTRADOR', 1, ''),
(4, 'logout', 'Pagina intermedia para la finalizacion de seseiones', 'GENERAL', 0, ''),
(5, 'borrar_registro', 'Pagina general para borrar registros en el sistema', 'GENERAL', 0, ''),
(6, 'adminUsuario', 'Pagina para la administracion de los usuarios', 'ADMINISTRADOR', 1, '&xajax=AREA&xajax_file=Usuarios'),
(7, 'adminGeneral', 'Pagina para la administracion de DATOS BASICOS', 'GENERAL', 1, ''),
(8, 'supervisor', 'Pagina principal del subsistema de supervisor', 'GENERAL', 1, ''),
(9, 'nom_adminNovedad', '', 'NOVEDADES', 1, ''),
(10, 'nom_adminCumplidoContratista', 'Gestiona los cumplidos', 'CUMPLIDO', 0, '&xajax=PERIODOS_CUMPLIDO&xajax_file=Cumplidos'),
(11, 'contratista', 'Pagina principal del subsistema de contratista', 'GENERAL', 1, ''),
(12, 'nom_adminCumplidoSupervisor', 'Gestiona los cumplidos para supervisor', 'CUMPLIDO', 0, '&xajax=PERIODOS_CUMPLIDO&xajax_file=Cumplidos'),
(13, 'nom_adminNominaOrdenador', 'Gestiona la nomina por parte del ordenador', 'NOMINA', 1, ''),
(14, 'ordenador', 'Pagina principal del subsistema del ordenador', 'GENERAL', 1, ''),
(15, 'asistenteFinanciero', 'Pagina Inicial para los asistentes del area financiera', 'FINANCIERO', 1, ''),
(16, 'reportesFinanciero', 'Pagina en la que se presentan los reportes financieros', 'FINANCIERO', 1, '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `gestion_parametros_reporte`
--

DROP TABLE IF EXISTS `gestion_parametros_reporte`;
CREATE TABLE IF NOT EXISTS `gestion_parametros_reporte` (
  `id_parametro` int(11) NOT NULL,
  `id_reporte` int(11) NOT NULL,
  `nombre` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `descripcion` text COLLATE utf8_spanish_ci,
  `conexion` varchar(15) COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'Nombre de usuario de la tabla dbms',
  `consulta` text COLLATE utf8_spanish_ci COMMENT 'Consulta SQl para obtener los datos del parametro, $P[parameto]',
  `estado` int(21) NOT NULL DEFAULT '1',
  `carga_parametro` varchar(100) COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'parametros que va a alimentar el presente parametro, separados por (|)',
  `control_parametro` varchar(100) COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'parametros con que se alimenta para ejecutar la consulta SQL, separados por (|) ',
  `tipo_caja` varchar(25) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Etiqueta HTML para la creacion en la pagina (combo,texto)',
  PRIMARY KEY (`id_parametro`,`id_reporte`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `gestion_parametros_reporte`
--

INSERT INTO `gestion_parametros_reporte` (`id_parametro`, `id_reporte`, `nombre`, `descripcion`, `conexion`, `consulta`, `estado`, `carga_parametro`, `control_parametro`, `tipo_caja`) VALUES
(2, 1, 'vigencia', 'Consulta que realiza carga de los datos para los parametros de vigencias en el reporte de reservas', 'oracleSIC', 'SELECT DISTINCT RB.VIGENCIA cod_vig,RB.VIGENCIA vigencia\nFROM  PR.PR_RUBRO RB \nINNER JOIN PR.PR_APROPIACION APR \nON APR.VIGENCIA=RB.VIGENCIA \nAND APR.RUBRO_INTERNO = RB.INTERNO \nWHERE APR.CODIGO_COMPANIA =''230'' \nORDER BY vigencia DESC', 1, 'rubro|prueba', 'vigencia', 'combo'),
(4, 1, 'disponibilidad', 'Consulta que realiza carga de los datos para los parametros de vigencias en el reporte de reservas', '', '', 1, '', '', 'texto'),
(1, 1, 'unidad', 'consulta que carga los valores para los parametros de unidad ejecutora, el el reporte de reservas.', 'oracleSIC', 'SELECT DISTINCT codigo cod_un, descripcion nombre_ud FROM pr.pr_unidad_ejecutora WHERE codigo_compania=''230'' and codigo $P{''unidad''}', 1, 'vigencia', 'unidad', 'combo'),
(3, 1, 'rubro', 'Consulta que realiza carga de los datos para los parametros de vigencias en el reporte de reservas', 'oracleSIC', 'SELECT DISTINCT RB.INTERNO cod_interno,RB.DESCRIPCION nom_rubro  \nFROM  PR.PR_RUBRO RB \nINNER JOIN PR.PR_APROPIACION APR \nON APR.VIGENCIA=RB.VIGENCIA \nAND APR.RUBRO_INTERNO = RB.INTERNO \nWHERE APR.CODIGO_COMPANIA =''230'' \nAND RB.VIGENCIA $P{''vigencia''}  \nAND APR.CODIGO_UNIDAD_EJECUTORA $P{''unidad''}\nORDER BY nom_rubro', 1, '', 'vigencia|unidad', 'combo'),
(5, 1, 'registro', 'Consulta que realiza carga de los datos para los parametros de vigencias en el reporte de reservas', '', '', 1, '', '', 'texto'),
(2, 4, 'vigencia', 'Consulta que realiza carga de los datos para los parametros de vigencias en el reporte de reservas', 'oracleSIC', 'SELECT DISTINCT RB.VIGENCIA cod_vig,RB.VIGENCIA vigencia\nFROM  PR.PR_RUBRO RB \nINNER JOIN PR.PR_APROPIACION APR \nON APR.VIGENCIA=RB.VIGENCIA \nAND APR.RUBRO_INTERNO = RB.INTERNO \nWHERE APR.CODIGO_COMPANIA =''230'' \nORDER BY vigencia DESC', 1, 'rubro|prueba', 'vigencia', 'combo'),
(5, 4, 'disponibilidad', 'Campo para la busqueda de ordenes de pago por disponibilidad', '', '', 1, '', '', 'texto'),
(1, 4, 'unidad', 'consulta que carga los valores para los parametros de unidad ejecutora, el el reporte de reservas.', 'oracleSIC', 'SELECT DISTINCT codigo cod_un, descripcion nombre_ud FROM pr.pr_unidad_ejecutora WHERE codigo_compania=''230''', 1, 'vigencia', 'unidad', 'combo'),
(3, 4, 'rubro', 'Consulta que realiza carga de los datos para los parametros de vigencias en el reporte de reservas', 'oracleSIC', 'SELECT DISTINCT RB.INTERNO cod_interno,RB.DESCRIPCION nom_rubro  \r\nFROM  PR.PR_RUBRO RB \r\nINNER JOIN PR.PR_APROPIACION APR \r\nON APR.VIGENCIA=RB.VIGENCIA \r\nAND APR.RUBRO_INTERNO = RB.INTERNO \r\nWHERE APR.CODIGO_COMPANIA =''230'' \r\nAND RB.VIGENCIA $P{''vigencia''}  \r\nAND APR.CODIGO_UNIDAD_EJECUTORA $P{''unidad''}\r\nORDER BY nom_rubro', 1, '', 'vigencia|unidad', 'combo'),
(6, 4, 'registro', 'Campo para la busqueda de ordenes de pago por registro', '', '', 1, '', '', 'texto'),
(7, 4, 'orden', 'Campo para la busqueda de ordenes de pago.', '', '', 1, '', '', 'texto'),
(4, 4, 'compromiso', 'Campo para la busqueda de ordenes de pago por compromiso.', '', '', 1, '', '', 'texto'),
(2, 5, 'vigencia', 'Consulta que realiza carga de los datos para los parametros de vigencias en el reporte de reservas', 'oracleSIC', 'SELECT DISTINCT RB.VIGENCIA cod_vig,RB.VIGENCIA vigencia\nFROM  PR.PR_RUBRO RB \nINNER JOIN PR.PR_APROPIACION APR \nON APR.VIGENCIA=RB.VIGENCIA \nAND APR.RUBRO_INTERNO = RB.INTERNO \nWHERE APR.CODIGO_COMPANIA =''230'' \nORDER BY vigencia DESC', 1, 'rubro|prueba', 'vigencia', 'combo'),
(5, 5, 'disponibilidad', 'Campo para la busqueda de ordenes de pago por disponibilidad', '', '', 1, '', '', 'texto'),
(1, 5, 'unidad', 'consulta que carga los valores para los parametros de unidad ejecutora, el el reporte de registros.', 'oracleSIC', 'SELECT DISTINCT codigo cod_un, descripcion nombre_ud FROM pr.pr_unidad_ejecutora WHERE codigo_compania=''230''', 1, 'vigencia', 'unidad', 'combo'),
(3, 5, 'rubro', 'Consulta que realiza carga de los datos para los parametros de vigencias en el reporte de reservas', 'oracleSIC', 'SELECT DISTINCT RB.INTERNO cod_interno,RB.DESCRIPCION nom_rubro  \r\nFROM  PR.PR_RUBRO RB \r\nINNER JOIN PR.PR_APROPIACION APR \r\nON APR.VIGENCIA=RB.VIGENCIA \r\nAND APR.RUBRO_INTERNO = RB.INTERNO \r\nWHERE APR.CODIGO_COMPANIA =''230'' \r\nAND RB.VIGENCIA $P{''vigencia''}  \r\nAND APR.CODIGO_UNIDAD_EJECUTORA $P{''unidad''}\r\nORDER BY nom_rubro', 1, '', 'vigencia|unidad', 'combo'),
(6, 5, 'registro', 'Campo para la busqueda de ordenes de pago por registro', '', '', 1, '', '', 'texto'),
(4, 5, 'compromiso', 'Campo para la busqueda de registros por compromiso.', '', '', 1, '', '', 'texto'),
(1, 9, 'unidad', 'consulta que carga los valores para los parametros de unidad ejecutora, el el reporte de disponibilidades.', 'oracleSIC', 'SELECT DISTINCT codigo cod_un, descripcion nombre_ud FROM pr.pr_unidad_ejecutora WHERE codigo_compania=''230''', 1, 'vigencia', 'unidad', 'combo'),
(2, 9, 'vigencia', 'Consulta que realiza carga de los datos para los parametros de vigencias en el reporte de disponibilidades', 'oracleSIC', 'SELECT DISTINCT RB.VIGENCIA cod_vig,RB.VIGENCIA vigencia\r\nFROM  PR.PR_RUBRO RB \r\nINNER JOIN PR.PR_APROPIACION APR \r\nON APR.VIGENCIA=RB.VIGENCIA \r\nAND APR.RUBRO_INTERNO = RB.INTERNO \r\nWHERE APR.CODIGO_COMPANIA =''230'' \r\nORDER BY vigencia DESC', 1, 'rubro|prueba', 'vigencia', 'combo'),
(3, 9, 'rubro', 'Consulta que realiza carga de los datos para los parametros de vigencias en el reporte de disponibilidades', 'oracleSIC', 'SELECT DISTINCT RB.INTERNO cod_interno,RB.DESCRIPCION nom_rubro  \r\nFROM  PR.PR_RUBRO RB \r\nINNER JOIN PR.PR_APROPIACION APR \r\nON APR.VIGENCIA=RB.VIGENCIA \r\nAND APR.RUBRO_INTERNO = RB.INTERNO \r\nWHERE APR.CODIGO_COMPANIA =''230'' \r\nAND RB.VIGENCIA $P{''vigencia''}  \r\nAND APR.CODIGO_UNIDAD_EJECUTORA $P{''unidad''}\r\nORDER BY nom_rubro', 1, '', 'vigencia|unidad', 'combo'),
(4, 9, 'disponibilidad', 'Campo para la busqueda por disponibilidad', '', '', 1, '', '', 'texto');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `gestion_registrado`
--

DROP TABLE IF EXISTS `gestion_registrado`;
CREATE TABLE IF NOT EXISTS `gestion_registrado` (
  `id_usuario` int(7) NOT NULL AUTO_INCREMENT,
  `identificacion` varchar(15) COLLATE utf8_spanish_ci NOT NULL,
  `nombre` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `apellido` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `correo` char(250) COLLATE utf8_spanish_ci NOT NULL,
  `telefono1` int(7) NOT NULL,
  `extensiones1` varchar(50) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Guarda las extensiones separadas por guion(-)',
  `usuario` char(50) COLLATE utf8_spanish_ci NOT NULL,
  `clave` char(50) COLLATE utf8_spanish_ci NOT NULL,
  `celular` varchar(15) COLLATE utf8_spanish_ci DEFAULT NULL,
  `fecha_registro` date NOT NULL,
  `estado` varchar(1) COLLATE utf8_spanish_ci NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_usuario`),
  KEY `id_usuario` (`id_usuario`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci PACK_KEYS=0 ROW_FORMAT=FIXED AUTO_INCREMENT=10 ;

--
-- Volcado de datos para la tabla `gestion_registrado`
--

INSERT INTO `gestion_registrado` (`id_usuario`, `identificacion`, `nombre`, `apellido`, `correo`, `telefono1`, `extensiones1`, `usuario`, `clave`, `celular`, `fecha_registro`, `estado`) VALUES
(1, '1', 'ADMINISTRADOR', 'ADMINISTRADOR', '', 0, '0', 'administrador', '21232f297a57a5a743894a0e4a801fc3', NULL, '2013-02-13', '1'),
(3, '0', 'SIN', 'ASIGNAR', 'NA', 0, 'NA', 'NA', 'NA', NULL, '2011-08-01', '0'),
(2, '53091267', 'maritza', 'callejas', 'fmcallejasc@correo.udistrital.edu.co', 0, '', '53091267', 'e10adc3949ba59abbe56e057f20f883e', NULL, '2013-02-13', '1'),
(4, '80723875', 'IVAN', 'CRISTANCHO', 'fmcallejasc@correo.udistrital.edu.co', 0, '', '80723875', 'e10adc3949ba59abbe56e057f20f883e', NULL, '2013-02-13', '1'),
(5, '79708124', 'PAULO CESAR', 'CORONADO SANCHEZ', 'fmcallejasc@correo.udistrital.edu.co', 0, '', '79708124', 'e10adc3949ba59abbe56e057f20f883e', NULL, '2013-02-13', '1'),
(6, '8720359', 'RAFAEL ENRIQUE', 'ARANZALEZ', 'fmcallejasc@correo.udistrital.edu.co', 3239300, '1113', '8720359', 'e10adc3949ba59abbe56e057f20f883e', NULL, '2013-04-04', '1'),
(7, '79297396', 'ROBERTO', 'VERGARA', 'fmcallejasc@correo.udistrital.edu.co', 0, '', '79297396', 'e10adc3949ba59abbe56e057f20f883e', NULL, '2013-04-16', '1'),
(8, '79812212', 'Jairo', 'Lavado', 'jairolh@gmail.com', 123456, '', '79812212', 'e10adc3949ba59abbe56e057f20f883e', NULL, '2013-04-01', '1'),
(9, '39674528', 'DIANA LEONOR', 'TINJACA RODRIGUEZ', 'computo@udistrital.edu.co', 123456, '', '39674528', 'e10adc3949ba59abbe56e057f20f883e', NULL, '2013-04-01', '1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `gestion_registrado_borrador`
--

DROP TABLE IF EXISTS `gestion_registrado_borrador`;
CREATE TABLE IF NOT EXISTS `gestion_registrado_borrador` (
  `nombre` char(250) NOT NULL DEFAULT '',
  `apellido` char(250) NOT NULL DEFAULT '',
  `correo` char(100) NOT NULL DEFAULT '',
  `telefono` char(50) NOT NULL DEFAULT '',
  `usuario` char(50) NOT NULL DEFAULT '',
  `identificador` char(50) NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=latin1 PACK_KEYS=0;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `gestion_registrado_subsistema`
--

DROP TABLE IF EXISTS `gestion_registrado_subsistema`;
CREATE TABLE IF NOT EXISTS `gestion_registrado_subsistema` (
  `id_usuario` int(7) NOT NULL DEFAULT '0',
  `id_subsistema` int(7) NOT NULL DEFAULT '0',
  `estado` int(2) NOT NULL DEFAULT '0',
  `id_dependencia` int(7) NOT NULL COMMENT 'CAMPO QUE INDICA EL CODIGO DE LA DEPENDENCIA A LA QUE PERTENECE EL USUARIO',
  `fecha_registro` date NOT NULL COMMENT 'CAMPO EN EL QUE SE ALMACENA LA FECHA DE REGISTRO DEL USUARIO PARA EL AREA Y PERFIL',
  `fecha_fin` date DEFAULT NULL COMMENT 'CAMPO QUE INDICA LA FECHA EN QUE SE DESACTIVA EL USUARIO'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci COMMENT='Relacion de usuarios que tienen acceso a modulos especiales';

--
-- Volcado de datos para la tabla `gestion_registrado_subsistema`
--

INSERT INTO `gestion_registrado_subsistema` (`id_usuario`, `id_subsistema`, `estado`, `id_dependencia`, `fecha_registro`, `fecha_fin`) VALUES
(1, 1, 1, 0, '2013-02-13', '2020-12-31'),
(2, 4, 1, 39, '2013-02-13', '2017-05-11'),
(4, 4, 1, 39, '2013-02-13', '2017-05-11'),
(5, 3, 1, 39, '2013-04-03', '2018-06-14'),
(6, 3, 1, 9, '2013-04-01', '2017-03-28'),
(7, 2, 1, 0, '2013-04-17', '2015-04-07'),
(8, 5, 1, 0, '2013-04-01', '2014-12-31'),
(9, 5, 1, 0, '2013-04-01', '2014-12-31');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `gestion_reportes`
--

DROP TABLE IF EXISTS `gestion_reportes`;
CREATE TABLE IF NOT EXISTS `gestion_reportes` (
  `id_reporte` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `titulo` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `descripcion` text COLLATE utf8_spanish_ci NOT NULL,
  `tipo_usuario` int(11) NOT NULL COMMENT 'Numero del rol en condor',
  `conexion` varchar(15) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Nombre de usuario de la tabla dbms',
  `consulta` text COLLATE utf8_spanish_ci NOT NULL COMMENT 'Consulta SQl para el reporte, $[parameto]',
  `estado` int(2) NOT NULL DEFAULT '1',
  `parametros` varchar(2) COLLATE utf8_spanish_ci NOT NULL DEFAULT 'N' COMMENT 'Permite identificar si el reporte usa parametros',
  PRIMARY KEY (`id_reporte`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=10 ;

--
-- Volcado de datos para la tabla `gestion_reportes`
--

INSERT INTO `gestion_reportes` (`id_reporte`, `nombre`, `titulo`, `descripcion`, `tipo_usuario`, `conexion`, `consulta`, `estado`, `parametros`) VALUES
(1, 'reservas01', 'Reservas Presupuestales: Unidad Ejecutora 01 - Rector', 'registro para la generacion del reporte de la unidad ejecutora 01', 6, 'oracleSIC', 'SELECT DISTINCT resv.vigencia VIGENCIA, rub.codigo_nivel1||''-''||rub.codigo_nivel2||''-''||rub.codigo_nivel3||''-''||rub.codigo_nivel4||''-''||rub.codigo_nivel5||''-''||rub.codigo_nivel6||''-''||rub.codigo_nivel7||''-''||rub.codigo_nivel8 CODIGO, resv.descriptivo_rubro DESCRIPCION_RUBRO, resv.tipo_dcto||'' ''||resv.nro_dcto||''-''||resv.nombre BENEFICIARIO, resv.numero_disponibilidad DISPONIBILIDAD, resv.numero_registro REGISTRO, resv.apropiacion_inicial VALOR_APROPIACIÓN, resv.valor_saldo VALOR_RESERVA, 0 REVERSAS, 0 FECHA_REVERSA, 0 SALDO_REVERSA, resv.valor_pagado VALOR_GIRO_ACUMULADO, 0 REVERSA_ACUMULADO, decode(resv.nro_op,'''',''SD'',resv.nro_op) ORDEN_PAGO, decode(resv.fecha_op,'''',''SD'',resv.fecha_op) FECHA_ORDEN, 0 SALDO_DEF_RESERVA, resv.saldo_final_rubro PENDIENTE_EJECUTAR, ''0 ''||''%'' EJECUTADO FROM pr_reservas resv, pr_v_rubros rub WHERE resv.rubro_interno=rub.interno_rubro AND resv.vigencia=rub.vigencia AND resv.codigo_compania=''230'' AND resv.vigencia $P{''vigencia''} AND resv.codigo_unidad_ejecutora $P{''unidad''} AND resv.rubro_interno $P{''rubro''} AND resv.numero_disponibilidad $P{''disponibilidad''} AND resv.numero_registro $P{''registro''}', 1, 'S'),
(2, 'listaTercerosPN', 'LISTADO DE TERCEROS  -  PERSONA NATURAL', 'registro para la generacion del reporte de listado de personas naturales', 6, 'oracleSIC', 'SELECT \r\nIB_TIPO_IDENTIFICACION TIPO_IDENTIFICACION, \r\nLTRIM(IB_CODIGO_IDENTIFICACION) NUMERO_DOCUMENTO,\r\nRTRIM(IB_PRIMER_APELLIDO) PRIMER_APELLIDO, \r\nRTRIM(IB_SEGUNDO_APELLIDO) SEGUNDO_APELLIDO,\r\nDECODE(IB_NATURALEZA, ''PN'', RTRIM(IB_PRIMER_NOMBRE))  PRIMER_NOMBRE,\r\nRTRIM(IB_SEGUNDO_NOMBRE) SEGUNDO_NOMBRE, \r\n/*IC_BANCO BANCO, \r\nIC_CUENTA ,\r\nDECODE( IC_TIPO_CUENTA, ''A'', ''AHORROS'', ''C'', ''CORRIENTE'',IC_TIPO_CUENTA) TIPO_CUENTA,*/\r\nT.DIRECCION DIRECCION_RESIDENCIA, \r\nT.TEL_CELULAR  TELEFONO_CELULAR, \r\nT.TEL_FIJO TELEFONO_FIJO,\r\nT.FAX FAX, \r\nT.E_MAIL CORREO\r\nFROM SHD.SHD_INFORMACION_BASICA B, SHD_INFORMACION_COMERCIAL C,\r\n   (SELECT C.ID,\r\n     MAX(DECODE(C.CO_TIPO_CONTACTO, ''DIR'', C.CO_VALOR)) DIRECCION,\r\n     MAX(DECODE(C.CO_TIPO_CONTACTO, ''CEL'', C.CO_VALOR)) TEL_CELULAR,\r\n     MAX(DECODE(C.CO_TIPO_CONTACTO, ''TEL'', C.CO_VALOR)) TEL_FIJO,\r\n     MAX(DECODE(C.CO_TIPO_CONTACTO, ''FAX'', C.CO_VALOR)) FAX,\r\n     MAX(DECODE(C.CO_TIPO_CONTACTO, ''E-MAIL'', C.CO_VALOR)) E_MAIL\r\n     FROM (SELECT * FROM SHD_CONTACTOS) C GROUP BY C.ID) T\r\n WHERE IB_CODIGO_IDENTIFICACION \r\n IN (SELECT DISTINCT LTRIM(IB_CODIGO_IDENTIFICACION) FROM SHD.SHD_INFORMACION_BASICA) \r\n AND B.ID=C.ID AND B.ID=T.ID\r\n AND IB_NATURALEZA=''PN''\r\n ORDER BY IB_PRIMER_APELLIDO,IB_SEGUNDO_APELLIDO,IB_PRIMER_NOMBRE,IB_SEGUNDO_NOMBRE', 1, 'N'),
(3, 'listaTercerosPJ', 'LISTADO DE TERCEROS  -  PERSONA JURIDICAS', 'registro para la generacion del reporte de listado de personas juridicas', 6, 'oracleSIC', 'SELECT \nIB_TIPO_IDENTIFICACION TIP_IDEN,\nLTRIM(IB_CODIGO_IDENTIFICACION) NUMERO_DOCUMENTO,\nDECODE(IB_NATURALEZA, ''PJ'', RTRIM(IB_PRIMER_NOMBRE), ''LTDA'', RTRIM(IB_PRIMER_NOMBRE), ''S.A.'', RTRIM(IB_PRIMER_NOMBRE), ''EU'', RTRIM(IB_PRIMER_NOMBRE), ''LRD'', RTRIM(IB_PRIMER_NOMBRE))  RAZON_SOCIAL,\n/*IC_BANCO, \nIC_CUENTA,\nDECODE( IC_TIPO_CUENTA, ''A'', ''AHORROS'', ''C'', ''CORRIENTE'',IC_TIPO_CUENTA) TIPO_CUENTA,*/\nT.DIRECCION direccion, \ndecode(T.TEL_CELULAR,'''',''No'',T.TEL_CELULAR) telefono_celular, \nT.TEL_FIJO telefono_fijo, \ndecode(T.FAX,'''',''No'',T.FAX)fax, \ndecode(T.E_MAIL,'''',''No'',T.E_MAIL) correo\nFROM SHD.SHD_INFORMACION_BASICA B, SHD_INFORMACION_COMERCIAL C,\n (SELECT C.ID,\n   MAX(DECODE(C.CO_TIPO_CONTACTO, ''DIR'', C.CO_VALOR)) DIRECCION,\n   MAX(DECODE(C.CO_TIPO_CONTACTO, ''CEL'', C.CO_VALOR)) TEL_CELULAR,\n   MAX(DECODE(C.CO_TIPO_CONTACTO, ''TEL'', C.CO_VALOR)) TEL_FIJO,\n   MAX(DECODE(C.CO_TIPO_CONTACTO, ''FAX'', C.CO_VALOR)) FAX,\n   MAX(DECODE(C.CO_TIPO_CONTACTO, ''E-MAIL'', C.CO_VALOR)) E_MAIL\n   FROM (SELECT * FROM SHD_CONTACTOS) C GROUP BY C.ID) T\n   WHERE IB_CODIGO_IDENTIFICACION IN\n    (SELECT DISTINCT LTRIM(IB_CODIGO_IDENTIFICACION) FROM SHD.SHD_INFORMACION_BASICA) \n    AND B.ID=C.ID \n    AND B.ID=T.ID\n   AND IB_NATURALEZA=''PJ''\n ORDER BY IB_NATURALEZA, IB_PRIMER_NOMBRE\n', 1, 'N'),
(4, 'ordenesPagoxrubro', 'ordenes de pago', 'registro para la generacion del reporte de listado de personas juridicas', 6, 'oracleSIC', 'SELECT DISTINCT \nORDENES.VIGENCIA, \nORDENES.VIGENCIA_PRESUPUESTAL, \nORDENES.UNIDAD_EJECUTORA, \nORDENES.CODIGO_RUBRO,\nORDENES.RUBRO,\nORDENES.NUMERO_COMPROMISO,\nORDENES.DISPONIBILIDAD_PRESUPUESTAL,\nORDENES.REGISTRO_PRESUPUESTAL, \nORDENES.ORDEN_PAGO, \nORDENES.VALOR_ORDEN,\nORDENES.FECHA_ORDEN,\nORDENES.FECHA_PAGO,\nORDENES.ESTADO,\nORDENES.BENEFICIARIO,\nORDENES.DETALLE_ORDEN\n\n\nFROM\n\n(\nSELECT DISTINCT\nTO_CHAR(DET_OP.VIGENCIA) VIGENCIA, \nTO_CHAR(DET_OP.VIGENCIA) VIGENCIA_PRESUPUESTAL, \nDET_OP.CODIGO_UNIDAD_EJECUTORA UNIDAD_EJECUTORA, \nRUB.INTERNO_RUBRO INTERNO_RUBRO,\nRUB.CODIGO_NIVEL1||''-''||RUB.CODIGO_NIVEL2||''-''||RUB.CODIGO_NIVEL3||''-''||RUB.CODIGO_NIVEL4||''-''||RUB.CODIGO_NIVEL5||''-''||RUB.CODIGO_NIVEL6||''-''||RUB.CODIGO_NIVEL7||''-''||RUB.CODIGO_NIVEL8 CODIGO_RUBRO,\nRUB.DESCRIPCION RUBRO,\nCOMP.NUMERO_COMPROMISO NUMERO_COMPROMISO,\nDET_OP.NUMERO_DISPONIBILIDAD DISPONIBILIDAD_PRESUPUESTAL,\nDET_OP.NUMERO_REGISTRO REGISTRO_PRESUPUESTAL, \nTO_NUMBER(DET_OP.CONSECUTIVO_ORDEN) ORDEN_PAGO, \nDET_OP.VALOR VALOR_ORDEN,\nDECODE(OP.FECHA_APROBACION,'''',DECODE(EGR.FECHA_REGISTRO,'''',TO_DATE(''01/01/1900'',''DD-MM-YY''),TO_DATE(EGR.FECHA_REGISTRO,''DD-MM-YY'')),TO_DATE(OP.FECHA_APROBACION,''DD-MM-YY'')) FECHA_ORDEN,\nTO_DATE(EGR.FECHA_REGISTRO,''DD-MM-YY'') FECHA_PAGO,\nDECODE(SUBSTR(OP.ESTADO,9,1),''1'',''ANULADO'',SUBSTR(OP.ESTADO,4,1),''1'',''VIGENTE'') ESTADO,\nBEN.IB_CODIGO_IDENTIFICACION||'' - ''||BEN.IB_PRIMER_NOMBRE||'' ''||BEN.IB_SEGUNDO_NOMBRE||'' ''||BEN.IB_PRIMER_APELLIDO||'' ''||BEN.IB_SEGUNDO_APELLIDO BENEFICIARIO,\nUPPER(OP.DETALLE) DETALLE_ORDEN\nFROM OGT.OGT_V_PREDIS_DETALLE DET_OP\nINNER JOIN PR.PR_V_RUBROS RUB ON DET_OP.VIGENCIA=RUB.VIGENCIA AND DET_OP.RUBRO_INTERNO=RUB.INTERNO_RUBRO\nINNER JOIN PR.PR_REGISTRO_PRESUPUESTAL REG ON DET_OP.VIGENCIA=REG.VIGENCIA AND DET_OP.CODIGO_COMPANIA=REG.CODIGO_COMPANIA \n       AND DET_OP.CODIGO_UNIDAD_EJECUTORA=REG.CODIGO_UNIDAD_EJECUTORA AND DET_OP.NUMERO_REGISTRO=REG.NUMERO_REGISTRO\nINNER JOIN PR.PR_COMPROMISOS COMP ON DET_OP.VIGENCIA=COMP.VIGENCIA AND REG.CODIGO_COMPANIA=COMP.CODIGO_COMPANIA \n       AND REG.CODIGO_UNIDAD_EJECUTORA=COMP.CODIGO_UNIDAD_EJECUTORA AND REG.NUMERO_REGISTRO=COMP.NUMERO_REGISTRO\n       AND REG.NUMERO_COMPROMISO=COMP.NUMERO_COMPROMISO\nLEFT OUTER JOIN SHD.SHD_INFORMACION_BASICA BEN ON BEN.IB_CODIGO_IDENTIFICACION=COMP.NUMERO_DOCUMENTO AND BEN.IB_TIPO_IDENTIFICACION=COMP.TIPO_DOCUMENTO\nLEFT OUTER JOIN OGT.OGT_ORDEN_PAGO OP \n     ON DET_OP.VIGENCIA = OP.VIGENCIA \n    AND DET_OP.CODIGO_COMPANIA = OP.ENTIDAD \n    AND DET_OP.CODIGO_UNIDAD_EJECUTORA = OP.UNIDAD_EJECUTORA \n    AND DET_OP.CONSECUTIVO_ORDEN = OP.CONSECUTIVO\n    AND COMP.NUMERO_COMPROMISO=OP.NUMERO_de_COMPROMISO\n    AND OP.TIPO_DOCUMENTO=''OP''\nLEFT OUTER JOIN OGT.OGT_DETALLE_EGRESO EGR \n  ON  OP.CONSECUTIVO=EGR.CONSECUTIVO \n  AND OP.TER_ID=EGR.TER_ID\n  AND OP.VIGENCIA=EGR.VIGENCIA \n  AND OP.UNIDAD_EJECUTORA=EGR.UNIDAD_EJECUTORA  \nWHERE OP.IND_APROBADO = 1 \nAND OP.TIPO_OP != 2\n\nUNION \n\nSELECT DISTINCT\nTO_CHAR(DET_OP.VIGENCIA) VIGENCIA, \nTO_CHAR(DET_OP.VIGENCIA_PRESUPUESTO) VIGENCIA_PRESUPUESTAL, \nDET_OP.UNIDAD_EJECUTORA UNIDAD_EJECUTORA, \nRUB.INTERNO_RUBRO INTERNO_RUBRO,\nRUB.CODIGO_NIVEL1||''-''||RUB.CODIGO_NIVEL2||''-''||RUB.CODIGO_NIVEL3||''-''||RUB.CODIGO_NIVEL4||''-''||RUB.CODIGO_NIVEL5||''-''||RUB.CODIGO_NIVEL6||''-''||RUB.CODIGO_NIVEL7||''-''||RUB.CODIGO_NIVEL8 CODIGO_RUBRO,\nRUB.DESCRIPCION RUBRO,\nCOMP.NUMERO_COMPROMISO NUMERO_COMPROMISO,\nDET_OP.DISPONIBILIDAD DISPONIBILIDAD_PRESUPUESTAL,\nDET_OP.REGISTRO REGISTRO_PRESUPUESTAL, \nTO_NUMBER(DET_OP.CONSECUTIVO) ORDEN_PAGO, \nDET_OP.VALOR_BRUTO VALOR_ORDEN,\nDECODE(OP.FECHA_APROBACION,'''',DECODE(EGR.FECHA_REGISTRO,'''',TO_DATE(''01/01/1900'',''DD-MM-YY''),TO_DATE(EGR.FECHA_REGISTRO,''DD-MM-YY'')),TO_DATE(OP.FECHA_APROBACION,''DD-MM-YY'')) FECHA_ORDEN,\nTO_DATE(EGR.FECHA_REGISTRO,''DD-MM-YY'') FECHA_PAGO,\nDECODE(SUBSTR(OP.ESTADO,9,1),''1'',''ANULADO'',SUBSTR(OP.ESTADO,4,1),''1'',''VIGENTE'') ESTADO,\nBEN.IB_CODIGO_IDENTIFICACION||'' - ''||BEN.IB_PRIMER_NOMBRE||'' ''||BEN.IB_SEGUNDO_NOMBRE||'' ''||BEN.IB_PRIMER_APELLIDO||'' ''||BEN.IB_SEGUNDO_APELLIDO BENEFICIARIO,\nUPPER(OP.DETALLE) DETALLE_ORDEN\nFROM OGT.OGT_INFORMACION_EXOGENA DET_OP\nINNER JOIN PR.PR_V_RUBROS RUB ON DET_OP.VIGENCIA_PRESUPUESTO=RUB.VIGENCIA AND DET_OP.RUBRO_INTERNO=RUB.INTERNO_RUBRO\nINNER JOIN PR.PR_REGISTRO_PRESUPUESTAL REG ON DET_OP.VIGENCIA_PRESUPUESTO=REG.VIGENCIA  \n       AND DET_OP.UNIDAD_EJECUTORA=REG.CODIGO_UNIDAD_EJECUTORA AND DET_OP.REGISTRO=REG.NUMERO_REGISTRO\nINNER JOIN PR.PR_COMPROMISOS COMP ON DET_OP.VIGENCIA_PRESUPUESTO=COMP.VIGENCIA AND REG.CODIGO_COMPANIA=COMP.CODIGO_COMPANIA \n       AND REG.CODIGO_UNIDAD_EJECUTORA=COMP.CODIGO_UNIDAD_EJECUTORA AND REG.NUMERO_REGISTRO=COMP.NUMERO_REGISTRO\n       AND REG.NUMERO_COMPROMISO=COMP.NUMERO_COMPROMISO\nLEFT OUTER JOIN SHD.SHD_INFORMACION_BASICA BEN ON BEN.IB_CODIGO_IDENTIFICACION=COMP.NUMERO_DOCUMENTO AND BEN.IB_TIPO_IDENTIFICACION=COMP.TIPO_DOCUMENTO\nLEFT OUTER JOIN OGT.OGT_ORDEN_PAGO OP \n     ON DET_OP.VIGENCIA = OP.VIGENCIA \n    AND DET_OP.UNIDAD_EJECUTORA = OP.UNIDAD_EJECUTORA \n    AND DET_OP.CONSECUTIVO = OP.CONSECUTIVO\n    AND COMP.NUMERO_COMPROMISO=OP.NUMERO_de_COMPROMISO\n    AND OP.TIPO_DOCUMENTO=''OP''\nLEFT OUTER JOIN OGT.OGT_DETALLE_EGRESO EGR \n  ON  OP.CONSECUTIVO=EGR.CONSECUTIVO \n  AND OP.TER_ID=EGR.TER_ID\n  AND OP.VIGENCIA=EGR.VIGENCIA \n  AND OP.UNIDAD_EJECUTORA=EGR.UNIDAD_EJECUTORA  \nWHERE OP.IND_APROBADO = 1 \nAND OP.TIPO_OP != 2 ) ORDENES\nWHERE ORDENES.VIGENCIA_PRESUPUESTAL $P{''vigencia''}\nAND ORDENES.UNIDAD_EJECUTORA $P{''unidad''}\nAND ORDENES.INTERNO_RUBRO  $P{''rubro''}\nAND ORDENES.NUMERO_COMPROMISO $P{''compromiso''}\nAND ORDENES.DISPONIBILIDAD_PRESUPUESTAL $P{''disponibilidad''}\nAND ORDENES.REGISTRO_PRESUPUESTAL $P{''registro''}\nAND ORDENES.ORDEN_PAGO $P{''orden''}\nORDER BY\nVIGENCIA, \nUNIDAD_EJECUTORA, \nCODIGO_RUBRO,\nNUMERO_COMPROMISO,\nDISPONIBILIDAD_PRESUPUESTAL,\nREGISTRO_PRESUPUESTAL, \nORDEN_PAGO\n', 1, 'S'),
(6, 'reservas02', 'Reservas Presupuestales: Unidad Ejecutora 02 - Convenios', 'registro para la generacion del reporte de la unidad ejecutora 02', 6, 'oracleSIC', ' select distinct resv.vigencia VIGENCIA, rub.codigo_nivel1||''-''||rub.codigo_nivel2||''-''||rub.codigo_nivel3||''-''||rub.codigo_nivel4||''-''||rub.codigo_nivel5||''-''||rub.codigo_nivel6||''-''||rub.codigo_nivel7||''-''||rub.codigo_nivel8 CODIGO, resv.descriptivo_rubro DESCRIPCION_RUBRO, resv.tipo_dcto||'' ''||resv.nro_dcto||''-''||resv.nombre BENEFICIARIO, resv.numero_disponibilidad DISPONIBILIDAD, resv.numero_registro REGISTRO, resv.apropiacion_inicial VALOR_APROPIACIÓN, resv.valor_saldo VALOR_RESERVA, 0 REVERSAS, 0 FECHA_REVERSA, 0 SALDO_REVERSA, resv.valor_pagado VALOR_GIRO_ACUMULADO, 0 REVERSA_ACUMULADO, decode(resv.nro_op,'''',''SD'',resv.nro_op) ORDEN_PAGO, decode(resv.fecha_op,'''',''SD'',resv.fecha_op) FECHA_ORDEN, 0 SALDO_DEF_RESERVA, resv.saldo_final_rubro PENDIENTE_EJECUTAR, ''0 ''||''%'' EJECUTADO from pr_reservas resv, pr_v_rubros rub where resv.rubro_interno=rub.interno_rubro and resv.vigencia=rub.vigencia and resv.vigencia=$P[VIGENCIA] and resv.codigo_unidad_ejecutora=''01'' and resv.codigo_compania=''230'' and resv.descriptivo_rubro=''SISTEMA INTEGRAL DE INFORMACION Y TELECOMUNICACIONES'' order by VIGENCIA,CODIGO,DISPONIBILIDAD,REGISTRO ', 1, 'N'),
(5, 'registroPresupuestalxrubro', 'Registros Presupuestales', 'registro para la generacion del reporte de listado de personas juridicas', 6, 'oracleSIC', 'SELECT DISTINCT \n  CRP.VIGENCIA VIGENCIA,\n  CRP.CODIGO_UNIDAD_EJECUTORA UNIDAD_EJECUTORA,\n  RUB.CODIGO_NIVEL1||''-''||RUB.CODIGO_NIVEL2||''-''||RUB.CODIGO_NIVEL3||''-''||RUB.CODIGO_NIVEL4||''-''||RUB.CODIGO_NIVEL5||''-''||RUB.CODIGO_NIVEL6||''-''||RUB.CODIGO_NIVEL7||''-''||RUB.CODIGO_NIVEL8 CODIGO_RUBRO,\n  RUB.DESCRIPCION RUBRO,\n  CRP.NUMERO_DISPONIBILIDAD DISPONIBILIDAD_PRESUPUESTAL,\n  COMP.NUMERO_COMPROMISO NUMERO_COMPROMISO,\n  CRP.NUMERO_REGISTRO REGISTRO_PRESUPUESTAL,\n    TO_DATE(CRP.FECHA_REGISTRO,''DD-MM-YY'') FECHA_REGISTRO,\n  COMP.OBJETO,\n  NVL(CRP_DISP.VALOR,0) VALOR_REGISTRO,\n  BEN.IB_CODIGO_IDENTIFICACION||'' - ''||BEN.IB_PRIMER_NOMBRE||'' ''||BEN.IB_SEGUNDO_NOMBRE||'' ''||BEN.IB_PRIMER_APELLIDO||'' ''||BEN.IB_SEGUNDO_APELLIDO BENEFICIARIO,\n  CRP.ESTADO,\n(CASE WHEN ANULAP_CRP.VALOR_ANULADO<>0\n     THEN TO_CHAR(ANULAP_CRP.FECHA_ANULACION,''DD-MM-YY'')\n     WHEN ANULAT_CRP.VALOR<>0\n     THEN TO_CHAR(ANULAT_CRP.FECHA_REGISTRO,''DD-MM-YY'')\n     ELSE ''N/A''\n     END) FECHA_ANULACION,\n(CASE WHEN ANULAP_CRP.VALOR_ANULADO<>0\n     THEN ANULAP_CRP.VALOR_ANULADO\n     WHEN ANULAT_CRP.VALOR<>0\n     THEN ANULAT_CRP.VALOR\n     ELSE 0 \n     END) TOTAL_ANULADO \nFROM PR.PR_REGISTRO_PRESUPUESTAL CRP \nINNER JOIN PR.PR_REGISTRO_DISPONIBILIDAD CRP_DISP\nON CRP.NUMERO_REGISTRO         =CRP_DISP.NUMERO_REGISTRO\nAND CRP.NUMERO_DISPONIBILIDAD  =CRP_DISP.NUMERO_DISPONIBILIDAD\nAND CRP.VIGENCIA               =CRP_DISP.VIGENCIA\nAND CRP.CODIGO_UNIDAD_EJECUTORA=CRP_DISP.CODIGO_UNIDAD_EJECUTORA \n\nINNER JOIN PR.PR_V_RUBROS RUB ON CRP.VIGENCIA=RUB.VIGENCIA AND CRP_DISP.RUBRO_INTERNO=RUB.INTERNO_RUBRO\n\nINNER JOIN PR.PR_COMPROMISOS COMP\nON CRP.NUMERO_COMPROMISO       =COMP.NUMERO_COMPROMISO\nAND CRP.NUMERO_REGISTRO        =COMP.NUMERO_REGISTRO\nAND CRP.VIGENCIA               =COMP.VIGENCIA\nAND CRP.CODIGO_UNIDAD_EJECUTORA=COMP.CODIGO_UNIDAD_EJECUTORA\nLEFT OUTER JOIN SHD.SHD_INFORMACION_BASICA BEN ON BEN.IB_CODIGO_IDENTIFICACION=COMP.NUMERO_DOCUMENTO AND BEN.IB_TIPO_IDENTIFICACION=COMP.TIPO_DOCUMENTO\nINNER JOIN\n  (SELECT PROVE.COD_TER COD_TER,\n    PROVE.TIP_ID TIP_ID,\n    PROVE.NRO_ID NRO_ID\n  FROM\n    ( SELECT DISTINCT TO_CHAR(PROV.ID_TERCERO) COD_TER,\n      TO_CHAR(TER.TIPO_DOCUMENTO) TIP_ID,\n      TO_CHAR(TER.NUMERO_DOCUMENTO) NRO_ID\n    FROM PR.PR_TERCEROS TER\n    INNER JOIN CO.CO_PROVEEDOR PROV\n    ON TO_CHAR(TER.NUMERO_DOCUMENTO)=TO_CHAR(PROV.NUM_IDENTIFICACION)\n    UNION\n    SELECT DISTINCT TO_CHAR(TER.ID) COD_TER,\n      TO_CHAR(TRIM(TER.IB_TIPO_IDENTIFICACION)) TIP_ID,\n      TO_CHAR(TRIM(TER.IB_CODIGO_IDENTIFICACION)) NRO_ID\n    FROM SHD.SHD_INFORMACION_BASICA TER\n    ) PROVE\n  ) BENE ON BENE.NRO_ID= COMP.NUMERO_DOCUMENTO\nAND BENE.TIP_ID        = COMP.TIPO_DOCUMENTO\nINNER JOIN SHD.BINTABLAS TCOMP\nON CRP.TIPO_COMPROMISO= TCOMP.ARGUMENTO\nAND TCOMP.NOMBRE      =''TIPO_COMPROMISO''\nLEFT OUTER JOIN PR.PR_RP_ANULADOS ANULAP_CRP\nON CRP.NUMERO_REGISTRO         =ANULAP_CRP.NUMERO_REGISTRO\nAND CRP.VIGENCIA               = ANULAP_CRP.VIGENCIA\nAND CRP.CODIGO_UNIDAD_EJECUTORA=ANULAP_CRP.CODIGO_UNIDAD_EJECUTORA\nAND ANULAP_CRP.RUBRO_INTERNO   =CRP_DISP.RUBRO_INTERNO\nLEFT OUTER JOIN PR.PR_ANULACIONES ANULAT_CRP\nON CRP.NUMERO_REGISTRO          =ANULAT_CRP.NUMERO_DOCUMENTO_ANULADO\nAND CRP.CODIGO_UNIDAD_EJECUTORA =ANULAT_CRP.CODIGO_UNIDAD_EJECUTORA\nAND CRP.VIGENCIA                = ANULAT_CRP.VIGENCIA\nAND ANULAT_CRP.DOCUMENTO_ANULADO=''REGISTRO''\nWHERE  CRP.CODIGO_COMPANIA=''230''\nAND CRP.VIGENCIA $P{''vigencia''} \nAND CRP.CODIGO_UNIDAD_EJECUTORA $P{''unidad''} \nAND RUB.INTERNO_RUBRO $P{''rubro''}\nAND COMP.NUMERO_COMPROMISO $P{''compromiso''}\nAND CRP.NUMERO_DISPONIBILIDAD $P{''disponibilidad''}\nAND CRP.NUMERO_REGISTRO $P{''registro''}\n', 1, 'S'),
(7, 'SIIGO_op', 'Formato SIIGO - Órdenes de Pago', 'registro para la generación del reporte que genera formato de consulta ordenes de pago\n', 6, 'oracleSIC', 'SELECT\nA.VIGENCIA VIGENCIA,\nA.TIPO_DOCUMENTO TIPO_COMPROBANTE,\nDECODE(A.UNIDAD_EJECUTORA,01,''12'',02,''14'') CC,\nA.UNIDAD_EJECUTORA,\nS.IB_CODIGO_IDENTIFICACION IDENTIFICACION,\nS.IB_PRIMER_APELLIDO||'' ''||S.IB_SEGUNDO_APELLIDO||'' ''||S.IB_PRIMER_NOMBRE||'' ''||S.IB_SEGUNDO_NOMBRE NOMBRE_IDENTIFICACION,\nCUENTA_CONTABLE, \nDESCRIPCION_CODIGO NOMBRE_CUENTA, \n''C'' NATURALEZA ,\nTO_CHAR(D.FECHA_DILIGENCIAMIENTO, ''YYYYMMDD'') FECHA_DOCUMENTO,\nnull DESCRIPCION_DETALLE_PAGO,\nSUM(VALOR_DESCUENTO) VALOR\n\nFROM   \nOGT.OGT_DETALLE_DESCUENTO A, OGT.OGT_DESCUENTO B, OGT.OGT_DOCUMENTO_PAGO D, OGT.OGT_ORDEN_PAGO P, SHD.SHD_INFORMACION_BASICA S\n\nWHERE   \nA.CODIGO_INTERNO = B.CODIGO_INTERNO\nAND A.CONSECUTIVO=D.CONSECUTIVO\nAND A.ENTIDAD=D.ENTIDAD\nAND A.TIPO_DOCUMENTO=D.TIPO_DOCUMENTO\nAND A.UNIDAD_EJECUTORA=D.UNIDAD_EJECUTORA\nAND A.VIGENCIA=D.VIGENCIA\nAND A.CONSECUTIVO=P.CONSECUTIVO\nAND A.ENTIDAD=P.ENTIDAD\nAND A.TIPO_DOCUMENTO=P.TIPO_DOCUMENTO\nAND A.UNIDAD_EJECUTORA=P.UNIDAD_EJECUTORA\nAND A.VIGENCIA=P.VIGENCIA\nAND P.TER_ID=S.ID\nAND S.IB_FECHA_FINAL IS NULL\nAND TO_CHAR(D.FECHA_DILIGENCIAMIENTO, ''YYYYMMDD'') BETWEEN ''20130101'' AND ''20130420''\nAND SUBSTR(P.ESTADO,9,1)<>''1''\n\n--ESTADO DIFERENTE DE ANULADO\nGROUP BY  \nA.VIGENCIA,\nA.ENTIDAD,\nA.UNIDAD_EJECUTORA,\nA.TIPO_DOCUMENTO,\nA.CONSECUTIVO, \nS.IB_TIPO_IDENTIFICACION,\nS.IB_CODIGO_IDENTIFICACION,\nS.IB_PRIMER_APELLIDO,\nS.IB_SEGUNDO_APELLIDO,\nS.IB_PRIMER_NOMBRE,\nS.IB_SEGUNDO_NOMBRE,\nCUENTA_CONTABLE, \nDESCRIPCION_CODIGO,\nPORCENTAJE,\nTO_CHAR(D.FECHA_DILIGENCIAMIENTO, ''YYYYMMDD'')\n\nUnion\n\nSELECT \nA.VIGENCIA VIGENCIA,\nA.TIPO_DOCUMENTO TIPO_COMPROBANTE,\nDECODE(A.UNIDAD_EJECUTORA,01,''12'',02,''14'') CC,\nA.UNIDAD_EJECUTORA, \nS.IB_CODIGO_IDENTIFICACION IDENTIFICACION,\nS.IB_PRIMER_APELLIDO||'' ''||S.IB_SEGUNDO_APELLIDO||'' ''||S.IB_PRIMER_NOMBRE||'' ''||S.IB_SEGUNDO_NOMBRE NOMBRE_IDENTIFICACION,\nCUENTA_CONTABLE,\nNULL,\n''C'' NATURALEZA,\nTO_CHAR(D.FECHA_DILIGENCIAMIENTO, ''YYYYMMDD'') FECHA_DOCUMENTO,\nnull DESCRIPCION_DETALLE_PAGO, \nVALOR_CAUSADO\n\nFROM\nOGT.OGT_CUENTAS_ORDEN_PAGO A, OGT.OGT_DETALLE_EGRESO E,OGT.OGT_DOCUMENTO_PAGO D, OGT.OGT_ORDEN_PAGO P, SHD.SHD_INFORMACION_BASICA S\n\nWHERE \nA.ES_DESCUENTO  IN (''B'',''T'',''N'')\nAND A.CONSECUTIVO=E.CONSECUTIVO\nAND  A.ENTIDAD=E.ENTIDAD \nAND A.TIPO_DOCUMENTO=E.TIPO_DOCUMENTO\nAND A.UNIDAD_EJECUTORA=E.UNIDAD_EJECUTORA\nAND A.VIGENCIA=E.VIGENCIA \nAND A.CONSECUTIVO=D.CONSECUTIVO\nAND  A.ENTIDAD=D.ENTIDAD \nAND A.TIPO_DOCUMENTO=D.TIPO_DOCUMENTO\nAND A.UNIDAD_EJECUTORA=D.UNIDAD_EJECUTORA\nAND A.VIGENCIA=D.VIGENCIA \nAND A.CONSECUTIVO=P.CONSECUTIVO\nAND  A.ENTIDAD=P.ENTIDAD \nAND A.TIPO_DOCUMENTO=P.TIPO_DOCUMENTO\nAND A.UNIDAD_EJECUTORA=P.UNIDAD_EJECUTORA\nAND A.VIGENCIA=P.VIGENCIA\nAND P.TER_ID=S.ID\nAND S.IB_FECHA_FINAL IS NULL \nAND SUBSTR(P.ESTADO,9,1)<>''1''\nAND TO_CHAR(D.FECHA_DILIGENCIAMIENTO, ''YYYYMMDD'') BETWEEN ''20130101'' AND ''20130420''', 1, 'N'),
(8, 'SIIGO_op_formato', 'Formato SICAPITAL-SIIGO: Órdenes de Pago', 'Registro para la generación del reporte listado de ordenes de pago en formato de importación software SIIGO.', 6, 'oracleSIC', 'SELECT\n\nDECODE(A.TIPO_DOCUMENTO,''OP'',''P'') TIPO_DOCUMENTO,\nDECODE(A.UNIDAD_EJECUTORA,01,''012'',02,''014'') CC,\nLPAD(A.CONSECUTIVO,11,''0'') NUMERO_DOCUMENTO,\nNULL SEC, /* CONSECUTIVO MAX 5 POSICIONES MAX 250 VALORES*/\nLPAD(S.IB_CODIGO_IDENTIFICACION,13,''0'') NIT,\n''000'' SUC,\nRPAD((replace(CUENTA_CONTABLE,''-'')),10,''0'') COD_CONTABLE,\n''0000000000000'' COD_DE_PROC,\nTO_CHAR(D.FECHA_DILIGENCIAMIENTO, ''YYYYMMDD'') FECHA_DOCUMENTO,\n''0001'' CCTO,\n''000'' SC,\nnull DESCRIPCION_MOVIMIENTO,\n''C'' NATURALEZA,\n((SUM(VALOR_DESCUENTO))*100) V_MOVIMIENTO,\n((SUM(VALOR_BASE_RETENCION)*100)) BASE_RETENCION \n\n\nFROM   \nOGT.OGT_DETALLE_DESCUENTO A, OGT.OGT_DESCUENTO B, OGT.OGT_DOCUMENTO_PAGO D, OGT.OGT_ORDEN_PAGO P, SHD_INFORMACION_BASICA S\n\nWHERE   \nA.CODIGO_INTERNO = B.CODIGO_INTERNO\nAND A.CONSECUTIVO=D.CONSECUTIVO\nAND A.ENTIDAD=D.ENTIDAD\nAND A.TIPO_DOCUMENTO=D.TIPO_DOCUMENTO\nAND A.UNIDAD_EJECUTORA=D.UNIDAD_EJECUTORA\nAND A.VIGENCIA=D.VIGENCIA\nAND A.CONSECUTIVO=P.CONSECUTIVO\nAND A.ENTIDAD=P.ENTIDAD\nAND A.TIPO_DOCUMENTO=P.TIPO_DOCUMENTO\nAND A.UNIDAD_EJECUTORA=P.UNIDAD_EJECUTORA\nAND A.VIGENCIA=P.VIGENCIA\nAND P.TER_ID=S.ID\nAND S.IB_FECHA_FINAL IS NULL\nAND TO_CHAR(D.FECHA_DILIGENCIAMIENTO, ''YYYYMMDD'') BETWEEN ''20130101'' AND ''20130420''\nAND SUBSTR(P.ESTADO,9,1)<>''1''\n\n--ESTADO DIFERENTE DE ANULADO\nGROUP BY\n\n\nA.UNIDAD_EJECUTORA,\nA.TIPO_DOCUMENTO,\nA.CONSECUTIVO, \nS.IB_CODIGO_IDENTIFICACION,\nCUENTA_CONTABLE, \nTO_CHAR(D.FECHA_DILIGENCIAMIENTO, ''YYYYMMDD'')\n\nUnion\n\nSELECT \nDECODE(A.TIPO_DOCUMENTO,''OP'',''P'') TIPO_DOCUMENTO,\nDECODE(A.UNIDAD_EJECUTORA,01,''012'',02,''014'') CC,\nLPAD(A.CONSECUTIVO,11,''0'') NUMERO_DOCUMENTO,\nNULL SEC, /* CONSECUTIVO MAX 5 POSICIONES MAX 250 VALORES*/\nLPAD(S.IB_CODIGO_IDENTIFICACION,13,''0'') NIT,\n''000'' SUC,\nRPAD((replace(CUENTA_CONTABLE,''-'')),10,''0'') COD_CONTABLE,\n''0000000000000'' COD_DE_PROC,\nTO_CHAR(D.FECHA_DILIGENCIAMIENTO, ''YYYYMMDD'') FECHA_DOCUMENTO,''0001'' CCTO,\n''000'' SC, \nnull DESCRIPCION_MOVIMIENTO, \n''D'' NATURALEZA,\n((VALOR_CAUSADO)*100) V_MOVIMIENTO,\nnull BASE_RETENCION\n\nFROM\nOGT.OGT_CUENTAS_ORDEN_PAGO A, OGT.OGT_DETALLE_EGRESO E,OGT.OGT_DOCUMENTO_PAGO D, OGT.OGT_ORDEN_PAGO P, SHD_INFORMACION_BASICA S\n\nWHERE \nA.ES_DESCUENTO  IN (''B'',''T'',''N'')\nAND A.CONSECUTIVO=E.CONSECUTIVO\nAND A.ENTIDAD=E.ENTIDAD \nAND A.UNIDAD_EJECUTORA=E.UNIDAD_EJECUTORA\nAND A.VIGENCIA=E.VIGENCIA \nAND A.CONSECUTIVO=D.CONSECUTIVO\nAND A.ENTIDAD=D.ENTIDAD \nAND A.UNIDAD_EJECUTORA=D.UNIDAD_EJECUTORA\nAND A.VIGENCIA=D.VIGENCIA \nAND A.CONSECUTIVO=P.CONSECUTIVO\nAND A.ENTIDAD=P.ENTIDAD \nAND A.UNIDAD_EJECUTORA=P.UNIDAD_EJECUTORA\nAND A.VIGENCIA=P.VIGENCIA\nAND P.TER_ID=S.ID\nAND S.IB_FECHA_FINAL IS NULL \nAND SUBSTR(P.ESTADO,9,1)<>''1''\nAND TO_CHAR(D.FECHA_DILIGENCIAMIENTO, ''YYYYMMDD'') BETWEEN ''20130101'' AND ''20130420''\n', 1, 'N'),
(9, 'disponibilidadPresupuestalxrubro', 'Disponibilidades Presupuestales', 'registro para la generacion del reporte de listado de certificados de disponibilidad presupuestal', 6, 'oracleSIC', 'SELECT DISTINCT\nDISP.VIGENCIA                           AS  VIGENCIA,\nTO_CHAR(DISP.CODIGO_UNIDAD_EJECUTORA)   AS  UNIDAD_EJECUTORA,\nRUB.CODIGO_NIVEL1||''-''||RUB.CODIGO_NIVEL2||''-''||RUB.CODIGO_NIVEL3||''-''||RUB.CODIGO_NIVEL4||''-''||RUB.CODIGO_NIVEL5||''-''||RUB.CODIGO_NIVEL6||''-''||RUB.CODIGO_NIVEL7||''-''||RUB.CODIGO_NIVEL8 CODIGO_RUBRO,\nRUB.DESCRIPCION RUBRO,\nDISP.NUMERO_DISPONIBILIDAD              AS  DISPONIBILIDAD,\nNVL(CDP.VALOR,0)                        AS  VALOR_CDP,\nTO_DATE(DISP.FECHA_REGISTRO,''DD-MM-YY'') AS  FECHA_CDP,\nDISP.OBJETO                             AS  OBJETO,\nDISP.NUM_SOL_ADQ                        AS  SOLICITUD,\nDISP.ESTADO                             AS  ESTADO,\nCASE WHEN NVL(ANULA.VALOR,0)>0 THEN  NVL(CDP.VALOR,0) ELSE NVL(ANULA.VALOR,0) END AS VALOR_ANULADO,\nDECODE(ANULA.FECHA_REGISTRO,'''',''N/A'',ANULA.FECHA_REGISTRO)  AS FECHA_ANULACION,\nNVL(CDP_ANULA.VALOR_ANULADO,0)          AS VALOR_ANULACION_PARCIAL,\nDECODE(CDP_ANULA.FECHA_ANULACION,'''',''N/A'',CDP_ANULA.FECHA_ANULACION)  AS FECHA_ANULACION_PARCIAL\n\n   FROM   PR.PR_DISPONIBILIDADES DISP,\n          PR.PR_DISPONIBILIDAD_RUBRO CDP,\n          PR.PR_ANULACIONES ANULA,\n          PR.PR_CDP_ANULADOS CDP_ANULA,\n          PR.PR_V_RUBROS RUB \n          \n   WHERE  DISP.VIGENCIA                 = CDP.VIGENCIA(+)\n   AND    DISP.CODIGO_COMPANIA          = CDP.CODIGO_COMPANIA(+)\n   AND    DISP.CODIGO_UNIDAD_EJECUTORA  = CDP.CODIGO_UNIDAD_EJECUTORA(+)\n   AND    CDP.VIGENCIA                  = RUB.VIGENCIA \n   AND    CDP.RUBRO_INTERNO             = RUB.INTERNO_RUBRO\n   AND    DISP.NUMERO_DISPONIBILIDAD    = CDP.NUMERO_DISPONIBILIDAD(+)\n   AND    DISP.NUMERO_DISPONIBILIDAD    = ANULA.NUMERO_DOCUMENTO_ANULADO(+)\n   AND    DISP.VIGENCIA                 = ANULA.VIGENCIA(+)\n   AND    DISP.CODIGO_UNIDAD_EJECUTORA  = ANULA.CODIGO_UNIDAD_EJECUTORA(+)\n   AND    DISP.CODIGO_COMPANIA          = ANULA.CODIGO_COMPANIA(+)\n   AND    ANULA.DOCUMENTO_ANULADO(+)    = ''CDP''\n   AND    CDP.VIGENCIA                  = CDP_ANULA.VIGENCIA(+)\n   AND    CDP.CODIGO_COMPANIA           = CDP_ANULA.CODIGO_COMPANIA(+)\n   AND    CDP.CODIGO_UNIDAD_EJECUTORA   = CDP_ANULA.CODIGO_UNIDAD_EJECUTORA(+)\n   AND    CDP.NUMERO_DISPONIBILIDAD     = CDP_ANULA.NUMERO_DISPONIBILIDAD(+)\n   AND    CDP.RUBRO_INTERNO             = CDP_ANULA.RUBRO_INTERNO(+)\n   AND    CDP.CODIGO_COMPANIA=''230''\n   AND DISP.VIGENCIA $P{''vigencia''} \n   AND DISP.CODIGO_UNIDAD_EJECUTORA $P{''unidad''} \n   AND CDP.RUBRO_INTERNO $P{''rubro''}\n   AND DISP.NUMERO_DISPONIBILIDAD $P{''disponibilidad''}\n   ORDER BY VIGENCIA, UNIDAD_EJECUTORA, CODIGO_RUBRO, DISPONIBILIDAD\n   \n', 1, 'S');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `gestion_subsistema`
--

DROP TABLE IF EXISTS `gestion_subsistema`;
CREATE TABLE IF NOT EXISTS `gestion_subsistema` (
  `id_subsistema` int(7) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(250) COLLATE utf8_spanish_ci NOT NULL DEFAULT '',
  `etiqueta` varchar(100) COLLATE utf8_spanish_ci NOT NULL DEFAULT '',
  `id_pagina` int(7) NOT NULL DEFAULT '0',
  `observacion` text COLLATE utf8_spanish_ci,
  PRIMARY KEY (`id_subsistema`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci PACK_KEYS=0 COMMENT='Subsistemas que componen el aplicativo' AUTO_INCREMENT=7 ;

--
-- Volcado de datos para la tabla `gestion_subsistema`
--

INSERT INTO `gestion_subsistema` (`id_subsistema`, `nombre`, `etiqueta`, `id_pagina`, `observacion`) VALUES
(1, 'administrador', 'Administrador', 3, 'Subsistema para la administracion del Sistema'),
(2, 'ordenador', 'Ordenador del Gasto', 8, 'Subsistema para el ordenador del gasto'),
(3, 'supervisor', 'Supervisor', 9, 'Subsistema para la supervisor'),
(4, 'contratista', 'Contratista', 10, 'Subsistema para el contratista'),
(5, 'reportesFinanciero', 'Analista Financiero', 16, 'Subsistema para el asistente del area financiera');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `gestion_valor_sesion`
--

DROP TABLE IF EXISTS `gestion_valor_sesion`;
CREATE TABLE IF NOT EXISTS `gestion_valor_sesion` (
  `id_sesion` varchar(32) COLLATE utf8_spanish_ci NOT NULL DEFAULT '',
  `variable` varchar(20) COLLATE utf8_spanish_ci NOT NULL DEFAULT '',
  `valor` text COLLATE utf8_spanish_ci NOT NULL,
  `expiracion` varchar(20) COLLATE utf8_spanish_ci DEFAULT '',
  `id_usuario` varchar(20) COLLATE utf8_spanish_ci DEFAULT '',
  PRIMARY KEY (`id_sesion`,`variable`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci COMMENT='Valores de sesion';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `gestion_variable`
--

DROP TABLE IF EXISTS `gestion_variable`;
CREATE TABLE IF NOT EXISTS `gestion_variable` (
  `id_tipo` int(4) NOT NULL AUTO_INCREMENT,
  `valor` char(100) COLLATE utf8_spanish_ci NOT NULL,
  `descripcion` char(255) COLLATE utf8_spanish_ci NOT NULL,
  `tipo` char(100) COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`id_tipo`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci ROW_FORMAT=FIXED AUTO_INCREMENT=5 ;

--
-- Volcado de datos para la tabla `gestion_variable`
--

INSERT INTO `gestion_variable` (`id_tipo`, `valor`, `descripcion`, `tipo`) VALUES
(1, 'CEDULA CIUDADANIA', '', 'DOCUMENTO'),
(2, 'CEDULA DE EXTRANJERIA', '', 'DOCUMENTO'),
(3, 'GENERAL', 'Noticias Generales', 'NOTICIA'),
(4, 'DEVOLUCIONES', 'Noticias de devoluciones de tramite', 'NOTICIA');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
