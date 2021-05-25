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

            $date1 = date_create(date("Y-m-d"));
            $date2 = date_create($seguimiento_actual[1]); 
            $interval = date_diff($date1, $date2);
            $interval = $interval->format('%a');

            if (($interval == 1 && $date1 > $date2)) {
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

                // echo "enviar correo, exp";
                // echo "<br/>";
            } else if ($interval == 0) {
                // obtener datos del proyecto, etapa y actividad para la notificación
                $datos_proyectos = ObtenerDatosNotificacion($seguimiento_actual[0]);
                // receptor
                $correo_alumno = ObtenerCorreoConIDProyecto($id_proyecto[0], "alumno");
                $correo_profesor = ObtenerCorreoConIDProyecto($id_proyecto[0], "profesor");
                $mail->addAddress($correo_alumno[0],'Usuario'); // alumno
                $mail->addAddress($correo_profesor[0],'Usuario'); // profesor
                //título
                $mail->Subject = '[Dëni] HOY es la fecha máxima de entrega!';
                $mail->Body = '<h3>Estimado usuario, el proyecto "'. $datos_proyectos[0].'", con clave '.$datos_proyectos[1].' tiene una entrega para máximo hoy.</h3> 
                <p>Hoy es la fecha límite de entrega para la actividad "'.$datos_proyectos[3].'" correspondiente a la etapa "'.$datos_proyectos[2].'".</p><br>
                <p>Saludos cordiales</p>';

                $mail->send();

                // echo "enviar correo, hoy";
                // echo "<br/>";
            } else if($interval == 3 && $date1 < $date2) {
                // obtener datos del proyecto, etapa y actividad para la notificación
                $datos_proyectos = ObtenerDatosNotificacion($seguimiento_actual[0]);
                // receptor
                $correo_alumno = ObtenerCorreoConIDProyecto($id_proyecto[0], "alumno");
                $correo_profesor = ObtenerCorreoConIDProyecto($id_proyecto[0], "profesor");
                $mail->addAddress($correo_alumno[0],'Usuario'); // alumno
                $mail->addAddress($correo_profesor[0],'Usuario'); // profesor
                //título
                $mail->Subject = '[Dëni] La fecha máxima de entrega está próxima a vencer!';
                $mail->Body = '<h3>Estimado usuario, el proyecto "'. $datos_proyectos[0].'", con clave '.$datos_proyectos[1].' tiene una entrega que está por vencer.</h3> 
                <p>La fecha de entrega para la actividad "'.$datos_proyectos[3].'" correspondiente a la etapa "'.$datos_proyectos[2].'" expira en 3 días.</p><br>
                <p>Saludos cordiales</p>';

                $mail->send();

                // echo "enviar correo, pron";
                // echo "<br/>";
            }
        }
    }
?>