<?php

require_once "sesion.inc.php";
$sesiones = new Sesion();
$MENSAJES['logout_1'] = "Cerrando sesi&oacute;n...";


// Si la sesion no es valida...
$sesiones->finalizarSesion();

?>

<html>
<head>
<title>Cerrando sesi&oacute;n...</title>
<META HTTP-EQUIV=Refresh CONTENT="2; URL=/phpdocbook/index.php">
</head>
<body>

<?php

echo $MENSAJES['logout_1'] . "<br>";
echo $vuelta;
?>

</body>
</html>
