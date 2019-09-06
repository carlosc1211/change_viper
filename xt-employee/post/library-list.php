<?php
require_once("../../lib/core.php");
require_once("../../lib/val_session_employee.php");
require_once('../../xt-model/PostModel.php');

require('../includes/header.php');


$tit1 = "Post Library";
$url1 = "../main/findex.php";

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
                        <h3><a href="../main/findex.php" class="btn btn-default">Main Menu</a> / <?php echo $tit1 ?></h3>
                    </div>

                </div>
                <div class="clearfix"></div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="x_panel">
                            <!--****************************************************************-->
                            <div class="x_title">
                                <h2>Documents<small>List</small></h2>
                                <div class="clearfix"></div>
                            </div>
                            <!--****************************************************************-->

                            <div class="x_content">
                            <?php
                            if($_SESSION["codclockin"])
                            {
                                $post = new PostModel();
                                $rs = $post->obtener($db, $_SESSION["codclockin"]["co_post"]);

                                if($rs) extract($rs[0]);
                                ?>
                                <table class="table">       

                                <?php
                                    
                                $ruta="../../images/post_docs/$ds_dir";
                                $ruta_online=ONLINE_DIR . "/images/post_docs/$ds_dir";

                                if($ds_dir!='')
                                {
                                    if ($dh = opendir($ruta_online)) 
                                    {    
                                        while (($file = readdir($dh)) !== false) 
                                        {   if ($file!="." && $file!="..")
                                            { ?>

                                                <tr>
                                                    <td>
                                                        <i class="fa fa-file-text-o"></i> <a href="<?php echo $ruta_online?>/<?php echo $file;?>" target="_blank"><?php echo $file;?></a>
                                                    </td>
                                                </tr>
                                            <?php
                                            }
                                        }
                                    }
                                }?> 

                                </table> 
                                <?php                               
                            }
                            else
                            {
                            ?>
                                <br><br>
                                <div class="form-group  col-md-12 col-xs-12">
                                    <div class="alert alert-error" role="alert"><strong>Sorry</strong> You must to Clock In!</div>
                                </div>
                                <button type="button" class="btn btn-default load" onclick="javascript:location.href='<?php echo $url1?>'">Back to Main Menu</button>
                            <?php 
                            } ?>
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


    </div>

    <?php
    include '../includes/bot-footer.php';
    include '../includes/datatables_date.php';
    ?>
</body>

</html>