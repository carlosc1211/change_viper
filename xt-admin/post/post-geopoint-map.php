<?php
require_once("../../lib/core.php");
require_once('../../xt-model/PostModel.php');
require('../includes/header_basic.php');

$tit1 = "Check Point on Map";

$codigo = getA("co_post");
$codigo_point = getA("co_point");

$post = new PostModel();
$rs = $post->obtener($db,$codigo);
extract($rs[0]);

$nb_post = $nb;

$rs_point = $post->obtener_det_geopoint($db,$codigo_point);
?>

<body class="nav-md">

    <div class="container body">


        <div class="main_container">

            <!-- page content -->
            <div class="right_col" role="main">

                <div class="page-title">
                    <div class="title_left">
                        <h3><?php echo $tit1 ?></h3>
                    </div>

                </div>
                <div class="clearfix"></div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="x_panel">

                            <div class="x_content">

                            <?php

                            if($rs_point)
                            {	extract($rs_point[0]);

                                ?>
                                <h3><?php echo $nb; ?> </h3>
                                [<?php echo $latitude . ", " . $longitude ?>]
                                <div id="map" style="height:300px"></div>
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

        function cargarmap1(lat, long) {

            var mapOptions2 = {
                center: new google.maps.LatLng(lat, long),
                zoom: 17, mapTypeId: google.maps.MapTypeId.SATELLITE
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

        cargarmap1(<?php echo $latitude ?>, <?php echo $longitude ?>);



    </script>

</body>

</html>