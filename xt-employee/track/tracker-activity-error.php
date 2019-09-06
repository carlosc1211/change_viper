<?php
require_once("../../lib/core.php");
require_once("../../lib/val_session_employee.php");
require_once('../../xt-model/PerfilModel.php');

require('../includes/header.php');

$co_acc = getA("co_acc");
$titcomp = getA("tipo");
$error = getA("error");

$tit1 = "Main Menu";
$tit2 = "Officer Tracker";
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
                    <div class="col-md-12 col-xs-12">
                        <div class="x_panel">
                            <form role="form" action="#">
                                <div class="col-md-12 col-xs-12">
                                    <br><br><br>
                                    <?php 
                                    switch($error)
                                    {
                                        case 1:
                                            $mensaje = "You are out of the property boundaries, please get back to post and try again";
                                        break;
                                    }
                                     ?>
                                     <br><br>
                                    <button class="btn-info btn load col-md-6 col-xs-12" type="button" onclick="javasscript:location.href='tracker-activity.php'"><i class="fa fa-arrow-circle-o-right"></i> Next Check Point</button>
                                    <button class="btn-dark btn load col-md-5 col-xs-12" type="button" onclick="javasscript:location.href='<?php echo $url1?>'">Back to Main Menu</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

                <!-- footer content -->
                    <?php include '../footer.php'; ?>
                <!-- /footer content -->

            </div>
            <!-- /page content -->
        </div>


    </div>

    <?php
    include '../bot-footer.php';
    ?>

</body>

</html>