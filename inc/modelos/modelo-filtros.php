<?php 

//obtiene esta variable de total-proyectos.php
if($_POST['tipo'] == 'filtrar'){

    require_once('../funciones/conexion.php');

    $tabla_a_buscar = filter_var($_POST['buscar_por'], FILTER_SANITIZE_STRING);
    
    if($tabla_a_buscar == 'asesor'){
        $nombre_a_buscar = filter_var($_POST['nombre_buscar'], FILTER_SANITIZE_STRING);
        list($nombre, $apellido) = explode(" ", $nombre_a_buscar, 2);
    
        try {
            $stmt_historico = $conn->prepare("SELECT proyecto_historico.proyecto, profesor.nombre as nom_asesor, profesor.apellido as ap_asesor, 
                                                    profesor.nombre as nom_asesor2, profesor.apellido as ap_asesor2, 
                                                    alumno.nombre, alumno.apellido, proyecto_historico.fechaInicio, proyecto_historico.fechaFin, 
                                                    proyecto_historico.descripcion /*, proyecto_historico.comentarioFinal */
                                    FROM (((proyecto_historico INNER JOIN alumno ON proyecto_historico.id_alumno=alumno.id) 
                                            INNER JOIN profesor ON profesor.id = proyecto_historico.id_asesor1) 
                                            INNER JOIN profesor ON profesor.id = proyecto_historico.id_asesor2)
                                    WHERE profesor.nombre LIKE '%?%' and profesor.apellido LIKE '%?%'");
            $stmt_historico->bind_param("ss", $nombre, $apellido);
            $stmt_historico->execute();
            $stmt_historico->bind_result($nombre_proyecto_h, $nombre_asesor_h, $apellido_asesor_h, $nombre_coasesor_h, $apellido_coasesor_h, 
                                        $nombre_alumno_h, $apellido_alumno_h, $fecha_inicio_h, $fecha_fin_h, $descripcion_h);
            $stmt_historico->fetch();

            $stmt_vigente = $conn->prepare("SELECT proyecto_vigente.proyecto, profesor.nombre as nom_asesor, profesor.apellido as ap_asesor, 
                                                    profesor.nombre as nom_asesor2, profesor.apellido as ap_asesor2, 
                                                    alumno.nombre, alumno.apellido, proyecto_vigente.fechaInicio, proyecto_vigente.fechaFin, 
                                                    proyecto_vigente.descripcion /*, proyecto_vigente.comentarioFinal */
                                    FROM (((proyecto_vigente INNER JOIN alumno ON proyecto_vigente.id_alumno=alumno.id) 
                                            INNER JOIN profesor ON profesor.id = proyecto_vigente.id_asesor1) 
                                            INNER JOIN profesor ON profesor.id = proyecto_vigente.id_asesor2)
                                    WHERE profesor.nombre LIKE '%?%' and profesor.apellido LIKE '%?%'");
            $stmt_vigente->bind_param("ss", $nombre, $apellido);
            $stmt_vigente->execute();
            $stmt_vigente->bind_result($nombre_proyecto_v, $nombre_asesor_v, $apellido_asesor_v, $nombre_coasesor_v, $apellido_coasesor_v, 
                                        $nombre_alumno_v, $apellido_alumno_v, $fecha_inicio_v, $fecha_fin_v, $descripcion_v);
            $stmt_vigente->fetch();

            if($stmt) {
                $respuesta = array(
                    'respuesta' => 'correcto',
                    'nombre_proyecto_h' => $nombre_proyecto_h,
                    'nombre_asesor_h' => $nombre_asesor_h,
                    'apellido_asesor_h' => $apellido_asesor_h,
                    'nombre_coasesor_h' => $nombre_coasesor_h,
                    'apellido_coasesor_h' => $apellido_coasesor_h,
                    'nombre_alumno_h' => $nombre_alumno_h,
                    'apellido_alumno_h' => $apellido_alumno_h,
                    'fecha_inicio_h' => $fecha_inicio_h,
                    'fecha_fin_h' => $fecha_fin_h,
                    'descripcion_h' => $descripcion_h,
                    'nombre_proyecto_v' => $nombre_proyecto_v,
                    'nombre_asesor_v' => $nombre_asesor_v,
                    'apellido_asesor_v' => $apellido_asesor_v,
                    'nombre_coasesor_v' => $nombre_coasesor_v,
                    'apellido_coasesor_v' => $apellido_coasesor_v,
                    'nombre_alumno_v' => $nombre_alumno_v,
                    'apellido_alumno_v' => $apellido_alumno_v,
                    'fecha_inicio_v' => $fecha_inicio_v,
                    'fecha_fin_v' => $fecha_fin_v,
                    'descripcion_v' => $descripcion_v
                ); 
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
    } else if ($tabla_a_buscar == 'asesor2') {
        $nombre_a_buscar = filter_var($_POST['nombre_buscar'], FILTER_SANITIZE_STRING);
        list($nombre, $apellido) = explode(" ", $nombre_a_buscar, 2);

        try {
            $stmt_historico = $conn->prepare("SELECT proyecto_historico.proyecto, profesor.nombre as nom_asesor, profesor.apellido as ap_asesor, 
                                                    profesor.nombre as nom_asesor2, profesor.apellido as ap_asesor2, 
                                                    alumno.nombre, alumno.apellido, proyecto_historico.fechaInicio, proyecto_historico.fechaFin, 
                                                    proyecto_historico.descripcion /*, proyecto_historico.comentarioFinal */
                                    FROM (((proyecto_historico INNER JOIN alumno ON proyecto_historico.id_alumno=alumno.id) 
                                            INNER JOIN profesor ON profesor.id = proyecto_historico.id_asesor1) 
                                            INNER JOIN profesor ON profesor.id = proyecto_historico.id_asesor2)
                                    WHERE profesor.nombre LIKE '%?%' and profesor.apellido LIKE '%?%'");
            $stmt_historico->bind_param("ss", $nombre, $apellido);
            $stmt_historico->execute();
            $stmt_historico->bind_result($nombre_proyecto_h, $nombre_asesor_h, $apellido_asesor_h, $nombre_coasesor_h, $apellido_coasesor_h, 
                                        $nombre_alumno_h, $apellido_alumno_h, $fecha_inicio_h, $fecha_fin_h, $descripcion_h);
            $stmt_historico->fetch();

            $stmt_vigente = $conn->prepare("SELECT proyecto_vigente.proyecto, profesor.nombre as nom_asesor, profesor.apellido as ap_asesor, 
                                                    profesor.nombre as nom_asesor2, profesor.apellido as ap_asesor2, 
                                                    alumno.nombre, alumno.apellido, proyecto_vigente.fechaInicio, proyecto_vigente.fechaFin, 
                                                    proyecto_vigente.descripcion /*, proyecto_vigente.comentarioFinal */
                                    FROM (((proyecto_vigente INNER JOIN alumno ON proyecto_vigente.id_alumno=alumno.id) 
                                            INNER JOIN profesor ON profesor.id = proyecto_vigente.id_asesor1) 
                                            INNER JOIN profesor ON profesor.id = proyecto_vigente.id_asesor2)
                                    WHERE profesor.nombre LIKE '%?%' and profesor.apellido LIKE '%?%'");
            $stmt_vigente->bind_param("ss", $nombre, $apellido);
            $stmt_vigente->execute();
            $stmt_vigente->bind_result($nombre_proyecto_v, $nombre_asesor_v, $apellido_asesor_v, $nombre_coasesor_v, $apellido_coasesor_v, 
                                        $nombre_alumno_v, $apellido_alumno_v, $fecha_inicio_v, $fecha_fin_v, $descripcion_v);
            $stmt_vigente->fetch();

            if($stmt) {
                $respuesta = array(
                    'respuesta' => 'correcto',
                    'nombre_proyecto_h' => $nombre_proyecto_h,
                    'nombre_asesor_h' => $nombre_asesor_h,
                    'apellido_asesor_h' => $apellido_asesor_h,
                    'nombre_coasesor_h' => $nombre_coasesor_h,
                    'apellido_coasesor_h' => $apellido_coasesor_h,
                    'nombre_alumno_h' => $nombre_alumno_h,
                    'apellido_alumno_h' => $apellido_alumno_h,
                    'fecha_inicio_h' => $fecha_inicio_h,
                    'fecha_fin_h' => $fecha_fin_h,
                    'descripcion_h' => $descripcion_h,
                    'nombre_proyecto_v' => $nombre_proyecto_v,
                    'nombre_asesor_v' => $nombre_asesor_v,
                    'apellido_asesor_v' => $apellido_asesor_v,
                    'nombre_coasesor_v' => $nombre_coasesor_v,
                    'apellido_coasesor_v' => $apellido_coasesor_v,
                    'nombre_alumno_v' => $nombre_alumno_v,
                    'apellido_alumno_v' => $apellido_alumno_v,
                    'fecha_inicio_v' => $fecha_inicio_v,
                    'fecha_fin_v' => $fecha_fin_v,
                    'descripcion_v' => $descripcion_v
                ); 
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
    } else if ($tabla_a_buscar == 'alumno') {
        $nombre_a_buscar = filter_var($_POST['nombre_buscar'], FILTER_SANITIZE_STRING);
        list($nombre, $apellido) = explode(" ", $nombre_a_buscar, 2);

        try {
            $stmt_historico = $conn->prepare("SELECT proyecto_historico.proyecto, profesor.nombre as nom_asesor, profesor.apellido as ap_asesor, 
                                                    profesor.nombre as nom_asesor2, profesor.apellido as ap_asesor2, 
                                                    alumno.nombre, alumno.apellido, proyecto_historico.fechaInicio, proyecto_historico.fechaFin, 
                                                    proyecto_historico.descripcion /*, proyecto_historico.comentarioFinal */
                                    FROM (((proyecto_historico INNER JOIN alumno ON proyecto_historico.id_alumno=alumno.id) 
                                            INNER JOIN profesor ON profesor.id = proyecto_historico.id_asesor1) 
                                            INNER JOIN profesor ON profesor.id = proyecto_historico.id_asesor2)
                                    WHERE alumno.nombre LIKE '%?%' and alumno.apellido LIKE '%?%'");
            $stmt_historico->bind_param("ss", $nombre, $apellido);
            $stmt_historico->execute();
            $stmt_historico->bind_result($nombre_proyecto_h, $nombre_asesor_h, $apellido_asesor_h, $nombre_coasesor_h, $apellido_coasesor_h, 
                                        $nombre_alumno_h, $apellido_alumno_h, $fecha_inicio_h, $fecha_fin_h, $descripcion_h);
            $stmt_historico->fetch();

            $stmt_vigente = $conn->prepare("SELECT proyecto_vigente.proyecto, profesor.nombre as nom_asesor, profesor.apellido as ap_asesor, 
                                                    profesor.nombre as nom_asesor2, profesor.apellido as ap_asesor2, 
                                                    alumno.nombre, alumno.apellido, proyecto_vigente.fechaInicio, proyecto_vigente.fechaFin, 
                                                    proyecto_vigente.descripcion /*, proyecto_vigente.comentarioFinal */
                                    FROM (((proyecto_vigente INNER JOIN alumno ON proyecto_vigente.id_alumno=alumno.id) 
                                            INNER JOIN profesor ON profesor.id = proyecto_vigente.id_asesor1) 
                                            INNER JOIN profesor ON profesor.id = proyecto_vigente.id_asesor2)
                                    WHERE alumno.nombre LIKE '%?%' and alumno.apellido LIKE '%?%'");
            $stmt_vigente->bind_param("ss", $nombre, $apellido);
            $stmt_vigente->execute();
            $stmt_vigente->bind_result($nombre_proyecto_v, $nombre_asesor_v, $apellido_asesor_v, $nombre_coasesor_v, $apellido_coasesor_v, 
                                        $nombre_alumno_v, $apellido_alumno_v, $fecha_inicio_v, $fecha_fin_v, $descripcion_v);
            $stmt_vigente->fetch();

            if($stmt) {
                $respuesta = array(
                    'respuesta' => 'correcto',
                    'nombre_proyecto_h' => $nombre_proyecto_h,
                    'nombre_asesor_h' => $nombre_asesor_h,
                    'apellido_asesor_h' => $apellido_asesor_h,
                    'nombre_coasesor_h' => $nombre_coasesor_h,
                    'apellido_coasesor_h' => $apellido_coasesor_h,
                    'nombre_alumno_h' => $nombre_alumno_h,
                    'apellido_alumno_h' => $apellido_alumno_h,
                    'fecha_inicio_h' => $fecha_inicio_h,
                    'fecha_fin_h' => $fecha_fin_h,
                    'descripcion_h' => $descripcion_h,
                    'nombre_proyecto_v' => $nombre_proyecto_v,
                    'nombre_asesor_v' => $nombre_asesor_v,
                    'apellido_asesor_v' => $apellido_asesor_v,
                    'nombre_coasesor_v' => $nombre_coasesor_v,
                    'apellido_coasesor_v' => $apellido_coasesor_v,
                    'nombre_alumno_v' => $nombre_alumno_v,
                    'apellido_alumno_v' => $apellido_alumno_v,
                    'fecha_inicio_v' => $fecha_inicio_v,
                    'fecha_fin_v' => $fecha_fin_v,
                    'descripcion_v' => $descripcion_v
                ); 
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
    } else if ($tabla_a_buscar == 'proyecto') {
        $nombre_a_buscar = filter_var($_POST['nombre_buscar'], FILTER_SANITIZE_STRING);

        try {
            $stmt_historico = $conn->prepare("SELECT proyecto_historico.proyecto, profesor.nombre as nom_asesor, profesor.apellido as ap_asesor, 
                                                    profesor.nombre as nom_asesor2, profesor.apellido as ap_asesor2, 
                                                    alumno.nombre, alumno.apellido, proyecto_historico.fechaInicio, proyecto_historico.fechaFin, 
                                                    proyecto_historico.descripcion /*, proyecto_historico.comentarioFinal */
                                    FROM (((proyecto_historico INNER JOIN alumno ON proyecto_historico.id_alumno=alumno.id) 
                                            INNER JOIN profesor ON profesor.id = proyecto_historico.id_asesor1) 
                                            INNER JOIN profesor ON profesor.id = proyecto_historico.id_asesor2)
                                    WHERE proyecto_historico.proyecto LIKE '%?%'");
            $stmt_historico->bind_param("s", $nombre_a_buscar);
            $stmt_historico->execute();
            $stmt_historico->bind_result($nombre_proyecto_h, $nombre_asesor_h, $apellido_asesor_h, $nombre_coasesor_h, $apellido_coasesor_h, 
                                        $nombre_alumno_h, $apellido_alumno_h, $fecha_inicio_h, $fecha_fin_h, $descripcion_h);
            $stmt_historico->fetch();

            $stmt_vigente = $conn->prepare("SELECT proyecto_vigente.proyecto, profesor.nombre as nom_asesor, profesor.apellido as ap_asesor, 
                                                    profesor.nombre as nom_asesor2, profesor.apellido as ap_asesor2, 
                                                    alumno.nombre, alumno.apellido, proyecto_vigente.fechaInicio, proyecto_vigente.fechaFin, 
                                                    proyecto_vigente.descripcion /*, proyecto_vigente.comentarioFinal */
                                    FROM (((proyecto_vigente INNER JOIN alumno ON proyecto_vigente.id_alumno=alumno.id) 
                                            INNER JOIN profesor ON profesor.id = proyecto_vigente.id_asesor1) 
                                            INNER JOIN profesor ON profesor.id = proyecto_vigente.id_asesor2)
                                    WHERE proyecto_vigente.proyecto LIKE '%?%'");
            $stmt_vigente->bind_param("s", $nombre_a_buscar);
            $stmt_vigente->execute();
            $stmt_vigente->bind_result($nombre_proyecto_v, $nombre_asesor_v, $apellido_asesor_v, $nombre_coasesor_v, $apellido_coasesor_v, 
                                        $nombre_alumno_v, $apellido_alumno_v, $fecha_inicio_v, $fecha_fin_v, $descripcion_v);
            $stmt_vigente->fetch();

            if($stmt) {
                $respuesta = array(
                    'respuesta' => 'correcto',
                    'nombre_proyecto_h' => $nombre_proyecto_h,
                    'nombre_asesor_h' => $nombre_asesor_h,
                    'apellido_asesor_h' => $apellido_asesor_h,
                    'nombre_coasesor_h' => $nombre_coasesor_h,
                    'apellido_coasesor_h' => $apellido_coasesor_h,
                    'nombre_alumno_h' => $nombre_alumno_h,
                    'apellido_alumno_h' => $apellido_alumno_h,
                    'fecha_inicio_h' => $fecha_inicio_h,
                    'fecha_fin_h' => $fecha_fin_h,
                    'descripcion_h' => $descripcion_h,
                    'nombre_proyecto_v' => $nombre_proyecto_v,
                    'nombre_asesor_v' => $nombre_asesor_v,
                    'apellido_asesor_v' => $apellido_asesor_v,
                    'nombre_coasesor_v' => $nombre_coasesor_v,
                    'apellido_coasesor_v' => $apellido_coasesor_v,
                    'nombre_alumno_v' => $nombre_alumno_v,
                    'apellido_alumno_v' => $apellido_alumno_v,
                    'fecha_inicio_v' => $fecha_inicio_v,
                    'fecha_fin_v' => $fecha_fin_v,
                    'descripcion_v' => $descripcion_v
                );  
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