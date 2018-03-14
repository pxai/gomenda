<div>
<span style="font-size: 14pt;font-weight:bold;">Resultados</span><br>
Estas son las preferencias de la gente que ha visitado esta p&aacute;gina.
<?php
	include_once './lib/weblog/color.inc.php';
	$color = new Color();
	
	echo $color->sacarVotaciones();
?>
</div>