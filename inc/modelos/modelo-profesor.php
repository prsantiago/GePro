<?php

// Acción INSERT nuevo registro de profesor en la BD
if(isset($_POST['accion'])) {
    if($_POST['accion'] == 'crear') {
        require_once('../funciones/conexion.php');      // Archivo donde se guarda la conexión a la BD
        require_once('../funciones/email_settings.php');
        require_once('../funciones/funciones.php');    // Archivo con las funciones en php

        // Sanitizar las entradas enviadas por POST
        $nombre_profesor = filter_var($_POST['nombre_profesor'], FILTER_SANITIZE_STRING);
        $apellido_profesor = filter_var($_POST['apellido_profesor'], FILTER_SANITIZE_STRING);
        $matricula_profesor = filter_var($_POST['matricula_profesor'], FILTER_SANITIZE_STRING);
        $correo_profesor = filter_var($_POST['correo_profesor'], FILTER_SANITIZE_EMAIL);
        $password_profesor = filter_var($_POST['password_profesor'], FILTER_SANITIZE_STRING);
        $universidad_profesor = filter_var($_POST['universidad_profesor'], FILTER_SANITIZE_STRING);
        $division_profesor = filter_var($_POST['division_profesor'], FILTER_SANITIZE_STRING);
        $departamento_profesor = filter_var($_POST['departamento_profesor'], FILTER_SANITIZE_STRING);

        //revisar que no se encuentre en la base de datos alguien con el mismo correo
        $duplicado = $conn->prepare("SELECT id FROM profesor WHERE correo = ?");
        $duplicado->bind_param("s", $correo_profesor);
        $duplicado->execute();
        $duplicado->bind_result($id_profesor);   // Asignar resultados a variable
        $duplicado->fetch();
        if($id_profesor != null) { //si ya está registrado el correo -> mensaje de error
            $respuesta = array(
                'respuesta' => 'error',
                'error' => 'Ya existe un usuario con este correo'
            );
            $duplicado->close(); 
        } 
        else {
            $duplicado->close();
            // hashear passwords
            $opciones = array(
                'cost' => 12
            );
            $hash_password = password_hash($password_profesor, PASSWORD_BCRYPT, $opciones);

            //para enviar por correo
            $mail->addAddress($correo_profesor,'Usuario');
            $mail->Subject = '[Dëni] Creación de cuenta de profesor';
            $mail->Body = '<h3>¡Bienvenido! </h3> <h3>Estimado usuario, gracias por registrarse en el Sistema Dëni para el seguimiento de proyectos.</h3> 
                <p>Para ingresar al sistema:</p> 
                <ol>
                    <li>Inicie sesión con este correo electrónico ('.$correo_profesor.').</li>
                    <li>Su contraseña es <strong>'.$password_profesor.'</strong>.</li>
                    <li>Ahora puede dar de alta proyectos y alumnos.</li>
                    <li>También puede editar los datos de su cuenta en cualquier momento.</li>
                </ol>
                <p>Esperamos que este sistema le sea de gran utilidad.</p><br>
                <p>Saludos cordiales</p>';

            // Se trata de realizar el INSERT a través de Prepared Statement
            // Checamos que una fila haya sido afectada (quiere decir que si se realizó el query), se manda como respuesta: correcto, id_insertado
            // Si el query fallo, se manda como respuesta: error y el detalle del error (número y descripción)
            // Se cierra el Prepared Statement y la conexión a BD
            // Se regresa la respuesta por JSON
            try {
                $stmt = $conn->prepare("INSERT INTO profesor VALUES (null,?,?,?,?,?,?,?,?)");
                $stmt->bind_param("ssssssss", $matricula_profesor, $nombre_profesor, $apellido_profesor,  $correo_profesor, $hash_password, $universidad_profesor, $division_profesor, $departamento_profesor);
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
                        'error' => 'No se pudo crear usuario',
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
        }

        echo json_encode($respuesta);
    }
}

// Acción UPDATE un registro de profesor en la BD
if(isset($_POST['accion'])) {
    if($_POST['accion'] == 'editar') {
        require_once('../funciones/conexion.php');      // Archivo donde se guarda la conexión a la BD

        // Validar las entradas
        $nombre_profesor = filter_var($_POST['nombre_profesor'], FILTER_SANITIZE_STRING);
        $apellido_profesor = filter_var($_POST['apellido_profesor'], FILTER_SANITIZE_STRING);
        $matricula_profesor = filter_var($_POST['matricula_profesor'], FILTER_SANITIZE_STRING);
        $correo_profesor = filter_var($_POST['correo_profesor'], FILTER_SANITIZE_EMAIL);
        $password_profesor = filter_var($_POST['password_profesor'], FILTER_SANITIZE_STRING);
        $universidad_profesor = filter_var($_POST['universidad_profesor'], FILTER_SANITIZE_STRING);
        $division_profesor = filter_var($_POST['division_profesor'], FILTER_SANITIZE_STRING);
        $departamento_profesor = filter_var($_POST['departamento_profesor'], FILTER_SANITIZE_STRING);
        session_start();                            // Se empieza la sesión para traer el valor de las variables de sesión necesarias
        $id_usuario = $_SESSION['id_usuario'];

        // hashear passwords
        $opciones = array(
            'cost' => 12
        );
        $hash_password = password_hash($password_profesor, PASSWORD_BCRYPT, $opciones);

        // Se trata de realizar el UPDATE a través de Prepared Statement
        // Checamos que una fila haya sido afectada (quiere decir que si se realizó el query)
        //      - Se guarda el nombre y apellido del profesor en su correspondiente variable de sesión
        //        Se manda como respuesta: correcto, id_usuario
        // Se cierra el Prepared Statement y la conexión a BD
        // Se regresa la respuesta por JSON
        try {
            $stmt = $conn->prepare("UPDATE profesor SET nombre = ?, apellido = ?, matricula = ?, 
                                                        correo = ?, contraseña = ?, universidad = ?,
                                                        division = ?, departamento = ? WHERE id = ?");
            $stmt->bind_param("ssssssssi", $nombre_profesor, $apellido_profesor, $matricula_profesor, $correo_profesor, 
                                            $hash_password, $universidad_profesor, $division_profesor, $departamento_profesor, $id_usuario);
            $stmt->execute();

            if($stmt->affected_rows == 1) {
                $_SESSION['nombre_usuario'] = $nombre_profesor;
                $_SESSION['apellido_usuario'] = $apellido_profesor;
                $respuesta = array(
                    'respuesta' => 'correcto',
                    'id_usuario' => $id_usuario
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

// Acción SELECT registro de alumno y validar con valores enviados por POST para su inicio de sesión
if(isset($_POST['tipo'])) {
    if($_POST['tipo'] == 'login') {
        require_once('../funciones/conexion.php');      // Acción donde se guarda la conexión a la BD

        // Sanitizar las entradas enviadas por POST
        $usuario = filter_var($_POST['usuario'], FILTER_SANITIZE_EMAIL);
        $password = filter_var($_POST['password'], FILTER_SANITIZE_STRING);
        
        // Se trata de realizar el SELECT a través de Prepared Statement
        // Si la variable nombre_usuario no está vacía es que si existe el usuario
        //      - Se revisa la contraseña
        //              - Se guarda nombre, apellido, universidad, id_usuario, logueado y que es profesor como variables de sesión
        //                Se manda como respuesta: correcto, nombre y apellido
        //      - Contraseña es erronea, se manda error
        // Si no existe el usuario, se manda error
        // Se cierra el Prepared Statement y la conexión a BD
        // Se regresa la respuesta por JSON
        try {
            $stmt = $conn->prepare("SELECT nombre, apellido, id, contraseña, universidad FROM profesor WHERE correo = ?");
            $stmt->bind_param('s', $usuario);
            $stmt->execute();
            $stmt->bind_result($nombre_usuario, $apellido_usuario, $id_usuario, $pass_usuario, $universidad_usuario);   // Asignar resultados a variables
            $stmt->fetch();
            if($nombre_usuario){
                if(password_verify($password,$pass_usuario)) {
                    session_start();            // Se empieza la sesión para traer el valor de las variables de sesión necesarias
                    $_SESSION['nombre_usuario'] = $nombre_usuario;
                    $_SESSION['apellido_usuario'] = $apellido_usuario;
                    $_SESSION['universidad_usuario'] = $universidad_usuario;
                    $_SESSION['id_usuario'] = $id_usuario;
                    $_SESSION['login'] = true;
                    $_SESSION['tipo_usuario'] = 'profesor';
                    $respuesta = array(
                        'respuesta' => 'correcto',
                        'usuario' => $nombre_usuario.' '.$apellido_usuario
                    );
                } else {
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
            $respuesta = array(
                'error' => $e->getMessage()
            );
        }
        
        echo json_encode($respuesta);
    }
}

?>