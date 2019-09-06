<?php
require_once("../../lib/core.php");
require_once('../../xt-model/PostModel.php');
require_once('../../xt-model/MiscModel.php');
require_once('../../xt-model/DailyModel.php');

$codigo = getA("co");

$misc = new MiscModel();
$post = new PostModel();
$dailymod = new DailyModel();

$rs_misc = $misc->obtener_param($db);
if($rs_misc) extract($rs_misc[0]);

$rs = $dailymod->obtener_in($db,$codigo);
if($rs) extract($rs[0]);

$_dir = $ds_dir;

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


$cuerpo .= "    <div style='background-color:#ccc;padding:10px'><strong>" . html_entity_decode($header_daily_log) . "</strong></div>";
$cuerpo .= "    <page size='A4'>";
$cuerpo .= "    <br><br>";
$cuerpo .= "    <table style='width: 100%;max-width: 100%;margin-bottom: 20px;' width='100%' align='center'>";
$cuerpo .= "        <tr>";
$cuerpo .= "            <td colspan='2'  style='font-weight:bold'><strong>Daily Log Activity Information</strong></td>";
$cuerpo .= "        </tr>        ";
$cuerpo .= "        <tr>";
$cuerpo .= "            <td>";
$cuerpo .= "                <table width='98%' align='center'>";
$cuerpo .= "                    <tr>";
$cuerpo .= "                        <td colspan='2' style='background: #f2f2f2; font-weight:bold; padding:5px;' >Post</td>";
$cuerpo .= "                    </tr>";
$cuerpo .= "                    <tr>";
$cuerpo .= "                        <td colspan='2' style='padding:5px;'>$post_name</td>";
$cuerpo .= "                    </tr>";
$cuerpo .= "                    <tr>";
$cuerpo .= "                        <td style='background: #f2f2f2; font-weight:bold; padding:5px; width:50%'>";
$cuerpo .= "                            Report by";
$cuerpo .= "                        </td>";
$cuerpo .= "                        <td style='background: #f2f2f2; font-weight:bold; padding:5px; width:50%'>";
$cuerpo .= "                            Report at";
$cuerpo .= "                        </td>";
$cuerpo .= "                    </tr>";
$cuerpo .= "                    <tr>";
$cuerpo .= "                        <td style='padding:5px; width:50%'>";
$cuerpo .= "                            $nb_employee  $apll_employee";
$cuerpo .= "                        </td>";
$cuerpo .= "                        <td style='padding:5px; width:50%'>";
$cuerpo .= "                            $fe_reg";
$cuerpo .= "                        </td>";
$cuerpo .= "                    </tr>";
$cuerpo .= "                    <tr>";
$cuerpo .= "                        <td colspan='2' style='background: #f2f2f2; font-weight:bold; padding:5px; width:50%'>";
$cuerpo .= "                            Description";
$cuerpo .= "                        </td>";
$cuerpo .= "                    </tr>";
$cuerpo .= "                    <tr>";
$cuerpo .= "                        <td colspan='2'>" . html_entity_decode($obs) . "</td>";
$cuerpo .= "                    </tr>";
$cuerpo .= "                </table>";
$cuerpo .= "                <br>";
$cuerpo .= "            </td>";
$cuerpo .= "        </tr>";
$cuerpo .= "    </table>";
$cuerpo .= "</page>";

$cuerpo .= "<page size='A4'>";
$cuerpo .= "    <table  width='100%' align='center'>";
$cuerpo .= "        <tr>";
$cuerpo .= "            <td colspan='2'  style='font-weight:bold'>Daily Log Pictures</td>";
$cuerpo .= "        </tr>        ";

            
$ruta="../../images/daily-activity/$_dir";
$ruta_online=ONLINE_DIR . "/images/daily-activity/$_dir";

if($_dir!='')
{
    if ($dh = opendir($ruta)) 
    {    
        while (($file = readdir($dh)) !== false) 
        {   if ($file!='.' && $file!='..')
            { 
                $cuerpo .= "<tr>";
                $cuerpo .= "    <td>";
                $cuerpo .= "        <img src='".$ruta_online."/".$file."' alt='' style='max-width:400px;max-height:300px;display: block;'>";
                $cuerpo .= "    </td>";
                $cuerpo .= "</tr>";
            }
        }
    }
}

$cuerpo .= "    </table>";
$cuerpo .= "    </page><br><br>";
$cuerpo .= "    <hr>";
$cuerpo .= "    <footer>";
$cuerpo .= "        <div class='col-md-12'>";
$cuerpo .= "            <p >". html_entity_decode($footer_daily_log);
$cuerpo .= "            </p>";
$cuerpo .= "        </div>";
$cuerpo .= "    </footer>";
$cuerpo .= "</div>";
$cuerpo .= "</body>";
$cuerpo .= "</html>";


$asunto =  "A daily log activity #$codigo has ocurred - Viper System";

$cabeceras = "";
$cabeceras .= 'MIME-Version: 1.0' . "\r\n";
$cabeceras .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
$cabeceras .= "From: Viper System<viper@ussecurity.biz>\r\n";
$cabeceras .= "Content-Type: text/html;\r\n";

//$rs = $post->obtener_dailylogalert($db,$co_post);

//if($rs) extract($rs[0]);

$rs = $misc->obtener_param($db);

if($rs) extract($rs[0]);

echo("Team Alerts:" . mail($corr_daily_log,$asunto,$cuerpo,$cabeceras)."<br>");


$arrmails = preg_split("/,/",$post_corr_daily_log);


foreach ($arrmails as $correos) {
    echo("Post Alerts:" . mail($correos,$asunto,$cuerpo,$cabeceras)."<br>");
}

?>