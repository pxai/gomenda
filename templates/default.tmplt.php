<?php
header('Content-type: text/html; charset=utf-8'); 

include_once './lib/formulario.inc.php';
include_once './lib/dialog.inc.php';
include_once './lib/utiles.inc.php';
include_once './lib/gomenda/entidad.inc.php';
include_once './lib/gomenda/display.inc.php';
$weblog = new Display($clave);
$entidad = new Entidad($clave);
$util = new Utiles();

$weblog->wl_iniciar();

if ($page=="entrada")
{
	$datos = $entidad->seleccionar("select_entrada",array($id));
	$titulo = " - Recomendación: " . $datos->getValue("titulo");
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es"lang="es" dir="ltr">
 <head>
 <title>
        gomenda.net&nbsp;&nbsp;O O O&nbsp;&nbsp; Recomendaciones a mansalva <?php echo $titulo; ?>
    </title>
<meta http-equiv="Content-Type"
    content="text/html; charset=utf-8" />
 <meta name="keywords" content="Gomenda, recomienda, sugerencia, opinión, crítica, libros, pelí­culas, juegos" />
 <meta name="description" content="Gomenda es una web para recomendar, criticar, sugerir cualquier cosa que hayas probado como videojuegos, libros, pelí­culas, etc..." />
 <meta name="author" content="root"/>
 <meta name="generator" content="Bluefish 1.0.7"/>
<link rel="alternate" type="application/rss+xml" title="RSS 2.0" href="<?php echo $path;?>/?rss2" />
<link rel="icon" href="/favicon.ico" type="image/x-icon" />
<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
 <link rel="stylesheet" type="text/css" href="<?php echo $path;?>/?estilo" />
    <script type="text/javascript" language="javascript" src="<?php echo $path;?>/js/funciones.js">
    // <![CDATA[
    // ]]>
    </script>
        
</head>

<body>
<div id="edukia">
	<div id="goiburua">
				<div id="logo">
				<a href="<?php echo $path;?>"><img src="<?php echo $path;?>/irudiak/logomenda.jpg" alt="Logomenda" title="Logomenda, versión alfa" border="0" align="left" /></a>
				</div>
				<div id="menu">
					<ul id="goiburumenu">
						<li>
							<?php 
							if ($_SESSION['login'] != "")
							{
								echo "Hola <a href='".$path."/?usuario&id=".$_SESSION['idusuario']."' title='Ver y modificar perfil'>". $_SESSION['login'] . "</a>. <a href='".$path."/?logout'>logout</a></li><li>|</li>";
							}else{
							?>
								<a href="<?php echo $path."/?".$cifrador->encrypt('login');?>">login</a>
								</li><li>|</li>
								<li><a href="<?php echo $path;?>/?registro">registro</a></li><li>|</li>
							<?php
							}
							?>
						<li><a href="<?php echo $path;?>/?wtf">&iquest;Qué es esto?</a></li><li>|</li>
						<li><form name="buscar" method="post" action="<?php echo $path;?>/?busqueda" style="display: inline" ><label>Buscar<input type="text" name="terminobusqueda" size="15" value="" /></label></form></li>
					</ul>
				</div>
		</div>

		<div id="azpig">
			<?php
				include_once './templates/categorias.tmplt.php';
			?>
		</div>
		<div id="azpig2">&nbsp;</div>
		<div id="zentrua">
			<div id="ezkerra">
			<?php
				include_once './templates/lateral.tmplt.php';
			?>
			</div>

		<?php
			if (preg_match("/^[a-z]{3,15}$/",$page) && file_exists('./templates/'.$page.'.tmplt.php') ) 
			{
			?>
			<div id="gomendioak">
			<?php
				include_once './templates/'.$page.'.tmplt.php';
			?>
			</div>
			<?php
			}
			else
			{
		?>

		<div id="gomendioak">
		<div id="azpigoiburu">
			<a href="<?php echo $path;?>/?crearentrada"><img src="<?php echo $path;?>/irudiak/gomendatu.png" alt="Botón de recomendación" title="Pulsa aquí para recomendar algo" border="0" /></a>			
		</div>
		<?php
			$weblog->wl_ultimas_entradas($conf['paginacion'],$inicio, $sesion->login);
			}
		?>
		</div>
		
	  
	  </div>



	<div id="oina">
	<img src="<?php echo $path;?>/irudiak/logotx.gif" align="middle" alt="logomendatx" title="Mini logomenda mini gris" />
	&nbsp;&nbsp;Basado en el lamentable framework dordoka - <i> 
	<?php
		$bukaera = microtime(true);
		$guztira = $bukaera - $hasiera;

		echo "$guztira seg. \n";
	?></i>
	&copy;left gomenda.net 
	</div>

</div>

</body>
</html>
