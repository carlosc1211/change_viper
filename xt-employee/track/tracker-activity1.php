<?php
require_once("../../lib/core.php");
require_once("../../lib/val_session_employee.php");
require_once('../../xt-model/TrackModel.php');
require_once('../../xt-model/MensajeModel.php');
require_once('../../xt-model/PostModel.php');

$mensaje = new MensajeModel();
$tracker = new TrackModel();
$post = new PostModel();

require('../includes/header.php');

$co_acc = getA("co_acc");

$_dir = $_SESSION["codclockin"]["_dir"];

$tit1 = "Main Menu";
$tit2 = "Officer Tracker Activity";
$url1 = "../main/findex.php";
$url2 = "tracker-activity.php";
?>
<head>
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    </head>
    <script type="text/javascript" src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js" ></script>	
    <style>
		@media only screen and (max-width: 700px) {
			video {
				max-width: 100%;
			}
		}
    </style>
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

                                <form role="form" action="tracker-activity-post1.php" method="post" name="forma" id="forma">
                                    <input type="hidden" name="poslat" id="poslat" value="">
                                    <input type="hidden" name="poslong" id="poslong" value="">
                                    <input type="hidden" name="accuracy" id="accuracy" value="">
                                    <input type="hidden" name="_dir" id="_dir" value="<?php echo $_dir ?>">

                                        <?php
                                        if($_SESSION["codclockin"])
                                        {
                                            $rs = $tracker->getTipoPost($db);
                                            if($rs) extract($rs[0]);

                                            ?>
                                            <div class="col-md-12 col-xs-12 bg-map">
                                                <div class="form-group ">
                                                    <h4>Current Position</h4>
                                                    <div id="showPos"></div>
                                                    <div id="map" style="height: 200px"></div>
                                                    <div class="clearfix"></div>
                                                </div>
                                            </div>
                                            <div class="col-md-12 col-xs-12 bg-map">
                                                <h4>Post Info</h4>
                                                    <label for="">Post: </label> <?php echo $post_name ?><br>
                                                    <label for="">Address: </label> <?php echo $post_dir ?><br>

                                                <div class="clearfix"></div>

                                                <input type="hidden" name="qr_image" id="qr_image" value=""> 
                                                <input type="hidden" name="qr_image_date" id="qr_image_date" value="">    
                                            </div>

                                            <div class="clearfix"></div>
                                            <br/>
                                            <!-- <div id="dropzone" class="dropzone">
                                       
                                    </div>       -->
                                    

                                    <video muted="muted" id="video"></video>
                                            <br>
                                            <button type="button" class="btn btn-success  col-md-6 col-xs-12" onclick="javascript:document.forma.submit()">Load Point Info</button>                                            
                                            <button class=" btn-dark btn col-md-5 col-xs-12" type="button" onclick="javasscript:location.href='<?php echo $url1?>'">Back to Main Menu</button>

                                            <?php
                                        }
                                        else
                                        { ?>
                                            <br><br>
                                            <div class="form-group ">
                                                <div class="alert alert-error" role="alert"><strong>Sorry</strong> You must to Clock In!</div>
                                            </div>
                                            <button type="button" class="btn btn-default load  col-md-6 col-xs-12" onclick="javascript:location.href='<?php echo $url1?>'">Back to Main Menu</button>

                                        <?php
                                        }
                                        ?>
                                    </div>
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
     <script src="script.js"></script>
    
    <!-- <script src="../js/dropzone/dropzone.js"></script> -->

    <script type="text/javascript">
    
        let scanner = new Instascan.Scanner(
            {
                video: document.getElementById('video')
            }
        );
        scanner.addListener('scan', function(content) {
            //alert('Su QR informa: ' + content);
            //window.open(content, "_blank");
            $("#qr_image").val(content);
           /*     fe_ano = getFullYear();
                fe_mes = getMonth()+1;
                fe_dia = getDate();
                fe_hora =getHours();
                fe_minutos = getMinutes();*/
                var f = new Date();
                fecha=f.getFullYear() + "/" + (f.getMonth() +1) + "/" + f.getDate() +' '+f.getHours() +':'+f.getMinutes();
            $("#qr_image_date").val(fecha);
            alert('Su QR informa: ' + content +'-'+ fecha);
        });
        Instascan.Camera.getCameras().then(cameras => 
        {
            if(cameras.length > 0){
                if (cameras.length == 1){
                    scanner.start(cameras[0]);
                }else{
                    scanner.start(cameras[1]);
                }

                
            } else {
                console.error("No existen dispositivos de camara!");
            }
        });
   
    $(document).ready(function () {

        var PositionOptions = {
            timeout: 5000,
            maximumAge: 0,
            enableHighAccurace: true // busca la mejor forma de geolocalizaci�n (GPS, tiangulaci�n, ...)
        };

        //var watchId = navigator.geolocation.watchPosition(showPosition, errorCallback, PositionOptions);
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

        function clear_watch_geolocation() {
          if (navigator.geolocation) {
            navigator.geolocation.clearWatch(watchId);
          }
        }

       /* Dropzone.autoDiscover = false;
        $("#dropzone").dropzone({
            url: "upload-track.php",
            addRemoveLinks: true,
            dictDefaultMessage:"[ Touch or Click here to Scan QR Code ]",
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
                fe_ano = file.lastModifiedDate.getFullYear();
                fe_mes = parseInt(file.lastModifiedDate.getMonth())+1;
                fe_dia = file.lastModifiedDate.getDate();
                fe_hora = file.lastModifiedDate.getHours();
                fe_minutos = file.lastModifiedDate.getMinutes();

                $("#qr_image_date").val(fe_ano + '-' + fe_mes + '-' + fe_dia + ' ' + fe_hora + ':' + fe_minutos);

                formData.append("_dir", "<?php echo $_dir ?>");
                //document.forma.submit();
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
        });*/

    });




    </script>
</body>

</html>