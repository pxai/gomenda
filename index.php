<?php
/**
* $Id$
* phpframework - v1.0 - http://www.cuatrovientos.org
* Pello Xabier Altadill Izura - Instituto Cuatrovientos 
**
* index.php
* ESTA ES LA PAGINA QUE SE DEBE SERVIR POR DEFECTO. 
* ES LA CONTROLADORA DEL FLUJO DE LA APLICACION, algo que en el patron MVC se
* llama Controller. Todas las peticiones vienen a esta pagina y se dirigen
* a la pagina pertinente segun el mapa de acciones.
*/
$hasiera = microtime(true);

//header('Content-type: text/html; charset=utf-8');
		
require_once './lib/config.inc.php';
require_once './lib/crypter.inc.php';
require_once './lib/log.inc.php';
require_once './lib/sesion.inc.php';
require_once './lib/error.inc.php';
require_once './lib/carga.inc.php';
require_once './lib/acl.inc.php';
//require_once '../lang/'.$language.'.inc.php';
// Establecemos el locale:
setlocale(LC_ALL,"es_ES","es_ES.ISO-8859-1");
//setlocale(LC_ALL,"utf-8","es_ES.UTF-8");

// Definimos el objeto para mostrar errores
$logger = new Logger();

// Definmos un objeto para calculos de carga de pagina
$carga = new Carga();

// Definimos el objeto para control de sesion
$sesion = new Sesion();

// Definimos el objeto para control de sesion
$acl = new Acl();

// Se comprueba la sesion
$sesion_activa = $sesion->comprobarSesion();

$logger->debug("INDEX.PHP clave: ".$clave ."<br>");

// Definimos un objeto para cifrado/descifrado
$cifrador = new Crypter($clave);


// PROCESAMIENTO DE ARGUMENTOS.

$logger->debug($_SERVER['REQUEST_METHOD']."<br>");
$logger->debug("index.php> query ".$_SERVER['QUERY_STRING']."<br>");
$logger->debug("index.php> clave actual: ".$cifrador->key."<br>");


$gakoak = array_keys($_GET);


	$action = $cifrador->decrypt($_SERVER['QUERY_STRING']);

$logger->debug("index.php> accion: ".$action. "<br>");

	$url = strtok($action,"&");
	$resto_url = strtok($action,"&");
	while($resto_url) {
		parse_str($resto_url);
		$logger->debug("resto> $resto_url");
		$resto_url = strtok("&");
	}

	$logger->debug("Estado de sesion de " . $sesion->login . ": ". $sesion_activa ." <br>");
	$logger->debug("Descifrado: $url con action: $action <br>");


	// Si la accion existe, comienza por ap_ y la sesion es valida, 
	// incluimos la pagina que nos dice	
	if (isset($ACTIONS[$url]) && ereg("^ap_*",$url) && $acl->checkACL($sesion->login,$url) && $sesion_activa) {
		
		$pagina = strtok($ACTIONS[$url],"?");
		$resto = strtok("?");
		// magia: convierte el string en variables!!
		parse_str($resto);
		
		$logger->debug("[ACL OK] Pagina: $pagina - $resto<br>");
	 	//echo "Pagina: $pagina - $resto<br>";
		import_request_variables("gP");
		include_once($pagina);

	// En caso de ser una acion valida que no precisa sesion
	} elseif (isset($ACTIONS[$url]) && !ereg("^ap_*",$url)) {
		$pagina = strtok($ACTIONS[$url],"?");
		$resto = strtok("?");
		// magia: convierte el string en variables!!
		parse_str($resto);
		
		$logger->debug("Es Pagina: $pagina - $resto<br>");
	 	//echo "Pagina: $pagina - $resto<br>";
		import_request_variables("gP");
		include_once($pagina);
	} elseif (preg_match("/q\=node\/view\//",$_SERVER['QUERY_STRING'])) {
		$pagina = strtok($ACTIONS['verentrada'],"?");
		$resto = strtok("?");
		
		$parametros = split("\/",$_SERVER['QUERY_STRING']);
		
		$entrada = "id=".$parametros[2];
		// magia: convierte el string en variables!!
		parse_str($resto."&amp;id=".$parametros[2]);
		$id = $parametros[2];
		
		$logger->debug("Es Pagina de drupal: $pagina - $entrada - ".$parametros[2]."<br>");
	 	//echo "Pagina: $pagina - $resto<br>";
		import_request_variables("gP");
		include_once($pagina);
	} else {
		
		// En caso de intento de acceso sin sesion...
		$test = ($sesion_activa || ($action == ""))?"":new Error($_SERVER['PHP_SELF'],"No has iniciado sesion");

		$pagina = strtok($ACTIONS['default'],"?");
		$resto = strtok("?");
		// magia: convierte el string en variables!!
		parse_str($resto);
		include_once($pagina);
		import_request_variables("gP");

		$logger->debug("Pagina no encontrada: $pagina ,Accion: $action<br>");

	}



?>
