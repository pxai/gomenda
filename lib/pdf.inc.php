<?php

/**
* $Id$
* phpframework - v1.0 -  http://www.cuatrovientos.org
* Pello Xabier Altadill Izura - Instituto Cuatrovientos 
* pdf.inc.php
* Clase para generar PDF a partir de la libreria php_pdf
**
*/

require '/usr/share/fpdf/fpdf.php';


class Pdf extends FPDF{

	var $file = "";
	var $ACL;

	function Pdf($File="") {
		$this->file = $File;
		
	}

/*
	
	//Cabecera de pÃÂ¡gina
	function Header() {
    	//Logo
    	$this->Image('/var/www/intranet/htdocs/images/logo.png',10,8,33);

    	//Arial bold 15
    	$this->SetFont('Arial','B',15);

	    //Movernos a la derecha
	    $this->Cell(80);

	    //TÃÂ­tulo
//	    $this->Cell(30,10,'Title',1,0,'C');

	    //Salto de lÃÂ­nea
	    $this->Ln(20);
	}

	//Pie de pÃÂ¡gina
	function Footer()	{
	    //PosiciÃÂ³n: a 1,5 cm del final
   	 $this->SetY(-15);

	    //Arial italic 8
   	 $this->SetFont('Arial','I',8);

  		 //NÃÂºmero de pÃÂ¡gina
//  	  	$this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
	}*/

}

	/**
	* generaPdfHacienda
	* genera el pdf de hacienda con el texto dado
	*/
	function generaPdfHacienda($texto) {


	}



?>