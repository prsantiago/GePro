<?php

if($_POST['accion'] == 'crear') {
    // Crear un nuevo registro en la base de datos
    require_once('../funciones/conexion.php');

    // Validar las entradas
    $nombre_profesor = filter_var($_POST['nombre_profesor'], FILTER_SANITIZE_STRING);
    $apellido_profesor = filter_var($_POST['apellido_profesor'], FILTER_SANITIZE_STRING);
    $matricula_profesor = filter_var($_POST['matricula_profesor'], FILTER_SANITIZE_STRING);
    $correo_profesor = filter_var($_POST['correo_profesor'], FILTER_SANITIZE_EMAIL);
    $password_profesor = filter_var($_POST['password_profesor'], FILTER_SANITIZE_STRING);
    $universidad_profesor = filter_var($_POST['universidad_profesor'], FILTER_SANITIZE_STRING);
    $division_profesor = filter_var($_POST['division_profesor'], FILTER_SANITIZE_STRING);
    $departamento_profesor = filter_var($_POST['departamento_profesor'], FILTER_SANITIZE_STRING);

    // hashear passwords
    $opciones = array(
        'cost' => 12
    );
    $hash_password = password_hash($password_profesor, PASSWORD_BCRYPT, $opciones);

    // importar la conexion
    try {
        $stmt = $conn->prepare("INSERT INTO profesor (nombre, apellido, matricula, 
                                                    correo, contraseña, universidad,
                                                    division, departamento) VALUES (?,?,?,?,?,?,?,?)");
        $stmt->bind_param("ssssssss", $nombre_profesor, $apellido_profesor, $matricula_profesor, $correo_profesor, 
                                        $hash_password, $universidad_profesor, $division_profesor, $departamento_profesor);
        $stmt->execute();

        if($stmt->affected_rows == 1) {
            $respuesta = array(
                'respuesta' => 'correcto',
                'id_insertado' => $stmt->insert_id
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

if($_POST['tipo'] == 'login') {
    require_once('../funciones/conexion.php');

    $usuario = filter_var($_POST['usuario'], FILTER_SANITIZE_EMAIL);
    $password = filter_var($_POST['password'], FILTER_SANITIZE_STRING);
    
    try {
        // Seleccionar el profesor de la base de datos
        $stmt = $conn->prepare("SELECT nombre, apellido, id, contraseña, universidad FROM profesor WHERE correo = ?");
        $stmt->bind_param('s', $usuario);
        $stmt->execute();
        // Loguear el usuario
        $stmt->bind_result($nombre_usuario, $apellido_usuario, $id_usuario, $pass_usuario, $universidad_usuario);
        $stmt->fetch();
        if($nombre_usuario){
            // El usuario existe, verificar el password
            if(password_verify($password,$pass_usuario)) {
                // Iniciar la sesion
                session_start();
                $_SESSION['nombre_usuario'] = $nombre_usuario;
                $_SESSION['apellido_usuario'] = $apellido_usuario;
                $_SESSION['universidad_usuario'] = $universidad_usuario;
                $_SESSION['id_usuario'] = $id_usuario;
                $_SESSION['login'] = true;
                $_SESSION['tipo_usuario'] = 'profesor';
                // Login correcto
                $respuesta = array(
                    'respuesta' => 'correcto',
                    'usuario' => $nombre_usuario.' '.$apellido_usuario
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