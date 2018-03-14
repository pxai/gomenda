<?php
/**
* $Id: calendar.inc.php 128 2006-05-23 16:29:43Z pello $
* phpframework - v1.0 -  http://www.cuatrovientos.org
* Pello Xabier Altadill Izura - Instituto Cuatrovientos 
* calendar.inc.php
* Clase para generar calendarios, generica.
**/



/**
* Definicion de clase calendario.
*/
class Calendar  {
	
	// Nombre de calendario
	var $nombre;
	var $CSSgeneral;
	var $CSSfestivo;
	var $CSSlectivo;
	var $CSSnolectivo;
	var $LINKmod;
	var $LINK;
	var $KEY;
	var $semanterior;
	var $semsiguiente;	

	/**
	* Calendar
	* constructor
	*/
	function Calendar ($key, $link="",$linkmod="",$cssgeneral="",$cssfestivo="", $csslectivo="", $cssnolectivo="") {
		$this->LINK = $link;
		$this->LINKmod = $linkmod;
		$this->CSSgeneral = $cssgeneral;
		$this->CSSfestivo = $cssfestivo;
		$this->CSSlectivo = $csslectivo;
		$this->CSSnolectivo = $cssnolectivo;
		$this->KEY = $key;
	}
	
	/**
	* render
	* Funcion que a partir de un aÃÂ±o escolar genera un calendario HTML
	*/
	function render ($ano) {
		$mes = 1;
		$html = "<!-- Calendario generado por phpframework - www.cuatrovientos.org -->\n";
		$html .= "<table><tr><th colspan='3' align='center'>".$ano."</th></tr>\n";
	
		// Creamos una tabla 3x4
		for ($i=0;$i<4;$i++) {
			$html .= "<tr>\n";
			
			for ($j=0;$j<3;$j++) {
				$html .= "<td>" .$this->renderMes($ano, $mes) . "</td>\n";
				$mes++;
			}
			
			$html .= "</tr>\n";
			
		}
		$html .= "</table>\n";
		return $html;
	}

 
	/**
	* generaMes
	* Funcion que genera un array con los datos de un mes
	* a partir del mes y el aÃÂ±o.
	*/
	function generaMes ($ano, $mes, $conhora=0) {
		$MES = array(42);
		$MES = array_fill(0,42,"<td>&nbsp;</td>");
		$indice = 0;
		$dias = 1;
		$jsopcional = "";
		$tipo = "tipodia2"; // Clase css
		$total = $this->numeroDias($ano, $mes);
		
		// calculamos cual es el primer dia del mes
		$indice = $this->inicioMes($ano, $mes);
								
		$indice--;
		$total++;
		
		// En caso de pedir la hora, incluimos un js opcional
		if ($conhora) {
			$jsopcional = ",document.getElementById(\"hora\").selectedIndex,document.getElementById(\"minuto\").selectedIndex";
			$jsfun = "Hora";
		}
		
		// Recorremos el resultado de la consulta
		while ($dias < $total) {
			$MES[$indice] = "<td class='". $tipo. "'><a href='javascript:cargaFecha".$jsfun."(".$dias.",".$mes.",".$ano.$jsopcional.")'>" .$dias++."</a></td>";
			$indice++;
		}
		

		return $MES;
	}

	/**
	* renderMes
	* Funcion que a partir de un mes y un aÃÂ±o renderiza un calendario mensual
	* si no se pasa nada se toma la fecha actual
	*/
	function renderMes ($ano="", $mes="", $conhora=0) {
		include_once './lib/crypter.inc.php';
		$cifrador = new Crypter($this->KEY);
		
		$semanas = 6;
		$i = 0;
		$cont = 0;
		$hoy = getdate();
		$ano = ($ano!="")?$ano:$hoy['year'];
		$mes = ($mes!="")?$mes:$hoy['mon'];
		$contenido = $this->generaMes($ano, $mes, $conhora);
		
		$anoant = $ano - 1;
		$anosig = $ano + 1;
		
		$html = "";
		
		$html .= "<table><tr><td><a href='/?".$cifrador->encrypt($this->LINK."&ano=".$anoant."&mes=".$mes)."'>".$anoant."</a></td><td>&nbsp;|&nbsp;</td><td><a href='/?".$cifrador->encrypt($this->LINK."&ano=".$anosig."&mes=".$mes)."'>".$anosig."</a></td></tr></table>";
		$html .= "<table class='".$this->CSSgeneral."'><!-- Mes, generado dinamicamente por phpframework - www.cuatrovientos.org -->\n";	
		$html .= "<thead><tr><th><a href='/?".$cifrador->encrypt($this->LINK.$this->anterior($ano,$mes))."'>&lt;&lt;</a></th><th colspan='5' align='center'>". $this->getMes($mes) ." - ". $ano ."</th><th><a href='/?".$cifrador->encrypt($this->LINK.$this->siguiente($ano,$mes))."'>&gt;&gt;</a></th></tr>\n";
		$html .= "<tr><td>L</td><td>M</td><td>X</td><td>J</td><td>V</td><td>S</td><td>D</td></tr></thead><tbody>\n";

		for ($i = 0; $i < $semanas; $i++) {
			$html .= "<tr>";
			
			for ($j = 0; $j < 7; $j++) {
				$html .= $contenido[($cont++)];
			}
			
			$html .= "</tr></thead>\n";
		}
		
		// Si se pide un calendario con seleccion de hora ponemos los desplegables
		if ($conhora) {
			$html .= "<tr><td colspan='7'><table><tr><td>Hora</td><td><select name='hora' id='hora'><option value='0'>0</option><option value='1'>1</option><option value='2'>2</option><option value='3'>3</option><option value='4'>4</option><option value='5'>5</option><option value='6'>6</option><option value='7'>7</option><option value='8'>8</option><option value='9'>9</option><option value='10'>10</option><option value='11'>11</option><option selected value='12'>12</option><option value='13'>13</option><option value='14'>14</option><option value='15'>15</option><option value='16'>16</option><option value='17'>17</option><option value='18'>18</option><option value='19'>19</option><option value='20'>20</option><option value='21'>21</option><option value='22'>22</option><option value='23'>23</option></select></td>\n";
			$html .= "<td>&nbsp;:&nbsp;</td><td><select name='minuto' id='minuto'><option value=''>0</option><option value='1'>1</option><option value='2'>2</option><option value='3'>3</option><option value='4'>4</option><option value='5'>5</option><option value='6'>6</option><option value='7'>7</option><option value='8'>8</option><option value='9'>9</option><option value='10'>10</option><option value='11'>11</option><option value='12'>12</option><option value='13'>13</option><option value='14'>14</option><option value='15'>15</option><option value='16'>16</option><option value='17'>17</option><option value='18'>18</option><option value='19'>19</option><option value='20'>20</option><option value='21'>21</option><option value='22'>22</option><option value='23'>23</option><option value='24'>24</option><option value='25'>25</option><option value='26'>26</option><option value='27'>27</option><option value='28'>28</option><option value='29'>29</option><option value='30'>30</option><option value='31'>31</option><option value='32'>32</option><option value='33'>33</option><option value='34'>34</option><option value='35'>35</option><option value='36'>36</option><option value='37'>37</option><option value='38'>38</option><option value='39'>39</option><option value='40'>40</option><option value='41'>41</option><option value='42'>42</option><option value='43'>43</option><option value='44'>44</option><option value='45'>45</option><option value='46'>46</option><option value='47'>47</option><option value='48'>48</option><option value='49'>49</option><option value='50'>50</option><option value='51'>51</option><option value='52'>52</option><option value='53'>53</option><option value='54'>54</option><option value='55'>55</option><option value='56'>56</option><option value='57'>57</option><option value='58'>58</option><option value='59'>59</option><option value='0'>00</option></select></td></tr></table></td></tr>\n";
		}
		
		$html .= "</tbody></table>\n";	

		return $html;
	}
	
	

	/**
	* generaCalendario
	* Dado un aÃÂ±o genera en SQL todo el calendario
	*/
	function generaCalendario ($ano) {
		$meses = array(9,10,11,12,1,2,3,4,5,6);
		$parametros;
		$festivo = 0;
		$t = 0;
		$curso = $ano."-".($ano+1);
		
		// Generamos el array parametros mes a mes
		for ($i=0; $i < count($meses); $i++) {
		
			// en enero sumamos un ano.
			$ano = ($i==4)?++$ano:$ano;

			for ($j=0; $j< $this->numeroDias($ano,$meses[$i]); $j++) {
				$diasemana = $this->diaDeLaSemana((${j}+1),$meses[$i],$ano);
				$parametros[$t++] = array($curso,$ano,$meses[$i],(${j}+1),$this->getDiaSemana($diasemana),$this->festivo($ano, $meses[$i],(${j}+1)),$diasemana, $ano."-".$meses[$i]."-".(${j}+1));
	
			}//for-j
			
		}//for-i

	

		
	}
	
	
	
	/**
	* numeroDias
	* dado un mes y un aÃÂ±o devuelve el numero de dÃÂ­as
	*/
	function numeroDias ($ano,$mes) {
			$dias = array(31,28,31,30,31,30,31,31,30,31,30,31);
			
			// Si es febrero, cuidadin
			if ($mes == 2) {
				return ((($ano % 4)==0)?29:28);
			} else {
				return $dias[($mes-1)];
			}
	}
	
	/**
	* getMes
	* dado un numero de mes devuelve el nombre
	*/
	function getMes ($num) {
			$meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
			return $meses[$num-1];
	}
	
	/**
	* getDiaSemana
	* dado un numero de dia de la semana nos devuelve el nombre
	*/
	function getDiaSemana ($num) {
			$num = ($num > 0 && $num <8)?$num:1;
			$semana = array("","Lunes","Martes","Miercoles","Jueves","Viernes","Sabado","Domingo");
			return $semana[$num];
	}
	
	/**
	* numeroFilas
	* Segun el numero de dias del mes y del comienzo
	* del primer dia, calcula el total de filas del calendario
	*/
	function numeroFilas ($dias, $inicio) {
		return (6 - (int)((42 - ($dias + $inicio)) / 7) );
	}
	
	/**
	* inicioMes
	* Segun el $mes y el $aÃÂ±o nos dice que dia de la semana cae
	* el primer dia
	*/
	function inicioMes ($ano, $mes) {
		$fecha = mktime(0, 0, 0, $mes, 1, $ano);
		// la funcion devuelve 0 si es domingo, asi que...
		$dia = (strftime("%w",$fecha)=="0")?7:strftime("%w",$fecha);
		return $this->diaDeLaSemana(1, $mes, $ano);
	}
	
	/**
	* diaDeLaSemana
	* Dado un dia de un mes de un aÃÂ±o, nos dice que dia de la semana es.
	*/
	function diaDeLaSemana ($dia, $mes, $ano) {
		$fecha = mktime(0, 0, 0, $mes, $dia, $ano);

		// la funcion devuelve 0 si es domingo, asi que...
		$dia = (strftime("%w",$fecha)=="0")?7:strftime("%w",$fecha);
		return $dia;
	}
	
	/**
	* festivo
	* Devuelve un 1 si es festivo, y 0 en caso contrario
	*/
	function festivo ($ano, $mes, $dia) {
		$fecha = mktime(0, 0, 0, $mes, $dia, $ano);

		// la funcion devuelve 0 si es domingo, asi que...
		$dia = strftime("%w",$fecha);
		
		return (($dia=="0" || $dia=="6")?1:0);
	}
	
	/**
	* curso 
	* Dado un mes y un aÃÂ±o devuelve el curso
	*/
	function curso ($ano, $mes) {
		if ($mes < 9) {
			return ($ano-1)."-".$ano;
		} else {
			return $ano."-".($ano+1);
		}
	}
	
	/**
	* anterior
	* Dado un mes y su aÃÂ±o, devuelve el enlace de mes anterior
	*/
	function anterior ($ano, $mes) {
		if ($mes == 1) {
			return "&ano=" . ($ano-1). "&mes=12";
		} else {
			return "&ano=".$ano. "&mes=". ($mes-1);
		}
	}

	/**
	* siguiente
	* Dado un mes y su aÃÂ±o, devuelve el enlace de mes siguiente
	*/
	function siguiente ($ano, $mes) {
		if ($mes == 12) {
			return "&ano=" . ($ano+1). "&mes=1";
		} else {
			return "&ano=".$ano. "&mes=". ($mes+1);
		}
	}
	
	
	/**
	* semana
	* Dado un dia del aÃÂ±o, devuelve un array
	* con todas las fechas de su semana correspondiente
	*/
	function semana ($dia, $mes, $ano) {
		// Primero sacamos la semana del aÃÂ±o correspondiente
		$diasem = $this->diaDeLaSemana($dia, $mes, $ano);

		// Luego sacamos el primer dia de esa semana		
		$lasemana[0] = date("Y-m-d",mktime(0,0,0,$mes,$dia-($diasem-1),$ano));

		$this->semanterior = mktime(0,0,0,$mes,$dia-($diasem),$ano);

		// Y sacamos todos los dias a partir de ahi.
		for ($i=1;$i<7;$i++) {
			$lasemana[$i] = date("Y-m-d",mktime(0,0,0,$mes,$dia-($diasem - 1) + $i,$ano));
		}

		$this->semsiguiente = mktime(0,0,0,$mes,$dia-($diasem) + 8,$ano);
		
		return $lasemana;
	}
	

}// class

?>