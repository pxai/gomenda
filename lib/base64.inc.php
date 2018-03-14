<?php
/**
* $Id: base64.inc.php 14 2006-03-01 12:32:45Z intranet $
* phpframework - v1.0 -  http://www.cuatrovientos.org
* Pello Xabier Altadill Izura - Instituto Cuatrovientos 
* base64.inc.php
*
* algoritmo de pseudocifrado sin efecto alguno, 
* simplemente codifica en base64 para ofuscar un poco las URL
*/

class EncryptionAlgorithm {

    /* Constructor */
    function EncryptionAlgorithm($params = null)
    {
    }

    /**
     * Set the key to be used for en/decryption
     *
     * @param String $key   The key to use
     */
    function setKey($key)
    {
    }


/**
* encrypt
* Esta funcion encapsula toda la logica de cifrado
*/
function  encrypt($cadena, $new_key = "") {
	return base64_encode($cadena);
}


/**
* decrypt
* Esta funcion encapsula toda la logica de descifrado
*/
function  decrypt ($cadena, $new_key = "") {

	return base64_decode($cadena);

}



}
