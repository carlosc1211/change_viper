<?php
require_once("../../lib/core.php");
require_once("../../lib/val_session.php");
require_once('../../xt-model/IssueModel.php');
require_once('../../xt-model/EmployeeModel.php');
require_once('../../xt-model/PostModel.php');
require_once('../../xt-model/MensajeModel.php');

$mensaje = new MensajeModel();
$issue = new IssueModel();
$employee = new EmployeeModel();
$post = new PostModel();

require('../includes/header_basic.php');

$codigo = getA("co");

$tit1 = "Internal Communication";

$rs = $issue->obtener($db,$codigo);

if($rs) extract($rs[0]);
?>

<body>
    <page size="A4">
        <div style="background-color:#ccc;padding:10px"><strong><?php echo html_entity_decode($header_issue) ?></strong></div>    
    <table class="table">
        <tr>
            <td colspan="2" class="td-title">General Information</td>
        </tr>        
        <tr>
            <td colspan="2">
                <table id="tabla" bgcolor="#000">
                    <tr>
                        <td class="td-50 td-grey td-bold">
                            Reported by
                        </td>
                        <td class="td-50 td-grey td-bold">
                            Post
                        </td>
                    </tr>
                    <tr>
                        <td class="td-50">
                            <?php
                            $rs = $employee->listarActivos($db);

                            foreach($rs as $rss)
                            {
                                extract($rss);
                                
                                if($co==$co_employee) echo $nb . '' . $apll;

                            }
                            ?>
                        </td>
                        <td class="td-50">
                            <?php
                            $rs = $post->listarActivos($db);

                            foreach($rs as $rss)
                            {
                                extract($rss);
                                
                                if($co==$co_post) echo $nb;

                            }
                            ?>

                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" class="td-50 td-grey td-bold">
                            Issue Date
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" class="td-50">
                            <?php echo $fe_issue ?>                                                            
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" class="td-50 td-grey td-bold">
                            Issue Description
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" class="td-50">
                            <?php echo html_entity_decode($ds) ?>                                                            
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td colspan="2" class="td-title">Logs</td>
        </tr>        
        <tr>
            <td colspan="2">
                <table id="example" class="table table-striped responsive-utilities jambo_table">
                    <thead>
                    <tr class="headings">
                        <th>Date</th>
                        <th>User</th>
                        <th>Status</th>
                        <th>Comment</th>
                    </tr>
                    </thead>

                    <tbody>
                    <?php
                    $rst = $issue->actionsLog($db,$codigo);

                    foreach($rst as $rsts)
                    {
                        extract($rsts);
                        ?>
                        <tr class="even pointer">
                            <td class=" "><?php echo $fe_issue_action?></td>
                            <td class=" "><?php echo $nb_user . ' ' . $apll_user?></td>
                            <td class=" "><?php echo $nb_stat?></td>
                            <td class=" "><?php echo html_entity_decode($ds_actions)?></td>
                        </tr>
                        <?php
                    }
                    ?>
                    </tbody>
                </table>
            </td>
        </tr>
    </table>><br><br>
    <hr>
    <footer>
        <div class="col-md-12">
            <p >
                <?php echo html_entity_decode($footer_issue) ?>
            </p>
        </div>
        <div class="clearfix"></div>
    </footer>
</page>
</body>
    <script>
       window.print();
    </script>

</html>