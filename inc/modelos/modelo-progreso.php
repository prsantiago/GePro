<?php
session_start();
//obtiene la variable a partir de progreso.php
if($_POST['accion'] == 'Actividad entregada') {
    // Crear un nuevo registro en la base de datos
    require_once('../funciones/conexion.php');
    require_once('../funciones/funciones.php');
    require_once('../funciones/email_settings.php');

    //Obtiene las variables necesarias
    $fecha_actividad = $_POST['fecha_proceso'];
    $id_proyecto = $_SESSION['id_proyecto'];
    $id_seguimiento = $_SESSION['id_seguimiento'];
    $id_etapa = $_SESSION['id_etapa'];
    $id_actividad = $_SESSION['id_actividad'];

    //obtener datos del proyecto para la notificación, tales como el nombre, la etapa
    //la actividad y la clave del proyecto
    $datos_proyectos = ObtenerDatosNotificacion($id_seguimiento);
    //Valores para enviar notificaciones
    //receptor
    $correo_alumno_coasesor = ObtenerCorreoConIDProyecto($id_proyecto, $_SESSION['tipo_usuario']);
    // $correo_alumno_coasesor = ObtenerCorreos($id_proyecto);
    $correo_asesor = ObtenerCorreosConID($_SESSION['id_usuario'], 'profesor');
    $mail->addAddress($correo_alumno_coasesor[0],'Usuario'); //alumno
    // $mail->addAddress($correo_alumno_coasesor[1],'Usuario'); //coasesor
    $mail->addAddress($correo_asesor[0],'Usuario'); //asesor
    //Información que incluirá el correo
    //La variable $mail se obtiene de email_settings.php
    $mail->Subject = '[Dëni] El status de su proyecto ha sido actualizado!';
    $mail->Body = '<h3>Estimado usuario, el proyecto "'. $datos_proyectos[0].'", con clave '.$datos_proyectos[1].' ha sido actualizado.</h3> 
                <p>Se registró la actividad "'.$datos_proyectos[3].'" correspondiente a la etapa "'.$datos_proyectos[2].'", en la fecha '.$fecha_actividad.'.</p>
                <p>De haber alguna inconsistencia, favor de comunicarse con el asesor responsable.</p><br>
                <p>Saludos cordiales</p>';


    try {
        //La entrega de una actividad implica que el último registro del proyecto en la
        //tabla seguimiento se actualiza con la fecha_actividad que se recibe en 
        //progreso.php y se crea un nuevo registro en la tabla seguimiento que calcula
        //la próxima actividad a entregar y la fecha de entrega propuesta.
        //El procedimiento NUEVO_SEGUIMIENTO se encarga de esas tareas.
        $stmt = $conn->prepare("CALL NUEVO_SEGUIMIENTO(?,?,?,?,?,null,false)");
        $stmt->bind_param('iiiis', $id_seguimiento, $id_proyecto, $id_etapa, $id_actividad, $fecha_actividad);
        $stmt->execute();
        //Si se ejecutó el procedimiento correctamente se envía un correo a los involucrados
        if($stmt->errno == 0){ 
            if($mail->send()){
                //Si el correo se envía correctamente se crea esta respuesta para json
                $respuesta = array(
                    'respuesta' => 'correcto',
                    'nombre' => 'Estatus actualizado',
                    'correo' => 'Enviado'
                );    
            } else {
                //Si el correo NO se envía correctamente se crea esta respuesta para json
                $respuesta = array(
                    'respuesta' => 'correcto',
                    'nombre' => 'Estatus actualizado',
                    'correo' => 'NO enviado'
                );
            } 
        } else {
            //Si el procedimiento no se ejecuta correctamente se crea esta respuesta
            $respuesta = array(
                'respuesta' => 'error',
                'error' => 'Error al actualizar el estatus',
                'detalle' => $stmt->errno.' : '.$stmt->error
            );
        }

        //se cierran las conexiones a la base de datos
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

//obtiene la variable a partir de progreso.php
if($_POST['accion'] == 'Aprobar actividad') {

    require_once('../funciones/conexion.php');
    require_once('../funciones/funciones.php');
    require_once('../funciones/email_settings.php');

    //Obtiene las variables necesarias
    $fecha_actividad = $_POST['fecha_proceso'];
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

    //Si la actividad actual es diferente de 4, significa que el proyecto no se encuentra
    //en la última etapa, tesis integrada, por lo que el proyecto avanza, no concluye.
    if($id_actividad!=4){
        //Información que incluirá el correo
        //La variable $mail se obtiene de email_settings.php
        $mail->Subject = '[Dëni] El status de su proyecto ha sido actualizado!';
        $mail->Body = '<h3>Estimado usuario, el proyecto "'. $datos_proyectos[0].'", con clave '.$datos_proyectos[1].' ha sido actualizado.</h3> 
            <p>Se registró que la etapa "'.$datos_proyectos[2].'" fue aprobada en la fecha '.$fecha_actividad.'.</p>
            <p>De haber alguna inconsistencia, favor de comunicarse con el asesor responsable.</p><br>
            <p>Saludos cordiales</p>';

        //La aprobación de una actividad implica que el último registro del proyecto en la
        //tabla seguimiento se actualiza con la fecha_actividad que se recibe en 
        //progreso.php y se crea un nuevo registro en la tabla seguimiento que empieza una
        //nueva etapa desde la actividad a 'entrega' y calcula una fecha de entrega para
        //la misma.
        //El procedimiento NUEVO_SEGUIMIENTO se encarga de esas tareas y su último 
        //parámetro es 'true' para indicar que se trata de una aprobación.
        try {
            $stmt = $conn->prepare("CALL NUEVO_SEGUIMIENTO(?,?,?,?,?,null,true)");
            $stmt->bind_param('iiiis', $id_seguimiento, $id_proyecto, $id_etapa, $id_actividad, $fecha_actividad);
            $stmt->execute();

            //Si se ejecutó el procedimiento correctamente se envía un correo a los involucrados
            if($stmt->errno == 0){ 
                if($mail->send()){
                    //Si el correo se envía correctamente se crea esta respuesta para json 
                    $respuesta = array(
                        'respuesta' => 'correcto',
                        'nombre' => 'Etapa aprobada',
                        'correo' => 'Enviado'
                    );    
                } else{
                    //Si el correo NO se envía correctamente se crea esta respuesta para json
                    $respuesta = array(
                        'respuesta' => 'correcto',
                        'nombre' => 'Etapa aprobada',
                        'correo' => 'NO enviado'
                    );
                } 
            } else {
                //Si el procedimiento no se ejecuta correctamente se crea esta respuesta
                $respuesta = array(
                    'respuesta' => 'error',
                    'error' => 'Error al actualizar el status',
                    'detalle' => $stmt->errno.' : '.$stmt->error
                );
            }

            //Se cierran las conexiones a la base de datos
            $stmt->close();
            $conn->close();
        } catch(Exception $e) {
            // En caso de un error, tomar la exepcion
            $respuesta = array(
                'error' => $e->getMessage()
            );
        }
    } else {
        // TODO: Cambiar estado del alumno a tesista
        //En este caso se aprobó la última actividad de la última etapa, por lo que se da por concluido el proyecto y se obtiene la entrada de $comFinal.

        //Información que incluirá el correo
        $mail->Subject = '[Dëni] Su proyecto ha sido finalizado!';
        $mail->Body = '<h3>Estimado usuario, el proyecto "'. $datos_proyectos[0].' ha sido finalizado.</h3> 
                <p>Se registró la aprobación de la etapa "'.$datos_proyectos[2].'", en la fecha '.$fecha_actividad.'. Dando por finalizado su proyecto.</p>
                <p>Gracias por usar el Sistema Dëni. De haber alguna inconsistencia, favor de comunicarse con el asesor responsable.</p><br>
                <p>Saludos cordiales</p>';

        try {
            $comFinal = filter_var($_POST['comFinal'], FILTER_SANITIZE_STRING);
            //El procedimiento NUEVO_SEGUIMIENTO toma el comentario final que se guarda en
            //la tabla proyecto y actualiza el último registro del proyecto en la tabla 
            //seguimiento con la fecha_actividad, pero no crea un nuevo registro.
            $stmt = $conn->prepare("CALL NUEVO_SEGUIMIENTO(?,?,?,?,?,?,true)");
            $stmt->bind_param('iiiiss', $id_seguimiento, $id_proyecto, $id_etapa, $id_actividad, $fecha_actividad, $comFinal);
            $stmt->execute();
            
            if($stmt->errno == 0){ 
                //Si el procedimiento se ejecutó correctamente se llama a otro procedimiento,
                //HISTÓRICOS se encarga de eliminar los comentarios del proyecto y de enviar 
                //los sus registros en las tablas de seguimiento y proyecto a sus históricos
                //correspondientes, eliminándolos de las tablas vigentes.
                $stmt_historicos = $conn->prepare("CALL FINALIZAR_PROYECTO(?)");
                $stmt_historicos->bind_param('i', $id_proyecto);
                $stmt_historicos->execute();
                if($stmt_historicos->errno == 0){
                    //Si HISTORICOS se ejecutó correctamente se enviará el correo notificando
                    //la finalización del proyecto. 
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
                //Si HISTORICOS no se ejecutó correctamente se manda esta respuesta
                $respuesta = array(
                    'respuesta' => 'error',
                    'error' => 'Error al finalizar el proyecto',
                    'detalle' => $stmt->errno.' : '.$stmt->error
                );
            }

            //cierre de las conexiones
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

// TODO: editar también fecha de próxima entrega del seguimiento (obtener la etapa y/o actividad)
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
    $mail->Subject = '[Dëni] Se ha editado su proyecto!';
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
                    'correo' => 'enviado'
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
                'detalle' => $stmt->errno.' : '.$stmt->error
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