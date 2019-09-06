<?php
require_once("../../lib/core.php");
require_once("../../lib/val_session.php");
require_once('../../xt-model/PostModel.php');
require_once('../../xt-model/StateModel.php');
require_once('../../xt-model/IncidentTypeModel.php');
require_once('../../xt-model/MensajeModel.php');

$estado = new StateModel();
$mensaje = new MensajeModel();
$post = new PostModel();
$incidenttpe = new IncidentTypeModel();

$_dir = GUID();

require('../includes/header.php');

$co_acc = getA("co_acc");

$tit1 = "Posts";
$tit2 = "New Post";
$url1 = "post-list.php?co_acc=$co_acc";
$url2 = "post-new.php?co_acc=$co_acc";
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
                            <!--****************************************************************-->
                            <div class="x_title">
                                <h2>Form <small> </small></h2>
                                <div class="clearfix"></div>
                            </div>
                            <!--****************************************************************-->

                            <div class="x_content">

                                <?php
                                if(isset($_REQUEST["acc"]))
                                {
                                    if(getA("acc")=="ing")
                                    {
                                        $result = $post->ingresar($db,
                                            [
                                                "ds_id"=>getA("r_ds_id"),
                                                "ds_dir"=>getA("_dir"),
                                                "corr_daily_log"=>getA("corr_daily_log"),
                                                "gpsnum"=>getA("gpsnum"),
                                                "geonum"=>getA("geonum"),
                                                "nb"=>getA("r_nb"),
                                                "industria"=>getA("r_industria"),
                                                "dir"=>getA("r_dir"),
                                                "ciudad"=>getA("r_ciudad"),
                                                "co_state"=>getA("r_co_state"),
                                                "ds_zip"=>getA("r_ds_zip"),
                                                "nb_contact"=>getA("r_nb_cont"),
                                                "title"=>getA("r_title"),
                                                "corr"=>getA("r_correo"),
                                                "telf_casa"=>getA("telf_casa"),
                                                "telf_cel"=>getA("telf_mobile"),
                                                "telf_fax"=>getA("fax"),
                                                "nb_contact_other"=>getA("nb_contact_other"),
                                                "title_other"=>getA("title_other"),
                                                "telf_contact_other"=>getA("telf_contact_other"),
                                                "actv"=>check(getA("activo"))], $_REQUEST
                                        );

                                        if($result)
                                            echo $mensaje->MensajeRegistro(1,"Record created successfully");
                                        else
                                            echo $mensaje->MensajeRegistro(2,"Sorry an error has ocurrred");

                                    }
                                }

                                ?>

                                <form role="form" action="<?php echo $url2;?>" method="post" name="forma" id="forma" enctype="multipart/form-data">
                                    <input type="hidden" id="_dir" name="_dir" value="<?php echo $_dir?>" >
                                    <input type="hidden" id="geonum" name="geonum" value="0" >
                                    <input type="hidden" id="gpsnum" name="gpsnum" value="0" >
                                    <div class="" role="tabpanel" data-example-id="togglable-tabs">
                                        <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
                                            <li role="presentation" class="active"><a href="#tab_content1" id="home-tab" role="tab" data-toggle="tab" aria-expanded="true">General</a>
                                            </li>
                                            <li role="presentation" class=""><a href="#tab_content2" role="tab" id="profile-tab" data-toggle="tab" aria-expanded="false">Docs</a>
                                            </li>
                                            <li role="presentation" class=""><a href="#tab_content3" role="tab" id="profile-tab" data-toggle="tab" aria-expanded="false"><i class="fa fa-map-marker"></i> GEO Fencing</a>
                                            </li>
                                            <li role="presentation" class=""><a href="#tab_content4" role="tab" id="profile-tab" data-toggle="tab" aria-expanded="false"><i class="fa fa-map-marker"></i> GPS Info</a>
                                            </li>
                                            <li role="presentation" class=""><a href="#tab_content5" role="tab" id="profile-tab" data-toggle="tab" aria-expanded="false"><i class="fa fa-exclamation-circle"></i> Alerts</a>
                                            </li>
                                        </ul>
                                        <div id="myTabContent" class="tab-content">
                                            <div role="tabpanel" class="tab-pane fade active in" id="tab_content1" aria-labelledby="home-tab">

                                                <div class="well well-sm"><strong>Post General Information</strong></div>

                                                <div class="col-md-12">
                                                    <div class="col-md-6">
                                                        <div class="form-group ">
                                                            <label class="control-label" for="r_ds_id">Post ID</label>
                                                            <input type="text" onkeypress="return acceptJustNumber(event)" class="form-control" name="r_ds_id" id="r_ds_id" placeholder="Input Post ID" maxlength="50">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group ">
                                                            <label class="control-label" for="r_nb">Post Name</label>
                                                            <input type="text" class="form-control" name="r_nb" id="r_nb" placeholder="Input Name" maxlength="150">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group ">
                                                            <label class="control-label" for="r_industria">Industry</label>
                                                            <input type="text" class="form-control" name="r_industria" id="r_industria" placeholder="Input Industry" maxlength="70">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group ">
                                                            <label class="control-label" for="r_dir">Address</label>
                                                            <input type="text" class="form-control" name="r_dir" id="r_dir" placeholder="Input Address" maxlength="255">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group ">
                                                            <label class="control-label" for="r_ciudad">City</label>
                                                            <input type="text" class="form-control" name="r_ciudad" id="r_ciudad" placeholder="Input City" maxlength="50">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group ">
                                                            <label class="control-label" for="r_co_state">State</label>
                                                            <select name="r_co_state" class="form-control" id="r_co_state">
                                                                <option value="" selected>Select</option>
                                                                <?php
                                                                $rs = $estado->listar($db);

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
                                                    <div class="col-md-6">
                                                        <div class="form-group ">
                                                            <label class="control-label" for="r_ds_zip">Zip</label>
                                                            <input type="text" class="form-control" name="r_ds_zip" id="r_ds_zip" placeholder="Input Zip" maxlength="5">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group ">
                                                            <label for="activo"><input name="activo" type="checkbox" class="BotonForm2_det" id="activo"> Active</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="clearfix"></div>
                                                <hr>
                                                <div class="well well-sm"><strong>Post Contact Information</strong></div>

                                                <div class="col-md-4">
                                                    <div class="form-group ">
                                                        <label class="control-label" for="r_nb_cont">Contact Name</label>
                                                        <input type="text" class="form-control" name="r_nb_cont" id="r_nb_cont" placeholder="Contact Name" maxlength="50">
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group ">
                                                        <label class="control-label" for="r_title">Title</label>
                                                        <input type="text" class="form-control" name="r_title" id="r_title" placeholder="Input Title" maxlength="50">
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group ">
                                                        <label class="control-label" for="r_correo">Email</label>
                                                        <input type="email" class="form-control" name="r_correo" id="r_correo" placeholder="Input Email" maxlength="150" onBlur="javascript:validaemail2('forma','r_correo')">
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group ">
                                                        <label class="control-label" for="telf_casa">Phone (Home)</label>
                                                        <input type="text" class="form-control" name="telf_casa" id="telf_casa" placeholder="Input Phone (Home)" maxlength="50">
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group ">
                                                        <label class="control-label" for="telf_mobile">Phone (Mobile)</label>
                                                        <input type="text" class="form-control" name="telf_mobile" id="telf_mobile" placeholder="Input Phone (Mobile)" maxlength="50">
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group ">
                                                        <label class="control-label" for="fax">FAX</label>
                                                        <input type="text" class="form-control" name="fax" id="fax" placeholder="Input FAX" maxlength="50">
                                                    </div>
                                                </div>
                                                <div class="clearfix"></div>
                                                <br>
                                                <div class="well well-sm"><strong>Other Contact Information</strong></div>

                                                <div class="col-md-4">
                                                    <div class="form-group ">
                                                        <label class="control-label" for="nb_contact_other">Contact Name</label>
                                                        <input type="text" class="form-control" name="nb_contact_other" id="nb_contact_other" placeholder="Input Name" maxlength="50">
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group ">
                                                        <label class="control-label" for="title_other">Title</label>
                                                        <input type="text" class="form-control" name="title_other" id="title_other" placeholder="Input Title" maxlength="50">
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group ">
                                                        <label class="control-label" for="telf_contact_other">Phone</label>
                                                        <input type="text" class="form-control" name="telf_contact_other" id="telf_contact_other" placeholder="Input Phone (Contact)" maxlength="50">
                                                    </div>
                                                </div>
                                                <div class="clearfix"></div>

                                            </div>


                                            <div role="tabpanel" class="tab-pane fade" id="tab_content2" aria-labelledby="profile-tab">
                                                <div class="well well-sm"><strong>Select and upload Documents</strong></div>

                                                <div id="dropzone" class="dropzone">

                                                </div>
                                                <div class="clearfix"></div>
                                                <br>
                                            </div>


                                            <div role="tabpanel" class="tab-pane fade" id="tab_content3" aria-labelledby="profile-tab">
                                                <br>
                                                <div class="well well-sm"><strong>GEO Fencing Points List</strong><div class="pull-right"><a href="https://maps.google.com/" target="_blank">Google Map</a></div></div>

                                                <div class="alert alert-warning" role="alert">The System takes the first point as the last point to close the polygon. (Clock wise)</div>

                                                
                                                <table class="table table-hover">
                                                    <thead>
                                                    <tr>
                                                        <th>Latitude</th>
                                                        <th>Longitude</th>
                                                        <th>Action</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody id="addGEOPoints">
                                                    <tr>
                                                        <th><input type="text" class="form-control" name="geo_point_lat_0" id="point_lat_0" maxlength="50"></th>
                                                        <th><input type="text" class="form-control" name="geo_point_log_0" id="point_log_0" maxlength="50"></th>
                                                        <th><a href="javascript:addGEOPoints()" class="btn btn-dark"><i class="fa fa-plus"></i> Add</a></th>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </div>


                                            <div role="tabpanel" class="tab-pane fade" id="tab_content4" aria-labelledby="profile-tab">
                                                <br>
                                                <div class="well well-sm"><strong>Check Points List</strong></div>
                                                <table class="table table-hover">
                                                    <thead>
                                                    <tr>
                                                        <th style="width: 55px;">#</th>
                                                        <th>Name</th>
                                                        <th>Latitude</th>
                                                        <th>Longitude</th>
                                                        <th width="90">Status</th>
                                                        <th>Action</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody id="addPoints">
                                                    <tr>
                                                        <th><input type="text" class="form-control" name="point_pos_0" id="point_pos_0" maxlength="4" style="width: 55px;"></th>
                                                        <th><input type="text" class="form-control" name="point_name_0" id="point_name_0" maxlength="50"></th>
                                                        <th><input type="text" class="form-control" name="point_lat_0" id="point_lat_0" maxlength="50"></th>
                                                        <th><input type="text" class="form-control" name="point_log_0" id="point_log_0" maxlength="50"></th>
                                                        <th><input type="checkbox" class="BotonForm2_det" name="point_activo_0" id="point_activo_0" checked="checked"> Active</th>
                                                        <th><a href="javascript:addChkPoints()" class="btn btn-dark"><i class="fa fa-plus"></i> Add</a></th>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </div>



                                            <div role="tabpanel" class="tab-pane fade" id="tab_content5" aria-labelledby="profile-tab">
                                                <div class=" well-sm alert-warning"><strong>Incident Types Alerts</strong></div>
                                                <table class="table table-striped">
                                                    <thead>
                                                    <tr>
                                                        <th>Incident Type</th>
                                                        <th>Emails (Comma Separated)</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody id="addPoints">
                                                    <?php
                                                    $rs = $incidenttpe->listarActivos($db);

                                                    foreach($rs as $rss)
                                                    {
                                                        extract($rss);
                                                        ?>
                                                        <tr>
                                                            <th><?php echo $nb ?> </th>
                                                            <th><textarea name="corr_<?php echo $co ?>" id="corr_<?php echo $co ?>" class="form-control" rows="2"></textarea> </th>
                                                        </tr>
                                                    <?php 
                                                    }
                                                    ?>
                                                    </tbody>
                                                    </table>
                                                <div class="clearfix"></div>
                                                <br>
                                                <div class=" well-sm alert-warning"><strong>Daily Log Alerts</strong></div>
                                                <br>
                                                <textarea class="form-control" name="corr_daily_log" id="corr_daily_log" placeholder="Input Emails comma separated"></textarea>

                                            </div>


                                        </div>
                                    </div>
                                    <div class="clearfix"></div>
                                    <br>
                                    <hr>
                                    <br>
                                    <?php echo putBotonAccion($db,  $co_acc,1,''); ?>
                                    <button type="button" class="btn btn-default" onclick="javascript:location.href='<?php echo $url1?>'">Back</button>
                                </form>



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
    <!-- ... -->
    <script src="../js/dropzone/dropzone.js"></script>
    <script type="text/javascript" src="../../bower_components/moment/min/moment.min.js"></script>
    <script type="text/javascript" src="../../bower_components/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>
    <link rel="stylesheet" href="../../bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css" />
    <script src="../../lib/jquery.maskedinput-1.2.2.js" type="text/javascript"></script>
    <script type="text/javascript">


        function cargaesto(objeto)
        {
            $("#"+objeto).datetimepicker({ format: 'LT', widgetPositioning: { horizontal:'right' }  });
        }


    $(document).ready(function () {
        $("#telf_contact_other").mask("999-999-9999");
        $("#telf_casa").mask("999-999-9999");
        $("#telf_mobile").mask("999-999-9999");
        $("#fax").mask("999-999-9999");

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
            acceptedFiles: 'image/*,.jpeg,.jpg,.png,.gif,.JPEG,.JPG,.PNG,.GIF,.PDF,.DOC',
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


    function addChkPoints()
    {   var i = parseInt($('#gpsnum').val()) + 1;
        var point_name = $('#point_name').val();
        var point_lat = $('#point_lat').val();
        var point_long = $('#point_long').val();

        $('#gpsnum').val(i);


        $("#addPoints").append('<tr id="point_'+i+'"><th><input type="text" class="form-control" name="point_pos_'+i+'" id="point_pos_'+i+'" maxlength="4" style="width: 55px;"></th><th><input type="text" class="form-control" name="point_name_'+i+'" id="point_name_'+i+'" maxlength="50"></th><th><input type="text" class="form-control" name="point_lat_'+i+'" id="point_lat_'+i+'" maxlength="50"></th><th><input type="text" class="form-control" name="point_log_'+i+'" id="point_log_'+i+'" maxlength="50"></th><th><input type="checkbox" class="BotonForm2_det" name="point_activo_'+i+'" id="point_activo_'+i+'" checked="checked"> Active</th><th><a href="javascript:delPoint(\'point_'+i+'\')" class="btn btn-danger"><i class="fa fa-trash"></i> Del</a></th></tr>   ');

    }

    function addGEOPoints()
    {   
        var i = parseInt($('#geonum').val()) + 1;
        var point_lat = $('#geo_point_lat').val();
        var point_long = $('#geo_point_long').val();

        $('#geonum').val(i);


        $("#addGEOPoints").append('<tr id="geopoint_'+i+'"><th><input type="text" class="form-control" name="geo_point_lat_'+i+'" id="geo_point_lat_'+i+'" maxlength="50"></th><th><input type="text" class="form-control" name="geo_point_log_'+i+'" id="geo_point_log_'+i+'" maxlength="50"></th><th><a href="javascript:delPoint(\'geopoint_'+i+'\')" class="btn btn-danger"><i class="fa fa-trash"></i> Del</a></th></tr>   ');

    }

    function delPoint(puntodel)
    {
        $("#"+puntodel).remove();
    }
</script>
</body>

</html>