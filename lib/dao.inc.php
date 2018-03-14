<?php
/**
 * $Id$
 * phpframework - v1.0 - http://www.cuatrovientos.org
 * Pello Xabier Altadill Izura - Instituto Cuatrovientos 
 * dao.inc
 * Toda la lógica de acceso a datos
 * Esta clase conviene utilizarla con el fichero CONFIG
 *
 */ 


class Dao {

  var $db;	// Objeto de manipulacion de BBDD
  var $db_type = 1;   // Tipo de BBDD
  var $host = 20;     // Host de BBDD
  var $port  = 80;    // Puerto de BBDD
  var $db_name = "post"; 
  var $user = ""; // Usuario de la BBDD
  var $password = ""; // Password
  var $logger;		// Clase para guardar logs
	/**
	* constructor
	*/
	function Dao ($ds="") {
	require './lib/config.inc.php';
	include_once './lib/data.inc.php';
	include_once './lib/log.inc.php';

	// si $ds no tiene nada, le asignamos la establecida defecto
	$ds = ($ds=="")?$defaultdb:$ds;
	
	$this->logger = new Logger();
	$this->logger->debug("Ha entrado $ds : " . $datasources["$ds"]['ds_type'] ."<br>");
	
	 // Si se requiere un DS de tipo conocido
	 if ($datasources[$ds]['ds_type'] == "mysql" || 
	     $datasources[$ds]['ds_type'] == "pgsql" ||
	     $datasources[$ds]['ds_type'] == "odbc" ||
	     $datasources[$ds]['ds_type'] == "oracle") {
		 include_once './lib/database_'.$datasources[$ds]['ds_type'].'.inc.php';
		 // Instancia
	         $this->db = new Database($datasources[$ds]['ds_type'],
					$datasources[$ds]['ds_host'],
					$datasources[$ds]['ds_port'],
					$datasources[$ds]['ds_name'],
					$datasources[$ds]['ds_username'],
					$datasources[$ds]['ds_password']);
	 } else {
		echo "NO CONECTADO<br>"; 
	 }

	 // Conectar
	 $this->connect();
	}

	/**
	* getData
	* recupera datos de la BBDD
	* $options : opciones de paginacion
	*/
	function getData ($query="",$parameters=Array(),$options="") {
		 include './lib/query.sql.inc.php';
		 include_once './lib/dialog.inc.php';
		$finalquery = $this->createSQL($query_sql[$query],$parameters) . $options;
		$this->logger->log("Query: ".$finalquery);
		// Realizamos la consulta y la asignamos a un Array
		// Controlamos si hay errores
		if ( !($rs = $this->db->select($finalquery)) ) {
			$dialog = new Dialog();
			$dialog->errorsql("Se produjo un error en el acceso a BBDD.");
			exit; // Detenemos la ejecucion
		}
		$data = $this->loadData($rs);
		return $data;
	}
	
	
	/**
	* setData
	* Establece datos en la BBDD
	*/
	function setData ($query="",$parameters) {
		 include './lib/query.sql.inc.php';
		 include_once './lib/dialog.inc.php';
		$finalquery = $this->createSQL($query_sql[$query],$parameters);
		$this->logger->log("Query: ".$finalquery);
		// Realizamod la ejecucion
		if (!$this->db->update($finalquery)) {
			$dialog = new Dialog();
			$dialog->errorsql("Se produjo un error en la modificacion de la BBDD");
			exit; // Detenemos la ejecucion
		}
	}

	/**
	* connect
	* Conecta con la BBDD
	*/
	function connect () {
		$this->db->connect();
		$this->logger->log("Conectado a ".$this->db->dbname);
	}
	
	/**
	* close
	* Establece datos en la BBDD
	*/
	function close () {
		$this->db->close();
		$this->logger->log("Desconectado de ".$this->db->dbname);
	}
	
	/**
	* createSQL
	* a partir de la query parametrizable
	* genera la query final con los parametros
	*/
	function createSQL ($query,$parameters) {
		$resultquery = "";
		$cont = 0;

		// si los parametros estan vacios, vuelta
		if (count($parameters) == 0) {
			return $query;
		}
		// Cada ocurrencia de ? la sustituye
		// por un parametro
		for ($i=0;$i < strlen($query);$i++) {
		 if ($query[$i] == '?') {
			$resultquery .= $parameters[$cont++];
		 } else {
			$resultquery .= $query[$i];
		 }
		}
		return $resultquery;
	}

	/**
	* loadData
	* a partir de el resultado de una query genera una Matriz de resultados
	* contenido en el objeto DATA
	*/
	function loadData ($rs) {
		$data = new Data();
		$total = $this->db->rslen($rs);

		// Cargamos los nombres de campo
		$data->setFields($this->db->getFields($rs));

		//$data->fields = $this->db->getFields($rs);
		for ($i=0; $i<$total; $i++) {
			$data->matrix[$i] = $this->db->fetchArray($rs,$i); 
		}
		return $data;
	}


        /**
        * genTable
        * genera una tabla con los datos de un result set
        */
        function genTable ($query="",$param=array(),$title="",$css="",$fields=array(),$link_fields=array(),$linked_text=array()) {

              $data = $this->getData($query,$param);
	      $result = $data->data2Table($fields,$link_fields,$linked_text,$css);
              return $result;
        }

        /**
        * genRecordTable
        * genera una tabla con los datos de un registro
        */
        function genRecordTable ($query="",$param=array(),$title="",$css="",$fields=array(),$link_fields=array(),$linked_text=array()) {

              $data = $this->getData($query,$param);
              $result = $data->data2Register($title,$css,$fields,$link_fields,$linked_text);
              return $result;
        }

        /**
        * genRecordModify
        * genera una tabla con los datos de un registro modificables
        */
        function genRecordModify ($query="",$param=array(),$title="",$css="",$form_action="") {

              $data = $this->getData($query,$param);
              $result = $data->data2Modify($title,$css,$form_action);
              return $result;
        }

		/**
		* generaID
		* Genera un id unico basandose en la fecha por milisegundos
		*/
		function generaID  () {
    		list($useg, $seg) = explode(" ", microtime());
		   $total = ($useg + (float)$seg);
					echo "Microtime: " .microtime(). "<br>";
					echo "Tiempo total: " .$total . " y " .$useg. " y " .$seg ."<br>";
		}

}// end class	
?>
