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
        $stmt = $conn->prepare("CALL NUEVO_SEGUIMIENTO(?,?,?,?,?,false)");
        $stmt->bind_param('iiiis', $id_seguimiento, $id_proyecto, $id_entrega, $id_proceso, $fecha_proceso);
        $stmt->execute();
        
        if($stmt->affected_rows == 1){ 
            $respuesta = array(
                'respuesta' => 'correcto',
                'nombre' => 'Status actualizado'
            );
        } else {
            $respuesta = array(
                'respuesta' => 'error',
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

if($_POST['accion'] == 'Aprobar actividad') {
    // Crear un nuevo registro en la base de datos
    require_once('../funciones/conexion.php');

    $fecha_proceso = $_POST['fecha_proceso'];
    $id_proyecto = $_SESSION['id_proyecto'];
    $id_seguimiento = $_SESSION['id_seguimiento'];
    $id_entrega = $_SESSION['id_entrega'];
    $id_proceso = $_SESSION['id_proceso'];

    try {
        // Seleccionar el profesor de la base de datos
        $stmt = $conn->prepare("CALL NUEVO_SEGUIMIENTO(?,?,?,?,?,true)");
        $stmt->bind_param('iiiis', $id_seguimiento, $id_proyecto, $id_entrega, $id_proceso, $fecha_proceso);
        $stmt->execute();
        
        if($stmt->affected_rows == 1){ 
            $respuesta = array(
                'respuesta' => 'correcto',
                'nombre' => 'Etapa aprobada'
            );
        } else {
            $respuesta = array(
                'respuesta' => 'error',
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

if ($_POST['accion'] == 'editar') {
    require_once('../funciones/conexion.php');

    $fecha_entrega = $_POST['fecha-entrega'];
    $id_seguimiento = $_POST['id_seguimiento'];

    try {
        $stmt = $conn->prepare("UPDATE seguimiento_vigente SET entrega=? WHERE id=?");
        $stmt->bind_param('si', $fecha_entrega, $id_seguimiento);
        $stmt->execute();

        if ($stmt->affected_rows == 1) {
            $respuesta = array(
                'respuesta' => 'correcto',
                'nombre' => 'Fecha actualizada',
                'id_seguimiento' => $id_seguimiento
            );
        } else {
            $respuesta = array(
                'respuesta' => 'error',
                'error' => 'Error al actualizar fecha de entrega',
                'id' => $id_seguimiento
            );
        }

        $stmt->close();
        $conn->close();
    } catch (Exception $e) {
        $respuesta = array(
            'error' => "Error al actualizar fecha de entrega",
            'fecha' => $fecha_entrega,
            'id' => $id_seguimiento
        );
    }

    echo json_encode($respuesta);
}

?>