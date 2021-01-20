<?php

function obtenerProyectos() {
    include 'conexion.php';
    try {
        
        return $conn->query("SELECT id, nombre, ,  FROM proyectos");
    } catch(Exception $e) {
        echo "Error!!!".$e->getMessage()."<br>";
        return false;
    }
}

//Obtiene un proyecto de un id dado
function obtenerProyecto($id) {
    include 'conexion.php';
    try {
        return $conn->query("SELECT id, nombre, ,  FROM proyectos WHERE id = $id");
    } catch(Exception $e) {
        echo "Error!!!".$e->getMessage()."<br>";
        return false;
    }
}



?>