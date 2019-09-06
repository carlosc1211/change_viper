<?php
require_once("../../lib/core.php");
require_once("../../lib/val_session.php");
require_once("../../xt-model/MiscModel.php");

$misc = new MiscModel();

$rs = $misc->listarIncident24($db);
extract($rs[0]);

$rs = $misc->listarInternalComm24($db);
extract($rs[0]);

$rs = $misc->listarEquipment24($db);
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
                        <a href="../issue/issue-list.php?co_acc=14">
                        <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                            <div class="tile-stats">
                                <div class="icon"><i class="fa fa-comments-o"></i>
                                </div>
                                <div class="count"><?php echo $cont_internalcomm ?></div>

                                <h3>Internal Communications</h3>
                            </div>
                        </div>
                        </a>
                        <a href="../report-device/device-list.php?co_acc=25">
                        <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                            <div class="tile-stats">
                                <div class="icon"><i class="fa fa-sort-amount-desc"></i>
                                </div>
                                <div class="count"><?php echo $cont_equipment ?></div>

                                <h3>Equipment <br>Reports</h3>
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
                    <br><hr><br>
                    <div class="row">
                                <div class="x_content">
                                    <div class="col-md-3 col-sm-12 col-xs-12">
                                        <div>
                                            <div class="x_title">
                                                <h2>Clocked Out Officer >8h</h2>
                                                
                                                <div class="clearfix"></div>
                                            </div>
                                            <ul class="list-unstyled top_profiles scroll-view">
                                            <?php
                                            $rs = $misc->listarOfficerClocked8($db);

                                            if($rs)
                                            {
                                                foreach($rs as $rss)
                                                {
                                                extract($rss);
                                                ?>
                                                    <li class="media event">
                                                        <div class="media-body">
                                                            <a class="title" href="../employee/employee-edit.php?co=<?php echo $co_employee ?>&co_acc=16">
                                                            <?php echo $nb_employee . ' ' . $apll_employee . " ($acumulado Hours)"?></a>
                                                            <p><small><strong><i class="fa fa-envelope-o"></i>: </strong> <?php echo $corr_employee  ?></small></p>
                                                            <p><small><strong><i class="fa fa-phone"></i>: </strong> <?php echo $telf_casa  ?></small></p>
                                                            <p><small><strong><i class="fa fa-mobile"></i>: </strong> <?php echo $telf_cel  ?></small></p>
                                                            </p>
                                                        </div>
                                                    </li>
                                                <?php 
                                                }
                                            }
                                            else
                                                echo "<li><p>Not records found</p></li>";
                                                ?>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-12 col-xs-12">
                                        <div>
                                            <div class="x_title">
                                                <h2>Post Uncheck</h2>
                                                
                                                <div class="clearfix"></div>
                                            </div>
                                            <ul class="list-unstyled top_profiles scroll-view">
                                            <?php
                                            $rs = $misc->listarPostUncheck($db);
                                            if($rs)
                                            {
                                                foreach($rs as $rss)
                                                {
                                                extract($rss);
                                                ?>
                                                    <li class="media event">
                                                        <div class="media-body">
                                                            <a class="title" href="../post/post-edit.php?co=<?php echo $co_post_uncheck ?>&co_acc=10">
                                                            <?php echo $nb_post_uncheck . ' ' . $ds_id_post_uncheck ?></a>
                                                            </p>
                                                        </div>
                                                    </li>
                                                <?php 
                                                }
                                            }
                                            else
                                                echo "<li><p>Not records found</p></li>";
                                                ?>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-12 col-xs-12">
                                        <div>
                                            <div class="x_title">
                                                <h2>Active Post</h2>
                                                
                                                <div class="clearfix"></div>
                                            </div>
                                            <ul class="list-unstyled top_profiles scroll-view">
                                            <?php
                                            $rs = $misc->listarActivePost($db);
                                            if($rs)
                                            {
                                                foreach($rs as $rss)
                                                {
                                                extract($rss);
                                                ?>
                                                    <li class="media event">
                                                        <div class="media-body">
                                                            <a class="title" href="../post/post-edit.php?co=<?php echo $co_post_active ?>&co_acc=10">
                                                            <?php echo $nb_post_active . ' ' . $ds_id_post_active ?></a>
                                                            </p>
                                                        </div>
                                                    </li>
                                                <?php 
                                                }
                                            }
                                            else
                                                echo "<li><p>Not records found</p></li>";
                                                ?>
                                            </ul>
                                        </div>
                                    </div>                                                                        

                                    <div class="col-md-3 col-sm-12 col-xs-12">
                                        <div>
                                            <div class="x_title">
                                                <h2>Inactive Officers</h2>
                                                
                                                <div class="clearfix"></div>
                                            </div>
                                            <ul class="list-unstyled top_profiles scroll-view">
                                            <?php
                                            $rs = $misc->listarOfficerStack($db);
                                            if($rs)
                                            {
                                                foreach($rs as $rss)
                                                {
                                                extract($rss);
                                                ?>
                                                    <li class="media event">
                                                        <div class="media-body">
                                                            <a class="title" href="../employee/employee-edit.php?co=<?php echo $co_employee_inactive ?>&co_acc=16">
                                                            <?php echo $nb_employee_stack . ' ' . $apll_employee_stack ?></a>
                                                            <p><small><strong><i class="fa fa-envelope-o"></i>: </strong> <?php echo $corr_employee_stack  ?></small></p>
                                                            <p><small><strong><i class="fa fa-phone"></i>: </strong> <?php echo $telf_casa_stack  ?></small></p>
                                                            <p><small><strong><i class="fa fa-mobile"></i>: </strong> <?php echo $telf_cel_stack  ?></small></p>
                                                            </p>
                                                        </div>
                                                    </li>
                                                <?php 
                                                }
                                            }
                                            else
                                                echo "<li><p>Not records found</p></li>";
                                                ?>
                                            </ul>
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