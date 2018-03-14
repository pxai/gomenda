<div>
<?php

$formulario = new Formulario("","form_alta_usuario","post","$path/?registro&ac=Salvar");
$password = $util->crearPassword();

if ($ac == "") 
{
	echo $formulario->generar();
}
elseif ($ac == "Salvar")
{
	if ($formulario->validar() && trim($_POST['login']) != "")
	{	
		// Comprobar si el usuario existe
		$res = $entidad->seleccionar("usuario_duplicado",array($_POST['login'],$_POST['email']));
		
		
		if (!$res->length())
		{
			$entidad->insertar("insertar_usuario",array($_POST['login'],$password,$_POST['email']));
			
			$to      = $_POST['email'];
			$subject = 'Registro en gomenda';
			$message = 'Esta es tu contraseña: $password \n saludos cordiales desde gomenda.net.';
			$headers = 'From: nomeralles@gomenda.net' . "\r\n" .
			'Reply-To: nomeralles@gomenda.net' . "\r\n" .
			'X-Mailer: Gomenda mailer como lo flipas.';
			
			echo "<div id='mensaje'>Correcto. Recibirás un correo con la contraseña. <span style='color:red'>".$password."</span><br />";
			echo "<a href='$path/?'>Volver</a></div>";
		}
		else
		{
			if ($_POST['login'] == $res->getValue('login'))
				echo "El usuario " . htmlentities($_POST['login']) . " ya existe.";
			if ($_POST['email'] == $res->getValue('email'))
				echo "El email " . htmlentities($_POST['email']) . " ya existe.";
				
			echo $formulario->regenerar();
		}
	}
	else
	{
		echo "Incorrecto";
		echo $formulario->regenerar();
	}
}
elseif ($ac == "Recordar")
{
	$formulario = new Formulario("","form_recordar_usuario","post","$path/?registro&ac=EnviarRecordar");	
	echo $formulario->generar();
}
elseif ($ac == "EnviarRecordar")
{
	$formulario = new Formulario("","form_recordar_usuario","post","$path/?registro&ac=EnviarRecordar");	

	if ($formulario->validar())
	{
		// Comprobar si el usuario existe
		$res = $entidad->seleccionar("usuario_email",array($_POST['email']));
		
		
		if ($res->length() == 1)
		{

			$entidad->modificar("update_password",array($password, $_POST['email']));
			
			$to = $_POST['email'];
			$subject = 'La pass que olvidaste';
			$message = 'Esta es tu nueva contraseña: '.$password.' \n saludos cordiales desde gomenda.net.';
			$headers = 'From: nomeralles@gomenda.net' . "\r\n" .
			'Reply-To: nomeralles@gomenda.net' . "\r\n" .
			'X-Mailer: Gomenda mailer como lo flipas.';

			mail($to, $subject, $message, $headers);


			echo "<div id='mensaje'>Correcto. Recibirás un correo con la contraseña. Come legumbres.<br />";
			echo "<a href='$path/?'>Volver</a></div>";
		}
		else
		{
				echo "El email " . htmlentities($_POST['email']) . " no existe.";
				
			echo $formulario->regenerar();
		}

	}
	else
	{
		echo "Incorrecto";
		echo $formulario->regenerar();
	}

}
?>
</div>
