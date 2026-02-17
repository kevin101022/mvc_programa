-- ===============================
-- TABLA TITULO_PROGRAMA
-- ===============================
CREATE TABLE titulo_programa (
    titpro_id SERIAL PRIMARY KEY,
    titpro_nombre VARCHAR(150) NOT NULL
);

-- ===============================
-- TABLA PROGRAMA
-- ===============================
CREATE TABLE programa (
    prog_id SERIAL PRIMARY KEY,
    prog_codigo INT NOT NULL,
    tit_programa_titpro_id INT NOT NULL,
    prog_tipo VARCHAR(30),
    sede_sede_id INT,
    CONSTRAINT fk_programa_titulo
        FOREIGN KEY (tit_programa_titpro_id)
        REFERENCES titulo_programa(titpro_id),
    CONSTRAINT fk_programa_sede
        FOREIGN KEY (sede_sede_id)
        REFERENCES sede(sede_id)
);

-- ===============================
-- TABLA COMPETENCIA
-- ===============================
CREATE TABLE competencia (
    comp_id SERIAL PRIMARY KEY,
    comp_nombre_corto VARCHAR(30) NOT NULL,
    comp_horas INT NOT NULL,
    comp_nombre_unidad_competencia VARCHAR(150)
);

-- ===============================
-- TABLA COMPETxPROGRAMA
-- ===============================
CREATE TABLE competxprograma (
    programa_prog_id INT NOT NULL,
    competencia_comp_id INT NOT NULL,
    PRIMARY KEY (programa_prog_id, competencia_comp_id),
    CONSTRAINT fk_cp_programa
        FOREIGN KEY (programa_prog_id)
        REFERENCES programa(prog_id),
    CONSTRAINT fk_cp_competencia
        FOREIGN KEY (competencia_comp_id)
        REFERENCES competencia(comp_id)
);

-- ===============================
-- TABLA CENTRO_FORMACION
-- ===============================
CREATE TABLE centro_formacion (
    cent_id SERIAL PRIMARY KEY,
    cent_nombre VARCHAR(100) NOT NULL
);

-- ===============================
-- TABLA COORDINACION
-- ===============================
CREATE TABLE coordinacion (
    coord_id SERIAL PRIMARY KEY,
    coord_nombre VARCHAR(45) NOT NULL,
    centro_formacion_cent_id INT NOT NULL,
    CONSTRAINT fk_coord_centro
        FOREIGN KEY (centro_formacion_cent_id)
        REFERENCES centro_formacion(cent_id)
);

-- ===============================
-- TABLA INSTRUCTOR
-- ===============================
CREATE TABLE instructor (
    inst_id SERIAL PRIMARY KEY,
    inst_nombres VARCHAR(45) NOT NULL,
    inst_apellidos VARCHAR(45) NOT NULL,
    inst_correo VARCHAR(45),
    inst_telefono BIGINT,
    inst_especialidad VARCHAR(150),
    centro_formacion_cent_id INT NOT NULL,
    CONSTRAINT fk_inst_centro
        FOREIGN KEY (centro_formacion_cent_id)
        REFERENCES centro_formacion(cent_id)
);

-- ===============================
-- TABLA FICHA
-- ===============================
CREATE TABLE ficha (
    fich_id SERIAL PRIMARY KEY,
    programa_prog_id INT NOT NULL,
    instructor_inst_id INT NOT NULL,
    fich_jornada VARCHAR(20),
    coordinacion_coord_id INT NOT NULL,
    CONSTRAINT fk_ficha_programa
        FOREIGN KEY (programa_prog_id)
        REFERENCES programa(prog_id),
    CONSTRAINT fk_ficha_instructor
        FOREIGN KEY (instructor_inst_id)
        REFERENCES instructor(inst_id),
    CONSTRAINT fk_ficha_coord
        FOREIGN KEY (coordinacion_coord_id)
        REFERENCES coordinacion(coord_id)
);

-- ===============================
-- TABLA SEDE
-- ===============================
CREATE TABLE sede (
    sede_id SERIAL PRIMARY KEY,
    sede_nombre VARCHAR(45) NOT NULL
);

-- ===============================
-- TABLA AMBIENTE (CORREGIDO)
-- ===============================
CREATE TABLE ambiente (
    amb_id SERIAL PRIMARY KEY, -- corregido a INT
    amb_nombre VARCHAR(45) NOT NULL,
    sede_sede_id INT NOT NULL,
    CONSTRAINT fk_amb_sede
        FOREIGN KEY (sede_sede_id)
        REFERENCES sede(sede_id)
);

-- ===============================
-- TABLA ASIGNACION
-- ===============================
CREATE TABLE asignacion (
    asig_id SERIAL PRIMARY KEY,
    instructor_inst_id INT NOT NULL,
    asig_fecha_ini TIMESTAMP NOT NULL,
    asig_fecha_fin TIMESTAMP NOT NULL,
    ficha_fich_id INT NOT NULL,
    ambiente_amb_id INT NOT NULL,
    competencia_comp_id INT NOT NULL,
    CONSTRAINT fk_asig_inst
        FOREIGN KEY (instructor_inst_id)
        REFERENCES instructor(inst_id),
    CONSTRAINT fk_asig_ficha
        FOREIGN KEY (ficha_fich_id)
        REFERENCES ficha(fich_id),
    CONSTRAINT fk_asig_amb
        FOREIGN KEY (ambiente_amb_id)
        REFERENCES ambiente(amb_id),
    CONSTRAINT fk_asig_comp
        FOREIGN KEY (competencia_comp_id)
        REFERENCES competencia(comp_id)
);

-- ===============================
-- TABLA DETALLE_ASIGNACION
-- ===============================
CREATE TABLE detalle_asignacion (
    detasig_id SERIAL PRIMARY KEY,
    asignacion_asig_id INT NOT NULL,
    detasig_hora_ini TIMESTAMP NOT NULL,
    detasig_hora_fin TIMESTAMP NOT NULL,
    CONSTRAINT fk_det_asig
        FOREIGN KEY (asignacion_asig_id)
        REFERENCES asignacion(asig_id)
);
