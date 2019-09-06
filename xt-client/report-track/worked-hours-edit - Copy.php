<?php
require_once("../../lib/core.php");
require_once("../../lib/val_session.php");
require_once('../../xt-model/TrackModel.php');
require_once('../../xt-model/MensajeModel.php');

$track = new TrackModel();
$mensaje = new MensajeModel();

require('../includes/header.php');

$codigo = getA("co");
$co_acc = getA("co_acc");

$tit1 = "Hours Worked";
$tit2 = "Edit Hours Worked";
$url1 = "worked-hours-list.php?co_acc=$co_acc";
$url2 = "worked-hours-edit.php?co_acc=$co_acc&co=$codigo";
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

                            <div class="x_content">

                                <?php

                                if(isset($_REQUEST["elim"]))
                                {
                                    $result = $track->eliminarOfficerTrack($db,["co"=>$codigo]);

                                    if($result)
                                        echo $mensaje->MensajeRegistro(1,"Record deleted successfully");
                                    else
                                        echo $mensaje->MensajeRegistro(2,"Sorry an error has ocurrred");

                                    ?>
                                    <script>
                                    var redirectTimeout = setTimeout( function() { window.location = '<?php echo $url1?>'; }, 3000 );
                                    </script>
                                    <?php
                                }

                                $rs = $track->obtenerWorkedHours($db,$codigo);
                                if($rs) extract($rs[0]);

                                $rs = $track->getLatLongClockIn($db,$codigo);
                                if($rs) extract($rs[0]);


                                ?>

                                <form role="form" action="<?php echo $url2;?>" method="post" name="forma" id="forma">
                                    <input type="hidden" id="lat_in" name="lat_in" value="<?php echo $lat_in ?>">
                                    <input type="hidden" id="long_in" name="long_in" value="<?php echo $long_in ?>">
                                    <input type="hidden" id="lat_out" name="lat_out" value="<?php echo $lat_out ?>">
                                    <input type="hidden" id="long_out" name="long_out" value="<?php echo $long_out ?>">
                                    
                                    <div class="form-group col-md-6 col-xs-12">
                                        <label class="control-label" for="r_ds_id">First Name</label>
                                        <div><?php echo $nb_employee ?></div>
                                    </div>
                                    <div class="form-group col-md-6 col-xs-12" col-xs-12>
                                        <label class="control-label" for="r_nb">Last Name</label>
                                        <div><?php echo $apll_employee ?></div>
                                    </div>
                                    <div class="form-group col-md-6 col-xs-12">
                                        <label class="control-label" for="r_ds_make">Post</label>
                                        <div><?php echo $post_name ?></div>
                                    </div>
                                    <div class="form-group col-md-6 col-xs-12">
                                        <label class="control-label" for="r_ds_make">Worked Hours</label>
                                        <div><?php echo $dif ?>&nbsp;</div>
                                    </div>

                                    <div class="clearfix"></div>

                                    <hr>

                                    <div class="col-md-6 col-xs-12">
                                        <div class="bg-success">
                                            <br>
                                            <h2 class="form-group col-xs-12"><strong>Clock In</strong></h2>
                                            <div class="form-group col-xs-12">
                                                <div><?php echo $clocked_in ?></div>
                                            </div>
                                            <div class="form-group col-xs-12">
                                                
                                                <div id="showPos_in">
                                                    Latitude: <?php echo $lat_in ?> <br>
                                                    Longitude: <?php echo $long_in ?> <br>
                                                    Accuracy: <?php echo $accuracy_in ?>                                            
                                                </div>
                                                <br>                                        
                                                <div id="map_in" style="height: 300px"></div>
                                            </div>
                                            <div class="clearfix"></div>                                            
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-xs-12">
                                        <div class="bg-success">
                                            <br>
                                            <h2 class="form-group col-xs-12"><strong>Clock Out</strong></h2>
                                            <div class="form-group col-xs-12">
                                                <div><?php echo $clocked_out ?>&nbsp;</div>
                                            </div>
                                            <div class="form-group col-xs-12">
                                                
                                                <?php
                                                $rs = $track->getLatLongClockOut($db,$codigo);
                                                if($rs) 
                                                {   extract($rs[0]);
                                                ?>
                                                    <div id="showPos_out">
                                                        Latitude: <?php echo $lat_out ?> <br>
                                                        Longitude: <?php echo $long_out ?>  <br>
                                                        Accuracy: <?php echo $accuracy_out ?>                                                                                                                                  
                                                    </div>
                                                    <br>                                        
                                                    <div id="map_out" style="height: 300px"></div>
                                                <?php 
                                                } ?>
                                            </div>
                                            <div class="clearfix"></div>
                                        </div>
                                    </div>

                                    <div class="clearfix"></div>
                                    <br><br>

                                    <div class="" role="tabpanel" data-example-id="togglable-tabs">
                                        <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
                                            <li role="presentation" class="active"><a href="#tab_content1" role="tab" id="profile-tab" data-toggle="tab" aria-expanded="false"><i class="fa fa-map-marker"></i> Officer Tracker GPS</a>
                                            </li>
                                            <li role="presentation" class=""><a href="#tab_content2" id="home-tab" role="tab" data-toggle="tab" aria-expanded="true">Officer Tracker List</a>
                                            </li>
                                        </ul>
                                        <div id="myTabContent" class="tab-content">
                                            <div role="tabpanel" class="tab-pane fade active in" id="tab_content1" aria-labelledby="home-tab">

                                                <?php
                                                $rs = $track->obtenerOfficerTracker($db,$codigo);  

                                                if($rs)
                                                {
                                                    foreach($rs as $rss)
                                                    {
                                                    extract($rss);

                                                    ?>
                                                    <div class="form-group col-md-3 col-xs-6" style="height:150px; margin:10px" id="map_<?php echo $co ?>">

                                                    </div>
                                                    <?php  
                                                    }
                                                }
                                                else
                                                    echo '<div class="alert alert-danger" role="alert"><p>Not Track Officer registered</p></div>';
                                                    ?>
                                            </div>

                                            <div role="tabpanel" class="tab-pane fade in" id="tab_content2" aria-labelledby="home-tab">
                                            
                                            <div class="col-md-12 col-xs-12">
                                            <?php  

                                            if($rs)
                                            {?>
                                            <table class="table">
                                                <tr>
                                                    <td>Check Point</td>
                                                    <td>Date / Time</td>
                                                </tr>
                                                <?php
                                                foreach($rs as $rss)
                                                {
                                                extract($rss);

                                                ?>
                                                    <tr>
                                                        <td><?php echo $check_point ?></td>
                                                        <td><?php echo $fe_reg_track ?></td>
                                                    </tr>
                                                <?php  
                                                }
                                                ?>
                                            </table>
                                            <?php    
                                            }
                                            else
                                                echo '<div class="alert alert-danger" role="alert"><p>Not Track Officer registered</p></div>';
                                                ?>

                                            </div>

                                        </div>

                                    <div class="clearfix"></div>
                                    <br><br>
                                    <?php echo putBotonAccion($db,$co_acc,3,$tit1); ?>
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
    <script type="text/javascript" src="//maps.google.com/maps/api/js?sensor=false&language=en"></script>

    <script type="text/javascript"> 

        function cargarmap_in(lat_in, long_in) {
            if (lat_in != '' && long_in != '') {
                var mapOptions_in = {
                    center: new google.maps.LatLng(lat_in, long_in),
                    zoom: 17, mapTypeId: google.maps.MapTypeId.ROADMAP
                };
                var map_in = new google.maps.Map(document.getElementById("map_in"), mapOptions_in);
                var place = new google.maps.LatLng(lat_in, long_in);
                var marker = new google.maps.Marker({
                    position: map_in.getCenter()
                    , title: 'Clock In'
                    , map: map_in
                    ,
                });
            }
        }

        function cargarmap_out(lat_out, long_out) {
            if(lat_out!='' && long_out!='') {
                var mapOptions_out = {
                    center: new google.maps.LatLng(lat_out, long_out),
                    zoom: 17, mapTypeId: google.maps.MapTypeId.ROADMAP
                };
                var map_out = new google.maps.Map(document.getElementById("map_out"), mapOptions_out);
                var place = new google.maps.LatLng(lat_out, long_out);
                var marker = new google.maps.Marker({
                    position: map_out.getCenter()
                    , title: 'Clock Out'
                    , map: map_out
                    ,
                });
            }
        }

        <?php  
        $rs = $track->obtenerOfficerTracker($db,$codigo);

        if($rs)
        {?>
        //Comienzo JS
        function cargarTrackers()
        {
            <?php
            foreach($rs as $rss)
            {
            extract($rss);

            ?>

                var mapOptions_out = {
                    center: new google.maps.LatLng(<?php echo $pos_lat ?>, <?php echo $pos_long ?>),
                    zoom: 17, mapTypeId: google.maps.MapTypeId.ROADMAP
                };
                var map_out = new google.maps.Map(document.getElementById("map_<?php echo $co ?>"), mapOptions_out);
                var place = new google.maps.LatLng(<?php echo $pos_lat ?>, <?php echo $pos_long ?>);
                var marker = new google.maps.Marker({
                    position: map_out.getCenter()
                    , title: 'Check Point: <?php echo $check_point ?>,  Date: <?php echo $fe_reg ?>,  Accuracy: <?php echo $accuracy ?>m'
                    , map: map_out
                    ,
                });

            <?php  
            }
            ?>
        }
        //Fin JS
        <?php
        }

        if($lat_in)
            echo "cargarmap_in($lat_in,$long_in);";
        if(isset($lat_out))
            echo "cargarmap_out($lat_out,$long_out);";

        if($rs) 
            echo "cargarTrackers();";
        ?>



    </script>
</body>

</html>