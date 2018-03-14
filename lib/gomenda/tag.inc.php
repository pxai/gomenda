<?php
/**
* $Id$
* phpframework - v1.0 -  http://www.cuatrovientos.org
* Pello Xabier Altadill Izura - Instituto Cuatrovientos 
* tag.inc.php
* Tags agrupa las funciones para gestionar tags 
*/

// Conexion, seleccion de base de datos
include_once './lib/gomenda/entidad.inc.php';


class Tag extends Entidad {
	

	/**
	* listaTags
	* Muestra la lista de tags
	*/
	function listaTags () {
		$html = "";
		$tags = $this->seleccionar("select_todos_tags",NULL);
		$html .= "<select name='".$this->ncrpt('listatags')."[]' multiple='yes'>\n";
		
		// Generamos la lista
		while ($tags->hasMoreElements()){
			$html .= "<option value='".$tags->getValue('idtag')."'>".$tags->getValue('nombre')."</option>\n";
			$tags->next();
		}		
		$html .= "</select>\n";
		
		return $html;
	
	}	


	/**
	* listaTagsSeleccionados
	* Muestra la lista de tags que ya tienen seleccionados
	*/
	function listaTagsSeleccionados ($seleccionados) {
		$html = "";
		$tags = $this->seleccionar("select_todos_tags",NULL);
		$html .= "<select name='".$this->ncrpt('listatags')."[]' multiple='yes'>\n";
		
		// Generamos la lista
		while ($tags->hasMoreElements()){
			if (in_array($tags->getValue('idtag'),$seleccionados))
			{
				$html .= "<option value='".$tags->getValue('idtag')."' selected='yes'>".$tags->getValue('nombre')."</option>\n";
			}
			else
			{
				$html .= "<option value='".$tags->getValue('idtag')."'>".$tags->getValue('nombre')."</option>\n";
			}
			$tags->next();
		}		
		$html .= "</select>\n";
		
		return $html;
	
	}	


}// class

?>
