<?php 

//obtiene esta variable de recuperar-cuenta.php
if($_POST['tipo'] == 'recuperar'){

	require_once('../funciones/email_settings.php');

    //recupera el correo introducido y lo sanitiza
	$correo = filter_var($_POST['usuario'], FILTER_SANITIZE_EMAIL);

	$mail->addAddress($correo,'Usuario');
	//título
	$mail->Subject = '[Dëni] Recuperación de contraseña';
	//cuerpo
	
	$mail->Body = '<p>Si solicitaste recuperar tu contraseña, ingresa a la siguiente página: http://localhost/deni/cambiar-pwd.php</p> 
					<br><p><strong>Si no lo solicitaste, ignora este correo.</strong></p>';

	if($mail->send()){
		$respuesta = array(
                    'respuesta' => 'correcto',
                    'nombre' => 'Correo enviado. Verifique su correo de entrada.',
                    'correo' => 'enviado'
                    );
	}
	else {
		$respuesta = array(
                    'error' => 'Error al enviar el correo. Verifique que la dirección sea correcta.',
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
        $conn->close();
    } catch(Exception $e) {
        $respuesta = array(
            'error' => $e->getMessage()
        );
    }

	echo json_encode($respuesta);

}

?>