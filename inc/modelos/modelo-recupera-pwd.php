<?php 

//obtiene esta variable de recuperar-cuenta.php
if($_POST['tipo'] == 'recuperar'){

	require_once('../funciones/email_settings.php');
    require_once('../funciones/conexion.php');

    session_start(); 
    $user = $_SESSION['user'];

    //recupera el correo introducido y lo sanitiza
	$correo = filter_var($_POST['usuario'], FILTER_SANITIZE_EMAIL);

    // verificar que algún usuario se haya dade de alta con el correo proporcionado
    if($user == "prof"){
        $query = $conn->prepare("SELECT nombre FROM profesor WHERE correo = ?");
        $query->bind_param('s', $correo);
        $query->execute();
        $query->bind_result($nombre);
        $query->fetch();
    } else {
        $query = $conn->prepare("SELECT nombre FROM alumno WHERE correo = ?");
        $query->bind_param('s', $correo);
        $query->execute();
        $query->bind_result($nombre);
        $query->fetch();
    }
    $query->close();

    if($nombre){

        $clave = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 5);
        $stmt = $conn->prepare("CALL GUARDAR_CLAVE(?,?)");
        $stmt->bind_param("ss",$correo,$clave);
        $stmt->execute();

        $mail->addAddress($correo,'Usuario');
        //título
        $mail->Subject = '[Dëni] Recuperación de contraseña';
        //cuerpo
        
        $mail->Body = '<p>Si solicitaste recuperar tu contraseña, ingresa a la siguiente página:[url]/cambiar-pwd.php</p> 
            <br>La clave para realizar el cambio es:<b>'.$clave.'</b>            
            <br><p><strong>Si no lo solicitaste, ignora este correo.</strong></p>';

        if($stmt->errno == 0) {
            if($mail->send()){
                $respuesta = array(
                            'respuesta' => 'correcto',
                            'nombre' => 'Correo enviado. Verifique su correo de entrada.',
                            'correo' => 'enviado',
                            'clave' => $clave
                            );
            }
            else {
                $respuesta = array(
                            'error' => 'Error al enviar el correo. Verifique que la dirección sea correcta.',
                            'correo' => $correo,
                            'clave' => $clave
                            );
            }
        } else {
            $respuesta = array(
                'error' => 'Error al generar su clave. Por favor intente de nuevo.',
                'correo' => $correo,
                'clave' => $clave,
                'detalle' => $stmt->errno.' : '.$stmt->error
            );
        }
        $stmt->close();
        $conn->close();
    } else {
        $respuesta = array(
            'error' => 'El correo no está registrado. Favor de verificarlo',
            'correo' => $correo
        );
    }

	echo json_encode($respuesta);

}

//obtiene esta variable de cambiar-pwd.php
if($_POST['tipo'] == 'cambiar'){

	require_once('../funciones/email_settings.php');
	require_once('../funciones/conexion.php');

	$correo = filter_var($_POST['usuario'], FILTER_SANITIZE_EMAIL);
    $clave = filter_var($_POST['clave'], FILTER_SANITIZE_STRING);
	$password = filter_var($_POST['pwd'], FILTER_SANITIZE_STRING);

	// hashear passwords
    $opciones = array(
        'cost' => 12
    );
    $hash_password = password_hash($password, PASSWORD_BCRYPT, $opciones);

	$mail->addAddress($correo,'Usuario');
	//título
	$mail->Subject = '[Dëni] Nueva contraseña';
	//cuerpo
	$mail->Body = '<h3>Su contraseña ha sido cambiada con éxito.</h3> 
					<p>Su nueva contraseña es: <strong>'.$password.' </strong></p>';

	try {
        //verificar que la clave sea correcta
        $query = $conn->prepare("SELECT clave FROM clave_password WHERE correo = ?");
        $query->bind_param("s", $correo);
        $query->execute();
        $query->bind_result($clave_correcta);
        $query->fetch();

        if($clave_correcta == $clave){

            $stmt = $conn->prepare("CALL NUEVA_PASSWORD(?,?)");
            $stmt->bind_param("ss",$hash_password,$correo);
            $stmt->execute();

            if($stmt->errno == 0) {
                if($mail->send()){
                    $respuesta = array(
                        'respuesta' => 'correcto',
                        'nombre' => 'Contraseña cambiada.',
                        'correo' => 'enviado'
                    );    
                }
                else {
                    $respuesta = array(
                        'respuesta' => 'correcto',
                        'nombre' => 'Contraseña cambiada.',
                        'correo' => 'NO enviado'
                    ); 
                }
            } else {
                $respuesta = array(
                    'respuesta' => 'error',
                    'error' => 'Error al cambiar contraseña',
                    'detalle' => $stmt->errno.' : '.$stmt->error
                );
            }
           
            $stmt->close();
        } else {
            $respuesta = array(
                'respuesta' => 'error',
                'error' => 'Error. La clave no es correcta.',
                'clave correcta' => $clave_correcta
            );
        }
        $query->close();
        $conn->close();
    } catch(Exception $e) {
        $respuesta = array(
            'error' => $e->getMessage()
        );
    }

	echo json_encode($respuesta);

}

?>