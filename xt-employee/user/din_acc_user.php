<?php 
define("__ADMIN", true);
$__ADMIN = true;

require_once("../lib/core.php"); 

header ('Content-type: text/html; charset=iso-8859-1');

$co_perfil = getA("co_perfil");

$strsql = "select a.co,a.ds_mod,c.nb as grupo from tssa_acc_exist a, tssa_acc b, tssa_acc_grupo c 
					 where a.co=b.co_acc_exist and a.co_grupo=c.co and b.co_perfil=$co_perfil order by c.ord,a.ord";
$rs = process_all($strsql);

if($rs)
{
	$salida = "<table width='100%' cellspacing='1' cellpadding='1'>
							<tr bgcolor='#cccccc'>
								<td>Opción Menú / Módulo</td>
								<td align='center'>Ingresar</td>
								<td align='center'>Modificar</td>
								<td align='center'>Eliminar</td>
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

