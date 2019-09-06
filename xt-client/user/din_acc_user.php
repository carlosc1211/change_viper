<?php 

require_once("../../lib/core.php");

header ('Content-type: text/html; charset=utf-8');

$co_perfil = getA("co_perfil");

$rs = $cn->getUserAccesoMod($db,$co_perfil);

if($rs)
{
	$salida = "<table width='100%' cellspacing='1' cellpadding='1'>
							<tr bgcolor='#cccccc'>
								<td>Menu Option / Module</td>
								<td align='center'>Add</td>
								<td align='center'>Update</td>
								<td align='center'>Delete</td>
							</tr>	";

	foreach($rs as $rss) 
	{
		extract($rss);
		
		$salida .= " <tr>
									<td>$grupo / $ds_mod</td>
									<td align='center'><input name='ing$co' id='ing$co' type='checkbox' class='BotonForm2_det' checked/></td>
									<td align='center'><input name='mod$co' id='mod$co' type='checkbox' class='BotonForm2_det' checked /></td>
									<td align='center'><input name='elim$co' id='elim$co' type='checkbox' class='BotonForm2_det' checked /></td>
								</tr>	";
	}
	
	$salida .= "</table>";
	echo($salida);
}
?>

