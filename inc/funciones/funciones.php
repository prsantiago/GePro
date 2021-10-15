<?php
// Llamada a procedure OBTENER_DETALLES_PROYECTO 
function obtenerProyectos($id_usuario) {
    global $conn;
    try {
        return $conn->query("CALL OBTENER_DETALLES_PROYECTO($id_usuario)");
        // return $conn->query("SELECT proyecto_vigente.id,proyecto_vigente.clave,proyecto_vigente.nom_proyecto,alumno.nombre,alumno.apellido FROM ((profesor INNER JOIN proyecto_vigente ON proyecto_vigente.id_asesor1=profesor.id) INNER JOIN alumno ON proyecto_vigente.id_alumno=alumno.id) WHERE profesor.id = $id_usuario");
    } catch(Exception $e) {
        echo "Error!!!".$e->getMessage()."<br>";
        return false;
    }
}

// SELECT para regresar: id, nombre, apellido y matricula de profesor registrado. Se filtra por universidad
function obtenerProfesoresRegistrados($universidad_usuario) {
    // include 'conexion.php';
    $conn = new mysqli(DB_HOST, DB_USUARIO, DB_PASSWORD, DB_NOMBRE);
    try {
        return $conn->query("SELECT id, nombre, apellido, matricula FROM profesor WHERE universidad = $universidad_usuario");
    } catch(Exception $e) {
        echo "Error!!!".$e->getMessage()."<br>";
        return false;
    }
}

// SELECT para regresar: id, nombre, apellido y matricula de alumno registrado. Se filtra por universidad
function obtenerAlumnosRegistrados($universidad_usuario) {
    require 'conexion.php';
    // include 'conexion.php';
    try {
        return $conn->query("SELECT id, nombre, apellido, matricula FROM alumno WHERE universidad = $universidad_usuario");
    } catch(Exception $e) {
        echo "Error!!!".$e->getMessage()."<br>";
        return false;
    }
}

// SELECT para regresar última fecha de entrega del seguimiento para el proyecto, etapa y actividad dado
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

// SELECT que regresa id, fecha de entrega, etapa y actividad de todos los seguimientos que tiene un proyecto
function obtenerSeguimientos($id_proyecto){
    require 'conexion.php';
    try {
        return $conn->query("SELECT seguimiento_vigente.id, seguimiento_vigente.fecha_entrega, etapa.nombre AS etapa, actividad.nombre AS actividad 
                            FROM ((seguimiento_vigente INNER JOIN etapa 
                                    ON seguimiento_vigente.id_etapa = etapa.id) INNER JOIN actividad
                                        ON seguimiento_vigente.id_actividad = actividad.id) 
                            WHERE seguimiento_vigente.id_proyecto = $id_proyecto");
    } catch(Exception $e) {
        echo "Error!!!".$e->getMessage()."<br>";
        return false;
    }
}

// TODO: Terminar los comentarios
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
    global $conn;
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
    global $conn;
    try {
        return $conn->query("SELECT proyecto,clave,etapa.nombre AS etapa,actividad.nombre AS actividad FROM ((( seguimiento_vigente INNER JOIN proyecto_vigente ON seguimiento_vigente.id_proyecto = proyecto_vigente.id) INNER JOIN etapa ON seguimiento_vigente.id_etapa = etapa.id) INNER JOIN actividad ON seguimiento_vigente.id_actividad = actividad.id) where seguimiento_vigente.id = $idSeg")->fetch_row();
    } catch(Exception $e) {
        echo "Error!!!".$e->getMessage()."<br>";
        return false;
    }
}

function ObtenerCorreos($idProy) {
    global $conn;
    try {
        return $conn->query("SELECT alumno.correo, profesor.correo FROM ((alumno INNER JOIN proyecto_vigente ON alumno.id = proyecto_vigente.id_alumno) INNER JOIN profesor ON profesor.id = proyecto_vigente.id_asesor2) WHERE proyecto_vigente.id = $idProy")->fetch_row();
    } catch(Exception $e) {
        echo "Error!!!".$e->getMessage()."<br>";
        return false;
    }
}

function ObtenerCorreosConID($idUsuario, $tipoUsuario) {
    global $conn;
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
    global $conn;
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

function obtenerIDProyectos(){
    global $conn;
    try {
        return $conn->query("SELECT id FROM `proyecto_vigente`")->fetch_all();
    } catch(Exception $e) {
        echo "Error!!!".$e->getMessage()."<br>";
        return false;
    }
}

function obtenerFechaSeguimientoActual($id_proyecto){
    global $conn;
    try {
        return $conn->query("SELECT id, proxima_entrega FROM seguimiento_vigente 
                            WHERE id =(SELECT MAX(id) FROM seguimiento_vigente 
                                        WHERE (id_proyecto = $id_proyecto))")->fetch_row();
    } catch(Exception $e) {
        echo "Error!!!".$e->getMessage()."<br>";
        return false;
    }
}


function obtenerAlumnoProyecto($id_proyecto) {
    $conn = new mysqli(DB_HOST, DB_USUARIO, DB_PASSWORD, DB_NOMBRE);
    try {
        return $conn->query("SELECT id_alumno FROM proyecto_vigente WHERE id = $id_proyecto")->fetch_row();
    } catch(Exception $e) {
        echo "Error!!!".$e->getMessage()."<br>";
        return false;
    }
}

function obtenerClaveProyecto() {
    global $conn;
    try {
        return $conn->query("SELECT clave FROM proyecto_vigente WHERE id = (SELECT MAX(id) FROM proyecto_vigente)")->fetch_row();
    } catch(Exception $e) {
        echo "Error!!!".$e->getMessage()."<br>";
        return false;
    }
}

function generarClaveProyecto($id_alumno, $universidad) {
    global $conn;
    $num_proyectos = $conn->query("SELECT MAX(id) FROM proyecto_vigente")->fetch_row();
    $datos_alumno = $conn->query("SELECT id_estado FROM alumno WHERE id = $id_alumno")->fetch_row();

    $charEstado = $datos_alumno[0] == 1 ? "P" : "T";
    $clave = $charEstado.$universidad.'-'.$num_proyectos[0];
    return $clave;
}

function obtenerProyectosCompletados(){
    global $conn;
    try{
        return $conn->query("SELECT proyecto_historico.proyecto,profesor.nombre as nom_asesor, profesor.apellido as ap_asesor, profesor.nombre as nom_asesor2, profesor.apellido as ap_asesor2,alumno.nombre,alumno.apellido,proyecto_historico.fechaInicio,proyecto_historico.fechaFin,proyecto_historico.descripcion FROM (((proyecto_historico INNER JOIN alumno ON proyecto_historico.id_alumno=alumno.id) INNER JOIN profesor ON profesor.id = proyecto_historico.id_asesor2) INNER JOIN profesor ON profesor.id = proyecto_historico.id_asesor1)");
    } catch(Exception $e){
        echo "Error!!!".$e->getMessage()."<br>";
        return false;
    } 
}

function obtenerProyectosEnProceso(){
    global $conn;
    try{
        return $conn->query("SELECT proyecto_vigente.proyecto,profesor.nombre as nom_asesor, profesor.apellido as ap_asesor, profesor.nombre as nom_asesor2, profesor.apellido as ap_asesor2, alumno.nombre,alumno.apellido,proyecto_vigente.fechaInicio,proyecto_vigente.fechaFin,proyecto_vigente.descripcion FROM (((proyecto_vigente INNER JOIN alumno ON proyecto_vigente.id_alumno=alumno.id) INNER JOIN profesor ON profesor.id = proyecto_historico.id_asesor2) INNER JOIN profesor ON profesor.id = proyecto_vigente.id_asesor1) WHERE proyecto_vigente.id > 1");
    } catch(Exception $e){
        echo "Error!!!".$e->getMessage()."<br>";
        return false;
    } 
}

?>