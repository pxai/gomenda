<?php
/**
* $Id$
* phpframework - v1.0 -  http://www.cuatrovientos.org
* Pello Xabier Altadill Izura - Instituto Cuatrovientos 
* imagen.php
* Pagina que genera una imagen aleatoria
*/

if (preg_match("/^[a-zA-Z0-9]+$/",$valor)) 
{
	include './lib/dynamicgraphic.inc.php';
	include './lib/gomenda/entidad.inc.php';
	$entidad = new Entidad();

	$codigo = $entidad->seleccionar("seleccionar_captcha",array($valor));
	$grafico = new DynamicGraphic();
	$grafico->generateText($codigo->getValue("captcha"));
}
//echo "A ver: " .$_GET['num_aleatorio'];
?>