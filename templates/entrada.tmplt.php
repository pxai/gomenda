<?php

	if (preg_match("/^[0-9]{1,15}$/",$id) ) 
	{
		if ($ac=="comentario")
		{		
			include_once './lib/gomenda/comentario.inc.php';
			$comentario = new Comentario($clave);
			
			if ($_SESSION['idusuario'] == "") {
				$comentario->insertarComentarioAnon($id, $_SESSION['idusuario']);
			} else{
				$comentario->insertarComentario($id, $_SESSION['idusuario']);
				$entidad->insertar("update_monedas",array(2,$_SESSION['idusuario']));
			}
			
			// Muestra la entrada
			$weblog->wl_mostrar_entrada($id, $_SESSION['idusuario']);
		}
		elseif ($ac=="eliminar")
		{		
			include_once './lib/gomenda/entrada.inc.php';
			$entrada = new Entrada($clave);
			
			$entrada->eliminarEntrada($id);
			echo "<span class='confirmacion'>OK, entrada eliminada con &eacute;xito.<br />";
			echo "<a href='?'>Inicio</a></span>";
		}
		else
		{		
			$weblog->wl_mostrar_entrada($id, $sesion->login);
		}
					
	}
	else
	{
		echo "Entrada no valida: " . htmlentities($id);
	}
?>
