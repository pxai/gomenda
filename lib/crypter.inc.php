<?php
/** 
 * $Id: crypter.inc.php 14 2006-03-01 12:32:45Z intranet $
 * phpframework - v1.0 http://www.cuatrovientos.org
* Pello Xabier Altadill Izura - Instituto Cuatrovientos  
 * crypter.inc
 * Clase para cifrado
 */ 

class Crypter {

  var $cifrador;
  var $key;

	/**
	* constructor
	*/
	function Crypter ($new_key="",$alg="") {
		require './lib/config.inc.php';
		include_once './lib/log.inc.php';

		$cypher = ($alg!="")?$alg:$cypher;
	
		$this->key = ($new_key != "")?$new_key:$chypher_key;
		$this->logger = new Logger();
		$this->logger->log("Algoritmo de cifrado: $cypher con clave " . $this->key);
	
 		if ($cypher == "blowfish" || 
		    $cypher == "plaintext" ||
		    $cypher == "base64" ||
		     $cypher == "rc2" ) {
			 include_once './lib/'.$cypher.'.inc.php';
			 // Instancia
		        $this->cifrador = new EncryptionAlgorithm();
			 $this->setKey($this->key);
		} else {
			 include_once './lib/plaintext.inc.php';
			 // Instancia
		        $this->cifrador = new EncryptionAlgorithm();
			 $this->setKey($this->key);
		}
	
	}


	/**
	* setKey
	* establece la clave de cifrado
	*/
	function setKey ($newkey) {
		$this->cifrador->setKey($newkey);
		$this->key = $newkey;
	}



	/**
	* crypt
	* cifra
	*/
	function encrypt ($text_to_crypt) {
		return $this->cifrador->encrypt($text_to_crypt);
	}

	/**
	* decrypt
	* descifra
	*/
	function decrypt ($text_to_decrypt) {
		return $this->cifrador->decrypt($text_to_decrypt);
	}
	
	

}// end class	

?>
