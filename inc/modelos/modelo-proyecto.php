<?php
session_start();

if($_POST['accion'] == 'crear') {
    // Crear un nuevo registro en la base de datos
    require_once('../funciones/conexion.php');
    require_once('../funciones/funciones.php');
    require_once('../funciones/email_settings.php');

    //Validar entradas
    // No sanitizamos id_alumno y id_coasesor porque lo obtenemos directamente de la BD
    $nombre_proyecto = filter_var($_POST['nombre'], FILTER_SANITIZE_STRING);
    $id_alumno = $_POST['id_alumno'];
    // session_start();
    $id_asesor1 = $_SESSION['id_usuario'];
    $id_coasesor = $_POST['id_coasesor'] ?: NULL;
    $fecha = filter_var($_POST['fecha'], FILTER_SANITIZE_STRING);
    $descripcion = filter_var($_POST['descripcion'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW);
    $universidad_usuario = $_SESSION['universidad_usuario'];

    //para enviar correo que notifique la creación del proyecto
    $correo_alumno = ObtenerCorreosConID($id_alumno,'alumno');
    $correo_asesor = ObtenerCorreosConID($id_asesor1,'profesor');
    if($id_coasesor != NULL) {
        $correo_coasesor = ObtenerCorreosConID($id_coasesor,'profesor');
        $mail->addAddress($correo_coasesor[0],'Coasesor');
    }

    $mail->addAddress($correo_alumno[0],'Alumno');
    $mail->addAddress($correo_asesor[0],'Asesor');
    //título
    $mail->Subject = '[GePro] Se ha creado un proyecto a su nombre!';
    $mail->Body = '<h3>Estimado usuario, el proyecto "'. $nombre_proyecto.'", con clave (algo) ha sido creado!.</h3> 
        <p>Descripción del proyecto: '.$descripcion.'</p>
        <p>Fecha de inicio: '.$fecha.'</p>
        <p>Para visualizar los avances de su proyecto ingrese la clave en el portal: nombre_portal.</p>
        <p>Saludos cordiales</p>';


    try {
        // Crear el proyecto en la base de datos
        $stmt = $conn->prepare("CALL NUEVO_PROYECTO(?,?,?,?,?,?,?)");
        $stmt->bind_param('iiissss', $id_asesor1, $id_coasesor, $id_alumno, $nombre_proyecto, $fecha, $descripcion, $universidad_usuario);
        $stmt->execute();
        
        if($stmt->errno == 0){ 
            if($mail->send()) {
                $respuesta = array(
                'respuesta' => 'correcto',
                'nombre' => $nombre_proyecto,
                'correo' => 'enviado'
                );
            } else{
                $respuesta = array(
                'respuesta' => 'correcto',
                'nombre' => $nombre_proyecto,
                'correo' => 'NO enviado'
                );
            }
        } else {
            $respuesta = array(
                'respuesta' => 'error',
                'error' => 'Error al crear el proyecto',
                'detalle' => $stmt->errno.' : '.$stmt->error
            );
        }

        $stmt->close();
        $conn->close();
    } catch(Exception $e) {
        // En caso de un error, tomar la exepcion
        $respuesta = array(
            'respuesta' => 'error',
            'error' => $e->getMessage()
        );
    }

    echo json_encode($respuesta);
}

if($_POST['accion'] == 'editar') {
    // Crear un nuevo registro en la base de datos
    require_once('../funciones/conexion.php');

    //Validar entradas
    // No sanitizamos id_alumno y id_coasesor porque lo obtenemos directamente de la BD
    $nombre_proyecto = filter_var($_POST['nombre'], FILTER_SANITIZE_STRING);
    $id_alumno = $_POST['id_alumno'];
    // session_start();
    $id_asesor1 = $_SESSION['id_usuario'];
    $id_coasesor = $_POST['id_coasesor'] ?: NULL;
    $fecha = filter_var($_POST['fecha'], FILTER_SANITIZE_STRING);
    $descripcion = filter_var($_POST['descripcion'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW);
    $id_proyecto = $_POST['id_proyecto'];

    try {
        // Crear el proyecto en la base de datos
        $stmt = $conn->prepare("UPDATE proyecto_vigente SET id_asesor1 = ?, id_asesor2 = ?, id_alumno = ?, 
                                                            proyecto = ?, fechaInicio = ?, descripcion = ?
                                WHERE id = ?");
        $stmt->bind_param('iiisssi', $id_asesor1, $id_coasesor, $id_alumno, $nombre_proyecto, $fecha, $descripcion, $id_proyecto);
        $stmt->execute();
        
        if($stmt->errno == 0){ 
            $respuesta = array(
                'respuesta' => 'correcto',
                'nombre' => $nombre_proyecto          
            );
        } else {
            $respuesta = array(
                'respuesta' => 'error',
                'error' => 'Error al crear el proyecto',
                'detalle' => $stmt->errno.' : '.$stmt->error
            );
        }

        $stmt->close();
        $conn->close();
    } catch(Exception $e) {
        // En caso de un error, tomar la exepcion
        $respuesta = array(
            'respuesta' => 'error',
            'error' => $e->getMessage()
        );
    }

    echo json_encode($respuesta);
}

if($_GET['accion'] == 'borrar') {
    // Crear un nuevo registro en la base de datos
    require_once('../funciones/conexion.php');

    //Validar entradas
    $id_proyecto = $_GET['id'];

    try {
        // Crear el proyecto en la base de datos
        $stmt = $conn->prepare("CALL BORRAR_PROYECTO(?)");
        $stmt->bind_param('i', $id_proyecto);
        $stmt->execute();
        
        if($stmt->errno == 0){ 
            $respuesta = array(
                'respuesta' => 'correcto',
                'nombre' => $nombre_proyecto          
            );
        } else {
            $respuesta = array(
                'respuesta' => 'error',
                'error' => 'Error al crear el proyecto',
                'detalle' => $stmt->errno.' : '.$stmt->error,
                'id' => $id_proyecto
            );
        }

        $stmt->close();
        $conn->close();
    } catch(Exception $e) {
        // En caso de un error, tomar la exepcion
        $respuesta = array(
            'respuesta' => 'error',
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
        $stmt = $conn->prepare("SELECT proyecto, id FROM proyecto_vigente WHERE clave = ?");
        $stmt->bind_param('s', $clave);
        $stmt->execute();
        // Loguear el usuario
        $stmt->bind_result($nombre_proyecto, $id_proyecto);
        $stmt->fetch();
        if($nombre_proyecto){
            // Iniciar la sesion
            // $_SESSION['nombre_proyecto'] = $nombre_proyecto;
            // $_SESSION['id_proyecto'] = $id_proyecto;
            // Login correcto
            $respuesta = array(
                'respuesta' => 'correcto',
                'nombre' => $nombre_proyecto,
                'id_proyecto' => $id_proyecto
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