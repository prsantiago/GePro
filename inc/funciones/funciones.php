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

function obtenerFechaSeguimiento($id_proyecto,$id_etapa,$id_actividad){
    $conn = new mysqli(DB_HOST, DB_USUARIO, DB_PASSWORD, DB_NOMBRE);
    try {
        return $conn->query("SELECT fecha_entrega FROM seguimiento_vigente 
                            WHERE id =(SELECT MAX(id) FROM seguimiento_vigente 
                                        WHERE (id_proyecto = $id_proyecto AND id_etapa = $id_etapa AND id_actividad = $id_actividad))")->fetch_row();
    } catch(Exception $e) {
        echo "Error!!!".$e->getMessage()."<br>";
        return false;
    }
}

function obtenerSeguimientos($id_proyecto){
    require 'conexion.php';
    try {
        return $conn->query("SELECT seguimiento_vigente.id, seguimiento_vigente.fecha_entrega, etapa.nombre AS etapa, actividad.nombre AS actividad 
                            FROM ((seguimiento_vigente INNER JOIN etapa 
                                    ON seguimiento_vigente.id_etapa = etapa.id) INNER JOIN actividad
                                        ON seguimiento_vigente.id_actividad = actividad.id) WHERE seguimiento_vigente.id_proyecto = $id_proyecto");
    } catch(Exception $e) {
        echo "Error!!!".$e->getMessage()."<br>";
        return false;
    }
}

function obtenerComentariosEtapa($id_proyecto, $idEtapa) {
    include 'conexion.php';
    try {
        return $conn->query("SELECT nombre, apellido, comentario, fecha 
                            FROM comentario 
                            WHERE id_proyecto = $id_proyecto AND id_etapa = $idEtapa");
    } catch(Exception $e) {
        echo "Error!!!".$e->getMessage()."<br>";
        return false;
    }
}

function obtenerComentariosActividad($id_proyecto, $idEtapa, $idActividad) {
    include 'conexion.php';
    try {
        return $conn->query("SELECT nombre, apellido, comentario, fecha 
                            FROM comentario  
                            WHERE id_proyecto = $id_proyecto AND id_etapa = $idEtapa AND id_actividad = $idActividad");
    } catch(Exception $e) {
        echo "Error!!!".$e->getMessage()."<br>";
        return false;
    }
}

function obtenerProyectosVigentes($idProf) {
    include 'conexion.php';
    try {
        return $conn->query("SELECT count(*) FROM proyecto_vigente WHERE id_asesor1 = $idProf OR id_asesor2 = $idProf")->fetch_row();
    } catch(Exception $e) {
        echo "Error!!!".$e->getMessage()."<br>";
        return false;
    }
}

function obtenerHistorialProyectos($idProf) {
    include 'conexion.php';
    try {
        return $conn->query("SELECT proyecto_historico.proyecto,alumno.nombre,alumno.apellido,proyecto_historico.fechaInicio,proyecto_historico.fechaFin,proyecto_historico.descripcion,proyecto_historico.comentarioFinal FROM (proyecto_historico INNER JOIN alumno ON proyecto_historico.id_alumno=alumno.id) WHERE proyecto_historico.id_asesor1 = $idProf OR proyecto_historico.id_asesor2 = $idProf");
    } catch(Exception $e) {
        echo "Error!!!".$e->getMessage()."<br>";
        return false;
    }
}

function ObtenerDatosNotificacion($idSeg) {
    $conn = new mysqli(DB_HOST, DB_USUARIO, DB_PASSWORD, DB_NOMBRE);
    try {
        return $conn->query("SELECT proyecto,clave,etapa.nombre AS etapa,actividad.nombre AS actividad FROM ((( seguimiento_vigente INNER JOIN proyecto_vigente ON seguimiento_vigente.id_proyecto = proyecto_vigente.id) INNER JOIN etapa ON seguimiento_vigente.id_etapa = etapa.id) INNER JOIN actividad ON seguimiento_vigente.id_actividad = actividad.id) where seguimiento_vigente.id = $idSeg")->fetch_row();
    } catch(Exception $e) {
        echo "Error!!!".$e->getMessage()."<br>";
        return false;
    }
}

function ObtenerCorreos($idProy) {
    $conn = new mysqli(DB_HOST, DB_USUARIO, DB_PASSWORD, DB_NOMBRE);
    try {
        return $conn->query("SELECT alumno.correo, profesor.correo FROM ((alumno INNER JOIN proyecto_vigente ON alumno.id = proyecto_vigente.id_alumno) INNER JOIN profesor ON profesor.id = proyecto_vigente.id_asesor2) WHERE proyecto_vigente.id = $idProy")->fetch_row();
    } catch(Exception $e) {
        echo "Error!!!".$e->getMessage()."<br>";
        return false;
    }
}

function ObtenerCorreosConID($idUsuario, $tipoUsuario) {
    $conn = new mysqli(DB_HOST, DB_USUARIO, DB_PASSWORD, DB_NOMBRE);
    try {
        if($tipoUsuario=="alumno")
            return $conn->query("SELECT correo FROM alumno where id = $idUsuario")->fetch_row();
        else if($tipoUsuario=="profesor")
            return $conn->query("SELECT correo FROM profesor where id = $idUsuario")->fetch_row();
    } catch(Exception $e) {
        echo "Error!!!".$e->getMessage()."<br>";
        return false;
    }
}

function ObtenerCorreoConIDProyecto($id_proyecto, $tipoUsuario) {
    $conn = new mysqli(DB_HOST, DB_USUARIO, DB_PASSWORD, DB_NOMBRE);
    try {
        if($tipoUsuario=="alumno")
            return $conn->query("SELECT profesor.correo FROM (profesor INNER JOIN proyecto_vigente ON profesor.id = proyecto_vigente.id_asesor1) where proyecto_vigente.id = $id_proyecto")->fetch_row();
        else if($tipoUsuario=="profesor")
            return $conn->query("SELECT alumno.correo FROM (alumno INNER JOIN proyecto_vigente ON alumno.id = proyecto_vigente.id_alumno) where proyecto_vigente.id = $id_proyecto")->fetch_row();
    } catch(Exception $e) {
        echo "Error!!!".$e->getMessage()."<br>";
        return false;
    }
}

?>