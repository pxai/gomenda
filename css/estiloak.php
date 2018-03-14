<?php 

header('Content-type: text/css'); 
$color = "#00ff00";
?>

/**
* estiloak.php
* Hoja de estilos - Estilo orria
*/

body {
	font-family: Arial, Verdana;
	font-size: 10pt;
	margin: 0px 0px 0px 0px;
	background-color: #e6e6e6;
	background-image: url('/irudiak/atzegrisa.gif');
	background-repeat: repeat-x;
}

#edukia {
	margin-left: 10px;
	margin-right: 10px;
/*	position: relative;*/
	max-width: 1200px;
}

#goiburua {
	height: 100px;
	margin-top: 0px;
	margin-bottom: 0px;
	background-color: black;
	color: white;
/*	overflow-x: hidden;
	overflow-y: hidden;*/
}

#menu {
	position: relative;
	margin-left: 350px;
	margin-top: 20px;
	margin-right: 5px;
	margin-bottom: 2px
	padding-left: 0pt;
	padding-right: 0pt;
}

#logo {
	float: left;
}

#goiburumenu {
	text-align: left;
	font-weight: bold;
	margin: 0px 0px 0px 0px;
	list-style: none;
/*	max-width: 420px;*/
}

#goiburumenu li {	
	margin-right: 5px;
	display: inline;
}

#goiburumenu a {
	text-decoration: none;
	border-bottom: 1px dotted white;
	color: white;
}

#goiburumenu a:hover {
	border-bottom: 1px solid white;
}

#goiburua input {
	border: 1px solid black;
	color: gray;
}

#azpig {
	clear: both;
	height: 30px;
	background-color: #8e0002;
	padding: 4px 2px 2px 2px;
}

#azpig2 {
	clear: both;
	height: 20px;
	background-color: #599100;
}

#azpigoiburu {
	margin: 0px 0px 20px 100px;
	position: relative;
/*	overflow-x: hidden;
	overflow-y: hidden;*/
}

#zentrua {

	background-color: white;
	/*position: relative;*/
	border: 1px solid #c6c6c6;
	overflow-x: hidden;
	overflow-y: hidden;
}

#ezkerra {
	float: left;
	width: 12.5em;
}

#gomendioak {
	margin-left: 13em;
	margin: 0px 20px 100px 200px;
	padding-left: 0pt;
	padding-right: 0pt;
}

.gomendio {
	margin: 20px 20px 20px 20px;
}

.termino {
	background-color: gray;
}

#oina {
	clear: both;
	position: relative;
	bottom: 0px;	
	text-align: center;
	font-size: 8pt;
	margin-top: 10px;	
	margin-bottom: 20px;	
	width:100%;
	font-family: verdana;
	color: gray;;
}

.laguntza  {
	font-size: 12pt;
}

fieldset {
	border: 1px solid gray;
}

.formulame {

	margin-left: 10px;
}

.formulame input,textarea {
	border: 1px solid gray;
	font-size: 14pt;
}

.formulame textarea {
	border: 1px solid gray;
	font-size: 12pt;
}

.semaforo {
	float: left;
	margin-right: 5px;
}

.divsem {
	width: 66px;
	height: 66px;
	text-align: center;
	color: white;
	font-weight: bold;
	background-image: url('/irudiak/beltza.png');
	background-repear: no-repeat;
	margin-bottom: 3px;
}

.divsemtx {
	width: 66px;
	text-align: center;
	color: gray;
	font-size: 8pt;
}

.divvotos {
	width: 66px;
	text-align: center;
	padding-left: 2px;
	padding-right: 2px;
}

.divvotos div {
	width: 20px;
	height: 20px;
	margin-right: 2x;
	float:left;
}


.datosentrada {
	/*clear: both;*/
}

.inputerror {
	background-color: yellow;
}

.labelinputerror {
	border: 1px solid red;
}

#divcategorias  {
	font-size: 12pt;
	font-weight: bold;
	text-align: left;
	color: white;
}

#divcategorias ul {
	list-style: none;
	padding: 0px;
	margin: 0px;
}

#divcategorias ul li{
	display: inline;
}

#divcategorias ul li a{
	padding: 2px 4px 2px 4px;
	text-decoration: none;
	color: white;
}

#divcategorias ul li a:hover {
	background-color: lightGray;
	color: #8e0002;
}

#divcategorias ul li a:visited {
	text-decoration: none;
}

/** LATERAL **/
#mejores {
	font-size: 9pt;
}

#mejores div {
	font-size: 12pt;
}

#mejores ul {
	margin: 2px;
	padding:2px;
	list-style: none;
}

#mejores a{
	font-size: 9pt;
	text-decoration: none;
	color: red;
}

#mejores a:hover{
	text-decoration: underline;
}

#mejorverde a {
	color: #00ff00;
}

#mejorrojo a {
	color: #8e0002;
}

#mejornaranja a{
	color: orange;
}

/**USUARIO**/
#datosusuario {
	list-style: none;
	margin: 20px;
	font-size: 12pt;
}

/***** DIVENTRADA *****/
.diventrada {
	margin: 5px 30px 30px 30px;
	padding-left: 10px;
	font-size: 12pt;
}

.diventrada a {
	text-decoration: none;
}

.entrada1 {
	border-bottom: 1px solid #00ff00;
}

.entrada2 {
	border-bottom: 1px solid orange;
}

.entrada3 {
	border-bottom: 1px solid #ff0000;
}

.entrada1 a {
	color: #00ff00;
}

.entrada2 a {
	color: orange;
}

.entrada3 a {
	color: #ff0000;
}

.tituloentrada {
	text-decoration: none;
	font-size: 20pt;
}

.tituloentrada a {
	text-decoration: none;
}

.autorentrada {
	font-size: 10pt;
	color: gray;
	margin-bottom: 5px;
}

.datosentrada {
	font-size: 10pt;
}

.herramientas {
	font-size: 9pt;
	color: gray;
}

.herramientas a {
	text-decoration: underline;
	font-size: 9pt;
	color: gray;
}

/**** DIVCOMENTARIO ******/
.comentario {
	margin: 10px 5px 20px 5px;
}

.datoscomentario {
	font-size: 9pt;
	color: gray;
}
