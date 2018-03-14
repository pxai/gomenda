<?php

/**
* $Id: utiles.inc.php 14 2006-03-01 12:32:45Z intranet $
* phpframework - v1.0 -  http://www.cuatrovientos.org
* Pello Xabier Altadill Izura - Instituto Cuatrovientos 
* utiles.inc.php
* Clase para crear el rastro de migas de pan
*
*/
class Utiles {
	
	/**
	* constructor sin parametros
	*/
	function Utiles() {
	}

	/**
	* crearPass
	*/
	function crearPass ($longitud = 8) {
		$c = array('a','b','c','d','e','f','g','h','j','k','m','n','o','p','q','r','s','t','u','v','w','x','y','z','2','3','4','5','6','7','8','9','.','-','_',',');
		$resultado = "";
		
		for ($i=0;$i<$longitud;$i++)
		{
			$resultado .= $c[rand(0,count($c)-1)];
		}
		
		return $resultado;
	}

}

?>
