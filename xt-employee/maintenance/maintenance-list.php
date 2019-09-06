<?php
require_once("../../lib/core.php");
require_once("../../lib/val_session_employee.php");
require_once('../../xt-model/MaintenanceModel.php');

$maintenance = new MaintenanceModel();

require('../includes/header.php');

$co_acc = getA("co_acc");

$tit1 = "Maintenance";
$tit2 = "New Maintenance";
$url1 = "maintenance-list.php";
$url2 = "maintenance-new.php";
$url3 = "maintenance-edit.php";

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
                        <h3><a href="../main/findex.php" class="btn btn-default">Main Menu</a> / <?php echo $tit1 ?></h3>
                    </div>

                </div>
                <div class="clearfix"></div>

                <div class="row">
                    <div class="col-md-12 col-xs-12">
                        <div class="x_panel">
                            <!--****************************************************************-->
                            <div class="x_title">
                                <h2><?php echo $tit1 ?> Records <small>List</small></h2>
                                <br><br>
                                <a href="<?php echo $url2?>" class="btn btn-md btn-dark pull-left load"><i class="glyphicon glyphicon-plus-sign"></i> Add New</a>
                                <div class="clearfix"></div>
                            </div>
                            <!--****************************************************************-->

                            <div class="x_content">
                            <?php

                            $cont=0;
                            $_SESSION["rs"] = "";
                            $_SESSION["rs"] = $maintenance->listar_propios($db,$_SESSION["codemployee"]["co"]);

                            if($_SESSION["rs"])
                            {	?>
                                <table id="example" class="table table-striped responsive-utilities jambo_table">
                                    <thead>
                                    <tr class="headings">
                                        <th>Incident # </th>
                                        <th>Date</th>
                                        <th>Post</th>
                                        <th class=" no-link last"><span class="nobr">Action</span>
                                        </th>
                                    </tr>
                                    </thead>

                                    <tbody>
                                    <?php
                                    foreach($_SESSION["rs"] as $rss)
                                    {
                                    extract($rss);
                                    ?>
                                    <tr class="even pointer">
                                        <td class=" "><?php echo $co?></td>
                                        <td class=" "><?php echo $fe_reg?></td>
                                        <td class=" "><?php echo $post_name?></td>
                                        <td class=" last">
                                            <a href="<?php echo $url3;?>?co=<?php echo $co;?>&amp;co_acc=<?php echo $co_acc ;?>" class="btn btn-default load"><i class="fa fa-pencil"></i> Edit</a>
                                        </td>
                                    </tr>
                                    <?php
                                    }
                                    ?>
                                    </tbody>

                                </table>
                                <?php
                            }
                            else
                            {	?>
                                <div class="alert alert-info">
                                    <button type="button" class="close" data-dismiss="alert">×</button>
                                    <strong>Sorry</strong> 0 Records found.
                                </div>
                                <?php
                            }
                            ?>

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


    </div>

    <?php
    include '../includes/bot-footer.php';
    include '../includes/datatables_date.php';
    ?>
</body>

</html>