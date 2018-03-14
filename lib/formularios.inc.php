<?php
/**
*
* $Id$
* phpframework - v1.0 - http://www.cuatrovientos.org
* Pello Xabier Altadill Izura - Instituto Cuatrovientos 
*
* Aplicacion: Intranet Cuatrovientos
* Formularios de la aplicacion
**
*/

/**
* Tipos: 0:text, 1:textarea, 2:select, 3:hidden, 4:lista multiple
*/
// Formulario de alta de usuario
$formularios['form_alta_usuario'] =  array( "login" => array("label" => "Login", "type" => 0, "value" => "", size => 40), 
							"email" => array("label" => "Email", "type" => 0, "value" => "", size => 60));
$formularios['form_alta_usuario_valid'] =  array("login" => array("req" => 1, "regexp" => "/^[\-\_\.a-zA-Z0-9\s]+$/", "size" => 40, "msg" => "Este campo no cumple condiciones"), 
								"email" => array("req" => 1, "regexp" => "/^[\-\_\.a-zA-Z0-9]+\@[\-\_\.a-zA-Z0-9]+\.[a-z]{2,4}$/", "size" => 50, "msg" => "El campo email no cumple condiciones." ));

$formularios['form_modificar_usuario'] =  array( "password" => array("label" => "Password", "type" => 9, "value" => "", size => 20), 
							"password2" => array("label" => "Repetir password", "type" => 9, "value" => "", size => 20), 
							"url" => array("label" => "Url", "type" => 0, "value" => "", size => 80),
							"email" => array("label" => "Email", "type" => 0, "value" => "", size => 60));
$formularios['form_modificar_usuario_valid'] =  array("password" => array("req" => 1, "regexp" => "/^[\-\_\.\,a-zA-Z0-9]{5,15}$/", "size" => 40, "msg" => "Este campo no cumple condiciones"), 
								"password2" => array("req" => 1, "regexp" => "/^[\-\_\.\,a-zA-Z0-9]{5,15}$/", "size" => 40, "msg" => "Este campo no cumple condiciones"),
								"url" => array("req" => 1, "regexp" => "#^http(s)?://[\-\.a-zA-Z0-9]+\.[a-z]{2,4}[/\-\.a-zA-Z0-9]*#", "size" => 50, "msg" => "El campo email no cumple condiciones." ),
								"email" => array("req" => 1, "regexp" => "/^[\-\_\.a-zA-Z0-9]+\@[\-\_\.a-zA-Z0-9]+\.[a-z]{2,4}$/", "size" => 50, "msg" => "El campo email no cumple condiciones." ));

$formularios['form_recordar_usuario'] =  array("email" => array("label" => "Email", "type" => 0, "value" => "", size => 60));

$formularios['form_recordar_usuario_valid'] =  array("email" => array("req" => 1, "regexp" => "/^[\-\_\.a-zA-Z0-9]+\@[\-\_\.a-zA-Z0-9]+\.[a-z]{2,4}$/", "size" => 50, "msg" => "El campo email no cumple condiciones." ));

// Formulario de login
$formularios['form_login'] =  array( "login" => array("label" => "Login", "type" => 0, "value" => "", size => 40), 
							"password" => array("label" => "Password", "type" => 9, "value" => "", size => 15));
$formularios['form_login_valid'] =  array("login" => array("req" => 1, "regexp" => "/^[\-\_\.\,a-zA-Z0-9\s]+$/", "size" => 40, "msg" => "Este campo no cumple condiciones"), 
							"password" => array("req" => 1, "regexp" => "/^[\-\_\.\,a-zA-Z0-9]{5,15}$/", "size" => 15, "msg" => "El campo no cumple condiciones." ));

// Formulario Ciclo
$formularios['form_alta_comentario'] =  array( "idcomentario" => array("label" => "idcomentario", "type" => 3, "value" => "0", size => 12), 
															"identrada" => array("label" => "identrada", "type" => 3, "value" => "", size => 20),
															"texto" => array("label" => "Texto", "type" => 1, "value" => "", size => 100) );
$formularios['form_alta_comentario_valid'] =  array("idcomentario" => array("req" => 1, "regexp" => "/^[0-9]+$/", "size" => 20, "msg" => "Este campo no cumple condiciones"),
														"identrada" => array("req" => 1, "regexp" => "/^[0-9]+$/", "size" => 20, "msg" => "Este campo no cumple condiciones" ),
														"texto" => array("req" => 1, "regexp" => "/^[\w\W]+$/", "size" => 1000, "msg" => "Este campo no cumple condiciones" ));

// Formulario Ciclo
$formularios['form_alta_entrada'] =  array( "idcategoria" => array("label" => "Categoría", "type" => 2, "value" => "sql_carga_categorias:idcategoria:nombre", size => 12), 
															"titulo" => array("label" => "Título", "type" => 0, "value" => "", size => 60),
															"texto" => array("label" => "Texto", "type" => 1, "value" => "", size => 100) ,
															"tags" => array("label" => "tags", "type" => 0, "value" => "", size => 40));
$formularios['form_alta_entrada_valid'] =  array("idcategoria" => array("req" => 1, "regexp" => "/^[0-9]+$/", "size" => 20, "msg" => "Este campo no cumple condiciones"),
														"titulo" => array("req" => 1, "regexp" => "/^[\w\W]+$/", "size" => 60, "msg" => "Este campo no cumple condiciones" ),
														"texto" => array("req" => 1, "regexp" => "/^[\w\W]+$/", "size" => 5000, "msg" => "Este campo no cumple condiciones" ),
														"tags" => array("req" => 1, "regexp" => "/^[áéíóúñÑüÜa-zA-Z0-9\-\s]+(\,[áéíóúÁÉÍÓÚñÑüÜa-zA-Z0-9\-\s]+)*$/", "size" => 100, "msg" => "Este campo no cumple condiciones" ),
														"idsemaforo" => array("req" => 1, "regexp" => "/^[0-9]{1}$/", "size" => 100, "msg" => "Este campo no cumple condiciones" ));

?>
