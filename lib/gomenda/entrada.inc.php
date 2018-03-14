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


class Entrada extends Entidad {
	
	// INSERT: instruccion para insertar una nueva entidad
	var $INSERT;

	/**
	* Constructor por defecto de Entrada
	*/
	function Entrada($path) {
		$this->path = $path;
	}


	/**
	* nuevaEntrada
	* Muestra el formulario para guardar una nueva entrada
	*/
	function nuevaEntrada ($quien) {

		$categorias = $this->seleccionar("select_categorias", NULL);

		echo "<fieldset><legend>Nueva recomendación</legend>\n";
		echo "<form name='nuevaEntrada' method='post' action='".$this->path."/?crearentrada&ac=Guardar' class='formulame'>";
		echo "<label>Categoría<br />";
		echo $categorias->data2Select("idcategoria","nombre","idcategoria")."</label><br />";
		?>
		
		<label>Tí­tulo<br /><input type="text" name="titulo" size="40" /></label><br />
		<label>Texto<br /><textarea name="texto" rows="10" cols="60"></textarea></label><br />
		<label>Tags<br /><input type="text" name="tags" size="40" />(separados por comas)</label><br />
		<label>Verde<input type="radio" name="idsemaforo" value="0" /></label>
		<label>Ambar<input type="radio" name="idsemaforo" value="1" /></label>
		<label>Rojo<input type="radio" name="idsemaforo" value="2" /></label><br />
		<input type="submit" name="enviar" value="Enviar" />
		</fieldset>
		
		
		<?php

	
	}	


	/**
	* guardarEntrada
	* Inserta una entrada
	*/
	function guardarEntrada ($quien) {


			if ($_POST['idsemaforo']!=1 && $_POST['idsemaforo']!=2 && $_POST['idsemaforo']!=3) 
			{
				echo "semaforo incorrecto";
				return false;
			}
			
			$tagstmp = strip_tags($_POST["tags"]);
			$titulo = strip_tags($_POST["titulo"]);
			$texto = strip_tags($_POST["texto"],'<b>');

			//(login, titulo, texto, idcategoria, idsemaforo,timestamp)	
			$this->insertarconID("select_max_entrada","insert_entrada",array($quien,$titulo,$texto,$_POST['idcategoria'],$_POST['idsemaforo']));
			$identrada = $this->ultimoID;
			$this->insertar("votar_usuario",array($identrada,$_POST['idsemaforo'],$quien));
			
			
			$tags = split(",",$tagstmp);

			
			foreach ($tags as $t) 
			{	
				echo $t . "<br />";
				$this->insertar("insert_entrada_tag",array($identrada,trim($t)));
			}
			
			return true;
	
	}	


	/**
	* modificarEntrada
	* Modifica una entrada
	*/
	function modificarEntrada () {
		/*
		echo "OK estamos dentro";
		echo "Has metido:  " . $_POST[$this->ncrpt('identrada')];
		echo "<br />Has metido:  " . $_POST[$this->ncrpt('titulo')];
		echo "<br />Has metido:  " . $_POST[$this->ncrpt('texto')];
			*/	
			
		$identrada = $_POST[$this->ncrpt('identrada')];
		$texto = $_POST[$this->ncrpt('texto')];
		$titulo = $_POST[$this->ncrpt('titulo')];
//		$seguridad = $_POST[$this->ncrpt('seguridad')];
//		$seguridadcrypt = $this->dcrpt($_POST[$this->ncrpt('seguridadcrypt')]);
		$tags = $_POST[$this->ncrpt('listatags')];

		/*foreach ($tags as $t) 
		{	
			echo "<br />Tag: ".$t.".";
		}*/
		
		if ($titulo != "" 
			 && $texto !=""
			 && $identrada !=""
			// && $seguridad == $seguridadcrypt
			) 
		{
			$quien = ($quien!="")?$quien:"anonimoso";
	
			$momento = mktime();
	
			$this->modificar("update_entrada",array($titulo, $texto, $identrada));
			$this->modificar("delete_tags_entrada",array($identrada));
	
			
			foreach ($tags as $t) 
			{	
				$this->insertar("insert_entrada_tag",array($identrada,$t));
			}
			
			return $identrada;
		}
		else 
		{
			$error = new Error("entrada","No se cumplen requisitos para comentar.<br>Rellena los campos y mete el c&oacute;digo de seguridad.");
			return 0;
		}
	
	}
	/**
	* eliminarEntrada
	* Inserta una entrada
	*/
	function eliminarEntrada ($id) {
		$this->eliminar("eliminar_entrada", array($id));
		$this->eliminar("eliminar_entrada_tag", array($id));
	}

}// class

?>
