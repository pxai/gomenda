<?php

include_once './lib/gomenda/entrada.inc.php';
include_once './lib/utiles.inc.php';
$entrada = new Entrada($clave);

$ultimas = $entrada->seleccionar("ultimas_entradas",array(0,10));
$util = new Utiles();


echo "<?xml version=\"1.0\" encoding=\"UTF-8\" ?>";

?>
<!--  generator="dordoka framework"  --> 
<rss version="2.0" xmlns:content="http://purl.org/rss/1.0/modules/content/" xmlns:wfw="http://wellformedweb.org/CommentAPI/" xmlns:dc="http://purl.org/dc/elements/1.1/">
<channel>
  <title>Gomenda</title> 
  <link><?php echo $path;?></link> 
  <description>Gomenda, web de recomendaciones...</description> 
  <pubDate><?php echo date('Y-m-d h:m:s');?></pubDate> 
  <generator><?php echo $path;?></generator> 
  <language>es</language> 
  
  <?php
  
  while ($ultimas->hasMoreElements())
  {
		$urlentrada = $path ."/recomendacion/".$ultimas->getValue("identrada")."/".$util->crearUrl($ultimas->getValue("titulo")).".html";
  
  ?>
  
<item>
  <title><?php echo $ultimas->getValue('titulo');?></title> 
  <link><?php echo $urlentrada;?></link> 
  <comments><?php echo $urlentrada;?></comments> 
  <pubDate><?php echo $ultimas->getValue('fecha');?></pubDate> 
  <dc:creator><?php echo $ultimas->getValue("login");?></dc:creator> 
<category>
<![CDATA[<?php $ultimas->getValue("categoria");?>]]>
  </category>
  <guid isPermaLink="true"><?php echo $urlentrada;?></guid> 
<description>
<![CDATA[<?php echo $util->teaser($ultimas->getValue("texto"));?>]]> 
  </description>
<content:encoded>
 <![CDATA[<?php echo $util->teaser($ultimas->getValue("texto"))?>]]> 
  </content:encoded>
  <wfw:commentRss><?php echo $urlentrada;?></wfw:commentRss> 
  </item>

<?
	$ultimas->next();
}
?>
  </channel>
  </rss>
 