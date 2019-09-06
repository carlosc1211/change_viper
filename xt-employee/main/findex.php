<?php
require_once("../../lib/core.php");
require_once("../../lib/val_session_employee.php");
require_once('../../xt-model/TrackModel.php');
require('../includes/header.php');

$track= new TrackModel();
$rs = $track->getActiveClockIn($db);

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
                        <a href="../track/clock-activity-in.php" class="load">
                            <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                <div class="tile-stats">
                                    <div class="icon"><i class="fa fa-clock-o"></i>
                                    </div>
                                    <div class="count">Clock In</div>
                                    <h3>Check in</h3>
                                </div>
                            </div>
                        </a>
                        <a href="../track/clock-activity-out.php" class="load">
                            <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                <div class="tile-stats">
                                    <div class="icon"><i class="fa fa-clock-o"></i>
                                    </div>
                                    <div class="count">Clock Out</div>
                                    <h3>Check out</h3>
                                </div>
                            </div>
                        </a>
                        <a href="../track/tracker-activity.php" class="load">
                            <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                <div class="tile-stats">
                                    <div class="icon"><i class="fa fa-map-marker"></i>
                                    </div>
                                    <div class="count">Officer </div>
                                    <h3>Tracker</h3>
                                </div>
                            </div>
                        </a>
                        <a href="../track/daily-log-list.php" class="load">
                        <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                            <div class="tile-stats">
                                <div class="icon"><i class="fa fa-calendar"></i>
                                </div>
                                <div class="count">Daily Log</div>
                                <h3>Activity</h3>
                            </div>
                        </div>
                        </a>
                        <a href="../incident/incident-list.php" class="load">
                        <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                            <div class="tile-stats">
                                <div class="icon"><i class="fa fa-file-text-o"></i>
                                </div>
                                <div class="count">Incident</div>
                                <h3>Report</h3>
                            </div>
                        </div>
                        </a>
                        <a href="../issue/issue-list.php" class="load">
                            <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                <div class="tile-stats">
                                    <div class="icon"><i class="fa fa-exclamation-circle"></i>
                                    </div>
                                    <div class="count">Internal</div>
                                    <h3>Comm. Report</h3>
                                </div>
                            </div>
                        </a>
                        <a href="../device/device-list.php" class="load">
                            <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                <div class="tile-stats">
                                    <div class="icon"><i class="fa fa-car"></i>
                                    </div>
                                    <div class="count">Equipment</div>
                                    <h3>Report</h3>
                                </div>
                            </div>
                        </a>
                        <a href="../maintenance/maintenance-list.php" class="load">
                            <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                <div class="tile-stats">
                                    <div class="icon"><i class="fa fa-wrench"></i>
                                    </div>
                                    <div class="count">Maintenance</div>
                                    <h3>Report</h3>
                                </div>
                            </div>
                        </a>
                        <a href="../post/library-list.php" class="load">
                            <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                <div class="tile-stats">
                                    <div class="icon"><i class="fa fa-book"></i>
                                    </div>
                                    <div class="count">Post</div>
                                    <h3>Library</h3>
                                </div>
                            </div>
                        </a>
                        <a href="../track/clock-activity-in1.php" class="load">
                            <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                <div class="tile-stats">
                                    <div class="icon"><i class="fa fa-qrcode"></i>
                                    </div>
                                    <div class="count">QR Reader</div>
                                    <h3>Scan QR</h3>
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


    <?php include '../includes/bot-footer.php'; ?>
</body>

</html>