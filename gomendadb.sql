-- phpMyAdmin SQL Dump
-- version 2.10.2
-- http://www.phpmyadmin.net
-- 
-- Servidor: localhost
-- Tiempo de generación: 19-12-2007 a las 14:26:27
-- Versión del servidor: 5.0.45
-- Versión de PHP: 5.2.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

-- 
-- Base de datos: `gomendadb`
-- 

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `categoria`
-- 

CREATE TABLE `categoria` (
  `idcategoria` int(11) NOT NULL auto_increment,
  `nombre` varchar(50) character set utf8 collate utf8_spanish_ci NOT NULL,
  `descripcion` varchar(100) character set utf8 collate utf8_spanish_ci NOT NULL,
  PRIMARY KEY  (`idcategoria`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

-- 
-- Volcar la base de datos para la tabla `categoria`
-- 

INSERT INTO `categoria` VALUES (1, 'Libro', 'Categoría para libros');
INSERT INTO `categoria` VALUES (2, 'Película', 'Categoría para película');
INSERT INTO `categoria` VALUES (3, 'Web', 'Categoría para web');
INSERT INTO `categoria` VALUES (4, 'Serie', 'Categoría para serie');
INSERT INTO `categoria` VALUES (5, 'Radio', 'Categoría para programas de radio');
INSERT INTO `categoria` VALUES (6, 'Podcast', 'Categoría para podcast');
INSERT INTO `categoria` VALUES (7, 'Videojuego', 'Categoría para videojuegos');
INSERT INTO `categoria` VALUES (8, 'Cómic', 'Categoría para cómic');
INSERT INTO `categoria` VALUES (9, 'Viajes', 'Categoría para viajes');
INSERT INTO `categoria` VALUES (10, 'Espectáculo', 'Categoría para cualquier tipo de espectáculo');

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `comentario`
-- 

CREATE TABLE `comentario` (
  `idcomentario` int(11) NOT NULL auto_increment,
  `identrada` int(11) NOT NULL default '0',
  `texto` text character set utf8 collate utf8_spanish_ci NOT NULL,
  `fecha` datetime NOT NULL default '0000-00-00 00:00:00',
  `idusuario` int(11) NOT NULL,
  PRIMARY KEY  (`idcomentario`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- 
-- Volcar la base de datos para la tabla `comentario`
-- 


-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `configuracion`
-- 

CREATE TABLE `configuracion` (
  `nombre` varchar(20) character set utf8 collate utf8_spanish_ci NOT NULL,
  `valor` text character set utf8 collate utf8_spanish_ci NOT NULL,
  PRIMARY KEY  (`nombre`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- 
-- Volcar la base de datos para la tabla `configuracion`
-- 

INSERT INTO `configuracion` VALUES ('titulo', 'Pello.info');
INSERT INTO `configuracion` VALUES ('pie', 'Dordoka, sistema de blog desarrollado corriendo y mal por un servidor basado en uno de tantos frameworks propios');
INSERT INTO `configuracion` VALUES ('paginacion', '3');
INSERT INTO `configuracion` VALUES ('colorfondo', 'black');
INSERT INTO `configuracion` VALUES ('enlaces', '<ul>\r\n<li><a href="http://alviento.cuatrovientos.org" _base_href="http://www.pello.info/">Al Viento</a></li><li>\r\n<a href="http://aula0.cuatrovientos.org" _base_href="http://www.pello.info/">Aula0</a></li><li>\r\n<a href="http://www.marrapuntu.org" _base_href="http://www.pello.info/">Marrapuntu</a></li><li>\r\n<a href="http://www.nafarroa.org" _base_href="http://www.pello.info/">Nafarroa.org</a></li><li>\r\n<a href="http://www.santirivas.info" _base_href="http://www.pello.info/">Santi Rivas</a></li><li>\r\n<a href="http://www.nightlight.biz" _base_href="http://www.pello.info/">Nightlight</a></li><li>\r\n<a href="http://blog.txipinet.com" _base_href="http://www.pello.info/">TxipiNet</a></li><li>\r\n<a href="http://www.hackresi.net" _base_href="http://www.pello.info/">Hacklab Iruña</a></li><li>\r\n\r\n<a href="http://www.jonvillate.com" _base_href="http://www.pello.info/">Jon Villate</a></li><li>\r\n<a href="http://www.tranze.com" _base_href="http://www.pello.info/">Tranze</a></li><li>\r\n<a href="http://www.gruslin.com" _base_href="http://www.pello.info/">Gruslin</a></li><li>\r\n<a href="http://www.acidonitrix.com" _base_href="http://www.pello.info/">Acidonitrix</a></li><li>\r\n<a href="http://www.simbiontes.com" _base_href="http://www.pello.info/">Simbiontes</a></li><li>\r\n<a href="http://juanfelipe.diginet.com.co/" _base_href="http://www.pello.info/">Juan Felipe</a></li><li>\r\n<a href="http://www.sala13.es/" _base_href="http://www.pello.info/">Sala 13</a></li>\r\n</ul>');
INSERT INTO `configuracion` VALUES ('tagline', 'Estoy en obras con un gestor de contenidos propio. Perdone las disculpas<a title=''El gran Erik''>&trade;</a>.');
INSERT INTO `configuracion` VALUES ('links', '    <h3 class="title">Links</h3>\r\n    <div class="content">    <table _base_href="http://www.pello.info/" border="0" cellpadding="0" cellspacing="0">\r\n              <tbody _base_href="http://www.pello.info/"><tr _base_href="http://www.pello.info/"> \r\n                <td class="td_titulo" _base_href="http://www.pello.info/"> \r\n                  <div align="center"><a href="/?q=node/view/2" _base_href="http://www.pello.info/"><font color="#666666">Proyectos</font></a></div>\r\n                </td>\r\n                <td rowspan="21" _base_href="http://www.pello.info/" align="left" valign="top"> \r\n                  <p>&nbsp;</p>\r\n\r\n                </td>\r\n              </tr>\r\n              <tr _base_href="http://www.pello.info/"> \r\n                <td _base_href="http://www.pello.info/">‡ <a href="/?q=node/view/6" _base_href="http://www.pello.info/"><font color="#000000">Fin de carrera</font></a></td>\r\n              </tr>\r\n              <tr _base_href="http://www.pello.info/">\r\n                <td _base_href="http://www.pello.info/">‡ <a href="/sendmailizer/index.html" _base_href="http://www.pello.info/"><font color="#000000">Sendmailizer</font></a></td>\r\n\r\n              </tr>\r\n              <tr _base_href="http://www.pello.info/">\r\n                <td _base_href="http://www.pello.info/">‡ <a href="/?q=node/view/15" _base_href="http://www.pello.info/"><font color="#000000">Webmin theme</font></a></td>\r\n              </tr>\r\n              <tr _base_href="http://www.pello.info/"> \r\n                <td class="td_titulo" _base_href="http://www.pello.info/"> \r\n                  <div align="center"><a href="/?q=node/view/1" _base_href="http://www.pello.info/"><font color="#666666">Manuales</font></a></div>\r\n                </td>\r\n\r\n              </tr>\r\n              <tr _base_href="http://www.pello.info/"> \r\n                <td _base_href="http://www.pello.info/">‡ <a href="/?q=node/view/1#struts" _base_href="http://www.pello.info/"><font color="#000000">Struts</font></a></td>\r\n              </tr>\r\n              <tr _base_href="http://www.pello.info/"> \r\n                <td _base_href="http://www.pello.info/">‡ <a href="/?q=node/view/6" _base_href="http://www.pello.info/"><font color="#000000">Jini</font></a></td>\r\n              </tr>\r\n              <tr _base_href="http://www.pello.info/"> \r\n                <td _base_href="http://www.pello.info/">‡ <a href="/?q=node/view/1#iptables" _base_href="http://www.pello.info/"><font color="#000000">IPTables</font></a></td>\r\n\r\n              </tr>\r\n              <tr _base_href="http://www.pello.info/"> \r\n                <td _base_href="http://www.pello.info/">‡ <a href="/?q=node/view/1#cpp" _base_href="http://www.pello.info/"><font color="#000000">C++</font></a></td>\r\n              </tr>\r\n <tr _base_href="http://www.pello.info/"> \r\n                <td _base_href="http://www.pello.info/">‡ <a href="/?q=node/view/1#html" _base_href="http://www.pello.info/"><font color="#000000">HTML</font></a></td>\r\n              </tr>\r\n              <tr _base_href="http://www.pello.info/"> \r\n                <td _base_href="http://www.pello.info/">‡ <a href="/?q=node/view/1#linux" _base_href="http://www.pello.info/"><font color="#000000">Linux</font></a></td>\r\n\r\n              </tr>\r\n              <tr _base_href="http://www.pello.info/"> \r\n                <td _base_href="http://www.pello.info/">‡ <a href="/?q=node/view/1#guias" _base_href="http://www.pello.info/"><font color="#000000">Guías!!</font></a></td>\r\n              </tr>\r\n              <tr _base_href="http://www.pello.info/"> \r\n                <td class="td_titulo" _base_href="http://www.pello.info/"> \r\n                  <div align="center"><a href="/?q=node/view/4" _base_href="http://www.pello.info/"><font color="#666666">CV</font></a></div>\r\n                </td>\r\n              </tr>\r\n\r\n              <tr _base_href="http://www.pello.info/"> \r\n                <td _base_href="http://www.pello.info/"> ‡ <a href="/?q=node/view/4" _base_href="http://www.pello.info/"><font color="#000000">Datos</font></a></td>\r\n              </tr>\r\n              <tr _base_href="http://www.pello.info/"> \r\n                <td _base_href="http://www.pello.info/">‡ <a href="/?q=node/view/4" _base_href="http://www.pello.info/"><font color="#000000">Estudios</font></a></td>\r\n              </tr>\r\n              <tr _base_href="http://www.pello.info/"> \r\n                <td _base_href="http://www.pello.info/">‡ <a href="/?q=node/view/4" _base_href="http://www.pello.info/"><font color="#000000">Idiomas</font></a></td>\r\n\r\n              </tr>\r\n              <tr _base_href="http://www.pello.info/"> \r\n                <td _base_href="http://www.pello.info/">‡ <a href="/?q=node/view/4" _base_href="http://www.pello.info/"><font color="#000000">Cursos</font></a></td>\r\n              </tr>\r\n              <tr _base_href="http://www.pello.info/"> \r\n                <td _base_href="http://www.pello.info/">‡ <a href="/?q=node/view/4" _base_href="http://www.pello.info/"><font color="#000000">Experiencia</font></a></td>\r\n              </tr>\r\n              <tr _base_href="http://www.pello.info/"> \r\n                <td _base_href="http://www.pello.info/"> \r\n                  <div align="center"><a href="/?q=node/view/5" _base_href="http://www.pello.info/"><font color="#666666">Fotografía</font></a></div>\r\n\r\n                </td>\r\n              </tr>\r\n              <tr _base_href="http://www.pello.info/"> \r\n                <td _base_href="http://www.pello.info/">‡ <a href="/?q=node/view/5" _base_href="http://www.pello.info/"><font color="#000000">Color</font></a></td>\r\n              </tr>\r\n              <tr _base_href="http://www.pello.info/"> \r\n                <td _base_href="http://www.pello.info/">‡ <a href="/argazkiak/ibiza/" _base_href="http://www.pello.info/"><font color="#000000">Ibiza</font></a></td>\r\n              </tr>\r\n\r\n              <tr _base_href="http://www.pello.info/"> \r\n                <td _base_href="http://www.pello.info/">‡ <a href="/argazkiak/sanfermin2004/" _base_href="http://www.pello.info/"><font color="#000000">SanFermin</font></a></td>\r\n              </tr>\r\n              <tr _base_href="http://www.pello.info/"> \r\n                <td _base_href="http://www.pello.info/">‡ <a href="http://www.nafarroa.org" _base_href="http://www.pello.info/"><font color="#000000">Nafarroa/Navarra</font></a></td>\r\n              </tr>\r\n              <tr _base_href="http://www.pello.info/"> \r\n                <td _base_href="http://www.pello.info/">‡ <a href="/?q=node/view/5" _base_href="http://www.pello.info/"><font color="#000000">B/N</font></a></td>\r\n\r\n              </tr>\r\n              <tr _base_href="http://www.pello.info/"> \r\n                <td _base_href="http://www.pello.info/"> \r\n                  <div align="center"><a href="/?q=node/view/3" _base_href="http://www.pello.info/"><font color="#666666">Dibujos</font></a></div>\r\n                </td>\r\n              </tr>\r\n              <tr _base_href="http://www.pello.info/"> \r\n                <td _base_href="http://www.pello.info/">‡ <a href="/??q=node/view/7" _base_href="http://www.pello.info/"><font color="#000000">Cómics</font></a></td>\r\n              </tr>\r\n\r\n              <tr _base_href="http://www.pello.info/"> \r\n                <td _base_href="http://www.pello.info/">‡ <a href="/?q=node/view/8" _base_href="http://www.pello.info/"><font color="#000000">Misc</font></a></td>\r\n              </tr>\r\n            </tbody></table></div>\r\n');

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `entrada`
-- 

CREATE TABLE `entrada` (
  `identrada` int(11) NOT NULL auto_increment,
  `titulo` varchar(50) character set utf8 collate utf8_spanish_ci NOT NULL,
  `texto` text character set utf8 collate utf8_spanish_ci NOT NULL,
  `lecturas` int(11) NOT NULL default '0',
  `timestamp` int(11) NOT NULL default '0',
  `idcategoria` smallint(6) NOT NULL default '0',
  `idusuario` int(11) NOT NULL,
  `semaforo` tinyint(4) NOT NULL default '1',
  PRIMARY KEY  (`identrada`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- 
-- Volcar la base de datos para la tabla `entrada`
-- 


-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `entrada_tag`
-- 

CREATE TABLE `entrada_tag` (
  `identrada` int(11) NOT NULL default '0',
  `idtag` int(11) NOT NULL default '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- 
-- Volcar la base de datos para la tabla `entrada_tag`
-- 


-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `tag`
-- 

CREATE TABLE `tag` (
  `idtag` int(11) NOT NULL auto_increment,
  `nombre` varchar(60) character set utf8 collate utf8_spanish_ci NOT NULL,
  `descripcion` varchar(128) character set utf8 collate utf8_spanish_ci NOT NULL,
  PRIMARY KEY  (`idtag`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- 
-- Volcar la base de datos para la tabla `tag`
-- 


-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `tbl_funcionalidad`
-- 

CREATE TABLE `tbl_funcionalidad` (
  `idfuncionalidad` int(11) NOT NULL auto_increment,
  `nombre` varchar(50) character set utf8 collate utf8_spanish_ci NOT NULL,
  `link` varchar(50) character set utf8 collate utf8_spanish_ci NOT NULL,
  PRIMARY KEY  (`idfuncionalidad`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

-- 
-- Volcar la base de datos para la tabla `tbl_funcionalidad`
-- 

INSERT INTO `tbl_funcionalidad` VALUES (1, 'ap_crearentrada', 'ap_crearentrada');
INSERT INTO `tbl_funcionalidad` VALUES (2, 'ap_editarentrada', 'ap_editarentrada');
INSERT INTO `tbl_funcionalidad` VALUES (3, 'ap_eliminarentrada', 'ap_eliminarentrada');
INSERT INTO `tbl_funcionalidad` VALUES (4, 'ap_eliminarcomentario', 'ap_eliminarcomentario');

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `tbl_session`
-- 

CREATE TABLE `tbl_session` (
  `idsession` varchar(100) character set utf8 collate utf8_spanish_ci NOT NULL,
  `idusuario` int(11) NOT NULL,
  `inicio` datetime NOT NULL default '0000-00-00 00:00:00',
  `fin` datetime default NULL,
  `activa` int(11) NOT NULL default '0',
  `clave` varchar(16) character set utf8 collate utf8_spanish_ci default NULL,
  `logincifrado` varchar(40) character set utf8 collate utf8_spanish_ci default NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- 
-- Volcar la base de datos para la tabla `tbl_session`
-- 

INSERT INTO `tbl_session` VALUES ('MjYxMTQxNTEyMzg1Mjg6MTI3LjAuMC4x', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 'ODU=', 'pello');
INSERT INTO `tbl_session` VALUES ('MTIxNjMyMTc2MDI0ODg5OjEyNy4wLjAuMQ==', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 'MTcwODg=', 'pello');
INSERT INTO `tbl_session` VALUES ('OTIxNDI2NDYzOTY0NDoxMjcuMC4wLjE=', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 'MTYwMTU=', 'pello');
INSERT INTO `tbl_session` VALUES ('MjAzMDMxNzU2OTE4OToxMjcuMC4wLjE=', 0, '0000-00-00 00:00:00', NULL, 1, 'MzA3MA==', 'pello');
INSERT INTO `tbl_session` VALUES ('MjY1Mjg1NDkxMTgzNDoxMjcuMC4wLjE=', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 'OTA0Mw==', 'pello');
INSERT INTO `tbl_session` VALUES ('MTE0NzU0MTEyMjYzNzc6MTI3LjAuMC4x', 0, '0000-00-00 00:00:00', NULL, 1, 'MjQ5MjM=', 'pello');

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `tbl_usuario_funcionalidad`
-- 

CREATE TABLE `tbl_usuario_funcionalidad` (
  `idusuario` int(11) NOT NULL,
  `idfuncionalidad` int(11) NOT NULL default '0',
  UNIQUE KEY `login` (`idusuario`,`idfuncionalidad`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- 
-- Volcar la base de datos para la tabla `tbl_usuario_funcionalidad`
-- 

INSERT INTO `tbl_usuario_funcionalidad` VALUES (0, 1);
INSERT INTO `tbl_usuario_funcionalidad` VALUES (0, 2);
INSERT INTO `tbl_usuario_funcionalidad` VALUES (0, 3);
INSERT INTO `tbl_usuario_funcionalidad` VALUES (0, 4);

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `usuarios`
-- 

CREATE TABLE `usuarios` (
  `idusuario` int(11) NOT NULL auto_increment,
  `login` varchar(20) character set utf8 collate utf8_spanish_ci NOT NULL,
  `password` varchar(40) character set utf8 collate utf8_spanish_ci NOT NULL,
  `email` varchar(50) character set utf8 collate utf8_spanish_ci default NULL,
  PRIMARY KEY  (`idusuario`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=93 ;

-- 
-- Volcar la base de datos para la tabla `usuarios`
-- 

INSERT INTO `usuarios` VALUES (1, 'pello', '21232f297a57a5a743894a0e4a801fc3', 'imalamah@luser.net');
INSERT INTO `usuarios` VALUES (92, 'tesTi', '32d63fb642d4f0cd9418bef108e1956b', 'test@er.com');
INSERT INTO `usuarios` VALUES (91, 'test', '066a8d4450de99e081cfe4d332b7cbfd', 'test@er.com');
INSERT INTO `usuarios` VALUES (90, 'test', '48a8114dbe7d91f249ed003dca4c8d18', 'test@er.com');
INSERT INTO `usuarios` VALUES (89, 'juan', '4944fcde6ddcb7104290862b5ef08bc7', 'juanito@gmail.com');
