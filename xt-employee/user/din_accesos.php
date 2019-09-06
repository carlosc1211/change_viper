<?php 
define("__ADMIN", true);
$__ADMIN = true;

require_once("../lib/core.php"); 

header ('Content-type: text/html; charset=iso-8859-1');

$codrol = getA("codrol");

$strsql = "select co,ds_mod from tssa_acc_exist where co_rol=$codrol order by ds_mod";
$rs = process_all($strsql);

foreach($rs as $rss) 
{
	extract($rss);
	echo($co . "|" . $ds_mod . "|");
}
?>