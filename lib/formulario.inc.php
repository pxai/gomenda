<?php

// incluimos el objeto data
include_once './lib/data.inc.php';
 
class Formulario {
    var $Formulario;  // Array con Nombres de campos
    var $Accion; // Campo action de formlario
    var $Metodo; // metodo de envio post/put
    var $Clase; // Clase CSS que se aplica
    var $Post; // Ultimos valores de POST
    var $Name; // Campo name del formulario
	 var $Errores;
	 var $Datos; // objeto data, para cuando hay que cargar datos de un objeto data.
	 var $ParametrosSelect; // parametros que se pueden pasar para aplicar a la select
	 var $onsubmit; // accion especifica para el momento de hacer submit.
	 var $KEY; // clave de cifrado
	 var $incomplete;
	 var $FORM;
    
    function Formulario($key, $formulario, $metodo="POST" ,$accion ="_myself", $clase = "",$name="",$datos=NULL) {
    	$this->Formulario = $formulario;
    	$this->Metodo = $metodo;
    	$this->Accion = $accion;
	if ($name=="") {
		$far = split("_",$formulario);
		$name = $far[1] . " " . $far[2];
	}
    	$this->Name = $name;
    	$this->Clase = $clase;
    	$this->Datos = ($datos == NULL)?new Data():$datos;
    	$this->ParametrosSelect = NULL;
    	$this->KEY = ($key!="")?$key :"";
    	$this->incomplete = 0;
		// Y el de formularios
		include "./lib/formularios.inc.php";
    	$this->FORM = $formularios[$this->Formulario];
    }
    

	// Funcion que dibuja el formulario
    function generar($botones=1) {
    	// incluimos el conjunto de formularios de la aplicacion
		$cifrador = new Crypter($this->KEY);
		
		//		echo "Accion: $this->Accion y Metodo $this->Metodo<br>";
  
		//		echo "Tama&ntilde;o: " . count($this->Formulario) ."<br>";
		if (count($this->FORM) > 0) {
			echo "<fieldset><legend>Formulario</legend>\n";
			echo "<form name='".$this->Name."' method='$this->Metodo' action='".$cifrador->encrypt($this->Accion)."' ". $this->onsubmit ." class='formulame'><br />\n";

			foreach ($this->FORM as $nombre => $valores) {
				echo $this->generaCampo($nombre, $valores);
			}

			if ($botones==1) {
					echo "<br /><input type='submit' name='enviar' value='enviar'><br />\n";
			}

			echo (!$this->incomplete)?"</form>\n</fieldset>\n":"";
			
		} //if

	}
	
	// Funcion que valida el formulario
	// importantisima y fundamental
    function validar() {
    	// incluimos el conjunto de formularios de la aplicacion
    	include "./lib/formularios.inc.php";
		$cifrador = new Crypter($this->KEY);
		
		// Incluimos el log para depurar
		require_once './lib/log.inc.php';
		$logger = new Logger();

    	// inicializamos la variable de errores
    	$this->Errores = array();
    	$es_valido = true;
		$nombre = "";
		
		// Establecemos el locale:
		setlocale(LC_ALL,"es_ES.ISO-8859-1");
		
		// guardamos los valores de POST para uso futuro
		$this->Post = $_POST;
		
    	$FORMVALID = $formularios[$this->Formulario."_valid"];
		//		echo "Accion: $this->Accion y Metodo $this->Metodo<br>";
		//		echo "Tama&ntilde;o: " . count($this->Formulario) ."<br>";
		if (count($FORMVALID) > 0) {
				$logger->debug("Array de validacion encontrado");

			// Recorremos las variables y vamos comprobando campos
			foreach ($_POST as $nom => $valor) {
			
					// Antes que nada desciframos el nombre
					$nombre = $cifrador->decrypt($nom);

				$logger->debug("<hr>Comprobando: " .$nom. "(". $nombre ."): " . $valor ."<br>");
					
					// Si el campo no esta en el array de validacion No se comprueba
					if (isset($FORMVALID[$nombre])) {
						$valores = $FORMVALID[$nombre];
				$logger->debug("Requerido: " .$valores["req"]. " - ");
				$logger->debug("Con expresion " .$valores["regexp"]. "<br>");
					} else continue;
					
					$this->Errores[$nombre] = "";


				// Comprobacion de campo requerido
				if ($valores["req"] == 1 && ($valor == "")) {
					$this->Errores[$nombre] .= "Esta campo es requerido";
					$es_valido = false;
					continue;
				} 
				
				$logger->debug("Campo:".$nombre." Valor:".$valor."<br>El tamaño de campo: ".strlen($valor)." tiene tam(".$valores["size"].")<br>");
				//echo "Campo:".$nombre." Valor:".$valor."<br>El tamaÃÂÃÂ±o de campo: ".strlen($valor)." tiene tam(".$valores["size"].")<br>";

				// Comprobacion de tamaño de campo
				if (($valores["req"] == 1) && (strlen($valor) > $valores["size"])) {
					$this->Errores[$nombre] .= "Valor:".$_POST[$nom]."<br>El tamaño de campo: ".count($_POST[$nom])." excede del permitido(".$valores["size"].")";
					$es_valido = false;
					continue;
				}

				// Comprobacion con expresion regular
				if ($valor != "" && !preg_match($valores["regexp"],$_POST[$nom])) {
					$this->Errores[$nombre] .=  $valores["msg"];
					$logger->debug("Regexp " .$valor. "<br>");
					$es_valido = false;

				} 
				
				// Por ultimo, lo pasamos por la piedra con HTMLESPECIALCHARS
				// Para desarmar cualquier codigo malicioso
				$_POST[$nom] = htmlspecialchars($_POST[$nom]);

			} // foreach


		}//if

		return $es_valido;
		
	}

	// Funcion que en caso de error redibuja el formulario
	// cambiando el fondo
    function regenerar($botones=1) {
    	// incluimos el conjunto de formularios de la aplicacion
    	include "./lib/formularios.inc.php";
		$cifrador = new Crypter($this->KEY);
		
		$clase = "";
    	$FORM = $formularios[$this->Formulario];
		//		echo "Accion: $this->Accion y Metodo $this->Metodo<br>";
  
		//		echo "Tama&ntilde;o: " . count($this->Formulario) ."<br>";
		if (count($FORM) > 0) {
			echo "<fieldset><legend>Formulario</legend>\n";
			echo "<form name='".$this->Name."' method='$this->Metodo' action='".$cifrador->encrypt($this->Accion)."' ". $this->onsubmit ." class='formulame'><br />\n";
		

			foreach ($FORM as $nombre => $valores) {

				// En caso de estar metido en la matriz de erorres
				// pintamos el fondo de amarillo
				$clase = ($this->Errores[$nombre] == "")?"":"inputerror";
				echo $this->regeneraCampoErrores($nombre, $valores, $clase);

			}

			if ($botones==1) {
					echo "<br /><input type='submit' name='enviar' value='enviar'><br />\n";
			}

			echo (!$this->incomplete)?"</form>\n":"";
			echo "</fieldset>\n";
	
		}//if
		
	}

	/**
	* Esta funcion carga una lista select a partir 
	* de una consulta SQL
	*/
	function cargaLista ($consulta,$parametros=NULL,$nombre, $valor_seleccionado,$multiple=0) {
		// Conexion, seleccion de base de datos
		include_once './lib/dao.inc.php';
		$acceso = new Dao();
		
		// Los datos de consulta vienen separados por ":"
		// los recuperamos: [0]-> consulta, [1]-> campo_value, [2]->texto
		$valores_lista = split(":",$consulta);
				
		// Realizar la insercion SQL
		$datos = $acceso->getData($valores_lista[0], $parametros);
		// cerramos la conexion
		$acceso->close();
		
		// recuperamos el valor seleccionado
		//	$valor_seleccionado = $this->Post[$valores_lista[1]];
   	//echo "A ver: " .$valor_seleccionado. " par1: " .$valores_lista[1]. " y par2:" . $valores_lista[2] ;

   		//return $datos;
			return $datos->data2Select($valores_lista[1],$valores_lista[2],$nombre, $valor_seleccionado,$multiple);
	}


	/**
	* Esta funcion carga una lista select a partir 
	* de una consulta SQL, pero al ser multiple hace mÃÂÃÂ¡s cosas
	*/
	function cargaListaMultiple ($consulta, $consulta_mul ,$parametros=NULL,$nombre, $valor_seleccionado,$multiple=0) {
		// Conexion, seleccion de base de datos
		include_once './lib/dao.inc.php';
		$acceso = new Dao();
		
		$resultado = array();
		$html = "";		

		// Los datos de consulta vienen separados por ":"
		// los recuperamos: [0]-> consulta, [1]-> parametro, [2]->campo a cargar
		$valores_lista = split(":",$consulta_mul);
				
		// Realizar la seleccion
		$datos_mul = $acceso->getData($valores_lista[0], array($this->Datos->getValue($valores_lista[1])));
		
		while ($datos_mul->hasMoreElements()) {
			array_push($resultado, $datos_mul->getValue($valores_lista[2]) );
			$datos_mul->next();
		}

		// Recuperamos datos de la lista		
		// los recuperamos: [0]-> consulta, [1]-> campo_value, [2]->texto
		$valores_lista = split(":",$consulta);

		// Realizar la Consulta SQL
		$datos = $acceso->getData($valores_lista[0], $parametros);

		// cerramos la conexion
		$acceso->close();

		while ($datos->hasMoreElements()) {
			$selected = "";
					
			$valor = $datos->getValue($valores_lista[1]);
			$texto = $datos->getValue($valores_lista[2]);
			
			// Si el valor esta en
			if ($valor !="" && in_array($valor, $resultado)) {
				$selected = "selected";
			}
			
			$html .= "<option value='". $valor ."' ".$selected .">". $texto ."</option>\n";
			
			$datos->next();
		}

		return $html;
	}
	
	
	/**
	* funcion que genera un campo segun el tipo
	*/
	function generaCampo ($nombre, $valores) {
		// Aqui guardamos el resultado en formato HTML
		$resultado = "";
		$cifrador = new Crypter($this->KEY);
		$valor_final = ($this->Datos->getValue($nombre) != "")?$this->Datos->getValue($nombre):$valores['value'];
		$valores2; // variable para listas dobles

		//echo "Valor final de ".$nombre." :".$valor_final ."<br>";
		// abrimos la fila, pero solo en caso de que no sea campo oculto

		// Tipos: 0:text, 1:textarea, 2:select, 3:hidden,4:multiple, 5:mutiple doble
		//        6: insercion de fecha, 7: insercion de fecha y hora, 8: multiple precargada
		switch ($valores['type']) {
 	    case 0:
						$resultado .= "\n<label>".$valores['label']."<br />\n";
						$resultado .=  "<input type='text' name='".$cifrador->encrypt($nombre)."' ";
						$resultado .=  " value='". $valor_final ."' size='".$valores['size']."' onFocus='conFoco(this)' onBlur='sinFoco(this)' />\n";
						$resultado .=  "</label><br />";
						break;
 	    case 1:
						$resultado .= "\n<label>".$valores['label']."<br />\n";
						$resultado .=  "<textarea name='".$cifrador->encrypt($nombre)."' cols='40' onFocus='conFoco(this)' onBlur='sinFoco(this)'>";
						$resultado .=  trim($valor_final) . "</textarea><br />\n";
						$resultado .=  "</label><br />";
						break;
 	    case 2:		
						$resultado .= "\n<label>".$valores['label']."<br />\n";
						$resultado .= $this->cargaSelect($valores,$cifrador->encrypt($nombre),$valor_final)."\n";
						$resultado .=  "</label><br />";
						break;
 	    case 3:
						$resultado .=  "<input type='hidden' name='".$cifrador->encrypt($nombre)."' ";
						$resultado .=  " value='". $valor_final ."'>\n";
						break;
 	    case 4:
						$resultado .= "\n<label>".$valores['label']."<br />\n";
						$resultado .= $this->cargaSelect($valores,$cifrador->encrypt($nombre),$_POST[$cifrador->encrypt($nombre)],$valores['size'])."\n";
						$resultado .=  "</label><br />";
						break;
 	    case 5:
 	    			 	$valores2 = $valores;
 	    				$valores2['value'] = $valores['value2'];
						$resultado .= "\n<table><tr>\n";
						$resultado .= "<td valign='top'>".$valores['label']."</td>\n";
 	    				$resultado .= "<td>".$this->cargaSelect($valores2,$cifrador->encrypt($valores['label2']),$_POST[$cifrador->encrypt($nombre)],$valores['size'])."</td>";
						$resultado .= "<td valign='middle'><input type='button' name='b1' value='&lt;&lt;' onclick='add()'><br>";
						$resultado .= "<br><input type='button' name='b1' value='&gt;&gt;' onclick='del()' /><br />\n";
 	    				$resultado .= "<td>".$this->cargaSelect($valores,$cifrador->encrypt($nombre),$_POST[$cifrador->encrypt($nombre)],$valores['size'])."</td>";
						$resultado .= "<td>".$this->Errores[$nombre]."</td></tr></table>";
						break;
 	    case 6:
 	    				// Si esta vacio le metemos la fecha de hoy por defecto.
 	 					$fechaactual = getdate();
 	 					$valor_final = ($valor_final !="")?$valor_final:$fechaactual['year']."-".$fechaactual['mon']."-".$fechaactual['mday'];
						$resultado .= "\n<label>".$valores['label']."<br />\n";
						$resultado .=  "<input type='text' id='".$cifrador->encrypt($nombre)."' name='".$cifrador->encrypt($nombre)."' ";
						$resultado .=  " value='". $valor_final ."' size='".$valores['size']."' readonly='yes' />\n";
						$resultado .=  "<a href=\"javascript:seleccionaFecha('/?".$cifrador->encrypt("calendar&retorno=".$nombre)."','".$cifrador->encrypt($nombre)."')\"><img src='images/calendario.gif' title='Selecciona fecha' border='0' align='center' /></a>";
						$resultado .=  "</label><br />";
						break;
	  	 case 7:
 	    				// Si esta vacio le metemos la fecha de hoy por defecto.
 	 					$fechaactual = getdate();
 	 					$valor_final = ($valor_final !="")?$valor_final:$fechaactual['year']."-".$fechaactual['mon']."-".$fechaactual['mday']." ".$fechaactual['hours'].":".$fechaactual['minutes'].":".$fechaactual['seconds'];
						$resultado .= "\n<label>".$valores['label']."<br />\n";
						$resultado .=  "<input type='text' id='".$cifrador->encrypt($nombre)."' name='".$cifrador->encrypt($nombre)."' ";
						$resultado .=  " value='". $valor_final ."' size='".$valores['size']."' readonly />\n";
						$resultado .=  "<a href=\"javascript:seleccionaFecha('/?".$cifrador->encrypt("calendar&conhora=1&retorno=".$nombre)."','".$cifrador->encrypt($nombre)."')\"><img src='images/calendario.gif' title='Selecciona fecha' border='0' align='center'></a>";
						$resultado .=  "</label><br />";
						break;
			case 8:
						$resultado .= "\n<label>".$valores['label']."<br />\n";
						$resultado .= $this->cargaSelectMultiple($valores,$cifrador->encrypt($nombre),$_POST[$cifrador->encrypt($nombre)],$valores['size'])."<br />\n";
						$resultado .=  "</label><br />";
						break;
	 	    case 9:
						$resultado .= "\n<label>".$valores['label']."<br />\n";
						$resultado .=  "<input type='password' name='".$cifrador->encrypt($nombre)."' ";
						$resultado .=  " value='". $valor_final ."' size='".$valores['size']."' onFocus='conFoco(this)' onBlur='sinFoco(this)' /><br />\n";
						$resultado .=  "</label><br />";
						break;
		}	

		
		return $resultado;
	}


	/**
	* funcion que genera un campo segun el tipo
	*/
	function regeneraCampoErrores ($nombre, $valores, $clase) {
			// Incluimos el log para depurar
		//require_once '../li./libinc.php';
		//$logger = new Logger();

		
		// Aqui guardamos el resultado en formato HTML
		$resultado = "";
		$cifrador = new Crypter($this->KEY);
		$valores2; // variable para listas dobles

		$valor_final = $_POST[$cifrador->encrypt($nombre)];

		// abrimos la fila, pero solo en caso de que no sea campo oculto
		//$logger->debug("Regenerando Campo:".$nombre." Valor:".$valores['value']."<br>La clase: ".$valores['type'] ." <br>");
	
		// Tipos: 0:text, 1:textarea, 2:select, 3:hidden
		switch ($valores['type']) {
 	    case 0:
						$resultado .= "\n<label  class='label".$clase."'>".$valores['label']."<br />\n";
						$resultado .=  "<input type='text' name='".$cifrador->encrypt($nombre)."' ";
						$resultado .= " value='".$_POST[$cifrador->encrypt($nombre)]."' size='".$valores['size']."' class='".$clase."' onFocus='conFoco(this)' onBlur='sinFoco(this)'/>\n";
						$resultado .= $this->Errores[$nombre]."</label><br />\n";
						break;
 	    case 1:
						$resultado .= "\n<label  class='label".$clase."'>".$valores['label']."<br />\n";
						$resultado .=  "<textarea name='".$cifrador->encrypt($nombre)."' cols='40' onFocus='conFoco(this)' onBlur='sinFoco(this)'>";
						$resultado .=  trim($_POST[$cifrador->encrypt($nombre)]). "</textarea>\n";
						$resultado .= $this->Errores[$nombre]."</label><br />\n";
						break;
 	    case 2:
						$resultado .= "\n<label  class='label".$clase."'>".$valores['label']."<br />\n";
 	    				//$resultado .= "<td>".$this->cargaSelect($valores,$cifrador->encrypt($nombre),$_POST[$cifrador->encrypt($nombre)])."</td>";
 	    				$resultado .= $this->cargaSelect($valores,$cifrador->encrypt($nombre),$valor_final)."<br />\n";
						$resultado .= $this->Errores[$nombre]."</label><br />\n";
						break;
 	    case 3:
						$resultado .=  "<input type='hidden' name='".$cifrador->encrypt($nombre)."' ";
						$resultado .=  " value='". $_PnOST[$cifrador->encrypt($nombre)] ."'>\n";
						break;
 	    case 4:
						$resultado .= "\n<label  class='label".$clase."'>".$valores['label']."<br />\n";
						$resultado .= $this->cargaSelect($valores,$cifrador->encrypt($nombre),$_POST[$cifrador->encrypt($nombre)],$valores['size'])."\n";
						$resultado .= $this->Errores[$nombre]."</label><br />\n";
						break;
 	    case 5:
 	    			 	$valores2 = $valores;
 	    				$valores2['value'] = $valores['value2'];
						$resultado .= "\n<label  class='label".$clase."'>".$valores['label']."<br />\n";
						$resultado .= "\n<table><tr>\n";
 	    				$resultado .= "<td>".$this->cargaSelect($valores2,$cifrador->encrypt($valores['label2']),$_POST[$cifrador->encrypt($nombre)],$valores['size'])."</td>";
						$resultado .= "<td valign='middle'><input type='button' name='b1' value='&lt;&lt;' onclick='add()'><br>";
						$resultado .= "<br><input type='button' name='b1' value='&gt;&gt;' onclick='del()'></td>\n";
 	    				$resultado .= "<td>".$this->cargaSelect($valores,$cifrador->encrypt($nombre),$_POST[$cifrador->encrypt($nombre)],$valores['size'])."</td>";
						$resultado .= "<td>".$this->Errores[$nombre]."</td></tr></table></label><br />\n";
						break;
 	    case 6:
						$resultado .= "\n<label  class='label".$clase."'>".$valores['label']."<br />\n";
						$resultado .=  "<input type='text' id='".$cifrador->encrypt($nombre)."' name='".$cifrador->encrypt($nombre)."' ";
						$resultado .=  " value='". $valor_final ."' size='".$valores['size']."' readonly>\n";
						$resultado .=  "<a href=\"javascript:seleccionaFecha('/?".$cifrador->encrypt("calendar&retorno=".$nombre)."','".$cifrador->encrypt($nombre)."')\"><img src='images/calendario.gif' title='Selecciona fecha' border='0' align='center'></a>".$this->Errores[$nombre]."</label><br />\n";
						break;
	  	 case 7:
 	    				// Si esta vacio le metemos la fecha de hoy por defecto.
 	 					$fechaactual = getdate();
 	 					$valor_final = ($valor_final !="")?$valor_final:$fechaactual['year']."-".$fechaactual['mon']."-".$fechaactual['mday']." ".$fechaactual['hours'].":".$fechaactual['minutes'].":".$fechaactual['seconds'];
						$resultado .= "\n<label  class='label".$clase."'>".$valores['label']."<br />\n";
						$resultado .=  "<input type='text' id='".$cifrador->encrypt($nombre)."' name='".$cifrador->encrypt($nombre)."' ";
						$resultado .=  " value='". $valor_final ."' size='".$valores['size']."' readonly />\n";
						$resultado .=  "<a href=\"javascript:seleccionaFecha('/?".$cifrador->encrypt("calendar&conhora=1&retorno=".$nombre)."','".$cifrador->encrypt($nombre)."')\"><img src='images/calendario.gif' title='Selecciona fecha' border='0' align='center'></a></label><br />\n";
						break;
 	    case 8:
						$resultado .= "\n<label  class='label".$clase."'>".$valores['label']."<br />\n";
						$resultado .= $this->cargaSelectMultiple($valores,$cifrador->encrypt($nombre),$_POST[$cifrador->encrypt($nombre)],$valores['size'])."<br />\n";
						$resultado .= "<td>&nbsp;".$this->Errores[$nombre]."</label><br />\n";
						break;
	 	    case 9:
						$resultado .= "\n<label  class='label".$clase."'>".$valores['label']."<br />\n";
						$resultado .=  "<input type='password' name='".$cifrador->encrypt($nombre)."' ";
						$resultado .=  " value='". $valor_final ."' size='".$valores['size']."' onFocus='conFoco(this)' onBlur='sinFoco(this)' />\n";
						$resultado .=  "</label><br />\n";
						break;

		}	

		
		return $resultado;
	}

	/**
	* cargaSelect
	* genera una select de dos formas: valores estaticos
	* o partir de una sentencia SQL
	*/
	function cargaSelect ($obselect, $nombre, $valor_final="", $multiple=0) {
		$resultado = "";
		$selected = "";
		$esmultiple = ($multiple==0)?"":"multiple size='".$multiple."'";
		// si la lista es multiple le metemos el []
		$nombre = ($esmultiple!="")?$nombre."[]":$nombre;
		
		// si es una select tipo SQL
		if (ereg("^sql_",$obselect['value']) ) {
				$resultado .= $this->cargaLista($obselect['value'], $this->ParametrosSelect, $nombre, $valor_final, $multiple);

		// si no, cargamos la lista con el array
		} else {
				$resultado .= "\n<select  id='". $nombre ."' name='". $nombre ."' ". $esmultiple. "><option></option>";				
				foreach ($obselect['value'] as $valor => $texto) {
					$selected = "";
					if ($valor_final !="" && $valor == $valor_final) {
						$selected = "selected";
					}
					$resultado .= "<option value='". $valor ."' ".$selected .">". $texto ."</option>\n";
				}

			// cerramos la lista		
			$resultado .= "\n</select>";

		}


		return $resultado;
	}
	
	/**
	* cargaSelectMultiple
	* genera una select de dos formas: valores estaticos
	* o partir de una sentencia SQL
	*/
	function cargaSelectMultiple ($obselect, $nombre, $valor_final="", $multiple) {
		$resultado = "";
		$resultado2 = "";
		$selected = "";
		$esmultiple = "multiple size='".$multiple."'";
		// si la lista es multiple le metemos el []
		$nombre = $nombre."[]";
		
		$resultado .= "\n<select  id='". $nombre ."' name='". $nombre ."' ". $esmultiple. ">";				

		// si es una select tipo SQL
		if (ereg("^sql_",$obselect['value']) ) {
				$resultado .= $this->cargaListaMultiple($obselect['value'], $obselect['selected'], $this->ParametrosSelect,$nombre, $valor_final, $multiple);
	
		// si no, cargamos la lista con el array
		} else {
				foreach ($obselect['value'] as $valor => $texto) {
					$selected = "";
					
					// Si el valor esta en
					if ($valor_final !="" && in_array($valor, $resultado2)) {
						$selected = "selected";
					}
					$resultado .= "<option value='". $valor ."' ".$selected .">". $texto ."</option>\n";
				}

		}

		// cerramos la lista		
		$resultado .= "\n</select>";

		return $resultado;
	}


}//class


?>