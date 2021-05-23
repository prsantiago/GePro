<?php

// Acción INSERT nuevo registro de comentario en la BD
if($_POST['accion'] == 'crear') {
    require_once('../funciones/conexion.php');          // Archivo donde se guarda la conexión a la BD
    require_once('../funciones/funciones.php');         // Archivo donde se almacenan funciones SQL adicionales
    require_once('../funciones/email_settings.php');    // Archivo con los ajustes para enviar notificación de registro por mail

    // Sanitizar la entrada enviada por POST
    $comentario = filter_var($_POST['comentario'], FILTER_SANITIZE_STRING);

    // Se empieza la sesión para traer el valor de las variables de sesión necesarias
    session_start();
    $nombre_usuario = $_SESSION['nombre_usuario'];
    $apellido_usuario = $_SESSION['apellido_usuario'];
    $id_etapa = $_SESSION['id_etapa'];
    $id_actividad = $_SESSION['id_actividad'];
    $id_proyecto = $_SESSION['id_proyecto'];
    $id_seguimiento = $_SESSION['id_seguimiento'];

    // obtener datos del proyecto, etapa y actividad para la notificación
    $datos_proyectos = ObtenerDatosNotificacion($id_seguimiento);

    // Al checar qué tipo de usuario hizo el comentario (profesor o alumno) se obtiene el correo del usuario contrario (alumno o profesor, respectivamente).
    $correo_a_usar = ObtenerCorreoConIDProyecto($id_proyecto, $_SESSION['tipo_usuario']);
    
    // Configuración del mail a enviar (destino, tema, contenido)
    $mail->addAddress($correo_a_usar[0],'Usuario'); 
    $mail->Subject = '[Dëni] Se ha agregado un nuevo comentario a su proyecto!';
    $mail->Body = '<h3>Estimado usuario, el proyecto "'. $datos_proyectos[0].'", con clave '.$datos_proyectos[1].' tiene un nuevo comentario.</h3> 
                <p>Se registró en la actividad "'.$datos_proyectos[3].'" correspondiente a la etapa "'.$datos_proyectos[2].'".</p><br>
                <p>Saludos cordiales</p>';

    // Se trata de realizar el INSERT a través de Prepared Statement
    // Checamos que una fila haya sido afectada (quiere decir que si se realizó el query)
    //      - Si el mail se pudo enviar, se manda como respuesta: correcto, id_insertado, id_etapa, id_actividad y enviado
    //      - Si el mail NO se pudo enviar, se manda como respuesta: correcto, id_insertado, id_etapa, id_actividad y NO enviado
    // Si el query fallo, se manda como respuesta: error y el detalle del error (número y descripción)
    // Se cierra el Prepared Statement y la conexión a BD
    // Se regresa la respuesta por JSON
    try {
        $stmt = $conn->prepare("CALL NUEVO_COMENTARIO(?,?,?,?,?,?)");
        $stmt->bind_param('ssiiis', $nombre_usuario, $apellido_usuario, $id_proyecto, $id_etapa, $id_actividad,$comentario);
        $stmt->execute();
        
        if($stmt->affected_rows == 1) {
            if($mail->send()) {
                $respuesta = array(
                    'respuesta' => 'correcto',
                    'id_insertado' => $stmt->insert_id,
                    'id_etapa' => $id_etapa,
                    'id_actividad' => $id_actividad,
                    'correo' => 'enviado'
                );
            } else {
                $respuesta = array(
                    'respuesta' => 'correcto',
                    'id_insertado' => $stmt->insert_id,
                    'id_etapa' => $id_etapa,
                    'id_actividad' => $id_actividad,
                    'correo' => 'NO enviado'
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
        $respuesta = array(
            'error' => $e->getMessage()
        );
    }

    echo json_encode($respuesta);
}

?>