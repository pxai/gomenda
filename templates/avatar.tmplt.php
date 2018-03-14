<?php

header("Content-Type: image/png");

mysql_connect("localhost", $datasources['mysql_1']['ds_username'], $datasources['mysql_1']['ds_password']) or
    die("Could not connect: " . mysql_error());
mysql_select_db($datasources['mysql_1']['ds_name']);
		
$result = mysql_query("SELECT avatar,avatartb FROM usuarios WHERE idusuario=".$id);
$result_array = mysql_fetch_array($result);

if ($tb != 1)
	echo $result_array[0];
else
	echo $result_array[1];

mysql_close();

?>