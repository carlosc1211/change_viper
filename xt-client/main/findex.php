<?php
require_once("../../lib/core.php");
require_once("../../lib/val_session.php");
require_once("../../xt-model/MiscModel.php");

$misc = new MiscModel();

$rs = $misc->listarIncident24($db);
extract($rs[0]);

$rs = $misc->listarOfficer24($db);
extract($rs[0]);

require('../includes/header.php');
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

                <br />
                <div class="">

                    <div class="row top_tiles">
                        <a href="../incident/incident-list.php?co_acc=12">
                        <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                            <div class="tile-stats">
                                <div class="icon"><i class="fa fa-exclamation-triangle"></i>
                                </div>
                                <div class="count"><?php echo $cont_incident ?></div>

                                <h3>Incident <br>Reports < 24h</h3>
                            </div>
                        </div>
                        </a>
                        <a href="../report-track/worked-hours-list.php?co_acc=17">
                        <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                            <div class="tile-stats">
                                <div class="icon"><i class="fa fa-check-square-o"></i>
                                </div>
                                <div class="count"><?php echo $cont_officer ?></div>

                                <h3>i-tracker  <br>&nbsp;</h3>
                            </div>
                        </div>
                        </a>
                    </div>

                </div>

                <!-- footer content -->
                    <?php include '../includes/footer.php'; ?>
                <!-- /footer content -->

            </div>
            <!-- /page content -->
        </div>


    </div>
    <script src="../js/bootstrap.min.js"></script>
    <script src="../js/nicescroll/jquery.nicescroll.min.js"></script>

    <!-- chart js -->
    <script src="../js/chartjs/chart.min.js"></script>
    <!-- bootstrap progress js -->
    <script src="../js/progressbar/bootstrap-progressbar.min.js"></script>
    <!-- icheck -->
    <script src="../js/icheck/icheck.min.js"></script>
    <!-- daterangepicker -->
    <script type="text/javascript" src="../js/moment.min2.js"></script>
    <script type="text/javascript" src="../js/datepicker/daterangepicker.js"></script>
    <!-- sparkline -->
    <script src="../js/sparkline/jquery.sparkline.min.js"></script>

    <script src="../js/custom.js"></script>
 

</body>

</html>