<?php
require_once("../../lib/core.php");
require_once('../../xt-model/ClientPostModel.php');

$clientpost = new ClientPostModel();
ob_start();
require_once("../includes/header_basic.php");

$tit1 = "Client / Post Match";

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
                                        <th>Client User </th>
                                        <th>Post </th>
                                    </tr>
                                    </thead>

                                    <tbody>
                                    <?php
                                    foreach($_SESSION["rs"] as $rss)
                                    {
                                    extract($rss);
                                    ?>
                                    <tr class="even pointer">
                                        <td class=" "><strong><?php echo $company?></strong><br><?php echo $nb?></td>
                                        <td class=" ">
                                            <ul class="unstyled-list">
                                            <?php
                                            $rst = $clientpost->obtenerPostAssigned($db,$co);

                                            foreach($rst as $rsst)
                                            {
                                                extract($rsst);
                                                ?>
                                                <li><?php echo $nb_post ?></li>
                                                <?php
                                            }
                                            ?>
                                            </ul>
                                        </td>                                    </tr>
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



</body>

</html>

<?php
$content = ob_get_clean();

// convert in PDF
require_once('../html2pdf_v4.03/html2pdf.class.php');
try
{
    $html2pdf = new HTML2PDF('P', 'A4', 'en');
    $html2pdf->setDefaultFont('Arial');
    $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
    $html2pdf->Output('$tit1.pdf');
}
catch(HTML2PDF_exception $e) {
    echo $e;
    exit;
}

?>