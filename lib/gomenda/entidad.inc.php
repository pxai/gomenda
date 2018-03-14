<?php
/**
* $Id: entidad.inc.php 75 2006-04-27 10:38:50Z pello $
* phpframework - v1.0 -  http://www.cuatrovientos.org
* Pello Xabier Altadill Izura - Instituto Cuatrovientos 
* entidad.inc.php
* SuperClase que agrupa la funcionalidad basica respecto
* al origen de datos: insertar, seleccionar, etc... 
*/

// Conexion, seleccion de base de datos
include_once './lib/dao.inc.php';
include_once './lib/crypter.inc.php';
include_once './lib/error.inc.php';
include_once './lib/utiles.inc.php';



class Entidad {
	
	// INSERT: instruccion para insertar una nueva entidad
	var $INSERT;

	// UPDATE: instruccion para modificar una entidad
	var $UPDATE;

	// SELECT: instruccion para hacer una select de todas las entidades
	var $SELECT;

	// SELECT: instruccion para hacer una select de busqueda
	var $SELECT_SEARCH;

	// SELECT: instruccion para hacer una select paginada
	var $SELECT_PAGED;

	// SELECT_4_UPDATE: instruccion para hacer una select de un unico
	// elemento de cara a un formulario de actualizacion
	var $SELECT_4_UPDATE;
	
	// Instruccion de borrado
	var $DELETE;

	// Clave para cifrados
	var $KEY;	
	
	// Ultimo ID generado
	var $ultimoID;
	
	// Total registros (para paginacion)
	var $totalRegistros;
	
	// cifrador
	var $crptr;
	
	// utiles
	var $util;
	
	// path
	var $path;
	
	/**
	* Constructor por defecto
	*/
	function Entidad($key="",$insert="", $update="", $select="", $select_paged="", $select_search="", $select_4_update="", $delete = "") {
		$this->INSERT = $insert;
		$this->UPDATE = $update;
		$this->SELECT = select;
		$this->SELECT_SEARCH = $select_search;
		$this->SELECT_PAGED = $select_paged;
		$this->SELECT_4_UPDATE = $select_4_update;
		$this->DELETE = $delete;
		$this->KEY = ($key != "")?$key:"";
		$this->crptr = new Crypter($this->KEY);
		$this->util = new Utiles();
	}

	/**
	* insertar
	* Funcion que realiza la insercion de una entidad en la BBDD
	*/
	function insertar ($query="", $parametros=NULL) {

		$query= ($query=="")?$this->INSERT:$query;
		
		// Instancia de acceso a datos
		$acceso = new Dao();	

		// Realizar la insercion SQL
		$resultado = $acceso->setData($query, $parametros);

		// cerramos la conexion
		$acceso->close();		
	}	
	
	
	
	/**
	* insertarconID
	* Funcion que realiza la insercion de una entidad en la BBDD
	* pero antes calcula un valor ID nuevo
	* La query de insercion debe tener en cuenta que la ID va al final
	*/
	function insertarconID ($querymax, $query="", $parametros=NULL) {

		$query= ($query=="")?$this->INSERT:$query;

		// Instancia de acceso a datos
	
		//$acceso->getData("begin",NULL);

		$nuevoid = $this->nuevoID($querymax);
		
		array_push($parametros, $nuevoid);
		
		$acceso = new Dao();	

		// Realizar la insercion SQL
		$resultado = $acceso->setData($query, $parametros);

//		$acceso->getData("commit",NULL);

		// cerramos la conexion
		$acceso->close();		
		
		$this->ultimoID = $nuevoid;
		return $nuevoid;
	}
	
	/**
	* modificar
	* Funcion que realiza la modificacion de una entidad en la BBDD
	*/
	function modificar ($query="", $parametros=NULL) {
			
		$query= ($query=="")?$this->UPDATE:$query;
		
		// Instancia de acceso a datos
		$acceso = new Dao();	

		// Realizar la insercion SQL
		$resultado = $acceso->setData($query, $parametros);

		// cerramos la conexion
		$acceso->close();		
	}	
	
	
	/**
	* eliminar
	* Funcion que realiza la eliminacion de una entidad en la BBDD
	*/
	function eliminar ($query="", $parametros=NULL) {
		
		$query= ($query=="")?$this->DELETE:$query;
		
		// Instancia de acceso a datos
		$acceso = new Dao();	

		// Realizar la insercion SQL
		$resultado = $acceso->setData($query, $parametros);

		// cerramos la conexion
		$acceso->close();		
}	
	
	/**
	* eliminarMultiple
	* Funcion que realiza la eliminacion de una entidad en la BBDD
	* esta eliminacion se hace con sentencias de este tipo
	* delete from table where campo in (?) donde la ? se debe
	* sustituir por los valores del parametro
	*/
	function eliminarMultiple ($query="", $parametros=NULL) {
		
		$query= ($query=="")?$this->DELETE:$query;
		
		// Instancia de acceso a datos
		$acceso = new Dao();	

		// Realizar la insercion SQL
		$resultado = $acceso->setData($query, $parametros);

		// cerramos la conexion
		$acceso->close();		
	}

	/**
	* seleccionar
	* Funcion que realiza la seleccion de entidades de la BBDD
	*/
	function seleccionar ($query="", $parametros=NULL) {

		$query= ($query=="")?$this->SELECT:$query;
		
		// Instancia de acceso a datos
		$acceso = new Dao();	

		// Realizar la insercion SQL
		$resultado = $acceso->getData($query, $parametros);

		// cerramos la conexion
		$acceso->close();		
		
		return $resultado;

	}	

	/**
	* seleccionar_busqueda
	* Funcion que realiza la seleccion de entidades de la BBDD para busqueda
	*/
	function seleccionar_busqueda ($query="", $parametros=NULL) {
		$query= ($query=="")?$this->SELECT_SEARCH:$query;
		
		// Instancia de acceso a datos
		$acceso = new Dao();	

		// Realizar la insercion SQL
		$resultado = $acceso->getData($query, $parametros);

		// cerramos la conexion
		$acceso->close();		
		
		return $resultado;

	}	


	/**
	* seleccionar_paginacion
	* Funcion que realiza la seleccion de entidades de la BBDD
	* con paginacion
	* Opcionalmente tiene campo para el criterio de ordenacion y el tipo de orden ASC o DESC
	*/
	function seleccionar_paginacion ($query="", $parametros=NULL, $querytotal="",$limit=0, $offset=0, $order="", $ord="ASC") {
		// Aqui meteremos las opciones de paginacion, orden etc
		$sqloptions = "";

		// Metemos el campo de ordenacion
		if ($order != "") {
			$sqloptions = " order by " . $order . " " . $ord;
		}

		$limit = (!$limit)?10:$limit;
		$offset = ($offset == "")?0:$offset;

		$sqloptions .=  " LIMIT " .$limit. " OFFSET " . $offset;
		
//		echo "Query: " .$sqloptions;
		// Instancia de acceso a datos
		$acceso = new Dao();	

		// Recuperamos el total de registros que tenemos
		$total = $acceso->getData($querytotal,$parametros);
		$this->totalRegistros = $total->getValue("total");
//		echo "Total de reg: " . $this->$totalRegistros . "<br />";

		// Realizar la insercion SQL
		$resultado = $acceso->getData($query, $parametros, $sqloptions);

		// cerramos la conexion
		$acceso->close();		
		
		return $resultado;

	}	


	/**
	* seleccionar_update
	* Funcion que realiza la seleccion de una entidad en la BBDD
	* de cara a realizar una insert
	*/
	function seleccionar_update ($query="", $parametros=NULL) {
		$query= ($query=="")?$this->SELECT_4_UPDATE:$query;
		
		// Instancia de acceso a datos
		$acceso = new Dao();	

		// Realizar la insercion SQL
		$resultado = $acceso->getData($query, $parametros);

		// cerramos la conexion
		$acceso->close();		
		
		return $resultado;

	}	
	
	
	/**
	* nuevoID
	* Funcion que selecciona EL ID mas alto de una tabla
	* La select se debe hacer select max(*) as maximo
	*/
	function nuevoID ($query) {
		
		$nuevoID = -1;
		
		// Instancia de acceso a datos
		$acceso = new Dao();	

		// Realizar la insercion SQL
		$resultado = $acceso->getData($query, $parametros);

		// cerramos la conexion
		$acceso->close();		

		$nuevoID = $resultado->getValue('maximo');

		return (($nuevoID!='')?($nuevoID + 1):1);

	}
	
	/**
	* todosCheckbox
	* genera una lista de conceptos seleccionables
	*/
	function todosCheckbox ($query, $parametros=NULL, $id, $nombre, $link, $linkdetalle="") {
		
		$datos = NULL;
		$datos = $this->seleccionar($query,$parametros);
		return $datos->data2Checkbox($id, $nombre, $link, $linkdetalle,"",$this->KEY);
	}


	/**
	* todosLista
	* genera una lista de datos
	*/
	function todosLista ($query, $parametros=NULL, $campo=NULL, $campo2=NULL ) {
		
		$datos = NULL; 
		$datos = $this->seleccionar($query,$parametros);
		return $datos->data2List($campo, $campo2 );
	}

	/**
	* detalle
	* Muestra el detalle de un registro, con todos sus campos
	*/
	function detalle ($query, $parametros, $title="",$css="",$fields=array(),$link_fields=array(),$linked_text=array()) {
		
		$datos = NULL;
		$datos = $this->seleccionar($query,$parametros);
		return $datos->data2Register($title,$css,$fields,$link_fields,$linked_text);
	}

	/**
	* setKey
	* establece una clave para los cifrados
	*/
	function setKey ($newKey) {
		$this->KEY = $newKey;
		$this->crptr->setKey($newKey);
	}

	/**
	* ncrpt
	* Encripta
	*/
	function ncrpt ($texto){
		return $this->crptr->encrypt($texto);
	}

	/**
	* dcrpt
	* desencripta
	*/
	function dcrpt ($texto){
		return $this->crptr->decrypt($texto);
	}
	
}// class

?>
