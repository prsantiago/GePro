<?php

function obtenerProyectos() {
    include 'conexion.php';
    try {
        return $conn->query("SELECT id, nombre, empresa, telefono FROM proyectos");
    } catch(Exception $e) {
        echo "Error!!!".$e->getMessage()."<br>";
        return false;
    }
}

//Obtiene un contacto de un id dado
function obtenerProyecto($id) {
    include 'conexion.php';
    try {
        return $conn->query("SELECT id, nombre, empresa, telefono FROM proyectos WHERE id = $id");
    } catch(Exception $e) {
        echo "Error!!!".$e->getMessage()."<br>";
        return false;
    }
}

?>