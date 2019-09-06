<?php
require_once("../../lib/core.php");
require_once("../../lib/val_session.php");
require_once('../../xt-model/DailyModel.php');
require_once('../../xt-model/MensajeModel.php');

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
                        <h3><a href="<?php echo $url1?>" class="btn btn-default"><?php echo $tit1 ?></a>/ <?php echo $tit2 ?></h3>
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
                                        $result = $perfil->actualizar($db,
                                            ["co"=>$codigo,
                                             "nb"=>getA("r_nombre"),
                                             "co_rol"=>getA("r_rol"),
                                             "accesos"=>getA("accesos_asgn_add"),
                                             "actv"=>check(getA("activo"))]
                                        );

                                        if($result)
                                            echo $mensaje->MensajeRegistro(1,"Record updated successfully");
                                        else
                                            echo $mensaje->MensajeRegistro(2,"Sorry an error has ocurrred");
                                    }
                                    elseif(getA("acc")=="elim")
                                    {
                                        $result = $dailymod->eliminar($db,["co"=>$codigo]);

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
                                }

                                $rs = $dailymod->obtener_in($db,$codigo);

                                if($rs) extract($rs[0]);

                                ?>

                                <form role="form" action="<?php echo $url2;?>" method="post" name="forma" id="forma">
                                    <div class="col-md-6 col-cx-12"></div>
                                        <div class="form-group ">
                                            <label class="control-label" for="r_employee">Report by</label>
                                            <?php echo $nb_employee . ' ' . $apll_employee?>
                                        </div>
                                        <div class="form-group ">
                                            <label class="control-label" for="r_employee">Report at</label>
                                            <?php echo $fe_reg?>
                                        </div>
                                        <div class="form-group ">
                                            <label class="control-label" for="r_employee">Post</label>
                                            <?php echo $post_name?>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-xs-12">

                                    </div>
                                    <div class="clearfix"></div>
                                    <br>
                                    <div class="form-group col-md-12 col-xs-12">
                                        <label class="control-label" for="accesos">Description</label>
                                        <textarea name="r_obs" id="r_obs" class="form-control" rows="8" readonly ><?php echo $obs?></textarea>
                                    </div>

                                    <div class="clearfix"></div>
                                    <br>
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

        cargarmap_in("<?php echo $lat_in?>","<?php echo $long_in?>");
        cargarmap_out("<?php echo $lat_out?>","<?php echo $long_out?>");

    </script>
</body>

</html>