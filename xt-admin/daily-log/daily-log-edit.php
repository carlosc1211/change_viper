<?php
require_once("../../lib/core.php");
require_once("../../lib/val_session.php");
require_once('../../xt-model/DailyModel.php');
require_once('../../xt-model/MensajeModel.php');

require('../includes/header.php');

$codigo = getA("co");
$co_acc = getA("co_acc");

$tit1 = "Daily Log Activity";
$tit2 = "Edit Daily Log Activity";
$url1 = "daily-log-list.php?co_acc=$co_acc";
$url2 = "daily-log-edit.php?co_acc=$co_acc&co=$codigo";
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
                                 <a href="daily-log-edit-print.php?co=<?php echo $codigo ?>" target="_blank" class="btn btn-default pull-right"><i class="fa fa-print"></i> Print</a>

                                <div class="clearfix"></div>
                            </div>
                            <!--****************************************************************-->

                            <div class="x_content">

                                <?php
                                $dailymod = new DailyModel();
                                $mensaje = new MensajeModel();

                                if(isset($_REQUEST["acc"]))
                                {
                                    if(getA("acc")=="ing")
                                    {
                                        $result = $dailymod->actualizar($db,
                                            [
                                            "co"=>$codigo,
                                            "obs"=>getA("ds")
                                            ]
                                        );

                                        if($result)
                                            echo $mensaje->MensajeRegistro(1,"Record updated successfully");
                                        else
                                            echo $mensaje->MensajeRegistro(2,"Sorry an error has ocurrred");
                                    }
                                    elseif(getA("acc")=="elim")
                                    {
                                        $result = $dailymod->eliminar($db,["co"=>$codigo]);

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

                                $rs = $dailymod->obtener_in($db,$codigo);

                                if($rs) extract($rs[0]);

                                $_dir = $ds_dir;


                                ?>

                                <form role="form" action="<?php echo $url2;?>" method="post" name="forma" id="forma">
                                    <input type="hidden" id="_dir" name="_dir" value="<?php echo $_dir?>" >

                                    <div class="" role="tabpanel" data-example-id="togglable-tabs">
                                        <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
                                            <li role="presentation" class="active"><a href="#tab_content1" id="home-tab" role="tab" data-toggle="tab" aria-expanded="true">General</a>
                                            </li>
                                            <li role="presentation" class=""><a href="#tab_content2" role="tab" id="profile-tab" data-toggle="tab" aria-expanded="false"><i class="fa fa-camera"></i> Pictures</a>
                                            </li>
                                        </ul>
                                        <div id="myTabContent" class="tab-content">
                                            <div role="tabpanel" class="tab-pane fade active in" id="tab_content1" aria-labelledby="home-tab">

                                                <div class="col-md-12 col-sm-12">
                                                    <br><br>
                                                    <div class="form-group ">
                                                        <label class="control-label" for="r_employee">Report by</label>
                                                        <?php echo $nb_employee . ' ' . $apll_employee?>
                                                    </div>
                                                    <div class="form-group ">
                                                        <label class="control-label" for="r_employee">Report at</label>
                                                        <?php echo $fe_reg?>
                                                    </div>
                                                    <div class="form-group ">
                                                        <label class="control-label" for="r_employee">Post</label>
                                                        <?php echo $post_name?>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label" for="accesos">Description</label>
                                                        <textarea name="ds" id="ds" class="form-control" rows="8" ><?php echo html_entity_decode($obs)?></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div role="tabpanel" class="tab-pane fade in" id="tab_content2" aria-labelledby="home-tab">
                                            <?php
                                                
                                            $ruta="../../images/daily-activity/$ds_dir";

                                            if($ds_dir!='')
                                            {
                                                if ($dh = opendir($ruta)) 
                                                {    
                                                    while (($file = readdir($dh)) !== false) 
                                                    {   if ($file!="." && $file!="..")
                                                        { ?>

                                                            <div class="col-md-3 col-sm-6 col-xs-12 hero-feature">
                                                                <div class="thumbnail">
                                                                    <a title="" href="<?php echo $ruta?>/<?php echo $file;?>" class="aColor"><img src="<?php echo $ruta?>/<?php echo $file;?>" alt="" style="display: block;max-height:99px"></a>
                                                                </div>
                                                            </div>
                                                        <?php
                                                        }
                                                    }
                                                }
                                            }?>                                                    
                                            </div>
                                        </div>
                                    </div>
                                    <div class="clearfix"></div>
                                    <br>
                                    <?php echo putBotonAccion($db,$co_acc,1,'Update'); ?>
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
    <script type="text/javascript">

        $(document).ready(function () {
            $(".aColor").colorbox({rel:'aColor'});
            CKEDITOR.replace('ds');
        
        });
    </script>
</body>

</html>