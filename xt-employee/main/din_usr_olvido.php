<?php
require_once("../../lib/core.php");

$corr = getB("corr");

$strsql = "select * from tssa_user where corr = '$corr' and actv=1";
$rs = process($strsql);

if($rs) extract($rs);

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