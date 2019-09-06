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



ob_start();

$codigo = getA("co");
$co_acc = getA("co_acc");

$tit1 = "Incidents";
$tit2 = "Edit Incident";
$url1 = "incident-list.php?co_acc=$co_acc";
$url2 = "incident-edit.php?co_acc=$co_acc&co=$codigo";
?>

<body >


        <?php

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

            <!-- page content -->
            <div style=" padding:30px">
                <div style="padding:10px; background-color:#fff">
                <div>
                    <div>
                        <h3 style="color:#333"><?php echo html_entity_decode($header_incident) ?></h3>
                    </div>
                </div>

                <hr>

                <div style="background-color: #73879C; color:#fff;padding: 5px;"><strong>Incident General Information</strong></div>
                
                <table width="100%" cellpadding="3" cellspacing="3" border="0">
                    <tr>
                        <td><strong>Incident Type: </strong></td>
                        <td>
                            <?php
                            $rs = $incidenttype->listarActivos($db);

                            foreach($rs as $rss)
                            {
                            extract($rss);

                            if($co==$co_incident_type) echo "<div>$nb</div>"; 
                            }
                            ?>                            
                        </td>
                        <td><strong>Post: </strong></td>
                        <td>
                            <?php
                            $rs = $post->listarActivos($db);

                            foreach($rs as $rss)
                            {
                                extract($rss);
                                
                                if($co==$co_post) echo "<div>$nb</div>";
                            }
                            ?>
                            
                        </td>
                    </tr>
                    <tr>
                        <td><strong>Incident Date: </strong></td>
                        <td><?php echo $fe_incident ?></td>
                        <td><strong>Reported by: </strong></td>
                        <td>
                            <?php
                            $rs = $employee->listarActivos($db);

                            foreach($rs as $rss)
                            {
                                extract($rss);
                                
                                if($co==$co_employee) echo "<div>$nb $apll</div>";
                            }
                            ?>                            
                        </td>
                    </tr>
                    <tr>
                        <td><strong>Incident Status: </strong></td>
                        <td>
                            <?php
                            $rs = $incident->listar_incidentstat($db);

                            foreach($rs as $rss)
                            {
                                extract($rss);
                                
                                if($co==$co_incident_stat) echo "<div>$nb</div>";
                            }
                            ?>                            
                        </td>
                        <td><strong>Victim / Owner Name: </strong></td>
                        <td><?php echo $victim_name?></td>
                    </tr>
                    <tr>
                        <td><strong>Victim / Owner Phone: </strong></td>
                        <td><?php echo $victim_telf?></td>
                        <td><strong>Victim / Owner Address: </strong></td>
                        <td><?php echo $victim_dir?></td>
                    </tr>
                    <tr>
                        <td colspan="4"><strong>Description: </strong></td>
                    </tr>
                    <tr>
                        <td colspan="4"><?php echo html_entity_decode($ds)?></td>
                    </tr>
                </table>

                <br><br>

                <div style="background-color: #73879C; color:#fff;padding: 5px;"><strong>Emergency Information</strong></div>
                
                <br><br>

                <table width="100%" cellpadding="3" cellspacing="3" border="0">
                    <tr>
                        <td><strong>First Responder: </strong></td>
                        <td>
                            <?php
                            $rs = $incident->listar_emergencyserv($db);

                            foreach($rs as $rss)
                            {
                                extract($rss);
                                
                                if($co==$co_emergency_disp) echo "<div>$nb</div>";
                            }
                        
                            if($emergency_otro!="")
                                echo " : $emergency_otro";
                            ?>                            
                        </td>
                        <td><strong>Emergency Contact Name: </strong></td>
                        <td><?php echo $emergency_name?></td>
                    </tr>
                    <tr>
                        <td><strong>Emergency Contact Badge: </strong></td>
                        <td><?php echo $emergency_badge?></td>
                        <td><strong>Emergency Inspection #: </strong></td>
                        <td><?php echo $case_no?></td>
                    </tr>
                    <tr>
                        <td><strong>Arrival Date: </strong></td>
                        <td><?php echo $fe_emergency_in ?></td>
                        <td><strong>Departure Date: </strong></td>
                        <td><?php echo $fe_emergency_out ?></td>
                    </tr>
                </table>


                <br><br>

                <div style="background-color: #73879C; color:#fff;padding: 5px;"><strong>Pictures</strong></div>
                
                <br><br>


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

                            <div style="float:left; width:300px">
                                <img src="<?php echo $ruta_online?>/<?php echo $file;?>" alt="" style="width:300px; height:auto">
                            </div>
                            <?php
                            }
                        }
                    }
                }?> 
                
                                            
                <div style="clear:both;height:0px"></div>
                <br><br>

                <div style="background-color: #73879C; color:#fff;padding: 5px;"><strong>Incident Involved</strong></div>
                

                <?php 
                if ($rs_prop)
                {   $i = 0;
                ?>
                <div>
                    <h4><strong>Properties</strong></h4>
                    <hr>
                    <table width="100%" cellspacing="3" cellpadding="3" border="0" >
                        <thead>
                        <tr style="background-color: #ccc">
                            <th>Address</th>
                            <th>City</th>
                            <th>State</th>
                            <th>ZIP</th>
                        </tr>
                        </thead>
                        <tbody id="addProp">
                        <?php

                            foreach($rs_prop as $prop_rs)
                            {
                                extract($prop_rs);
                                ?>
                                <tr id="prop_<?php echo $i ?>">
                                    <td><?php echo $prop_dir ?></td>
                                    <td><?php echo $prop_ciudad ?></td>
                                    <td align="center"><?php echo $prop_state ?></td>
                                    <td align="center"><?php echo $prop_zip ?></td>
                                </tr>
                                <?php
                                $i++;
                            }
                        
                        ?>


                        </tbody>
                    </table>
                </div>
                <?php 
                } 

                if ($rs_vehic)
                {   $i = 0;
                ?>
                <div>
                    <h4><strong>Vehicles</strong></h4>
                    <hr>
                    <table width="100%" cellspacing="3" cellpadding="3" border="0" >
                        <thead>
                        <tr style="background-color: #ccc">
                            <th>Make</th>
                            <th>Model</th>
                            <th>Year</th>
                            <th>TAG</th>
                            <th>Color</th>
                            <th>Plate</th>
                            <th>Other</th>
                        </tr>
                        </thead>
                        <tbody id="addVehic">
                        <?php

                            foreach($rs_vehic as $vehic_rs)
                            {
                                extract($vehic_rs);
                                ?>
                                <tr id="prop_<?php echo $i ?>">
                                    <td><?php echo $vehic_make ?></td>
                                    <td><?php echo $vehic_model ?></td>
                                    <td align="center"><?php echo $vehic_ano ?></td>
                                    <td align="center"><?php echo $vehic_tag ?></td>
                                    <td align="center"><?php echo $vehic_color ?></td>
                                    <td align="center"><?php echo $vehic_placa ?></td>
                                    <td><?php echo $vehic_otro ?></td>
                                </tr>
                                <?php
                                $i++;
                            }
                        
                        ?>
                        </tbody>
                    </table>
                </div>
                <?php 
                } 

                if ($rs_person)
                {   $i = 0;
                ?>
                <div>
                    <h4><strong>Persons</strong></h4>
                    <hr>
                    <table width="100%" cellspacing="3" cellpadding="3" border="0" >
                        <thead>
                        <tr style="background-color: #ccc">
                            <th>Name</th>
                            <th>Address</th>
                            <th>Phone</th>
                            <th>Age</th>
                        </tr>
                        </thead>
                        <tbody id="addPerson">
                        <?php
                            foreach($rs_person as $person_rs)
                            {
                                extract($person_rs);
                                ?>
                                <tr id="person_<?php echo $i ?>">
                                    <td><?php echo $person_nb ?></td>
                                    <td><?php echo $person_dir ?></td>
                                    <td><?php echo $person_telf ?></td>
                                    <td align="center"><?php echo $person_age ?></td>
                                </tr>
                                <?php
                                $i++;
                            }
                        
                        ?>
                        </tbody>
                    </table>
                </div>
                <?php 
                } 

                if ($rs_witness)
                {   $i = 0;
                ?>
                <div>
                    <h4><strong>Witness</strong></h4>
                    <hr>                                            
                    <table width="100%" cellspacing="3" cellpadding="3" border="0" >
                        <thead>
                        <tr style="background-color: #ccc">
                            <th>Name</th>
                            <th>Address</th>
                            <th>Phone</th>
                        </tr>
                        </thead>
                        <tbody id="addWitness">
                        <?php
                            foreach($rs_witness as $witness_rs)
                            {
                                extract($witness_rs);
                                ?>
                                <tr id="witness_<?php echo $i ?>">
                                    <td><?php echo $witness_nb ?></td>
                                    <td><?php echo $witness_dir ?></td>
                                    <td><?php echo $witness_telf ?></td>
                                </tr>
                                <?php
                                $i++;
                            }
                        
                        ?>
                        </tbody>
                    </table>
                </div>
                <?php 
                } ?>

                <br><br>
                <hr>

                <div>
                    <p >
                        <?php echo html_entity_decode($footer_incident) ?>
                    </p>
                </div>
            </div>
</body>

<?php


$m = ob_get_contents();



ob_end_clean();

$s =  "Incident Ocurred - Viper System";

$h = "";
$h .= 'MIME-Version: 1.0' . "\r\n";
$h .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
$h .= "From: Viper System<dlugo@xeniat.com>\r\n";
$h .= "Content-Type: text/html;\r\n";
$h .= "X-Mailer: PHP/" . phpversion();


$arr_corr = preg_split("/,/",$corr_incident);

foreach ($arr_corr as $i => $value)
{ 
    $result = mail($arr_corr[$i], $s, $m, $h);

}

?>