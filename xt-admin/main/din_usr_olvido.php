<?php
require_once("../../lib/core.php");

$corr = getB("corr");

$rs = $cn->getUserAccesoCorr($db,$corr);

if($rs) extract($rs[0]);

if($co)
{
	$mailpara =$corr;
	$mail_body = "Hi. <br> As you ask for password request, here is your Password:" . $pwd;

	if(mail($mailpara,'Password forgot request - ' . $_APP_TITLE,$mail_body))
	{
		echo("1");
	}
	else
	{
		echo("2");
	}	
}
else
{
echo("2");
}
?>