<?php 
define("__ADMIN", true);
$__ADMIN = true;

require_once("../lib/core.php"); 

$usuario = getA("ds_usr");

$strsql = "select co from tssa_user where usr='$usuario'";
$rs = process($strsql);

if($rs) extract($rs);

if($co)
{	echo("1");  }
else
{	echo("0");  }
?>