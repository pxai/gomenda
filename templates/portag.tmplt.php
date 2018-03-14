<?php
	if (preg_match("/^[a-zA-Z0-9\-]{1,60}$/",$id) ) 
	{
		echo "Aqui los tags: " . $id;
		$weblog->wl_ultimas_entradas_tag($conf['paginacion'],$inicio, $id, $sesion->login);
	}
	else
	{
		echo "Tag no valido: " . htmlentities($id);
	}
?>