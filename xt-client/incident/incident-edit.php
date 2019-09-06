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


require('../includes/header.php');

$codigo = getA("co");
$co_acc = getA("co_acc");

$tit1 = "Incidents";
$tit2 = "Edit Incident";
$url1 = "incident-list.php?co_acc=$co_acc";
$url2 = "incident-edit.php?co_acc=$co_acc&co=$codigo";
?>

<body class="nav-md">

    <div class="container body">


        <div class="main_container">

            <div class="col-md-3 left_col">
                <?php include '../includes/menu.php'; ?>
            </div>

            <!-- top navigation -->
                <?php include '../includes/top-menu.php'; ?>
            <!-- /top navigation -->


            <!-- page content -->
            <div class="right_col" role="main">

                <div class="page-title">
                    <div class="title_left">
                        <h3><a href="<?php echo $url1?>" class="btn btn-default"><?php echo $tit1 ?></a>/ <?php echo $tit2 ?></h3>
                    </div>

                </div>
                <div class="clearfix"></div>

                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="x_panel">
                        <?php  
                        $rs_incident = $incident->valIncidentClient($db,$codigo,$_SESSION["coduser"]["co"]);
                        if($rs_incident) 
                        {?>
                            <!--****************************************************************-->
                            <div class="x_title">
                                <h2>Form <small> </small></h2>
                                 <a href="incident-edit-print.php?co=<?php echo $codigo ?>" target="_blank" class="btn btn-default pull-right"><i class="fa fa-print"></i> Print</a>
                                <div class="clearfix"></div>
                            </div>
                            <!--****************************************************************-->

                            <div class="x_content">
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
                                    <div class="col-md-12">
                                        <p >
                                            <?php echo html_entity_decode($footer_incident) ?>
                                        </p>
                                    </div>
                                    <div class="clearfix"></div>
                                </page>



                            </div>
                            <?php 
                            } else { ?>
                                <h4>You don't have permissions to see this information.</h4>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>

                <!-- footer content -->
                    <?php include '../includes/footer.php'; ?>
                <!-- /footer content -->

            </div>
            <!-- /page content -->
        </div>



    <?php
    include '../includes/bot-footer.php';
    ?>
    <!-- dropzone -->
    <script src="../js/dropzone/dropzone.js"></script>

    <script type="text/javascript" src="../../bower_components/moment/min/moment.min.js"></script>
    <script type="text/javascript" src="../../bower_components/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>
    <link rel="stylesheet" href="../../bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css" />
    <script src="../ckeditor/ckeditor.js" type="text/javascript"></script>
    <script type="text/javascript">

        $(function () {
            $('#datetimepicker1').datetimepicker({  widgetPositioning: { horizontal:'right' }  });
            $('#datetimepicker2').datetimepicker({  widgetPositioning: { horizontal:'right' }  });
            $('#datetimepicker3').datetimepicker({  widgetPositioning: { horizontal:'right' }  });
        });

        $(document).ready(function () {
            CKEDITOR.replace( 'ds' );

            $('#r_co_emergency').change(function () {
                if (parseInt($('#r_co_emergency').val()) == 999)
                    $('#demergency_otro').show();
                else
                    $('#demergency_otro').hide();
            });

            Dropzone.autoDiscover = false;
            var myDropzone = new Dropzone("#dropzone",{
                url: "upload.php",
                addRemoveLinks: true,
                dictDefaultMessage:"Drop files here or click",
                dictInvalidFileType:"Invalid file type",
                dictRemoveFile:"Remove File",
                maxFiles:20,
                thumbnailWidth:310,
                thumbnailHeight:203,
                maxFileSize: 10000,
                dictResponseError: "There has benn an error on server",
                acceptedFiles: 'image/*,.jpeg,.jpg,.png,.gif,.JPEG,.JPG,.PNG,.GIF',
                init: function()
                {
                    $.getJSON('upload.php?opc=list&_dir=<?php echo $_dir?>', function(data) {
                        $.each(data, function(index, val) {
                            var mockFile = { name: val.name, size: val.size };
                            myDropzone.options.addedfile.call(myDropzone, mockFile);
                            myDropzone.options.thumbnail.call(myDropzone, mockFile, "../../images/incidents/<?php echo $_dir?>/" + val.name);
                            mockFile.previewElement.classList.add('dz-success');
                            mockFile.previewElement.classList.add('dz-complete');
                        });
                    });
                    //this.on("addedfile", function(file) { alert("Added file."); });
                },
                error: function(file)
                {
                    alert("Error, can not upload the file " + file.name);
                },
                sending: function(file, xhr, formData) {
                    formData.append("_dir", "<?php echo $_dir ?>");
                },
                removedfile: function(file, serverFileName)
                {
                    var name = file.name;
                    $.ajax({
                        type: "POST",
                        url: "upload.php?opc=delete",
                        data: "filename="+name+"&_dir=<?php echo $_dir ?>",
                        success: function(data)
                        {
                            var json = JSON.parse(data);
                            if(json.res == true)
                            {       var element;
                                (element = file.previewElement) != null ?
                                    element.parentNode.removeChild(file.previewElement) :
                                    false;
                            }
                        }
                    });
                }
            });
        });

        function addProp()
        {   var i = parseInt($('#propnum').val()) + 1;
            var prop_dir = $('#prop_dir').val();
            var prop_ciudad = $('#prop_ciudad').val();
            var prop_state = $('#point_long').val();
            var prop_zip = $('#prop_zip').val();

            $('#propnum').val(i);

            $("#addProp").append('<tr id="prop_'+i+'"><th><input type="text" class="form-control" name="prop_dir_'+i+'" id="prop_dir_'+i+'" maxlength="255"></th><th><input type="text" class="form-control" name="prop_ciudad_'+i+'" id="prop_ciudad_'+i+'" maxlength="50"></th><th><input type="text" class="form-control" name="prop_state_'+i+'" id="prop_state_'+i+'" maxlength="50"></th><th><input type="text" class="form-control" name="prop_zip_'+i+'" id="prop_zip_'+i+'" maxlength="10"></th><th><a href="javascript:delInvolved(\'prop_'+i+'\')" class="btn btn-danger"><i class="fa fa-trash"></i> Del</a></th></tr>');

        }

        function addVehic()
        {   var i = parseInt($('#vehicnum').val()) + 1;
            var vehic_make = $('#vehic_make').val();
            var vehic_model = $('#vehic_model').val();
            var vehic_ano = $('#vehic_ano').val();
            var vehic_tag = $('#vehic_tag').val();
            var vehic_color = $('#vehic_color').val();
            var vehic_placa = $('#vehic_placa').val();
            var vehic_otro = $('#vehic_otro').val();

            $('#vehicnum').val(i);

            $("#addVehic").append('<tr id="vehic_'+i+'"><th><input type="text" class="form-control" name="vehic_make_'+i+'" id="vahic_make_'+i+'" maxlength="50"></th><th><input type="text" class="form-control" name="vehic_model_'+i+'" id="vehic_model_'+i+'" maxlength="50"></th><th><input type="text" class="form-control" name="vehic_ano_'+i+'" id="vehic_ano_'+i+'" maxlength="4"></th><th><input type="text" class="form-control" name="vehic_tag_'+i+'" id="vehic_tag_'+i+'" maxlength="50"></th><th><input type="text" class="form-control" name="vehic_color_'+i+'" id="vehic_color_'+i+'" maxlength="50"></th><th><input type="text" class="form-control" name="vehic_placa_'+i+'" id="vehic_placa_'+i+'" maxlength="50"></th><th><input type="text" class="form-control" name="vehic_otro_'+i+'" id="vehic_otro_'+i+'" maxlength="50"></th><th><a href="javascript:delInvolved(\'vehic_'+i+'\')" class="btn btn-danger"><i class="fa fa-trash"></i> Del</a></th></tr>');

        }

        function addPerson()
        {   var i = parseInt($('#personnum').val()) + 1;
            var person_nb = $('#person_nb').val();
            var person_dir = $('#person_dir').val();
            var person_telf = $('#person_telf').val();
            var person_age = $('#person_age').val();

            $('#personnum').val(i);

            $("#addPerson").append('<tr id="person_'+i+'"><th><input type="text" class="form-control" name="person_nb_'+i+'" id="person_nb_'+i+'" maxlength="50"></th><th><input type="text" class="form-control" name="person_dir_'+i+'" id="person_dir_'+i+'" maxlength="255"></th><th><input type="text" class="form-control" name="person_telf_'+i+'" id="person_telf_'+i+'" maxlength="50"></th><th><input type="text" class="form-control" name="person_age_'+i+'" id="person_age_'+i+'" maxlength="50"></th><th><a href="javascript:delInvolved(\'person_'+i+'\')" class="btn btn-danger"><i class="fa fa-trash"></i> Del</a></th></tr>');

        }

        function addWitness()
        {   var i = parseInt($('#witnessnum').val()) + 1;
            var witness_nb = $('#witness_nb').val();
            var witness_dir = $('#witness_dir').val();
            var witness_telf = $('#witness_telf').val();

            $('#witnessnum').val(i);

            $("#addWitness").append('<tr id="witness_'+i+'"><th><input type="text" class="form-control" name="witness_nb_'+i+'" id="witness_nb_'+i+'" maxlength="50"></th><th><input type="text" class="form-control" name="witness_dir_'+i+'" id="witness_dir_'+i+'" maxlength="255"></th><th><input type="text" class="form-control" name="witness_telf_'+i+'" id="witness_telf_'+i+'" maxlength="50"></th><th><a href="javascript:delInvolved(\'witness_'+i+'\')" class="btn btn-danger"><i class="fa fa-trash"></i> Del</a></th></tr>');

        }

        function delInvolved(puntodel)
        {
            $("#"+puntodel).remove();
        }

    </script>
</body>

</html>