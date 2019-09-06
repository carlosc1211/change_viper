<?php
require_once("../../lib/core.php");
require_once("../../lib/val_session_employee.php");
require_once('../../xt-model/TrackModel.php');
require_once('../../xt-model/PostModel.php');

require('../includes/header.php');

$_dir = GUID();


$tit1 = "Main Menu";
$tit2 = "Clock In";
$url1 = "../main/findex.php";
$url2 = "clock-activity-in.php";
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
                    <div class="col-md-12 col-xs-12">
                        <div class="x_panel">
                            
                            <form action="clock-activity-post.php" method="post" name="forma" id="forma" enctype="multipart/form-data">
                                <input type="hidden" name="poslat" id="poslat" value="">
                                <input type="hidden" name="poslong" id="poslong" value="">
                                <input type="hidden" name="accuracy" id="accuracy" value="">
                                <input type="hidden" name="tipo" id="tipo" value="1">
                                <input type="hidden" id="_dir" name="_dir" value="<?php echo $_dir?>" >                                
                                <input type="hidden" name="co_clock_tipo" id="co_clock_tipo" value="<?php echo $co_clock_tipo ?>">
                
                                <?php 
                                if(!$_SESSION["codclockin"])
                                {
                                ?>
                                <div class="col-md-6 col-xs-12 bg-map">
                                    <div class="form-group  ">
                                        <h4>Current Position</h4>
                                        <div id="showPos"></div>
                                        <div>
                                            <div id="map" style="height: 200px"></div>
                                        </div>
                                        
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="col-md-6 col-xs-12">
                                    <div class="hideMe2"><br></div>
                                    <div id="dropzone" class="dropzone">

                                    </div>      
                                    <input type="hidden" name="qr_image" id="qr_image" value="">    
                                    <input type="hidden" name="qr_image_date" id="qr_image_date" value="">    
                                        <br>
                                        <button type="button" class="btn btn-success  col-md-6 col-xs-12" onclick="javascript:document.forma.submit()">Load Post Info</button>
                                        <button class=" btn-dark btn load col-md-5 col-xs-12" type="button" onclick="javasscript:location.href='../main/findex.php'">Back to Main Menu</button>
                                    </div>
                                </div>
                                <?php  
                                }
                                else
                                {
                                ?>
                                    <div class="col-md-6 col-xs-12">
                                            <br>
                                            <div class="alert alert-error"><strong>You are not Clocked Out</strong></div>

                                            <button class=" btn-dark btn load col-md-12 col-xs-12" type="button" onclick="javasscript:location.href='../main/findex.php'">Back to Main Menu</button>
                                        </div>
                                    </div>

                                <?php  
                                }
                                ?>
                                <div class="clearfix"></div>

                                <br><br>
                            </form>

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
            enableHighAccurace: true // busca la mejor forma de geolocalización (GPS, tiangulación, ...)
        };

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


        Dropzone.autoDiscover = false;
        $("#dropzone").dropzone({
            url: "upload-track.php",
            addRemoveLinks: true,
            dictDefaultMessage:"Touch or Click here to Scan QR Code",
            dictInvalidFileType:"Invalid file type",
            dictRemoveFile:"Remove File",
            maxFiles:1,
            thumbnailWidth:400,
            thumbnailHeight:300,
            maxFileSize: 10000,
            dictResponseError: "There has benn an error on server",
            acceptedFiles: 'image/*,.jpeg,.jpg,.png,.gif,.JPEG,.JPG,.PNG,.GIF',
            init: function(file)
            {
                this.on("addedfile", function(file) { 
                   // $("#qr_image").val(file.name);
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
        });

    });


    </script>

</body>

</html>