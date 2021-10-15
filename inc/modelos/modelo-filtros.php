<?php 

//obtiene esta variable de total-proyectos.php
if($_POST['tipo'] == 'filtrar'){

    require_once('../funciones/conexion.php');

    $nombre='';
    $apellido='';

    if($_POST['filtro_asesor'] != 0){
        $nombre_asesor = filter_var($_POST['filtro_asesor'], FILTER_SANITIZE_STRING);
        list($nombre, $apellido) = explode(" ", $nombre_asesor, 2);
    
    try {
            $stmt = $conn->prepare("SELECT proyecto_historico.proyecto,profesor.nombre as nom_asesor, profesor.apellido as ap_asesor, alumno.nombre,alumno.apellido,proyecto_historico.fechaInicio,proyecto_historico.fechaFin,proyecto_historico.descripcion,proyecto_historico.comentarioFinal FROM ((proyecto_historico INNER JOIN alumno ON proyecto_historico.id_alumno=alumno.id) INNER JOIN profesor ON profesor.id = proyecto_historico.id_asesor1) WHERE profesor.nombre LIKE '%?%' OR 
                profesor.apellido LIKE '%?%'");
            $stmt->bind_param("ss", $nombre, $apellido);
            $stmt->execute();

            if($stmt) {
                echo "entro";  
            } else {
                $respuesta = array(
                    'respuesta' => 'error',
                    'error' => 'No se pudo encontrar al asesor',
                    'detalle' => $stmt->errno.' : '.$stmt->error
                );
            }

            $stmt->close();
            $conn->close();
        } catch(Exception $e) {
            $respuesta = array(
                'error' => $e->getMessage()
            );
        }
    } else if ($_POST['filtro_uni'] != 0) {
        $uni = filter_var($_POST['filtro_uni'], FILTER_SANITIZE_STRING);
        try {
            $stmt = $conn->prepare("SELECT proyecto_historico.proyecto,profesor.nombre as nom_asesor, profesor.apellido as ap_asesor, alumno.nombre,alumno.apellido,proyecto_historico.fechaInicio,proyecto_historico.fechaFin,proyecto_historico.descripcion,proyecto_historico.comentarioFinal FROM ((proyecto_historico INNER JOIN alumno ON proyecto_historico.id_alumno=alumno.id) INNER JOIN profesor ON profesor.id = proyecto_historico.id_asesor1) WHERE alumno.universidad = ?");
            $stmt->bind_param("s", $uni);
            $stmt->execute();

            if($stmt) {
                echo "entro";  
            } else {
                $respuesta = array(
                    'respuesta' => 'error',
                    'error' => 'No se pudo encontrar al asesor',
                    'detalle' => $stmt->errno.' : '.$stmt->error
                );
            }

            $stmt->close();
            $conn->close();
        } catch(Exception $e) {
            $respuesta = array(
                'error' => $e->getMessage()
            );
        }
        echo json_encode($respuesta);
    }

        
}
 ?>