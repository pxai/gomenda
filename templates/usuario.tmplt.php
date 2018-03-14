<div>
<?php


if ($ac == "" && preg_match("/^[0-9]{1,10}$/",$id)) 
{
	$usuario = $entidad->seleccionar("select_usuario",array($id));
	$totalentradas = $entidad->seleccionar("select_entradas_usuario",array($id));
	$totalcomentarios = $entidad->seleccionar("select_comentarios_usuario",array($id));
	$totalvotos = $entidad->seleccionar("select_total_votos_usuario",array($id));

	if (!$usuario->length())
	{
		echo "Ese usuario no existe.";
	}	
	else
	{
		$tentradas = $totalentradas->length();
		$tcomentarios = $totalcomentarios->length();
		$tvotos = $totalvotos->getValue('total');
		
		if ($_SESSION['idusuario'] == $id)  {
		
			echo "<a href='".$path."/?usuario&ac=Modificar'>Modificar datos</a>";
			echo "&nbsp;|&nbsp;<a href='".$path."/?usuario&ac=Avatar'>Cambiar avatar</a>";
		}
		
		if ($usuario->getValue('avatartb') == "") {
			echo "<br /><br /><img src='".$path."/irudiak/avatardef.png' title='Avatar de ".$usuario->getValue('login')."' alt='Avatar de ".$usuario->getValue('login')."' border='1' align='left' style='margin-right: 20px;' /><br />";
		} else {
			echo "<br /><br /><img src='".$path."/?avatar&id=".$id."' title='Avatar de ".$usuario->getValue('login')."' alt='Avatar de ".$usuario->getValue('login')."' border='1' align='left' style='margin-right: 20px;' /><br />";
		}
		echo "<h1>".$usuario->getValue('login')."</h1>\n";
		echo "<ul id='datosusuario'>\n";
		echo "<li><b>Desde: </b>".$usuario->getValue('fecha')."</li>\n";
		echo "<li><b>Su morada: </b> <a href='".$usuario->getValue('url')."' title='Ir a la web de ".$usuario->getValue('login')."'>".$usuario->getValue('url')."</a></li>\n";
		echo "<li><b>Fuerza: </b>".($tentradas+($tcomentarios*0.5)+$tvotos*0.1)."</li>\n";
		echo "<li><b>Carisma: </b>".$tentradas."</li>\n";
		echo "</ul>\n";
		echo "<hr />\n";
		echo "<ul id='datosusuario'>\n";
		echo "<li><b>Recomendaciones aportadas: </b>".$tentradas."</li>\n";
		echo "<li><b>Comentarios: </b>".$tcomentarios."</li>\n";
		echo "<li><b>Votos: </b>".$tvotos."</li>\n";
		echo "</ul>\n";
		echo "<hr />\n";
		echo "<ul id='datosusuario'>\n";
		echo "<li><img src='".$path."/irudiak/txanpona.gif' alt='monedas' title='Monedas acumuladas' align='center' /><b>Monedas: </b>".$usuario->getValue('monedas')."</li>\n";
		//echo "<li><img src='".$path."/irudiak/trollbegi.gif' alt='monedas' title='Monedas acumuladas' align='center' /><b>Ojo del Troll</b></li>\n";
		//echo "<li><img src='".$path."/irudiak/trollmailu.gif' alt='monedas' title='Monedas acumuladas' align='center' /><b>Martillo TrollSmasher</b></li>\n";
		echo "</ul>\n";
	}
}
elseif ($ac == "Modificar")
{
	$usuario = $entidad->seleccionar("select_usuario",array($_SESSION['idusuario']));	
	$formulario = new Formulario("","form_modificar_usuario","post","$path/?usuario&ac=Salvar","","",$usuario);
	echo $formulario->generar();
}	
elseif ($ac == "Avatar")
{	
?>

<fieldset><legend>Modificar avatar</legend>
<form name='modificar usuario' method='post' action='<?php echo $path;?>/?usuario&ac=SalvarImagen'  class='formulame'  enctype="multipart/form-data"><br />

<label>Seleccionar fichero<br />
<input type='file' name='avatar'  value='' size='20' onFocus='conFoco(this)' onBlur='sinFoco(this)' /><br />
</label><br />

<br /><br /><input type='submit' name='enviar' value='enviar'><br />
</form>
</fieldset>

<?php

}
elseif ($ac == "Salvar")
{
	$formulario = new Formulario("","form_modificar_usuario","post","$path/?usuario&ac=Salvar");

	if ($formulario->validar() && $_POST['password'] == $_POST['password2'])
	{	
		// Comprobar si el usuario existe
		$entidad->modificar("update_usuario",array($_POST['password'],$_POST['email'],$_POST['url'],$_SESSION['idusuario']));
		echo "OK, datos modificados.<a href='".$path."/?usuario&id=".$_SESSION['idusuario']."'>Vale, vamos a ver.</a>";
		
	}
	else
	{
		echo "Incorrecto!! asegurate de que los passwords coinciden y que el resto de los campos cumple los requesitos.";
		echo $formulario->regenerar();
	}
}
elseif ($ac == "SalvarImagen")
{

	define("NAMETHUMB1", "./tmp/thumbtemp1" .  $_SESSION['idusuario']);
	define("NAMETHUMB2", "./tmp/thumbtemp2" .  $_SESSION['idusuario']);
	
  // Mime types permitidos
  $mimetypes = array("image/jpg","image/jpeg", "image/gif", "image/png");
  // Variables de la foto
  $name = $_FILES["avatar"]["name"];
  $type = $_FILES["avatar"]["type"];
  $tmp_name = $_FILES["avatar"]["tmp_name"];
  $size = $_FILES["avatar"]["size"];
  
  if ($size > 40000) {
  	echo "La imagen es demasiado grande. No más de 40Kbytes por favor.<br />";
  	echo "<a href='javascript:history.back()'>Volver</a></div>";
  	return;
  }
  echo "Nombre: " .$name. " tipo:" .$type. " tam:" .$size. "<br />";
  // Verificamos si el archivo es una imagen válida
  if(!in_array($type, $mimetypes))
    die("El archivo que subiste no es una imagen válida");

  // Creando el thumbnail
  switch($type) {
    case $mimetypes[0]:
    case $mimetypes[1]:
      $img = imagecreatefromjpeg($tmp_name);
      break;
    case $mimetypes[2]:
      $img = imagecreatefromgif($tmp_name);
      break;
    case $mimetypes[3]:
      $img = imagecreatefrompng($tmp_name);
      break;
  }
  
  $tam = getimagesize($tmp_name);

  $anchot = 25;
  $altot = 25;

  $ancho = 80;
  $alto = 80;

  $nueva = imagecreatetruecolor($ancho, $alto);
  $thumb = imagecreatetruecolor($anchot, $altot);

  imagecopyresampled($nueva, $img, 0, 0, 0, 0, $ancho, $alto, $tam[0], $tam[1]);
  imagecopyresampled($thumb, $img, 0, 0, 0, 0, $anchot, $altot, $tam[0], $tam[1]);

  switch($type) {
    case $mimetypes[0]:
    case $mimetypes[1]:
      imagejpeg($nueva, NAMETHUMB1);
      imagejpeg($thumb, NAMETHUMB2);
                break;
    case $mimetypes[2]:
      imagegif($nueva, NAMETHUMB1);
      imagegif($thumb, NAMETHUMB2);
      break;
    case $mimetypes[3]:
      imagepng($nueva, NAMETHUMB1);
      imagepng($thumb, NAMETHUMB2);
      break;
  }
  
  // Extrae los contenidos de las fotos
  # contenido de la foto original
  $fp = fopen(NAMETHUMB1, "rb");
  $final = fread($fp, filesize(NAMETHUMB1));
  $final = addslashes($final);
  fclose($fp);
  
  $fp = fopen(NAMETHUMB2, "rb");
  $tthumb = fread($fp, filesize(NAMETHUMB2));
  $tthumb = addslashes($tthumb);
  fclose($fp);


  // Borra archivos temporales si es que existen
  @unlink($tmp_name);
  @unlink(NAMETHUMB1);
  @unlink(NAMETHUMB2);


 	$entidad->modificar("update_avatar_usuario",array($final ,$tthumb,$_SESSION['idusuario']));
		echo "OK, avatar guardado.<a href='".$path."/?usuario&id=".$_SESSION['idusuario']."'>Vale, vamos a ver.</a>";



}
elseif ($ac == "Recordar")
{
	$formulario = new Formulario("","form_recordar_usuario","post","$path/?registro&ac=EnviarRecordar");	
	echo $formulario->generar();
}


?>
</div>
