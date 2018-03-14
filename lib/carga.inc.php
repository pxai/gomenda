<?php
/**
* $Id: carga.inc.php 14 2006-03-01 12:32:45Z intranet $
* phpframework - v1.0 -  http://www.cuatrovientos.org
* Pello Xabier Altadill Izura - Instituto Cuatrovientos 
* carga.inc.php
* Clase para calculos de carga de pagina
*/
class Carga {

	// para guardar 
	var $inicio;
	
	// para guardar errores de formulario
	var $fin;
	
	/**
	* constructor sin parametros
	*/
	function Carga() {
		$inicio_tmp = explode(' ', microtime()); 
		$this->inicio = $inicio_tmp[1] + $inicio_tmp[0]; 
	}


	// funcion para sacar el tiempo total de carga
	function total() {
				// tiempo:
				$fin_tmp= explode(' ', microtime()); 
				$this->fin = $fin_tmp[1] + $fin_tmp[0]; 
				$tiempocarga = number_format(($this->fin - $this->inicio), 7); 
				echo "<div style='font-size:8pt'>$tiempocarga. sec</div>";  
	}
		

}

?>
