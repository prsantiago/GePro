<?php
session_start();
if($_POST['accion'] == 'enviar_comentario') {
    // Crear un nuevo registro en la base de datos
    require_once('../funciones/conexion.php');

    //Validar entradas
    $comentario = filter_var($_POST['comentario'], FILTER_SANITIZE_STRING);
    // session_start();
    $id_usuario = $_SESSION['id_usuario'];
    $tipo_usuario = $_SESSION['tipo_usuario'];

    try {
        // Crear el proyecto en la base de datos
        $stmt = $conn->prepare("CALL NUEVO_COMENTARIO(?,?,?,?)");
        $stmt->bind_param('isis', $id_usuario, $tipo_usuario, $id_Seg, $comentario);
        $stmt->execute();
        
        if($stmt){
            $respuesta = array(
                'respuesta' => 'correcto',
                'comentario' => $comentario
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