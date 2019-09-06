<?php 
include_once '../../lib/core.php';
include_once '../../xt-model/PointLocation.php';
include_once '../../xt-model/PostModel.php';
require_once('../../xt-model/MiscModel.php');
require_once('../../xt-model/EmployeeModel.php');

if($_SESSION["codclockin"])
{
	$co_post = $_SESSION["codclockin"]["co_post"];
	$vlat = getA("vlat");
	$vlong = getA("vlong");
	$vaccuracy = getA("vaccuracy");

	$strtask = "";
	$sep = "|";

	if($co_post!="")
	{
		if($vaccuracy<15)
		{
			$pointLocation = new pointLocation();
			$post = new PostModel();
			$misc = new MiscModel();
			$employee = new EmployeeModel();

			$rs_post = $post->obtener($db,$co_post);
			if($rs_post) extract($rs_post[0]);

			$nb_post = $nb;
			$ds_id_post = $ds_id;

			$rs_misc = $misc->obtener_param($db);
			if($rs_misc) extract($rs_misc[0]);

			$rs_employee = $employee->obtener($db,$_SESSION["codemployee"]["co"]);
			if($rs_employee) extract($rs_employee[0]);

			$points = "$vlat $vlong";

			if($_SESSION["post_polygon"])
			{
				$statGeoFence = $pointLocation->pointInPolygon($points, $_SESSION["post_polygon"]);


				if($statGeoFence=='outside')
				{

					$asunto =  "A Guard has left the boundaries of the property  - Viper System";

					$cabeceras = "";
					$cabeceras .= 'MIME-Version: 1.0' . "\r\n";
					$cabeceras .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
					$cabeceras .= "From: Viper System<viper@ussecurity.biz>\r\n";
					$cabeceras .= "Content-Type: text/html;\r\n";

					$cuerpo = "<!DOCTYPE html>";
					$cuerpo .= "<html lang='en'>";
					$cuerpo .= "<head>";
					$cuerpo .= "    <meta http-equiv='Content-Type' content='text/html; charset=UTF-8'>";
					$cuerpo .= "    <meta charset='utf-8'>";
					$cuerpo .= "    <meta http-equiv='X-UA-Compatible' content='IE=edge'>";
					$cuerpo .= "    <meta name='viewport' content='width=device-width, initial-scale=1'>";
					$cuerpo .= "    <title>Viper System </title>";
					$cuerpo .= "</head>";
					$cuerpo .= "<body style='font-family:verdana;font-size:12px;color:#333;background-color:#fff;'>";
					$cuerpo .= "    <div style='width:100%'>";
					$cuerpo .= "    <div style='background-color:#ccc;padding:10px'><strong>" . html_entity_decode($header_track) . "</strong></div>";
					$cuerpo .= "    <page size='A4'><br><br>";
					$cuerpo .= "    <table style='width: 100%;max-width: 100%;margin-bottom: 20px;' width='100%' align='center'>";
					$cuerpo .= "        <tr>";
					$cuerpo .= "            <td colspan='2' style='font-weight:bold'>General Information</td>";
					$cuerpo .= "        </tr>        ";
					$cuerpo .= "        <tr>";
					$cuerpo .= "            <td colspan='2'>";
					$cuerpo .= "                <table  width='98%' align='center'>";
					$cuerpo .= "                    <tr>";
					$cuerpo .= "                        <td style='background: #f2f2f2; font-weight:bold; padding:5px; width:50%'>";
					$cuerpo .= "                            Guard ID";
					$cuerpo .= "                        </td>";
					$cuerpo .= "                        <td style='background: #f2f2f2; font-weight:bold; padding:5px; width:50%'>";
					$cuerpo .= "                            Guard Name";
					$cuerpo .= "                        </td>";
					$cuerpo .= "                    </tr>";
					$cuerpo .= "                    <tr>";
					$cuerpo .= "                        <td style='padding:5px; width:50%'>" . $nb;
					$cuerpo .= "                        </td>";
					$cuerpo .= "                        <td style='padding:5px; width:50%'>" . $apll;
					$cuerpo .= "                        </td>";
					$cuerpo .= "                    </tr>";
					$cuerpo .= "                    <tr>";
					$cuerpo .= "                        <td style='background: #f2f2f2; font-weight:bold; padding:5px; width:50%'>";
					$cuerpo .= "                            POST ID";
					$cuerpo .= "                        </td>";
					$cuerpo .= "                        <td style='background: #f2f2f2; font-weight:bold; padding:5px; width:50%'>";
					$cuerpo .= "                            POST Name";
					$cuerpo .= "                        </td>";
					$cuerpo .= "                    </tr>";
					$cuerpo .= "                    <tr>";
					$cuerpo .= "                        <td style='padding:5px; width:50%'>" . $ds_id_post;
					$cuerpo .= "                        </td>";
					$cuerpo .= "                        <td style='padding:5px; width:50%'>" . $nb_post;
					$cuerpo .= "                        </td>";
					$cuerpo .= "                    </tr>";
					$cuerpo .= "                </table>";
					$cuerpo .= "            </td>";
					$cuerpo .= "        </tr>";
					$cuerpo .= "    </table>";
					$cuerpo .= "    </page><br><br>";
					$cuerpo .= "    <hr>";
					$cuerpo .= "    <footer>";
					$cuerpo .= "        <div class='col-md-12'>";
					$cuerpo .= "            <p >". html_entity_decode($footer_track);
					$cuerpo .= "            </p>";
					$cuerpo .= "        </div>";
					$cuerpo .= "    </footer>";
					$cuerpo .= "</div>";
					$cuerpo .= "</body>";
					$cuerpo .= "</html>";


					mail($corr_track,$asunto,$cuerpo,$cabeceras);
				}

				echo($statGeoFence);
			}
		}
	}
}


?>