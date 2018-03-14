<?php
/** 
 * $Id$
 * phpframework - v1.0
* phpframework - v1.0 -  http://www.cuatrovientos.org
* Pello Xabier Altadill Izura - Instituto Cuatrovientos 
* dialog.inc.php
 * Clase para generar graficos dinamicos con GD
 */ 

class DynamicGraphic {

  var $text;
  var $signature = "Phpframework";

	/**
	* constructor
	*/
	function DynamicGraphic () {
	}
	
	/**
	* generateText
	*/
	function generateText ($text ="") {
		Header("Content-type: image/png");
		$height = 22;
		$width = 70;
		$im = ImageCreate($width, $height);
		$bck = ImageColorAllocate($im, 153,153,153);
		$white = ImageColorAllocate($im, 233, 114, 191);
		ImageFill($im, 0, 0, $bck);
		ImageLine($im, 0, 0, $width, $height, $white);
 		for($i=0;$i<=99;$i=$i+10) {
			ImageLine($im, 0, $i, $width, $height, $white); } 
		$txt_color = ImageColorAllocate ($im, 255, 255, 255);
 		ImageString ($im, 31, 5, 5,  $text , $txt_color);
		ImagePNG($im);
	}
	
} // end

?>