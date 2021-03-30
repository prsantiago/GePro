<?php
session_start();

if($_POST['accion'] == 'Actividad entregada') {
    // Crear un nuevo registro en la base de datos
    require_once('../funciones/conexion.php');

    //Validar entradas
    $fecha_proceso = $_POST['fecha_proceso'];
    $id_proyecto = $_SESSION['id_proyecto'];
    $id_seguimiento = $_SESSION['id_seguimiento'];
    $id_etapa = $_SESSION['id_etapa'];
    $id_actividad = $_SESSION['id_actividad'];

    try {
        // Crear un nuevo seguimiento y actualizar fecha de etapa del anterior seg
        $stmt = $conn->prepare("CALL NUEVO_SEGUIMIENTO(?,?,?,?,?,null,false)");
        $stmt->bind_param('iiiis', $id_seguimiento, $id_proyecto, $id_etapa, $id_actividad, $fecha_proceso);
        $stmt->execute();
        
        if($stmt->affected_rows == 1){ 
            $respuesta = array(
                'respuesta' => 'correcto',
                'nombre' => 'Status actualizado'
            );
        } else {
            $respuesta = array(
                'respuesta' => 'error',
                'error' => 'Error al actualizar el status',
                'detalle' => $stmt->errno.' : '.$stmt->error
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
    $id_etapa = $_SESSION['id_etapa'];
    $id_actividad = $_SESSION['id_actividad'];

    if($id_actividad!=4){
        try {
        
            $stmt = $conn->prepare("CALL NUEVO_SEGUIMIENTO(?,?,?,?,?,null,true)");
            $stmt->bind_param('iiiis', $id_seguimiento, $id_proyecto, $id_etapa, $id_actividad, $fecha_proceso);
            $stmt->execute();

            if($stmt->affected_rows == 1){ 
                $respuesta = array(
                    'respuesta' => 'correcto',
                    'nombre' => 'Etapa aprobada'
                );
            } else {
                $respuesta = array(
                    'respuesta' => 'error',
                    'error' => 'Error al actualizar el status',
                    'detalle' => $stmt->errno.' : '.$stmt->error
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
    }
    else {
        try {
        $comFinal = filter_var($_POST['comFinal'], FILTER_SANITIZE_STRING);

        $stmt = $conn->prepare("CALL NUEVO_SEGUIMIENTO(?,?,?,?,?,?,true)");
        $stmt->bind_param('iiiiss', $id_seguimiento, $id_proyecto, $id_etapa, $id_actividad, $fecha_proceso, $comFinal);
        $stmt->execute();
        
        if($stmt->affected_rows == 1){ 
            $stmt_historicos = $conn->prepare("CALL HISTORICOS(?)");
            $stmt_historicos->bind_param('i', $id_proyecto);
            $stmt_historicos->execute();
            if($stmt_historicos->affected_rows == 1){
                $respuesta = array(
                    'respuesta' => 'correcto',
                    'nombre' => 'Proyecto finalizado!'
                );
            }
            else {
                $respuesta = array(
                    'respuesta' => 'error',
                    'error' => 'Error al generar históricos',
                    'detalle' => $stmt_historicos->errno.' : '.$stmt_historicos->error
                );
            }
        } else {
            $respuesta = array(
                'respuesta' => 'error',
                'error' => 'Error al finalizar el proyecto',
                'detalle' => $stmt->errno.' : '.$stmt->error
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
    }
    
    echo json_encode($respuesta);
}

if ($_POST['accion'] == 'editar') {
    require_once('../funciones/conexion.php');

    $fecha_entrega = $_POST['fecha_entrega'];
    $id_seguimiento = $_POST['id_seguimiento'];

    try {
        $stmt = $conn->prepare("UPDATE seguimiento_vigente SET fecha_entrega=? WHERE id=?");
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
                'detalle' => $stmt->errno.' : '.$stmt->error
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