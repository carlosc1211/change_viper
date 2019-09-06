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
$co_acc = getA("co_acc");

function callback_mail($buffer)
{

    $subject =  "An incident #$codigo has ocurred - Viper System";

    $cabeceras = "";
    $cabeceras .= 'MIME-Version: 1.0' . "\r\n";
    $cabeceras .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
    $cabeceras .= "From: Viper System<" . MAIL_DE . ">\r\n";
    $cabeceras .= "Content-Type: text/html;\r\n";
    $cabeceras .= "X-Mailer: PHP/" . phpversion();

    $mail_body = $buffer;

    $rs = $post->obtener_incidentalert($db,$codigo);

    if($rs) extract($rs[0]);

    $rs = $misc->obtener_param($db);

    if($rs) extract($rs[0]);

    mail("dev.damaso.lugo@gmail.com",$subject,$mail_body,$cabeceras);
    //mail($corr_incident,$subject,$mail_body,$cabeceras);

    /*$arrmails = preg_split("/,/",$ds_corr);

    foreach ($arrmails as $correos) {
        mail($correos,$subject,$mail_body,$cabeceras);
    }
*/

    return ($buffer);

}

ob_start("callback_mail");

require('../includes/header_online.php');


?>

<body class="nav-md">

    <div class="container body">


        <div class="main_container">

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
            <div role="main">
                <div class="page-title">
                    <div class="title_left col-md-12">
                        <h4 style="color:#fff"><?php echo $header_incident ?></h4>
                    </div>
                </div>
                <div class="clearfix"></div>

                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="x_panel">
                            <div class="x_content">

                                <form role="form" action="<?php echo $url2;?>" method="post" name="forma" id="forma">

                                        <div class="well well-sm"><strong>Incident General Information</strong></div>

                                        <div class="col-md-6 col-xs-12">
                                            <div class="form-group ">
                                                <label class="control-label" for="r_co_incident_type">Incident Type</label>
                                                <?php
                                                $rs = $incidenttype->listarActivos($db);

                                                foreach($rs as $rss)
                                                {
                                                    extract($rss);
                                                    
                                                    if($co==$co_incident_type) echo "<div>$nb</div>"; 
                                                }
                                                ?>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-xs-12">
                                            <div class="form-group ">
                                                <label class="control-label" for="r_co_post">Post</label>
                                                    <?php
                                                    $rs = $post->listarActivos($db);

                                                    foreach($rs as $rss)
                                                    {
                                                        extract($rss);
                                                        
                                                        if($co==$co_post) echo "<div>$nb</div>";
                                                    }
                                                    ?>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-xs-12">
                                            <div class="form-group ">
                                                <label class="control-label" for="r_fe_incident">Incident Date</label>
                                                <div><?php echo $fe_incident ?></div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-xs-12">
                                            <div class="form-group ">
                                                <label class="control-label" for="r_co_employee">Reported by</label>
                                                    <?php
                                                    $rs = $employee->listarActivos($db);

                                                    foreach($rs as $rss)
                                                    {
                                                        extract($rss);
                                                        
                                                        if($co==$co_employee) echo "<div>$nb $apll</div>";
                                                    }
                                                    ?>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-xs-12">
                                            <div class="form-group ">
                                                <label class="control-label" for="r_co_incident_stat">Incident Status</label>
                                                    <?php
                                                    $rs = $incident->listar_incidentstat($db);

                                                    foreach($rs as $rss)
                                                    {
                                                        extract($rss);
                                                        
                                                        if($co==$co_incident_stat) echo "<div>$nb</div>";
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-xs-12">
                                            <div class="form-group ">
                                                <label class="control-label" for="victim_name">Victim / Owner Name</label>
                                                <div><?php echo $victim_name?></div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-xs-12">
                                            <div class="form-group ">
                                                <label class="control-label" for="victim_telf">Victim / Owner Phone</label>
                                                <div><?php echo $victim_telf?></div>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-6 col-xs-12">
                                            <label class="control-label" for="victim_dir">Victim / Owner Address</label>
                                            <div><?php echo $victim_dir?></div>
                                        </div>

                                        <div class="clearfix"></div>

                                        <div class="form-group col-md-12">
                                            <label class="control-label" for="ds">Description</label>
                                            <div><?php echo html_entity_decode($ds)?></div>
                                        </div>

                                        <div class="clearfix"></div>
                                        <br><br>
                                        <div class="well well-sm"><strong>Emergency Information</strong></div>

                                        <div class="col-md-6 col-xs-12">
                                            <div class="form-group ">
                                                <label class="control-label" for="co_emergency_disp">First Responder</label>
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

                                            </div>
                                        </div>
                                        <?php 
                                        if($emergency_name!="")
                                        {
                                        ?>
                                        <div class="col-md-6 col-xs-12">
                                            <div class="form-group ">
                                                <label class="control-label" for="emergency_name">Emergency Contact Name</label>
                                                <div><?php echo $emergency_name?></div>
                                            </div>
                                        </div>
                                        <?php  
                                        }
                                        if($emergency_badge!="")
                                        {
                                        ?>
                                        <div class="col-md-6 col-xs-12">
                                            <div class="form-group ">
                                                <label class="control-label" for="emergency_badge">Emergency Contact Badge</label>
                                                <div><?php echo $emergency_badge?></div>
                                            </div>
                                        </div>
                                        <?php  
                                        }
                                        if($case_no!="")
                                        {
                                        ?>
                                        <div class="col-md-6 col-xs-12">
                                            <div class="form-group ">
                                                <label class="control-label" for="case_no">Emergency Inspection #</label>
                                                <div><?php echo $case_no?></div>
                                            </div>
                                        </div>
                                        <?php  
                                        }
                                        if($fe_emergency_in!="")
                                        {
                                        ?>
                                        <div class="col-md-6 col-xs-12">
                                            <div class="form-group ">
                                                <label class="control-label" for="fe_emergency_in">Arrival Date</label>
                                                <div><?php echo $fe_emergency_in ?></div>
                                            </div>
                                        </div>
                                        <?php  
                                        }
                                        if($fe_emergency_out!="")
                                        {
                                        ?>
                                        <div class="col-md-6 col-xs-12">
                                            <div class="form-group ">
                                                <label class="control-label" for="fe_emergency_out">Departure Date</label>
                                                <div><?php echo $fe_emergency_out ?></div>
                                            </div>
                                        </div>
                                        <?php 
                                        } 
                                        ?>

                                        <div class="clearfix"></div>



                                            <div class="well well-sm"><strong>Pictures</strong></div>

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

                                                            <div class="col-md-4 col-sm-6 col-xs-12 hero-feature">
                                                                <div class="thumbnail">
                                                                    <img src="<?php echo $ruta_online?>/<?php echo $file;?>" alt="" style="display: block;">
                                                                </div>
                                                            </div>
                                                        <?php
                                                        }
                                                    }
                                                }
                                            }?> 
                                            
                                            <div class="clearfix"></div>
                                            <div class="well well-sm"><strong>Incident Involved</strong></div>
                                            <?php 
                                            if ($rs_prop)
                                            {   $i = 0;
                                            ?>
                                            <div>
                                                <h5><strong>Properties</strong></h5>
                                                <hr>
                                                <table class="table table-hover">
                                                    <thead>
                                                    <tr>
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
                                                                <th><?php echo $prop_dir ?></th>
                                                                <th><?php echo $prop_ciudad ?></th>
                                                                <th><?php echo $prop_state ?></th>
                                                                <th><?php echo $prop_zip ?></th>
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
                                                <h5><strong>Vehicles</strong></h5>
                                                <hr>
                                                <table class="table table-hover">
                                                    <thead>
                                                    <tr>
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
                                                                <th><?php echo $vehic_make ?></th>
                                                                <th><?php echo $vehic_model ?></th>
                                                                <th><?php echo $vehic_ano ?></th>
                                                                <th><?php echo $vehic_tag ?></th>
                                                                <th><?php echo $vehic_color ?></th>
                                                                <th><?php echo $vehic_placa ?></th>
                                                                <th><?php echo $vehic_otro ?></th>
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
                                                <h5><strong>Persons</strong></h5>
                                                <hr>
                                                <table class="table table-hover">
                                                    <thead>
                                                    <tr>
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
                                                                <th><?php echo $person_nb ?></th>
                                                                <th><?php echo $person_dir ?></th>
                                                                <th><?php echo $person_telf ?></th>
                                                                <th><?php echo $person_age ?></th>
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
                                                <h5><strong>Witness</strong></h5>
                                                <hr>                                            
                                                <table class="table table-hover">
                                                    <thead>
                                                    <tr>
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
                                                                <th><?php echo $witness_nb ?></th>
                                                                <th><?php echo $witness_dir ?></th>
                                                                <th><?php echo $witness_telf ?></th>
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
                                        </div>
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                            </form>



                            </div>

                        </div>
                    </div>
                </div>
            </div>
            
            <footer>
                <div class="col-md-12">
                    <p >
                        <?php echo $footer_incident ?>
                    </p>
                </div>
                <div class="clearfix"></div>
            </footer>


            </div>
            <!-- /page content -->
        </div>



    <!-- dropzone -->
</body>

</html>
<?php

ob_end_flush();

?>