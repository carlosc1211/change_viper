<?php
require_once("../lib/core.php");
require_once("../lib/val_session_employee.php");
require_once('../xt-model/EmployeeModel.php');
require_once('../xt-model/MensajeModel.php');

require('header.php');

$tit1 = "Main Menu";
$tit2 = "Edit Profile";
$url1 = "findex.php";
$url2 = "profile.php";
?>

<body class="nav-md">

    <div class="container body">


        <div class="main_container">

            <div class="col-md-3 left_col">
                <?php include 'menu.php'; ?>
            </div>

            <!-- top navigation -->
                <?php include 'top-menu.php'; ?>
            <!-- /top navigation -->


            <!-- page content -->
            <div class="right_col" role="main">

                <div class="page-title">
                    <div class="title_left">
                        <h3><a href="<?php echo $url1?>"><?php echo $tit1 ?></a> / <a href="<?php echo $url2?>"><?php echo $tit2 ?></a></h3>
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
                                $mensaje = new MensajeModel();
                                $profile = new EmployeeModel();

                                if(isset($_REQUEST["acc"]))
                                {
                                    if(getA("acc")=="ing")
                                    {
                                        $result = $profile->actualizar_user(
                                            [
                                                "co"=>$_SESSION["codemployee"]["co"],
                                                "corr"=>getA("r_correo"),
                                                "pwd"=>hash('sha256',getA("r_clave"),false),
                                            ]
                                        );

                                        if($result)
                                            echo $mensaje->MensajeRegistro(1,"Record created successfully");
                                        else
                                            echo $mensaje->MensajeRegistro(2,"Sorry an error has ocurrred");

                                    }
                                }

                                $rs = $profile->obtener_user($_SESSION["codemployee"]["co"]);

                                if($rs) extract($rs);
                                ?>

                                <form role="form" action="<?php echo $url2;?>" method="post" name="forma" id="forma">
                                    <div class="form-group ">
                                        <label class="control-label" for="r_nombre">Email</label>
                                        <input type="text" class="form-control" name="r_correo" id="r_correo" placeholder="Input Email" maxlength="150" value="<?php echo $corr?>" onBlur="javascript:validaemail2('forma','r_correo')" data-placement="bottom" data-content="Coloque un email valido">
                                    </div>
                                    <div class="form-group ">
                                        <label class="control-label" for="perfil">Password</label>
                                        <input name="r_clave" type="password" class="form-control" id="r_clave"  maxlength="10" value="">
                                    </div>
                                    <button type="button" class="btn btn-dark" onclick="javascript:validar(this.form,'ing')">Submit</button>
                                    <button type="button" class="btn btn-default" onclick="javascript:location.href='<?php echo $url1?>'">Back</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- footer content -->
                <?php include 'footer.php'; ?>
            <!-- /footer content -->
            </div>
            <!-- /page content -->
        </div>
    <?php
    include 'bot-footer.php';
    ?>
</body>
</html>