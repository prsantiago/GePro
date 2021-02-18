 -- Se ejecuta después de que se creó el proyecto en modelo-proyecto.php
DELIMITER //
    CREATE PROCEDURE EMPEZAR_SEGUIMIENTO()
    BEGIN
        DECLARE Z INT;
        DECLARE X DATE;
        DECLARE Y DATE;
        SELECT MAX(id) INTO Z FROM proyecto_vigente;
        SELECT fechaInicio INTO Y FROM proyecto_vigente WHERE id=Z;
        SELECT DATE_ADD(Y, INTERVAL 14 DAY) INTO X;  
        INSERT INTO seguimiento_vigente VALUES (NULL,Z,NULL,X,1,1);
    END//
 DELIMITER ;    
