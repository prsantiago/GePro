<?php

if($_POST['accion'] == 'checar') {
    // Crear un nuevo registro en la base de datos
    require_once('../funciones/conexion.php');

    $clave = filter_var($_POST['clave'], FILTER_SANITIZE_STRING);

    try {
        // Seleccionar el profesor de la base de datos
        $stmt = $conn->prepare("SELECT nombre, id FROM proyecto_vigente WHERE clave = ?");
        $stmt->bind_param('s', $clave);
        $stmt->execute();
        // Loguear el usuario
        $stmt->bind_result($nombre_proyecto, $id_proyecto);
        $stmt->fetch();
        if($nombre_proyecto){
            // Iniciar la sesion
            session_start();
            $_SESSION['nombre_proyecto'] = $nombre_proyecto;
            $_SESSION['id_proyecto'] = $id_proyecto;
            $_SESSION['login'] = false;
            // Login correcto
            $respuesta = array(
                'respuesta' => 'correcto',
                'nombre' => $nombre_proyecto
            );
        } else {
            $respuesta = array(
                'error' => 'Proyecto no existe'
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