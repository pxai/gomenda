<?php
/**
* $Id$
* phpframework - v1.0 -  http://www.cuatrovientos.org
* Pello Xabier Altadill Izura - Instituto Cuatrovientos 
* dialog.inc.php
* Clase para crear ventanas de confirmacion HTML, javascript
*/
class Dialog {

	// para guardar mensajes de error
	var $MENSAJE;
	
	// Titulo del dialogo
	var $TITULO;
	
	// tipo de dialogo: OK, error, aviso
	var $TIPO;
	
	// Link de retorno
	var $LINK;

	// Link de retorno
	var $LINKCANCEL;

	// para guardar errores de formulario
	var $FORMULARIO = array();

	var $CSS = "";
	
	/**
	* constructor sin parametros
	*/
	function Dialog($titulo="", $msg="", $css = "dialog", $link="javascript:history.back()",$tipo="OK",$linkcancel="") {
		$this->TITULO = $titulo;
		$this->MENSAJE = $msg;
		$this->CSS = $css;
		$this->LINK = $link;
		$this->LINKCANCEL = $linkcancel;
		$this->TIPO = "<img src='/images/".$tipo.".png' border='0' alt='".$tipo."' title='".$tipo ." volver'>";
	}


	// funcion para mostrar el dialogo
	function mostrar($quien="") {
		
		echo "<table width='300' class='". $this->CSS . "'>\n";
		echo "<tr><th colspan='2' align='center'>".$this->TITULO."</th></tr>\n";
		echo "<tr><td valign='middle'><a href='".$this->LINK."'>".$this->TIPO."</a></td>\n";
		echo "<td><br>".$this->MENSAJE."<br><br></td></tr>\n";
		echo "<tfoot><tr><td colspan='2' align='center'><a href='".$this->LINK."'><img src='/images/volver.png' border='0' title='vuelveeeee' align='middle'>V O L V E R</a></td></tr></tfoot>";
		echo "\n</table>\n";

	}
	
	// funcion para mostrar el dialogo
	function errorsql($texto) {
		
		echo "<table width='300' class='". $this->CSS . "'>\n";
		echo "<tr><th colspan='2' align='center'>ERROR</th></tr>\n";
		echo "<tr><td valign='middle'><a href='".$this->LINK."'><img src='/images/emblem-important.png' border='0' title='vuelveeeee' align='middle'></a></td>\n";
		echo "<td><br>".$texto."<br><br></td></tr>\n";
		echo "<tfoot><tr><td colspan='2' align='center'><a href='".$this->LINK."'><img src='/images/volver.png' border='0' title='vuelveeeee' align='middle'>V O L V E R</a></td></tr></tfoot>";
		echo "\n</table>\n";

	}

	// funcion para mostrar el dialogo tipo yesorno
	function mostraryesorno() {
		
		echo "<table width='300' class='". $this->CSS . "'>\n";
		echo "<tr><th colspan='2' align='center'>".$this->TITULO."</th></tr>\n";
		echo "<tr><td valign='middle'><a href='".$this->LINK."'>".$this->TIPO."</a></td>\n";
		echo "<td><br>".$this->MENSAJE."<br><br></td></tr>\n";
		echo "<tr><td colspan='2' align='center'><a href='".$this->LINK."' class='boton'>OK</a>\n";
		echo "&nbsp;&nbsp;&nbsp;<a href='".$this->LINKCANCEL ."' class='boton'>Cancelar</a></td></tr>";
		echo "<tfoot><tr><td colspan='2'>&nbsp;</td></tr></tfoot>";
		echo "\n</table>\n";
	}
	

}

?>
