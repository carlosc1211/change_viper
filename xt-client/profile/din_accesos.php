<?php 
require_once("../../lib/core.php");

header ('Content-type: text/html; charset=utf-8');

$codrol = getA("codrol");

$accrol = new ConnectModel();
$rs = $accrol->getRolAccesoMod($db,$codrol);

foreach($rs as $rss) 
{
	extract($rss);
	echo($co . "|" . $ds_mod . "|");
}
?>