<?php
require_once("../../lib/core.php");
require_once("../../lib/val_session.php");
require_once('../../xt-model/MaintenanceModel.php');
require_once('../../xt-model/MaintenanceTypeModel.php');
require_once('../../xt-model/PostModel.php');
require_once('../../xt-model/MensajeModel.php');

$mensaje = new MensajeModel();
$maintenance = new MaintenanceModel();
$maintenancetype = new MaintenanceTypeModel();
$post = new PostModel();

require('../includes/header.php');

$codigo = getA("co");
$co_acc = getA("co_acc");

$tit1 = "Maintenance";
$tit2 = "Edit Maintenance";
$url1 = "maintenance-list.php?co_acc=$co_acc";
$url2 = "maintenance-edit.php?co_acc=$co_acc&co=$codigo";
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
                                        $result = $maintenance->actualizar($db,
                                            [
                                                "co"=>$codigo,
                                                "ds_dir"=>getA("_dir"),
                                                "propnum"=>getA("propnum"),
                                                "title"=>getA("r_title"),
                                                "co_post"=>getA("r_co_post"),
                                                "co_employee"=>$_SESSION["codemployee"]["co"],
                                                "ds"=>getA("ds")
                                            ], $_REQUEST
                                        );


                                        if($result)
                                            echo $mensaje->MensajeRegistro(1,"Record updated successfully");
                                        else
                                            echo $mensaje->MensajeRegistro(2,"Sorry an error has ocurrred");
                                    }
                                    elseif(getA("acc")=="elim")
                                    {
                                        $result = $maintenance->eliminar($db,["co"=>$codigo]);

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


                                $rs_propnum = $maintenance->obtener_propnum($db,$codigo);
                                if($rs_propnum) extract($rs_propnum[0]);


                                $rs_prop = $maintenance->obtener_prop($db,$codigo);

                                $rs = $maintenance->obtener($db,$codigo);

                                if($rs) extract($rs[0]);

                                $_dir = $ds_dir;
                                ?>

                                <form role="form" action="<?php echo $url2;?>" method="post" name="forma" id="forma">
                                    <input type="hidden" id="_dir" name="_dir" value="<?php echo $_dir?>" >
                                    <input type="hidden" id="propnum" name="propnum" value="<?php echo $propnum?>" >
                                    <div class="" role="tabpanel" data-example-id="togglable-tabs">
                                        <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
                                            <li role="presentation" class="active"><a href="#tab_content1" id="home-tab" role="tab" data-toggle="tab" aria-expanded="true">General</a>
                                            </li>
                                            <li role="presentation" class=""><a href="#tab_content2" role="tab" id="profile-tab" data-toggle="tab" aria-expanded="false"><i class="fa fa-camera"></i> Pictures</a>
                                            </li>
                                        </ul>
                                        <div id="myTabContent" class="tab-content">
                                            <div role="tabpanel" class="tab-pane fade active in" id="tab_content1" aria-labelledby="home-tab">
                                                <div class="form-group col-md-6 col-xs-12">
                                                    <label class="control-label" for="r_title">Title</label>
                                                    <input type="text" class="form-control" name="r_title" id="r_title" placeholder="Input Title" maxlength="250" value="<?php echo $nb ?>">
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
                                                                <option value="<?php echo $co ?>" <?php if($co==$co_post) echo "selected" ?>><?php echo $nb ?></option>
                                                                <?php
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="form-group col-md-12">
                                                    <label class="control-label" for="ds">Description</label>
                                                    <textarea class="form-control" name="ds" id="ds" placeholder="Input Description" ><?php echo $ds?></textarea>
                                                </div>

                                                <div class="clearfix"></div>
                                                <br><br>

                                                <div class="bg-success">
                                                    <div class="well well-sm"><strong>Maintenance Type Involved</strong></div>
                                                    <?php
                                                    if ($rs_prop)
                                                    {   $i = 0;

                                                        foreach($rs_prop as $prop_rs)
                                                        {
                                                            extract($prop_rs);
                                                            ?>
                                                            <div id="prop_<?php echo $i ?>">
                                                                <div class="col-md-12 col-xs-12">
                                                                    <label for="">Maintenance Type</label>
                                                                    <select name="maintenance_type_<?php echo $i ?>" class="form-control" id="maintenance_type_<?php echo $i ?>">
                                                                        <option value="" selected>Select</option>
                                                                        <?php
                                                                        $rs = $maintenancetype->listarActivos($db);

                                                                        foreach($rs as $rss)
                                                                        {
                                                                            extract($rss);
                                                                            ?>
                                                                            <option value="<?php echo $co ?>" <?php if($co==$co_maintenance_type) echo "Selected"; ?>><?php echo $nb ?></option>
                                                                            <?php
                                                                        }
                                                                        ?>
                                                                    </select>
                                                                </div>
                                                                <div class="col-md-12 col-xs-12">
                                                                    <label for="">Description</label>
                                                                    <div><textarea class="form-control" name="prop_ds_<?php echo $i ?>" id="prop_ds_<?php echo $i ?>" ><?php echo $ds ?></textarea></div>
                                                                </div>

                                                                <div class="clearfix"></div>
                                                                <br>  

                                                                <div class="pull-right">
                                                                    <label for="">&nbsp;</label>
                                                                    <?php if($i==0) { ?>
                                                                        <div><a href="javascript:addProp()" class="btn btn-dark"><i class="fa fa-plus"></i> Add</a></div>
                                                                    <?php } else { ?>
                                                                        <div><a href="javascript:delInvolved('prop_<?php echo $i ?>')" class="btn btn-danger"><i class="fa fa-trash"></i> Del</a></div>                                                                            <th></th>
                                                                    <?php } ?>
                                                                </div> 
                                                            </div>                                                           
                                                           
                                                            <?php
                                                            $i++;
                                                        }
                                                    }
                                                    else
                                                    {
                                                        ?>                                                    
                                                        <div class="col-md-12 col-xs-12">
                                                            <label for="">Maintenance Type</label>
                                                            <select name="maintenance_type_0" class="form-control" id="maintenance_type_0">
                                                                <option value="" selected>Select</option>
                                                                <?php
                                                                $rs = $maintenancetype->listarActivos($db);

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
                                                        <div class="col-md-12 col-xs-12">
                                                            <label for="">Description</label>
                                                            <div><textarea class="form-control" name="prop_ds_0" id="prop_ds_0" ></textarea></div>
                                                        </div>

                                                        <div class="clearfix"></div>
                                                        <br>

                                                        <div class="pull-right">
                                                            <a href="javascript:addProp()" class="btn btn-dark"><i class="fa fa-plus"></i> Add New</a>
                                                        </div>                                                

                                                    <?php 
                                                    }
                                                    ?>

                                                    <div class="clearfix"></div>
                                                    <br>
                                                    
                                                    <div id="addProp"></div>   
                                                    <div class="clearfix"></div>                                                  
                                                </div>
                                            </div>
                                            <div role="tabpanel" class="tab-pane fade in" id="tab_content2" aria-labelledby="home-tab">

                                                <div class="well well-sm"><strong>Select and upload Picture</strong></div>

                                                <div id="dropzone" class="dropzone">

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="clearfix"></div>
                                    <br>
                                    <?php echo putBotonAccion($db,$co_acc,3,$tit1); ?>
                                    <button type="button" class="btn btn-default load" onclick="javascript:location.href='<?php echo $url1?>'">Back</button>
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
    <!-- dropzone -->
    <script src="../js/dropzone/dropzone.js"></script>

    <script type="text/javascript" src="../../bower_components/moment/min/moment.min.js"></script>
    <script type="text/javascript" src="../../bower_components/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>
    <link rel="stylesheet" href="../../bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css" />
    <script src="../ckeditor/ckeditor.js" type="text/javascript"></script>
    <script type="text/javascript">

        $(document).ready(function () {
            CKEDITOR.replace( 'ds' );

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
                            myDropzone.options.thumbnail.call(myDropzone, mockFile, "../../images/maintenance/<?php echo $_dir?>/" + val.name);
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

        function addProp()
        {   var i = parseInt($('#propnum').val()) + 1;
            var prop_dir = $('#prop_dir').val();
            var prop_ds = $('#prop_ds').val();

            $('#propnum').val(i);

            $("#addProp").append('<div id="prop_'+i+'"><div class="col-md-12 col-xs-12"><label for="">Maintenance Type</label><div><select name="maintenance_type_'+i+'" class="form-control" id="maintenance_type_'+i+'"><option value="" selected>Select</option><?php  $rs = $maintenancetype->listarActivos($db);foreach($rs as $rss){ extract($rss);?><option value="<?php echo $co ?>"><?php echo $nb ?></option><?php } ?></select></div></div><div class="col-md-12 col-xs-12"><label for="">Description</label><div><textarea class="form-control" name="prop_ds_'+i+'" id="prop_ds_'+i+'" ></textarea></div></div><div class="clearfix"></div><br><div class="pull-right"><a href="javascript:delInvolved(\'prop_'+i+'\')" class="btn btn-danger"><i class="fa fa-trash"></i> Del</a></div></div>');

        }

        

        function delInvolved(puntodel)
        {
            $("#"+puntodel).remove();
        }

    </script>

</body>

</html>