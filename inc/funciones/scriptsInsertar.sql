DELIMITER //
    CREATE PROCEDURE BORRAR_PROYECTO(id_proyecto int)
    BEGIN
        DELETE FROM comentario_vigente WHERE id_proyecto = id_proyecto;
        DELETE FROM seguimiento_vigente WHERE id_proyecto = id_proyecto;
        DELETE FROM proyecto_vigente WHERE id = id_proyecto;
    END//
 DELIMITER ;