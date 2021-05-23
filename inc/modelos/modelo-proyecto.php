<?php
session_start();        // Se empieza la sesión para traer el valor de las variables de sesión necesarias

// Acción procedure NUEVO_PROYECTO registro de proyecto en la BD
if($_POST['accion'] == 'crear') {
    require_once('../funciones/conexion.php');          // Archivo donde se guarda la conexión a la BD
    require_once('../funciones/funciones.php');         // Archivo donde se almacenan funciones SQL adicionales
    require_once('../funciones/email_settings.php');    // Archivo con los ajustes para enviar notificación de registro por mail

    // Sanitizar las entradas enviadas por POST
    $nombre_proyecto = filter_var($_POST['nombre'], FILTER_SANITIZE_STRING);
    $fecha = filter_var($_POST['fecha'], FILTER_SANITIZE_STRING);
    $descripcion = filter_var($_POST['descripcion'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW);
    // No sanitizamos id_alumno y id_coasesor porque lo obtenemos directamente de la BD
    $id_alumno = $_POST['id_alumno'];
    $id_coasesor = $_POST['id_coasesor'] ?: NULL;

    $id_asesor1 = $_SESSION['id_usuario'];
    $universidad_usuario = $_SESSION['universidad_usuario'];
    $clave_proy = generarClaveProyecto($id_alumno,$universidad_usuario);

    // Obtiene correos de alumno, asesor y checa si tiene co-asesor para recuperar su correo
    $correo_alumno = ObtenerCorreosConID($id_alumno,'alumno');
    $correo_asesor = ObtenerCorreosConID($id_asesor1,'profesor');
    if($id_coasesor != NULL) {
        $correo_coasesor = ObtenerCorreosConID($id_coasesor,'profesor');
        $mail->addAddress($correo_coasesor[0],'Coasesor');
    }

    // Configuración del mail a enviar (destino, tema, contenido)
    $mail->addAddress($correo_alumno[0],'Alumno');
    $mail->addAddress($correo_asesor[0],'Asesor');
    //título
    $mail->Subject = '[Dëni] Se ha creado un proyecto a su nombre!';
    $mail->Body = '<h3>Estimado usuario, el proyecto "'. $nombre_proyecto.'", con clave "'.$clave_proy.'" ha sido creado!.</h3>
        <p>Descripción del proyecto: '.$descripcion.'</p>
        <p>Fecha de inicio: '.$fecha.'</p>
        <p>Para visualizar los avances de su proyecto ingrese la clave en el portal: nombre_portal.</p>
        <p>Saludos cordiales</p>';


    // Se trata de llamar al procedure NUEVO_PROYECTO a través de Prepared Statement
    // Se checa que el stmt no tenga un número de error
    //      - Si el mail se pudo enviar, se manda como respuesta: correcto, nombre_proyecto y enviado
    //      - Si el mail NO se pudo enviar, se manda como respuesta: correcto, nombre_proyecto y NO enviado
    // Si el query falló, se manda como respuesta: error y el detalle del error (número y descripción)
    // Se cierra el Prepared Statement y la conexión a BD
    // Se regresa la respuesta por JSON
    try {
        $stmt = $conn->prepare("CALL NUEVO_PROYECTO(?,?,?,?,?,?,?,?)");
        $stmt->bind_param('iiisssss', $id_asesor1, $id_coasesor, $id_alumno, $nombre_proyecto, $fecha, $descripcion, $universidad_usuario, $clave_proy);
        $stmt->execute();
        
        if($stmt->errno == 0){ 
            if($mail->send()) {
                $respuesta = array(
                'respuesta' => 'correcto',
                'nombre' => $nombre_proyecto,
                'correo' => 'enviado',
                'clave' => $clave_proy
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
        $respuesta = array(
            'respuesta' => 'error',
            'error' => $e->getMessage()
        );
    }

    echo json_encode($respuesta);
}

// Acción UPDATE un registro de proyecto en la BD
if($_POST['accion'] == 'editar') {
    require_once('../funciones/conexion.php');      // Archivo donde se guarda la conexión a la BD

    // Sanitizar las entradas enviadas por POST
    $nombre_proyecto = filter_var($_POST['nombre'], FILTER_SANITIZE_STRING);
    $fecha = filter_var($_POST['fecha'], FILTER_SANITIZE_STRING);
    $descripcion = filter_var($_POST['descripcion'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW);
    // No sanitizamos id_alumno, id_coasesor y id_proyecto porque lo obtenemos directamente de la BD
    $id_alumno = $_POST['id_alumno'];
    $id_coasesor = $_POST['id_coasesor'] ?: NULL;
    $id_proyecto = $_POST['id_proyecto'];

    $id_asesor1 = $_SESSION['id_usuario'];

    // Se trata de realizar el UPDATE a través de Prepared Statement
    // Se checa que el stmt no tenga un número de error, se manda como respuesta: correcto, nombre_proyecto
    // Si el query falló, se manda como respuesta: error y el detalle del error (número y descripción)
    // Se cierra el Prepared Statement y la conexión a BD
    // Se regresa la respuesta por JSON
    try {
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
        $respuesta = array(
            'respuesta' => 'error',
            'error' => $e->getMessage()
        );
    }

    echo json_encode($respuesta);
}

// Acción procedure BORRAR_PROYECTO registro de proyecto en la BD
if($_GET['accion'] == 'borrar') {
    require_once('../funciones/conexion.php');      // Archivo donde se guarda la conexión a la BD

    // id_proyecto enviado por GET
    $id_proyecto = $_GET['id'];

    // Se trata de llamar al procedure BORRAR_PROYECTO a través de Prepared Statement
    // Se checa que el stmt no tenga un número de error, se manda como respuesta: correcto y nombre_proyecto
    // Si el query falló, se manda como respuesta: error, el detalle del error (número y descripción) y id_proyecto
    // Se cierra el Prepared Statement y la conexión a BD
    // Se regresa la respuesta por JSON
    try {
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
        $respuesta = array(
            'respuesta' => 'error',
            'error' => $e->getMessage()
        );
    }

    echo json_encode($respuesta);
}

// Acción SELECT registro de proyecto de la BD
if($_POST['accion'] == 'checar') {
    require_once('../funciones/conexion.php');      // Archivo donde se guarda la conexión a la BD

    // Sanitizar las entradas enviadas por POST
    $clave = filter_var($_POST['clave'], FILTER_SANITIZE_STRING);

    // Se trata de realizar el SELECT a través de Prepared Statement
    // Si la variable nombre_proyecto no está vacía es que si existe el proycto, se manda como respuesta: correcto, nombre_proyecto y id_proyecto
    // Si no existe el proyecto, se manda error
    // Se cierra el Prepared Statement y la conexión a BD
    // Se regresa la respuesta por JSON
    try {
        $stmt = $conn->prepare("SELECT proyecto, id FROM proyecto_vigente WHERE clave = ?");
        $stmt->bind_param('s', $clave);
        $stmt->execute();
        $stmt->bind_result($nombre_proyecto, $id_proyecto);
        $stmt->fetch();
        if($nombre_proyecto){
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
        $respuesta = array(
            'error' => $e->getMessage()
        );
    }
    
    echo json_encode($respuesta);
}

?>