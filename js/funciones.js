/**
*
* $Id: funciones.js 169 2006-09-13 08:28:48Z pello $
* phpframework - v1.0 - http://www.cuatrovientos.org
* Pello Xabier Altadill Izura - Instituto Cuatrovientos 
* funciones.js
* Conjunto de funciones comunes para la aplicacion
*
*/

function confirmar(url) {
	if (confirm("Estas seguro de lo que vas a hacer, gañan?"))
	{
		document.location.href = url;
	}
}

var actual = 1;

function opinion(voto) {
	var caja = document.getElementById("idsemaforo");
	var texto =  document.getElementById("divtextopinion");

	actual = voto;
	
	switch (voto)
	{
		case 1 : texto.innerHTML="<i>Me gust</i>";break;
		case 2 : texto.innerHTML="<i>Ni fu ni fa</i>";break;
		case 3 : texto.innerHTML="<i>NO me gus</i>";break;
		default: break;
	}


	caja.value = voto;
	
}


// En esta funcion primero controlamos si el elemento es visible
// y lo ponemos en estado contrario
function aparecedesaparece(elemento) {
	
		// Si el elemento lista tiene propiedad visible o vacia, lo quitamos
		if (document.getElementById(elemento).style.visibility == "visible" || document.getElementById(elemento).style.visibility == "") {

			document.getElementById(elemento).style.visibility = "hidden";
			document.getElementById(elemento).style.display = "none";

		} else {

			document.getElementById(elemento).style.visibility = "visible";
			document.getElementById(elemento).style.display = "block";

		}

	}
	

/**
* votar
* envia una votación via AJAX
*/
function votar(voto,id) {
      procesoAJAXVotar("voto",voto,"id",id,"POST","?votar&ac=Votar");
}


 /**
 * procesoAJAXSugerencia :  Ejemplo basico de AJAX (2)
 * procesa una peticion de forma asincrona
 * nombre: nombre de la variable que pasaremos
 * valor: valor, es obvio
 * metodo: metodo a usar
 * url: direccion de destino
 */
 function procesoAJAXVotar (nombrevoto,valorvoto,nombreid,valorid,metodo,url) {
 
 
	 // Creamos el objeto, segun el navegador
	 if (window.XMLHttpRequest) { // Para los mozilla y los basados en gecko
 	   xmlhttprequest = new XMLHttpRequest();
	} else if (window.ActiveXObject) { // Para Mordorsoft Exploiter
	    xmlhttprequest = new ActiveXObject("Microsoft.XMLHTTP");
	} 
	
	// PREPARANDOSE PARA LA RESPUESTA
	// establecemos un handler para cuando llegue la respuesta,
	xmlhttprequest.onreadystatechange = function() { procesaVoto(xmlhttprequest); };
	
	
	// HACIENDO LA PETICION
	// Open(metodo, url, y si queremos la peticion asincrona o no)
	xmlhttprequest.open(metodo, url, true);
	 
	// Preparamos el POST. Hay que establecer esta cabecera
	// para poder enviar variables por post
	xmlhttprequest.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
 
	 // Send es necesario si queremos pasar variables por POST
	// asi que construimos una especie de query string con variables=valores
	 xmlhttprequest.send(nombrevoto+"="+valorvoto+"&"+nombreid+"="+valorid);
	 
 }
 


 /**
 * procesaVoto
 * parametros: el objeto xmlhttprequest
 * Es la funcion handler que procesa el archivo recibido a traves de la peticion.
 */
 function procesaVoto (xhr) {

	var res = "";
	var datos = new Array();
	var sem,sem1, sem2, sem3;

	// primermo comprobamos el estado de la respuesta
	// 0: sin inicializar
	// 1 : cargandose
	// 2 : cargado
	// 3 : interactivo
	// 4 : completa
	 if (xhr.readyState == 4) {
			// A continuacion comprobamos el codigo de respuesta HTTP del servidor
			// en caso de ser correcta seria 200 (OK)
			// Si hacemos una prueba local no es necesario
	 		if (xhr.status == 200) {
	 			//return (xhr.responseText);
				res = xhr.responseText;
				datos = res.split(";");
				
				sem = document.getElementById(datos[0]+"sem");
				sem1 = document.getElementById("1_"+datos[0]+"_li");
				sem2 = document.getElementById("2_"+datos[0]+"_li");
				sem3 = document.getElementById("3_"+datos[0]+"_li");
				
				sem1.innerHTML = datos[2];
				sem2.innerHTML = datos[3];
				sem3.innerHTML = datos[4];
				
				//alert("Total: " + res);
				sem.innerHTML = datos[1];
	 			document.getElementById(datos[0]+"semtx").innerHTML = datos[6] ;
	 	 	}
	  } else {
	    // Todavia no hay respuesta...
	  }
 }