CREATE DATABASE deni;
USE deni;

START TRANSACTION;
SET time_zone = "+00:00";

--
-- Table structure for table `profesor`
--

CREATE TABLE profesor(
    id INT NOT NULL auto_increment,
    matricula VARCHAR(25) DEFAULT NULL,
    nombre VARCHAR(50) DEFAULT NULL,
    apellido VARCHAR(50) DEFAULT NULL,
    correo VARCHAR(50) DEFAULT NULL,
    contraseña VARCHAR(255) DEFAULT NULL,
    universidad VARCHAR(10) DEFAULT NULL,
    division VARCHAR(50) DEFAULT NULL,
    departamento VARCHAR(50) DEFAULT NULL,
    
    PRIMARY KEY(id)
)DEFAULT CHARSET=utf8;

--
-- Table structure for table `alumno`
--

CREATE TABLE alumno(
    id INT NOT NULL AUTO_INCREMENT,
    matricula VARCHAR(25) DEFAULT NULL,
    nombre VARCHAR(50) DEFAULT NULL,
    apellido VARCHAR(50) DEFAULT NULL,
    correo VARCHAR(50) DEFAULT NULL,
    contraseña VARCHAR(255) DEFAULT NULL,
    universidad VARCHAR(10) DEFAULT NULL,
    division VARCHAR(50) DEFAULT NULL,
    carrera VARCHAR(50) DEFAULT NULL,
    id_estado INT DEFAULT NULL,
    
    PRIMARY KEY(id)
)DEFAULT CHARSET=utf8;

--
-- Table structure for table `proyecto_vigente`
--

CREATE TABLE proyecto_vigente(
    id INT NOT NULL AUTO_INCREMENT,
    id_asesor1 INT DEFAULT NULL,
    id_asesor2 INT DEFAULT NULL,
    id_alumno INT DEFAULT NULL,
    proyecto VARCHAR(125) DEFAULT NULL,
    fechaInicio DATE DEFAULT NULL,
    fechaFin DATE DEFAULT NULL,
    descripcion VARCHAR(255) DEFAULT NULL,
    comentarioFinal VARCHAR(255) DEFAULT NULL,
    clave VARCHAR(15) DEFAULT NULL,
    
    PRIMARY KEY(id)
)DEFAULT CHARSET=utf8;

--
-- Table structure for table `proyecto_historico`
--

CREATE TABLE proyecto_historico(
    id INT NOT NULL AUTO_INCREMENT,
    id_asesor1 INT DEFAULT NULL,
    id_asesor2 INT DEFAULT NULL,
    id_alumno INT DEFAULT NULL,
    proyecto VARCHAR(125) DEFAULT NULL,
    fechaInicio DATE DEFAULT NULL,
    fechaFin DATE DEFAULT NULL,
    descripcion VARCHAR(255) DEFAULT NULL,
    comentarioFinal VARCHAR(255) DEFAULT NULL,
    clave VARCHAR(15) DEFAULT NULL,
    
    PRIMARY KEY(id)
)DEFAULT CHARSET=utf8;

--
-- Table structure for table `seguimiento_vigente`
--

CREATE TABLE seguimiento_vigente(
    id INT NOT NULL AUTO_INCREMENT,
    id_proyecto INT DEFAULT NULL,
    fecha_entrega DATE DEFAULT NULL,
    proxima_entrega DATE DEFAULT NULL,
    id_etapa INT DEFAULT NULL,
    id_actividad INT DEFAULT NULL,

    PRIMARY KEY(id)
)DEFAULT CHARSET=utf8;

--
-- Table structure for table `seguimiento_historico`
--

CREATE TABLE seguimiento_historico(
    id INT NOT NULL AUTO_INCREMENT,
    id_proyecto INT DEFAULT NULL,
    fecha_entrega DATE DEFAULT NULL,
    proxima_entrega DATE DEFAULT NULL,
    id_etapa INT DEFAULT NULL,
    id_actividad INT DEFAULT NULL,

    PRIMARY KEY(id)
)DEFAULT CHARSET=utf8;

--
-- Table structure for table `etapa`
--

CREATE TABLE etapa(
    id INT NOT NULL AUTO_INCREMENT,
    nombre VARCHAR(20) DEFAULT NULL,
    
    PRIMARY KEY(id)
)DEFAULT CHARSET=utf8;

--
-- Table structure for table `actividad`
--

CREATE TABLE actividad(
    id INT NOT NULL AUTO_INCREMENT,
    nombre varchar(20) DEFAULT NULL,
    tiempo_maximo varchar(20) DEFAULT NULL,
    responsable INT  DEFAULT NULL,
    
    PRIMARY KEY(id)
)DEFAULT CHARSET=utf8;

--
-- Table structure for table `estado`
--

CREATE TABLE estado(
    id INT NOT NULL AUTO_INCREMENT,
    nombre VARCHAR(25) DEFAULT NULL,
    
    PRIMARY KEY(id)
)DEFAULT CHARSET=utf8;

--
-- Table structure for table `comentario`
--

CREATE TABLE comentario(
    id INT NOT NULL AUTO_INCREMENT,
    id_proyecto INT DEFAULT NULL,
    id_etapa INT DEFAULT NULL,
    id_actividad INT DEFAULT NULL,
    nombre VARCHAR(50) DEFAULT NULL,
    apellido VARCHAR(50) DEFAULT NULL,
    comentario VARCHAR(255) DEFAULT NULL,
    fecha datetime DEFAULT NULL,

    PRIMARY KEY(id)
)DEFAULT CHARSET=utf8;

CREATE TABLE clave_password(
    id INT NOT NULL AUTO_INCREMENT,
    correo VARCHAR(50),
    clave VARCHAR(50),
    
    PRIMARY KEY(id)
)DEFAULT CHARSET=utf8;

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

--
-- Dumping data for table `actividad`
--

INSERT INTO actividad (id, nombre, tiempo_maximo, responsable) VALUES
(1, 'Entrega', '2 semanas', 1),
(2, 'Retroalimentación', '1 semana', 2),
(3, 'Aprobación', '1 semana', 2),
(4, 'Presentación', '2 semanas', 1);

--
-- Dumping data for table `estado`
--

INSERT INTO estado (id, nombre) VALUES
(1, 'Pre-tesista'),
(2, 'Tesista'),
(3, 'Titulado');

--
-- Dumping data for table `etapa`
--

INSERT INTO etapa (id, nombre) VALUES
(1, 'Introducción'),
(2, 'Marco teórico'),
(3, 'Desarrollo'),
(4, 'Resultados'),
(5, 'Tesis integrada');

-- --------------------------------------------------------

DELIMITER $$

--
-- Procedures
--

CREATE DEFINER=`root`@`localhost` PROCEDURE `BORRAR_PROYECTO` (`idProyecto` INT)  BEGIN
        DELETE FROM comentario WHERE id_proyecto = idProyecto;
        DELETE FROM seguimiento_vigente WHERE id_proyecto = idProyecto;
        DELETE FROM proyecto_vigente WHERE id = idProyecto;
    END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `FINALIZAR_PROYECTO` (`idProy` INT)  BEGIN
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
    END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `NUEVA_PASSWORD` (`pwd` VARCHAR(255), `_correo` VARCHAR(50))  BEGIN
        DECLARE X INT;
        DECLARE Y INT;
        SELECT id INTO X FROM profesor WHERE correo = _correo;
        SELECT IFNULL(X,1) INTO Y;
        IF (Y = 1) THEN
            SELECT id INTO X FROM alumno WHERE correo = _correo;
            UPDATE alumno SET contraseña = pwd WHERE id = X;
            DELETE FROM clave_password WHERE correo = _correo;
        ELSE
            UPDATE profesor SET contraseña = pwd WHERE id = X;
            DELETE FROM clave_password WHERE correo = _correo;
        END IF;
    END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `NUEVO_COMENTARIO` (IN `nombre_usuario` VARCHAR(50), IN `apellido_usuario` VARCHAR(50), IN `id_proy` INT, IN `id_etapa` INT, IN `id_actividad` INT, IN `comentario` VARCHAR(255))  BEGIN
        INSERT INTO comentario
        VALUES (NULL, id_proy, id_etapa, id_actividad, nombre_usuario, apellido_usuario, comentario, NOW());
    END$$ 

CREATE DEFINER=`root`@`localhost` PROCEDURE `NUEVO_PROYECTO` (IN `id_asesor1` INT, IN `id_asesor2` INT, IN `id_alumno` INT, IN `nombre_proyecto` VARCHAR(125), IN `fecha` VARCHAR(100), IN `descripcion` VARCHAR(255), IN `universidad_alumno` VARCHAR(10), IN `clave_proy` VARCHAR(15))  BEGIN
        INSERT INTO proyecto_vigente (id_asesor1, id_asesor2, id_alumno, proyecto, fechaInicio, descripcion, clave) 
        VALUES (id_asesor1, id_asesor2, id_alumno, nombre_proyecto, fecha, descripcion, clave_proy);
        
        SELECT @max_proyecto:=MAX(id) from proyecto_vigente;
        SELECT @fechaInicio:=fechaInicio FROM proyecto_vigente WHERE id = @max_proyecto;
        SELECT @fechaEntrega:=DATE_ADD(@fechaInicio, INTERVAL 14 DAY);  
        INSERT INTO seguimiento_vigente VALUES (NULL,@max_proyecto,NULL,@fechaEntrega,1,1);
    END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `NUEVO_SEGUIMIENTO` (`idSeg` INT, `idProy` INT, `id_etapa` INT, `id_actividad` INT, `fecha` DATE, `com` VARCHAR(255), `aprobado` BOOL)  BEGIN
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
                ELSE
                    INSERT INTO seguimiento_vigente VALUES (NULL,idProy,NULL,X,id_etapa,4);
                    UPDATE seguimiento_vigente SET fecha_entrega = fecha,id_actividad = 3 WHERE id=idSeg; 
                END IF;
            END IF;
        END IF;
    END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `OBTENER_DETALLES_PROYECTO` (`id_asesor` INT)  BEGIN
        SELECT 
        proyecto_vigente.id,
        proyecto_vigente.id_asesor2,
        proyecto_vigente.clave,
        proyecto_vigente.proyecto,
        alumno.nombre,
        alumno.apellido
    FROM
        ((profesor INNER JOIN proyecto_vigente ON proyecto_vigente.id_asesor1=profesor.id) INNER JOIN
        alumno ON proyecto_vigente.id_alumno=alumno.id)
    WHERE
        profesor.id = id_asesor;
    END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `GUARDAR_CLAVE` (`_correo` VARCHAR(50),`_clave` VARCHAR(50))  
BEGIN
        DECLARE X INT;
        SELECT IFNULL(id,1) INTO X FROM clave_password WHERE correo = _correo;
        IF (X != 1) THEN
            UPDATE clave_password SET clave = _clave WHERE correo = _correo;
        ELSE
            INSERT INTO clave_password VALUES (null, _correo, _clave);
        END IF;
    END$$

DELIMITER ;