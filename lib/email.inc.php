<?php
/**
* $Id$
* phpframework - v1.0 http://www.cuatrovientos.org
* Pello Xabier Altadill Izura - Instituto Cuatrovientos 
* email.inc.php
* funciones de envio de correo
*
*/

class Email {
/**
* Variables
*/	
var $message;
var $subject;
var $from;
var $to;
var $cc;
var $bcc;
var $host;
var $port; 
var $tipo;

/**
* Email
* constructor
*/	
function Email ($from,$to,$subject,$message,$cc="",$bcc="") {
	$this->from = $from;
	$this->to = $to;
	$this->subject = $subject;
	$this->message = $message;
	$this->cc = $cc;
	$this->bcc = $bcc;
}


/**
* enviar
* Envia un correo simple
*/
function enviar () {
	$copia = ($this->cc!="")?'Cc: '. $this->cc . "\r\n":"";
	$copiaoculta = ($this->bcc!="")?'Bcc: '. $this->bcc . "\r\n":"";

	// Establecemos cabeceras...
	$headers = 'From: '. $this->from . "\r\n" .
   $copia .
   $copiaoculta .
   'Reply-To: '. $this->from . "\r\n" .
   'X-Mailer: Intranet Cuatrovientos';

	// Y enviamos
	mail($this->to, $this->subject, $this->message, $headers);
}

/**
* enviarHTML
* Envia un correo simple en formato HTML
*/
function enviarHTML () {
	$copia = ($this->cc!="")?'Cc: '. $this->cc . "\r\n":"";
	$copiaoculta = ($this->bcc!="")?'Bcc: '. $this->bcc . "\r\n":"";

	// Establecemos cabeceras...
	$headers = 'From: '. $this->from . "\r\n" .
   $copia .
   $copiaoculta .
   'Reply-To: '. $this->from . "\r\n" .
   'MIME-Version: 1.0' . "\r\n" .
   'Content-type: text/html; charset=iso-8859-1' . "\r\n" .
   'X-Mailer: Intranet Cuatrovientos';

	// Y enviamos
	mail($this->to, $this->subject, $this->message, $headers);
}

/**
* enviar
* Envia un correo simple
*/
function enviarPDF () {
	$copia = ($this->cc!="")?'Cc: '. $this->cc . "\r\n":"";
	$copiaoculta = ($this->bcc!="")?'Bcc: '. $this->bcc . "\r\n":"";

	// Establecemos cabeceras...
	$headers = 'From: '. $this->from . "\r\n" .
   $copia .
   $copiaoculta .
   'Reply-To: '. $this->from . "\r\n" .
   'X-Mailer: Intranet Cuatrovientos' . "\r\n"  .
   'MIME-Version : 1.0' . "\r\n" .
   'Content-Type : application/octet-stream;name=nombre3.pdf' . "\r\n" .
   'Content-Transfer-Encoding : 8bit';

	$this->message = $this->cargaPDF("/tmp/FOLLETONORMAS.pdf");

	// Y enviamos
	mail($this->to, $this->subject, $this->message, $headers);
}

	/**
	* cargamos el PDF en una variable
	*/
	function cargaPDF($nombre="") {
		$gestor = fopen($nombre, "rb");
		$contenido = fread($gestor, filesize($nombre));
		fclose($gestor);
		
		return $contenido;
	}

}// end class

?>
