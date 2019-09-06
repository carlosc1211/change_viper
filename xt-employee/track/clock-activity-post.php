<?php
require_once("../../lib/core.php");
require_once("../../lib/val_session_employee.php");
require_once('../../xt-model/TrackModel.php');
require_once('../../xt-model/PostModel.php');
require_once('../includes/lib/QrReader.php');
require_once('../../xt-model/PointLocation.php');

$clockreg = new TrackModel();
$post = new PostModel();
$clocktipo = new TrackModel();

require('../includes/header.php');

$co_acc = getA("co_acc");
$_dir = getA("_dir");


$rs = $clocktipo->getTipo($db);

if($rs) extract($rs[0]);

if($tipo==1)
{   $titcomp = "Out";  $tipo=2; $co_clock_tipo=$co;  }
else
{   $titcomp = "In";   $tipo=1; $co_clock_tipo=$co;   }





$tit1 = "Main Menu";
$tit2 = "Clock In";
$url1 = "../main/findex.php";
$url2 = "clock-activity.php";
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
                    <div class="col-md-12">
                        <div class="x_panel">
                            <?php
                            if(isset($_REQUEST["acc"]))
                            {
                                if(getA("acc")=="ing")
                                {
                                    $result = $clockreg->ClockLogIn($db,
                                        [
                                            "poslat"=>getA("poslat"),
                                            "poslong"=>getA("poslong"),
                                            "accuracy"=>getA("accuracy"),
                                            "tipo"=>getA("tipo"),
                                            "co_clock_tipo"=>getA("co_clock_tipo"),
                                            "co_post"=>getA("co_post"),
                                            "_dir"=>getA("_dir"),
                                            "coduser"=>$_SESSION["codemployee"]["co"]
                                        ]
                                    );

                                    if($result)
                                    {
                                        //echo  $_SESSION["codclockin"]["co"]."--------";
                                    ?>
                                        <script>
                                            document.location.href = 'clock-registered.php?tipo=In';
                                        </script>
                                    <?php
                                    }
                                    else
                                    {
                                    ?>
                                        <script>
                                            document.location.href = 'clock-activity-error.php?tipo=1&error=1';
                                        </script>
                                    <?php
                                    }


                                }
                            }
                            else
                            {
                                //***********************  Cambiamos el tamaño del archivo  **********************************
                                $qr_image = getA("qr_image");
                                $qr_image_date = getA("qr_image_date");

                                $targetPath = "../../images/track/";

                                $nombre_archivo = $targetPath.$_dir."/".$qr_image;
                                /*
                                $fe_actual = date_create(date("Y-n-j G:i"));
                                $qr_image_date = date_create($qr_image_date);

                                echo date_format($fe_actual, 'Y-m-d G:i') . "<br>";
                                echo date_format($qr_image_date, 'Y-m-d G:i') . "<br>";

                                $interval = date_diff($fe_actual, $qr_image_date);
                                $interval =  $interval->format('%h');
                                echo $interval;*/



                                $interval =  dateDiffMinutes(date("Y-n-j G:i"), $qr_image_date);

                                //echo date("Y-n-j G:i")."<br>".$qr_image_date."<br>".$interval;

                                if ($interval>-35)
                                {
                                    $origen=$nombre_archivo;
                                    $destino=$nombre_archivo;
                                    $destino_temporal=tempnam("tmp/","tmp");

                                    // Establecer un ancho y alto máximo
                                    $ancho = 300;
                                    $alto = 300;

                                    // Obtener las nuevas dimensiones
                                    list($ancho_orig, $alto_orig) = getimagesize($nombre_archivo);


                                    if($ancho_orig>$ancho)
                                    {
                                        $ratio_orig = $ancho_orig/$alto_orig;

                                        if ($ancho/$alto > $ratio_orig) {
                                           $ancho = $alto*$ratio_orig;
                                        } else {
                                           $alto = $ancho/$ratio_orig;
                                        }

                                        redimensionar_jpeg($origen, $destino_temporal, $ancho, $alto, 100);
                                         
                                        // guardamos la imagen
                                        $fp=fopen($destino,"w");
                                        fputs($fp,fread(fopen($destino_temporal,"r"),filesize($destino_temporal)));
                                        fclose($fp);
                                         
                                         
                                    }
                                    //*********************************************************************************************
                                    if($qr_image!='')
                                    {
                                        $qrcode = new QrReader("../../images/track/$_dir/$qr_image");
                                        $text = explode("|",$qrcode->text()); //return decoded text from QR Code            

                                    }
                                }
                                else
                                    $str_msj = "Image loaded must be taken at time!. ";                                
                            }

                            ?>

                            <form action="clock-activity-post.php?acc=ing" method="post" name="forma" id="forma" enctype="multipart/form-data">
                                <input type="hidden" name="poslat" id="poslat" value="">
                                <input type="hidden" name="poslong" id="poslong" value="">
                                <input type="hidden" name="accuracy" id="accuracy" value="">
                                <input type="hidden" name="tipo" id="tipo" value="<?php echo $tipo ?>">
                                <input type="hidden" id="_dir" name="_dir" value="<?php echo $_dir?>" >                                
                                <input type="hidden" name="co_clock_tipo" id="co_clock_tipo" value="<?php echo $co_clock_tipo ?>">

                                <div class="col-md-6 col-xs-12 bg-map">
                                    <div class="form-group  ">
                                        <h4>Current Position</h4>
                                        <div id="showPos"></div>
                                        <br>
                                        <div class="col-md-12 col-xs-12">
                                            <div id="map" style="height: 200px"></div>
                                        </div>
                                        <div class="clearfix"></div>
                                        <br>
                                    </div>
                                </div>

                                <?php 
                                if(is_array($text))
                                { 
                                    $rs = $post -> obtener($db,$text[0]);

                                    if ($rs) 
                                    {
                                        extract($rs[0]);

                                        $date = date('m/d/Y H:i:s');
                                        ?>
                                        <div class="col-md-6 col-xs-12 bg-map">
                                            <div class="form-group  ">

                                            <h4>Post Info</h4>
                                                <label for="">Post: </label> <?php echo $text[2] ?><br>
                                                <label for="">Address: </label> <?php echo $dir ?><br>
                                                <label for="">Date Time: </label> <?php echo $date ?>

                                            <input type="hidden" name="co_post" id="co_post" value="<?php echo $text[0] ?>">    
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-xs-12">
                                            <br>
                                            <button type="button" class="btn btn-success col-md-6 col-xs-12" onclick="javascript:validar(this.form,'ing')"><i class="fa fa-check-circle-o"></i> Check In</button>
                                            <button class=" btn-dark btn col-md-5 col-xs-12" type="button" onclick="javasscript:location.href='../main/findex.php'">Back to Main Menu</button>
                                        </div>
                                    <?php 
                                    } else { ?>
                                        <div class="col-md-6 col-xs-12 bg-map">
                                            <div class="form-group  ">

                                            <h3>Post Info</h3>

                                            <div class="alert alert-error"><strong><?php echo $str_msj ?>No Post information associated with this QR Code, please try again</strong></div>

                                            </div>
                                        </div>
                                        <div class="col-md-6 col-xs-12">
                                            <br>
                                            <button type="button" class="btn btn-success col-md-6 col-xs-12" onclick="javascript:location.href='clock-activity-in.php'">Back</button>
                                            <button class=" btn-dark btn col-md-5 col-xs-12" type="button" onclick="javasscript:location.href='../main/findex.php'">Back to Main Menu</button>
                                        </div>

                                <?php 
                                    }
                                }
                                else
                                { ?>
                                    <div class="col-md-6 col-xs-12">
                                        <br>
                                        <div class="alert alert-error"><strong><?php echo $str_msj ?>No Post Info Founded on QR Image, please go back and try again.</strong></div>
                                        
                                        <br>
                                        <br>
                                        <button class=" btn-dark btn" type="button" onclick="javasscript:history.back()">Back to Scan QR Code</button>
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

    <script type="text/javascript">
    setInterval(function(){ location.reload(); }, 300000);
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

    });


    </script>

</body>

</html>