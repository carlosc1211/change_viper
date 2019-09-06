<?php
require_once("../../lib/core.php");
require_once("../../lib/val_session.php");
require_once('../../xt-model/TrackModel.php');
require_once('../../xt-model/PostModel.php');

require('../includes/header.php');

$co_acc = getA("co_acc");

$tit1 = "i-Tracker";

$url1 = "worked-hours-list.php?co_acc=$co_acc";
$url3 = "worked-hours-edit.php";
$url4 = "worked-hours-list-print.php";
$url5 = "worked-hours-list-pdf.php";
$url6 = "worked-hours-list-excel.php";

$post = new PostModel();

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
                                <div class="clearfix"></div>
                            </div>
                            <!--****************************************************************-->
                            <div class="box-inner">
                                <div class="box-content">
                                    <span><b>Advanced Search</b></span>
                                    <form action="worked-hours-list.php?acc=ser" method="post" name="forma">
                                    <table class="table">
                                      <tr>
                                        <td>From</td>
                                        <td>
                                            <div class='input-group date' id='datetimepicker1'>
                                                <input type='text' class="form-control" name="fe_desde" id="fe_desde" />
                                                <span class="input-group-addon">
                                                    <span class="glyphicon glyphicon-calendar"></span>
                                                </span>
                                            </div>
                                        </td>
                                         <td>To</td>
                                        <td>
                                            <div class='input-group date' id='datetimepicker2'>
                                                <input type='text' class="form-control" name="fe_hasta" id="fe_hasta" />
                                                <span class="input-group-addon">
                                                    <span class="glyphicon glyphicon-calendar"></span>
                                                </span>
                                            </div>                   
                                        </td>
                                      </tr>
                                    </table>
                                    <div class="text-center"><button type="submit" class="btn btn-default">Search</button> </div>
                                    </form>

                                </div>
                            </div>
                            <hr>            

                            <div class="x_content">
                            <?php 
                            $track = new TrackModel();
                            $_SESSION["rs"] = "";

                            if(isset($_REQUEST["acc"]))
                            {
                                $desde = todate_hr(getA("fe_desde"));
                                $hasta = todate_hr(getA("fe_hasta"));

                                $_SESSION["rs"] = $track->listarWorkedFiltered($db,$desde,$hasta,$_SESSION["coduser"]["co"]);
                            }
                            else
                            {    
                                $cont=0;
                                $_SESSION["rs"] = $track->listarWorkedFiltered($db,$desde,$hasta,$_SESSION["coduser"]["co"]);
                            }
                            if($_SESSION["rs"])
                            {	?>
                                <table id="example" class="table table-striped responsive-utilities jambo_table">
                                    <thead>
                                    <tr class="headings">
                                        <th>Clocked In </th>
                                        <th>Employee </th>
                                        <th>Post </th>
                                        <th>Status </th>
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
                                        <td class=" "><?php echo $clocked_in?></td>
                                        <td class=" "><?php echo $nb_emp . ' ' . $apll_emp?></td>
                                        <td class=" "><?php echo $post_name?></td>
                                        <td class=" ">
                                        <?php 
                                        if($stat==1)
                                        {
                                            echo "<div style='color:green'><i class='fa fa-circle'></i> Active</div>";
                                        }
                                        else
                                        {
                                            echo "<div style='color:red'><i class='fa fa-circle'></i> Inactive</div>";
                                        }
                                        ?>
                                        </td>
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
    include '../includes/datatables_date.php';
    ?>
    <script type="text/javascript" src="../../bower_components/moment/min/moment.min.js"></script>
    <script type="text/javascript" src="../../bower_components/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>
    <link rel="stylesheet" href="../../bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css" />
    <script type="text/javascript">
        $(function () {
            $('#datetimepicker1').datetimepicker({  widgetPositioning: { horizontal:'right' }  });
            $('#datetimepicker2').datetimepicker({  widgetPositioning: { horizontal:'right' }  });
        });
    </script>
</body>

</html>