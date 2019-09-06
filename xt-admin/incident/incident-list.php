<?php
require_once("../../lib/core.php");
require_once("../../lib/val_session.php");
require_once('../../xt-model/IncidentModel.php');
require_once('../../xt-model/PostModel.php');

require('../includes/header.php');

$co_acc = getA("co_acc");

$post = new PostModel();

$tit1 = "Incidents";
$tit2 = "New Incident";
$url1 = "incident-list.php?co_acc=$co_acc";
$url2 = "incident-new.php?co_acc=$co_acc";
$url3 = "incident-edit.php";
$url4 = "incident-list-print.php";
$url5 = "incident-list-pdf.php";
$url6 = "incident-list-excel.php";

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
                                <?php
                                registro_new($db,$tit1,$url2,'Add New');
                                ?>
                                <ul class="nav navbar-right panel_toolbox">
                                    <li><a href="<?php echo $url4 ?>" target="_blank" data-toggle="tooltip" data-placement="top" title="Print"><i class="fa fa-print"></i></a></li>
                                    <li><a href="<?php echo $url5 ?>" target="_blank" data-toggle="tooltip" data-placement="top" title="Save as PDF"><i class="fa fa-file-pdf-o"></i></a></li>
                                    <li><a href="_<?php echo $url6 ?>" target="_blank" data-toggle="tooltip" data-placement="top" title="Save as Excel Document"><i class="fa fa-file-excel-o"></i></a></li>
                                </ul>
                                <div class="clearfix"></div>
                            </div>
                            <!--****************************************************************-->
                            <div class="box-inner">
                                <div class="box-content">
                                    <span><b>Advanced Search</b></span>
                                    <form action="incident-list.php?acc=ser" method="post" name="forma">
                                    <table class="table">
                                      <tr>
                                        <td>Post</td>
                                        <td colspan="3">
                                            <select name="co_post" class="form-control" id="co_post">
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
                                        </td>
                                      </tr>
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

                            $cont=0;
                            $_SESSION["rs"] = "";
                            $incident = new IncidentModel();
                            if(isset($_REQUEST["acc"]))
                            {
                                $desde = todate_hr(getA("fe_desde"));
                                $hasta = todate_hr(getA("fe_hasta"));
                                $co_post = getA("co_post");

                                $_SESSION["rs"] = $incident->listar($db,$desde,$hasta,$co_post);
                            }
                            else
                            {                              
                                $_SESSION["rs"] = $incident->listar($db,$desde,$hasta,$co_post);
                            }

                            if($_SESSION["rs"])
                            {	?>
                                <table id="example" class="table table-striped responsive-utilities jambo_table">
                                    <thead>
                                    <tr class="headings">
                                        <th>Incident # </th>
                                        <th>Date</th>
                                        <th>Post</th>
                                        <th>Type</th>
                                        <th>Reported By</th>
                                        <th>Status</th>

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
                                        <td class=" "><?php echo $fe_incident?></td>
                                        <td class=" "><?php echo $post_name?></td>
                                        <td class=" "><?php echo $incident_type?></td>
                                        <td class=" "><?php echo $nb_user . ' ' . $apll_user?></td>
                                        <td class=" "><?php echo $stat ?></td>
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