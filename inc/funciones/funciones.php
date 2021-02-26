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
        return $conn->query("SELECT id, nombre, apellido, matricula FROM profesor WHERE universidad = $universidad_usuario");
    } catch(Exception $e) {
        echo "Error!!!".$e->getMessage()."<br>";
        return false;
    }
}

function obtenerAlumnosRegistrados($universidad_usuario) {
    include 'conexion.php';
    try {
        return $conn->query("SELECT id, nombre, apellido, matricula FROM alumno WHERE universidad = $universidad_usuario");
    } catch(Exception $e) {
        echo "Error!!!".$e->getMessage()."<br>";
        return false;
    }
}

function obtenerAlumnoSeleccionado($id_alumno, $conn) {

    try {
        // return $conn->query("SELECT matricula, id_estado FROM alumno WHERE id = $id_alumno");
        return array('id_estado' => 1, 'matricula' => '2163035605');
    } catch(Exception $e) {
        echo "Error!!!".$e->getMessage()."<br>";
        return false;
    }
}
function numeroDeProyectos($conn) {
    try {
        // return $conn->query("SELECT MAX(id) FROM proyecto_vigente");
        return 1;
    } catch(Exception $e) {
        echo "Error!!!".$e->getMessage()."<br>";
        return false;
    }
}

function generarClaveProyecto($id_alumno, $universidad) {
    require 'conexion.php';
    $num_proyectos = numeroDeProyectos($conn);
    $datos_alumno = obtenerAlumnoSeleccionado($id_alumno,$conn);

    $charEstado = $datos_alumno['id_estado'] == 1 ? "P" : "T";
    $finMatricula = substr($datos_alumno['matricula'], -4); // ultimos 4 caracteres de la matricula

    $clave = $charEstado.$universidad.'-'.$finMatricula.$num_proyectos;
    // $clave = strval($id_alumno).$universidad;
    return $clave;
}

function obtenerFechaSeguimiento($id_proyecto, $id_entrega, $id_proceso){
    require 'conexion.php';
    try {
        return $conn->query("SELECT entrega FROM seguimiento_vigente WHERE id =(SELECT MAX(id) FROM seguimiento_vigente WHERE (id_proyecto = $id_proyecto AND id_entrega = $id_entrega AND id_proceso = $id_proceso))")->fetch_row();
    } catch(Exception $e) {
        echo "Error!!!".$e->getMessage()."<br>";
        return false;
    }
}

function obtenerSeguimientos($id_proyecto){
    require 'conexion.php';
    try {
        return $conn->query("SELECT seguimiento_vigente.id, seguimiento_vigente.entrega, entrega.nombre AS etapa, proceso.nombre AS proceso FROM ((seguimiento_vigente INNER JOIN entrega ON seguimiento_vigente.id_entrega = entrega.id) INNER JOIN proceso ON seguimiento_vigente.id_proceso = proceso.id) WHERE seguimiento_vigente.id_proyecto = $id_proyecto");
    } catch(Exception $e) {
        echo "Error!!!".$e->getMessage()."<br>";
        return false;
    }
}

function obtenerComentariosEtapa($id_proyecto, $id_etapa) {
    include 'conexion.php';
    try {
        return $conn->query("SELECT id, nombre, apellido, comentario, fecha 
                            FROM (comentario_vigente INNER JOIN seguimiento_vigente ON comentario_vigente.id_proyecto = seguimiento_vigente.id_proyecto) 
                            WHERE comentario_vigente.id_proyecto = $id_proyecto AND seguimiento_vigente.id_entrega = $id_etapa");
    } catch(Exception $e) {
        echo "Error!!!".$e->getMessage()."<br>";
        return false;
    }
}

function obtenerComentariosActividad($id_proyecto, $id_etapa, $id_actividad) {
    include 'conexion.php';
    try {
        return $conn->query("SELECT id, nombre, apellido, comentario, fecha 
                            FROM (comentario_vigente INNER JOIN seguimiento_vigente ON comentario_vigente.id_proyecto = seguimiento_vigente.id_proyecto) 
                            WHERE comentario_vigente.id_proyecto = $id_proyecto AND seguimiento_vigente.id_entrega = $id_etapa AND seguimiento_vigente.id_proceso = $id_actividad");
    } catch(Exception $e) {
        echo "Error!!!".$e->getMessage()."<br>";
        return false;
    }
}

?>