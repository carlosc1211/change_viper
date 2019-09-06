<?php
require_once("../../lib/core.php");
require_once("../../lib/val_session.php");
require_once('../../xt-model/DailyModel.php');

$dailymod = new DailyModel();

require('../includes/header_basic.php');

$codigo = getA("co");

$tit1 = "Daily Log Activity";

$rs = $dailymod->obtener_in($db,$codigo);
if($rs) extract($rs[0]);

$_dir = $ds_dir;

?>

<body>
    <page size="A4">
        <div style="background-color:#ccc;padding:10px"><strong><?php echo html_entity_decode($header_daily_log) ?></strong></div>    
    <table class="table">
        <tr>
            <td colspan="2" class="td-title">Daily Log General Information</td>
        </tr>        
        <tr>
            <td>
                <table id="tabla" bgcolor="#000">
                    <tr>
                        <td colspan="2" class="td-grey td-bold">
                            Post
                        </td>
                    </tr>
                    <tr>                        
                        <td colspan="2">
                            <?php echo $post_name?>
                        </td>
                    </tr>
                    <tr>
                        <td class="td-50 td-grey td-bold">
                            Report by
                        </td>
                        <td class="td-50 td-grey td-bold">
                            Report at
                        </td>
                    </tr>
                    <tr>
                        <td class="td-50">
                            <?php echo $nb_employee . ' ' . $apll_employee?>
                        </td>
                        <td class="td-50">
                            <?php echo $fe_reg?>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" class="td-grey td-bold">
                            Description
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <?php echo html_entity_decode($obs) ?>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</page>

<page size="A4">
    <table class="table">
        <tr>
            <td colspan="2" class="td-title">Daily Log Pictures</td>
        </tr>        

        <?php
            
        $ruta="../../images/daily-activity/$_dir";
        $ruta_online=ONLINE_DIR . "/images/daily-activity/$_dir";

        if($_dir!='')
        {
            if ($dh = opendir($ruta)) 
            {    
                while (($file = readdir($dh)) !== false) 
                {   if ($file!="." && $file!="..")
                    { ?>

                        <tr>
                            <td class="thumbnail">
                                <img src="<?php echo $ruta_online?>/<?php echo $file;?>" alt="" style="max-width:400px;max-height:300px;display: block;">
                            </td>
                        </tr>
                    <?php
                    }
                }
            }
        }?> 


    </table><br><br>
    <hr>
    <footer>
        <div class="col-md-12">
            <p >
                <?php echo html_entity_decode($footer_daily_log) ?>
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