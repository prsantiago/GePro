<?php
session_start();

if($_POST['accion'] == 'Actividad entregada') {
    // Crear un nuevo registro en la base de datos
    require_once('../funciones/conexion.php');

    //Validar entradas
    $fecha_proceso = $_POST['fecha_proceso'];
    $id_proyecto = $_SESSION['id_proyecto'];
    $id_seguimiento = $_SESSION['id_seguimiento'];
    $id_entrega = $_SESSION['id_entrega'];
    $id_proceso = $_SESSION['id_proceso'];

    try {
        // Crear un nuevo seguimiento y actualizar fecha de entrega del anterior seg
        $stmt = $conn->prepare("CALL SEGUIMIENTO_RETRO(?,?,?,?,?)");
        $stmt->bind_param('iiiis', $id_seguimiento, $id_proyecto, $id_entrega, $id_proceso, $fecha_proceso);
        $stmt->execute();
        
        if($stmt){ 
            $respuesta = array(
                    'respuesta' => 'correcto',
                    'nombre' => 'Status actualizado'
            );
        } else {
            $respuesta = array(
                'error' => 'Error al actualizar el status'
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

if($_POST['accion'] == 'Aprobar etapa') {
    // Crear un nuevo registro en la base de datos
    require_once('../funciones/conexion.php');

    $fecha_proceso = $_POST['fecha_proceso'];
    $id_proyecto = $_SESSION['id_proyecto'];
    $id_seguimiento = $_SESSION['id_seguimiento'];
    $id_entrega = $_SESSION['id_entrega'];
    $id_proceso = $_SESSION['id_proceso'];

    try {
        // Seleccionar el profesor de la base de datos
        $stmt = $conn->prepare("CALL SEGUIMIENTO_APROBADO(?,?,?,?,?)");
        $stmt->bind_param('iiiis', $id_seguimiento, $id_proyecto, $id_entrega, $id_proceso, $fecha_proceso);
        $stmt->execute();
        
         if($stmt){ 
            $respuesta = array(
                    'respuesta' => 'correcto',
                    'nombre' => 'Etapa aprobada'
            );
        } else {
            $respuesta = array(
                'error' => 'Error al actualizar el status'
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