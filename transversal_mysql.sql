-- Database: transversal (MySQL)
-- Generated: 2026-02-17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

-- --------------------------------------------------------

CREATE TABLE `sede` (
  `sede_id` int(11) NOT NULL AUTO_INCREMENT,
  `sede_nombre` varchar(45) NOT NULL,
  `foto` varchar(150) NOT NULL,
  PRIMARY KEY (`sede_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `titulo_programa` (
  `titpro_id` int(11) NOT NULL AUTO_INCREMENT,
  `titpro_nombre` varchar(150) NOT NULL,
  PRIMARY KEY (`titpro_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `centro_formacion` (
  `cent_id` int(11) NOT NULL AUTO_INCREMENT,
  `cent_nombre` varchar(100) NOT NULL,
  PRIMARY KEY (`cent_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `programa` (
  `prog_id` int(11) NOT NULL AUTO_INCREMENT,
  `prog_codigo` int(11) NOT NULL,
  `prog_denominacion` varchar(150) DEFAULT NULL,
  `tit_programa_titpro_id` int(11) NOT NULL,
  `prog_tipo` varchar(30) DEFAULT NULL,
  `sede_sede_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`prog_id`),
  CONSTRAINT `fk_programa_titulo` FOREIGN KEY (`tit_programa_titpro_id`) REFERENCES `titulo_programa` (`titpro_id`),
  CONSTRAINT `fk_programa_sede` FOREIGN KEY (`sede_sede_id`) REFERENCES `sede` (`sede_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `competencia` (
  `comp_id` int(11) NOT NULL AUTO_INCREMENT,
  `comp_nombre_corto` varchar(30) NOT NULL,
  `comp_horas` int(11) NOT NULL,
  `comp_nombre_unidad_competencia` varchar(150) DEFAULT NULL,
  PRIMARY KEY (`comp_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `competxprograma` (
  `programa_prog_id` int(11) NOT NULL,
  `competencia_comp_id` int(11) NOT NULL,
  PRIMARY KEY (`programa_prog_id`,`competencia_comp_id`),
  CONSTRAINT `fk_cp_programa` FOREIGN KEY (`programa_prog_id`) REFERENCES `programa` (`prog_id`),
  CONSTRAINT `fk_cp_competencia` FOREIGN KEY (`competencia_comp_id`) REFERENCES `competencia` (`comp_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `coordinacion` (
  `coord_id` int(11) NOT NULL AUTO_INCREMENT,
  `coord_nombre` varchar(45) NOT NULL,
  `centro_formacion_cent_id` int(11) NOT NULL,
  PRIMARY KEY (`coord_id`),
  CONSTRAINT `fk_coord_centro` FOREIGN KEY (`centro_formacion_cent_id`) REFERENCES `centro_formacion` (`cent_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `instructor` (
  `inst_id` int(11) NOT NULL AUTO_INCREMENT,
  `inst_nombres` varchar(45) NOT NULL,
  `inst_apellidos` varchar(45) NOT NULL,
  `inst_correo` varchar(100) DEFAULT NULL,
  `inst_telefono` bigint(20) DEFAULT NULL,
  `especialidad` varchar(100) NOT NULL,
  `centro_formacion_cent_id` int(11) NOT NULL,
  PRIMARY KEY (`inst_id`),
  CONSTRAINT `fk_inst_centro` FOREIGN KEY (`centro_formacion_cent_id`) REFERENCES `centro_formacion` (`cent_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `ficha` (
  `fich_id` int(11) NOT NULL AUTO_INCREMENT,
  `programa_prog_id` int(11) NOT NULL,
  `instructor_inst_id` int(11) NOT NULL,
  `fich_jornada` varchar(20) DEFAULT NULL,
  `coordinacion_coord_id` int(11) NOT NULL,
  PRIMARY KEY (`fich_id`),
  CONSTRAINT `fk_ficha_programa` FOREIGN KEY (`programa_prog_id`) REFERENCES `programa` (`prog_id`),
  CONSTRAINT `fk_ficha_instructor` FOREIGN KEY (`instructor_inst_id`) REFERENCES `instructor` (`inst_id`),
  CONSTRAINT `fk_ficha_coord` FOREIGN KEY (`coordinacion_coord_id`) REFERENCES `coordinacion` (`coord_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `ambiente` (
  `amb_id` int(11) NOT NULL AUTO_INCREMENT,
  `amb_nombre` varchar(45) NOT NULL,
  `sede_sede_id` int(11) NOT NULL,
  PRIMARY KEY (`amb_id`),
  CONSTRAINT `fk_amb_sede` FOREIGN KEY (`sede_sede_id`) REFERENCES `sede` (`sede_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `asignacion` (
  `asig_id` int(11) NOT NULL AUTO_INCREMENT,
  `instructor_inst_id` int(11) NOT NULL,
  `asig_fecha_ini` datetime NOT NULL,
  `asig_fecha_fin` datetime NOT NULL,
  `ficha_fich_id` int(11) NOT NULL,
  `ambiente_amb_id` int(11) NOT NULL,
  `competencia_comp_id` int(11) NOT NULL,
  PRIMARY KEY (`asig_id`),
  CONSTRAINT `fk_asig_inst` FOREIGN KEY (`instructor_inst_id`) REFERENCES `instructor` (`inst_id`),
  CONSTRAINT `fk_asig_ficha` FOREIGN KEY (`ficha_fich_id`) REFERENCES `ficha` (`fich_id`),
  CONSTRAINT `fk_asig_amb` FOREIGN KEY (`ambiente_amb_id`) REFERENCES `ambiente` (`amb_id`),
  CONSTRAINT `fk_asig_comp` FOREIGN KEY (`competencia_comp_id`) REFERENCES `competencia` (`comp_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `detalle_asignacion` (
  `detasig_id` int(11) NOT NULL AUTO_INCREMENT,
  `asignacion_asig_id` int(11) NOT NULL,
  `detasig_hora_ini` datetime NOT NULL,
  `detasig_hora_fin` datetime NOT NULL,
  PRIMARY KEY (`detasig_id`),
  CONSTRAINT `fk_det_asig` FOREIGN KEY (`asignacion_asig_id`) REFERENCES `asignacion` (`asig_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------
-- VOLCADO DE DATOS (DATA DUMP)
-- --------------------------------------------------------

INSERT INTO `sede` (`sede_id`, `sede_nombre`, `foto`) VALUES
(2, 'CIES', '../../assets/imagenes/sede_699457fce7e5a.jpg'),
(3, 'CEDRUM', '../../assets/imagenes/sede_6994584595a30.jpg'),
(4, 'Calzado', '../../assets/imagenes/sede_69945934760fc.jpg'),
(5, 'Tecno Parque', '../../assets/imagenes/sede_699459ea1b329.jpg');

INSERT INTO `titulo_programa` (`titpro_id`, `titpro_nombre`) VALUES
(1, 'Tecnólogo en Análisis y Desarrollo de Software'),
(2, 'Tecnólogo en Negociación Internacional');

INSERT INTO `centro_formacion` (`cent_id`, `cent_nombre`) VALUES
(1, 'Industria'),
(2, 'Biblioteca');

INSERT INTO `programa` (`prog_id`, `prog_codigo`, `prog_denominacion`, `tit_programa_titpro_id`, `prog_tipo`, `sede_sede_id`) VALUES
(1, 223308, 'ADSO', 1, 'Tecnólogo', 2);

INSERT INTO `competencia` (`comp_id`, `comp_nombre_corto`, `comp_horas`, `comp_nombre_unidad_competencia`) VALUES
(1, 'Etica', 48, 'tguirdñjgrigjñtrutrklbmsfgklbfgd');

INSERT INTO `competxprograma` (`programa_prog_id`, `competencia_comp_id`) VALUES
(1, 1);

INSERT INTO `coordinacion` (`coord_id`, `coord_nombre`, `centro_formacion_cent_id`) VALUES
(1, 'TIC', 2),
(2, 'Zapateria', 1);

INSERT INTO `instructor` (`inst_id`, `inst_nombres`, `inst_apellidos`, `inst_correo`, `inst_telefono`, `especialidad`, `centro_formacion_cent_id`) VALUES
(1, 'Mauricio', 'Puentes', 'ejemplo@gmail.com', 8974372385, 'Etica', 2);

INSERT INTO `ficha` (`fich_id`, `programa_prog_id`, `instructor_inst_id`, `fich_jornada`, `coordinacion_coord_id`) VALUES
(3115418, 1, 1, 'Mañana', 1);

INSERT INTO `ambiente` (`amb_id`, `amb_nombre`, `sede_sede_id`) VALUES
(1, '201 Biblioteca', 2),
(2, '202 Bilbioteca', 2),
(3, '404 laboratorio', 3),
(4, '101 investigación', 3),
(5, '300 Costura', 4),
(6, '305 plantillas', 4),
(7, '204 auditorio', 5);

INSERT INTO `asignacion` (`asig_id`, `instructor_inst_id`, `asig_fecha_ini`, `asig_fecha_fin`, `ficha_fich_id`, `ambiente_amb_id`, `competencia_comp_id`) VALUES
(1, 1, '2026-02-17 00:00:00', '2026-02-25 00:00:00', 3115418, 7, 1);

-- Corregir AUTO_INCREMENT para ficha
ALTER TABLE `ficha` AUTO_INCREMENT = 3115419;

COMMIT;
