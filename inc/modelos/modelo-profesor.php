<?php

if($_POST['accion_profesor'] == 'crear') {
    // Crear un nuevo registro en la base de datos
    require_once('../funciones/conexion.php');

    // Validar las entradas
    $nombre_profesor = filter_var($_POST['nombre_profesor'], FILTER_SANITIZE_STRING);
    $apellido_profesor = filter_var($_POST['apellido_profesor'], FILTER_SANITIZE_STRING);
    $matricula_profesor = filter_var($_POST['matricula_profesor'], FILTER_SANITIZE_STRING);
    $correo_profesor = filter_var($_POST['correo_profesor'], FILTER_SANITIZE_STRING);
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

        $stmt = $conn->prepare("INSERT INTO profesor (nombre_profesor, apellido_profesor, matricula_profesor, 
                                                    correo_profesor, password_profesor, universidad_profesor,
                                                    division_profesor, departamento_profesor) VALUES (?,?,?,?,?,?,?,?)");
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

?>