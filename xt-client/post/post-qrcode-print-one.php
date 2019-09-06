<?php
require_once("../../lib/core.php");
require_once('../../xt-model/PostModel.php');
require('../includes/header_basic.php');

$tit1 = "Post Check Point QR Code";

$codigo = getA("co_post");
$codigo_point = getA("co_point");
$pos_lat_point = $_GET['pos_lat_point'];
$pos_long_point = $_GET['pos_long_point'];


$post = new PostModel();
$rs = $post->obtener($db,$codigo);
extract($rs[0]);

$nb_post = $nb;

$rs_point = $post->obtener_det_point($db,$codigo_point);


?>

<body class="nav-md">

    <div class="container body">


        <div class="main_container">

            <!-- page content -->
            <div class="right_col" role="main">

                <div class="page-title">

                </div>
                <div class="clearfix"></div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="x_panel">

                            <div class="x_content">
                            <?php

                            if($rs_point)
                            {   extract($rs_point[0]);
                                ?>
                                <h3><?php echo $nb?></h3>
                                <br>
                                <br>
                                <iframe src="det_qrcode.php?pos_lat_point=<?php echo $pos_lat_point?>&pos_long_point=<?php echo $pos_long_point?>&nb=<?php echo $nb?>" align="center" frameborder="0" height="300" width="300"></iframe></td>
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

            </div>
            <!-- /page content -->
        </div>



    <script>
        window.print();
    </script>

</body>

</html>