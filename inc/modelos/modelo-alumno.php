<?php

// Acción INSERT nuevo registro de alumno en la BD
if($_POST['accion'] == 'crear') {
    require_once('../funciones/conexion.php');          // Archvo donde se guarda la conexión a la DB
    require_once('../funciones/email_settings.php');    // Archivo con los ajustes para enviar notificaión de registro por mail
    require_once('../funciones/funciones.php');    // Archivo con las funciones en php
    
    // Sanitizar las entradas enviadas por POST
    $nombre_alumno = filter_var($_POST['nombre_alumno'], FILTER_SANITIZE_STRING);
    $apellido_alumno = filter_var($_POST['apellido_alumno'], FILTER_SANITIZE_STRING);
    $matricula_alumno = filter_var($_POST['matricula_alumno'], FILTER_SANITIZE_STRING);
    $correo_alumno = filter_var($_POST['correo_alumno'], FILTER_SANITIZE_EMAIL);
    $password_alumno = filter_var($_POST['password_alumno'], FILTER_SANITIZE_STRING);
    $universidad_alumno = filter_var($_POST['universidad_alumno'], FILTER_SANITIZE_STRING);
    $division_alumno = filter_var($_POST['division_alumno'], FILTER_SANITIZE_STRING);
    $carrera_alumno = filter_var($_POST['carrera_alumno'], FILTER_SANITIZE_STRING);
    $estado_alumno = filter_var($_POST['estado_alumno'], FILTER_SANITIZE_NUMBER_INT);

    // hashear contraseña
    $opciones = array(
        'cost' => 12
    );
    $hash_password = password_hash($password_alumno, PASSWORD_BCRYPT, $opciones);

    // Configuración del mail a enviar (destino, tema, contenido)
    $mail->addAddress($correo_alumno,'Usuario');
    $mail->Subject = '[Dëni] Se ha creado una cuenta de alumno para usted';
    $mail->Body = '<h3>¡Bienvenido! </h3> <h3>Estimado usuario, se le ha creado una cuenta de alumno en el Sistema Dëni para el seguimiento de proyectos.</h3> 
        <p>Para ingresar al sistema debe seguir los siguientes pasos:</p> 
        <ol>
            <li>Una vez que se haya dado de alta un proyecto a su nombre, le llegará un correo con
            la clave que empleará para visualizar sus avances.</li>
            <li>Diríjase al portal: [página_portal_index] e ingrese la clave del proyecto. </li>
            <li>Podrá visualizar sus avances y las fechas correspondientes.</li>
            <li>Inicie sesión con este correo electrónico ('.$correo_alumno.') y con la 
            siguiente contraseña <strong>'.$password_alumno.'</strong>.</li>
            <li>De ser posible, cambie su contraseña.</li>
            <li>Para realizar un comentario a su asesor, seleccione la fecha en la actividad que le interesa comentar.</li>
            <li>También puede editar los datos de su cuenta.</li>
        </ol>
        <p>Esperamos que este sistema le sea de gran utilidad.</p><br>
        <p>Saludos cordiales</p>';

    // Se trata de realizar el INSERT a través de Prepared Statement
    // Checamos que una fila haya sido afectada (quiere decir que si se realizó el query)
    //      - Si el mail se pudo enviar, se manda como respuesta: correcto, id_insertado y enviado
    //      - Si el mail NO se pudo enviar, se manda como respuesta: correcto, id_insertado y NO enviado
    // Si el query fallo, se manda como respuesta: error y el detalle del error (número y descripción)
    // Se cierra el Prepared Statement y la conexión a BD
    // Se regresa la respuesta por JSON
    try {
        $duplicado = $conn->prepare("SELECT nombre FROM alumno WHERE correo = ?");
        $duplicado->bind_param('s', $correo_alumno);
        $duplicado->execute();
        $duplicado->bind_result($nombre_al);
        $duplicado->fetch();
        if($nombre_al){
            $respuesta = array(
                'respuesta' => 'error',
                'error' => 'El alumno ya ha sido registrado.'
            ); 
        } else {
            $stmt = $conn->prepare("INSERT INTO alumno VALUES (null,?,?,?,?,?,?,?,?,?)");
            $stmt->bind_param("ssssssssi", $matricula_alumno, $nombre_alumno, $apellido_alumno,  $correo_alumno, $hash_password,$universidad_alumno, $division_alumno, $carrera_alumno, $estado_alumno);
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
                    'detalle' => $stmt->errno.' : '.$stmt->error
                );
            }
            $stmt->close();
        }

        $conn->close();
    } catch(Exception $e) {
        $respuesta = array(
            'error' => $e->getMessage()
        );
    }

    echo json_encode($respuesta);
}

// Acción UPDATE un registro de alumno en la BD
if($_POST['accion'] == 'editar') {
    require_once('../funciones/conexion.php');  // Archivo donde se guarda la conexión a la DB

    // Sanitizar las entradas enviadas por POST
    $nombre_alumno = filter_var($_POST['nombre_alumno'], FILTER_SANITIZE_STRING);
    $apellido_alumno = filter_var($_POST['apellido_alumno'], FILTER_SANITIZE_STRING);
    $matricula_alumno = filter_var($_POST['matricula_alumno'], FILTER_SANITIZE_STRING);
    $correo_alumno = filter_var($_POST['correo_alumno'], FILTER_SANITIZE_EMAIL);
    $password_alumno = filter_var($_POST['password_alumno'], FILTER_SANITIZE_STRING);
    $universidad_alumno = filter_var($_POST['universidad_alumno'], FILTER_SANITIZE_STRING);
    $division_alumno = filter_var($_POST['division_alumno'], FILTER_SANITIZE_STRING);
    $carrera_alumno = filter_var($_POST['carrera_alumno'], FILTER_SANITIZE_STRING);
    session_start();                            // Se empieza la sesión para traer el valor de las variables de sesión necesarias
    $id_usuario = $_SESSION['id_usuario'];
    $id_proyecto = $_SESSION['id_proyecto'];

    // hashear passwords
    $opciones = array(
        'cost' => 12
    );
    $hash_password = password_hash($password_alumno, PASSWORD_BCRYPT, $opciones);

    // Se trata de realizar el UPDATE a través de Prepared Statement
    // Checamos que una fila haya sido afectada (quiere decir que si se realizó el query)
    //      - Se guarda el nombre y apellido del alumno en su correspondiente variable de sesión
    //        Se manda como respuesta: correcto, id_usuario y id_proyecto
    // Se cierra el Prepared Statement y la conexión a BD
    // Se regresa la respuesta por JSON
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

// Acción SELECT registro de alumno y validar con valores enviados por POST para su inicio de sesión
if($_POST['accion'] == 'login') {
    require_once('../funciones/conexion.php');      // Archivo donde se guarda la conexión a la DB
    require_once('../funciones/funciones.php');     // Archivo donde se almacenan funciones SQL adicionales

    // Sanitizar las entradas enviadas por POST
    $usuario = filter_var($_POST['usuario'], FILTER_SANITIZE_EMAIL);
    $password = filter_var($_POST['password'], FILTER_SANITIZE_STRING);
    
    // Se trata de realizar el SELECT a través de Prepared Statement
    // Si la variable nombre_usuario no está vacía es que si existe el usuario
    //      - Se revisa que el alumno que quiere iniciar sesión sea el asignado al proyecto que ingresó para ver su progreso
    //          - Se revisa la contraseña
    //                  - Se guarda nombre, apellido, id_usuario, logueado y que es alumno como variables de sesión
    //                    Se manda como respuesta: correcto, nombre y apellido, id_proyecto
    //          - Contraseña es erronea, se manda error
    //      - El usuario que quiere iniciar sesión no es el asignado al proyecto, se manda error
    // Si no existe el usuario, se manda error
    // Se cierra el Prepared Statement y la conexión a BD
    // Se regresa la respuesta por JSON
    try {
        $stmt = $conn->prepare("SELECT nombre, apellido, id, contraseña FROM alumno WHERE correo = ?");
        $stmt->bind_param('s', $usuario);
        $stmt->execute();
        $stmt->bind_result($nombre_usuario, $apellido_usuario, $id_usuario, $pass_usuario);     // Asignar resultados a variables
        $stmt->fetch();
        if($nombre_usuario){
            session_start();         // Se empieza la sesión para traer el valor de las variables de sesión necesarias
            $id_proyecto = $_SESSION['id_proyecto'];
            $usuario_proyecto = obtenerAlumnoProyecto($id_proyecto);    // Traer alumno asignado al proyecto que se está desplegando en progreso.php
            
            if($id_usuario == $usuario_proyecto[0]) {
                if(password_verify($password,$pass_usuario)){
                    $_SESSION['nombre_usuario'] = $nombre_usuario;
                    $_SESSION['apellido_usuario'] = $apellido_usuario;
                    $_SESSION['id_usuario'] = $id_usuario;
                    $_SESSION['login'] = true;
                    $_SESSION['tipo_usuario'] = 'alumno';
                    $respuesta = array(
                        'respuesta' => 'correcto',
                        'usuario' => $nombre_usuario.' '.$apellido_usuario,
                        'id_proyecto' => $id_proyecto
                    );
                } else {
                    $respuesta = array(
                        'error' => 'Password Incorrecto'
                    );
                }
            } else {
                $respuesta = array(
                    'error' => 'Usuario no tiene este proyecto'
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
        $respuesta = array(
            'error' => $e->getMessage()
        );
    }
    
    echo json_encode($respuesta);
}

?>