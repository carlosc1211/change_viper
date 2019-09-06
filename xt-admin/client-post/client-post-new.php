<?php
require_once("../../lib/core.php");
require_once("../../lib/val_session.php");
require_once('../../xt-model/UsuarioModel.php');
require_once('../../xt-model/PostModel.php');
require_once('../../xt-model/ClientPostModel.php');
require_once('../../xt-model/MensajeModel.php');

require('../includes/header.php');



$mensaje = new MensajeModel();
$usuario = new UsuarioModel();
$post = new PostModel();
$clientpost = new ClientPostModel();

$co_acc = getA("co_acc");

$tit1 = "Client / Post Match";
$tit2 = "New Client / Post Match";
$url1 = "client-post-list.php?co_acc=$co_acc";
$url2 = "client-post-new.php?co_acc=$co_acc";
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
                                        $result = $clientpost->ingresar($db,
                                            ["client"=>getA("r_client"),
                                             "post_asgn_add"=>getA("post_asgn_add")]
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
                                        <label class="control-label" for="r_client">Client User</label>
                                        <select name="r_client" class="form-control" id="r_client">
                                            <option value="" selected>Select</option>
                                            <?php
                                            $rs = $usuario->listarClientesActivos($db);

                                            foreach($rs as $rss)
                                            {
                                                extract($rss);
                                                ?>
                                                <option value="<?php echo $co_user ?>"><?php echo $company . " - " . $usr ?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="form-group ">
                                        <div class="form-group ">
                                            <label class="control-label" for="post">Post</label>
                                            <select name="post" class="form-control" id="post">
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
                                        </div>
                                    </div>
                                    <div class="form-group ">
                                        <div class="col-md-2">
                                            <input name="agregar" type="button" class="form-control" id="agregar" value="&gt;&gt;"  onClick="javascript:add_item(this.form, 'post', 'post_asgn','post_asgn_add')">
                                            <input name="eliminar" type="button" class="form-control" id="eliminar" value="&lt;&lt;"  onClick="javascript:del_item(this.form, 'post', 'post_asgn','post_asgn_add')">
                                        </div>
                                        <div class="col-md-10">
                                            <label class="control-label" for="post">Asigned Post</label>
                                            <select name="post_asgn" size="5" class="form-control" id="post_asgn"></select>
                                            <input type="hidden" id="post_asgn_add" name="post_asgn_add">
                                        </div>
                                    </div>

                                    <br /><br />
                                    <div class="clearfix"></div>
                                    <br /><br />
                                    <?php echo putBotonAccion($db,$co_acc,1,''); ?>
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