<?php 

require_once("../../lib/core.php");
require_once("../../xt-model/UsuarioModel.php");

$usuario = new UsuarioModel();
$ds_usr = getA("ds_usr");

$rs = $usuario->obtenerUserusr($db,$ds_usr);

if($rs) extract($rs[0]);

if($co)
{	echo("1");  }
else
{	echo("0");  }
?>