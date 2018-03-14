<?php
/**
* $Id$
* phpframework - v1.0 -  http://www.cuatrovientos.org
* Pello Xabier Altadill Izura - Instituto Cuatrovientos 
* color.inc.php
* Color, para controlar las votaciones de eleccion de color 
*/

// Conexion, seleccion de base de datos
include_once './lib/gomenda/entidad.inc.php';


class Color extends Entidad {
	
	// INSERT: instruccion para insertar una nueva entidad
	var $INSERT;



	/**
	* insertarVoto
	* Inserta un voto por un color
	*/
	function insertarVoto ($id) {
	
		if (!preg_match("/^[0-9a-fA-F]{6}$/",$id)){
			return;	
		}	
		
		// Si no ha votado aÃÂºn:
		if (!isset($_SESSION['votocolor'])) {
			$_SESSION['votocolor'] = array($id);
			$this->insertar("voto_color",array($id));
		}	
		elseif (!in_array($id,$_SESSION['votocolor']))
		{
			array_push($_SESSION['votocolor'],$id);
			// Solo permito votar si no lo ha hecho ya.
			$this->insertar("voto_color",array($id));
		}
		else 
		{
			echo "Ya has votado por este, perra!";
		}
	}	

	/**
	* sacarVotaciones
	* Saca el resultado de votaciones por momentos
	*/
	function sacarVotaciones () {
		$html = "";
		$colores = $this->seleccionar("select_colores_votacion");

		$html .= "<table border='0'>\n";
		while ($colores->hasMoreElements()){
			$html .= "<tr><td bgcolor='#".$colores->getValue('color')."'>#".$colores->getValue('color');
			$html .= "&nbsp;&nbsp; <span style='font-size:9pt'>". $colores->getValue('votos') ." votos.</span></td></tr>\n";
			$colores->next();
		}
				
		$html .= "</table>\n";
		
		return $html;
	}	

	/**
	* colorMasVotado
	* Saca el color mas votado
	*/
	function colorMasVotado () {
		
		$colores = $this->seleccionar("select_color_mas_votado");

		$resultado = ($colores->getValue('color')!="")?$colores->getValue('color'):"f9b209";
		
		return $resultado;
	}	

}// class

?>
