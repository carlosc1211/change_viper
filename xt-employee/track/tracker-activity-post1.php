<?php
require_once("../../lib/core.php");
require_once("../../lib/val_session_employee.php");
require_once('../../xt-model/TrackModel.php');
require_once('../../xt-model/MensajeModel.php');
require_once('../../xt-model/PostModel.php');
require_once('../includes/lib/QrReader.php');
require_once('../../xt-model/PointLocation.php');

$mensaje = new MensajeModel();
$tracker = new TrackModel();
$post = new PostModel();

require('../includes/header.php');

$co_acc = getA("co_acc");
$_dir = $_SESSION["codclockin"]["_dir"];

$pos1 = $_POST['poslat'];
$pos2 = round($_POST['poslong'], 7);
//echo $pos1;
//echo $_SESSION["codclockin"]["co"];

//echo $_SESSION["codclockin"]["co_post"];
//$cccc = $_SESSION["codclockin"]["co_post"];

$tit1 = "Main Menu";
$tit2 = "Officer Tracker Activity";
$url1 = "../main/findex.php";
$url2 = "tracker-activity.php";
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
                        <h3><a href="<?php echo $url1?>" class="btn btn-default"><?php echo $tit1 ?></a> / <?php echo $tit2 ?></h3>
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
                                        $result = $tracker->OfficcerTrack($db,
                                            [
                                                "poslat"=>getA("poslat"),
                                                "poslong"=>getA("poslong"),
                                                "accuracy"=>getA("accuracy"),
                                                "co_post"=>$_SESSION["codclockin"]["co_post"],

                                                "pos_lat_point"=>getA("qr_image1"),
                                                "pos_long_point"=>getA("qr_image2"),
                                                "nb_point"=>getA("qr_image3"),
                                                
                                                "co_clock_in"=>$_SESSION["codclockin"]["co"],
                                                "_dir"=>$_SESSION["codclockin"]["_dir"],
                                                "coduser"=>$_SESSION["codemployee"]["co"]
                                            ]
                                        );

                                        if($result){
                                        ?>
                                            <script>
                                                document.location.href = 'track-registered1.php?tipo=In&point=<?php echo getA("nb_point")?>';
                                            </script>
                                       <?php
                                        }
                                        else
                                        {
                                        ?>
                                            <script>
                                                document.location.href = 'tracker-activity-error.php?tipo=1&error=1';
                                            </script>
                                        <?php
                                        }
                                    }
                                }
                                else
                                {
                                    $qr_image = getA("qr_image");
                                    $qr_image_date = getA("qr_image_date");

                                    //echo $qr_image;
                                    //echo $qr_image_date;                                    
                                    $latitud = explode("|", $qr_image);
                                    $a = $latitud[0];
                                    $b = $latitud[1];
                                    $c = $latitud[2];
                                 
                                    if($qr_image!='')
                                    {
                                        $text=$qr_image;
                                    }
                                    else
                                        $str_msj = "Image loaded must be taken at time!. ";                                    
                                }

                                ?>

                                <form role="form" action="tracker-activity-post1.php?acc=ing" method="post" name="forma" id="forma">
                                <input type="hidden" name="poslat" id="poslat" value="">
                                <input type="hidden" name="poslong" id="poslong" value="">
                                <input type="hidden" name="accuracy" id="accuracy" value="">
                                <input type="hidden" name="_dir" id="_dir" value="<?php echo $_dir ?>">
                                
                                <?php
                                    $rs = $tracker->getTipoPost($db);
                                    if ($rs) {
                                    $geo = $tracker->consultaGeo($db, $cccc);
                                        if ($geo) {
                                            $points = trim($pos1) . " " . trim($pos2);
                                            $pointLocation = new pointLocation();
                                            $statGeoFence = $pointLocation->pointInPolygon1("$points", $_SESSION["post_polygon2"]);

                                            if ($statGeoFence!='inside') { ?>
                                                <div class="col-md-6 col-xs-12 bg-map">
                                                    <div class="form-group  ">

                                                    <h3>Check Point Info</h3>
                                                    <div class="alert alert-error"><strong>You are outside the coverage radius to <?php echo $post_name ?>, please try again</strong></div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-xs-12">
                                                    <br>
                                                    <button type="button" class="btn btn-success col-md-6 col-xs-12" onclick="javascript:location.href='tracker-activity1.php'">Back</button>
                                                    <button class=" btn-dark btn col-md-5 col-xs-12" type="button" onclick="javasscript:location.href='../main/findex.php'">Back to Main Menu</button>
                                                </div>
                                            <?php
                                            } else { ?>
                                                <div class="col-md-6 col-xs-12 bg-map">
                                                <div class="form-group ">
                                                    <h4>Current Position</h4>
                                                    <div id="showPos"></div>
                                                    <div id="map" style="height: 200px"></div>
                                                    <div class="clearfix"></div>
                                                </div>
                                                </div>
                                                <input type="text" name="qr_image1" id="qr_image1" value="<?php echo $a; ?>">
                                                <input type="text" name="qr_image2" id="qr_image2" value="<?php echo $b; ?>">
                                                <input type="text" name="qr_image3" id="qr_image3" value="<?php echo $c; ?>">
                                                <div class="clearfix"></div>
                                                <br>
                                                <button type="submit" class="btn btn-success col-md-6 col-xs-12"><i class="fa fa-check-circle-o"></i> CP Complete</button>
                                                <button class=" btn-dark btn col-md-5 col-xs-12" type="button" onclick="javasscript:location.href='../main/findex.php'">Back to Main Menu</button>
                                            <?php }
                                        }
                                    } else { ?>
                                            <div class="col-md-6 col-xs-12 bg-map">
                                                    <div class="form-group  ">
                                                    <h3>Check Point Info</h3>
                                                    <div class="alert alert-error"><strong>The Information associated with this QR Code doesn't correspond to <?php echo $post_name ?>, please try again</strong></div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-xs-12">
                                                    <br>
                                                    <button type="button" class="btn btn-success col-md-6 col-xs-12" onclick="javascript:location.href='tracker-activity1.php'">Back</button>
                                                    <button class=" btn-dark btn col-md-5 col-xs-12" type="button" onclick="javasscript:location.href='../main/findex.php'">Back to Main Menu</button>
                                                </div>
                                    <?php }
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

    <script type="text/javascript">
    $(document).ready(function () {

        var PositionOptions = {
            timeout: 5000,
            maximumAge: 0,
            enableHighAccurace: true // busca la mejor forma de geolocalizaci�n (GPS, tiangulaci�n, ...)
        };

        //navigator.geolocation.getCurrentPosition(showPosition, errorCallback, PositionOptions);
        navigator.geolocation.getCurrentPosition(showPosition, errorCallback, PositionOptions);
        


        function showPosition(position) {
            var lat = position.coords.latitude;
            var long = position.coords.longitude;
            var accuracy = position.coords.accuracy;

            $("#poslat").val(lat);
            $("#poslong").val(long);
            $("#accuracy").val(accuracy);
            $("#showPos").html("Latitude: " + lat + " &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Longitude: " + long + "<br>Accuracy: " + accuracy + "m");

            cargarmap1(lat, long);
        }

        function cargarmap1(lat, long) {

            var mapOptions2 = {
                center: new google.maps.LatLng(lat, long),
                zoom: 17, mapTypeId: google.maps.MapTypeId.ROADMAP
            };
            var map = new google.maps.Map(document.getElementById("map"), mapOptions2);


            var place = new google.maps.LatLng(lat, long);
            var marker = new google.maps.Marker({
                position: map.getCenter()
                , title: 'Your current position'
                , map: map
                ,
            });
        }

        function errorCallback(error) {
            var errors = { 
                1: 'Permission denied',
                2: 'Position unavailable',
                3: 'Request timeout'
              };
          //alert("Error: " + errors[error.code]);
        };        


        /* Dropzone.autoDiscover = false;
        $("#dropzone").dropzone({
            url: "upload-track1.php",
            addRemoveLinks: true,
            dictDefaultMessage:"Touch or Click here to Scan",
            dictInvalidFileType:"Invalid file type",
            dictRemoveFile:"Remove File",
            maxFiles:1,
            thumbnailWidth:400,
            thumbnailHeight:400,
            maxFileSize: 10000,
            dictResponseError: "There has benn an error on server",
            acceptedFiles: 'image/*,.jpeg,.jpg,.png,.gif,.JPEG,.JPG,.PNG,.GIF',
            init: function(file)
            {
                this.on("addedfile", function(file) { 
                    //$("#qr_image").val(file.name);
                });

            },
            error: function(file)
            {
                alert("Error, can not upload the file " + file.name);
            },
            success: function(file, Response) {
                 $("#qr_image").val(Response);
                },            
            sending: function(file, xhr, formData) {
                formData.append("_dir", "<?php echo $_dir ?>");
            },
            removedfile: function(file, serverFileName)
            {
                var name = $("#qr_image").val();
                $.ajax({
                    type: "POST",
                    url: "upload-track.php?opc=delete",
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
        }); */

    });


    </script>
</body>

</html>