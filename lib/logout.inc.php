<?php

// si no esta establecido el valor username
// no se esta intentando el login

		include_once "./lib/sesion.inc.php";
		include_once "./lib/error.inc.php";
		$sesiones = new Sesion();
		$sesiones->finalizarSesion();
		
		$mensaje = new Error("Logout","Gracias por cerrar la sesi&oacute;n correctamente.<br />Que tenga un buen d&iacute;a.");

		$destino = "Location: ?"; 


		// Nos movemos a la pagina destino (vuelta al login a la principal de la aplicacion)
		header($destino);

?>
