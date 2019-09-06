<?php
require_once("../../lib/core.php");
require_once('../../xt-model/IncidentModel.php');
require_once('../../xt-model/IncidentTypeModel.php');
require_once('../../xt-model/PostModel.php');
require_once('../../xt-model/EmployeeModel.php');
require_once('../../xt-model/MiscModel.php');

$misc = new MiscModel();
$incident = new IncidentModel();
$incidenttype = new IncidenttypeModel();
$post = new PostModel();
$employee = new EmployeeModel();

$codigo = getA("co");

$rs_misc = $misc->obtener_param($db);
if($rs_misc) extract($rs_misc[0]);

$rs_propnum = $incident->obtener_propnum($db,$codigo);
if($rs_propnum) extract($rs_propnum[0]);

$rs_vehicnum = $incident->obtener_vehicnum($db,$codigo);
if($rs_vehicnum) extract($rs_vehicnum[0]);

$rs_personnum = $incident->obtener_personnum($db,$codigo);
if($rs_personnum) extract($rs_personnum[0]);

$rs_witnessnum = $incident->obtener_witnessnum($db,$codigo);
if($rs_witnessnum) extract($rs_witnessnum[0]);

$rs_prop = $incident->obtener_prop($db,$codigo);
$rs_vehic = $incident->obtener_vehic($db,$codigo);
$rs_person = $incident->obtener_person($db,$codigo);
$rs_witness = $incident->obtener_witness($db,$codigo);


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


$rs = $incident->obtener($db,$codigo);

if($rs) extract($rs[0]);

$_dir = $ds_dir;

$cuerpo .= "    <div style='background-color:#ccc;padding:10px'><strong>" . html_entity_decode($header_incident) . "</strong></div>";
$cuerpo .= "    <page size='A4'>";
$cuerpo .= "    <br><br>";
$cuerpo .= "    <table style='width: 100%;max-width: 100%;margin-bottom: 20px;' width='100%' align='center'>";
$cuerpo .= "        <tr>";
$cuerpo .= "            <td colspan='2'  style='font-weight:bold'><strong>Incident General Information</strong></td>";
$cuerpo .= "        </tr>        ";
$cuerpo .= "        <tr>";
$cuerpo .= "            <td>";
$cuerpo .= "                <table width='98%' align='center'>";
$cuerpo .= "                    <tr>";
$cuerpo .= "                        <td style='background: #f2f2f2; font-weight:bold; padding:5px; width:50%'>";
$cuerpo .= "                            Incident Type";
$cuerpo .= "                        </td>";
$cuerpo .= "                        <td style='background: #f2f2f2; font-weight:bold; padding:5px; width:50%'>";
$cuerpo .= "                            Post";
$cuerpo .= "                        </td>";
$cuerpo .= "                    </tr>";
$cuerpo .= "                    <tr>";
$cuerpo .= "                        <td style='padding:5px; width:50%'>";

$rs = $incidenttype->listarActivos($db);

foreach($rs as $rss)
{
    extract($rss);
    
    if($co==$co_incident_type) 
        $cuerpo .=  $nb;
}

$cuerpo .= "   </td>";
$cuerpo .= "   <td style='padding:5px; width:50%'>";
            
$rs = $post->listarActivos($db);

foreach($rs as $rss)
{
    extract($rss);
    
    if($co==$co_post) 
        $cuerpo .= $nb;

}

$cuerpo .= "                        </td> ";
$cuerpo .= "                    </tr>";
$cuerpo .= "                    <tr>";
$cuerpo .= "                        <td style='background: #f2f2f2; font-weight:bold; padding:5px; width:50%'>";
$cuerpo .= "                            Incident Date";
$cuerpo .= "                        </td>";
$cuerpo .= "                        <td style='background: #f2f2f2; font-weight:bold; padding:5px; width:50%'>";
$cuerpo .= "                            Reported by";
$cuerpo .= "                        </td>";
$cuerpo .= "                    </tr>";
$cuerpo .= "                    <tr>";
$cuerpo .= "                        <td style='padding:5px; width:50%'>" . $fe_incident . "</td>";
$cuerpo .= "                        <td style='padding:5px; width:50%'>";

$rs = $employee->listarActivos($db);

foreach($rs as $rss)
{
    extract($rss);
    
    if($co==$co_employee) 
        $cuerpo .= $nb . '' . $apll;

}
                                                           
$cuerpo .= "                        </td>";
$cuerpo .= "                    </tr>";
$cuerpo .= "                    <tr>";
$cuerpo .= "                        <td style='background: #f2f2f2; font-weight:bold; padding:5px; width:50%'>";
$cuerpo .= "                            Incident Status";
$cuerpo .= "                        </td>";
$cuerpo .= "                        <td style='background: #f2f2f2; font-weight:bold; padding:5px; width:50%'>";
$cuerpo .= "                            Victim / Owner Name";
$cuerpo .= "                        </td>";
$cuerpo .= "                    </tr>";
$cuerpo .= "                    <tr>";
$cuerpo .= "                        <td style='padding:5px; width:50%'>";

$rs = $incident->listar_incidentstat($db);

foreach($rs as $rss)
{
    extract($rss);
    
    if($co==$co_incident_stat) 
        $cuerpo .= $nb; 

}

$cuerpo .= "                        </td>";
$cuerpo .= "                        <td style='padding:5px; width:50%'>". $victim_name; 
$cuerpo .= "                        </td>";
$cuerpo .= "                    </tr>";
$cuerpo .= "                    <tr>";
$cuerpo .= "                        <td style='background: #f2f2f2; font-weight:bold; padding:5px; width:50%'>";
$cuerpo .= "                            Victim / Owner Phone";
$cuerpo .= "                        </td>";
$cuerpo .= "                        <td style='background: #f2f2f2; font-weight:bold; padding:5px; width:50%'>";
$cuerpo .= "                            Victim / Owner Address";
$cuerpo .= "                        </td>";
$cuerpo .= "                    </tr>";
$cuerpo .= "                    <tr>";
$cuerpo .= "                        <td style='padding:5px; width:50%'>" . $victim_telf;
$cuerpo .= "                        </td>";
$cuerpo .= "                        <td style='padding:5px; width:50%'>" . $victim_dir;
$cuerpo .= "                        </td>";
$cuerpo .= "                    </tr>";
$cuerpo .= "                    <tr>";
$cuerpo .= "                        <td colspan='2'  style='background: #f2f2f2; font-weight:bold; padding:5px;'>";
$cuerpo .= "                            Description";
$cuerpo .= "                        </td>";
$cuerpo .= "                    </tr>";
$cuerpo .= "                    <tr>";
$cuerpo .= "                        <td colspan='2'>" . html_entity_decode($ds);
$cuerpo .= "                        </td>";
$cuerpo .= "                    </tr>";
$cuerpo .= "                </table>";
$cuerpo .= "                <br><br>";
$cuerpo .= "            </td>";
$cuerpo .= "        </tr>";
$cuerpo .= "        <tr>";
$cuerpo .= "            <td colspan='2'  style='font-weight:bold'><strong>Emergency Information</strong></td>";
$cuerpo .= "        </tr>        ";
$cuerpo .= "        <tr>";
$cuerpo .= "            <td colspan='2'>";
$cuerpo .= "                <table width='98%' align='center'>";
$cuerpo .= "                    <tr>";
$cuerpo .= "                        <td style='background: #f2f2f2; font-weight:bold; padding:5px; width:50%'>";
$cuerpo .= "                            First Responder";
$cuerpo .= "                        </td>";
$cuerpo .= "                        <td style='background: #f2f2f2; font-weight:bold; padding:5px; width:50%'>";
$cuerpo .= "                            Emergency Contact Name";
$cuerpo .= "                        </td>";
$cuerpo .= "                    </tr>";
$cuerpo .= "                    <tr>";
$cuerpo .= "                        <td style='padding:5px; width:50%'>";

$rs = $incident->listar_emergencyserv($db);

foreach($rs as $rss)
{
    extract($rss);
    
    if($co==$co_emergency_disp) 
        $cuerpo .= $nb; 

}

$cuerpo .= "                        </td>";
$cuerpo .= "                        <td style='padding:5px; width:50%'>" . $emergency_name;
$cuerpo .= "                        </td>";
$cuerpo .= "                    </tr>";
$cuerpo .= "                    <tr>";
$cuerpo .= "                        <td style='background: #f2f2f2; font-weight:bold; padding:5px; width:50%'>";
$cuerpo .= "                            Emergency Contact Badge";
$cuerpo .= "                        </td>";
$cuerpo .= "                        <td style='background: #f2f2f2; font-weight:bold; padding:5px; width:50%'>";
$cuerpo .= "                            Emergency Inspection #";
$cuerpo .= "                        </td>";
$cuerpo .= "                    </tr>";
$cuerpo .= "                    <tr>";
$cuerpo .= "                        <td style='padding:5px; width:50%'>" . $emergency_badge; 
$cuerpo .= "                        </td>";
$cuerpo .= "                        <td style='padding:5px; width:50%'>" . $case_no;
$cuerpo .= "                        </td>";
$cuerpo .= "                    </tr>";
$cuerpo .= "                    <tr>";
$cuerpo .= "                        <td style='background: #f2f2f2; font-weight:bold; padding:5px; width:50%'>";
$cuerpo .= "                            Arrival Date";
$cuerpo .= "                        </td>";
$cuerpo .= "                        <td style='background: #f2f2f2; font-weight:bold; padding:5px; width:50%'>";
$cuerpo .= "                            Departure Date";
$cuerpo .= "                        </td>";
$cuerpo .= "                    </tr>";
$cuerpo .= "                    <tr>";
$cuerpo .= "                        <td style='padding:5px; width:50%'>" . $fe_emergency_in;
$cuerpo .= "                        </td>";
$cuerpo .= "                        <td style='padding:5px; width:50%'>" . $fe_emergency_out;
$cuerpo .= "                        </td>";
$cuerpo .= "                    </tr>";
$cuerpo .= "                </table>";
$cuerpo .= "            </td>";
$cuerpo .= "        </tr>";
$cuerpo .= "    </table>";
$cuerpo .= "</page>";
$cuerpo .= "<page size='A4'>";
$cuerpo .= "    <table  width='98%' align='center'>";
$cuerpo .= "        <tr>";
$cuerpo .= "            <td colspan='2'  style='font-weight:bold'>Incident Involved</td>";
$cuerpo .= "        </tr>        ";
$cuerpo .= "        <tr>";
$cuerpo .= "            <td colspan='2'  style='font-weight:bold'>Poperties</td>";
$cuerpo .= "        </tr>    ";
$cuerpo .= "        <tr>";
$cuerpo .= "            <td colspan='2'>";

if ($rs_prop)
{   
    $cuerpo .= "                <table  width='98%' align='center'>";
    $cuerpo .= "                    <tr>";
    $cuerpo .= "                        <td style='background: #f2f2f2; font-weight:bold; padding:5px; width:25%'>Address</td>";
    $cuerpo .= "                        <td style='background: #f2f2f2; font-weight:bold; padding:5px; width:25%'>City</td>";
    $cuerpo .= "                        <td style='background: #f2f2f2; font-weight:bold; padding:5px; width:25%'>State</td>";
    $cuerpo .= "                        <td style='background: #f2f2f2; font-weight:bold; padding:5px; width:25%'>ZIP</td>";
    $cuerpo .= "                    </tr>";

    foreach($rs_prop as $prop_rs)
    {
        extract($prop_rs);

        $cuerpo .= "                        <tr>";
        $cuerpo .= "                            <td>". $prop_dir . "</td>";
        $cuerpo .= "                            <td>". $prop_ciudad ."</td>";
        $cuerpo .= "                            <td>". $prop_state ."</td>";
        $cuerpo .= "                            <td>". $prop_zip ."</td>";
        $cuerpo .= "                        </tr>";

    }

    $cuerpo .= "                </table>";

}
else
    $cuerpo .= "<p>There is not Properties involved</p>";

$cuerpo .= "            </td>";
$cuerpo .= "        </tr>";
$cuerpo .= "        <tr>";
$cuerpo .= "            <td colspan='2'  style='font-weight:bold'>Vehicles</td>";
$cuerpo .= "        </tr>    ";
$cuerpo .= "        <tr>";
$cuerpo .= "            <td colspan='2'>";

if ($rs_vehic)
{   
    $cuerpo .= "                <table  width='98%' align='center'>";
    $cuerpo .= "                    <tr>";
    $cuerpo .= "                        <td style='background: #f2f2f2; font-weight:bold; padding:5px; width:14%'>Make</td>";
    $cuerpo .= "                        <td style='background: #f2f2f2; font-weight:bold; padding:5px; width:14%'>Model</td>";
    $cuerpo .= "                        <td style='background: #f2f2f2; font-weight:bold; padding:5px; width:14%'>Year</td>";
    $cuerpo .= "                        <td style='background: #f2f2f2; font-weight:bold; padding:5px; width:14%'>TAG</td>";
    $cuerpo .= "                        <td style='background: #f2f2f2; font-weight:bold; padding:5px; width:14%'>Color</td>";
    $cuerpo .= "                        <td style='background: #f2f2f2; font-weight:bold; padding:5px; width:14%'>Plate</td>";
    $cuerpo .= "                        <td style='background: #f2f2f2; font-weight:bold; padding:5px; width:14%'>Other</td>";
    $cuerpo .= "                    </tr>";

    foreach($rs_vehic as $vehic_rs)
    {
        extract($vehic_rs);

        $cuerpo .= "                        <tr>";
        $cuerpo .= "                            <td>". $vehic_make ."</td>";
        $cuerpo .= "                            <td>". $vehic_model ."</td>";
        $cuerpo .= "                            <td>". $vehic_ano ."</td>";
        $cuerpo .= "                            <td>". $vehic_tag ."</td>";
        $cuerpo .= "                            <td>". $vehic_color ."</td>";
        $cuerpo .= "                            <td>". $vehic_placa ."</td>";
        $cuerpo .= "                            <td>". $vehic_otro ."</td>";
        $cuerpo .= "                        </tr>";

    }

    $cuerpo .= "                </table>";

}
else
    $cuerpo .= "<p>There is not Vehicles involved</p>";

$cuerpo .= "            </td>";
$cuerpo .= "        </tr>";
$cuerpo .= "        <tr>";
$cuerpo .= "            <td colspan='2'  style='font-weight:bold'>Persons</td>";
$cuerpo .= "        </tr>    ";
$cuerpo .= "        <tr>";
$cuerpo .= "            <td colspan='2'>";

if ($rs_person)
{   
    $cuerpo .= "                <table  width='98%' align='center'>";
    $cuerpo .= "                    <tr>";
    $cuerpo .= "                        <td style='background: #f2f2f2; font-weight:bold; padding:5px; width:25%'>Name</td>";
    $cuerpo .= "                        <td style='background: #f2f2f2; font-weight:bold; padding:5px; width:25%'>Address</td>";
    $cuerpo .= "                        <td style='background: #f2f2f2; font-weight:bold; padding:5px; width:25%'>Phone</td>";
    $cuerpo .= "                        <td style='background: #f2f2f2; font-weight:bold; padding:5px; width:25%'>Age</td>";
    $cuerpo .= "                    </tr>";

    foreach($rs_person as $person_rs)
    {
        extract($person_rs);

        $cuerpo .= "                        <tr>";
        $cuerpo .= "                            <td>". $person_nb ."</td>";
        $cuerpo .= "                            <td>". $person_dir ."</td>";
        $cuerpo .= "                            <td>". $person_telf ."</td>";
        $cuerpo .= "                            <td>". $person_age ."</td>";
        $cuerpo .= "                        </tr>";

    }

    $cuerpo .= "                </table>";

}
else
    $cuerpo .= "<p>There is not Persons involved</p>";

$cuerpo .= "            </td>";
$cuerpo .= "        </tr>";
$cuerpo .= "        <tr>";
$cuerpo .= "            <td colspan='2'  style='font-weight:bold'>Witness</td>";
$cuerpo .= "        </tr>    ";
$cuerpo .= "        <tr>";
$cuerpo .= "            <td colspan='2'>";

if ($rs_witness)
{  
    $cuerpo .= "                <table  width='98%' align='center'>";
    $cuerpo .= "                    <tr>";
    $cuerpo .= "                        <td style='background: #f2f2f2; font-weight:bold; padding:5px; width:40%'>Name</td>";
    $cuerpo .= "                        <td style='background: #f2f2f2; font-weight:bold; padding:5px; width:30%'>Address</td>";
    $cuerpo .= "                        <td style='background: #f2f2f2; font-weight:bold; padding:5px; width:30%'>Phone</td>";
    $cuerpo .= "                    </tr>";

    foreach($rs_witness as $witness_rs)
    {
        extract($witness_rs);

        $cuerpo .= "                        <tr>";
        $cuerpo .= "                            <td>". $witness_nb ."</td>";
        $cuerpo .= "                            <td>". $witness_dir ."</td>";
        $cuerpo .= "                            <td>". $witness_telf ."</td>";
        $cuerpo .= "                        </tr>";

    }

    $cuerpo .= "                </table>";

}
else
   $cuerpo .= "<p>There is not Witness involved</p>";


$cuerpo .= "            </td>";
$cuerpo .= "        </tr>";
$cuerpo .= "    </table>";
$cuerpo .= "</page>";
$cuerpo .= "<page size='A4'>";
$cuerpo .= "    <table  width='98%' align='center'>";
$cuerpo .= "        <tr>";
$cuerpo .= "            <td colspan='2'  style='font-weight:bold'>Pictures</td>";
$cuerpo .= "        </tr>        ";

            
$ruta="../../images/incidents/$_dir";
$ruta_online=ONLINE_DIR . "/images/incidents/$_dir";

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
$cuerpo .= "            <p >". html_entity_decode($footer_incident);
$cuerpo .= "            </p>";
$cuerpo .= "        </div>";
$cuerpo .= "    </footer>";
$cuerpo .= "</div>";
$cuerpo .= "</body>";
$cuerpo .= "</html>";


$asunto =  "An incident #$codigo has ocurred - Viper System";

$cabeceras = "";
$cabeceras .= 'MIME-Version: 1.0' . "\r\n";
$cabeceras .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
$cabeceras .= "From: Viper System<viper@ussecurity.biz>\r\n";
$cabeceras .= "Content-Type: text/html;\r\n";

$rs = $post->obtener_incidentalert($db,$co_post);

if($rs) extract($rs[0]);

$rs = $misc->obtener_param($db);

if($rs) extract($rs[0]);

echo("Team Alerts:" . mail($corr_incident,$asunto,$cuerpo,$cabeceras)."<br>");

$arrmails = preg_split("/,/",$ds_corr);


foreach ($arrmails as $correos) {
    echo("Post Alerts:" . mail($correos,$asunto,$cuerpo,$cabeceras)."<br>");
}
?>