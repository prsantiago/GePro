<?php 

require_once 'PHPMailer/PHPMailerAutoload.php';
include '../funciones/funciones.php';

if($_POST['tipo'] == 'recuperar'){

	$correo = $_POST['usuario'];

	//recuperar contraseña
	$hash_pwd = RecuperarPwd($correo[0]);

	$mail = new PHPMailer();
	$mail->isSMTP();
	$mail->SMTPAuth = true;
	$mail->SMTPSecure = 'tls';
	$mail->Host = 'smtp.gmail.com';
	$mail->Port = '587';
	$mail->Username = ''; //correo
	$mail->Password = ''; //contraseña
	//emisor
	$mail->setFrom('al2153001026@azc.uam.mx','Claudia Arellano');
	//receptor
	$mail->addAddress($correo[0],'Usuario');
	//título
	$mail->Subject = '[GePro] Recuperación de contraseña';
	//cuerpo
	
	$mail->Body = '<h3>Te invito a que llenes el siguiente formulario.</h3> 
					<br><p><strong>Sólo se puede llenar una vez.</strong></p>';
	$mail->isHTML(true);
	//$mail->addAtachment();

	if($mail->send()){
		echo "Formulario enviado con éxito";
	}
	else {
		echo "Error al enviar el formulario";
	}

}


?>