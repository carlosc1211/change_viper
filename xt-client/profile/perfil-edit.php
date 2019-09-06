<?php
require_once("../../lib/core.php");
require_once("../../lib/val_session.php");
require_once('../../xt-model/PerfilModel.php');
require_once('../../xt-model/MensajeModel.php');

$perfil = new PerfilModel();
$mensaje = new MensajeModel();

require('../includes/header.php');

$codigo = getA("co");
$co_acc = getA("co_acc");

$tit1 = "Profiles";
$tit2 = "Edit Profile";
$url1 = "perfil-list.php?co_acc=$co_acc";
$url2 = "perfil-edit.php?co_acc=$co_acc&co=$codigo";
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
                        <h3><a href="<?php echo $url1?>" class="btn btn-default"><?php echo $tit1 ?></a> / <a href="<?php echo $url2?>" class="btn btn-default"><?php echo $tit2 ?></a></h3>
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
                                        $result = $perfil->actualizar($db,
                                            ["co"=>$codigo,
                                             "nb"=>getA("r_nombre"),
                                             "co_rol"=>getA("r_rol"),
                                             "accesos"=>getA("accesos_asgn_add"),
                                             "actv"=>check(getA("activo"))]
                                        );

                                        if($result)
                                            echo $mensaje->MensajeRegistro(1,"Record updated successfully");
                                        else
                                            echo $mensaje->MensajeRegistro(2,"Sorry an error has ocurrred");
                                    }
                                    elseif(getA("acc")=="elim")
                                    {
                                        $result = $perfil->eliminar($db,["co"=>$codigo]);

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

                                $rs = $perfil->obtener($db,$codigo);

                                if($rs) extract($rs[0]);

                                ?>

                                <form role="form" action="<?php echo $url2;?>" method="post" name="forma" id="forma">
                                    <div class="form-group ">
                                        <label class="control-label" for="r_nombre">Name</label>
                                        <input type="text" class="form-control" name="r_nombre" id="r_nombre" placeholder="Input Name" maxlength="50" value="<?php echo $nb?>">
                                    </div>
                                    <div class="form-group ">
                                        <label class="control-label" for="r_titulo">Role</label>
                                        <select name="r_rol" class="form-control" id="r_rol" onChange="javascript:loadAccesos()">
                                            <option value="" selected>Select</option>
                                            <?php
                                            $rs = $perfil->listarRol($db);

                                            foreach($rs as $rss)
                                            {
                                                extract($rss);
                                                ?>
                                                <option value="<?php echo $co ?>" <?php if($co==$co_rol) echo('Selected')?>><?php echo $nb ?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="form-group ">
                                        <label class="control-label" for="accesos">Modules</label>
                                        <select name="accesos" class="form-control" id="accesos">
                                            <option selected>Select</option>
                                            <?php
                                            $rs = $perfil->obtenerModulosLibres($db,$codigo);

                                            foreach($rs as $rss)
                                            {
                                                extract($rss);
                                                ?>
                                                <option value="<?php echo $co ?>" ><?php echo $ds_mod ?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="form-group ">
                                        <div class="col-md-2">
                                            <input name="agregar" type="button" class="form-control" id="agregar" value="&gt;&gt;"  onClick="javascript:add_item(this.form, 'accesos', 'accesos_asgn','accesos_asgn_add')">
                                            <input name="eliminar" type="button" class="form-control" id="eliminar" value="&lt;&lt;"  onClick="javascript:del_item(this.form, 'accesos', 'accesos_asgn','accesos_asgn_add')">
                                        </div>
                                        <div class="col-md-10">
                                            <label class="control-label" for="accesos">Asigned modules</label>
                                            <select name="accesos_asgn" size="5" class="form-control" id="accesos_asgn">
                                                <?php
                                                $sep = "";
                                                $cadena = "";

                                                $rs = $perfil->obtenerModulosAsgn($db,$codigo);

                                                foreach($rs as $rss)
                                                {
                                                    extract($rss);
                                                    ?>
                                                    <option value="<?php echo $co ?>"><?php echo $ds_mod ?></option>
                                                    <?php
                                                    $cadena .= $sep . $co;
                                                    $sep="|";
                                                }
                                                ?>
                                            </select>
                                            <input type="hidden" id="accesos_asgn_add" name="accesos_asgn_add" value="<?php echo $cadena ?>">
                                        </div>
                                    </div>

                                    <br /><br />
                                    <div class="clearfix"></div>
                                    <br /><br />
                                    <div class="form-group ">
                                        <label for="activo"><input name="activo" type="checkbox" class="BotonForm2_det" id="activo" <?php echo cheq($actv) ?>> Active</label>
                                    </div>
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
    <script type="text/javascript">
        function loadAccesos()
        {		 $.ajax({
            type: "get",
            url: "din_accesos.php",
            data: "codrol="+$('#r_rol').val(),
            success: function(msg){
                var strResult = msg.split("|");
                var n = strResult.length;
                var j=1;k=0;
                $("#accesos").removeOption(/./);
                $("#accesos").addOption('0', 'Seleccionar');

                for (var i=1; i<(n/2); i++){
                    $("#accesos").addOption(strResult[k],strResult[j]);
                    k+=2;j=k+1;
                }
                $("#accesos").selectOptions('0');
            }
        });
        }
    </script>
</body>

</html>