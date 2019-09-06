<?php
require_once("../../lib/core.php");
require_once("../../lib/val_session_employee.php");
require_once('../../xt-model/DailyModel.php');
require_once('../../xt-model/MensajeModel.php');
require_once('../../xt-model/PostModel.php');

$mensaje = new MensajeModel();
$dailyact = new DailyModel();
$post = new PostModel();

require('../includes/header.php');

$co_acc = getA("co_acc");

$tit1 = "Main Menu";
$tit2 = "Daily Activity";
$url1 = "../main/findex.php";
$url2 = "daily-activity.php";
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
                        <h3><a href="<?php echo $url1?>" class="btn btn-default"><?php echo $tit1 ?></a> / <a href="<?php echo $url2?>" class="btn btn-default"><?php echo $tit2 ?></a></h3>
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
                                if(isset($_REQUEST["acc"]))
                                {
                                    if(getA("acc")=="ing")
                                    {
                                        $result = $dailyact->ingresar($db,
                                            [
                                                "fechaclock"=>getA("fechaclock"),
                                                "poslat"=>getA("poslat"),
                                                "poslong"=>getA("poslong"),
                                                "co_post"=>getA("r_co_post"),
                                                "obs"=>getA("r_obs"),
                                                "coduser"=>$_SESSION["codemployee"]["co"]
                                            ]
                                        );

                                        if($result)
                                            echo $mensaje->MensajeRegistro(1,"Record created successfully");
                                        else
                                            echo $mensaje->MensajeRegistro(2,"Sorry an error has ocurrred");

                                    }
                                }

                                ?>

                                <form role="form" action="<?php echo $url2;?>" method="post" name="forma" id="forma">
                                    <div class="col-md-6 col-xs-12 bg-success">
                                        <div class="form-group ">
                                            <input type="hidden" name="fechaclock" id="fechaclock" value="">
                                            <input type="hidden" name="poslat" id="poslat" value="">
                                            <input type="hidden" name="poslong" id="poslong" value="">
                                            <input type="hidden" name="tipo" id="tipo" value="<?php echo $tipo ?>">
                                            <h3>Current Time</h3>
                                            <div id="dateTime"></div>
                                            <h3>Current Position</h3>
                                            <div id="showPos"></div>
                                            <br>
                                            <div id="map" style="height: 300px"></div>
                                            <div class="clearfix"></div>
                                            <br>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-xs-12">
                                        <div class="form-group  col-md-12 col-xs-12">
                                            <label class="control-label" for="r_co_post">Post</label>
                                            <select name="r_co_post" class="form-control" id="r_co_post">
                                                <option value="" selected>Select</option>
                                                <?php
                                                $rs = $post->listarActivos($db);

                                                foreach($rs as $rss)
                                                {
                                                    extract($rss);
                                                    ?>
                                                    <option value="<?php echo $co ?>"><?php echo $nb ?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-12 col-xs-12">
                                            <label class="control-label" for="accesos">Description</label>
                                            <textarea name="r_obs" id="r_obs" class="form-control" rows="8" ></textarea>
                                        </div>

                                        <br />
                                        <div class="clearfix"></div>
                                        <br />

                                        <button type="button" class="btn btn-dark" onclick="javascript:validar(this.form,'ing')">Submit</button>
                                        <button type="button" class="btn btn-default load" onclick="javascript:location.href='<?php echo $url1?>'">Back to Main Menu</button>
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
    <script type="text/javascript" src="//maps.google.com/maps/api/js?sensor=false&language=en"></script>

    <script type="text/javascript">
        $(document).ready(function () {

            navigator.geolocation.getCurrentPosition(showPosition);

            function getDateTimeMysql() {
                var now = new Date();
                var year = now.getFullYear();
                var month = now.getMonth() + 1;
                var day = now.getDate();
                var hour = now.getHours();
                var minute = now.getMinutes();
                var second = now.getSeconds();
                if (month.toString().length == 1) {
                    var month = '0' + month;
                }
                if (day.toString().length == 1) {
                    var day = '0' + day;
                }
                if (minute.toString().length == 1) {
                    var minute = '0' + minute;
                }
                if (second.toString().length == 1) {
                    var second = '0' + second;
                }

                $("#fechaclock").val(year + '-' + month + '-' + day + ' ' + hour + ':' + minute + ':' + second);

            }

            function setDateTimeMap() {
                var d = new Date();
                $("#dateTime").html(d.toString());
                getDateTimeMysql();
            }

            function showPosition(position) {
                var lat = position.coords.latitude;
                var long = position.coords.longitude;

                $("#poslat").val(lat);
                $("#poslong").val(long);
                $("#showPos").html("Latitude: " + lat + "<br>Longitude: " + long);

                setInterval(setDateTimeMap, 1000);

                cargarmap1(lat, long);
            }

            function cargarmap1(lat, long) {

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
            }
        });
    </script>
</body>

</html>