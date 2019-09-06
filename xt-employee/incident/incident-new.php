<?php
require_once("../../lib/core.php");
require_once("../../lib/val_session_employee.php");
require_once('../../xt-model/IncidentModel.php');
require_once('../../xt-model/IncidentTypeModel.php');
require_once('../../xt-model/PostModel.php');
require_once('../../xt-model/MensajeModel.php');

$mensaje = new MensajeModel();
$incident = new IncidentModel();
$incidenttype = new IncidenttypeModel();
$post = new PostModel();

$_dir = GUID();

require('../includes/header.php');

$co_acc = getA("co_acc");

$tit1 = "Incidents";
$tit2 = "New Incident";
$url1 = "incident-list.php?co_acc=$co_acc";
$url2 = "incident-new.php?co_acc=$co_acc";
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
                        <h3><a href="../main/findex.php" class="btn btn-default">Main</a> / <a href="<?php echo $url1?>" class="btn btn-default"><?php echo $tit1 ?></a> / <?php echo $tit2 ?></h3>
                    </div>

                </div>
                <div class="clearfix"></div>

                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="x_panel">

                            <div class="x_content">

                                <?php
                                if(isset($_REQUEST["acc"]))
                                {
                                    if(getA("acc")=="ing")
                                    {
                                        $result = $incident->ingresar($db,
                                            [
                                                "ds_dir"=>getA("_dir"),
                                                "propnum"=>getA("propnum"),
                                                "vehicnum"=>getA("vehicnum"),
                                                "personnum"=>getA("personnum"),
                                                "witnessnum"=>getA("witnessnum"),
                                                "co_incident_type"=>getA("r_co_incident_type"),
                                                "co_incident_stat"=>"1",
                                                "co_post"=>getA("r_co_post"),
                                                "fe_incident"=>todate_hr(getA("r_fe_incident")),
                                                "co_employee"=>$_SESSION["codemployee"]["co"],
                                                "victim_name"=>getA("victim_name"),
                                                "victim_telf"=>getA("victim_telf"),
                                                "victim_dir"=>getA("victim_dir"),
                                                "ds"=>getA("ds"),
                                                "co_emergency"=>getA("co_emergency_disp"),
                                                "emergency_other"=>getA("emergency_other"),
                                                "emergency_name"=>getA("emergency_name"),
                                                "emergency_badge"=>getA("emergency_badge"),
                                                "case_no"=>getA("case_no"),
                                                "fe_emergency_in"=>todate_hr(getA("fe_emergency_in")),
                                                "fe_emergency_out"=>todate_hr(getA("fe_emergency_out"))], $_REQUEST
                                        );

                                        if($result)
                                        {
                                            echo $mensaje->MensajeRegistro(1,"Record created successfully");
                                            ?>
                                            <script>
                                            $.ajax({
                                                type: "POST",
                                                url: "mail-incident-edit.php",
                                                data: "co=<?php echo $result ?>",
                                                success: function(data)
                                                {data=data;
                                                }
                                            });
                                            </script>

                                            <?php                                            
                                        }
                                        else
                                            echo $mensaje->MensajeRegistro(2,"Sorry an error has ocurrred");

                                    }
                                }

                                ?>

                                <form role="form" action="<?php echo $url2;?>" method="post" name="forma" id="forma">
                                    <input type="hidden" id="_dir" name="_dir" value="<?php echo $_dir?>" >
                                    <input type="hidden" id="propnum" name="propnum" value="0" >
                                    <input type="hidden" id="vehicnum" name="vehicnum" value="0" >
                                    <input type="hidden" id="personnum" name="personnum" value="0" >
                                    <input type="hidden" id="witnessnum" name="witnessnum" value="0" >
                                    <div class="" role="tabpanel" data-example-id="togglable-tabs">
                                        <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
                                            <li role="presentation" class="active"><a href="#tab_content1" id="home-tab" role="tab" data-toggle="tab" aria-expanded="true">General</a>
                                            </li>
                                            <li role="presentation" class=""><a href="#tab_content2" role="tab" id="profile-tab" data-toggle="tab" aria-expanded="false"><i class="fa fa-camera"></i> Pictures</a>
                                            </li>
                                            <li role="presentation" class=""><a href="#tab_content3" role="tab" id="profile-tab" data-toggle="tab" aria-expanded="false">Details</a>
                                            </li>
                                        </ul>
                                        <div id="myTabContent" class="tab-content">
                                            <div role="tabpanel" class="tab-pane fade active in" id="tab_content1" aria-labelledby="home-tab">

                                                <div class="col-md-6 col-xs-12">
                                                    <div class="form-group ">
                                                        <label class="control-label" for="r_co_incident_type">Incident Type</label>
                                                        <select name="r_co_incident_type" class="form-control" id="r_co_incident_type">
                                                            <option value="" selected>Select</option>
                                                            <?php
                                                            $rs = $incidenttype->listarActivos($db);

                                                            foreach($rs as $rss)
                                                            {
                                                                extract($rss);
                                                                ?>
                                                                <option value="<?php echo $co ?>"><?php echo $nb ?></option>
                                                                <?php
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-xs-12">
                                                    <div class="form-group ">
                                                        <label class="control-label" for="r_co_post">Post</label>
                                                        <select name="r_co_post" class="form-control" id="r_co_post">
                                                            <option value="" selected>Select</option>
                                                            <?php
                                                            $rs = $post->listarActivos($db);

                                                            foreach($rs as $rss)
                                                            {
                                                                extract($rss);
                                                                ?>
                                                                <option value="<?php echo $co ?>"><?php echo $nb ?></option>
                                                                <?php
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-xs-12">
                                                    <div class="form-group ">
                                                        <label class="control-label" for="r_fe_incident">Incident Date</label>
                                                        <div class='input-group date' id='datetimepicker1'>
                                                            <input type='text' class="form-control" value="<?php echo date("m/d/Y g:i A"); ?>" name="r_fe_incident" id="r_fe_incident" />
                                                                <span class="input-group-addon">
                                                                    <span class="glyphicon glyphicon-calendar"></span>
                                                                </span>
                                                        </div>

                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-xs-12">
                                                    <div class="form-group ">
                                                        <label class="control-label" for="victim_name">Victim / Owner Name</label>
                                                        <input type="text" class="form-control" name="victim_name" id="victim_name" placeholder="Victim / Owner Name" maxlength="50">
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-xs-12">
                                                    <div class="form-group ">
                                                        <label class="control-label" for="victim_telf">Victim / Owner Phone</label>
                                                        <input type="text" class="form-control" name="victim_telf" id="victim_telf" placeholder="Input Victim / Owner Phone" maxlength="50">
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-6 col-xs-12">
                                                    <label class="control-label" for="victim_dir">Victim / Owner Address</label>
                                                    <input type="text" class="form-control" name="victim_dir" id="victim_dir" placeholder="Input Victim / Owner Address" maxlength="250">
                                                </div>

                                                <div class="clearfix"></div>

                                                <div class="form-group col-md-12">
                                                    <label class="control-label" for="ds">Description</label>
                                                    <textarea class="form-control" name="ds" id="ds" placeholder="Input Description" ></textarea>
                                                </div>

                                                <div class="clearfix"></div>
                                                <br><br>
                                                <div class="well well-sm"><strong>Emergency Information</strong></div>

                                                <div class="col-md-6 col-xs-12">
                                                    <div class="form-group ">
                                                        <label class="control-label" for="co_emergency_disp">First Responder</label>
                                                        <select name="co_emergency_disp" class="form-control" id="co_emergency_disp">
                                                            <option value="" selected>Select</option>
                                                            <?php
                                                            $rs = $incident->listar_emergencyserv($db);

                                                            foreach($rs as $rss)
                                                            {
                                                                extract($rss);
                                                                ?>
                                                                <option value="<?php echo $co ?>"><?php echo $nb ?></option>
                                                                <?php
                                                            }
                                                            ?>
                                                        </select>
                                                        <div id="demergency_otro" style="display: none">
                                                            <br>
                                                            <input type="text" name="emergency_otro"placeholder="Input Other Emergency Service" class="form-control" name="emergency_otro" maxlength="50">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-xs-12">
                                                    <div class="form-group ">
                                                        <label class="control-label" for="emergency_name">Emergency Contact Name</label>
                                                        <input type="text" class="form-control" name="emergency_name" id="emergency_name" placeholder="Input Emergency Name" maxlength="50">
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-xs-12">
                                                    <div class="form-group ">
                                                        <label class="control-label" for="emergency_badge">Emergency Contact Badge</label>
                                                        <input type="text" class="form-control" name="emergency_badge" id="emergency_badge" placeholder="Input Emergency Badge" maxlength="50">
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-xs-12">
                                                    <div class="form-group ">
                                                        <label class="control-label" for="case_no">Emergency Inspection #</label>
                                                        <input type="text" class="form-control" name="case_no" id="case_no" placeholder="Input Emergency Inspection #" maxlength="50">
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-xs-12">
                                                    <div class="form-group ">
                                                        <label class="control-label" for="fe_emergency_in">Arrival Date</label>
                                                        <div class='input-group date' id='datetimepicker2'>
                                                            <input type='text' class="form-control" name="fe_emergency_in" id="fe_emergency_in" />
                                                                <span class="input-group-addon">
                                                                    <span class="glyphicon glyphicon-calendar"></span>
                                                                </span>
                                                        </div>

                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-xs-12">
                                                    <div class="form-group ">
                                                        <label class="control-label" for="fe_emergency_out">Departure Date</label>
                                                        <div class='input-group date' id='datetimepicker3'>
                                                            <input type='text' class="form-control" name="fe_emergency_out" id="fe_emergency_out" />
                                                                <span class="input-group-addon">
                                                                    <span class="glyphicon glyphicon-calendar"></span>
                                                                </span>
                                                        </div>

                                                    </div>
                                                </div>


                                                <div class="clearfix"></div>


                                            </div>
                                            <div role="tabpanel" class="tab-pane fade in" id="tab_content2" aria-labelledby="home-tab">

                                                <div class="well well-sm"><strong>Select and upload Picture (Touch or click blue area for upload)</strong></div>

                                                <div id="dropzone" class="dropzone">
                                                    <br><br><br><p class="text-center" style="color:#f2f2f2">Touch or Click blue area for Upload</p><br><br>

                                                </div>
                                            </div>
                                            <div role="tabpanel" class="tab-pane fade in" id="tab_content3" aria-labelledby="home-tab">

                                                <div class="well well-sm"><strong>Incident Involved</strong></div>

                                                <div class="bg-success">
                                                    <div class="well well-sm"><strong>Properties</strong></div>
                                                    <div class="col-md-3 col-xs-12">
                                                        <label for="">Address</label>
                                                        <div><input type="text" class="form-control" name="prop_dir_0" id="prop_dir_0" maxlength="255"></div>
                                                    </div>
                                                    <div class="col-md-3 col-xs-12">
                                                        <label for="">City</label>
                                                        <div><input type="text" class="form-control" name="prop_ciudad_0" id="prop_ciudad_0" maxlength="50"></div>
                                                    </div>
                                                    <div class="col-md-3 col-xs-12">
                                                        <label for="">State</label>
                                                        <div><input type="text" class="form-control" name="prop_state_0" id="prop_state_0" maxlength="50"></div>
                                                    </div>
                                                    <div class="col-md-2 col-xs-12">
                                                        <label for="">ZIP</label>
                                                        <div><input type="text" class="form-control" name="prop_zip_0" id="prop_zip_0" maxlength="10"></div>
                                                    </div>
                                                    <div class="col-md-1 col-xs-12">
                                                        <label for="">&nbsp;</label>
                                                        <div><a href="javascript:addProp()" class="btn btn-dark"><i class="fa fa-plus"></i> Add</a></div>
                                                    </div>
                                                    
                                                    <div id="addProp"></div>

                                                    <div class="clearfix"></div>
                                                </div>

                                                <br>

                                                <div class="bg-warning">
                                                    <div class="well well-sm"><strong>Vehicles</strong></div>
                                                    <div class="col-md-2 col-xs-12">
                                                        <label for="">Make</label>
                                                        <div><input type="text" class="form-control" name="vehic_make_0" id="vehic_make_0" maxlength="50"></div>
                                                    </div>
                                                    <div class="col-md-2 col-xs-12">
                                                        <label for="">Model</label>
                                                        <div><input type="text" class="form-control" name="vehic_model_0" id="vehic_model_0" maxlength="50"></div>
                                                    </div>
                                                    <div class="col-md-1 col-xs-12">
                                                        <label for="">Year</label>
                                                        <div><input type="text" class="form-control" name="vehic_ano_0" id="vehic_ano_0" maxlength="4"></div>
                                                    </div>
                                                    <div class="col-md-1 col-xs-12">
                                                        <label for="">TAG</label>
                                                        <div><input type="text" class="form-control" name="vehic_tag_0" id="vehic_tag_0" maxlength="50"></div>
                                                    </div>
                                                    <div class="col-md-2 col-xs-12">
                                                        <label for="">Color</label>
                                                        <div><input type="text" class="form-control" name="vehic_color_0" id="vehic_color_0" maxlength="50"></div>
                                                    </div>
                                                    <div class="col-md-2 col-xs-12">
                                                        <label for="">Plate</label>
                                                        <div><input type="text" class="form-control" name="vehic_placa_0" id="vehic_placa_0" maxlength="50"></div>
                                                    </div>
                                                    <div class="col-md-1 col-xs-12">
                                                        <label for="">Other</label>
                                                        <div><input type="text" class="form-control" name="vehic_otro_0" id="vehic_otro_0" maxlength="50"></div>
                                                    </div>
                                                    <div class="col-md-1 col-xs-12">
                                                        <label for="">&nbsp;</label>
                                                        <div><a href="javascript:addVehic()" class="btn btn-dark"><i class="fa fa-plus"></i> Add</a></div>
                                                    </div>

                                                    <div id="addVehic"></div>

                                                    <div class="clearfix"></div>
                                                </div>

                                                <br>
                                                <div class="bg-info">
                                                    <div class="well well-sm"><strong>Persons</strong></div>
                                                    <div class="col-md-3 col-xs-12">
                                                        <label for="">Name</label>
                                                        <div><input type="text" class="form-control" name="person_nb_0" id="person_nb_0" maxlength="50"></div>
                                                    </div>
                                                    <div class="col-md-3 col-xs-12">
                                                        <label for="">Address</label>
                                                        <div><input type="text" class="form-control" name="person_dir_0" id="person_dir_0" maxlength="255"></div>
                                                    </div>
                                                    <div class="col-md-3 col-xs-12">
                                                        <label for="">Phone</label>
                                                        <div><input type="text" class="form-control" name="person_telf_0" id="person_telf_0" maxlength="50"></div>
                                                    </div>
                                                    <div class="col-md-2 col-xs-12">
                                                        <label for="">Age</label>
                                                        <div><input type="text" class="form-control" name="person_age_0" id="person_age_0" maxlength="4"></div>
                                                    </div>
                                                    <div class="col-md-1 col-xs-12">
                                                        <label for="">&nbsp;</label>
                                                        <div><a href="javascript:addPerson()" class="btn btn-dark"><i class="fa fa-plus"></i> Add</a></div>
                                                    </div>

                                                    <div id="addPerson"></div>

                                                    <div class="clearfix"></div>
                                                </div>

                                                <br>

                                                <div class="bg-success">
                                                    <div class="well well-sm"><strong>Witness</strong></div>
                                                    <div class="col-md-4 col-xs-12">
                                                        <label for="">Name</label>
                                                        <div><input type="text" class="form-control" name="witness_nb_0" id="witness_nb_0" maxlength="50"></div>
                                                    </div>
                                                    <div class="col-md-4 col-xs-12">
                                                        <label for="">Address</label>
                                                        <div><input type="text" class="form-control" name="witness_dir_0" id="witness_dir_0" maxlength="255"></div>
                                                    </div>
                                                    <div class="col-md-3 col-xs-12">
                                                        <label for="">Phone</label>
                                                        <div><input type="text" class="form-control" name="witness_telf_0" id="witness_telf_0" maxlength="50"></div>
                                                    </div>
                                                    <div class="col-md-1 col-xs-12">
                                                        <label for="">&nbsp;</label>
                                                        <div><a href="javascript:addWitness()" class="btn btn-dark"><i class="fa fa-plus"></i> Add</a></div>
                                                    </div>

                                                    <div id="addWitness"></div>

                                                    <div class="clearfix"></div>
                                                </div>

                                                <br>

                                            </div>
                                        </div>
                                    </div>
                                <div class="clearfix"></div>
                                <br>
                                <button type="button" class="btn btn-dark " onclick="javascript:validar(this.form,'ing')">Submit</button>
                                <button type="button" class="btn btn-default load" onclick="javascript:location.href='<?php echo $url1?>'">Back</button>
                            </form>


                            </div>

                        </div>

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
            $("#dropzone").dropzone({
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

            $("#addProp").append('<div id="prop_'+i+'"><div class="col-md-3 col-xs-12"><label for="">Address</label><div><input type="text" class="form-control" name="prop_dir_'+i+'" id="prop_dir_'+i+'" maxlength="255"></div></div><div class="col-md-3 col-xs-12"><label for="">City</label><div><input type="text" class="form-control" name="prop_ciudad_'+i+'" id="prop_ciudad_'+i+'" maxlength="50"></div></div><div class="col-md-3 col-xs-12"><label for="">State</label><div><input type="text" class="form-control" name="prop_state_'+i+'" id="prop_state_'+i+'" maxlength="50"></div></div><div class="col-md-2 col-xs-12"><label for="">ZIP</label><div><input type="text" class="form-control" name="prop_zip_'+i+'" id="prop_zip_'+i+'" maxlength="10"></div></div><div class="col-md-1 col-xs-12"><label for="">&nbsp;</label><div><a href="javascript:delInvolved(\'prop_'+i+'\')" class="btn btn-danger"><i class="fa fa-trash"></i> Del</a></div></div></div>');

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

            $("#addVehic").append('<div id="vehic_'+i+'"><div class="col-md-2 col-xs-12"><label for="">Make</label><div><input type="text" class="form-control" name="vehic_make_'+i+'" id="vehic_make_'+i+'" maxlength="50"></div></div><div class="col-md-2 col-xs-12"><label for="">Model</label><div><input type="text" class="form-control" name="vehic_model_'+i+'" id="vehic_model_'+i+'" maxlength="50"></div></div><div class="col-md-1 col-xs-12"><label for="">Year</label><div><input type="text" class="form-control" name="vehic_ano_'+i+'" id="vehic_ano_'+i+'" maxlength="4"></div></div><div class="col-md-1 col-xs-12"><label for="">TAG</label><div><input type="text" class="form-control" name="vehic_tag_'+i+'" id="vehic_tag_'+i+'" maxlength="50"></div></div><div class="col-md-2 col-xs-12"><label for="">Color</label><div><input type="text" class="form-control" name="vehic_color_'+i+'" id="vehic_color_'+i+'" maxlength="50"></div></div><div class="col-md-2 col-xs-12"><label for="">Plate</label><div><input type="text" class="form-control" name="vehic_placa_'+i+'" id="vehic_placa_'+i+'" maxlength="50"></div></div><div class="col-md-1 col-xs-12"><label for="">Other</label><div><input type="text" class="form-control" name="vehic_otro_'+i+'" id="vehic_otro_'+i+'" maxlength="50"></div></div><div class="col-md-1 col-xs-12"><label for="">&nbsp;</label><div><a href="javascript:delInvolved(\'vehic_'+i+'\')" class="btn btn-danger"><i class="fa fa-trash"></i> Del</a></div></div></div>');

         }

        function addPerson()
        {   var i = parseInt($('#personnum').val()) + 1;
            var person_nb = $('#person_nb').val();
            var person_dir = $('#person_dir').val();
            var person_telf = $('#person_telf').val();
            var person_age = $('#person_age').val();

            $('#personnum').val(i);

            $("#addPerson").append('<div id="person_'+i+'"><div class="col-md-3 col-xs-12"><label for="">Name</label><div><input type="text" class="form-control" name="person_nb_0" id="person_nb_0" maxlength="50"></div></div><div class="col-md-3 col-xs-12"><label for="">Address</label><div><input type="text" class="form-control" name="person_dir_0" id="person_dir_0" maxlength="255"></div></div><div class="col-md-3 col-xs-12"><label for="">Phone</label><div><input type="text" class="form-control" name="person_telf_0" id="person_telf_0" maxlength="50"></div></div><div class="col-md-2 col-xs-12"><label for="">Age</label><div><input type="text" class="form-control" name="person_age_0" id="person_age_0" maxlength="4"></div></div><div class="col-md-1 col-xs-12"><label for="">&nbsp;</label><div><a href="javascript:delInvolved(\'person_'+i+'\')" class="btn btn-danger"><i class="fa fa-trash"></i> Del</a></div></div></div>');


        }

        function addWitness()
        {   var i = parseInt($('#witnessnum').val()) + 1;
            var witness_nb = $('#witness_nb').val();
            var witness_dir = $('#witness_dir').val();
            var witness_telf = $('#witness_telf').val();

            $('#witnessnum').val(i);

            $("#addWitness").append('<div id="witness_'+i+'"><div class="col-md-4 col-xs-12"><label for="">Name</label><div><input type="text" class="form-control" name="witness_nb_0" id="witness_nb_0" maxlength="50"></div></div><div class="col-md-4 col-xs-12"><label for="">Address</label><div><input type="text" class="form-control" name="witness_dir_0" id="witness_dir_0" maxlength="255"></div></div><div class="col-md-3 col-xs-12"><label for="">Phone</label><div><input type="text" class="form-control" name="witness_telf_0" id="witness_telf_0" maxlength="50"></div></div><div class="col-md-1 col-xs-12"><label for="">&nbsp;</label><div><a href="javascript:delInvolved(\'witness_'+i+'\')" class="btn btn-danger"><i class="fa fa-trash"></i> Del</a></div></div></div>');

            
        }

        function delInvolved(puntodel)
        {
            $("#"+puntodel).remove();
        }

    </script>

</body>

</html>