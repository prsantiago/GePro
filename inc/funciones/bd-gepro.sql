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
    comentarioFinal VARCHAR(255),
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
    comentarioFinal VARCHAR(255),
    clave VARCHAR(10),
    
    PRIMARY KEY(id)
);

CREATE TABLE seguimiento_vigente(
    id INT NOT NULL AUTO_INCREMENT,
    id_proyecto INT,
    fecha_entrega DATE,
    proxima_entrega DATE,
    id_etapa INT,
    id_actividad INT,

    PRIMARY KEY(id)
);

CREATE TABLE seguimiento_historico(
    id INT NOT NULL AUTO_INCREMENT,
    id_proyecto INT,
    fecha_entrega DATE,
    proxima_entrega DATE,
    id_etapa INT,
    id_actividad INT,

    PRIMARY KEY(id)
);

CREATE TABLE etapa(
	id INT NOT NULL AUTO_INCREMENT,
    nombre VARCHAR(75),
    
	PRIMARY KEY(id)
);

CREATE TABLE actividad(
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

CREATE TABLE comentario(
    id INT NOT NULL AUTO_INCREMENT,
    id_proyecto INT,
    id_etapa INT,
    id_actividad INT,
    nombre VARCHAR(75),
    apellido VARCHAR(125),
    comentario VARCHAR(255),
    fecha datetime,

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
ALTER TABLE seguimiento_vigente ADD CONSTRAINT FK_etapa FOREIGN KEY (id_etapa) references etapa(id);
ALTER TABLE seguimiento_vigente ADD CONSTRAINT FK_act FOREIGN KEY (id_actividad) references actividad(id);
-- Llaves foráneas seguimiento_histórico
ALTER TABLE seguimiento_historico ADD CONSTRAINT FK_proyecto_historico FOREIGN KEY (id_proyecto) references proyecto_historico(id);
ALTER TABLE seguimiento_historico ADD CONSTRAINT FK_etapa_historico FOREIGN KEY (id_etapa) references etapa(id);
ALTER TABLE seguimiento_historico ADD CONSTRAINT FK_act_historico FOREIGN KEY (id_actividad) references actividad(id);
-- Llaves foráneas comentarios
ALTER TABLE comentario ADD CONSTRAINT FK_comen_proy FOREIGN KEY (id_proyecto) references proyecto_vigente(id);
ALTER TABLE comentario ADD CONSTRAINT FK_comen_et FOREIGN KEY (id_etapa) references etapa(id);
ALTER TABLE comentario ADD CONSTRAINT FK_comen_act FOREIGN KEY (id_actividad) references actividad(id);

-- valores a tablas catálogo
INSERT INTO estado VALUES
(NULL, 'Pre-tesista'),(NULL,'Tesista'),(NULL,'Titulado');

INSERT INTO etapa VALUES
(NULL,'Introducción'),
(NULL,'Marco teórico'),
(NULL,'Desarrollo'),
(NULL,'Resultados'),
(NULL,'Tesis integrada');

INSERT INTO actividad VALUES
(NULL,'Entrega','2 semanas',1),
(NULL,'Retroalimentación','1 semana',2),
(NULL,'Aprobación','1 semana',2),
(NULL,'Presentación','2 semanas',1);

DELIMITER //
    CREATE PROCEDURE NUEVO_SEGUIMIENTO(idSeg int,idProy int, id_etapa int,id_actividad int,fecha date,com varchar(255),aprobado bool)
    BEGIN
        DECLARE X DATE;
        DECLARE Y INT;
        IF (aprobado = false) THEN
            IF (id_actividad = 1) THEN
                SELECT DATE_ADD(fecha, INTERVAL 14 DAY) INTO X;
                INSERT INTO seguimiento_vigente VALUES (NULL,idProy,NULL,X,id_etapa,2);
            ELSE
                SELECT DATE_ADD(fecha, INTERVAL 7 DAY) INTO X;  
                INSERT INTO seguimiento_vigente VALUES (NULL,idProy,NULL,X,id_etapa,1);
            END IF;
            UPDATE seguimiento_vigente SET fecha_entrega = fecha WHERE id=idSeg; 
        ELSE
            SELECT DATE_ADD(fecha, INTERVAL 14 DAY) INTO X;
            IF (id_etapa <= 4) THEN
                INSERT INTO seguimiento_vigente VALUES (NULL,idProy,NULL,X,id_etapa+1,1);
                UPDATE seguimiento_vigente SET fecha_entrega = fecha,id_actividad = 3 WHERE id=idSeg; 
            ELSE
                IF (id_actividad = 4) THEN
                    UPDATE seguimiento_vigente SET fecha_entrega = fecha WHERE id=idSeg; 
                    UPDATE proyecto_vigente SET fechaFin = fecha,comentarioFinal = com WHERE id=idProy; 
                    -- CALL HISTORICOS(idProy);
                ELSE
                    INSERT INTO seguimiento_vigente VALUES (NULL,idProy,NULL,X,id_etapa,4);
                    UPDATE seguimiento_vigente SET fecha_entrega = fecha,id_actividad = 3 WHERE id=idSeg; 
                END IF;
            END IF;
        END IF;
    END//
 DELIMITER ; 

 DELIMITER //
    CREATE PROCEDURE FINALIZAR_PROYECTO(idProy int)
    BEGIN
        DECLARE X INT;
        DECLARE Y INT;
        SELECT id_alumno INTO X FROM proyecto_vigente WHERE id = idProy;
        SELECT id_estado INTO Y FROM alumno WHERE id = X; 
        IF (Y = 1) THEN
            UPDATE alumno SET id_estado = 2 WHERE id = X;
        ELSE 
            UPDATE alumno SET id_estado = 3 WHERE id = X;
        END IF;
        INSERT INTO proyecto_historico SELECT * FROM proyecto_vigente WHERE id = idProy;
        INSERT INTO seguimiento_historico SELECT * FROM seguimiento_vigente WHERE id_proyecto = idProy;
        DELETE FROM seguimiento_vigente WHERE id_proyecto = idProy; 
        DELETE FROM comentario WHERE id_proyecto = idProy;
        DELETE FROM proyecto_vigente WHERE id = idProy;
    END//
DELIMITER ;

DELIMITER //
    CREATE PROCEDURE NUEVO_COMENTARIO(nombre_usuario varchar(75),apellido_usuario varchar(75), 
                                        id_proy int, id_etapa int, id_actividad int, comentario varchar(255))
    BEGIN
        INSERT INTO comentario
        VALUES (NULL, id_proy, id_etapa, id_actividad, nombre_usuario, apellido_usuario, comentario, NOW());
    END//
DELIMITER ; 

DELIMITER //
    CREATE PROCEDURE BORRAR_PROYECTO(idProyecto int)
    BEGIN
        DELETE FROM comentario WHERE id_proyecto = idProyecto;
        DELETE FROM seguimiento_vigente WHERE id_proyecto = idProyecto;
        DELETE FROM proyecto_vigente WHERE id = idProyecto;
    END//
 DELIMITER ;

DELIMITER //
	CREATE PROCEDURE OBTENER_DETALLES_PROYECTO(id_asesor int)
	BEGIN
		SELECT 
		proyecto_vigente.id,
        proyecto_vigente.clave,
        proyecto_vigente.proyecto,
        alumno.nombre,
        alumno.apellido
    FROM
        ((profesor INNER JOIN proyecto_vigente ON proyecto_vigente.id_asesor1=profesor.id) INNER JOIN
        alumno ON proyecto_vigente.id_alumno=alumno.id)
    WHERE
        profesor.id = id_asesor;
	END//
DELIMITER ;

DELIMITER //
    CREATE PROCEDURE NUEVO_PROYECTO(id_asesor1 int, id_asesor2 int, id_alumno int, nombre_proyecto varchar(125),
                                    fecha varchar(100), descripcion varchar(255), universidad_alumno varchar(10), clave_proy varchar(25))
    BEGIN
        INSERT INTO proyecto_vigente (id_asesor1, id_asesor2, id_alumno, proyecto, fechaInicio, descripcion, clave) 
        VALUES (id_asesor1, id_asesor2, id_alumno, nombre_proyecto, fecha, descripcion, clave_proy);
        
        SELECT @max_proyecto:=MAX(id) from proyecto_vigente;
        SELECT @fechaInicio:=fechaInicio FROM proyecto_vigente WHERE id = @max_proyecto;
        SELECT @fechaEntrega:=DATE_ADD(@fechaInicio, INTERVAL 14 DAY);  
        INSERT INTO seguimiento_vigente VALUES (NULL,@max_proyecto,NULL,@fechaEntrega,1,1);
    END//
 DELIMITER ;   

DELIMITER //
    CREATE PROCEDURE NUEVA_PASSWORD(pwd varchar(255),_correo varchar(50))
    BEGIN
        DECLARE X INT;
        DECLARE Y INT;
        SELECT id INTO X FROM profesor WHERE correo = _correo;
        SELECT IFNULL(X,2) INTO Y;
        IF (Y = 2) THEN
            SELECT id INTO X FROM alumno WHERE correo = _correo;
            UPDATE alumno SET contraseña = pwd WHERE id = X;
        ELSE
            UPDATE profesor SET contraseña = pwd WHERE id = X;
        END IF;
    END//
 DELIMITER ;