<?php

if($_POST['accion'] == 'crear') {
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

    try {
        $stmt = $conn->prepare("INSERT INTO profesor (nombre_profesor, apellido_profesor, matricula_profesor, 
                                                    correo_profesor, password_profesor, universidad_profesor,
                                                    division_profesor, departamento_profesor) VALUES (?,?,?,?,?,?,?,?)");
        $stmt->bind_param("ssssssss", $nombre_profesor, $apellido_profesor, $matricula_profesor, $correo_profesor, 
                                        $password_profesor, $universidad_profesor, $division_profesor, $departamento_profesor);
        $stmt->execute();

        if($stmt->affected_rows == 1) {
            $respuesta = array(
                'respuesta' => 'correcto',
                'datos' => array (
                    'id_insertado' => $stmt->insert_id,
                    'nombre_profesor' => $nombre_profesor,
                    'apellido_profesor' => $apellido_profesor,
                    'matricula_profesor' => $matricula_profesor,
                    'correo_profesor' => $correo_profesor,
                    'password_profesor' => $password_profesor,
                    'universidad_profesor' => $universidad_profesor,
                    'division_profesor' => $division_profesor,
                    'departamento_profesor' => $departamento_profesor
                )
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