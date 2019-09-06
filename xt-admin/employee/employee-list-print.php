<?php
require_once("../../lib/core.php");
require('../includes/header_basic.php');

$tit1 = "Employees";

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
                                        <th>First Name</th>
                                        <th>Last Name</th>
                                        <th>Mobile</th>
                                        <th>Email</th>
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
                                        <td><?php echo $nb?></td>
                                        <td><?php echo $apll?></td>
                                        <td><?php echo $telf_cel?></td>
                                        <td><a mailto="<?php echo $corr?>"><?php echo $corr?></a></td>
                                        <td><?php echo $stat_employee?></td>
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