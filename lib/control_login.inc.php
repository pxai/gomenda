<?php
 
// Establecemos el locale
setlocale(LC_ALL,"es-ES","es_ES.ISO-8859-1");

$username = $_POST[$cifrador->encrypt('login')]; 
$password = $_POST[$cifrador->encrypt('password')]; 

$destino="Location:  ".$path."/?" . $cifrador->encrypt('login'); 

// si no esta establecido el valor username
// no se esta intentando el login
if (!isset($username) && !isset($password) ) {
	$errores = new Error($_SERVER['PHP_SELF'],"Login incorrecto: escribe algo o que?");
	$_SESSION['msgerror'] = "Login incorrecto: escribe algo o que?";
	header($destino); 
} elseif (!preg_match("/^[a-zA-Z0-9\_\,\.\-\s]{3,40}$/",$username) || !preg_match("/^[a-zA-Z0-9\_\,\.\-]{3,19}$/",$password)) {
	$errores = new Error($_SERVER['PHP_SELF'],"Login incorrecto: solo se permiten los caracteres [a-zA-Z0-9],.-_ en los dos campos");
	$_SESSION['msgerror'] = "Login incorrecto: solo se permiten los caracteres [a-zA-Z0-9],.-_ en los dos campos";
	header($destino); 
} else {
		// Conexion, seleccion de base de datos
		include_once './lib/dao.inc.php';
		include_once './lib/crypter.inc.php';
		$acceso = new Dao();
		
		$parametros = array($username, $password);
		// Realizar la insercion SQL
		$resultado = $acceso->getData("comprobar_usuario",$parametros);
		// cerramos la conexion
		$acceso->close();
	// Si hay resultados, entonces el usuario es correcto y se envia a la pantalla inicial
	if ($resultado->getValue('login') == $username && $resultado->getValue("password") !="" && $resultado->length() == 1) {

		include_once "./lib/sesion.inc.php";
		$sesiones = new Sesion("",$username,$resultado->getValue("idusuario"),date('Y-m-d H:i:s'));
		$sesiones->iniciarSesion();
		
		// Cargamos la plantilla que le corresponde al usuario
		$plantilla = $resultado->getValue("codigo");
//		$cifrador->setKey($sesiones->keysesion);
		$cif = new Crypter($sesiones->keysesion);
		$logger->debug("Login OK, Clave actual: " . $cif->key . ", vamos a: " . $cif->encrypt($plantilla));
		$destino="Location:  ?" . $cif->encrypt($plantilla);
//		$logger->debug("Login OK, Clave actual: " . $cifrador->key . ", vamos a: " . $cifrador->encrypt('ap_inicio'));
//		$destino="Location:  /?" . $cifrador->encrypt('ap_inicio');

		// En caso contrario, devolvemos al usuario a la pantalla de login
		// Y mostraremos errores
	} else {
		include_once './lib/error.inc.php';
		$errores = new Error($_SERVER['PHP_SELF'],"Login incorrecto");
		$_SESSION["msgerror"] = "Login incorrecto";
		$destino="Location:  ".$path."/?" . $cifrador->encrypt('login'); 

	}


	// Nos movemos a la pagina destino (vuelta al login a la principal de la aplicacion)
	header($destino);
}

?>
