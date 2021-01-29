<?php

function obtenerProyectos($id_usuario) {
    include 'conexion.php';
    try {
        return $conn->query("CALL OBTENER_DETALLES_PROYECTO($id_usuario)");
    } catch(Exception $e) {
        echo "Error!!!".$e->getMessage()."<br>";
        return false;
    }
}

//Obtiene un proyecto de un id dado
function obtenerProyecto($id_proyecto) {
    include 'conexion.php';
    try {
        return $conn->query("CALL OBTENER_PROYECTO($id_proyecto)");
    } catch(Exception $e) {
        echo "Error!!!".$e->getMessage()."<br>";
        return false;
    }
}

function obtenerProfesoresRegistrados($universidad_usuario) {
    include 'conexion.php';
    try {
        // funcion que hace la comparación entre enteros, institución es un nuevo campo en la tabla profesor, es un int.
        return $conn->query("SELECT id, nombre, apellido, matricula FROM profesor WHERE institucion = $universidad_usuario");
        // funcion que hace la comparación entre cadenas
        // return $conn->query("SELECT id, nombre, apellido, matricula FROM profesor WHERE universidad = $universidad_usuario");
    } catch(Exception $e) {
        echo "Error!!!".$e->getMessage()."<br>";
        return false;
    }
}

function obtenerAlumnosRegistrados($universidad_usuario) {
    include 'conexion.php';
    try {
        // funcion que hace la comparación entre enteros, institución es un nuevo campo en la tabla alumno, es un int.
        return $conn->query("SELECT id, nombre, apellido, matricula FROM alumno WHERE institucion = $universidad_usuario");
        // funcion que hace la comparación entre cadenas
        // return $conn->query("SELECT id, nombre, apellido, matricula FROM alumno WHERE universidad = $universidad_usuario");
    } catch(Exception $e) {
        echo "Error!!!".$e->getMessage()."<br>";
        return false;
    }
}

?>