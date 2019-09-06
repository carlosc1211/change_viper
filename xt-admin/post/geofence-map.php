<?php
require_once("../../lib/core.php");
require_once('../../xt-model/PostModel.php');
require('../includes/header_basic.php');

$tit1 = "GEO Fence Point on Map";

$codigo = getA("co_post");

$post = new PostModel();
$rs = $post->obtener_geopoint($db,$codigo);

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
                                <div id="map_in" style="height: 400px"></div>

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

    <?php  

    if($rs)
    {
        $lat_in="";
    ?>
        //Comienzo JS
        function cargarmap_in(lat_in, long_in) 
        {

            var mapOptions_in = {
                center: new google.maps.LatLng(lat_in, long_in),
                zoom: 17, mapTypeId: google.maps.MapTypeId.ROADMAP
            };

            var map_in = new google.maps.Map(document.getElementById("map_in"), mapOptions_in);
            var place = new google.maps.LatLng(lat_in, long_in);
            var marker = new google.maps.Marker({
                position: map_in.getCenter()
                , title: 'GEO Fence'
                , map: map_in
                ,
            });

            <?php
            foreach($rs as $rss)
            {
                extract($rss);

                if($lat_in=="")
                {
                    $lat_in = $latitude;
                    $long_in = $longitude;
                }
                ?>

                var place = new google.maps.LatLng(<?php echo $latitude ?>, <?php echo $longitude ?>);
                var marker = new google.maps.Marker({
                    position: place
                    , title: 'Check Point: <?php echo "cod:$co lat:$latitude  long:$longitude" ?>'
                    , map: map_in
                    ,
                });

            <?php  
            }
            ?>
        }
        //Fin JS
    <?php
    }

    if($rs) 
        echo "cargarmap_in($lat_in,$long_in)";
    ?>

    </script>

</body>

</html>