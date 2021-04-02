<?php

if($_POST['accion'] == 'crear') {
    // Crear un nuevo registro en la base de datos
    require_once('../funciones/conexion.php');
    require_once('../funciones/email_settings.php');

    // Validar las entradas
    $nombre_alumno = filter_var($_POST['nombre_alumno'], FILTER_SANITIZE_STRING);
    $apellido_alumno = filter_var($_POST['apellido_alumno'], FILTER_SANITIZE_STRING);
    $matricula_alumno = filter_var($_POST['matricula_alumno'], FILTER_SANITIZE_STRING);
    $correo_alumno = filter_var($_POST['correo_alumno'], FILTER_SANITIZE_EMAIL);
    $password_alumno = filter_var($_POST['password_alumno'], FILTER_SANITIZE_STRING);
    $universidad_alumno = filter_var($_POST['universidad_alumno'], FILTER_SANITIZE_STRING);
    $division_alumno = filter_var($_POST['division_alumno'], FILTER_SANITIZE_STRING);
    $carrera_alumno = filter_var($_POST['carrera_alumno'], FILTER_SANITIZE_STRING);
    $estado_alumno = filter_var($_POST['estado_alumno'], FILTER_SANITIZE_NUMBER_INT);

    // hashear passwords
    $opciones = array(
        'cost' => 12
    );
    $hash_password = password_hash($password_alumno, PASSWORD_BCRYPT, $opciones);

    $mail->addAddress($correo_alumno,'Usuario');
    $mail->Subject = '[GePro] Se ha creado una cuenta de alumno para usted';
    $mail->Body = '<h3>¡Bienvenido! </h3> <h3>Estimado usuario, se le ha creado una cuenta de alumno en el sistema GePro para el seguimiento de proyectos.</h3> 
        <p>Para ingresar al sistema debe seguir los siguientes pasos:</p> 
        <ol>
            <li>Una vez se haya dado de alta un proyecto a su nombre, le llegará un correo con
            la clave que empleará para visualizar sus avances.</li>
            <li>Diríjase al portal: página_portal e ingrese la clave del proyecto. </li>
            <li>Podrá visualizar sus avances y las fechas correspondientes.</li>
            <li>Para realizar un comentario a su asesor, seleccione la fecha en la actividad
            que le interesa comentar.</li>
            <li>Inicie sesión con este correo electrónico ('.$correo_alumno.') y con la 
            siguiente contraseña <strong>'.$password_alumno.'</strong></p>.</li>
            <li>De ser posible, cambie su contraseña.</li>
            <li>Ahora puede comentar.</li>
        </ol>
        <p>De haber alguna inconsistencia con sus datos, favor de comunicarse con el asesor responsable.</p><br>
        <p>Saludos cordiales</p>';


    try {
        $stmt = $conn->prepare("INSERT INTO alumno (nombre, apellido, matricula, 
                                                    correo, contraseña, universidad,
                                                    division, carrera, id_estado) VALUES (?,?,?,?,?,?,?,?,?)");
        $stmt->bind_param("ssssssssi", $nombre_alumno, $apellido_alumno, $matricula_alumno, $correo_alumno, $hash_password,
                                        $universidad_alumno, $division_alumno, $carrera_alumno, $estado_alumno);
        $stmt->execute();

        if($stmt->affected_rows == 1) {
            if($mail->send()){
                $respuesta = array(
                    'respuesta' => 'correcto',
                    'id_insertado' => $stmt->insert_id,
                    'correo' => 'enviado'
                );    
            }
            else {
                $respuesta = array(
                    'respuesta' => 'correcto',
                    'id_insertado' => $stmt->insert_id,
                    'correo' => 'NO enviado'
                ); 
            }
        } else {
            $respuesta = array(
                'respuesta' => 'error',
                'error' => 'Error al crear alumno',
                'id_usuario' => $stmt->errno.' : '.$stmt->error
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

if($_POST['accion'] == 'editar') {
    // Crear un nuevo registro en la base de datos
    require_once('../funciones/conexion.php');

    // Validar las entradas
    $nombre_alumno = filter_var($_POST['nombre_alumno'], FILTER_SANITIZE_STRING);
    $apellido_alumno = filter_var($_POST['apellido_alumno'], FILTER_SANITIZE_STRING);
    $matricula_alumno = filter_var($_POST['matricula_alumno'], FILTER_SANITIZE_STRING);
    $correo_alumno = filter_var($_POST['correo_alumno'], FILTER_SANITIZE_EMAIL);
    $password_alumno = filter_var($_POST['password_alumno'], FILTER_SANITIZE_STRING);
    $universidad_alumno = filter_var($_POST['universidad_alumno'], FILTER_SANITIZE_STRING);
    $division_alumno = filter_var($_POST['division_alumno'], FILTER_SANITIZE_STRING);
    $carrera_alumno = filter_var($_POST['carrera_alumno'], FILTER_SANITIZE_STRING);
    session_start();
    $id_usuario = $_SESSION['id_usuario'];
    $id_proyecto = $_SESSION['id_proyecto'];

    // hashear passwords
    $opciones = array(
        'cost' => 12
    );
    $hash_password = password_hash($password_alumno, PASSWORD_BCRYPT, $opciones);

    try {
        $stmt = $conn->prepare("UPDATE alumno SET nombre = ?, apellido = ?, matricula = ?, 
                                                    correo = ?, contraseña = ?, universidad = ?,
                                                    division = ?, carrera = ? WHERE id = ?");
        $stmt->bind_param("ssssssssi", $nombre_alumno, $apellido_alumno, $matricula_alumno, $correo_alumno, $hash_password,
                                        $universidad_alumno, $division_alumno, $carrera_alumno, $id_usuario);
        $stmt->execute();

        if($stmt->affected_rows == 1) {
            $_SESSION['nombre_usuario'] = $nombre_alumno;
            $_SESSION['apellido_usuario'] = $apellido_alumno;
            $respuesta = array(
                'respuesta' => 'correcto',
                'id_usuario' => $id_usuario,
                'id_proyecto' => $id_proyecto
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

if($_POST['accion'] == 'login') {
    require_once('../funciones/conexion.php');

    $usuario = filter_var($_POST['usuario'], FILTER_SANITIZE_EMAIL);
    $password = filter_var($_POST['password'], FILTER_SANITIZE_STRING);
    
    try {
        // Seleccionar el profesor de la base de datos
        $stmt = $conn->prepare("SELECT nombre, apellido, id, contraseña FROM alumno WHERE correo = ?");
        $stmt->bind_param('s', $usuario);
        $stmt->execute();
        // Loguear el usuario
        $stmt->bind_result($nombre_usuario, $apellido_usuario, $id_usuario, $pass_usuario);
        $stmt->fetch();
        if($nombre_usuario){
            // El usuario existe, verificar el password
            if(password_verify($password,$pass_usuario)){
                // Iniciar la sesion
                session_start();
                $_SESSION['nombre_usuario'] = $nombre_usuario;
                $_SESSION['apellido_usuario'] = $apellido_usuario;
                $_SESSION['id_usuario'] = $id_usuario;
                $_SESSION['login'] = true;
                $_SESSION['tipo_usuario'] = 'alumno';
                // Login correcto
                $respuesta = array(
                    'respuesta' => 'correcto',
                    'usuario' => $nombre_usuario.' '.$apellido_usuario,
                    'id_proyecto' => $_SESSION['id_proyecto']
                );
            } else {
                // Login incorrecto, enviar error
                $respuesta = array(
                    'error' => 'Password Incorrecto'
                );
            }
        } else {
            $respuesta = array(
                'error' => 'Usuario no existe'
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