<?php 

require_once("../../lib/core.php");
require_once('../../xt-model/PerfilModel.php');

header ('Content-type: text/html; charset=utf-8');

$perfil = new PerfilModel();
$codrol = getA("codrol");

$rs = $perfil->obtenerPerfilRol($db,$codrol);

foreach($rs as $rss) 
{
	extract($rss);
	echo($co . "|" . $nb . "|");
}
?>