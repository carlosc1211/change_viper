<?php
require_once("../../lib/core.php");
require_once("../../lib/val_session.php");
require_once('../../xt-model/PostModel.php');
require_once('../../xt-model/StateModel.php');
require_once('../../xt-model/MensajeModel.php');

$estado = new StateModel();
$mensaje = new MensajeModel();
$post = new PostModel();

require('../includes/header.php');

$codigo = getA("co");
$co_acc = getA("co_acc");

$tit1 = "Posts";
$tit2 = "Edit Post";
$url1 = "post-list.php?co_acc=$co_acc";
$url2 = "post-edit.php?co_acc=$co_acc&co=$codigo";
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
                                 <a href="post-edit-print.php?co=<?php echo $codigo ?>" target="_blank" class="btn btn-default pull-right"><i class="fa fa-print"></i> Print</a>
                                <div class="clearfix"></div>
                            </div>
                            <!--****************************************************************-->

                            <div class="x_content">

                                <?php

                                if(isset($_REQUEST["acc"]))
                                {
                                    if(getA("acc")=="ing")
                                    {
                                        $result = $post->actualizar($db,
                                            [
                                                "co"=>$codigo,
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
                                            echo $mensaje->MensajeRegistro(1,"Record updated successfully");
                                        else
                                            echo $mensaje->MensajeRegistro(2,"Sorry an error has ocurrred");
                                    }
                                    elseif(getA("acc")=="elim")
                                    {
                                        $result = $post->eliminar($db,["co"=>$codigo]);

                                        if($result)
                                            echo $mensaje->MensajeRegistro(1,"Record deleted successfully");
                                        else
                                            echo $mensaje->MensajeRegistro(2,"Sorry an error has ocurrred");

                                        ?>
                                        <script>
                                        var redirectTimeout = setTimeout( function() { window.location = '<?php echo $url1?>'; }, 3000 );
                                        </script>
                                        <?php
                                    }
                                }

                                $rs = $post->obtener($db,$codigo);
                                $rs_point = $post->obtener_point($db,$codigo);
                                $rs_geopoint = $post->obtener_geopoint($db,$codigo);
                                $rs_gpsnum = $post->obtener_gpsnum($db,$codigo);
                                $rs_geonum = $post->obtener_geonum($db,$codigo);

                                if($rs) extract($rs[0]);
                                if($rs_gpsnum) extract($rs_gpsnum[0]);
                                if($rs_geonum) extract($rs_geonum[0]);

                                $_dir = $ds_dir;

                                ?>

                                <form role="form" action="<?php echo $url2;?>" method="post" name="forma" id="forma">
                                    <input type="hidden" id="_dir" name="_dir" value="<?php echo $_dir?>" >
                                    <input type="hidden" id="geonum" name="geonum" value="<?php echo $geonum?>" >
                                    <input type="hidden" id="gpsnum" name="gpsnum" value="<?php echo $gpsnum?>" >
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
                                                            <input type="text" onkeypress="return acceptJustNumber(event)" class="form-control" name="r_ds_id" id="r_ds_id" value="<?php echo $ds_id?>" placeholder="Input Post ID" maxlength="50">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group ">
                                                            <label class="control-label" for="r_nb">Post Name</label>
                                                            <input type="text" class="form-control" name="r_nb" id="r_nb" value="<?php echo $nb?>" placeholder="Input Name" maxlength="150">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group ">
                                                            <label class="control-label" for="r_industria">Industry</label>
                                                            <input type="text" class="form-control" name="r_industria" id="r_industria" value="<?php echo $ds_industria?>" placeholder="Input Industry" maxlength="70">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group ">
                                                            <label class="control-label" for="r_dir">Address</label>
                                                            <input type="text" class="form-control" name="r_dir" id="r_dir" placeholder="Input Address" maxlength="255" value="<?php echo $dir?>">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group ">
                                                            <label class="control-label" for="r_ciudad">City</label>
                                                            <input type="text" class="form-control" name="r_ciudad" id="r_ciudad" value="<?php echo $ciudad?>" placeholder="Input City" maxlength="50">
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
                                                                    <option value="<?php echo $co ?>" <?php if($co==$co_state) echo "selected" ?>><?php echo $nb ?></option>
                                                                    <?php
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group ">
                                                            <label class="control-label" for="r_ds_zip">Zip</label>
                                                            <input type="text" class="form-control" name="r_ds_zip" id="r_ds_zip" value="<?php echo $ds_zip?>" placeholder="Input Zip" maxlength="5">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group ">
                                                            <label for="activo"><input name="activo" type="checkbox" class="BotonForm2_det" id="activo" <?php echo cheq($actv_post) ?>> Active</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="clearfix"></div>
                                                <hr>
                                                <div class="well well-sm"><strong>Post Contact Information</strong></div>

                                                <div class="col-md-4">
                                                    <div class="form-group ">
                                                        <label class="control-label" for="r_nb_cont">Contact Name</label>
                                                        <input type="text" class="form-control" name="r_nb_cont" id="r_nb_cont" value="<?php echo $nb_contact?>" placeholder="Contact Name" maxlength="50">
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group ">
                                                        <label class="control-label" for="r_title">Title</label>
                                                        <input type="text" class="form-control" name="r_title" id="r_title" value="<?php echo $title?>" placeholder="Input Title" maxlength="50">
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group ">
                                                        <label class="control-label" for="r_correo">Email</label>
                                                        <input type="email" class="form-control" name="r_correo" id="r_correo" value="<?php echo $corr?>" placeholder="Input Email" maxlength="150" onBlur="javascript:validaemail2('forma','r_correo')">
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group ">
                                                        <label class="control-label" for="telf_casa">Phone (Home)</label>
                                                        <input type="text" class="form-control" name="telf_casa" id="telf_casa" value="<?php echo $telf?>" placeholder="Input Phone (Home)" maxlength="50">
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group ">
                                                        <label class="control-label" for="telf_mobile">Phone (Mobile)</label>
                                                        <input type="text" class="form-control" name="telf_mobile" id="telf_mobile" value="<?php echo $telf_cel?>" placeholder="Input Phone (Mobile)" maxlength="50">
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group ">
                                                        <label class="control-label" for="fax">FAX</label>
                                                        <input type="text" class="form-control" name="fax" id="fax" placeholder="Input FAX" value="<?php echo $telf_otro?>" maxlength="50">
                                                    </div>
                                                </div>
                                                <div class="clearfix"></div>
                                                <br>
                                                <div class="well well-sm"><strong>Other Contact Information</strong></div>

                                                <div class="col-md-4">
                                                    <div class="form-group ">
                                                        <label class="control-label" for="nb_contact_other">Contact Name</label>
                                                        <input type="text" class="form-control" name="nb_contact_other" id="nb_contact_other" value="<?php echo $nb_contact_other?>" placeholder="Input Name" maxlength="50">
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group ">
                                                        <label class="control-label" for="title_other">Title</label>
                                                        <input type="text" class="form-control" name="title_other" id="title_other" value="<?php echo $title_other?>" placeholder="Input Title" maxlength="50">
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group ">
                                                        <label class="control-label" for="telf_contact_other">Phone</label>
                                                        <input type="text" class="form-control" name="telf_contact_other" id="telf_contact_other" value="<?php echo $telf_contact_other?>" placeholder="Input Phone (Contact)" maxlength="50">
                                                    </div>
                                                </div>
                                                <div class="clearfix"></div>
                                                <br>

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
                                                <div class="well well-sm" style="height:54px"><strong>GEO Fencing Points List</strong><div class="pull-right">
                                                <a href="https://maps.google.com/" target="_blank"class="btn btn-default pull-right"><i class="fa fa-map-marker"></i> Open Google Map</a>
                                                <a href="geofence-map.php?co_post=<?php echo $codigo ?>" class="btn btn-default pull-right mapson"><i class="fa fa-map-marker"></i> GEO Fence on Google Map</a>
                                                </div></div>
                                                
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
                                                    <?php
                                                    if ($rs_geopoint)
                                                    {   $i = 0;

                                                        foreach($rs_geopoint as $geopoints)
                                                        {
                                                            extract($geopoints);
                                                            ?>
                                                            <tr id="geopoint_<?php echo $i ?>">
                                                                <th><input type="text" class="form-control" name="geo_point_lat_<?php echo $i ?>" id="geo_point_lat_<?php echo $i ?>" maxlength="50" value="<?php echo $latitude ?>"></th>
                                                                <th><input type="text" class="form-control" name="geo_point_log_<?php echo $i ?>" id="geo_point_log_<?php echo $i ?>" maxlength="50" value="<?php echo $longitude ?>"></th>

                                                               <?php if($i==0) { ?>
                                                                    <th style="width:110px">
                                                                        <a href="javascript:addGEOPoints()" class="btn btn-dark btn-xs" data-toggle="tooltip" data-placement="top" title="Add New"><i class="fa fa-plus"></i></a>
                                                                        <a href="post-geopoint-map.php?co_post=<?php echo $codigo ?>&co_point=<?php echo $co ?>" class="btn btn-dark btn-xs iframe" data-toggle="tooltip" data-placement="top" title="View in Map"><i class="fa fa-map-marker"></i></a>
                                                                    </th>
                                                                <?php } else { ?>
                                                                    <th>
                                                                        <a href="javascript:delPoint('geopoint_<?php echo $i ?>')" class="btn btn-danger btn-xs"  data-toggle="tooltip" data-placement="top" title="Delete"><i class="fa fa-trash"></i></a>
                                                                        <a href="post-geopoint-map.php?co_post=<?php echo $codigo ?>&co_point=<?php echo $co ?>" class="btn btn-dark btn-xs iframe" data-toggle="tooltip" data-placement="top" title="View in Map"><i class="fa fa-map-marker"></i></a>
                                                                    </th>
                                                                <?php } ?>                                                                
                                                            </tr>
                                                            <?php
                                                            $i++;
                                                        }
                                                    }
                                                    else
                                                    {
                                                    ?>
                                                        <tr>
                                                            <th><input type="text" class="form-control" name="geo_point_lat_0" id="geo_point_lat_0" maxlength="50"></th>
                                                            <th><input type="text" class="form-control" name="geo_point_log_0" id="geo_point_log_0" maxlength="50"></th>
                                                            <th><a href="javascript:addGEOPoints()" class="btn btn-dark"><i class="fa fa-plus"></i> Add</a></th>
                                                        </tr>
                                                    <?php
                                                    }
                                                    ?>
                                                    </tbody>
                                                </table>
                                            </div>


                                            <div role="tabpanel" class="tab-pane fade" id="tab_content4" aria-labelledby="profile-tab">
                                                <br>
                                                <div class="well well-sm" style="height:54px"><strong>Check Points List</strong> <a href="post-qrcode-print.php?co_post=<?php echo $codigo ?>&gate=0" target="_blank" class="btn btn-default pull-right"><i class="fa fa-print"></i> Print QR Codes List</a></div>
                                                <br>
                                                <a href="post-qrcode-print.php?co_post=<?php echo $codigo ?>&gate=1" target="_blank" class="btn btn-info pull-right qrcode"><i class="fa fa-print"></i> Print Start Point QR Code</a>
                                                <a href="point-map.php?co_post=<?php echo $codigo ?>" class="btn btn-default pull-right mapson"><i class="fa fa-map-marker"></i> Points on Google Map</a>

                                                <br>
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
                                                    <?php
                                                    if ($rs_point)
                                                    {   $i = 0;

                                                        foreach($rs_point as $points)
                                                        {
                                                            extract($points);
                                                            ?>
                                                            <tr id="point_<?php echo $i ?>">
                                                                <th><input type="hidden" name="point_co_<?php echo $i ?>" id="point_co_<?php echo $i ?>" value="<?php echo $co ?>">
                                                                    <input type="text" class="form-control" name="point_pos_<?php echo $i ?>" id="point_pos_<?php echo $i ?>" maxlength="4" value="<?php echo $pos ?>"></th>
                                                                <th><input type="text" class="form-control" name="point_name_<?php echo $i ?>" id="point_name_<?php echo $i ?>" maxlength="50" value="<?php echo $nb ?>"></th>
                                                                <th><input type="text" class="form-control" name="point_lat_<?php echo $i ?>" id="point_lat_<?php echo $i ?>" maxlength="50" value="<?php echo $latitude ?>"></th>
                                                                <th><input type="text" class="form-control" name="point_log_<?php echo $i ?>" id="point_log_<?php echo $i ?>" maxlength="50" value="<?php echo $longitude ?>"></th>
                                                                <th><input type="checkbox" class="BotonForm2_det" name="point_activo_<?php echo $i ?>" id="point_activo_<?php echo $i ?>" <?php echo cheq($actv) ?>> Active</th>
                                                                <?php if($i==0) { ?>
                                                                    <th style="width:110px">
                                                                        <a href="javascript:addChkPoints()" class="btn btn-dark btn-xs" data-toggle="tooltip" data-placement="top" title="Add New"><i class="fa fa-plus"></i></a>
                                                                        <a href="post-qrcode-print-one.php?co_post=<?php echo $codigo ?>&co_point=<?php echo $co ?>&pos_lat_point=<?php echo $latitude ?>&pos_long_point=<?php echo $longitude ?>" class="btn btn-dark btn-xs qrcode" data-toggle="tooltip" data-placement="top" title="Print"><i class="fa fa-print"></i></a>
                                                                        <a href="post-point-map.php?co_post=<?php echo $codigo ?>&co_point=<?php echo $co ?>" class="btn btn-dark btn-xs iframe" data-toggle="tooltip" data-placement="top" title="View in Map"><i class="fa fa-map-marker"></i></a>
                                                                    </th>
                                                                <?php } else { ?>
                                                                    <th>
                                                                        <a href="javascript:delPoint('point_<?php echo $i ?>')" class="btn btn-danger btn-xs"  data-toggle="tooltip" data-placement="top" title="Delete"><i class="fa fa-trash"></i></a>
                                                                        <a href="post-qrcode-print-one.php?co_post=<?php echo $codigo ?>&co_point=<?php echo $co ?>&pos_lat_point=<?php echo $latitude ?>&pos_long_point=<?php echo $longitude ?>" class="btn btn-dark btn-xs qrcode" data-toggle="tooltip" data-placement="top" title="Print"><i class="fa fa-print"></i></a>
                                                                        <a href="post-point-map.php?co_post=<?php echo $codigo ?>&co_point=<?php echo $co ?>" class="btn btn-dark btn-xs iframe" data-toggle="tooltip" data-placement="top" title="View in Map"><i class="fa fa-map-marker"></i></a>
                                                                    </th>
                                                                <?php } ?>
                                                            </tr>
                                                            <?php
                                                            $i++;
                                                        }
                                                    }
                                                    else
                                                    {
                                                    ?>
                                                        <tr>
                                                            <th><input type="text" class="form-control" name="point_pos_0" id="point_pos_0" maxlength="4"></th>
                                                            <th><input type="text" class="form-control" name="point_name_0" id="point_name_0" maxlength="50"></th>
                                                            <th><input type="text" class="form-control" name="point_lat_0" id="point_lat_0" maxlength="50"></th>
                                                            <th><input type="text" class="form-control" name="point_log_0" id="point_log_0" maxlength="50"></th>
                                                            <th><input type="checkbox" class="BotonForm2_det" name="point_activo_0" id="point_activo_0" checked="checked"> Active</th>
                                                            <th><a href="javascript:addChkPoints()" class="btn btn-dark"><i class="fa fa-plus"></i> Add</a></th>
                                                        </tr>
                                                    <?php
                                                    }
                                                    ?>
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
                                                    $rs = $post->obtener_incidentalert($db,$codigo);

                                                    foreach($rs as $rss)
                                                    {
                                                        extract($rss);
                                                        ?>
                                                        <tr>
                                                            <th><?php echo $nb ?> </th>
                                                            <th><textarea name="corr_<?php echo $co ?>" id="corr_<?php echo $co ?>" class="form-control"><?php echo $ds_corr ?></textarea> </th>
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
                                                <textarea class="form-control" name="corr_daily_log" id="corr_daily_log" placeholder="Input Emails comma separated"><?php echo $corr_daily_log ?></textarea>
                                            </div>


                                        </div>
                                    </div>
                                    <div class="clearfix"></div>
                                    <br>
                                    <hr>
                                    <br>
                                    <?php echo putBotonAccion($db,$co_acc,1,''); ?>
                                    <?php echo putBotonAccion($db,$co_acc,3,$tit1); ?>
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

            $(".iframe").colorbox({iframe:true, width:"80%", height:"80%"});
            $(".mapson").colorbox({iframe:true, width:"80%", height:"80%"});
            $(".qrcode").colorbox({iframe:true, width:"30%", height:"80%"});

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
                acceptedFiles: 'image/*,.jpeg,.jpg,.png,.gif,.JPEG,.JPG,.PNG,.GIF,.PDF,.DOC',
                init: function()
                {
                    $.getJSON('upload.php?opc=list&_dir=<?php echo $_dir?>', function(data) {
                        $.each(data, function(index, val) {
                            var mockFile = { name: val.name, size: val.size };
                            myDropzone.options.addedfile.call(myDropzone, mockFile);
                            myDropzone.options.thumbnail.call(myDropzone, mockFile, "../../images/post_docs/<?php echo $_dir?>/" + val.name);
                            mockFile.previewElement.classList.add('dz-success');
                            mockFile.previewElement.classList.add('dz-complete');
                        });
                    });
                    this.on("addedfile", function(file) { alert("Added file."); });
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