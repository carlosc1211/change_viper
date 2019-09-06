<?php
require_once("../../lib/core.php");
require_once("../../lib/val_session.php");
require_once('../../xt-model/EmergencyServiceModel.php');
require_once('../../xt-model/MensajeModel.php');

require('../includes/header.php');

$co_acc = getA("co_acc");

$tit1 = "Emergency Service";
$tit2 = "New Emergency Service";
$url1 = "emergency-service-list.php?co_acc=$co_acc";
$url2 = "emergency-service-new.php?co_acc=$co_acc";
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
                        <h3><a href="<?php echo $url1?>" class="btn btn-default"><?php echo $tit1 ?></a>/ <a href="<?php echo $url2?>" class="btn btn-default"><?php echo $tit2 ?></a></h3>
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
                                if(isset($_REQUEST["acc"]))
                                {
                                    if(getA("acc")=="ing")
                                    {
                                        $mensaje = new MensajeModel();
                                        $emergencyservice = new EmergencyServiceModel();
                                        $result = $emergencyservice->ingresar($db,
                                            ["nb"=>getA("r_nb"),
                                             "actv"=>check(getA("activo"))]
                                        );

                                        if($result)
                                            echo $mensaje->MensajeRegistro(1,"Record created successfully");
                                        else
                                            echo $mensaje->MensajeRegistro(2,"Sorry an error has ocurrred");

                                    }
                                }

                                ?>

                                <form role="form" action="<?php echo $url2;?>" method="post" name="forma" id="forma">
                                    <div class="form-group ">
                                        <label class="control-label" for="r_nb">Name</label>
                                        <input type="text" class="form-control" name="r_nb" id="r_nb" placeholder="Input Emergency Service" maxlength="70">
                                    </div>
                                    
                                    <div class="form-group ">
                                        <label for="activo"><input name="activo" type="checkbox" class="BotonForm2_det" id="activo"> Active</label>
                                    </div>
                                    <?php echo putBotonAccion($db, $co_acc, 1, ''); ?>
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
</body>

</html>