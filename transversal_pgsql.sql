x-- Database: transversal (PostgreSQL)
-- Generated: 2026-02-17

-- --------------------------------------------------------

CREATE TABLE sede (
  sede_id SERIAL PRIMARY KEY,
  sede_nombre varchar(45) NOT NULL,
  foto varchar(150) NOT NULL
);

CREATE TABLE titulo_programa (
  titpro_id SERIAL PRIMARY KEY,
  titpro_nombre varchar(150) NOT NULL
);

CREATE TABLE centro_formacion (
  cent_id SERIAL PRIMARY KEY,
  cent_nombre varchar(100) NOT NULL
);

CREATE TABLE programa (
  prog_id SERIAL PRIMARY KEY,
  prog_codigo int NOT NULL,
  prog_denominacion varchar(150) DEFAULT NULL,
  tit_programa_titpro_id int NOT NULL,
  prog_tipo varchar(30) DEFAULT NULL,
  sede_sede_id int DEFAULT NULL,
  CONSTRAINT fk_programa_titulo FOREIGN KEY (tit_programa_titpro_id) REFERENCES titulo_programa (titpro_id),
  CONSTRAINT fk_programa_sede FOREIGN KEY (sede_sede_id) REFERENCES sede (sede_id)
);

CREATE TABLE competencia (
  comp_id SERIAL PRIMARY KEY,
  comp_nombre_corto varchar(30) NOT NULL,
  comp_horas int NOT NULL,
  comp_nombre_unidad_competencia varchar(150) DEFAULT NULL
);

CREATE TABLE competxprograma (
  programa_prog_id int NOT NULL,
  competencia_comp_id int NOT NULL,
  PRIMARY KEY (programa_prog_id, competencia_comp_id),
  CONSTRAINT fk_cp_programa FOREIGN KEY (programa_prog_id) REFERENCES programa (prog_id),
  CONSTRAINT fk_cp_competencia FOREIGN KEY (competencia_comp_id) REFERENCES competencia (comp_id)
);

CREATE TABLE coordinacion (
  coord_id SERIAL PRIMARY KEY,
  coord_nombre varchar(45) NOT NULL,
  centro_formacion_cent_id int NOT NULL,
  CONSTRAINT fk_coord_centro FOREIGN KEY (centro_formacion_cent_id) REFERENCES centro_formacion (cent_id)
);

CREATE TABLE instructor (
  inst_id SERIAL PRIMARY KEY,
  inst_nombres varchar(45) NOT NULL,
  inst_apellidos varchar(45) NOT NULL,
  inst_correo varchar(100) DEFAULT NULL,
  inst_telefono bigint DEFAULT NULL,
  especialidad varchar(100) NOT NULL,
  centro_formacion_cent_id int NOT NULL,
  CONSTRAINT fk_inst_centro FOREIGN KEY (centro_formacion_cent_id) REFERENCES centro_formacion (cent_id)
);

CREATE TABLE ficha (
  fich_id SERIAL PRIMARY KEY,
  programa_prog_id int NOT NULL,
  instructor_inst_id int NOT NULL,
  fich_jornada varchar(20) DEFAULT NULL,
  coordinacion_coord_id int NOT NULL,
  CONSTRAINT fk_ficha_programa FOREIGN KEY (programa_prog_id) REFERENCES programa (prog_id),
  CONSTRAINT fk_ficha_instructor FOREIGN KEY (instructor_inst_id) REFERENCES instructor (inst_id),
  CONSTRAINT fk_ficha_coord FOREIGN KEY (coordinacion_coord_id) REFERENCES coordinacion (coord_id)
);

CREATE TABLE ambiente (
  amb_id SERIAL PRIMARY KEY,
  amb_nombre varchar(45) NOT NULL,
  sede_sede_id int NOT NULL,
  CONSTRAINT fk_amb_sede FOREIGN KEY (sede_sede_id) REFERENCES sede (sede_id)
);

CREATE TABLE asignacion (
  asig_id SERIAL PRIMARY KEY,
  instructor_inst_id int NOT NULL,
  asig_fecha_ini timestamp NOT NULL,
  asig_fecha_fin timestamp NOT NULL,
  ficha_fich_id int NOT NULL,
  ambiente_amb_id int NOT NULL,
  competencia_comp_id int NOT NULL,
  CONSTRAINT fk_asig_inst FOREIGN KEY (instructor_inst_id) REFERENCES instructor (inst_id),
  CONSTRAINT fk_asig_ficha FOREIGN KEY (ficha_fich_id) REFERENCES ficha (fich_id),
  CONSTRAINT fk_asig_amb FOREIGN KEY (ambiente_amb_id) REFERENCES ambiente (amb_id),
  CONSTRAINT fk_asig_comp FOREIGN KEY (competencia_comp_id) REFERENCES competencia (comp_id)
);

CREATE TABLE detalle_asignacion (
  detasig_id SERIAL PRIMARY KEY,
  asignacion_asig_id int NOT NULL,
  detasig_hora_ini timestamp NOT NULL,
  detasig_hora_fin timestamp NOT NULL,
  CONSTRAINT fk_det_asig FOREIGN KEY (asignacion_asig_id) REFERENCES asignacion (asig_id)
);

-- --------------------------------------------------------
-- VOLCADO DE DATOS (DATA DUMP)
-- --------------------------------------------------------

INSERT INTO sede (sede_id, sede_nombre, foto) VALUES
(2, 'CIES', '../../assets/imagenes/sede_699457fce7e5a.jpg'),
(3, 'CEDRUM', '../../assets/imagenes/sede_6994584595a30.jpg'),
(4, 'Calzado', '../../assets/imagenes/sede_69945934760fc.jpg'),
(5, 'Tecno Parque', '../../assets/imagenes/sede_699459ea1b329.jpg');

INSERT INTO titulo_programa (titpro_id, titpro_nombre) VALUES
(1, 'Tecnólogo en Análisis y Desarrollo de Software'),
(2, 'Tecnólogo en Negociación Internacional');

INSERT INTO centro_formacion (cent_id, cent_nombre) VALUES
(1, 'Industria'),
(2, 'Biblioteca');

INSERT INTO programa (prog_id, prog_codigo, prog_denominacion, tit_programa_titpro_id, prog_tipo, sede_sede_id) VALUES
(1, 223308, 'ADSO', 1, 'Tecnólogo', 2);

INSERT INTO competencia (comp_id, comp_nombre_corto, comp_horas, comp_nombre_unidad_competencia) VALUES
(1, 'Etica', 48, 'tguirdñjgrigjñtrutrklbmsfgklbfgd');

INSERT INTO competxprograma (programa_prog_id, competencia_comp_id) VALUES
(1, 1);

INSERT INTO coordinacion (coord_id, coord_nombre, centro_formacion_cent_id) VALUES
(1, 'TIC', 2),
(2, 'Zapateria', 1);

INSERT INTO instructor (inst_id, inst_nombres, inst_apellidos, inst_correo, inst_telefono, especialidad, centro_formacion_cent_id) VALUES
(1, 'Mauricio', 'Puentes', 'ejemplo@gmail.com', 8974372385, 'Etica', 2);

INSERT INTO ficha (fich_id, programa_prog_id, instructor_inst_id, fich_jornada, coordinacion_coord_id) VALUES
(3115418, 1, 1, 'Mañana', 1);

INSERT INTO ambiente (amb_id, amb_nombre, sede_sede_id) VALUES
(1, '201 Biblioteca', 2),
(2, '202 Bilbioteca', 2),
(3, '404 laboratorio', 3),
(4, '101 investigación', 3),
(5, '300 Costura', 4),
(6, '305 plantillas', 4),
(7, '204 auditorio', 5);

INSERT INTO asignacion (asig_id, instructor_inst_id, asig_fecha_ini, asig_fecha_fin, ficha_fich_id, ambiente_amb_id, competencia_comp_id) VALUES
(1, 1, '2026-02-17 00:00:00', '2026-02-25 00:00:00', 3115418, 7, 1);

-- Ajustar las secuencias de PostgreSQL para que no den error al insertar nuevos después del volcado
SELECT setval('sede_sede_id_seq', (SELECT MAX(sede_id) FROM sede));
SELECT setval('titulo_programa_titpro_id_seq', (SELECT MAX(titpro_id) FROM titulo_programa));
SELECT setval('centro_formacion_cent_id_seq', (SELECT MAX(cent_id) FROM centro_formacion));
SELECT setval('programa_prog_id_seq', (SELECT MAX(prog_id) FROM programa));
SELECT setval('competencia_comp_id_seq', (SELECT MAX(comp_id) FROM competencia));
SELECT setval('coordinacion_coord_id_seq', (SELECT MAX(coord_id) FROM coordinacion));
SELECT setval('instructor_inst_id_seq', (SELECT MAX(inst_id) FROM instructor));
SELECT setval('ficha_fich_id_seq', (SELECT MAX(fich_id) FROM ficha));
SELECT setval('ambiente_amb_id_seq', (SELECT MAX(amb_id) FROM ambiente));
SELECT setval('asignacion_asig_id_seq', (SELECT MAX(asig_id) FROM asignacion));
SELECT setval('detalle_asignacion_detasig_id_seq', COALESCE((SELECT MAX(detasig_id) FROM detalle_asignacion), 1));
