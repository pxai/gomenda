<?php

	include_once './lib/gomenda/entrada.inc.php';
	$entrada = new Entrada($path);
	
	$formulario = new Formulario("","form_alta_entrada","post","$path/?crearentrada&ac=Guardar");

	if ($ac=="" && $_SESSION["login"]!="")	
	{			
		// Muestra la entrada sí?
		//$entrada->nuevaEntrada($_SESSION["login"]);
		$formulario->incomplete = 1;
		echo $formulario->generar(0);

		?>

		<label>Tu opini&oacute;n</label><br />
		<label style="color:green">Mola<input type="radio" name="idsemaforo" style="background-image:url('<?php echo $path; ?>/irudiak/berde.gif')" value="1" /></label>
		<label style="color:orange">Ni fu ni fa<input type="radio" name="idsemaforo" style="background-image:url('<?php echo $path; ?>/irudiak/hori.gif')" value="2" /></label>
		<label style="color:red">NO me ha gustado<input type="radio" name="idsemaforo" style="background-image:url('<?php echo $path; ?>/irudiak/gorri.gif')" value="3" /></label>
		<br />
		<input type="submit" name="enviar" value="Enviar" />
		</form></fieldset>
		<?php
	}
	elseif ($ac=="" && $_SESSION["login"]=="")	
	{			
		echo "<p>Debes <a href='$path/?login'>logearte</a> o tener un <a href='$path/?registro'>usuario.</a></p>";
		?>
		<p>Lo único que hace falta es un login y un email por si se te olvida la contraseña. El email
		no es para darte el coñazo.</p>
<?php
		// Muestra la entrada
	}
	elseif ($ac == "Guardar")
	{

			
			if ($formulario->validar() && $entrada->guardarEntrada($_SESSION["idusuario"]))
			{
					$entidad->insertar("update_monedas",array(5,$_SESSION['idusuario']));
				// Muestra la entrada
				echo "<span style='text-align:center'>OK, entrada creada con &eacute;xito.<br />";
				echo "<a href='?'>Inicio</a></span>";
			}
			else
			{
				echo "Error en la entrada";
				$formulario->incomplete = 1;
				echo $formulario->regenerar(0);

				?>
		<label>Tu opini&oacute;n</label><br />
		<label style="color:green">Mola<input type="radio" name="idsemaforo" style="background-image:url('<?php echo $path; ?>/irudiak/berde.gif')" value="1" /></label>
		<label style="color:orange">Ni fu ni fa<input type="radio" name="idsemaforo" style="background-image:url('<?php echo $path; ?>/irudiak/hori.gif')" value="2" /></label>
		<label style="color:red">NO me ha gustado<input type="radio" name="idsemaforo" style="background-image:url('<?php echo $path; ?>/irudiak/gorri.gif')" value="3" /></label>
		<br />
					<input type="submit" name="enviar" value="Enviar" />
					</form></fieldset>
				<?php
			}
			
	}
	else
	{
	}
		
?>
