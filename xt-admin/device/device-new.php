<?php
require_once("../../lib/core.php");
require_once("../../lib/val_session.php");
require_once('../../xt-model/DeviceModel.php');
require_once('../../xt-model/PostModel.php');
require_once('../../xt-model/MensajeModel.php');

require('../includes/header.php');

$co_acc = getA("co_acc");

$_dir = GUID();

$tit1 = "Equipment";
$tit2 = "New Equipment";
$url1 = "device-list.php?co_acc=$co_acc";
$url2 = "device-new.php?co_acc=$co_acc";
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
                                        $mensaje = new MensajeModel();
                                        $device = new DeviceModel();
                                        $result = $device->ingresar($db,
                                            [
                                            "ds_dir"=>getA("_dir"),
                                            "ds_id"=>getA("r_ds_id"),
                                            "nb"=>getA("r_nb"),
                                            "ds_make"=>getA("r_ds_make"),
                                            "ds_model"=>getA("r_ds_model"),
                                            "ds_serial"=>getA("ds_serial"),
                                            "co_post"=>getA("r_co_post"),
                                            "actv"=>check(getA("activo"))]
                                        );

                                        if($result)
                                            echo $mensaje->MensajeRegistro(1,"Record created successfully");
                                        else
                                            echo $mensaje->MensajeRegistro(2,"Sorry an error has ocurrred");

                                    }
                                }

                                ?>

                                <form role="form" action="<?php echo $url2;?>" method="post" name="forma" id="forma">
                                    <input type="hidden" id="_dir" name="_dir" value="<?php echo $_dir?>" >
                                
                                    <div class="" role="tabpanel" data-example-id="togglable-tabs">
                                        <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
                                            <li role="presentation" class="active"><a href="#tab_content1" id="home-tab" role="tab" data-toggle="tab" aria-expanded="true">General</a>
                                            </li>
                                            <li role="presentation" class=""><a href="#tab_content2" role="tab" id="profile-tab" data-toggle="tab" aria-expanded="false"><i class="fa fa-camera"></i> Pictures</a>
                                            </li>
                                        </ul>
                                        <div id="myTabContent" class="tab-content">
                                            <div role="tabpanel" class="tab-pane fade active in" id="tab_content1" aria-labelledby="home-tab">
                                                <div class="form-group col-md-6">
                                                    <label class="control-label" for="r_ds_id">Device Id</label>
                                                    <input type="text" class="form-control" name="r_ds_id" id="r_ds_id" placeholder="Input Device Id" maxlength="50">
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label class="control-label" for="r_nb">Name</label>
                                                    <input type="text" class="form-control" name="r_nb" id="r_nb" placeholder="Input Name" maxlength="50">
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label class="control-label" for="r_ds_make">Make by</label>
                                                    <input type="text" class="form-control" name="r_ds_make" id="r_ds_make" placeholder="Input Make by" maxlength="50">
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label class="control-label" for="r_ds_model">Model</label>
                                                    <input type="text" class="form-control" name="r_ds_model" id="r_ds_model" placeholder="Input Model" maxlength="50">
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label class="control-label" for="ds_serial">Serial / Plate</label>
                                                    <input type="text" class="form-control" name="ds_serial" id="ds_serial" placeholder="Input Serial" maxlength="50">
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label class="control-label" for="r_co_post">Post</label>
                                                    <select name="r_co_post" class="form-control" id="r_co_post">
                                                        <option value="" selected>Select</option>
                                                        <?php
                                                        $post = new PostModel();
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
                                                <div class="form-group col-md-6">
                                                    <label for="activo"><input name="activo" type="checkbox" class="BotonForm2_det" id="activo"> Active</label>
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
                                <br>

                                    <?php echo putBotonAccion($db,$co_acc,1,''); ?>
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

    <!-- dropzone -->
    <script src="../js/dropzone/dropzone.js"></script>

    <script type="text/javascript">

        $(document).ready(function () {
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


    </script>
 </body>

</html>