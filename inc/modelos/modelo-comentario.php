<?php

if($_POST['accion'] == 'crear') {
    // Crear un nuevo registro en la base de datos
    require_once('../funciones/conexion.php');

    //Validar entradas
    $comentario = filter_var($_POST['comentario'], FILTER_SANITIZE_STRING);
    session_start();
    $nombre_usuario = $_SESSION['nombre_usuario'];
    $apellido_usuario = $_SESSION['apellido_usuario'];
    $id_seguimiento = $_SESSION['id_seguimiento'];

    try {
        // Crear el proyecto en la base de datos
        $stmt = $conn->prepare("CALL NUEVO_COMENTARIO(?,?,?,?)");
        $stmt->bind_param('ssis', $nombre_usuario, $apellido_usuario, $id_seguimiento, $comentario);
        $stmt->execute();
        
        if($stmt->affected_rows == 1) {
            $respuesta = array(
                'respuesta' => 'correcto',
                'id_insertado' => $stmt->insert_id
            );
        } else {
            $respuesta = array(
                'error' => 'Error al enviar el comentario'
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