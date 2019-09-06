<?php
require_once("../../lib/core.php");
require_once('../../xt-model/PostModel.php');
require_once('../../xt-model/StateModel.php');
require_once('../../xt-model/MensajeModel.php');

$estado = new StateModel();
$mensaje = new MensajeModel();
$post = new PostModel();

require('../includes/header_basic.php');

$codigo = getA("co");

$tit1 = "Post";

$rs = $post->obtener($db,$codigo);

if($rs) extract($rs[0]);

?>

<body>
    <page size="A4">
    <table class="table">
        <tr>
            <td colspan="2" class="td-title">Post General Information</td>
        </tr>        
        <tr>
            <td colspan="2">
                <table id="tabla" bgcolor="#000">
                    <tr>
                        <td class="td-25 td-grey td-bold">
                            Post ID
                        </td>
                        <td class="td-25">
                            <?php echo $ds_id ?>                                                            
                        </td>
                        <td class="td-25 td-grey td-bold">
                            Post Name
                        </td>
                        <td class="td-25">
                            <?php echo $nb ?>                                                            
                        </td>
                    </tr>
                    <tr>
                        <td class="td-25 td-grey td-bold">
                            Industry
                        </td>
                        <td class="td-25">
                            <?php echo $ds_industria?>
                        </td>
                        <td class="td-25 td-grey td-bold">
                            Address
                        </td>
                        <td class="td-25">
                            <?php echo $dir?>
                        </td>
                    </tr>
                    <tr>
                        <td class="td-25 td-grey td-bold">
                            City
                        </td>
                        <td class="td-25">
                            <?php echo $ciudad?>
                        </td>
                        <td class="td-25 td-grey td-bold">
                            State
                        </td>
                        <td class="td-25">
                            <?php
                            $rs = $estado->listar($db);

                            foreach($rs as $rss)
                            {
                                extract($rss);
                                
                                if($co==$co_state)  echo $nb;

                            }
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="td-25 td-grey td-bold">
                            Zip
                        </td>
                        <td class="td-25">
                            <?php echo $ds_zip?>
                        </td>
                        <td class="td-25 td-grey td-bold">
                            Active
                        </td>
                        <td class="td-25">
                            <input name="activo" disabled="true" type="checkbox" class="BotonForm2_det" id="activo" <?php echo cheq($actv) ?>>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td colspan="2" class="td-title">Post Contact Information</td>
        </tr>        
        <tr>
            <td colspan="2">
                <table id="tabla" bgcolor="#000">
                    <tr>
                        <td class="td-25 td-grey td-bold">
                            Contact Name
                        </td>
                        <td class="td-25">
                            <?php echo $nb_contact ?>                                                            
                        </td>
                        <td class="td-25 td-grey td-bold">
                            Title
                        </td>
                        <td class="td-25">
                            <?php echo $title ?>                                                            
                        </td>
                    </tr>
                    <tr>
                        <td class="td-25 td-grey td-bold">
                            Email
                        </td>
                        <td class="td-25">
                            <?php echo $corr?>
                        </td>
                        <td class="td-25 td-grey td-bold">
                            Phone (Home)
                        </td>
                        <td class="td-25">
                            <?php echo $telf?>
                        </td>
                    </tr>
                    <tr>
                        <td class="td-25 td-grey td-bold">
                            Phone (Mobile)
                        </td>
                        <td class="td-25">
                            <?php echo $telf_cel?>
                        </td>
                        <td class="td-25 td-grey td-bold">
                            FAX
                        </td>
                        <td class="td-25">
                            <?php echo $telf_otro?>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td colspan="2" class="td-title">Other Contact Information</td>
        </tr>        
        <tr>
            <td colspan="2">
                <table id="tabla" bgcolor="#000">
                    <tr>
                        <td class="td-25 td-grey td-bold">
                            Contact Name
                        </td>
                        <td class="td-25">
                            <?php echo $nb_contact_other ?>                                                            
                        </td>
                        <td class="td-25 td-grey td-bold">
                            Title
                        </td>
                        <td class="td-25">
                            <?php echo $title_other ?>                                                            
                        </td>
                    </tr>
                    <tr>
                        <td class="td-25 td-grey td-bold">
                            Phone
                        </td>
                        <td colspan="3" class="td-25">
                            <?php echo $telf_contact_other?>                                                            
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</page>
</body>
    <script>
       window.print();
    </script>

</html>