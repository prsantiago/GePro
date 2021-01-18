<?php

if($_POST['accion_alumno'] == 'crear') {
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
    $estado_alumno = filter_var($_POST['estado_alumno'], FILTER_SANITIZE_NUMBER_INT);
    $claveproyecto_alumno = filter_var($_POST['claveproyecto_alumno'], FILTER_SANITIZE_STRING);

    // hashear passwords
    $opciones = array(
        'cost' => 12
    );
    $hash_password = password_hash($password_alumno, PASSWORD_BCRYPT, $opciones);

    try {
        $stmt = $conn->prepare("INSERT INTO alumno (nombre_alumno, apellido_alumno, matricula_alumno, 
                                                    correo_alumno, password_alumno, universidad_alumno,
                                                    division_alumno, carrera_alumno, estado_alumno, claveproyecto_alumno) VALUES (?,?,?,?,?,?,?,?,?,?)");
        $stmt->bind_param("ssssssssis", $nombre_alumno, $apellido_alumno, $matricula_alumno, $correo_alumno, $hash_password,
                                        $universidad_alumno, $division_alumno, $carrera_alumno, $estado_alumno, $claveproyecto_alumno);
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

?>