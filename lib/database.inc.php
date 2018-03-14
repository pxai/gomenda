<?php
/**
* $Id$
* phpframework - v1.0 http://www.cuatrovientos.org
* Pello Xabier Altadill Izura - Instituto Cuatrovientos 
* database.inc
* funciones de acceso a la BBDD
**
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
function Database ($tipo = "mysql", $host = "ejemplo", $port = 3306,$dbname = "test", $username ="test", $password = "ar57tea") {
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
}

/**
* select
* devuelve un ResulSet.
*/
function select ($query) {
}

/**
* insert
* Funcion para insertar nuevos registros.
* Devuelve un String vacio, y si hay errores devolveria un mensaje.
*/	
function insert ($query) {
}

/**
* update
* Funcion para modificar registros.
* Devuelve un String vacio, y si hay errores devolveria un mensaje.
*/	
function update ($query) {
}
	
/**
* delete
* Funcion para eliminar registros.
* Devuelve un String vacio, y si hay errores devolveria un mensaje.
*/	
function delete ($query) {
}

/**
* rslen
* devuelve el tamaÃ±o del ResultSet
*/
function rslen ($rs) {
}

/**
* fetchArray
* devuelve un array con el contenido de un registro
*/
function fetchArray ($rs) {
}

/**
* fetchObject
* devuelve un array con el contenido de un registro en modo objeto
*/
function fetchObject ($rs) {
}


/**
* count
* devuelve el valor de una consulta select count(*)
*/
function count ($rs,$field = 0) {
}

/**
* close
* Para cerrar la conexion con la BBDD
*/
function close () {
}

/**
* getFields
* devuelve un array con el los nombres de campos que tiene un RS
*/
function getFields ($rs) {
}

}// end class

?>
