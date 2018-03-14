<?php
	if (preg_match("/^[0-9]{1,15}$/",$id) ) 
	{
		if ($ac=="comentario")
		{		
			include_once './lib/gomenda/comentario.inc.php';
			$comentario = new Comentario($clave);
			
			$comentario->insertarComentario($id, $sesion->login);
			
		}
		
		// Muestra la entrada
		$weblog->wl_editar_entrada($id);
		
	}
	elseif ($ac == "guardar")
	{
			include_once './lib/gomenda/entrada.inc.php';
			$entrada = new Entrada($clave);
			
		 	if (!($id = $entrada->modificarEntrada()))
			{
				// Muestra la entrada
				echo "<span style='text-align:center'>Error al editar entrada<br />";
				echo "<a href='?'>Inicio</a></span>";
				
			}
			else
			{
				echo "<span style='text-align:center'>OK, entrada modificada con &eacute;xito.<br />";
				echo "<a href='?'>Inicio</a></span>";
				$weblog->wl_editar_entrada($id);
			}
			
	}

	else
	{
		echo "Entrada no valida: " . htmlentities($id);
	}
?>