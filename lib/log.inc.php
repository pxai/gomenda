<?php
/**
 * $Id$
 * phpframework - v1.0
 * by NHTaldea - http://nhtaldea.almacenweb.com - (C) NHTaldea labs
 * log.inc
 * Creacion de logs generica para todas las operaciones.
 * *
 */ 

class Logger {
  var $LogFile = "./var/aplicacion.log.xml";
  var $LogLevel = "";
  var $LogString = "";
  var $ShowDate = 0;
  var $Debug = 0;

  /* public: constructor */
  function Logger($file = "") {
 	require './lib/config.inc.php';
 	$this->LogLevel = $conf['log_level'];
	$this->LogFile = $conf['log_file'];
	$this->Debug = $conf['debug'];

   }

  /*
  * log
  * Escribe un mensaje en el log
  */
  function log($content="",$loglevel = "") {
	// si esta desactivado, salimos
	//echo "Veamos: " .$this->LogFile.  " y " .$this->LogLevel."<br>"; // DEBUG

	if (!$this->LogLevel) return;
	  
	// abrimos el fichero
	$file = fopen($this->LogFile,"a");
	$cn = "<log date='" . date("j-m-Y G:i:s") . "'>$content</log>\n";
	
	fputs($file, $cn);
	//Cerramos fichero
	fclose($file);
  }

  /*
  * debug
  * Vuelca informacion al navegador
  */
  function debug($content="",$loglevel = "") {
	// Si no esta habilitado, nada
	if (!$this->Debug) return;
	$this->log($content, $loglevel);
//	echo "DEBUG> $content <br>\n";	  
  }


}
?>
