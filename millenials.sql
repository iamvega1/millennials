-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 06-06-2017 a las 01:15:40
-- Versión del servidor: 10.1.13-MariaDB
-- Versión de PHP: 7.0.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `millenials`
--

DELIMITER $$
--
-- Procedimientos
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `act_usuario` (IN `pUser` VARCHAR(40), IN `pNom` VARCHAR(50), IN `pApat` VARCHAR(50))  NO SQL
BEGIN
  DECLARE nom varchar(50);
    DECLARE pat varchar(40);

    
    SELECT nombre INTO nom from usuarios WHERE usuario = pUser;
    SELECT ape_pat INTO pat from usuarios WHERE usuario = pUser;
  
    IF (pNom <> nom) THEN
  update `usuarios` set `nombre` = pNom where `usuario` = pUser;
  end if;
    
    IF (pApat <> pat) THEN
  update `usuarios` set `ape_pat` = pApat where `usuario` = pUser;
  end if;
    
    COMMIT;

end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ins_cp_ent_mun` (IN `pCp` INT(6), IN `pNomEnt` VARCHAR(100), IN `pNomMun` VARCHAR(100))  NO SQL
    SQL SECURITY INVOKER
BEGIN
  DECLARE cp int;
    DECLARE idEnt int;
    DECLARE idMun int;
    set cp = 0, idEnt = 0, idMun = 0;
    
select `codigo_postal` into cp 
from `codigos_postales` 
WHERE `codigo_postal` = pCp;

IF (cp = 0) THEN     
  select `id_entidad` into idEnt 
    from `entidades` 
    WHERE `nombre` = pNomEnt;

    IF (idEnt = 0) THEN     
        INSERT INTO `entidades` (`nombre`) VALUES (pNomEnt); 
        set idEnt = last_insert_id();  
    END if;

    select `id_municipio` into idMun 
    from `municipios` 
    WHERE `nombre` = pNomMun;

    IF (idMun = 0) THEN     
        INSERT INTO `municipios` (`nombre`, `id_entidad`) VALUES (pNomMun, idEnt);
        set idMun = last_insert_id();
    END if;

     INSERT INTO `codigos_postales` (`codigo_postal`, `id_municipio`) VALUES (pCp, idMun);
END if;    
      
    COMMIT;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ins_usuario` (IN `pUsuario` VARCHAR(40), IN `pId_rol` INT(5), IN `pNombre` VARCHAR(50), IN `pApe_pat` VARCHAR(40), IN `pApe_mat` VARCHAR(40), IN `pPass` VARCHAR(40), IN `pCp` INT(10), IN `pId_sexo` INT(2))  NO SQL
    SQL SECURITY INVOKER
BEGIN
INSERT INTO `usuarios` (`usuario`, `id_rol`, `nombre`, `ape_pat`, `ape_mat`, `password`, `contador`, `codigo_postal`, `id_sexo`) VALUES (pUsuario, pId_rol, pNombre, pApe_pat, pApe_mat, pPass, '0', pCp, pId_sexo);
end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `obt_entidad_municipio` (IN `pCP` INT(6) UNSIGNED)  NO SQL
    SQL SECURITY INVOKER
BEGIN
SELECT 
    e.id_entidad, e.nombre nomEntidad, m.id_municipio, m.nombre nomMunicipio
FROM
    municipios m
    JOIN entidades e
      ON e.id_entidad = m.id_entidad
    JOIN codigos_postales c
    ON m.id_municipio = c.id_municipio
where
  c.codigo_postal = pCP;
END$$

--
-- Funciones
--
CREATE DEFINER=`root`@`localhost` FUNCTION `comp_exist_cp` (`pCp` INT(7)) RETURNS INT(7) NO SQL
    SQL SECURITY INVOKER
BEGIN
  DECLARE cp int;
SELECT
  codigo_postal
    INTO
      cp
FROM 
  codigos_postales
WHERE 
  codigo_postal = pCp;
    RETURN cp;
END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `obt_id_municipio` (`pCodigoPostal` INT(3)) RETURNS INT(11) NO SQL
    SQL SECURITY INVOKER
BEGIN
  DECLARE id int;
    set id = 0;
  SELECT `id_municipio` INTO id FROM `municipios` where `id_municipio` = (
    SELECT `id_municipio` FROM `codigos_postales` WHERE `id_codigo_postal` = pCodigoPostal);
 RETURN id;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `codigos_postales`
--

CREATE TABLE `codigos_postales` (
  `codigo_postal` int(11) NOT NULL,
  `id_municipio` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `codigos_postales`
--

INSERT INTO `codigos_postales` (`codigo_postal`, `id_municipio`) VALUES
(67100, 1),
(67180, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `encuestas`
--

CREATE TABLE `encuestas` (
  `id_encuesta` int(11) NOT NULL,
  `nombre` varchar(60) DEFAULT NULL,
  `descripcion` varchar(100) DEFAULT NULL,
  `usuario` varchar(50) DEFAULT NULL,
  `fecha_crea` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `fecha_mod` date DEFAULT NULL,
  `activa` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `encuestas`
--

INSERT INTO `encuestas` (`id_encuesta`, `nombre`, `descripcion`, `usuario`, `fecha_crea`, `fecha_mod`, `activa`) VALUES
(8, 'hgf', NULL, 'athena', '2017-04-13 18:26:34', NULL, 0),
(9, 'ik', NULL, 'athena', '2017-04-13 18:39:09', NULL, 0),
(10, 'oso', 'hola', 'athena', '2017-04-13 18:42:14', NULL, 0),
(11, 'prueba 1', 'null', 'luis', '2017-04-25 23:53:03', NULL, 0),
(12, 'Prueba 1 encuesta', 'null', 'luis', '2017-04-27 23:48:31', NULL, 0),
(13, 'prueba', 'null', 'luis', '2017-05-18 20:48:49', NULL, 0),
(14, 'prueba2', 'null', 'luis', '2017-05-18 23:44:03', NULL, 0),
(15, 'prueba3', 'null', 'luis', '2017-05-18 23:47:38', NULL, 0),
(16, 'prueba 3', 'null', 'luis', '2017-05-19 00:01:34', NULL, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `encuestas_activas`
--

CREATE TABLE `encuestas_activas` (
  `id_encuesta` int(11) NOT NULL,
  `user` varchar(50) NOT NULL,
  `fecha_crea` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `entidades`
--

CREATE TABLE `entidades` (
  `id_entidad` int(11) NOT NULL,
  `nombre` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `entidades`
--

INSERT INTO `entidades` (`id_entidad`, `nombre`) VALUES
(2, 'Nuevo León');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `municipios`
--

CREATE TABLE `municipios` (
  `id_municipio` int(11) NOT NULL,
  `id_entidad` int(11) NOT NULL,
  `nombre` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `municipios`
--

INSERT INTO `municipios` (`id_municipio`, `id_entidad`, `nombre`) VALUES
(1, 2, 'Guadalupe');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `preguntas`
--

CREATE TABLE `preguntas` (
  `id_pregunta` int(11) NOT NULL,
  `id_encuesta` int(11) DEFAULT NULL,
  `clave` int(11) DEFAULT NULL,
  `pregunta` varchar(200) DEFAULT NULL,
  `descripcion` varchar(200) DEFAULT NULL,
  `id_tipo` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `preguntas`
--

INSERT INTO `preguntas` (`id_pregunta`, `id_encuesta`, `clave`, `pregunta`, `descripcion`, `id_tipo`) VALUES
(1, 10, 1, 'que odias', '', 3),
(2, 11, 1, 'pregunta uno ejemplo opcion multiple', 'NULL', 1),
(5, 11, 2, 'segunda pregunta', NULL, 2),
(6, 12, 1, 'primer pregunta ejemplo uno', 'NULL', 1),
(7, 12, 2, 'pregunta numero dos contenido ejemplo simula el contenido de una pregunta', 'NULL', 2),
(8, 12, 3, 'prueba pregunta tres ejemplo', 'NULL', 3),
(9, 13, 1, ' pregunta uno', 'NULL', 2),
(10, 16, 1, ' pregunta uno', 'NULL', 2),
(11, 16, 2, ' pregunta dos', 'NULL', 1),
(12, 16, 3, ' pregunta tres', 'NULL', 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `resp_pregunta`
--

CREATE TABLE `resp_pregunta` (
  `id_resp` int(11) NOT NULL,
  `id_pregunta` int(11) DEFAULT NULL,
  `clave` int(11) DEFAULT NULL,
  `respuesta` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `resp_pregunta`
--

INSERT INTO `resp_pregunta` (`id_resp`, `id_pregunta`, `clave`, `respuesta`) VALUES
(1, 1, 1, 'bailar'),
(2, 2, 1, 'respuesta uno'),
(3, 2, 2, 'respuesta dos'),
(4, 6, 1, 'respuesta uno'),
(5, 6, 2, 'respuesta dos'),
(6, 6, 3, 'respuesta tres'),
(7, 7, 1, 'respuesta uno mas larga'),
(8, 7, 2, 'respuesta dos extra larga ejemplo'),
(9, 7, 3, 'otra opcion'),
(10, 8, 1, 'respuesta uno ejemplo pregunta tres'),
(11, 8, 2, 'respuesta dos'),
(12, 8, 3, 'respuesta'),
(13, 8, 4, 'respuesta cuatro'),
(14, 9, 1, 'respuesta uno'),
(15, 9, 2, 'respuesta dos'),
(16, 10, 1, 'respuesta uno'),
(17, 10, 2, 'respuesta dos'),
(18, 10, 3, 'respuesta tres'),
(19, 11, 1, 'respuesta uno'),
(20, 11, 2, 'respuesta dos'),
(21, 11, 3, 'respuesta tres'),
(22, 12, 1, 'respuesta uno'),
(23, 12, 2, 'respuesta dos');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `resp_usuario`
--

CREATE TABLE `resp_usuario` (
  `id_resp_user` int(11) NOT NULL,
  `usuario` int(11) DEFAULT NULL,
  `id_resp` int(11) DEFAULT NULL,
  `clave` int(11) DEFAULT NULL,
  `fecha_crea` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `ID_ROL` int(3) NOT NULL,
  `NOMBRE` varchar(50) DEFAULT NULL,
  `DESCRIPCION` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`ID_ROL`, `NOMBRE`, `DESCRIPCION`) VALUES
(1, 'admin', 'administrador con privilegios para crear encuestas y usuarios'),
(2, 'encuestador', 'puede crear encuestas'),
(3, 'encuestado', 'puede responder encuestas');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sexo`
--

CREATE TABLE `sexo` (
  `id_sexo` int(1) NOT NULL,
  `nombre` varchar(20) NOT NULL,
  `abreviatura` varchar(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `sexo`
--

INSERT INTO `sexo` (`id_sexo`, `nombre`, `abreviatura`) VALUES
(1, 'hombre', 'h'),
(2, 'mujer', 'm');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipos_pregunta`
--

CREATE TABLE `tipos_pregunta` (
  `id_tipo` int(11) NOT NULL,
  `DESCRIPCION` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `tipos_pregunta`
--

INSERT INTO `tipos_pregunta` (`id_tipo`, `DESCRIPCION`) VALUES
(1, 'simple'),
(2, 'multiple'),
(3, 'Prioridad'),
(4, 'Mixta');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `usuario` varchar(50) NOT NULL,
  `id_rol` int(3) DEFAULT NULL,
  `nombre` varchar(40) NOT NULL,
  `ape_pat` varchar(20) DEFAULT NULL,
  `ape_mat` varchar(20) DEFAULT NULL,
  `password` varchar(50) NOT NULL,
  `fecha_crea` datetime DEFAULT CURRENT_TIMESTAMP,
  `fecha_ult_ingreso` date DEFAULT NULL,
  `contador` int(11) DEFAULT NULL,
  `codigo_postal` int(11) DEFAULT NULL,
  `id_sexo` int(11) DEFAULT NULL,
  `fecha_nacimiento` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`usuario`, `id_rol`, `nombre`, `ape_pat`, `ape_mat`, `password`, `fecha_crea`, `fecha_ult_ingreso`, `contador`, `codigo_postal`, `id_sexo`, `fecha_nacimiento`) VALUES
('athena', 1, 'athena', 'nieto', 'rivera', 'rivera123', '2017-04-10 17:20:34', '2017-04-10', 1, 67100, 2, '2017-05-03'),
('luis', 1, 'luis', 'vega', 'cortez', 'luis123', '2017-04-10 19:41:01', '2017-06-05', 3, 67180, 1, '2017-05-03'),
('luisq', 2, 'Luis', 'luis', 'luis', 'luis', '2017-05-01 17:43:04', '2017-05-25', 2, 67180, 1, '2017-01-01'),
('prueba', 2, 'prueba', 'prueba', 'prueba', 'prueba', '2017-06-05 18:11:54', NULL, 0, 67180, 1, '2017-06-01'),
('sodelia', 2, 'Lazaro', 'herrera', '1234', '1234', '2017-04-14 19:55:10', NULL, NULL, 67180, 2, '2017-06-06');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `codigos_postales`
--
ALTER TABLE `codigos_postales`
  ADD PRIMARY KEY (`codigo_postal`),
  ADD KEY `fk_id_endidad` (`id_municipio`);

--
-- Indices de la tabla `encuestas`
--
ALTER TABLE `encuestas`
  ADD PRIMARY KEY (`id_encuesta`),
  ADD KEY `fk_usuario` (`usuario`);

--
-- Indices de la tabla `entidades`
--
ALTER TABLE `entidades`
  ADD PRIMARY KEY (`id_entidad`);

--
-- Indices de la tabla `municipios`
--
ALTER TABLE `municipios`
  ADD PRIMARY KEY (`id_municipio`),
  ADD KEY `id_entidad` (`id_entidad`);

--
-- Indices de la tabla `preguntas`
--
ALTER TABLE `preguntas`
  ADD PRIMARY KEY (`id_pregunta`),
  ADD KEY `fk_id_encuesta` (`id_encuesta`),
  ADD KEY `fk_id_tipo` (`id_tipo`);

--
-- Indices de la tabla `resp_pregunta`
--
ALTER TABLE `resp_pregunta`
  ADD PRIMARY KEY (`id_resp`),
  ADD KEY `fk_id_pregunta` (`id_pregunta`);

--
-- Indices de la tabla `resp_usuario`
--
ALTER TABLE `resp_usuario`
  ADD PRIMARY KEY (`id_resp_user`),
  ADD KEY `fk_id_resp` (`id_resp`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`ID_ROL`);

--
-- Indices de la tabla `sexo`
--
ALTER TABLE `sexo`
  ADD PRIMARY KEY (`id_sexo`);

--
-- Indices de la tabla `tipos_pregunta`
--
ALTER TABLE `tipos_pregunta`
  ADD PRIMARY KEY (`id_tipo`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`usuario`),
  ADD KEY `fk_id_rol` (`id_rol`),
  ADD KEY `fk_id_sexo` (`id_sexo`),
  ADD KEY `codigo_postal` (`codigo_postal`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `encuestas`
--
ALTER TABLE `encuestas`
  MODIFY `id_encuesta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT de la tabla `entidades`
--
ALTER TABLE `entidades`
  MODIFY `id_entidad` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT de la tabla `municipios`
--
ALTER TABLE `municipios`
  MODIFY `id_municipio` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `preguntas`
--
ALTER TABLE `preguntas`
  MODIFY `id_pregunta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT de la tabla `resp_pregunta`
--
ALTER TABLE `resp_pregunta`
  MODIFY `id_resp` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;
--
-- AUTO_INCREMENT de la tabla `resp_usuario`
--
ALTER TABLE `resp_usuario`
  MODIFY `id_resp_user` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `sexo`
--
ALTER TABLE `sexo`
  MODIFY `id_sexo` int(1) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `codigos_postales`
--
ALTER TABLE `codigos_postales`
  ADD CONSTRAINT `fk_id_endidad` FOREIGN KEY (`id_municipio`) REFERENCES `municipios` (`id_municipio`);

--
-- Filtros para la tabla `encuestas`
--
ALTER TABLE `encuestas`
  ADD CONSTRAINT `fk_usuario` FOREIGN KEY (`usuario`) REFERENCES `usuarios` (`usuario`);

--
-- Filtros para la tabla `municipios`
--
ALTER TABLE `municipios`
  ADD CONSTRAINT `municipios_ibfk_1` FOREIGN KEY (`id_entidad`) REFERENCES `entidades` (`id_entidad`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `preguntas`
--
ALTER TABLE `preguntas`
  ADD CONSTRAINT `fk_id_tipo` FOREIGN KEY (`id_tipo`) REFERENCES `tipos_pregunta` (`id_tipo`),
  ADD CONSTRAINT `preguntas_ibfk_1` FOREIGN KEY (`id_encuesta`) REFERENCES `encuestas` (`id_encuesta`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `resp_pregunta`
--
ALTER TABLE `resp_pregunta`
  ADD CONSTRAINT `resp_pregunta_ibfk_1` FOREIGN KEY (`id_pregunta`) REFERENCES `preguntas` (`id_pregunta`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `resp_usuario`
--
ALTER TABLE `resp_usuario`
  ADD CONSTRAINT `resp_usuario_ibfk_1` FOREIGN KEY (`id_resp`) REFERENCES `resp_pregunta` (`id_resp`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `fk_id_rol` FOREIGN KEY (`id_rol`) REFERENCES `roles` (`ID_ROL`),
  ADD CONSTRAINT `fk_id_sexo` FOREIGN KEY (`id_sexo`) REFERENCES `sexo` (`id_sexo`),
  ADD CONSTRAINT `usuarios_ibfk_1` FOREIGN KEY (`codigo_postal`) REFERENCES `codigos_postales` (`codigo_postal`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
