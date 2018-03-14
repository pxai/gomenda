<?php

/**
* $Id: acl.inc.php 14 2006-03-01 12:32:45Z intranet $
* phpframework - v1.0 -  http://www.cuatrovientos.org
* Pello Xabier Altadill Izura - Instituto Cuatrovientos 
* acl.inc.php
* Clase para gestionar el control de acceso a modulos de la aplicacion
* pero NO dependiente de la aplicacion concreta
*/
class Acl {

	var $login = "";
	var $ACL;

	function Acl($Login="") {
	
	
	}



	// Funcion para comprobar la validez de acceso
	// a determinada funcionalidad
	function checkACL($login, $pagina) {
		// Conexion, seleccion de base de datos
		include_once './lib/dao.inc.php';
		$acceso = new Dao();

		// consultamos si cumple el ACL
		$resultado = $acceso->getData("check_acl",array($login,$pagina));
		$acceso->close();
				
		// Si hay algun resultado, es correcto
		if ($resultado->getValue("total") == 1) {
			return TRUE;
		}	else {
			return FALSE;
		}

	}
	

}

?>