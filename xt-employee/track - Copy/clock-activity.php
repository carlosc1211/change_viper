<?php
require_once("../../lib/core.php");
require_once("../../lib/val_session_employee.php");
require_once('../../xt-model/TrackModel.php');
require_once('../../xt-model/PostModel.php');

$clockreg = new TrackModel();
$post = new PostModel();

require('../includes/header.php');

$co_acc = getA("co_acc");
$tipo = getA("tipo");

if($tipo==1)
{   $titcomp = "In";    }
else
{   $titcomp = "Out";    }

$tit1 = "Main Menu";
$tit2 = "Clock $titcomp";
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
                        <h3><a href="<?php echo $url1?>" class="btn btn-default"><?php echo $tit1 ?></a> / <a href="<?php echo $url2?>" class="btn btn-default"><?php echo $tit2 ?></a></h3>
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
                                    $result = $clockreg->ClockLog($db,
                                        [
                                            "fechaclock"=>getA("fechaclock"),
                                            "poslat"=>getA("poslat"),
                                            "poslong"=>getA("poslong"),
                                            "tipo"=>getA("tipo"),
                                            "co_post"=>getA("r_co_post"),
                                            "coduser"=>$_SESSION["codemployee"]["co"]
                                        ]
                                    );

                                    if($result)
                                    {
                                    ?>
                                        <script>
                                            document.location.href = 'clock-register.php?tipo=<?php echo $tipo?>';
                                        </script>
                                    <?php
                                    }


                                }
                            }

                            ?>

                            <form action="clock-activity.php?acc=ing" method="post" name="forma" id="forma">
                                <input type="hidden" name="fechaclock" id="fechaclock" value="">
                                <input type="hidden" name="poslat" id="poslat" value="">
                                <input type="hidden" name="poslong" id="poslong" value="">
                                <input type="hidden" name="tipo" id="tipo" value="<?php echo $tipo ?>">
                                <div class="col-md-6 col-xs-12 bg-success">
                                    <div class="form-group  ">
                                        <h3>Current Position</h3>
                                        <div id="showPos"></div>
                                        <br>
                                        <div class="col-md-12 col-xs-12">
                                            <div id="map" style="height: 300px"></div>
                                        </div>
                                        <div class="clearfix"></div>
                                        <br>
                                    </div>
                                </div>
                                <div class="col-md-6 col-xs-12">
                                    <div class="form-group ">
                                        <label class="control-label" for="r_co_post">Select Post</label>
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

                                    <br>
                                    <button type="button" class="btn btn-dark" onclick="javascript:validar(this.form,'ing')">Submit</button>
                                    <button class=" btn-dark btn" type="button" onclick="javasscript:location.href='findex.php'">Back to Main Menu</button>
                                </div>
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
    });
    </script>

</body>

</html>