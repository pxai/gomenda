<?php
/**
* $Id$
* phpframework - v1.0
* by NHTaldea - http://nhtaldea.almacenweb.com - (C) NHTaldea labs
* database.inc
* funciones de acceso a la BBDD
**
*/

class Database {
/**
* Variables
*/	
var $connection = 0;
var $dbname;
var $username;
var $password;
var $host;
var $port; 
var $tipo;

/**
* Database
* constructor
*/	
function Database ($tipo = "mysql", $host = "localhost", $port = 3306,$dbname = "", $username ="", $password = "") {
	$this->tipo = $tipo;
	$this->host = $host;
	$this->port = $port;
	$this->dbname = $dbname;
	$this->username = $username;
	$this->password = $password;
}

/**
* connect
* Funcion para conectarse con la BBDD
*/
function connect () {
	$result = 0;

	$this->connection = mysql_connect($this->host,$this->username,$this->password) or die("<br><font face='verdana'><b>El servicio esta inactivo en este momento, perdone las molestias</b></font><br>");
	$result = mysql_select_db($this->dbname, $this->connection) or die("<br><font face='verdana'><b>Error al establecer BBDD activa: ".$this->dbname."</b></font><br>");
	return $result;
}

/**
* select
* devuelve un ResulSet.
*/
function select ($query) {
	$result = 0;
//	$result = mysql_db_query($this->dbname,$query,$this->connection) or die("<br><font face='verdana'><b>Error en consulta ".$query." BBDD: ".$this->dbname."</b></font><br>");
	$result = mysql_db_query($this->dbname,$query,$this->connection);
	return $result;
}

/**
* insert
* Funcion para insertar nuevos registros.
* Devuelve un String vacio, y si hay errores devolveria un mensaje.
*/	
function insert ($query) {
	$result = 0;
//	$result = mysql_db_query($this->dbname,$query,$this->connection) or die("<br><font face='verdana'><b>El servicio esta inactivo en este momento, perdone las molestias</b></font><br>");
	$result = mysql_db_query($this->dbname,$query,$this->connection);
	return $result;	
}

/**
* update
* Funcion para modificar registros.
* Devuelve un String vacio, y si hay errores devolveria un mensaje.
*/	
function update ($query) {
	$result = 0;
	$result = mysql_db_query($this->dbname,$query,$this->connection) ;
	return $result;	
}
	
/**
* delete
* Funcion para eliminar registros.
* Devuelve un String vacio, y si hay errores devolveria un mensaje.
*/	
function delete ($query) {
	$result = 0;
	$result = mysql_db_query($this->dbname,$query,$this->connection);
	return $result;	
}

/**
* rslen
* devuelve el tamaÃ±o del ResultSet
*/
function rslen ($rs) {
	return mysql_num_rows($rs);
}

/**
* fetchArray
* devuelve un array con el contenido de un registro
*/
function fetchArray ($rs) {
	return mysql_fetch_array($rs);
}

/**
* fetchObject
* devuelve un array con el contenido de un registro en modo objeto
*/
function fetchObject ($rs) {
	return mysql_fetch_object($rs);
}

/**
* count
* devuelve el valor de una consulta select count(*)
*/
function count ($rs,$field = 0) {
	return mysql_result($rs,0,$field);
}

/**
* close
* Para cerrar la conexion con la BBDD
*/
function close () {
	$result = mysql_close($this->connection) or die("<br><font face='verdana'><b>El servicio esta inactivo en este momento, perdone las molestias <br>(No se pudo cerrar la conexion)</b></font><br>"); 
	return $result;		
}

/**
* getFields
* devuelve un array con el los nombres de campos que tiene un RS
*/
function getFields ($rs) {
	for ($i=0;$i<mysql_num_fields($rs);$i++) {
		$fields[mysql_field_name($rs, $i)] = $i;
	}

	return $fields;
}

}// end class



?>
