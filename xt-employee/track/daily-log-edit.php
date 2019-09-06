<?php
require_once("../../lib/core.php");
require_once("../../lib/val_session_employee.php");
require_once('../../xt-model/DailyModel.php');
require_once('../../xt-model/MensajeModel.php');
require_once('../../xt-model/TrackModel.php');
require_once('../../xt-model/PostModel.php');

$mensaje = new MensajeModel();
$dailyact = new DailyModel();
$post = new PostModel();
$tracker = new TrackModel();

require('../includes/header.php');

$codigo = getA("co");
$co_acc = getA("co_acc");

$tit1 = "Daily Log Activity";
$tit2 = "Edit Daily Log Activity";
$url1 = "daily-log-list.php?co_acc=$co_acc";
$url2 = "daily-log-edit.php?co_acc=$co_acc&co=$codigo";
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
                        <h3><a href="../main/findex.php" class="btn btn-default">Main</a> / <a href="<?php echo $url1?>" class="btn btn-default"><?php echo $tit1 ?></a>/ <?php echo $tit2 ?></h3>
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
                                $dailymod = new DailyModel();
                                $mensaje = new MensajeModel();

                                if(isset($_REQUEST["acc"]))
                                {
                                    if(getA("acc")=="ing")
                                    {
                                        $result = $dailyact->actualizar($db,
                                            [
                                            "co"=>$codigo,
                                            "ds_dir"=>getA("_dir"),
                                            "co_post"=>$_SESSION["codclockin"]["co_post"],
                                            "obs"=>getA("ds"),
                                            "coduser"=>$_SESSION["codemployee"]["co"] 
                                            ]
                                        );


                                        if($result)
                                        {
                                            echo $mensaje->MensajeRegistro(1,"Record created successfully");
                                            ?>
                                            <script>
                                            $.ajax({
                                                type: "get",
                                                url: "daily-activity-edit.php",
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

                                $rs = $dailymod->obtener_in($db,$codigo);
                                if($rs) extract($rs[0]);

                                $rs = $tracker->getTipoPost($db);
                                if($rs) extract($rs[0]);

                                $_dir = $ds_dir;

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
                                               <div class="col-md-12 col-xs-12">
                                                <br>
                                                    <div class="well well-sm"><h4>Post Info</h4>
                                                        <label for="">Post: </label> <?php echo $post_name ?><br>
                                                        <label for="">Address: </label> <?php echo $post_dir ?><br>
                                                    </div>
                                                    
                                                        <label class="control-label" for="accesos">Description</label>
                                                        <textarea name="ds" id="ds" class="form-control" rows="8" ><?php echo html_entity_decode($obs)?></textarea>

                                                    <br />
                                                    <div class="clearfix"></div>
                                                    <br />

                                                </div>
                                            </div>
                                            <div role="tabpanel" class="tab-pane fade in" id="tab_content2" aria-labelledby="home-tab">
                                                <div id="dropzone" class="dropzone">

                                                </div>                                                  
                                            </div>
                                        </div>
    
                                        <button type="button" class="btn btn-dark" onclick="javascript:validar(this.form,'ing')">Update</button>
                                        <button type="button" class="btn btn-default load" onclick="javascript:location.href='<?php echo $url1?>'">Back</button>

                                    </div>
                                    <div class="clearfix"></div>
                                    <br>
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
    <script src="../ckeditor/ckeditor.js" type="text/javascript"></script>

    <script type="text/javascript">
        $(document).ready(function () {
            CKEDITOR.replace('ds');

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
                            myDropzone.options.thumbnail.call(myDropzone, mockFile, "../../images/daily-activity/<?php echo $_dir?>/" + val.name);
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
    </script>
</body>

</html>