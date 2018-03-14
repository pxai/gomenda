<?php
/**
* $Id$
* phpframework - v1.0 -  http://www.cuatrovientos.org
* Pello Xabier Altadill Izura - Instituto Cuatrovientos 
* sesion.inc.php
* Clase para manejar sesiones
*/

include_once './lib/crypter.inc.php';

class Sesion {

	var $idsesion="";
	var $login="";
	var $fechainicio="";
	var $keysesion = "";
	var $idusuario = "";
	var $cifrador;

	function Sesion($Idsession="",$Login="", $idusuario="",$Fechainicio="") {
		session_start();
		$this->login = $Login;
		$this->idusuario = $idusuario;
		$this->fechainicio = $Fechainicio;
		$this->cifrador = new Crypter();
	}


	// funcion para iniciar sesion y registrarla en la BBDD
	function iniciarSesion() {
		// inicia la session y genera un ID
		//session_start();
		$this->idsesion = $this->generaID();

		session_set_cookie_params(60*60*24*100); // 100 dÃ­as
		
		// Conexion, seleccion de base de datos
		include_once './lib/dao.inc.php';
		//include_once './lib/log.inc.php';
		//$log = new Log();
		$acceso = new Dao();

		$this->keysesion = $this->genKey();

		$this->cifrador->setKey($this->keysesion);
		$parametros = array($this->idsesion, $this->login ,$this->keysesion ,$this->cifrador->encrypt($this->login));
		// Realizar la insercion SQL
		$resultado = $acceso->setData("iniciar_session",$parametros);
		// cerramos la conexion
		$acceso->close();


		//echo "Este es el ID: ".$this->idsession ." y la consulta<br>".$consulta;
		$_SESSION['idsession'] = $this->idsesion;
		$_SESSION['login'] = $this->cifrador->encrypt($this->login);
		$_SESSION['idusuario'] = $this->cifrador->encrypt($this->idusuario);
		$_SESSION['key'] = $this->keysesion;
		//setcookie($_SESSION['login'],$_SESSION['idsession']);
		
	}
	
	// funcion para finalizar sesion y quitarla de la BBDD
	function finalizarSesion() {
		// termina la session
		// Conexion, seleccion de base de datos
		$this->idsesion = $_SESSION['idsession'];
		$this->login = $_SESSION['login'];


		// Conexion, seleccion de base de datos
		include_once './lib/dao.inc.php';
		$acceso = new Dao();
		$parametros = array($this->idsesion, $this->login);
		// Realizar la insercion SQL
		$resultado = $acceso->setData("terminar_session",$parametros);
		// cerramos la conexion
		$acceso->close();


		session_destroy();
		
	}

	// Funcion para comprobar si una sesion es valida
	// lo mira en la BBDD
	function comprobarSesion() {

		$sesionvalida = false;
		$miid = $_SESSION['idsession'];
		$milogin = $_SESSION['login'];

//		unset($_COOKIES['PHPSESSID']);
/*		foreach ($_COOKIES as $clave => $valor) {
			$miid = $valor;
			$milogin = $clave;
		}
*/

		if ($_SESSION['key'] == "")
		{
			$_SESSION['key'] = $this->genKey();
		}

		include_once './lib/dao.inc.php';
		$acceso = new Dao();
		$parametros = array($miid,$milogin);
		$data = $acceso->getData("comprobar_session",$parametros);
		$acceso->close();

		if ($data->getValue('logincifrado') == $milogin) {
			$sesionvalida = true;
			$this->login = $data->getValue('login');
			$this->keysesion = $data->getValue('key');
			$this->idprofesor = $data->getValue('tbl_profesor_id_profesor');
		}

		return $sesionvalida;
		
	}
	
	
	// Funcion para comprobar si una sesion es valida
	// lo mira en la BBDD
	function existeSesion($miid, $milogin) {

		$sesionvalida = false;

		include_once './lib/dao.inc.php';
		$acceso = new Dao();
		$parametros = array($miid,$milogin);
		$data = $acceso->getData("comprobar_session",$parametros);
		$acceso->close();

		if ($data->getValue('logincifrado') == $milogin) {
			$sesionvalida = true;
		}

		return $sesionvalida;
		
	}
	
	/*
	* Funcion que retorna el login
	* de la sesion actual
	*/
	function getLogin () {
		//session_start();
		return $_SESSION['login'];
	}
	
	/*
	* Funcion que retorna el login
	* de la sesion actual
	*/
	function getIDProfesor () {
		//session_start();
		$this->cifrador->setKey($this->keysesion);
		return $_SESSION['idprofesor'];
	}
	/**
	* genera un ID aleatorio
	* y lo convierte a base64
	*/
	function generaID() {

		$randval = "";

		// creamos una buena semilla aleatoria
		srand( ((int)((double)microtime()*1000003)) );

		// generamos cuatro numeros aleatorios
		for ($i=0;$i<3;$i++) {
		  $randval .= rand();
		}

		// Le metemos la IP como parte
		$randval .= ":".$_SERVER['REMOTE_ADDR'];
		// y devolvemos el resultado en base64
		return base64_encode($randval);
	}
	
	
	/**
	* genkey
	* genera una clave aleatoria
	*
	*/
	function genKey() {

		$randval = "";

		// creamos una buena semilla aleatoria
		srand( ((int)((double)microtime()*100000003)) );

		  $randval .= rand();

		// y devolvemos el resultado en base64
		return substr(base64_encode($randval),0,9);
	}

}

?>
