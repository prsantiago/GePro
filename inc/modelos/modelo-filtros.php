<?php 

//obtiene esta variable de total-proyectos.php
if($_POST['tipo'] == 'filtrar'){

    require_once('../funciones/conexion.php');

    $tabla_a_buscar = filter_var($_POST['buscar_por'], FILTER_SANITIZE_STRING);
    
    if ($tabla_a_buscar == 'proyecto') {
        $nombre_a_buscar = filter_var($_POST['nombre_buscar'], FILTER_SANITIZE_STRING);

        try {
            $stmt_historico = $conn->prepare("SELECT proyecto_historico.proyecto,
                                                        profesor.nombre as nom_asesor, 
                                                        profesor.apellido as ap_asesor,
                                                        alumno.nombre,
                                                        alumno.apellido,
                                                        proyecto_historico.fechaInicio,
                                                        proyecto_historico.fechaFin,
                                                        proyecto_historico.descripcion 
                                                FROM ((proyecto_historico 
                                                        INNER JOIN alumno ON proyecto_historico.id_alumno=alumno.id)  
                                                        INNER JOIN profesor ON profesor.id = proyecto_historico.id_asesor1)
                                    WHERE proyecto_historico.proyecto = ?");
            $stmt_historico->bind_param("s", $nombre_a_buscar);
            $stmt_historico->execute();
            $stmt_historico->bind_result($nombre_proyecto_h, $nombre_asesor_h, $apellido_asesor_h, 
                                        $nombre_alumno_h, $apellido_alumno_h, $fecha_inicio_h, $fecha_fin_h, $descripcion_h);
            $stmt_historico->fetch();

            $stmt_vigente = $conn->prepare("SELECT proyecto_vigente.proyecto,profesor.nombre as nom_asesor, profesor.apellido as ap_asesor, alumno.nombre,alumno.apellido,proyecto_vigente.fechaInicio,proyecto_vigente.fechaFin,proyecto_vigente.descripcion FROM ((proyecto_vigente INNER JOIN alumno ON proyecto_vigente.id_alumno=alumno.id) INNER JOIN profesor ON profesor.id = proyecto_vigente.id_asesor1) 
                                    WHERE proyecto_vigente.proyecto = ?");
            $stmt_vigente->bind_param("s", $nombre_a_buscar);
            $stmt_vigente->execute();
            $stmt_vigente->bind_result($nombre_proyecto_v, $nombre_asesor_v, $apellido_asesor_v, 
                                        $nombre_alumno_v, $apellido_alumno_v, $fecha_inicio_v, $fecha_fin_v, $descripcion_v);
            $stmt_vigente->fetch();

            if($nombre_proyecto_h != null ) {
                $respuesta = array(
                    'respuesta' => 'correcto',
                    'nombre_proyecto_h' => $nombre_proyecto_h,
                    'nombre_asesor_h' => $nombre_asesor_h.' '.$apellido_asesor_h,
                    'nombre_alumno_h' => $nombre_alumno_h.' '.$apellido_alumno_h,
                    'fecha_inicio_h' => $fecha_inicio_h,
                    'fecha_fin_h' => $fecha_fin_h,
                    'descripcion_h' => $descripcion_h,
                    'status' => 'Concluido'
                ); 
            } else if($nombre_proyecto_v != null) {
                $respuesta = array(
                    'respuesta' => 'correcto',
                    'nombre_proyecto_v' => $nombre_proyecto_v,
                    'nombre_asesor_v' => $nombre_asesor_v.' '.$apellido_asesor_v,
                    'nombre_alumno_v' => $nombre_alumno_v.' '.$apellido_alumno_v,
                    'fecha_inicio_v' => $fecha_inicio_v,
                    'fecha_fin_v' => $fecha_fin_v,
                    'descripcion_v' => $descripcion_v,
                    'status' => 'En proceso'
                );  
            } else if ($stmt_vigente->ernno > 0 || $stmt_historico->ernno > 0) {
                $respuesta = array(
                    'respuesta' => 'error',
                    'error' => 'Error en la consulta'
                );
            } else if ($nombre_proyecto_h == null && $nombre_proyecto_v == null) {
                $respuesta = array(
                    'respuesta' => 'error',
                    'error' => 'No se pudo encontrar el proyecto'
                );
            }

            $stmt_vigente->close(); $stmt_historico->close();
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