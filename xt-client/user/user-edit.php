<?php
require_once("../../lib/core.php");
require_once("../../lib/val_session.php");
require_once('../../xt-model/UsuarioModel.php');
require_once('../../xt-model/PerfilModel.php');
require_once('../../xt-model/MensajeModel.php');

$mensaje = new MensajeModel();
$usuario = new UsuarioModel();
$perfil= new PerfilModel();

require('../includes/header.php');

$codigo = getA("co");
$co_acc = getA("co_acc");

$tit1 = "Users";
$tit2 = "Edit User";
$url1 = "user-list.php?co_acc=$co_acc";
$url2 = "user-edit.php?co_acc=$co_acc&co=$codigo";
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
                                        $result = $usuario->actualizar($db,
                                            ["co"=>$codigo,
                                             "nb"=>getA("r_nombre"),
                                             "apll"=>getA("r_apellido"),
                                             "telf"=>getA("telefono"),
                                             "corr"=>getA("r_correo"),
                                             "usr"=>getA("r_usuario"),
                                             "pwd"=>hash('sha256',getA("r_clave"),false),
                                             "co_rol"=>getA("r_rol"),
                                             "co_perfil"=>nulo(getA("perfil")),
                                             "actv"=>check(getA("activo"))], $_REQUEST
                                        );

                                        if($result)
                                            echo $mensaje->MensajeRegistro(1,"Record created successfully");
                                        else
                                            echo $mensaje->MensajeRegistro(2,"Sorry an error has ocurrred");

                                    }
                                    elseif(getA("acc")=="elim")
                                    {
                                        $result = $usuario->eliminar($db,["co"=>$codigo]);

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

                                $rs = $usuario->obtener($db,$codigo);

                                if($rs) extract($rs[0]);
                                ?>

                                <form role="form" action="<?php echo $url2;?>" method="post" name="forma" id="forma">
                                    <div class="form-group ">
                                        <label class="control-label" for="r_nombre">First Name</label>
                                        <input type="text" class="form-control" name="r_nombre" id="r_nombre" placeholder="Input First Name" maxlength="50" value="<?php echo $nb?>">
                                    </div>
                                    <div class="form-group ">
                                        <label class="control-label" for="r_apellido">Last Name</label>
                                        <input type="text" class="form-control" name="r_apellido" id="r_apellido" placeholder="Input Last Name" maxlength="50" value="<?php echo $apll?>">
                                    </div>
                                    <div class="form-group ">
                                        <label class="control-label" for="telefono">Phone</label>
                                        <input type="text" class="form-control" name="telefono" id="telefono" placeholder="Input Phone" maxlength="70" value="<?php echo $telf?>">
                                    </div>
                                    <div class="form-group ">
                                        <label class="control-label" for="r_nombre">Email</label>
                                        <input type="text" class="form-control" name="r_correo" id="r_correo" placeholder="Input Email" maxlength="150" value="<?php echo $corr?>" onBlur="javascript:validaemail2('forma','r_correo')" data-placement="bottom" data-content="Coloque un email valido">
                                    </div>
                                    <div class="form-group ">
                                        <label class="control-label" for="r_titulo">Role</label>
                                        <select name="r_rol" class="form-control" id="r_rol" onChange="javascript:gen_perfil()">
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
                                        <label class="control-label" for="perfil">Profile</label>
                                        <select name="perfil" class="form-control" id="perfil" onChange="javascript:actAccesos()">
                                            <option selected>Select</option>
                                            <?php
                                            $rs = $perfil->obtenerPerfilRol($db,$co_rol);

                                            foreach($rs as $rss)
                                            {
                                                extract($rss);

                                                ?>
                                                <option value="<?php echo $co ?>" <?php if($co==$co_perfil) echo('Selected')?>><?php echo $nb ?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="form-group ">
                                        <label class="control-label" for="accesos">Access</label>
                                        <div id="divAccUser" class="col-md-12">
                                            <table width='100%' cellspacing='1' cellpadding='1'>
                                                <tr bgcolor='#cccccc'>
                                                    <td>Option Menu / Module</td>
                                                    <td align='center'>Create</td>
                                                    <td align='center'>Update</td>
                                                    <td align='center'>Delete</td>
                                                </tr>
                                                <?php
                                                $rs = $cn->getUserAccesoModEdit($db,$co_perfil,$codigo);

                                                foreach($rs as $rss)
                                                {
                                                    extract($rss);
                                                    ?>
                                                    <tr>
                                                        <td><?php echo "$grupo / $ds_mod" ?></td>
                                                        <td align='center'><input name='ing<?php echo $co ?>' id='ing<?php echo $co ?>' type='checkbox' class='BotonForm2_det'  <?php echo cheq($ingresa) ?>/></td>
                                                        <td align='center'><input name='mod<?php echo $co ?>' id='mod<?php echo $co ?>' type='checkbox' class='BotonForm2_det'  <?php echo cheq($modifica) ?> /></td>
                                                        <td align='center'><input name='elim<?php echo $co ?>' id='elim<?php echo $co ?>' type='checkbox' class='BotonForm2_det'  <?php echo cheq($elimina) ?> /></td>
                                                    </tr>
                                                    <?php
                                                }
                                                ?>
                                            </table>

                                        </div>
                                    </div>
                                    <hr>
                                    <div class="form-group ">
                                        <label class="control-label" for="perfil">User</label>
                                        <input name="r_usuario" type="text" class="form-control" id="r_usuario"  maxlength="10" onBlur="javascript:verif_usr()" value="<?php echo $usr ?>">
                                    </div>
                                    <div class="form-group ">
                                        <label class="control-label" for="perfil">Password</label>
                                        <input name="r_clave" type="password" class="form-control" id="r_clave"  maxlength="10" value="">
                                    </div>
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
        function actAccesos()
        {	$.ajax({
            type: "get",
            url: "din_acc_user.php",
            data: "co_perfil="+$('#perfil').val(),
            success: function(msg){
                $("#divAccUser").html(msg);
            }
        });
        }

        function verif_usr()
        {		$.ajax({
            type: "get",
            url: "din_verif_user.php",
            data: "ds_usr="+$('#r_usuario').val(),
            success: function(msg){
                if(parseInt(msg)==1)
                {	alert('Sorry. User exists');	$('#r_usuario').focus(); $('#r_usuario').select(); }
            }
        });
        }

        function gen_perfil()
        {		var rol =$('#r_rol').val();
            if(rol==1) {
                $('#perfil').removeAttr("disabled");
                $.ajax({
                    type: "get",
                    url: "din_perfil.php",
                    data: "codrol="+rol,
                    success: function(msg){
                        var strResult = msg.split("|");
                        var n = strResult.length;
                        var j=1;k=0;
                        $("#perfil").removeOption(/./);
                        $("#perfil").addOption('0', 'Select');

                        for (var i=1; i<(n/2); i++){
                            $("#perfil").addOption(strResult[k],strResult[j]);
                            k+=2;j=k+1;
                        }
                        $("#perfil").selectOptions('0');
                    }
                });
            } else {
                $("#perfil").removeOption(/./);
                $("#perfil").addOption('0', 'Select');
                $("#perfil").selectOptions('0');
                $('#perfil').attr("disabled", true);
            }
        }
    </script>

</body>

</html>