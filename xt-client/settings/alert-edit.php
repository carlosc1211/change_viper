<?php
require_once("../../lib/core.php");
require_once("../../lib/val_session.php");
require_once('../../xt-model/MiscModel.php');
require_once('../../xt-model/MensajeModel.php');

require('../includes/header.php');

$co_acc = getA("co_acc");


$tit2 = "Edit Alert Emails";
$url2 = "alert-edit.php?co_acc=$co_acc";
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
                        <h3><?php echo $tit2 ?></h3>
                    </div>

                </div>
                <div class="clearfix"></div>

                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="x_panel">
                            <!--****************************************************************-->
                            <div class="x_title">
                                <h2>Form <small> </small></h2>
                                <div class="clearfix"></div>
                            </div>
                            <!--****************************************************************-->

                            <div class="x_content">

                                <?php
                                $param = new MiscModel();
                                $mensaje = new MensajeModel();

                                if(isset($_REQUEST["acc"]))
                                {
                                    if(getA("acc")=="ing")
                                    {
                                        $result = $param->actualizar_param($db,
                                            [
                                                "corr_incident"=>getA("corr_incident"),
                                                "corr_issue"=>getA("corr_issue"),
                                                "corr_track"=>getA("corr_track"),
                                                "corr_daily_log"=>getA("corr_daily_log"),
                                                "header_incident"=>getA("header_incident"),
                                                "footer_incident"=>getA("footer_incident"),
                                                "header_issue"=>getA("header_issue"),
                                                "footer_issue"=>getA("footer_issue"),
                                                "header_track"=>getA("header_track"),
                                                "footer_track"=>getA("footer_track"),
                                                "header_daily_log"=>getA("header_daily_log"),
                                                "footer_daily_log"=>getA("footer_daily_log"),
                                            ]
                                        );

                                        if($result)
                                            echo $mensaje->MensajeRegistro(1,"Record updated successfully");
                                        else
                                            echo $mensaje->MensajeRegistro(2,"Sorry an error has ocurrred");
                                    }
                                }

                                $rs = $param->obtener_param($db);

                                if($rs) extract($rs[0]);

                                ?>

                                <form role="form" action="<?php echo $url2;?>" method="post" name="forma" id="forma">
                                    <div class="" role="tabpanel" data-example-id="togglable-tabs">
                                        <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
                                            <li role="presentation" class="active"><a href="#tab_content1" id="home-tab" role="tab" data-toggle="tab" aria-expanded="true">Email Settings</a>
                                            </li>
                                            <li role="presentation" class=""><a href="#tab_content2" role="tab" id="profile-tab" data-toggle="tab" aria-expanded="false">Email Format</a>
                                            </li>
                                        </ul>
                                        <div id="myTabContent" class="tab-content">
                                            <div role="tabpanel" class="tab-pane fade active in" id="tab_content1" aria-labelledby="home-tab">
                                                <div class="form-group col-md-12">
                                                    <label class="control-label" for="r_ds_id">Incident Alert (Comma separated)</label>
                                                    <textarea name="corr_incident" id="corr_incident" class="form-control"><?php echo $corr_incident ?></textarea>
                                                </div>
                                                <div class="form-group col-md-12">
                                                    <label class="control-label" for="r_ds_id">Internal Communication Alert (Comma separated)</label>
                                                    <textarea name="corr_issue" id="corr_issue" class="form-control"><?php echo $corr_issue ?></textarea>
                                                </div>
                                                <div class="form-group col-md-12">
                                                    <label class="control-label" for="r_ds_id">Officer Tracker Alert (Comma separated)</label>
                                                    <textarea name="corr_track" id="corr_track" class="form-control"><?php echo $corr_track ?></textarea>
                                                </div>
                                                <div class="form-group col-md-12">
                                                    <label class="control-label" for="r_ds_id">Daily Log Alert (Comma separated)</label>
                                                    <textarea name="corr_daily_log" id="corr_daily_log" class="form-control"><?php echo $corr_daily_log ?></textarea>
                                                </div>
                                            </div>
                                            <div role="tabpanel" class="tab-pane fade in" id="tab_content2" aria-labelledby="home-tab">
                                                <div class="form-group col-md-12">
                                                    <label class="control-label" for="r_ds_id">Incident Email Header Format</label>
                                                    <textarea name="header_incident" id="header_incident" class="form-control"><?php echo $header_incident ?></textarea>
                                                </div>
                                                <div class="form-group col-md-12">
                                                    <label class="control-label" for="r_ds_id">Incident Email Footer Format</label>
                                                    <textarea name="footer_incident" id="footer_incident" class="form-control"><?php echo $footer_incident ?></textarea>
                                                </div>
                                                <div class="clearfix"></div>
                                                <br><br>
                                                <div class="form-group col-md-12">
                                                    <label class="control-label" for="r_ds_id">Internal Communication Email Header Format</label>
                                                    <textarea name="header_issue" id="header_issue" class="form-control"><?php echo $header_issue ?></textarea>
                                                </div>
                                                <div class="form-group col-md-12">
                                                    <label class="control-label" for="r_ds_id">Internal Communication Email Footer Format</label>
                                                    <textarea name="footer_issue" id="footer_issue" class="form-control"><?php echo $footer_issue ?></textarea>
                                                </div>
                                                <div class="clearfix"></div>
                                                <br><br>
                                                <div class="form-group col-md-12">
                                                    <label class="control-label" for="r_ds_id">Officer Tracker Email Header Format</label>
                                                    <textarea name="header_track" id="header_track" class="form-control"><?php echo $header_track ?></textarea>
                                                </div>
                                                <div class="form-group col-md-12">
                                                    <label class="control-label" for="r_ds_id">Officer Tracker Email Footer Format</label>
                                                    <textarea name="footer_track" id="footer_track" class="form-control"><?php echo $footer_track ?></textarea>
                                                </div>
                                                <br><br>
                                                <div class="clearfix"></div>
                                                <br><br>
                                                <div class="form-group col-md-12">
                                                    <label class="control-label" for="r_ds_id">Daily Log Email Header Format</label>
                                                    <textarea name="header_daily_log" id="header_daily_log" class="form-control"><?php echo $header_daily_log ?></textarea>
                                                </div>
                                                <div class="form-group col-md-12">
                                                    <label class="control-label" for="r_ds_id">Daily Log Email Footer Format</label>
                                                    <textarea name="footer_daily_log" id="footer_daily_log" class="form-control"><?php echo $footer_daily_log ?></textarea>
                                                </div>
                                                <br><br>
                                            </div>
                                        </div>

                                    <div class="clearfix"></div>
                                    <br><br>
                                    <?php echo putBotonAccion($db,$co_acc,1,''); ?>
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

</body>

</html>