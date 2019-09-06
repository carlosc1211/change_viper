<?php
require_once("../../lib/core.php");
require_once("../../lib/val_session.php");
require_once('../../xt-model/DailyModel.php');

require('../includes/header.php');

$co_acc = getA("co_acc");

$tit1 = "Daily Log";

$url1 = "daily-log-list.php?co_acc=$co_acc";
$url3 = "daily-log-edit.php";
$url4 = "daily-log-list-print.php";
$url5 = "daily-log-list-pdf.php";
$url6 = "daily-log-list-excel.php";

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
                        <h3><a href="<?php echo $url1?>" class="btn btn-default"><?php echo $tit1 ?></a></h3>
                    </div>

                </div>
                <div class="clearfix"></div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="x_panel">
                            <!--****************************************************************-->
                            <div class="x_title">
                                <h2><?php echo $tit1 ?> Records <small>List</small></h2>
                                <ul class="nav navbar-right panel_toolbox">
                                    <li><a href="<?php echo $url4 ?>" target="_blank" data-toggle="tooltip" data-placement="top" title="Print"><i class="fa fa-print"></i></a></li>
                                    <li><a href="<?php echo $url5 ?>" target="_blank" data-toggle="tooltip" data-placement="top" title="Save as PDF"><i class="fa fa-file-pdf-o"></i></a></li>
                                    <li><a href="<?php echo $url6 ?>" target="_blank" data-toggle="tooltip" data-placement="top" title="Save as Excel Document"><i class="fa fa-file-excel-o"></i></a></li>
                                </ul>
                                <div class="clearfix"></div>
                            </div>
                            <!--****************************************************************-->

                            <div class="x_content">
                            <?php

                            $cont=0;
                            $_SESSION["rs"] = "";
                            $dailymod = new DailyModel();
                            $_SESSION["rs"] = $dailymod->listar($db);

                            if($_SESSION["rs"])
                            {	?>
                                <table id="example" class="table table-striped responsive-utilities jambo_table">
                                    <thead>
                                    <tr class="headings">
                                        <th>Resgistered at </th>
                                        <th>Resgistered by </th>
                                        <th>Post </th>
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
                                        <td class=" "><?php echo $fe_reg?></td>
                                        <td class=" "><?php echo $nb_employee . ' ' . $apll_employee?></td>
                                        <td class=" "><?php echo $post_name?></td>
                                        <td class=" last">
                                            <a href="<?php echo $url3;?>?co=<?php echo $co;?>&amp;co_acc=<?php echo $co_acc ;?>" class="btn btn-default load"><i class="fa fa-search"></i> View</a>
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
    include '../includes/datatables.php';
    ?>
</body>

</html>