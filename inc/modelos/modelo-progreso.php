<?php
session_start();

if($_POST['accion'] == 'Actividad entregada') {
    // Crear un nuevo registro en la base de datos
    require_once('../funciones/conexion.php');
    require_once('../funciones/funciones.php');
    require_once('../funciones/email_settings.php');

    //Validar entradas
    $fecha_proceso = $_POST['fecha_proceso'];
    $id_proyecto = $_SESSION['id_proyecto'];
    $id_seguimiento = $_SESSION['id_seguimiento'];
    $id_etapa = $_SESSION['id_etapa'];
    $id_actividad = $_SESSION['id_actividad'];

    //obtener datos del proyecto para la notificación
    $datos_proyectos = ObtenerDatosNotificacion($id_seguimiento);
    //Valores para enviar notificaciones
    //receptor
    // TODO: usar obtenerCorreosConIDProyecto por mientras, en xampp se cambia a obtenerCorreos
    $correo_alumno_coasesor = ObtenerCorreoConIDProyecto($id_proyecto, $_SESSION['tipo_usuario']);
    // $correo_alumno_coasesor = ObtenerCorreos($id_proyecto);
    // echo json_encode($correo_alumno_coasesor);
    $correo_asesor = ObtenerCorreosConID($_SESSION['id_usuario'], 'profesor');
    $mail->addAddress($correo_alumno_coasesor[0],'Usuario'); //alumno
    // $mail->addAddress($correo_alumno_coasesor[1],'Usuario'); //coasesor
    $mail->addAddress($correo_asesor[0],'Usuario'); //asesor
    //título
    $mail->Subject = '[GePro] El status de su proyecto ha sido actualizado!';
    $mail->Body = '<h3>Estimado usuario, el proyecto "'. $datos_proyectos[0].'", con clave '.$datos_proyectos[1].' ha sido actualizado.</h3> 
                <p>Se registró la actividad "'.$datos_proyectos[3].'" correspondiente a la etapa "'.$datos_proyectos[2].'", en la fecha '.$fecha_proceso.'.</p>
                <p>De haber alguna inconsistencia, favor de comunicarse con el asesor responsable.</p><br>
                <p>Saludos cordiales</p>';


    try {
        // Crear un nuevo seguimiento y actualizar fecha de etapa del anterior seg
        $stmt = $conn->prepare("CALL NUEVO_SEGUIMIENTO(?,?,?,?,?,null,false)");
        $stmt->bind_param('iiiis', $id_seguimiento, $id_proyecto, $id_etapa, $id_actividad, $fecha_proceso);
        $stmt->execute();
        
        if($stmt->errno == 0){ 
            if($mail->send()){
                $respuesta = array(
                    'respuesta' => 'correcto',
                    'nombre' => 'Status actualizado',
                    // 'correo' => 'Enviado a '.$correo_alumno_coasesor[0].', '.$correo_alumno_coasesor[1].' y '.$correo_asesor[0]
                    'correo' => 'Enviado a '.$correo_alumno_coasesor[0].' y '.$correo_asesor[0]
                );    
            } else {
                $respuesta = array(
                    'respuesta' => 'correcto',
                    'nombre' => 'Status actualizado',
                    'correo' => 'NO enviado'
                );
            } 
        } else {
            $respuesta = array(
                'respuesta' => 'error',
                'error' => 'Error al actualizar el status',
                'detalle' => $stmt->errno.' : '.$stmt->error
            );
        }

        $stmt->close();
        $conn->close();
    } catch(Exception $e) {
        // En caso de un error, tomar la exepcion
        $respuesta = array(
            'error' => $e->getMessage()
        );
    }

    echo json_encode($respuesta);
}

if($_POST['accion'] == 'Aprobar actividad') {

    require_once('../funciones/conexion.php');
    require_once('../funciones/funciones.php');
    require_once('../funciones/email_settings.php');

    $fecha_proceso = $_POST['fecha_proceso'];
    $id_proyecto = $_SESSION['id_proyecto'];
    $id_seguimiento = $_SESSION['id_seguimiento'];
    $id_etapa = $_SESSION['id_etapa'];
    $id_actividad = $_SESSION['id_actividad'];

    //obtener datos del proyecto para la notificación
    $datos_proyectos = ObtenerDatosNotificacion($id_seguimiento);
    //Valores para enviar notificaciones
    //receptor
    // $correo_alumno_coasesor = ObtenerCorreos($id_proyecto);
    $correo_alumno_coasesor = ObtenerCorreoConIDProyecto($id_proyecto, $_SESSION['tipo_usuario']);
    $correo_asesor = ObtenerCorreosConID($_SESSION['id_usuario'], 'profesor');
    $mail->addAddress($correo_alumno_coasesor[0],'Usuario'); //alumno
    // $mail->addAddress($correo_alumno_coasesor[1],'Usuario'); //coasesor
    $mail->addAddress($correo_asesor[0],'Usuario'); //asesor

    if($id_actividad!=4){
        //título
        $mail->Subject = '[GePro] El status de su proyecto ha sido actualizado!';
        $mail->Body = '<h3>Estimado usuario, el proyecto "'. $datos_proyectos[0].'", con clave '.$datos_proyectos[1].' ha sido actualizado.</h3> 
            <p>Se registró que la etapa "'.$datos_proyectos[2].'" fue aprobada en la fecha '.$fecha_proceso.'.</p>
            <p>De haber alguna inconsistencia, favor de comunicarse con el asesor responsable.</p><br>
            <p>Saludos cordiales</p>';

        try {
        
            $stmt = $conn->prepare("CALL NUEVO_SEGUIMIENTO(?,?,?,?,?,null,true)");
            $stmt->bind_param('iiiis', $id_seguimiento, $id_proyecto, $id_etapa, $id_actividad, $fecha_proceso);
            $stmt->execute();

            if($stmt->errno == 0){ 
                if($mail->send()){
                    $respuesta = array(
                        'respuesta' => 'correcto',
                        'nombre' => 'Etapa aprobada',
                        'correo' => 'Enviado a '.$correo_alumno_coasesor[0].', '.$correo_alumno_coasesor[1].' y '.$correo_asesor[0]
                    );    
                } else{
                    $respuesta = array(
                        'respuesta' => 'correcto',
                        'nombre' => 'Etapa aprobada',
                        'correo' => 'NO enviado'
                    );
                } 
            } else {
                $respuesta = array(
                    'respuesta' => 'error',
                    'error' => 'Error al actualizar el status',
                    'detalle' => $stmt->errno.' : '.$stmt->error
                );
            }

            $stmt->close();
            $conn->close();
        } catch(Exception $e) {
            // En caso de un error, tomar la exepcion
            $respuesta = array(
                'error' => $e->getMessage()
            );
        }
    } else {
        //título
        $mail->Subject = '[GePro] Su proyecto ha sido finalizado!';
        $mail->Body = '<h3>Estimado usuario, el proyecto "'. $datos_proyectos[0].' se ha concluido.</h3> 
                <p>Se registró la aprobación de la etapa "'.$datos_proyectos[2].'", en la fecha '.$fecha_proceso.'. Dando por finalizado su proyecto.</p>
                <p>De haber alguna inconsistencia, favor de comunicarse con el asesor responsable.</p><br>
                <p>Saludos cordiales</p>';

        try {
            $comFinal = filter_var($_POST['comFinal'], FILTER_SANITIZE_STRING);

            $stmt = $conn->prepare("CALL NUEVO_SEGUIMIENTO(?,?,?,?,?,?,true)");
            $stmt->bind_param('iiiiss', $id_seguimiento, $id_proyecto, $id_etapa, $id_actividad, $fecha_proceso, $comFinal);
            $stmt->execute();
            
            if($stmt->errno == 0){ 
                $stmt_historicos = $conn->prepare("CALL HISTORICOS(?)");
                $stmt_historicos->bind_param('i', $id_proyecto);
                $stmt_historicos->execute();
                if($stmt_historicos->errno == 0){
                    if($mail->send()){
                        $respuesta = array(
                            'respuesta' => 'correcto',
                            'nombre' => 'Proyecto finalizado!',
                            'correo' => 'Enviado'
                        );    
                    } else{
                        $respuesta = array(
                            'respuesta' => 'correcto',
                            'nombre' => 'Proyecto finalizado!',
                            'correo' => 'NO enviado'
                        );
                    }
                } else {
                    $respuesta = array(
                        'respuesta' => 'error',
                        'error' => 'Error al generar históricos',
                        'detalle' => $stmt_historicos->errno.' : '.$stmt_historicos->error
                    );
                }
            } else {
                $respuesta = array(
                    'respuesta' => 'error',
                    'error' => 'Error al finalizar el proyecto',
                    'detalle' => $stmt->errno.' : '.$stmt->error
                );
            }

            $stmt->close();
            $conn->close();
        } catch(Exception $e) {
            // En caso de un error, tomar la exepcion
            $respuesta = array(
                'error' => $e->getMessage()
            );
        }
    }
    
    echo json_encode($respuesta);
}

// FIXME: Se puede editar seguimientos sin tener una fecha de entrega, arreglar
if ($_POST['accion'] == 'editar') {
    require_once('../funciones/conexion.php');
    require_once('../funciones/funciones.php');
    require_once('../funciones/email_settings.php');

    $fecha_entrega = $_POST['fecha_entrega'];
    $id_seguimiento = $_POST['id_seguimiento'];

    // obtener datos del proyecto, etapa y actividad para la notificación
    $datos_proyectos = ObtenerDatosNotificacion($id_seguimiento);

    // echo json_encode($datos_proyectos);

    // receptor
    $correo_a_usar = ObtenerCorreoConIDProyecto($_SESSION['id_proyecto'], $_SESSION['tipo_usuario']);
    // echo json_encode($correo_a_usar);
    $mail->addAddress($correo_a_usar[0],'Usuario'); //asesor
    //título
    $mail->Subject = '[GePro] Se ha agregado un nuevo comentario a su proyecto!';
    // $mail->Body = '<p>Se registro un nuevo comentario en su proyecto</p>';
    $mail->Body = '<h3>Estimado usuario, el proyecto "'. $datos_proyectos[0].'", con clave '.$datos_proyectos[1].' fue editado.</h3> 
                <p>Se cambió la fecha de entrega a '.$fecha_entrega.' de la actividad "'.$datos_proyectos[3].'" correspondiente a la etapa "'.$datos_proyectos[2].'".</p><br>
                <p>Saludos cordiales</p>';


    try {
        $stmt = $conn->prepare("UPDATE seguimiento_vigente SET fecha_entrega=? WHERE id=?");
        $stmt->bind_param('si', $fecha_entrega, $id_seguimiento);
        $stmt->execute();

        if ($stmt->errno == 0) {
            if($mail->send()) {
                $respuesta = array(
                    'respuesta' => 'correcto',
                    'nombre' => 'Fecha actualizada',
                    'id_seguimiento' => $id_seguimiento,
                    'correo' => 'enviado a '.$correo_a_usar[0]
                );
            } else {
                $respuesta = array(
                    'respuesta' => 'correcto',
                    'nombre' => 'Fecha actualizada',
                    'id_seguimiento' => $id_seguimiento,
                    'correo' => 'no enviado'
                );
            }
        } else {
            $respuesta = array(
                'respuesta' => 'error',
                'error' => 'Error al actualizar fecha de entrega',
                'detalle' => $stmt->errno.' : '.$stmt->error,
                'correo' => $correo_a_usar[0]
            );
        }

        $stmt->close();
        $conn->close();
    } catch (Exception $e) {
        $respuesta = array(
            'error' => "Error al actualizar fecha de entrega",
            'fecha' => $fecha_entrega,
            'id' => $id_seguimiento
        );
    }

    echo json_encode($respuesta);
}

?>