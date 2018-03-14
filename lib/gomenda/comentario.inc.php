<?php
/**
* $Id$
* phpframework - v1.0 -  http://www.cuatrovientos.org
* Pello Xabier Altadill Izura - Instituto Cuatrovientos 
* entrada.inc.php
* Entrada agrupa las funciones para mostrar entradas 
*/

// Conexion, seleccion de base de datos
include_once './lib/gomenda/entidad.inc.php';


class Comentario extends Entidad {
	
	// INSERT: instruccion para insertar una nueva entidad
	var $INSERT;



	/**
	* insertarComentario
	* Inserta un comentario
	*/
	function insertarComentario ($id, $quien) {
		
		if ($_POST[$this->ncrpt('comentario')] !="") 
		{
			$quien = ($quien!="")?$quien:"-1";
			$comentario = strip_tags($_POST[$this->ncrpt('comentario')]);
			$titulo = strip_tags($_POST[$this->ncrpt('titulo')]);
	
			$this->insertar("insert_comentario",array($id,$quien, $comentario));
		}
		else 
		{
			$error = new Error("comentario","No se cumplen requisitos para comentar.<br>Rellena los campos y mete el c&oacute;digo de seguridad.");
		}
	
	}	
	
	/**
	* insertarComentarioAnbon
	* Inserta un comentario
	*/
	function insertarComentarioAnon ($id, $quien) {
	/*
		echo "OK estamos dentro";
		echo "Has metido:  " . $_POST[$this->ncrpt('comentario')];
		echo "<br />Has metido:  " . $_POST[$this->ncrpt('titulo')];*/
		if (!preg_match("/^[a-zA-Z0-9]+$/", $_POST[$this->ncrpt('seguridadcrypt')]))
		{
			exit;
		}
		
		$codigo = $this->seleccionar("seleccionar_captcha",array($_POST[$this->ncrpt('seguridadcrypt')]));
			
		$seguridad = $_POST[$this->ncrpt('seguridad')];
		$seguridadcrypt = $codigo->getValue('captcha');
		
		if ($_POST[$this->ncrpt('comentario')] !=""
			 && $seguridad == $seguridadcrypt
			) 
		{
			$quien = ($quien!="")?$quien:"-1";
			$comentario = strip_tags($_POST[$this->ncrpt('comentario')]);
			$titulo = strip_tags($_POST[$this->ncrpt('titulo')]);
	
			$this->insertar("insert_comentario",array($id,$quien, $comentario));
		}
		else 
		{
			$error = new Error("comentario","No se cumplen requisitos para comentar.<br>Rellena los campos y mete el c&oacute;digo de seguridad.");
		}
	
	}	



}// class

?>
