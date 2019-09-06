<?php
require_once("../../lib/core.php");
require_once("../../lib/phpqrcode/qrlib.php");
require_once('../../xt-model/PostModel.php');
require('../includes/header_basic.php');


$tit1 = "";
$codigo = getA("co_post");
$gate = getA("gate");

$post = new PostModel();
$rs = $post->obtener($db,$codigo);
extract($rs[0]);
$nb_post = $nb;

$rs_point = $post->obtener_point_activos($db,$codigo);



if($gate==0)  
    $tit1 = "Post Check Point QR Code";
?>

<body class="nav-md">

    <div class="container body">


        <div class="main_container">

            <!-- page content -->
            <div class="right_col" role="main">

                <div class="page-title">
                    <div class="title_left">
                        <h3><?php echo $tit1 ?></h3>
                    </div>

                </div>
                <div class="clearfix"></div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="x_panel">

                            <div class="x_content">
                            <?php

                            if($rs_point)
                            {	

                                if($gate==0)
                                {
                                ?>
                                <table id="example" class="table responsive-utilities jambo_table">
                                    <thead>
                                    <tr class="headings">
                                        <th>Check Point Name</th>
                                        <th>QR Code Image</th>
                                    </tr>
                                    <tr class="even pointer">
                                        <td><?php echo $nb_post?> - Start Point</td>
                                        <td><iframe src="det_qrcode.php?pos_lat_point=<?php echo $codigo?>&pos_long_point=0&nb=<?php echo $nb_post?>" frameborder="0" height="300" width="300"></iframe></td>
                                    </tr>
                                    </thead>

                                    <tbody>
                                    <?php
                                  
                                        foreach($rs_point as $rss)
                                        {
                                        extract($rss);
                                        ?>
                                        <tr class="even pointer">
                                            <td><?php echo $nb?></td>
                                            <td><iframe src="det_qrcode.php?pos_lat_point=<?php echo $latitude?>&pos_long_point=<?php echo $longitude?>&nb=<?php echo $nb?>" frameborder="0" height="300" width="300"></iframe></td>
                                        </tr>
                                        <?php
                                        }
                                    ?>
                                    </tbody>

                                </table>
                                <?php
                                }
                                else
                                { ?>
                                <h3><?php echo $nb_post?> - Start Point</h3>
                                <br>
                                <br>
                                <iframe src="det_qrcode.php?pos_lat_point=<?php echo $codigo?>&pos_long_point=0&nb=<?php echo $nb_post?>" align="center" frameborder="0" height="300" width="300"></iframe></td>
                                <?php
                                }

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