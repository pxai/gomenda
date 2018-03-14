<?php

/** 
 * $Id$
 * phpframework - v1.0
 * by NHTaldea - http://nhtaldea.almacenweb.com - (C) NHTaldea labs 
 * dinamicgraphic.inc
 * Clase para generar graficos dinamicos con GD
 */ 

class DinamicGraphic {

  var $text;
  var $signature = "Phpframework";

	/**
	* constructor
	*/
	function DinamicGraphic () {
	}
	
	/**
	* generateText
	*/
	function generateText ($text ="") {
		Header("Content-type: image/png");
		$height = 50;
		$width = 300;
		$im = ImageCreate($width, $height);
		$bck = ImageColorAllocate($im, 10,110,100);
		$white = ImageColorAllocate($im, 255, 255, 255);
		ImageFill($im, 0, 0, $bck);
		ImageLine($im, 0, 0, $width, $height, $white);
		$txt_color = ImageColorAllocate ($im, 233, 114, 191);
 		ImageString ($im, 31, 5, 5,  "My first", $txt_color);
 		for($i=0;$i<=99;$i=$i+10) {
		ImageLine($im, 0, $i, $width, $height, $white); } 
		ImagePNG($im);
	}
	
} // end

?>