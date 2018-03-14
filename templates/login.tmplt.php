<div>
<?php

$formulario = new Formulario("","form_login","post","$path/?comprobar_login");

if ($_SESSION["msgerror"] != "") 
{
	echo $_SESSION["msgerror"];
	unset($_SESSION["msgerror"]);
}

if ($ac == "") 
{
	echo $formulario->generar();
}
?>
<br />
<div><a href="<?php echo $path;?>/?registro&ac=Recordar">&iquest;Olvidaste tu contraseña piltrafilla?</a></div>
</div>