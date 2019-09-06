<?php
require_once("../../lib/core.php");
require_once("../../lib/val_session.php");
require_once('../../xt-model/IncidentModel.php');
require_once('../../xt-model/IncidentTypeModel.php');
require_once('../../xt-model/PostModel.php');
require_once('../../xt-model/EmployeeModel.php');
require_once('../../xt-model/MensajeModel.php');
require_once('../../xt-model/MiscModel.php');

$misc = new MiscModel();
$mensaje = new MensajeModel();
$incident = new IncidentModel();
$incidenttype = new IncidenttypeModel();
$post = new PostModel();
$employee = new EmployeeModel();

require('../includes/header_basic.php');

$codigo = getA("co");

$tit1 = "Incident";

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

$rs = $incident->obtener($db,$codigo);

if($rs) extract($rs[0]);

$_dir = $ds_dir;

?>

<body>
    <page size="A4">
        <div style="background-color:#ccc;padding:10px"><strong><?php echo html_entity_decode($header_incident) ?></strong></div>    
    <table class="table">
        <tr>
            <td colspan="2" class="td-title">Incident General Information</td>
        </tr>        
        <tr>
            <td>
                <table id="tabla" bgcolor="#000">
                    <tr>
                        <td class="td-50 td-grey td-bold">
                            Incident Type
                        </td>
                        <td class="td-50 td-grey td-bold">
                            Post
                        </td>
                    </tr>
                    <tr>
                        <td class="td-50">
                            <?php
                            $rs = $incidenttype->listarActivos($db);

                            foreach($rs as $rss)
                            {
                                extract($rss);
                                
                                if($co==$co_incident_type) echo  $nb;
                            }
                            ?>
                        </td>
                        <td class="td-50">
                            <?php
                            $rs = $post->listarActivos($db);

                            foreach($rs as $rss)
                            {
                                extract($rss);
                                
                                if($co==$co_post) echo $nb;

                            }
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="td-50 td-grey td-bold">
                            Incident Date
                        </td>
                        <td class="td-50 td-grey td-bold">
                            Reported by
                        </td>
                    </tr>
                    <tr>
                        <td class="td-50">
                            <?php echo $fe_incident ?>                                                            
                        </td>
                        <td class="td-50">
                            <?php
                            $rs = $employee->listarActivos($db);

                            foreach($rs as $rss)
                            {
                                extract($rss);
                                
                                if($co==$co_employee) echo  $nb . '' . $apll;

                            }
                            ?>
                                                           
                        </td>
                    </tr>
                    <tr>
                        <td class="td-50 td-grey td-bold">
                            Incident Status
                        </td>
                        <td class="td-50 td-grey td-bold">
                            Victim / Owner Name
                        </td>
                    </tr>
                    <tr>
                        <td class="td-50">
                            <?php
                            $rs = $incident->listar_incidentstat($db);

                            foreach($rs as $rss)
                            {
                                extract($rss);
                                
                                if($co==$co_incident_stat) echo $nb; 

                            }
                            ?>
                        </td>
                        <td class="td-50">
                            <?php echo $victim_name ?>                                                            
                        </td>
                    </tr>
                    <tr>
                        <td class="td-50 td-grey td-bold">
                            Victim / Owner Phone
                        </td>
                        <td class="td-50 td-grey td-bold">
                            Victim / Owner Address
                        </td>
                    </tr>
                    <tr>
                        <td class="td-50">
                            <?php echo $victim_telf ?>                                                            
                        </td>
                        <td class="td-50">
                            <?php echo $victim_dir ?>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" class="td-grey td-bold">
                            Description
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <?php echo html_entity_decode($ds) ?>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td colspan="2" class="td-title">Emergency Information</td>
        </tr>        
        <tr>
            <td colspan="2">
                <table id="tabla" bgcolor="#000">
                    <tr>
                        <td class="td-50 td-grey td-bold">
                            First Responder
                        </td>
                        <td class="td-50 td-grey td-bold">
                            Emergency Contact Name
                        </td>
                    </tr>
                    <tr>
                        <td class="td-50">
                            <?php
                            $rs = $incident->listar_emergencyserv($db);

                            foreach($rs as $rss)
                            {
                                extract($rss);
                                
                                if($co==$co_emergency_disp) echo $nb; 

                            }
                            ?>
                        </td>
                        <td class="td-50">
                            <?php echo $emergency_name ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="td-50 td-grey td-bold">
                            Emergency Contact Badge
                        </td>
                        <td class="td-50 td-grey td-bold">
                            Emergency Inspection #
                        </td>
                    </tr>
                    <tr>
                        <td class="td-50">
                            <?php echo $emergency_badge ?>                                                            
                        </td>
                        <td class="td-50">
                            <?php echo $case_no ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="td-50 td-grey td-bold">
                            Arrival Date
                        </td>
                        <td class="td-50 td-grey td-bold">
                            Departure Date
                        </td>
                    </tr>
                    <tr>
                        <td class="td-50">
                            <?php echo $fe_emergency_in ?>                                                            
                        </td>
                        <td class="td-50">
                            <?php echo $fe_emergency_out ?>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</page>

<page size="A4">
    <table class="table">
        <tr>
            <td colspan="2" class="td-title">Incident Involved</td>
        </tr>        
        <tr>
            <td colspan="2" class="td-title">Poperties</td>
        </tr>    
        <tr>
            <td colspan="2">
            <?php
            if ($rs_prop)
            {   ?>
                <table class="table">
                    <tr>
                        <td>Address</td>
                        <td>City</td>
                        <td>State</td>
                        <td>ZIP</td>
                    </tr>
                    <?php
                    foreach($rs_prop as $prop_rs)
                    {
                        extract($prop_rs);
                        ?>
                        <tr>
                            <td><?php echo $prop_dir ?></td>
                            <td><?php echo $prop_ciudad ?></td>
                            <td><?php echo $prop_state ?></td>
                            <td><?php echo $prop_zip ?></td>
                        </tr>
                        <?php
                    }
                    ?>
                </table>
            <?php 
            }
            else
            {   echo "<p>There is not Properties involved</p>";} ?>

            </td>
        </tr>
        <tr>
            <td colspan="2" class="td-title">Vehicles</td>
        </tr>    
        <tr>
            <td colspan="2">
            <?php
            if ($rs_vehic)
            {   ?>
                <table class="table">
                    <tr>
                        <td>Make</td>
                        <td>Model</td>
                        <td>Year</td>
                        <td>TAG</td>
                        <td>Color</td>
                        <td>Plate</td>
                        <td>Other</td>
                    </tr>
                    <?php
                    foreach($rs_vehic as $vehic_rs)
                    {
                        extract($vehic_rs);
                        ?>
                        <tr>
                            <td><?php echo $vehic_make ?></td>
                            <td><?php echo $vehic_model ?></td>
                            <td><?php echo $vehic_ano ?></td>
                            <td><?php echo $vehic_tag ?></td>
                            <td><?php echo $vehic_color ?></td>
                            <td><?php echo $vehic_placa ?></td>
                            <td><?php echo $vehic_otro ?></td>
                        </tr>
                        <?php
                    }
                    ?>
                </table>
            <?php 
            }
            else
            {   echo "<p>There is not Vehicles involved</p>";} ?>

            </td>
        </tr>
        <tr>
            <td colspan="2" class="td-title">Persons</td>
        </tr>    
        <tr>
            <td colspan="2">
            <?php
            if ($rs_person)
            {   ?>
                <table class="table">
                    <tr>
                        <td>Name</td>
                        <td>Address</td>
                        <td>Phone</td>
                        <td>Age</td>
                    </tr>
                    <?php
                    foreach($rs_person as $person_rs)
                    {
                        extract($person_rs);
                        ?>
                        <tr>
                            <td><?php echo $person_nb ?></td>
                            <td><?php echo $person_dir ?></td>
                            <td><?php echo $person_telf ?></td>
                            <td><?php echo $person_age ?></td>
                        </tr>
                        <?php
                    }
                    ?>
                </table>
            <?php 
            }
            else
            {   echo "<p>There is not Persons involved</p>";} ?>

            </td>
        </tr>
        <tr>
            <td colspan="2" class="td-title">Witness</td>
        </tr>    
        <tr>
            <td colspan="2">
            <?php
            if ($rs_witness)
            {  ?>
                <table class="table">
                    <tr>
                        <td>Name</td>
                        <td>Address</td>
                        <td>Phone</td>
                    </tr>
                    <?php
                    foreach($rs_witness as $witness_rs)
                    {
                        extract($witness_rs);
                        ?>
                        <tr>
                            <td><?php echo $witness_nb ?></td>
                            <td><?php echo $witness_dir ?></td>
                            <td><?php echo $witness_telf ?></td>
                        </tr>
                        <?php
                    }
                    ?>
                </table>
            <?php 
            }
            else
            {   echo "<p>There is not Witness involved</p>";} ?>
            </td>
        </tr>
    </table>
</page>

<page size="A4">
    <table class="table">
        <tr>
            <td colspan="2" class="td-title">Pictures</td>
        </tr>        

        <?php
            
        $ruta="../../images/incidents/$_dir";
        $ruta_online=ONLINE_DIR . "/images/incidents/$_dir";

        if($_dir!='')
        {
            if ($dh = opendir($ruta)) 
            {    
                while (($file = readdir($dh)) !== false) 
                {   if ($file!="." && $file!="..")
                    { ?>

                        <tr>
                            <td class="thumbnail">
                                <img src="<?php echo $ruta_online?>/<?php echo $file;?>" alt="" style="max-width:400px;max-height:300px;display: block;">
                            </td>
                        </tr>
                    <?php
                    }
                }
            }
        }?> 


    </table><br><br>
    <hr>
    <footer>
        <div class="col-md-12">
            <p >
                <?php echo html_entity_decode($footer_incident) ?>
            </p>
        </div>
        <div class="clearfix"></div>
    </footer>
    </page>


</body>
    <script>
       window.print();
    </script>

</html>