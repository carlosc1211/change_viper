<?php
$tit1 = "Post iTracker List";

header('Content-type: application/vnd.ms-excel');
header("Content-Disposition: attachment; filename=$tit1.xls");
header("Pragma: no-cache");
header("Expires: 0");

require_once("../../lib/core.php");

?>

<body class="nav-md">

    <div class="container body">


        <div class="main_container">


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

                            if($_SESSION["rs"])
                            {	?>
                                <table id="example" class="table table-striped responsive-utilities jambo_table">
                                    <thead>
                                    <tr class="headings">
                                        <th>Employee </th>
                                        <th>Post </th>
                                        <th>Check Point</th>
                                        <th>Date / Time</th>
                                    </tr>
                                    </thead>

                                    <tbody>
                                    <?php
                                    foreach($_SESSION["rs"] as $rss)
                                    {
                                        extract($rss);
                                        ?>
                                        <tr class="even pointer">
                                            <td class=" "><?php echo $nb_emp . ' ' . $apll_emp?></td>
                                            <td class=" "><?php echo $post_name?></td>
                                            <td class=" "><?php echo $nb_point?></td>
                                            <td class=" "><?php echo $fe_reg_track?></td>
                                        </tr>
                                        <?php
                                    }
                                    ?>
                                    </tbody>

                                </table>
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

        </div>



    <script>
        window.print();
    </script>

</body>

</html>