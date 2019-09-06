<?php
require_once("../../lib/core.php");
require_once('../../xt-model/IssueModel.php');
require_once('../../xt-model/EmployeeModel.php');
require_once('../../xt-model/PostModel.php');
require_once('../../xt-model/MensajeModel.php');
require_once('../../xt-model/MiscModel.php');

$misc = new MiscModel();
$mensaje = new MensajeModel();
$issue = new IssueModel();
$employee = new EmployeeModel();
$post = new PostModel();

$codigo = getA("co");

$rs_misc = $misc->obtener_param($db);
if($rs_misc) extract($rs_misc[0]);

$rs = $issue->obtener($db,$codigo);

if($rs) extract($rs[0]);


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
$cuerpo .= "    <div style='background-color:#ccc;padding:10px'><strong>" . html_entity_decode($header_issue) . "</strong></div>";
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
$cuerpo .= "                            Reported by";
$cuerpo .= "                        </td>";
$cuerpo .= "                        <td style='background: #f2f2f2; font-weight:bold; padding:5px; width:50%'>";
$cuerpo .= "                            Post";
$cuerpo .= "                        </td>";
$cuerpo .= "                    </tr>";
$cuerpo .= "                    <tr>";
$cuerpo .= "                        <td style='padding:5px; width:50%'>";

$rs = $employee->listarActivos($db);

foreach($rs as $rss)
{
    extract($rss);

    if($co==$co_employee) 
        $cuerpo .= $nb . '' . $apll;

}

$cuerpo .= "                        </td>";
$cuerpo .= "                        <td style='padding:5px; width:50%'>";

$rs = $post->listarActivos($db);

foreach($rs as $rss)
{
    extract($rss);
    
    if($co==$co_post) 
        $cuerpo .= $nb;

}

$cuerpo .= "                        </td>";
$cuerpo .= "                    </tr>";
$cuerpo .= "                    <tr>";
$cuerpo .= "                        <td colspan='2' style='background: #f2f2f2; font-weight:bold; padding:5px; width:50%'>";
$cuerpo .= "                            Issue Date";
$cuerpo .= "                        </td>";
$cuerpo .= "                    </tr>";
$cuerpo .= "                    <tr>";
$cuerpo .= "                        <td colspan='2' style='padding:5px; width:50%'>" . $fe_issue;
$cuerpo .= "                        </td>";
$cuerpo .= "                    </tr>";
$cuerpo .= "                    <tr>";
$cuerpo .= "                        <td colspan='2' style='background: #f2f2f2; font-weight:bold; padding:5px; width:50%'>";
$cuerpo .= "                            Issue Description";
$cuerpo .= "                        </td>";
$cuerpo .= "                    </tr>";
$cuerpo .= "                    <tr>";
$cuerpo .= "                        <td colspan='2' style='padding:5px; width:50%'>" . html_entity_decode($ds);
$cuerpo .= "                        </td>";
$cuerpo .= "                    </tr>";
$cuerpo .= "                </table>";
$cuerpo .= "            </td>";
$cuerpo .= "        </tr>";
$cuerpo .= "        <tr>";
$cuerpo .= "            <td colspan='2' style='font-weight:bold'>Logs</td>";
$cuerpo .= "        </tr>        ";
$cuerpo .= "        <tr>";
$cuerpo .= "            <td colspan='2'>";
$cuerpo .= "                <table width='98%' align='center'>";
$cuerpo .= "                    <thead>";
$cuerpo .= "                    <tr class='headings'>";
$cuerpo .= "                        <th style='background: #f2f2f2; font-weight:bold; padding:5px; width:25%'>Date</th>";
$cuerpo .= "                        <th style='background: #f2f2f2; font-weight:bold; padding:5px; width:25%'>User</th>";
$cuerpo .= "                        <th style='background: #f2f2f2; font-weight:bold; padding:5px; width:25%'>Status</th>";
$cuerpo .= "                        <th style='background: #f2f2f2; font-weight:bold; padding:5px; width:25%'>Comment</th>";
$cuerpo .= "                    </tr>";
$cuerpo .= "                    </thead>";
$cuerpo .= "                    <tbody>";


$rst = $issue->actionsLog($db,$codigo);

foreach($rst as $rsts)
{
    extract($rsts);

    $cuerpo .= "    <tr class='even pointer'>";
    $cuerpo .= "        <td style='padding:5px; width:25%' align='center'>" . $fe_issue_action ."</td>";
    $cuerpo .= "        <td style='padding:5px; width:25%'>" . $nb_user . ' ' . $apll_user ."</td>";
    $cuerpo .= "        <td style='padding:5px; width:25%' align='center'>" . $nb_stat ."</td>";
    $cuerpo .= "        <td style='padding:5px; width:25%'>" . html_entity_decode($ds_actions) ."</td>";
    $cuerpo .= "    </tr>";

}

$cuerpo .= "                    </tbody>";
$cuerpo .= "                </table>";
$cuerpo .= "            </td>";
$cuerpo .= "        </tr>";
$cuerpo .= "    </table>";
$cuerpo .= "    </page><br><br>";
$cuerpo .= "    <hr>";
$cuerpo .= "    <footer>";
$cuerpo .= "        <div class='col-md-12'>";
$cuerpo .= "            <p >". html_entity_decode($footer_issue);
$cuerpo .= "            </p>";
$cuerpo .= "        </div>";
$cuerpo .= "    </footer>";
$cuerpo .= "</div>";
$cuerpo .= "</body>";
$cuerpo .= "</html>";


$asunto =  "An internal communication (issue) #$codigo has ocurred - Viper System";

$cabeceras = "";
$cabeceras .= 'MIME-Version: 1.0' . "\r\n";
$cabeceras .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
$cabeceras .= "From: Viper System<viper@ussecurity.biz>\r\n";
$cabeceras .= "Content-Type: text/html;\r\n";

$rs = $misc->obtener_param($db);

if($rs) extract($rs[0]);

echo("Team Alerts:" . mail($corr_issue,$asunto,$cuerpo,$cabeceras)."<br>");

?>