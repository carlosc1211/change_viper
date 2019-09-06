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

$_dir = GUID();

require('../includes/header.php');

$co_acc = getA("co_acc");

$tit1 = "Daily Activity";
$tit2 = "New Daily Activity";
$url1 = "daily-log-list.php?co_acc=$co_acc";
$url2 = "daily-activity.php?co_acc=$co_acc";
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
                                        $result = $dailyact->ingresar($db,
                                            [
                                                "ds_dir"=>getA("_dir"),
                                                "poslat"=>getA("poslat"),
                                                "poslong"=>getA("poslong"),
                                                "accuracy"=>getA("accuracy"),
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
                                                type: "POST",
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

                                ?>

                                <form role="form" action="<?php echo $url2;?>" method="post" name="forma" id="forma">
                                    <input type="hidden" id="_dir" name="_dir" value="<?php echo $_dir?>" >
                                    <input type="hidden" name="poslat" id="poslat" value="">
                                    <input type="hidden" name="poslong" id="poslong" value="">
                                    <input type="hidden" name="accuracy" id="accuracy" value="">
                                    <input type="hidden" name="tipo" id="tipo" value="<?php echo $tipo ?>">
                                    <?php
                                    if($_SESSION["codclockin"])
                                    {
                                        $rs = $tracker->getTipoPost($db);
                                        if($rs) extract($rs[0]);

                                        ?>
                                        <!--
                                        <div class="col-md-6 col-xs-12 bg-success">
                                            <div class="form-group ">
                                                <h3>Current Position</h3>
                                                <div id="showPos"></div>
                                                <br>
                                                <div id="map" style="height: 300px"></div>
                                                <div class="clearfix"></div>
                                                <br>
                                            </div>
                                        </div>
                                        -->
                                    <div class="" role="tabpanel" data-example-id="togglable-tabs">
                                        <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
                                            <li role="presentation" class="active"><a href="#tab_content1" id="home-tab" role="tab" data-toggle="tab" aria-expanded="true">Activity Description</a>
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
                                                        <textarea name="ds" id="ds" class="form-control" rows="8" ></textarea>

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
                                    <button type="button" class="btn btn-dark" onclick="javascript:validar(this.form,'ing')">Submit</button>
                                    <button type="button" class="btn btn-default load" onclick="javascript:location.href='<?php echo $url1?>'">Back</button>

                                    <?php
                                    }
                                    else
                                    { ?>
                                        <br><br>
                                        <div class="form-group">
                                            <div class="alert alert-error" role="alert"><strong>Sorry</strong> You must to Clock In!</div>
                                        </div>
                                        <button type="button" class="btn btn-default load  col-md-6 col-xs-12" onclick="javascript:location.href='<?php echo $url1?>'">Back</button>

                                    <?php
                                    }
                                    ?>
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

            navigator.geolocation.getCurrentPosition(showPosition);

            function showPosition(position) {
                var lat = position.coords.latitude;
                var long = position.coords.longitude;
                var accuracy = position.coords.accuracy;

                $("#poslat").val(lat);
                $("#poslong").val(long);
                $("#accuracy").val(accuracy);
                //$("#showPos").html("Latitude: " + lat + "<br>Longitude: " + long);

                cargarmap1(lat, long);
            }

            function cargarmap1(lat, long) {

            /*
                var mapOptions2 = {
                    center: new google.maps.LatLng(lat, long),//Universidad
                    zoom: 17, mapTypeId: google.maps.MapTypeId.ROADMAP
                };
                var map = new google.maps.Map(document.getElementById("map"), mapOptions2);

                //marcador con la ubicación de la Universidad
                var place = new google.maps.LatLng(lat, long);
                var marker = new google.maps.Marker({
                    position: map.getCenter()
                    , title: 'Your current position'
                    , map: map
                    ,
                });
            */
            }

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