<?php
require_once("../../lib/core.php");
require_once("../../lib/val_session.php");
require_once('../../xt-model/DailyModel.php');
require_once('../../xt-model/MensajeModel.php');
$dailymod = new DailyModel();
require('../includes/header_basic.php');

require('../includes/header.php');

$codigo = getA("co");
$co_acc = getA("co_acc");

$tit1 = "Daily Log Activity";
$tit2 = "Edit Daily Log Activity";
$url1 = "daily-log-list.php?co_acc=$co_acc";
$url2 = "daily-log-edit.php?co_acc=$co_acc&co=$codigo";

$rs = $dailymod->obtener_in($db,$codigo);
if($rs) extract($rs[0]);

$_dir = $ds_dir;
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
                        <?php  
                        $rs_incident = $dailymod->valDailyLogClient($db,$codigo,$_SESSION["coduser"]["co"]);
                        if($rs_incident) 
                        {?>                            
                            <!--****************************************************************-->
                            <div class="x_title">
                                <h2>Form <small> </small></h2>
                                 <a href="daily-log-edit-print.php?co=<?php echo $codigo ?>" target="_blank" class="btn btn-default pull-right"><i class="fa fa-print"></i> Print</a>

                                <div class="clearfix"></div>
                            </div>
                            <!--****************************************************************-->

                            <div class="x_content">

                                <page size="A4">
                                    <div style="background-color:#ccc;padding:10px"><strong><?php echo html_entity_decode($header_daily_log) ?></strong></div>    
                                <table class="table">
                                    <tr>
                                        <td colspan="2" class="td-title">Daily Log General Information</td>
                                    </tr>        
                                    <tr>
                                        <td>
                                            <table id="tabla" bgcolor="#000">
                                                <tr>
                                                    <td colspan="2" class="td-grey td-bold">
                                                        Post
                                                    </td>
                                                </tr>
                                                <tr>                        
                                                    <td colspan="2">
                                                        <?php echo $post_name?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="td-50 td-grey td-bold">
                                                        Report by
                                                    </td>
                                                    <td class="td-50 td-grey td-bold">
                                                        Report at
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="td-50">
                                                        <?php echo $nb_employee . ' ' . $apll_employee?>
                                                    </td>
                                                    <td class="td-50">
                                                        <?php echo $fe_reg?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2" class="td-grey td-bold">
                                                        Description
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2">
                                                        <?php echo html_entity_decode($obs) ?>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                </table>
                            </page>

                            <page size="A4">
                                <table class="table">
                                    <tr>
                                        <td colspan="2" class="td-title">Daily Log Pictures</td>
                                    </tr>        

                                    <?php
                                        
                                    $ruta="../../images/daily-activity/$_dir";
                                    $ruta_online=ONLINE_DIR . "/images/daily-activity/$_dir";

                                    if($_dir!='')
                                    {
                                        if ($dh = opendir($ruta)) 
                                        {    
                                            while (($file = readdir($dh)) !== false) 
                                            {   if ($file!="." && $file!="..")
                                                { ?>

                                                    <tr>
                                                        <td class="thumbnail">
                                                            <img src="<?php echo $ruta_online?>/<?php echo $file;?>" alt="" style="max-width:400px;max-height:300px;display: block;">
                                                        </td>
                                                    </tr>
                                                <?php
                                                }
                                            }
                                        }
                                    }?> 


                                </table><br><br>
                                <hr>
                                    <div class="col-md-12">
                                        <p >
                                            <?php echo html_entity_decode($footer_daily_log) ?>
                                        </p>
                                    </div>
                                    <div class="clearfix"></div>
                                </page>
                            <?php 
                            } else { ?>
                                <h4>You don't have permissions to see this information.</h4>
                            <?php } ?>
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
    <script type="text/javascript">

        $(document).ready(function () {
            $(".aColor").colorbox({rel:'aColor'});
            CKEDITOR.replace('ds');
        
        });
    </script>
</body>

</html>