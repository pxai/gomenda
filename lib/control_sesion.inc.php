<?php

require_once "sesion.inc.php";
$sesiones = new Sesion();

// Si la sesion no es valida...
if (!$sesiones->comprobarSesion()) {
	header("Location: /error.php?msg=session_1"); 
	exit;
}

// en cualquier otra cosa, sigue adelante

?>
