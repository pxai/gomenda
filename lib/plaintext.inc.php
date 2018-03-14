<?php
/**
* $Id$
* phpframework - v1.0 -  http://www.cuatrovientos.org
* Pello Xabier Altadill Izura - Instituto Cuatrovientos 
* plaintext.inc
*
* algoritmo de cifrado sin efecto alguno, para el caso que no se requiera
* ningun cifrado
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
	return $cadena;
}


/**
* decrypt
* Esta funcion encapsula toda la logica de descifrado
*/
function  decrypt ($cadena, $new_key = "") {

	return $cadena;

}



}
