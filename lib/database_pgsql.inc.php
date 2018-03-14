<?php
/**
* $Id$
* phpframework - v1.0 - http://www.cuatrovientos.org
* Pello Xabier Altadill Izura - Instituto Cuatrovientos 
* database.inc
* funciones de acceso a la BBDD
*
*/

class Database {
/**
* Variables
*/	
var $connection;
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
function Database ($tipo = "", $host = "localhost", $port ="" ,$dbname = "galgo", $username ="", $password = "") {
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
	$this->connection = pg_connect("dbname=".$this->dbname."  host=".$this->host ." port=".$this->port." user=".$this->username ." password=".$this->password) or die("<br><font face='verdana'><b>El servicio esta inactivo en este momento, perdone las molestias. Conexion.</b></font><br>");
	$result = $this->connection;
	return $result;
}

/**
* select
* devuelve un ResulSet.
*/
function select ($query) {
	$result = 0;

		$result = @pg_query ($this->connection, $query);
		return $result;
}

/**
* insert
* Funcion para insertar nuevos registros.
* Devuelve un String vacio, y si hay errores devolveria un mensaje.
*/	
function insert ($query) {
	$result = 0;
	$result = @pg_query ($this->connection, $query) or die("<br><font face='verdana'>#".$query."#<b>El servicio esta inactivo en este momento, perdone las molestias(Consulta)</b></font><br>");
	return $result;	
}

/**
* update
* Funcion para modificar registros.
* Devuelve un String vacio, y si hay errores devolveria un mensaje.
*/	
function update ($query) {
	$result = 0;
	$result = @pg_query ($this->connection, $query) or die("<br><font face='verdana'>#".$query."#<b>El servicio esta inactivo en este momento, perdone las molestias(Consulta)</b></font><br>");
	return $result;	
}
	
/**
* delete
* Funcion para eliminar registros.
* Devuelve un String vacio, y si hay errores devolveria un mensaje.
*/	
function delete ($query) {
	$result = 0;
	$result = @pg_query ($this->connection, $query) or die("<br><font face='verdana'>#".$query."#<b>El servicio esta inactivo en este momento, perdone las molestias(Consulta)</b></font><br>");
	return $result;	
}

/**
* rslen
* devuelve el tamaÃ±o del ResultSet
*/
function rslen ($rs) {
	return @pg_numrows($rs);
//	return mysql_num_rows($rs) or die("<br><font face='verdana'><b>(0 registros)</b></font><br>");
}

/**
* fetchArray
* devuelve un array con el contenido de un registro
*/
function fetchArray ($rs,$ind=0) {
	return @pg_fetch_array($rs,$ind);
}

/**
* fetchObject
* devuelve un array con el contenido de un registro en modo objeto
*/
function fetchObject ($rs,$ind=0) {
	return @pg_fetch_object($rs,$ind);
}

/**
* count
* devuelve el valor de una consulta select count(*)
*/
function count ($rs,$field=0) {
	return @pg_numrows($rs);
}

/**
* close
* Para cerrar la conexion con la BBDD
*/
function close () {
	$result = @pg_close($this->connection) or die("<br><font face='verdana'><b>El servicio esta inactivo en este momento, perdone las molestias <br>(No se pudo cerrar la conexion)</b></font><br>"); 
	return $result;		
}


/**
* getFields
* devuelve un array con el los nombres de campos que tiene un RS
*/
function getFields ($rs) {
        for ($i=0;$i<@pg_numfields($rs);$i++) {
                $fields[@pg_fieldname($rs,$i)] = $i;
        }
        return $fields;
}

}// end class

?>
