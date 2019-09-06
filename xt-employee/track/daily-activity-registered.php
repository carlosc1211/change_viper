<?php
require_once("../../lib/core.php");
require_once("../../lib/val_session_employee.php");
require_once('../../xt-model/PerfilModel.php');

require('../includes/header.php');

$co_acc = getA("co_acc");
$titcomp = getA("tipo");


$tit1 = "Main Menu";
$tit2 = "Daily Activity";
$url1 = "daily-log-list.php?co_acc=$co_acc";
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
                            <form role="form" action="#">
                                <div class="col-md-12 col-xs-12">
                                    <br><br><br>
                                    <div  class="alert alert-success" role="alert"><i class="fa fa-check-circle-o" style="font-size: 24px"></i> Daily Activity Submited</div>
                                    <br><br>
                                    <button class="btn-dark btn load" type="button" onclick="javasscript:location.href='<?php echo $url1?>'">Back</button>
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