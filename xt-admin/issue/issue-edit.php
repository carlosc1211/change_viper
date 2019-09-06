<?php
require_once("../../lib/core.php");
require_once("../../lib/val_session.php");
require_once('../../xt-model/IssueModel.php');
require_once('../../xt-model/EmployeeModel.php');
require_once('../../xt-model/PostModel.php');
require_once('../../xt-model/MensajeModel.php');

$mensaje = new MensajeModel();
$issue = new IssueModel();
$employee = new EmployeeModel();
$post = new PostModel();

require('../includes/header.php');

$codigo = getA("co");
$co_acc = getA("co_acc");

$tit1 = "Internal Communication";
$tit2 = "Edit Internal Communication";
$url1 = "issue-list.php?co_acc=$co_acc";
$url2 = "issue-edit.php?co_acc=$co_acc&co=$codigo";
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
                        <h3><a href="<?php echo $url1?>" class="btn btn-default"><?php echo $tit1 ?></a>/ <?php echo $tit2 ?></h3>
                    </div>

                </div>
                <div class="clearfix"></div>

                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="x_panel">
                            <!--****************************************************************-->
                            <div class="x_title">
                                <h2>Form <small> </small></h2>
                                 <a href="issue-edit-print.php?co=<?php echo $codigo ?>" target="_blank" class="btn btn-default pull-right"><i class="fa fa-print"></i> Print</a>
                                <div class="clearfix"></div>
                            </div>
                            <!--****************************************************************-->

                            <div class="x_content">

                                <?php

                                if(isset($_REQUEST["acc"]))
                                {
                                    if(getA("acc")=="ing")
                                    {
                                        $result = $issue->actualizar_admin($db,
                                            [
                                                "co"=>$codigo,
                                                "co_employee"=>getA("r_co_employee"),
                                                "co_issue_stat"=>getA("r_co_issue_stat"),
                                                "co_post"=>getA("r_post"),
                                                "fe_issue"=>todate_hr(getA("r_fe_issue")),
                                                "ds"=>getA("ds"),
                                                "ds_actions"=>getA("ds_actions")
                                            ]
                                        );

                                        if($result)
                                            echo $mensaje->MensajeRegistro(1,"Record updated successfully");
                                        else
                                            echo $mensaje->MensajeRegistro(2,"Sorry an error has ocurrred");
                                    }
                                    elseif(getA("acc")=="elim")
                                    {
                                        $result = $issue->eliminar($db,["co"=>$codigo]);

                                        if($result)
                                            echo $mensaje->MensajeRegistro(1,"Record deleted successfully");
                                        else
                                            echo $mensaje->MensajeRegistro(2,"Sorry an error has ocurrred");

                                        ?>
                                        <script>
                                        var redirectTimeout = setTimeout( function() { window.location = '<?php echo $url1?>'; }, 3000 );
                                        </script>
                                        <?php
                                    }
                                }

                                $rs = $issue->obtener($db,$codigo);

                                if($rs) extract($rs[0]);

                                ?>

                                <form role="form" action="<?php echo $url2;?>" method="post" name="forma" id="forma">
                                    <div class="" role="tabpanel" data-example-id="togglable-tabs">
                                        <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
                                            <li role="presentation" class="active"><a href="#tab_content1" id="home-tab" role="tab" data-toggle="tab" aria-expanded="true">General</a>
                                            </li>
                                            <li role="presentation" class=""><a href="#tab_content2" role="tab" id="profile-tab" data-toggle="tab" aria-expanded="false">Actions Log</a>
                                            </li>
                                        </ul>
                                        <div id="myTabContent" class="tab-content">
                                            <div role="tabpanel" class="tab-pane fade active in" id="tab_content1" aria-labelledby="home-tab">


                                                <div class="col-md-6 col-xs-12">
                                                    <div class="form-group ">
                                                        <label class="control-label" for="r_co_employee">Reported by</label>
                                                        <select name="r_co_employee" readonly class="form-control" id="r_co_employee">
                                                            <option value="" selected>Select</option>
                                                            <?php
                                                            $rs = $employee->listarActivos($db);

                                                            foreach($rs as $rss)
                                                            {
                                                                extract($rss);
                                                                ?>
                                                                <option value="<?php echo $co ?>" <?php if($co==$co_employee) echo "selected"?>><?php echo $nb . '' . $apll ?></option>
                                                                <?php
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-6 col-xs-12">
                                                    <label class="control-label" for="r_post">Post</label>
                                                    <select name="r_post" readonly class="form-control" id="r_post">
                                                        <option value="" selected>Select</option>
                                                        <?php
                                                        $rs = $post->listarActivos($db);

                                                        foreach($rs as $rss)
                                                        {
                                                            extract($rss);
                                                            ?>
                                                            <option value="<?php echo $co ?>" <?php if($co==$co_post) echo "selected"?>><?php echo $nb ?></option>
                                                            <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="col-md-6 col-xs-12">
                                                    <div class="form-group ">
                                                        <label class="control-label" for="r_fe_issue">Issue Date</label>
                                                        <div class='input-group date' id='datetimepicker1'>
                                                            <input type='text' readonly class="form-control" name="r_fe_issue" id="r_fe_issue" value="<?php echo $fe_issue?>" />
                                                                            <span class="input-group-addon">
                                                                                <span class="glyphicon glyphicon-calendar"></span>
                                                                            </span>
                                                        </div>

                                                    </div>
                                                </div>
                                                <div class="form-group col-md-12 col-xs-12">
                                                    <label class="control-label" for="ds">Issue Description</label>
                                                    <textarea class="form-control" readonly name="ds" id="ds" rows="10"><?php echo $ds?></textarea>
                                                </div>
                                            </div>
                                            <div role="tabpanel" class="tab-pane fade in" id="tab_content2" aria-labelledby="home-tab">

                                                <div class="well well-sm"><strong>Add comment to actual status</strong></div>

                                                <div class="form-group col-md-6 col-xs-12">
                                                    <label class="control-label" for="r_co_issue_stat">Issue Status</label>
                                                    <select name="r_co_issue_stat" class="form-control" id="r_co_issue_stat">
                                                        <option value="" selected>Select</option>
                                                        <?php
                                                        $rs = $issue->listarIssuestat($db);

                                                        foreach($rs as $rss)
                                                        {
                                                            extract($rss);
                                                            ?>
                                                            <option value="<?php echo $co ?>" <?php if($co==$co_issue_stat) echo "selected"?>><?php echo $nb ?></option>
                                                            <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="form-group col-md-12 col-xs-12">
                                                    <label class="control-label" for="ds_actions">Issue comment</label>
                                                    <textarea class="form-control" name="ds_actions" id="ds_actions" rows="3"></textarea>
                                                </div>

                                                <div class="clearfix"></div>
                                                <br><br>
                                                <div class="well well-sm"><strong>Logs</strong></div>

                                                <table id="example" class="table table-striped responsive-utilities jambo_table">
                                                    <thead>
                                                    <tr class="headings">
                                                        <th>Date</th>
                                                        <th>User</th>
                                                        <th>Status</th>
                                                        <th>Comment</th>
                                                    </tr>
                                                    </thead>

                                                    <tbody>
                                                    <?php
                                                    $rst = $issue->actionsLog($db,$codigo);

                                                    foreach($rst as $rsts)
                                                    {
                                                        extract($rsts);
                                                        ?>
                                                        <tr class="even pointer">
                                                            <td class=" "><?php echo $fe_issue_action?></td>
                                                            <td class=" "><?php echo $nb_user . ' ' . $apll_user?></td>
                                                            <td class=" "><?php echo $nb_stat?></td>
                                                            <td class=" "><?php echo html_entity_decode($ds_actions)?></td>
                                                        </tr>
                                                        <?php
                                                    }
                                                    ?>
                                                    </tbody>
                                                </table>
                                            </div>

                                                <br /><br />
                                    <div class="clearfix"></div>
                                    <?php echo putBotonAccion($db,$co_acc,1,''); ?>
                                    <?php echo putBotonAccion($db,$co_acc,3,$tit1); ?>
                                    <button type="button" class="btn btn-default" onclick="javascript:location.href='<?php echo $url1?>'">Back</button>
                                </form>



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



    <?php
    include '../includes/bot-footer.php';
    ?>
    <script src="../ckeditor/ckeditor.js" type="text/javascript"></script>
    <script type="text/javascript" src="../../bower_components/moment/min/moment.min.js"></script>
    <script type="text/javascript" src="../../bower_components/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>
    <link rel="stylesheet" href="../../bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css" />

    <script type="text/javascript">
        $(function () {
            $('#datetimepicker1').datetimepicker({  widgetPositioning: { horizontal:'right' }  });
        });

        $(document).ready(function () {
            CKEDITOR.replace('ds');
        });
    </script>
</body>

</html>