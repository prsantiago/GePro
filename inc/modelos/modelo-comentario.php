<?php

if($_POST['accion'] == 'crear') {
    // Crear un nuevo registro en la base de datos
    require_once('../funciones/conexion.php');
    require_once('../funciones/funciones.php');
    require_once('../funciones/email_settings.php');

    //Validar entradas
    $comentario = filter_var($_POST['comentario'], FILTER_SANITIZE_STRING);
    session_start();
    $nombre_usuario = $_SESSION['nombre_usuario'];
    $apellido_usuario = $_SESSION['apellido_usuario'];
    $id_etapa = $_SESSION['id_etapa'];
    $id_actividad = $_SESSION['id_actividad'];
    $id_proyecto = $_SESSION['id_proyecto'];
    $id_seguimiento = $_SESSION['id_seguimiento'];

    // obtener datos del proyecto, etapa y actividad para la notificación
    $datos_proyectos = ObtenerDatosNotificacion($id_seguimiento);

    // receptor
    $correo_a_usar = ObtenerCorreoConIDProyecto($id_proyecto, $_SESSION['tipo_usuario']);
    $mail->addAddress($correo_a_usar[0],'Usuario'); //asesor
    //título
    $mail->Subject = '[GePro] Se ha agregado un nuevo comentario a su proyecto!';
    // $mail->Body = '<p>Se registro un nuevo comentario en su proyecto</p>';
    $mail->Body = '<h3>Estimado usuario, el proyecto "'. $datos_proyectos[0].'", con clave '.$datos_proyectos[1].' tiene un nuevo comentario.</h3> 
                <p>Se registró en la actividad "'.$datos_proyectos[3].'" correspondiente a la etapa "'.$datos_proyectos[2].'".</p><br>
                <p>Saludos cordiales</p>';

    try {
        // Crear el proyecto en la base de datos
        $stmt = $conn->prepare("CALL NUEVO_COMENTARIO(?,?,?,?,?,?)");
        $stmt->bind_param('ssiiis', $nombre_usuario, $apellido_usuario, $id_proyecto, $id_etapa, $id_actividad,$comentario);
        $stmt->execute();
        
        if($stmt->affected_rows == 1) {
            if($mail->send()) {
                $respuesta = array(
                    'respuesta' => 'correcto',
                    'id_etapa' => $id_etapa,
                    'id_actividad' => $id_actividad,
                    'correo' => 'enviado a '.$correo_a_usar[0]
                );
            } else {
                $respuesta = array(
                    'respuesta' => 'correcto',
                    'id_insertado' => $stmt->insert_id,
                    'id_etapa' => $id_etapa,
                    'id_actividad' => $id_actividad,
                    'correo' => 'enviado'
                );
            }
        } else {
            $respuesta = array(
                'respuesta' => 'error',
                'error' => 'Error al enviar el comentario',
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

?>