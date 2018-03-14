<?php
/**
* $Id$
* phpframework - v1.0 -  http://www.cuatrovientos.org
* Pello Xabier Altadill Izura - Instituto Cuatrovientos 
* display.inc.php
* Funciones de distinto tipo para mostrar contenidos sacados de la BBDD
*
*/

include_once './lib/gomenda/entidad.inc.php';
include_once './lib/formulario.inc.php';


class Display extends Entidad {

var $valores;


function wl_iniciar () {
	$configuracion = $this->seleccionar("select_configuracion");
	
		while($configuracion->hasMoreElements()) {
			$this->valores[$configuracion->getValue("nombre")] = $configuracion->getValue("valor");
			$configuracion->next();
		}
}

/**
* wl_utimas_entradas
* muestra las ultimas entradas
*/
function wl_ultimas_entradas ($paginacion =3, $inicio=0, $login) {
	$totales = $this->seleccionar("total_entradas",NULL);

	if (!isset($inicio)) $inicio = 0;
	
	$entradas = $this->seleccionar("ultimas_entradas",array($inicio, $paginacion));

	while($entradas->hasMoreElements()) {
		$avatar = "<a href='".$path."/?usuario&id=".$entradas->getValue("idusuario")."' title='Detalles del usuario'>";
		if ($entradas->getValue('avatartb') == "") {
			$avatar .= "<img src='".$path."/irudiak/avatar.png' title='Avatar de ".$entradas->getValue('login')."' alt='Avatar de ".$entradas->getValue('login')."' border='0' align='left' style='margin-left:5px;border:1px solid lightGray;' />";
		} else {
			$avatar .= "<img src='".$path."/?avatar&id=".$entradas->getValue("idusuario")."&tb=1' title='Avatar de ".$entradas->getValue('login')."' alt='Avatar de ".$entradas->getValue('login')."' style='border:1px solid gray;' align='left' style='margin-left:5px;margin-right: 20px;' />";
		}
		$avatar .="</a>";

		$id = $entradas->getValue("identrada");
		$totalcomentarios = $this->seleccionar("total_comentarios", array($id));
		$totalvotos = $this->seleccionar("total_votos_entrada", array($id));
		$tags = $this->seleccionar("tags_entrada", array($id));
		echo "<div class='diventrada' >\n";
		echo "<div class='entrada".$entradas->getValue("semaforo")."' >\n";
		$urlentrada = $path ."/recomendacion/".$id."/".$this->util->crearUrl($entradas->getValue("titulo")).".html";
		echo "<div class='tituloentrada'><a href='".$urlentrada."'>". $entradas->getValue("titulo") . "</a></div>\n";
		echo "<div class='semaforo'>";
		echo "<div class='divsem'><span id='".$id."sem'>".$totalvotos->getValue("total")."</span><br />votos<br />";
		echo "<div class='divsemtx' id='".$id."semtx'>Vota!</div></div>";
		echo "<div class='divvotos'>";
		echo "<div id='1_".$id."_li' style='color:#00ff00'><a href='javascript:votar(1,".$id.")' title='A mí­ me ha gustado'><img src='./irudiak/berde.png' border='0' /></a></div>";
		echo "<div id='2_".$id."_li' style='color:orange'><a href='javascript:votar(2,".$id.")' title='Opino que ni fu ni fa'><img src='./irudiak/hori.png' border='0' /></a></div>";
		echo "<div id='3_".$id."_li' style='color:red'><a href='javascript:votar(3,".$id.")' title='A mí­ no me mola'><img src='./irudiak/gorri.png' border='0' /></a></div>";
		echo "</div>";
		echo "</div>\n";
		echo "<div class='autorentrada'>".$avatar." Enviado por: <b><a href='".$path."/?usuario&id=".$entradas->getValue("idusuario")."' title='Detalles del usuario'>". $entradas->getValue("login") . "</a></b>\n";
		echo "<span class='fechaentrada'>". $entradas->getValue("fecha") . "</span>\n";
		$htmltags = "<span class='tagsentrada'>Etiquetas: ";
		if (!$tags->length()) { $htmltags .= "sin tema";}
		while ($tags->hasMoreElements()){
			$htmltags .= "<a href='?".$this->ncrpt("listarportag&id=".$tags->getValue("tag"))."'>".$tags->getValue("tag") . "</a>, ";
			$tags->next();
		}
		$htmltags .= "</span>\n";
		echo $htmltags;
		echo "<br /></div>\n";		
		echo "<div class='textoentrada'>". $this->maquear($this->teaser($entradas->getValue("texto")),$entradas->getValue("titulo")) . " <a href='".$urlentrada."'>&gt;más</a></div>\n";
		echo "<div class='datosentrada'>\n";
		echo "<span class='categoriaentrada'>&nbsp;<b>". htmlentities($entradas->getValue("categoria")) . "</b></span>&nbsp;\n";
	
		// Mostramos opciones para borrar
		if ($login == "pello")
		{
			echo "<span class='tagsentrada'><a href='?".$this->ncrpt("ap_editarentrada&id=$id")."'>Editar entrada</a>&nbsp;\n";
			echo "<a href='javascript:confirmar(\"?".$this->ncrpt("ap_eliminarentrada&id=$id")."\")'>Eliminar entrada</a></span>\n";
		}


		echo "</div>\n";
		echo "</div>\n";

		echo "<div class='herramientas'>".$totalcomentarios->getValue("total")." comentario(s) &nbsp;&#124;&nbsp;";
		echo "<a href='". $urlentrada."'><img src='./irudiak/comment.png' align='middle' title='Dejar comentario' alt='Deja un comentario' border='0' />";
		echo "Dejar comentario</a>\n&nbsp;&#124;&nbsp;"; 
		echo "<span class='permalink'>".$entradas->getValue("lecturas")." lecturas &nbsp;&#124;&nbsp;<a href='".$urlentrada."' title='pelmalink: Venga tio va, linkame va venga tio...'>PELMAlink</a></span>";
		echo "</div>\n";

		echo "</div>\n";
		$entradas->next();
	}
	
	// Enlaces de paginacion 
	$total = $totales->getValue("total");
	$inicio = 0;
	echo "<div id='divpaginacion'>";
	echo "<span><a href='?inicio=0'>Inicio</a>&nbsp;&nbsp;</span>";
	while(($inicio + $paginacion) < $total && $total > $paginacion) {
		$inicio += $paginacion;
		echo "<span><a href='?". $this->ncrpt("inicio=".$inicio) ."'>".$inicio."</a>&nbsp;&nbsp;</span>";
	
	}
	echo "</div>";
}

/**
* wl_utimas_entradas_tag
* muestra las ultimas entradas segun un tag
*/
function wl_ultimas_entradas_tag ($paginacion =3, $inicio=0, $idtag, $login) {
	$totales = $this->seleccionar("total_entradas_tag",array($idtag));

	if (!isset($inicio)) $inicio = 0;
	
	$entradas = $this->seleccionar("ultimas_entradas_tag",array($idtag, $inicio, $paginacion));
	
	
	while($entradas->hasMoreElements()) {
		$avatar = "<a href='".$path."/?usuario&id=".$entradas->getValue("idusuario")."' title='Detalles del usuario'>";
		if ($entradas->getValue('avatartb') == "") {
			$avatar .= "<img src='".$path."/irudiak/avatar.png' title='Avatar de ".$entradas->getValue('login')."' alt='Avatar de ".$entradas->getValue('login')."' border='0' align='left' style='margin-left:5px;border:1px solid lightGray;' />";
		} else {
			$avatar .= "<img src='".$path."/?avatar&id=".$entradas->getValue("idusuario")."&tb=1' title='Avatar de ".$entradas->getValue('login')."' alt='Avatar de ".$entradas->getValue('login')."' style='border:1px solid gray;' align='left' style='margin-left:5px;margin-right: 20px;' />";
		}
		$avatar .="</a>";

		$id = $entradas->getValue("identrada");
		$totalcomentarios = $this->seleccionar("total_comentarios", array($id));
		$totalvotos = $this->seleccionar("total_votos_entrada", array($id));
		$tags = $this->seleccionar("tags_entrada", array($id));
		echo "<div class='diventrada' >\n";
		echo "<div class='entrada".$entradas->getValue("semaforo")."' >\n";
		$urlentrada = $path ."/recomendacion/".$id."/".$this->util->crearUrl($entradas->getValue("titulo")).".html";
		echo "<div class='tituloentrada'><a href='".$urlentrada."'>". $entradas->getValue("titulo") . "</a></div>\n";
		echo "<div class='semaforo'>";
		echo "<div class='divsem'><span id='".$id."sem'>".$totalvotos->getValue("total")."</span><br />votos<br />";
		echo "<div class='divsemtx' id='".$id."semtx'>Vota!</div></div>";
		echo "<div class='divvotos'>";
		echo "<div id='1_".$id."_li' style='color:#00ff00'><a href='javascript:votar(1,".$id.")' title='A mí­ me ha gustado'><img src='./irudiak/berde.png' border='0' /></a></div>";
		echo "<div id='2_".$id."_li' style='color:orange'><a href='javascript:votar(2,".$id.")' title='Opino que ni fu ni fa'><img src='./irudiak/hori.png' border='0' /></a></div>";
		echo "<div id='3_".$id."_li' style='color:red'><a href='javascript:votar(3,".$id.")' title='A mí­ no me mola'><img src='./irudiak/gorri.png' border='0' /></a></div>";
		echo "</div>";
		echo "</div>\n";
		echo "<div class='autorentrada'>".$avatar." Enviado por: <b><a href='".$path."/?usuario&id=".$entradas->getValue("idusuario")."' title='Detalles del usuario'>". $entradas->getValue("login") . "</a></b>\n";
		echo "<span class='fechaentrada'>". $entradas->getValue("fecha") . "</span>\n";
		$htmltags = "<span class='tagsentrada'>Etiquetas: ";
		if (!$tags->length()) { $htmltags .= "sin tema";}
		while ($tags->hasMoreElements()){
			$htmltags .= "<a href='?".$this->ncrpt("listarportag&id=".$tags->getValue("tag"))."'>".$tags->getValue("tag") . "</a>, ";
			$tags->next();
		}
		$htmltags .= "</span>\n";
		echo $htmltags;
		echo "<br /></div>\n";		
		echo "<div class='textoentrada'>". $this->maquear($this->teaser($entradas->getValue("texto")),$entradas->getValue("titulo")) . " <a href='".$urlentrada."'>&gt;más</a></div>\n";
		echo "<div class='datosentrada'>\n";
		echo "<span class='categoriaentrada'>&nbsp;<b>". htmlentities($entradas->getValue("categoria")) . "</b></span>&nbsp;\n";
	
		// Mostramos opciones para borrar
		if ($login == "pello")
		{
			echo "<span class='tagsentrada'><a href='?".$this->ncrpt("ap_editarentrada&id=$id")."'>Editar entrada</a>&nbsp;\n";
			echo "<a href='javascript:confirmar(\"?".$this->ncrpt("ap_eliminarentrada&id=$id")."\")'>Eliminar entrada</a></span>\n";
		}


		echo "</div>\n";
		echo "</div>\n";

		echo "<div class='herramientas'>".$totalcomentarios->getValue("total")." comentario(s) &nbsp;&#124;&nbsp;";
		echo "<a href='". $urlentrada."'><img src='./irudiak/comment.png' align='middle' title='Dejar comentario' alt='Deja un comentario' border='0' />";
		echo "Dejar comentario</a>\n&nbsp;&#124;&nbsp;"; 
		echo "<span class='permalink'>".$entradas->getValue("lecturas")." lecturas &nbsp;&#124;&nbsp;<a href='".$urlentrada."' title='pelmalink: Venga tio va, linkame va venga tio...'>PELMAlink</a></span>";
		echo "</div>\n";

		echo "</div>\n";
		$entradas->next();

	}
	
	// Enlaces de paginacion 
	$total = $totales->getValue("total");
	$inicio = 0;
	echo "<div id='divpaginacion'>";
	echo "<span><a href='?".$this->ncrpt("listarportag&id=$idtag&inicio=0")."'>Inicio</a>&nbsp;&nbsp;</span>";
	while(($inicio + $paginacion) < $total && $total > $paginacion) {
		$inicio += $paginacion;
		echo "<span><a href='?". $this->ncrpt("listarportag&id=$idtag&inicio=".$inicio) ."'>".$inicio."</a>&nbsp;&nbsp;</span>";
	
	}
	echo "</div>";
}


/**
* wl_utimas_entradas_busqueda
* muestra las ultimas entradas
*/
function wl_ultimas_entradas_busqueda ($paginacion =3, $inicio=0, $termino, $login) {
	$totales = $this->seleccionar("total_entradas_busqueda",array($termino, $termino));

	echo "Resultado: <b>" . $totales->getValue("total") . "</b> entradas.<br />";

	if (!$totales->getValue("total")) {
		echo "Tu busqueda esta m&aacute;s vac&iacute;a que una gala de los Pecos.<br />";
		echo "<br /><br /><a href='/'>Vaaale</a>";		
		return;
	}
	
	if (!isset($inicio)) $inicio = 0;
	
	$entradas = $this->seleccionar("ultimas_entradas_busqueda",array($termino, $termino, $inicio, $paginacion));
	
	
	while($entradas->hasMoreElements()) {
		$avatar = "<a href='".$path."/?usuario&id=".$entradas->getValue("idusuario")."' title='Detalles del usuario'>";
		if ($entradas->getValue('avatartb') == "") {
			$avatar .= "<img src='".$path."/irudiak/avatar.png' title='Avatar de ".$entradas->getValue('login')."' alt='Avatar de ".$entradas->getValue('login')."' border='0' align='left' style='margin-left:5px;border:1px solid lightGray;' />";
		} else {
			$avatar .= "<img src='".$path."/?avatar&id=".$entradas->getValue("idusuario")."&tb=1' title='Avatar de ".$entradas->getValue('login')."' alt='Avatar de ".$entradas->getValue('login')."' style='border:1px solid gray;' align='left' style='margin-left:5px;margin-right: 20px;' />";
		}
		$avatar .="</a>";

		$id = $entradas->getValue("identrada");
		$totalcomentarios = $this->seleccionar("total_comentarios", array($id));
		$totalvotos = $this->seleccionar("total_votos_entrada", array($id));
		$tags = $this->seleccionar("tags_entrada", array($id));
		echo "<div class='diventrada' >\n";
		echo "<div class='entrada".$entradas->getValue("semaforo")."' >\n";
		$urlentrada = $path ."/recomendacion/".$id."/".$this->util->crearUrl($entradas->getValue("titulo")).".html";
		echo "<div class='tituloentrada'><a href='".$urlentrada."'>". $entradas->getValue("titulo") . "</a></div>\n";
		echo "<div class='semaforo'>";
		echo "<div class='divsem'><span id='".$id."sem'>".$totalvotos->getValue("total")."</span><br />votos<br />";
		echo "<div class='divsemtx' id='".$id."semtx'>Vota!</div></div>";
		echo "<div class='divvotos'>";
		echo "<div id='1_".$id."_li' style='color:#00ff00'><a href='javascript:votar(1,".$id.")' title='A mí­ me ha gustado'><img src='./irudiak/berde.png' border='0' /></a></div>";
		echo "<div id='2_".$id."_li' style='color:orange'><a href='javascript:votar(2,".$id.")' title='Opino que ni fu ni fa'><img src='./irudiak/hori.png' border='0' /></a></div>";
		echo "<div id='3_".$id."_li' style='color:red'><a href='javascript:votar(3,".$id.")' title='A mí­ no me mola'><img src='./irudiak/gorri.png' border='0' /></a></div>";
		echo "</div>";
		echo "</div>\n";
		echo "<div class='autorentrada'>".$avatar." Enviado por: <b><a href='".$path."/?usuario&id=".$entradas->getValue("idusuario")."' title='Detalles del usuario'>". $entradas->getValue("login") . "</a></b>\n";
		echo "<span class='fechaentrada'>". $entradas->getValue("fecha") . "</span>\n";
		$htmltags = "<span class='tagsentrada'>Etiquetas: ";
		if (!$tags->length()) { $htmltags .= "sin tema";}
		while ($tags->hasMoreElements()){
			$htmltags .= "<a href='?".$this->ncrpt("listarportag&id=".$tags->getValue("tag"))."'>".$tags->getValue("tag") . "</a>, ";
			$tags->next();
		}
		$htmltags .= "</span>\n";
		echo $htmltags;
		echo "<br /></div>\n";		
		echo "<div class='textoentrada'>". $this->maquear($this->teaser($entradas->getValue("texto")),$entradas->getValue("titulo")) . " <a href='".$urlentrada."'>&gt;más</a></div>\n";
		//echo "<div class='textoentrada'>". str_replace($termino, "<span class='termino'>".$termino."</span>", $this->maquear($this->teaser($entradas->getValue("texto")))) . " <a href='".$urlentrada."'>&gt;más</a></div>\n";
		echo "<div class='datosentrada'>\n";
		echo "<span class='categoriaentrada'>&nbsp;<b>". htmlentities($entradas->getValue("categoria")) . "</b></span>&nbsp;\n";
	
		// Mostramos opciones para borrar
		if ($login == "pello")
		{
			echo "<span class='tagsentrada'><a href='?".$this->ncrpt("ap_editarentrada&id=$id")."'>Editar entrada</a>&nbsp;\n";
			echo "<a href='javascript:confirmar(\"?".$this->ncrpt("ap_eliminarentrada&id=$id")."\")'>Eliminar entrada</a></span>\n";
		}


		echo "</div>\n";
		echo "</div>\n";

		echo "<div class='herramientas'>".$totalcomentarios->getValue("total")." comentario(s) &nbsp;&#124;&nbsp;";
		echo "<a href='". $urlentrada."'><img src='./irudiak/comment.png' align='middle' title='Dejar comentario' alt='Deja un comentario' border='0' />";
		echo "Dejar comentario</a>\n&nbsp;&#124;&nbsp;"; 
		echo "<span class='permalink'>".$entradas->getValue("lecturas")." lecturas &nbsp;&#124;&nbsp;<a href='".$urlentrada."' title='pelmalink: Venga tio va, linkame va venga tio...'>PELMAlink</a></span>";
		echo "</div>\n";

		echo "</div>\n";
		$entradas->next();
	}
	
	// Enlaces de paginacion 
	$total = $totales->getValue("total");
	$inicio = 0;
	echo "<div id='divpaginacion'>";
	echo "<span><a href='?".$this->ncrpt("busqueda&termino=$termino&inicio=0")."'>Inicio</a>&nbsp;&nbsp;</span>";
	while(($inicio + $paginacion) < $total && $total > $paginacion) {
		$inicio += $paginacion;
		echo "<span><a href='?". $this->ncrpt("busqueda&termino=$termino&inicio=".$inicio) ."'>".$inicio."</a>&nbsp;&nbsp;</span>";
	
	}
	echo "</div>";
}


/**
* wl_mostrar_entrada
* Muestra una entrada
*/
function wl_mostrar_entrada ($id, $login) {

	$entrada = $this->seleccionar("select_entrada",array($id));
	
	$seguridad = substr(base64_encode($this->aleatorio()*$this->aleatorio()),0,10);
	$captcha = strtolower(substr(base64_encode($this->aleatorio()*$this->aleatorio()),0,3));
	$this->insertar("insertar_captcha",array($captcha,$seguridad));
	
	if (!$entrada->length()) {
		echo "No existe la entrada<br />";
		echo "<br /><br /><a href='?'>Vaaale</a>";		
		return;
	}	
	
	$comentarios = $this->seleccionar("select_comentarios_entrada", array($id));
	$totalcomentarios = $this->seleccionar("total_comentarios", array($id));
	$totalvotos = $this->seleccionar("total_votos_entrada", array($id));
	$tags = $this->seleccionar("tags_entrada", array($id));
	
			echo "<div class='diventrada' >\n";
			echo "<div class='entrada".$entrada->getValue("semaforo")."' >\n";
			$urlentrada = $path ."/recomendacion/".$id."/".$this->util->crearUrl($entrada->getValue("titulo")).".html";
			echo "<div class='tituloentrada'><a href='?". $urlentrada."'>". $entrada->getValue("titulo") . "</a></div>\n";
			echo "<div class='semaforo'>";
			echo "<div class='divsem'><span id='".$id."sem'>".$totalvotos->getValue("total")."</span><br />votos<br />";
			echo "<div class='divsemtx' id='".$id."semtx'>Vota!</div></div>";
			echo "<div class='divvotos'>";
			echo "<div id='1_".$id."_li' style='color:#00ff00'><a href='javascript:votar(1,".$id.")' title='A mí­ me ha gustado'><img src='./irudiak/berde.png' border='0' /></a></div>";
			echo "<div id='2_".$id."_li' style='color:orange'><a href='javascript:votar(2,".$id.")' title='Opino que ni fu ni fa'><img src='./irudiak/hori.png' border='0' /></a></div>";
			echo "<div id='3_".$id."_li' style='color:red'><a href='javascript:votar(3,".$id.")' title='A mí­ no me mola'><img src='./irudiak/gorri.png' border='0' /></a></div>";
			echo "</div>";
			echo "</div>\n";
			echo "<div class='textoentrada'>". $this->maquear($entrada->getValue("texto")) . "</div>\n";
			echo "<div class='datosentrada'>\n";
			echo "<span class='categoriaentrada'>&nbsp;<b>". htmlentities($entrada->getValue("categoria")) . "</b></span>&nbsp;\n";
			echo "<span class='autorentrada'> Enviado por: <b><a href='".$path."/?usuario&id=".$entrada->getValue("idusuario")."' title='Detalles del usuario'>". $entrada->getValue("login") . "</a></b></span>&nbsp;&nbsp\n";
			echo "<span class='fechaentrada'>". $entrada->getValue("fecha") . "</span>&nbsp;&nbsp;\n";

			// Mostramos opciones para borrar
			if ($login == "pello")
			{
				echo "<span class='tagsentrada'><a href='?".$this->ncrpt("ap_editarentrada&id=$id")."'>Editar entrada</a>&nbsp;\n";
				echo "<a href='javascript:confirmar(\"?".$this->ncrpt("ap_eliminarentrada&id=$id")."\")'>Eliminar entrada</a></span>\n";
			}

			$htmltags = "<span class='tagsentrada'>Etiquetas: ";
			if (!$tags->length()) { $htmltags .= "sin tema";}
			while ($tags->hasMoreElements()){
				$htmltags .= "<a href='/?".$this->ncrpt("listarportag&id=".$tags->getValue("tag"))."'>".$tags->getValue("tag") . "</a>, ";
				$tags->next();
			}
			$htmltags .= "</span>\n";
			echo $htmltags;
			echo "</div>\n";
			echo "</div>\n";

			echo "<div class='herramientas'>".$totalcomentarios->getValue("total")." comentario(s) &nbsp;&#124;&nbsp;";
			echo "<a href='#comentar'><img src='/irudiak/comment.png' align='middle' title='Dejar comentario' alt='Deja un comentario' border='0' />";
			echo "Dejar comentario</a>\n&nbsp;&#124;&nbsp;"; 
			echo "<span class='permalink'>".$entrada->getValue("lecturas")." lecturas &nbsp;&#124;&nbsp;<a href='index.php?q=node/view/".$id."' title='pelmalink: Venga tio va, linkame va venga tio...'>PELMAlink</a></span>";
			echo "</div>\n";

			echo "</div>\n";

		while ($comentarios->hasMoreElements()){
		echo "<div class='comentario'>";
		if ($_SESSION['login'] == "pello")
		{
			echo "<span><a href='/?".$this->ncrpt("eliminarcomentario&id=".$comentarios->getValue("idcomentario"))."'>Eliminar</a></span><br />";
		}
		echo "<div class='textocomentario'>". $comentarios->getValue("texto") . "</div>";
		echo "<div class='datoscomentario'>";
			echo "<span class='autorcomentario'>Enviado por: <b>". $comentarios->getValue("login") . "</b></span>&nbsp;&nbsp";
			echo "<span class='fechacomentario'>". $comentarios->getValue("fecha") . "</span>&nbsp;&nbsp;\n";
		echo "</div>";
		echo "</div>\n";
		$comentarios->next();
	}

	
	// Un valor aleatorio para el cÃ³digo de seguridad
	
	echo "\n<div class='formulario'><a name='comentar'></a>";
	echo "<img src='/irudiak/comment.png' align='middle' title='Dejar comentario' alt='Deja un comentario' />Dejar comentario"; 
	echo "<form name='formulario' method='POST' action='/?".$this->ncrpt("verentrada&id=".$entrada->getValue("identrada")."&ac=comentario")."'>";
	echo "<label id='comentario' name='comentario'>Comentario<br />";
	echo "<textarea name='".$this->ncrpt('comentario')."'  cols='40' rows='5'>Pues yo...</textarea></label><br />\n";
	if ($_SESSION['idusuario'] =="") {
		echo "<img src='/?".$this->ncrpt('imagen&valor='.$seguridad)."' alt='Introduce este valor' title='Introduce este valor' />\n";
		echo "<input type='hidden' name='".$this->ncrpt('seguridadcrypt')."' value='".$this->ncrpt($seguridad)."' /><br />";
		echo "<input type='text' name='".$this->ncrpt('seguridad')."' value='' /><br />";
	}
	echo "<input type='submit' name='enviar' value='Comentar'>";
	echo "</div>";

		if (is_array($_SESSION['error'])) {
			echo "<div class='diverror'>";
			foreach ($_SESSION['error'] as $i => $j) 
				echo "Error:  $j <br>";
			echo "</div>";
			unset($_SESSION['error']);
			$_SESSION['error'] = "";
		}	

	echo "</div>";
	
	echo "</div>";
	
	$this->insertar("actualiza_lecturas",array($id));
	
}


/**
* wl_crear_entrada
* Crea una nueva entrada
*/
function wl_crear_entrada () {
	
	include_once './lib/weblog/tag.inc.php';	
	$tag = new Tag($this->KEY);
	
	// Un valor aleatorio para el cÃ³digo de seguridad
	$seguridad = $this->aleatorio();
	echo "<div class='entrada'>";

	// En caso de error...
		if (isset($_SESSION['error'])) {
			echo "<div class='diverror'>";
			foreach ($_SESSION['error'] as $i => $j) 
				echo "Error:  $j <br>";
			echo "</div>";
			unset($_SESSION['error']);
			$_SESSION['error'] = "";
		}	
		
	echo "<div class='formularioentrada'>";
	echo "Crear una entrada"; 
	echo "<form name='formulario' method='POST' action='?".$this->ncrpt("ap_crearentrada&ac=guardar")."'>";
	echo "<label id='tituloent' name='tituloent'>T&iacute;tulo</label>";
	echo "<input type='text' name='".$this->ncrpt('titulo')."' value='".$_POST[$this->ncrpt('titulo')]."' /><br />";
	echo "<label id='textoent' name='textoent'>Texto</label>";
	echo "<textarea name='".$this->ncrpt('texto')."' cols='70' rows='20'>".$_POST[$this->ncrpt('texto')]."</textarea><br />";
	echo "<label id='tagsent' name='tagsent' valign='top'>Tags</label>";
	echo $tag->listaTags() ."<br />";
	echo "<img src='?".$this->ncrpt('imagen&valor='.$seguridad)."' alt='Introduce este valor' title='Introduce este valor' />";
	echo "<input type='hidden' name='".$this->ncrpt('seguridadcrypt')."' value='".$this->ncrpt($seguridad)."' /><br />";
	echo "<input type='text' name='".$this->ncrpt('seguridad')."' value='' /><br />";
	echo "<input type='submit' name='enviar' value='Guardar'>";
	echo "</div>";


	echo "</div>";
	
//	echo "</div>";
//	echo "</div>";
		
}


/**
* wl_crear_entrada
* Crea una nueva entrada
*/
function wl_editar_entrada ($id) {
	
	include_once './lib/weblog/tag.inc.php';	
	$tag = new Tag($this->KEY);

	$entrada = $this->seleccionar("select_entrada",array($id));
	
	if (!$entrada->length()) {
		echo "No existe la entrada<br />";
		echo "<br /><br /><a href='?'>Vaaale</a>";		
		return;
	}	
	
	$comentarios = $this->seleccionar("select_comentarios_entrada", array($id));
	$totalcomentarios = $this->seleccionar("total_comentarios", array($id));
	$tags = $this->seleccionar("tags_entrada", array($id));
	$ar_tags = array();
	
	while ($tags->hasMoreElements()){
			$ar_tags[] = $tags->getValue('idtag');
			$tags->next();
	}		
	
	// Un valor aleatorio para el cÃ³digo de seguridad
	$seguridad = $this->aleatorio();
	echo "<div class='entrada'>";

	// En caso de error...
		if (isset($_SESSION['error'])) {
			echo "<div class='diverror'>";
			foreach ($_SESSION['error'] as $i => $j) 
				echo "Error:  $j <br>";
			echo "</div>";
			unset($_SESSION['error']);
			$_SESSION['error'] = "";
		}	
		
	echo "<div class='formularioentrada'>";
	echo "<a href='?".$this->ncrpt("verentrada&id=$id")."'>Volver a la entrada</a><br />"; 
	echo "Modifica una entrada"; 
	echo "<form name='formulario' method='POST' action='?".$this->ncrpt("ap_editarentrada&ac=guardar")."'>";
	echo "<input type='submit' name='enviar' value='Guardar'>";
	echo "<input type='hidden' name='".$this->ncrpt('identrada')."' value='".$entrada->getValue('identrada')."' /><br />";
	echo "<label id='tituloent' name='tituloent'>T&iacute;tulo</label>";
	echo "<input type='text' name='".$this->ncrpt('titulo')."' value='".$entrada->getValue('titulo')."' /><br />";
	echo "<label id='textoent' name='textoent'>Texto</label><br />";
	echo "<textarea name='".$this->ncrpt('texto')."' cols='80' rows='20'>".$entrada->getValue('texto')."</textarea><br />";
	echo "<label id='tagsent' name='tagsent' valign='top'>Tags</label><br />";
	echo $tag->listaTagsSeleccionados($ar_tags) ."<br />";
// Seguridad 
//	echo "<img src='?".$this->ncrpt('imagen&valor='.$seguridad)."' alt='Introduce este valor' title='Introduce este valor' />";
//	echo "<input type='hidden' name='".$this->ncrpt('seguridadcrypt')."' value='".$this->ncrpt($seguridad)."' /><br />";
//	echo "<input type='text' name='".$this->ncrpt('seguridad')."' value='' /><br />";
/////////////
	echo "<input type='submit' name='enviar' value='Guardar'>";
	echo "</div>";


	echo "</div>";
	
		
}

/**
* wl_enlaces
* Muestra la seccion de enlaces
*/
function wl_enlaces () {
	echo $this->valores['enlaces'];
}

/**
* wl_links_internos
* Muestra la seccion de enlaces internos
*/
function wl_links_internos () {
	echo $this->valores['links'];
}

/**
* wl_categorias
* Muestra las categorias disponibles en el blog
*/
function wl_categorias () {
	$categorias = $this->seleccionar("select_tags");
	
	echo "<ul>";
	while ($categorias->hasMoreElements()){
		echo "<li><a href='?".$this->ncrpt('listarportag&id='.$categorias->getValue('idtag'))."'>";
		echo $categorias->getValue("nombre");
		echo "</a> (" .$categorias->getValue("total") .") ";
		$categorias->next();
	}
	echo "</ul>";
}

/**
* wl_titulo
* Muestra el titulo del blog
*/
function wl_titulo () {
	echo "<a href='?'>".$this->valores['titulo']."</a>";
}


/**
* wl_tagline
* Muestra el tagline del blog
*/
function wl_tagline () {
	echo $this->valores['tagline'];
}

/**
* wl_pie_de_blog
* Muestra el pie de pÃ¡gina del blog
*/
function wl_pie_de_blog () {
	echo $this->valores['pie'];
}


/**
* recomienda
* Genera el cÃ³digo de enlaces para recomendar
*/
function recomienda ($url, $title) {	
		$html = "";

		$url = "http://".$_SERVER['HTTP_HOST']."/".$url; 

		// Meneame	
		$html .="<a href='http://meneame.net/submit.php?url=$url&title=$title'>\n";
		$html .="<img src='./irudiak/meneame.gif' style='border: none;' alt='&iexcl;Men&eacute;ame!'/></a>\n";

		// Digg
		$html .="<a href='http://digg.com/submit?phase=3&url=$url&title=$title' target='_blank'>\n";
		$html .="<img src='./irudiak/digg.jpg' style='border: none;' alt='Digg it!'/></a>\n";

		// Delicious
		$html .="<a href='http://del.icio.us/post?v=2&url=$url&title=$title' target='_blank'>\n";
		$html .="<img src='./irudiak/delicious.gif' style='border: none;' alt='del.icio.us it!'/></a>\n";
		
		// Technorati
		$html .="<a href='http://technorati.com/faves?add=http://www.pello.info' target='_blank'>\n";
		$html .="<img src='./irudiak/technorati.jpg' style='border: none;' alt='a Technorati'/></a>\n";	

		// Blogmarks
		$html .="<a href='http://www.blogmarks.net/my/new.php?title=$title&summary=$title&url=$url&via=$url&tags=pello' target='_blank'>\n";
		$html .="<img src='./irudiak/blogmarks.gif' style='border: none;' alt='Blogmark it!'/></a>\n";
		
		return $html;
}


/**
* teaser
* Saca parte de una entrada a partid de <!--break-->
* o de cierta cantidad de caracteres
*/
function teaser ($texto) {	
	$partes = split("<!--break-->", $partes);
	
	// Si no tiene el break, a buscar un cacho!
	if (count($partes) == 1 && strlen($texto) > 512) {	
		if ( ($pos = strpos ($texto, " ", 512 ) )) {	
			return substr($texto, 0, $pos). "... ";
		}	
		return substr($texto, 0, 512). "... ";
	}
		return $texto;
}

/**
* maquear
* mejora el texto poniendo links, etc..
*/
function maquear ($texto) {
	$resultado = "";
	$resultado = ereg_replace("[[:alpha:]]+://[^<>[:space:]]+[[:alnum:]/]","<a href='\\0'>\\0</a>", $texto);
	
	return $resultado;
}
/**
* aleatorio
* Muestra un valor aleatorio para los comentarios
*/
function aleatorio () {
	return substr(round(rand()),0,5);
}

}


?>
