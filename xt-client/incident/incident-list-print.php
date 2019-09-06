<?php
require_once("../../lib/core.php");
require('../includes/header_basic.php');

$tit1 = "Incident";

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

                            if($_SESSION["rs"])
                            {	?>
                                <table id="example" class="table table-striped responsive-utilities jambo_table">
                                    <thead>
                                    <tr class="headings">
                                        <th>Incident # </th>
                                        <th>Date</th>
                                        <th>Post</th>
                                        <th>Type</th>
                                        <th>Reported By</th>
                                        <th>Status</th>
                                    </tr>
                                    </thead>

                                    <tbody>
                                    <?php
                                    foreach($_SESSION["rs"] as $rss)
                                    {
                                    extract($rss);
                                    ?>
                                    <tr class="even pointer">
                                        <td class=" "><?php echo $co?></td>
                                        <td class=" "><?php echo $fe_incident?></td>
                                        <td class=" "><?php echo $post_name?></td>
                                        <td class=" "><?php echo $incident_type?></td>
                                        <td class=" "><?php echo $nb_user . ' ' . $apll_user?></td>
                                        <td class=" "><?php echo $stat ?></td>
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
            <!-- /page content -->
        </div>



    <script>
        window.print();
    </script>

</body>

</html>