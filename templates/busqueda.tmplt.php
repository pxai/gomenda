<?php
	$termino = ($_POST[$cifrador->encrypt("terminobusqueda")]!="")?$_POST[$cifrador->encrypt("terminobusqueda")]:$termino;
	if (preg_match("/^[a-zA-z0-9]{3,100}$/", $termino) ) 
	{
		echo "Paginacion: " . $conf['paginacion'];
		$weblog->wl_ultimas_entradas_busqueda($conf['paginacion'],$inicio,$termino, $sesion->login);
	}
	else
	{
		echo "Cadena de busqueda NO valida: " . htmlentities($termino);
		echo "<br />Una expresi&oacute;n regular fascistoide solo deja pasar esto:  [a-zA-z0-9]";
		echo "<br /><br /><a href='?'>Vaaale</a>";		
	}
?>