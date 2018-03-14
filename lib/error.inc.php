<?php
/**
* $Id$
* phpframework - v1.0 -  http://www.cuatrovientos.org
* Pello Xabier Altadill Izura - Instituto Cuatrovientos 
* error.inc.php
* Clase para manejar errores
*/
class Error {

	// para guardar mensajes de error
	var $ERRORES = array();
	
	// para guardar errores de formulario
	var $FORMULARIO = array();

	var $CSS = "";
	
	/**
	* constructor sin parametros
	*/
	function Error($pagina="", $msg="", $css = "") {
		session_start();
		$this->CSS = $css;
		
		if ($pagina != "") {
			$this->ERRORES = array($pagina => $msg);
			$_SESSION['error'] = $this->ERRORES;
		} else {
			$this->ERRORES = $_SESSION['error'];
		}
	}


	// funcion para sacar errores
	function errores() {
		if (count($this->ERRORES) == 0) {
			return;
		}
		
		echo "<div class='". $this->CSS . "'>\n";
		foreach ($this->ERRORES as $key => $item) {
			echo $item ."<br>";
		}		
		echo "</div>\n";
	}
	
	// funcion para sacar errores
	function mostrarErrores() {
		if (count($this->ERRORES) == 0) {
			return;
		}
		
		echo "<div class='". $this->CSS . "'>\n";
		foreach ($this->ERRORES as $key => $item) {
			echo "[" . $key ."]: " . $item ."<br>";
		}		
		echo "</div>\n";
	}
	
	/**
	* Elimina el objeto de errores para que no se propague
	*/
	function borrar() {
		session_start();
		unset($this->ERRORES);
		unset($this->FORMULARIO);
		unset($_SESSION['error']);
		$_SESSION['error'] = "";
	
	}

}

?>
