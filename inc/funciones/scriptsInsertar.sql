CREATE TABLE comentario_vigente(
	id INT NOT NULL AUTO_INCREMENT,
    id_proyecto INT,
    nombre VARCHAR(75),
    apellido VARCHAR(75),
    comentario VARCHAR(255),
    fecha DATETIME,

	PRIMARY KEY(id)
);

CREATE TABLE comentario_historico(
	id INT NOT NULL AUTO_INCREMENT,
    id_proyecto INT,
    nombre VARCHAR(75),
    apellido VARCHAR(75),
    comentario VARCHAR(255),
    fecha DATETIME,

	PRIMARY KEY(id)
);

-- Llaves foráneas comentarios
ALTER TABLE comentario_vigente ADD CONSTRAINT FK_comentario FOREIGN KEY (id_proyecto) references proyecto_vigente(id);
ALTER TABLE comentario_historico ADD CONSTRAINT FK_comentario_historico FOREIGN KEY (id_proyecto) references proyecto_historico(id);