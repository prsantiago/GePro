-- CREATE DATABASE gepro;

-- USE gepro;

CREATE TABLE profesor(
	id INT NOT NULL auto_increment,
	matricula INT,
    nombre VARCHAR(75),
    apellido VARCHAR(125),
    correo VARCHAR(125),
    contraseña VARCHAR(75),
    universidad VARCHAR(125),
    division VARCHAR(125),
    departamento VARCHAR(125),
    
    PRIMARY KEY(id)
);

CREATE TABLE alumno(
	id INT NOT NULL AUTO_INCREMENT,
    matricula INT,
    nombre VARCHAR(75),
    apellido VARCHAR(125),
	correo VARCHAR(125),
    contraseña VARCHAR(255),
    universidad VARCHAR(125),
    division VARCHAR(125),
    carrera VARCHAR(125),
    id_estado INT,
    
    PRIMARY KEY(id)
);

CREATE TABLE proyecto_vigente(
	id INT NOT NULL AUTO_INCREMENT,
    id_asesor1 INT,
    id_asesor2 INT,
    id_alumno INT,
    nombre VARCHAR(125),
    fechaInicio DATE,
    fechaFin DATE,
    descripcion VARCHAR(255),
    clave VARCHAR(10),
    
    PRIMARY KEY(id)
);

CREATE TABLE proyecto_historico(
	id INT NOT NULL AUTO_INCREMENT,
    id_asesor1 INT,
    id_asesor2 INT,
    id_alumno INT,
    nombre VARCHAR(125),
    fechaInicio DATE,
    fechaFin DATE,
    descripcion VARCHAR(255),
    clave VARCHAR(10),
    
    PRIMARY KEY(id)
);

CREATE TABLE seguimiento_vigente(
	id INT NOT NULL AUTO_INCREMENT,
    id_proyecto INT,
    entrega DATE,
    proxima_entrega DATE,
    id_entrega INT,
    id_proceso INT,

	PRIMARY KEY(id)
);

CREATE TABLE seguimiento_historico(
	id INT NOT NULL AUTO_INCREMENT,
    id_proyecto INT,
    entrega DATE,
    proxima_entrega DATE,
    id_entrega INT,
    id_proceso INT,

	PRIMARY KEY(id)
);

CREATE TABLE entrega(
	id INT NOT NULL AUTO_INCREMENT,
    nombre VARCHAR(75),
    
	PRIMARY KEY(id)
);

CREATE TABLE proceso(
	id INT NOT NULL AUTO_INCREMENT,
    nombre VARCHAR(75),
    tiempo_maximo VARCHAR(50),
    responsable INT,
    
	PRIMARY KEY(id)
);

CREATE TABLE estado(
	id INT NOT NULL AUTO_INCREMENT,
    nombre VARCHAR(25),
    
    PRIMARY KEY(id)
);

CREATE TABLE comentario_vigente(
	id INT NOT NULL AUTO_INCREMENT,
    id_seguimiento INT,
    comentario VARCHAR(255),

	PRIMARY KEY(id)
);

CREATE TABLE comentario_historico(
	id INT NOT NULL AUTO_INCREMENT,
    id_seguimiento INT,
    comentario VARCHAR(255),

	PRIMARY KEY(id)
);

-- Llaves foráneas alumno
ALTER TABLE alumno ADD CONSTRAINT FK_estado FOREIGN KEY (id_estado) references estado(id);
-- Llaves foráneas proyecto_vigente
ALTER TABLE proyecto_vigente ADD CONSTRAINT FK_asesor1 FOREIGN KEY (id_asesor1) references profesor(id);
ALTER TABLE proyecto_vigente ADD CONSTRAINT FK_asesor2 FOREIGN KEY (id_asesor2) references profesor(id);
ALTER TABLE proyecto_vigente ADD CONSTRAINT FK_alumno FOREIGN KEY (id_alumno) references alumno(id);
-- Llaves foráneas proyecto_histórico
ALTER TABLE proyecto_historico ADD CONSTRAINT FK_asesor1_historico FOREIGN KEY (id_asesor1) references profesor(id);
ALTER TABLE proyecto_historico ADD CONSTRAINT FK_asesor2_historico FOREIGN KEY (id_asesor2) references profesor(id);
ALTER TABLE proyecto_historico ADD CONSTRAINT FK_alumno_historico FOREIGN KEY (id_alumno) references alumno(id);
-- Llaves foráneas seguimiento_vigente
ALTER TABLE seguimiento_vigente ADD CONSTRAINT FK_proyecto FOREIGN KEY (id_proyecto) references proyecto_vigente(id);
ALTER TABLE seguimiento_vigente ADD CONSTRAINT FK_entrega FOREIGN KEY (id_entrega) references entrega(id);
ALTER TABLE seguimiento_vigente ADD CONSTRAINT FK_proceso FOREIGN KEY (id_proceso) references proceso(id);
-- Llaves foráneas seguimiento_histórico
ALTER TABLE seguimiento_historico ADD CONSTRAINT FK_proyecto_historico FOREIGN KEY (id_proyecto) references proyecto_historico(id);
ALTER TABLE seguimiento_historico ADD CONSTRAINT FK_entrega_historico FOREIGN KEY (id_entrega) references entrega(id);
ALTER TABLE seguimiento_historico ADD CONSTRAINT FK_proceso_historico FOREIGN KEY (id_proceso) references proceso(id);
-- Llaves foráneas comentarios
ALTER TABLE comentario_vigente ADD CONSTRAINT FK_comentario FOREIGN KEY (id_seguimiento) references seguimiento_vigente(id);
ALTER TABLE comentario_historico ADD CONSTRAINT FK_comentario_historico FOREIGN KEY (id_seguimiento) references seguimiento_historico(id);

-- valores a tablas catálogo
INSERT INTO estado VALUES
(NULL, 'Pre-tesista'),(NULL,'Tesista'),(NULL,'Titulado');

INSERT INTO entrega VALUES
(NULL,'Introducción'),
(NULL,'Marco teórico'),
(NULL,'Desarrollo'),
(NULL,'Resultados'),
(NULL,'Tesis integrada');

INSERT INTO proceso VALUES
(NULL,'Entrega','2 semanas',1),
(NULL,'Retroalimentación','1 semana',2),
(NULL,'Aprobación','1 semana',2),
(NULL,'Presentación','2 semanas',1);

/*DELIMITER //
	CREATE PROCEDURE NUEVO_PROYECTO(correo_A1 varchar(125),correoA2 varchar(125),correoAlum varchar(125),
    nombre varchar(125),fechaIni date,fechaFin date, descripcion varchar(75))
	BEGIN
		DECLARE X INT;
        DECLARE Y INT;
        DECLARE Z INT;
		SELECT idProf INTO X FROM Profesor WHERE Profesor.correo = correo_A1;
        SELECT idProf INTO Y FROM Profesor WHERE Profesor.correo = correo_A2;
        SELECT idAlumno INTO Z FROM Alumno WHERE Alumno.correo = correoAlum;
        INSERT INTO proyecto_vigente VALUES (NULL,X,Y,Z,nombre,fechaIni,fechaFin,descripcion);
	END//
 DELIMITER ;  */
