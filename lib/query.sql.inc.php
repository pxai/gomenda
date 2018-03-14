<?php
/**
*
* $Id$
* phpframework - v1.0 - http://www.cuatrovientos.org
* Pello Xabier Altadill Izura - Instituto Cuatrovientos 
* query.sql.inc
* Conjunto de queries actualizables
*
* Join a pelo: select tbl_aula.nombre, tbl_tipo_aula.tipo from tbl_aula,tbl_tipo_aula where tbl_aula.tbl_tipo_aula_id_tipo_aula = tbl_tipo_aula.id_tipo_aula
* Join explicita: select tbl_aula.nombre, tbl_tipo_aula.tipo from tbl_aula JOIN tbl_tipo_aula ON ( tbl_aula.tbl_tipo_aula_id_tipo_aula = tbl_tipo_aula.id_tipo_aula)
*/
$query_sql['begin'] = "BEGIN";
$query_sql['commit'] = "COMMIT";
$query_sql['rollback'] = "ROLLBACK";

$query_sql['select_session'] = "SELECT * FROM tbl_session";
$query_sql['iniciar_session'] = "INSERT INTO tbl_session VALUES ('?','?','now()',null,1,'?','?')";
$query_sql['terminar_session']= "UPDATE tbl_session set activa=0, fin ='now()' WHERE idsession='?' and logincifrado='?'";
$query_sql['comprobar_session'] = "SELECT * FROM tbl_session where idsession='?' and logincifrado='?' and activa=1";
$query_sql['insertar_usuario'] = "insert into usuarios values (NULL,'?',md5('?'),'?',now(),'','','')";
$query_sql['select_usuario'] = "select idusuario,login,email,url,fecha,avatartb,monedas from usuarios where idusuario=?";
$query_sql['select_comentarios_usuario'] = "select * from comentario where idusuario=? order by fecha asc";
$query_sql['select_entradas_usuario'] = "select * from entrada where idusuario=? order by fecha asc";
$query_sql['select_total_votos_usuario'] = "select count(*) as total from voto_entrada where idusuario=?";
$query_sql['update_password'] = "update usuarios set password=md5('?') where email='?'";
$query_sql['update_usuario'] = "update usuarios set password=md5('?'),email='?',url='?' where idusuario=?";
$query_sql['update_avatar_usuario'] = "update usuarios set avatar='?',avatartb='?' where idusuario=?";
$query_sql['update_monedas'] = "update usuarios set monedas=monedas+? where idusuario=?";
$query_sql['select_avatar'] = "select avatar,avatartb from usuarios where idusuario=?";
$query_sql['comprobar_usuario'] = "SELECT * FROM usuarios where login='?' and password=md5('?')";
$query_sql['usuario_duplicado'] = "SELECT * FROM usuarios where login=lcase('?') or email=lcase('?')";
$query_sql['usuario_email'] = "SELECT * FROM usuarios where email=lcase('?')";
$query_sql['select_categorias'] = "SELECT * FROM categoria order by nombre";
$query_sql['sql_carga_categorias'] = "SELECT * FROM categoria order by nombre";
$query_sql['select_funcionalidades'] = "select link, target, tbl_funcionalidad.target,tbl_funcionalidad.nombre, tbl_grupo_funcionalidad.nombre as grupo from tbl_funcionalidad, tbl_grupo_funcionalidad where tbl_grupo_funcionalidad_id_grupo=id_grupo and tbl_funcionalidad.visible=1 and id_grupo in (select tbl_grupo_funcionalidad_id_grupo from tbl_acceso_has_tbl_funcionalidad where tbl_acceso_login='?') order by tbl_grupo_funcionalidad_id_grupo,tbl_funcionalidad.nombre";
$query_sql['votar_usuario'] = "insert into voto_entrada (identrada,voto,idusuario) values (?,?,?)";
$query_sql['votar_usuario_anon'] = "insert into voto_entrada (identrada,voto,userkey) values (?,?,'?')";
$query_sql['comprobar_voto_entrada'] = "SELECT * FROM voto_entrada where identrada=? and (idusuario=? or userkey='?')";
$query_sql['select_votos_entrada'] = "SELECT DISTINCT voto, count(voto) as total FROM voto_entrada WHERE identrada =? GROUP BY voto order by voto";
$query_sql['total_votos_entrada'] = "SELECT count(voto) as total FROM voto_entrada WHERE identrada =?";
$query_sql['comprobar_voto_entrada_anon'] = "SELECT * FROM voto_entrada where identrada=? and key='?'";
//$query_sql['check_acl'] = "select count(idfuncionalidad) as total from tbl_funcionalidad, tbl_usuario_funcionalidad where tbl_usuario_funcionalidad.tbl_grupo_funcionalidad_id_grupo=tbl_funcionalidad.tbl_grupo_funcionalidad_id_grupo and tbl_acceso_has_tbl_funcionalidad.tbl_acceso_login='?' and tbl_funcionalidad.link='?'";
$query_sql['check_acl'] = "SELECT count(tbl_usuario_funcionalidad.idfuncionalidad) as total FROM tbl_usuario_funcionalidad, tbl_funcionalidad WHERE tbl_funcionalidad.idfuncionalidad=tbl_usuario_funcionalidad.idfuncionalidad and tbl_usuario_funcionalidad.login='?' and tbl_funcionalidad.link = '?'";
$query_sql['ultimas_entradas'] = "select entrada.*,usuarios.login,usuarios.avatartb, categoria.nombre as categoria from entrada,usuarios,categoria where entrada.idusuario=usuarios.idusuario and categoria.idcategoria=entrada.idcategoria  order by fecha desc limit ?,?";
$query_sql['ultimas_entradas_tag'] = "select entrada.*,usuarios.login,usuarios.avatartb, categoria.nombre as categoria  from entrada,usuarios,entrada_tag,categoria where entrada.idusuario=usuarios.idusuario and categoria.idcategoria=entrada.idcategoria and tag='?' and entrada.identrada=entrada_tag.identrada order by fecha desc limit ?,?";
$query_sql['total_entradas'] = "select count(*) as total from entrada";
$query_sql['total_entradas_tag'] = "select count(*) as total from entrada, entrada_tag where tag='?' and entrada.identrada=entrada_tag.identrada";
$query_sql['total_comentarios'] = "select count(*) as total from comentario where identrada=?";
$query_sql['ultimas_entradas_busqueda'] = "select entrada.*,usuarios.login,usuarios.avatartb, categoria.nombre as categoria from entrada,usuarios,categoria where entrada.idusuario=usuarios.idusuario and categoria.idcategoria=entrada.idcategoria and (entrada.titulo like '%?%' or entrada.texto like '%?%') order by fecha desc limit ?,?";
$query_sql['total_entradas_busqueda'] = "select count(*) as total from entrada where (entrada.titulo like '%?%' or entrada.texto like '%?%')";
$query_sql['tags_entrada'] = "select entrada_tag.* from entrada_tag where identrada=?";
$query_sql['select_configuracion'] = "select * from configuracion";
$query_sql['select_todos_tags'] ="select tag.* from tag order by nombre";
$query_sql['select_tags'] ="select count(entrada_tag.idtag)as total, tag.nombre, tag.idtag from entrada_tag, tag where tag.idtag=entrada_tag.idtag group by entrada_tag.idtag order by total desc";
$query_sql['select_entrada'] = "select entrada.*,usuarios.login, categoria.nombre as categoria from entrada,usuarios,categoria  where entrada.idusuario=usuarios.idusuario and categoria.idcategoria=entrada.idcategoria and identrada=?";
$query_sql['select_comentarios_entrada'] = "select comentario.*,usuarios.login from comentario,usuarios where usuarios.idusuario=comentario.idusuario and identrada=? order by fecha asc";
$query_sql['insert_comentario'] = "insert into comentario (identrada, idusuario, texto, fecha) values (?,?,'?',now())";
$query_sql['actualiza_lecturas'] = "update entrada set lecturas = lecturas + 1 where identrada=?";
$query_sql['voto_color'] = "update color_votos set votos = votos + 1 where color='?'";
$query_sql['insert_entrada'] = "insert into entrada (idusuario, titulo, texto, idcategoria, semaforo,fecha,identrada) values ('?','?','?',?,?,now(),?)";
$query_sql['select_ultima_entrada'] = "select identrada from entrada where timestamp=?";
$query_sql['select_max_entrada'] = "select max(identrada) as maximo from entrada";
$query_sql['eliminar_entrada'] = "delete from entrada where identrada=?";
$query_sql['eliminar_entrada_tag'] = "delete from entrada_tag where identrada=?";
$query_sql['insert_entrada_tag'] = "insert into entrada_tag (identrada, tag) values (?,'?')";
$query_sql['update_entrada'] = "update entrada set titulo='?',texto='?' where identrada=?";
$query_sql['delete_tags_entrada'] = "delete from entrada_tag where identrada=?";
$query_sql['insertar_captcha'] = "insert into captcha (captcha, valor) values ('?','?')";
$query_sql['seleccionar_captcha'] = "select * from captcha where valor='?'";

?>
