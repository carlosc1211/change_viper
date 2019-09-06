<?php
require_once("../../lib/core.php");
require('../includes/header_basic.php');

$tit1 = "Posts";

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
                                        <th>Post Id</th>
                                        <th>Post Name</th>
                                        <th>City</th>
                                        <th>State</th>
                                        <th>Contact Name</th>
                                        <th>Phone</th>
                                        <th>Email</th>
                                        <th>Active</th>
                                    </tr>
                                    </thead>

                                    <tbody>
                                    <?php
                                    foreach($_SESSION["rs"] as $rss)
                                    {
                                    extract($rss);
                                    ?>
                                    <tr class="even pointer">
                                        <td><?php echo $ds_id?></td>
                                        <td><?php echo $nb?></td>
                                        <td><?php echo $ciudad?></td>
                                        <td><?php echo $state?></td>
                                        <td><?php echo $nb_contact?></td>
                                        <td><?php echo $telf?></td>
                                        <td><a mailto="<?php echo $corr?>"><?php echo $corr?></a></td>
                                        <td class=" "><?php if($actv==1){echo('<span class="label-success label label-default">Yes</span>');}else{echo('<span class="label-default label label-danger">No</span>');}?></td>
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