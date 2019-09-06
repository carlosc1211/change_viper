<?php
require_once("../../lib/core.php");
require_once('../../xt-model/TrackModel.php');
require('../includes/header_basic.php');

$tit1 = "Check Point on Map";

$codigo = getA("co_track");

$post = new TrackModel();
$rs = $post->obtenerOfficerTrackerPoint($db,$codigo);

?>

<body class="nav-md">

    <div class="container body">


        <div class="main_container">

            <!-- page content -->
            <div class="right_col" role="main">

                <div class="clearfix"></div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="x_panel">

                            <div class="x_content">

                            <?php

                            if($rs)
                            {	

                                ?>
                                <div class="col-md-12">
                                    <div id="map_in" style="height: 360px"></div>
                                    <br><br>
                                    <ul class="list-inline">
                                        <li><img src="http://maps.google.com/mapfiles/ms/icons/red.png" alt=""><strong>Device GPS</strong></li>
                                        <li><img src="http://maps.google.com/mapfiles/ms/icons/blue.png" alt=""><strong>QR Code Point</strong></li>
                                    </ul>
                                </div>
                                <?php
                            }
                            else
                            {	?>
                                <div class="alert alert-info">
                                    <button type="button" class="close" data-dismiss="alert">×</button>
                                    <strong>Sorry</strong> 0 Records found.
                                </div>
                                <?php
                            }
                            ?>

                            </div>

                        </div>
                    </div>
                </div>
            </div>

            </div>
            <!-- /page content -->
        </div>


    <script type="text/javascript" src="//maps.google.com/maps/api/js?sensor=false&language=en"></script>

    <script>
        //Comienzo JS
        function cargarmap1(latitude, longitude, pos_lat, pos_long) 
        {

            var mapOptions_in = {
                center: new google.maps.LatLng(latitude, longitude),
                zoom: 17, mapTypeId: google.maps.MapTypeId.SATELLITE
            };

            var map_in = new google.maps.Map(document.getElementById("map_in"), mapOptions_in);
            var place = new google.maps.LatLng(latitude, longitude);


            icon = "http://maps.google.com/mapfiles/ms/icons/blue.png";


            var place = new google.maps.LatLng(latitude, longitude);
            var marker = new google.maps.Marker({
                position: place
                , title: 'QR Code Point'
                , map: map_in
                , icon: new google.maps.MarkerImage(icon)
            });


            var place = new google.maps.LatLng(pos_lat, pos_long);
            var marker = new google.maps.Marker({
                position: place
                , title: 'Device GPS'
                , map: map_in
                ,
            });

        }
        //Fin JS
    <?php
    if($rs) 
    {   extract($rs[0]);

        echo "cargarmap1($pos_lat_point, $pos_long_point, $pos_lat, $pos_long)";
    }
    ?>

    </script>

</body>

</html>