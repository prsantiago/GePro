<?php
session_start();
if($_POST['accion'] == 'crear') {
    // Crear un nuevo registro en la base de datos
    require_once('../funciones/conexion.php');

    //Validar entradas
    $nombre_proyecto = filter_var($_POST['nombre'], FILTER_SANITIZE_STRING);
    $correo_alumno = filter_var($_POST['correo_alumno'], FILTER_SANITIZE_EMAIL);
    // session_start();
    $id_asesor1 = $_SESSION['id_usuario'];
    $correo_coasesor = filter_var($_POST['correo_coasesor'], FILTER_SANITIZE_EMAIL);
    $fecha = filter_var($_POST['fecha'], FILTER_SANITIZE_STRING);
    $descripcion = filter_var($_POST['descripcion'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW);
    //se debe crear algoritmo para la clave del proyecto
    // $clave = "TUAM-2153";

    try {
        // Crear el proyecto en la base de datos
        $stmt = $conn->prepare("CALL NUEVO_PROYECTO(?,?,?,?,?,?)");
        $stmt->bind_param('isssss', $id_asesor1, $correo_coasesor, $correo_alumno, $nombre_proyecto, $fecha, $descripcion);
        $stmt->execute();
        
        if($stmt){
            $respuesta = array(
                'respuesta' => 'correcto',
                'nombre' => $nombre_proyecto
            );
        } else {
            $respuesta = array(
                'error' => 'Error al crear el proyecto'
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
            $_SESSION['nombre_proyecto'] = $nombre_proyecto;
            $_SESSION['id_proyecto'] = $id_proyecto;
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