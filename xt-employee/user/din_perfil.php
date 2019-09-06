<?php 
define("__ADMIN", true);
$__ADMIN = true;

require_once("../lib/core.php"); 

$codrol = getA("codrol");

$strsql = "select co,nb from tssa_perfil where co_rol=$codrol";
$rs = process_all($strsql);

foreach($rs as $rss) 
{
	extract($rss);
	echo($co . "|" . $nb . "|");
}
?>