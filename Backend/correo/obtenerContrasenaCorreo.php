<?php

class obtenerContrasenaCorreo{

    function obtenerContrasenaCorreo($usuario){
		$permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$contrasenaclaro = substr(str_shuffle($permitted_chars), 0, 16);
		$contrasenaencriptada = md5($contrasenaclaro);
		$usuario->arrayDataValue['password'] = $contrasenaencriptada;
		$usuario->EDIT();
		return $contrasenaclaro;
		
	}

	function enviarCorreo($contrasenaclaro, $usuario){
		include_once "correo/includesCorreo/phpMailer.php";
		include_once "correo/includesCorreo/smtp.php";

		$email_user = "correoRecuperacionPHP@gmail.com";
		$email_password = "qayjwrjmoolfqrgt";
		$name = "Recuperacion de password";
		$the_subject ="Cambio de password";

		$address_to = $usuario->arrayDataValue['email'];
		
		$phpmailer = new PHPMailer();

		// ———- datos de la cuenta de Gmail ——————————-
		$phpmailer->Username = $email_user;
		$phpmailer->Password = $email_password; 

		//———————————————————————–
		$phpmailer->Host = "smtp.gmail.com"; // GMail
		$phpmailer->SMTPSecure = 'ssl';
		$phpmailer->Port = 465;
		$phpmailer->IsSMTP(); // use SMTP
		$phpmailer->SMTPAuth = true;

		$phpmailer->setFrom($email_user,$name);
		$phpmailer->AddAddress($address_to); //destinatario
		//Enviar un tipo de correo en función del idioma del usuario
		$phpmailer->Subject = $the_subject; 
		$phpmailer->Body .= "<p>Ha solicitado una nueva contraseña para su cuenta en la herramienta</p>";
		$phpmailer->Body .= "<p>La nueva contraseña es: </p>";
		$phpmailer->Body .= "<strong>".$contrasenaclaro;
		$phpmailer->Body .= "<p>Se recomienda cambiar la contraseña por otra de su elección.</p>";
		$phpmailer->Body .= "</strong>";
		$phpmailer->Body .= "<p>Gracias por confiar en nuestro equipo.</p>";
		$phpmailer->Body .= "<i>Fecha y Hora: ".date("d-m-Y h:i:s")."</i>";
		$phpmailer->IsHTML(true);

		$resultado = $phpmailer->Send();

		if (!$resultado) {
			rellenarExcepcionAccion('CONTRASENA_CAMBIADA_EMAIL_KO');
		}
	}

}

?>