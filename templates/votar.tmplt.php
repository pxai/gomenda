<?php

// insert into voto_entrada (identrada,voto,key) values (24,1,'MzUw')
include_once './lib/gomenda/entidad.inc.php';
$entidad = new Entidad($_SESSION['key']);
$resultado = "";

if ($ac=="Votar" && preg_match("/^[0-9]+$/",$id) && preg_match("/^[0-3]{1}$/",$voto))
{

	$usuario = ($_SESSION['idusuario'] =="")?"NULL":$_SESSION['idusuario'];
	$votos_entrada = $entidad->seleccionar("comprobar_voto_entrada",array($id,$usuario,$_SESSION['key']));
	
	if ($votos_entrada->length() == 0)
	{
		if ($_SESSION['login'] != "") {
			
			$entidad->insertar("votar_usuario",array($id,$voto,$_SESSION['idusuario']));
			$entidad->insertar("update_monedas",array(1,$_SESSION['idusuario']));
		}
		else
		{
			$entidad->insertar("votar_usuario_anon",array($id,$voto,$_SESSION['key']));
		}
		$resultado = "OK;OK gracias;";
	}
	else
	{
		$resultado = "error;Ya votaste;";
	}

	$votos = $entidad->seleccionar("select_votos_entrada",array($id));

	$totales = array('0' => 0, '1' => 0, '2' => 0, '3' => 0);
	$suma = 0;

	while ($votos->hasMoreElements())
	{
		$totales[$votos->getValue("voto")] = $votos->getValue("total");
		$suma += $votos->getValue("total");
		$votos->next();
	}
	

	echo "$id;$suma;".$totales[1].";".$totales[2].";".$totales[3].";".$resultado;
	
}
		
?>
