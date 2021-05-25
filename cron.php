<!-- si son las 12 -->
    <!-- obtenerUltimoSeguimientoDeProyectos -->
        <!-- fecha del sistema > fechaProximaEntrega -->
            <!-- enviar la notificacion -->

<?php 
    require_once('inc/funciones/funciones.php');
    require_once('inc/funciones/conexion.php');
    require_once('inc/funciones/email_settings.php');

    // si son las 12
    if (date("H:i:s")) {
        // obtener ultimo seguimiento de todos los proyectos
        // nos regresa los id de todos los proyectos
        $id_proyectos = obtenerIDProyectos();
        foreach ($id_proyectos as $id_proyecto) {
            $seguimiento_actual = obtenerFechaSeguimientoActual($id_proyecto[0]);
            if (date("Y-m-d") > $seguimiento_actual[1]) {
            // if ("2021-05-21" > $seguimiento_actual[1]) {


                // obtener datos del proyecto, etapa y actividad para la notificación
                $datos_proyectos = ObtenerDatosNotificacion($seguimiento_actual[0]);
                // receptor
                $correo_alumno = ObtenerCorreoConIDProyecto($id_proyecto[0], "alumno");
                $correo_profesor = ObtenerCorreoConIDProyecto($id_proyecto[0], "profesor");
                $mail->addAddress($correo_alumno[0],'Usuario'); // alumno
                $mail->addAddress($correo_profesor[0],'Usuario'); // profesor
                //título
                $mail->Subject = '[Dëni] La fecha máxima de entrega se ha pasado!';
                $mail->Body = '<h3>Estimado usuario, el proyecto "'. $datos_proyectos[0].'", con clave '.$datos_proyectos[1].' tiene una entrega pendiente.</h3> 
                <p>La fecha de entrega para la actividad "'.$datos_proyectos[3].'" correspondiente a la etapa "'.$datos_proyectos[2].'" ha expirado.</p><br>
                <p>Saludos cordiales</p>';

                $mail->send();

                echo "enviar correo";
                echo "<br/>";
            } else if(date("Y-m-d") < $seguimiento_actual[1]) {
                $date1 = date_create(date("Y-m-d"));
                $date2 = date_create($seguimiento_actual[1]);
                $interval = date_diff($date1, $date2);
                echo (date("Y-m-d")." - ".$seguimiento_actual[1]." = ".$interval->format('%a'))."<br/>";
                echo "todavía hay tiempo";
                echo "<br/>";
            }
        }
    }
?>