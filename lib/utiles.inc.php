<?php
/**
* $Id: utiles.inc.php 14 2006-03-01 12:32:45Z intranet $
* phpframework - v1.0 -  http://www.cuatrovientos.org
* Pello Xabier Altadill Izura - Instituto Cuatrovientos 
* utiles.inc.php
* Clase con utilidades 
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
	function crearPassword ($longitud = 8) {
		$c = array('a','b','c','d','e','f','g','h','j','k','m','n','o','p','q','r','s','t','u','v','w','x','y','z','2','3','4','5','6','7','8','9','.','-','_',',');
		$resultado = "";
		
		for ($i=0;$i<$longitud;$i++)
		{
			$resultado .= $c[rand(0,count($c)-1)];
		}
		
		return $resultado;
	}

	/**
	* creaUrl
	* del tí­tulo crea un url fijo.
	*/
	function crearUrl ($url)
	{
		$resultado = "";
		// aportado por thyng

		$resultado = $this->quitarAcentos($url);
		$resultado = str_replace(" ","0",strtolower($resultado));
		$resultado = preg_replace("/\W/","",$resultado);
		$resultado = str_replace("0","_",$resultado);		
		return $resultado;
	}

	/*
	* quitarAcentos
	* gracias Thyng
	*/
	function quitarAcentos($str)   
	{    
		 	if($this->is_utf($str))   
		 	 {        
		 		$str = utf8_decode($str);    
		 	}         
		 	$str = htmlentities($str);     
		 	$str = preg_replace('/&([a-zA-Z])(uml|acute|grave|circ|tilde);/','$1',$str);     
		 	return html_entity_decode($str);   
	 }    

   function is_utf ($t)
   {
       if ( @preg_match ('/.+/u', $t) )       
            return 1;
	}
	
/**
* teaser
* Saca parte de una entrada a partid de <!--break-->
* o de cierta cantidad de caracteres
*/
function teaser ($texto) {	
	$partes = split("<!--break-->", $partes);
	
	// Si no tiene el break, a buscar un cacho!
	if (count($partes) == 1 && strlen($texto) > 512) {	
		if ( ($pos = strpos ($texto, " ", 512 ) )) {	
			return substr($texto, 0, $pos). "... ";
		}	
		return substr($texto, 0, 512). "... ";
	}
		return $texto;
}

}

?>
