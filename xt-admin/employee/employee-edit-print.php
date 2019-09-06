<?php
require_once("../../lib/core.php");
require_once('../../xt-model/EmployeeModel.php');
require_once('../../xt-model/StateModel.php');
require_once('../../xt-model/MiscModel.php');
require_once('../../xt-model/MensajeModel.php');

$miscelaneo = new MiscModel();
$estado = new StateModel();
$mensaje = new MensajeModel();
$employee = new EmployeeModel();

require('../includes/header_basic.php');

$codigo = getA("co");

$tit1 = "Employees";

$rs = $employee->obtener($db,$codigo);

if($rs) extract($rs[0]);
?>

<body>
    <page size="A4">
    <table class="table">
        <tr>
            <td colspan="2" class="td-title">Employee General Information</td>
        </tr>        
        <tr>
            <td><img src="../../images/employee/<?php echo $ds_img ?>" alt="" class="img-thumbnail"></td>
            <td>
                <table id="tabla" bgcolor="#000">
                    <tr>
                        <td class="td-40 td-grey td-bold">
                            Employee ID
                        </td>
                        <td class="td-60 td-grey td-bold">
                            Hire Date
                        </td>
                    </tr>
                    <tr>
                        <td class="td-40">
                            <?php echo $ds_id ?>                                                            
                        </td>
                        <td class="td-60">
                            <?php echo $fe_contrato ?>                                                            
                        </td>
                    </tr>
                    <tr>
                        <td class="td-40 td-grey td-bold">
                            First Name
                        </td>
                        <td class="td-60 td-grey td-bold">
                            Middle Name
                        </td>
                    </tr>
                    <tr>
                        <td class="td-40">
                            <?php echo $nb ?>                                                            
                        </td>
                        <td class="td-60">
                            <?php echo $nb_2 ?>                                                            
                        </td>
                    </tr>
                    <tr>
                        <td class="td-40 td-grey td-bold">
                            Last Name
                        </td>
                        <td class="td-60 td-grey td-bold">
                            Address
                        </td>
                    </tr>
                    <tr>
                        <td class="td-40">
                            <?php echo $apll ?>                                                            
                        </td>
                        <td class="td-60">
                            <?php echo $dir ?>                                                            
                        </td>
                    </tr>
                    <tr>
                        <td class="td-40 td-grey td-bold">
                            City
                        </td>
                        <td class="td-60 td-grey td-bold">
                            State
                        </td>
                    </tr>
                    <tr>
                        <td class="td-40">
                            <?php echo $ciudad ?>                                                            
                        </td>
                        <td class="td-60">
                            <?php
                            $rs = $estado->listar($db);

                            foreach($rs as $rss)
                            {
                                extract($rss);
                                
                                if($co==$co_state) echo $nb;
                            }
                            ?>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <table id="tabla" bgcolor="#000">
                    <tr>
                        <td class="td-25 td-grey td-bold">
                            Zip
                        </td>
                        <td class="td-25">
                            <?php echo $ds_zip ?>                                                            
                        </td>
                        <td class="td-25 td-grey td-bold">
                            D.O.B
                        </td>
                        <td class="td-25">
                            <?php echo $fe_nac ?>                                                            
                        </td>
                    </tr>
                    <tr>
                        <td class="td-25 td-grey td-bold">
                            Gender
                        </td>
                        <td class="td-25">
                            <?php
                            $rs = $miscelaneo->listarSexo($db);

                            foreach($rs as $rss)
                            {
                                extract($rss);
                                
                                if($co==$co_sexo) echo $nb; 

                            }
                            ?>
                        </td>
                        <td class="td-25 td-grey td-bold">
                            Ethnicity
                        </td>
                        <td class="td-25">
                            <?php
                            $rs = $miscelaneo->listarEtnia($db);

                            foreach($rs as $rss)
                            {
                                extract($rss);
                                
                                if($co==$co_etnia) echo $nb;

                            }
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="td-25 td-grey td-bold">
                            Language
                        </td>
                        <td class="td-25">
                            <?php
                            $rs = $miscelaneo->listarLenguaje($db);
                            $coma = "";
                        

                            foreach($rs as $rss)
                            {
                                extract($rss);
                                
                                $posicion = "";
                                $posicion = strpos($co_lenguaje,$co);
                                
                                if($posicion!==false)
                                {
                                    echo $coma . " " . $nb; 
                                    $coma = ",";
                                } 
                            }
                            ?>                            
                            <input type="hidden" name="language_other"placeholder="Input Other Language" value="<?php echo $lenguaje_otro?>" class="form-control" name="language_other" maxlength="50">

                        </td>
                        <td class="td-25 td-grey td-bold">
                            Citizen Status
                        </td>
                        <td class="td-25">
                            <?php
                            $rs = $miscelaneo->listarCitizenStat($db);

                            foreach($rs as $rss)
                            {
                                extract($rss);
                                
                                if($co==$co_citizen_stat) echo $nb;

                            }
                            ?>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td colspan="2" class="td-title">Employe Contact Information</td>
        </tr>        
        <tr>
            <td colspan="2">
                <table id="tabla" bgcolor="#000">
                    <tr>
                        <td class="td-25 td-grey td-bold">
                            Email
                        </td>
                        <td class="td-25">
                            <?php echo $corr ?>                                                            
                        </td>
                        <td class="td-25 td-grey td-bold">
                            Phone (Home)
                        </td>
                        <td class="td-25">
                            <?php echo $telf_casa ?>                                                            
                        </td>
                    </tr>
                    <tr>
                        <td class="td-25 td-grey td-bold">
                            Phone (Mobile)
                        </td>
                        <td class="td-25">
                            <?php echo $telf_cel ?>                                                            
                        </td>
                        <td class="td-25 td-grey td-bold">
                            FAX
                        </td>
                        <td class="td-25">
                            <?php echo $telf_fax ?>                                                            
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td colspan="2" class="td-title">Emergency Contact Information</td>
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
                            Relationship
                        </td>
                        <td class="td-25">
                            <?php echo $parentesco_contact ?>                                                            
                        </td>
                    </tr>
                    <tr>
                        <td class="td-25 td-grey td-bold">
                            Phone
                        </td>
                        <td colspan="3" class="td-25">
                            <?php echo $telf_contact ?>                                                            
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td colspan="2" class="td-title">License Information</td>
        </tr>        
        <tr>
            <td colspan="2">
                <table id="tabla" bgcolor="#000">
                    <?php if($lic_manejo_ds){ ?>
                    <tr>
                        <td class="td-40 td-grey td-bold">
                            Driver License
                        </td>
                        <td class="td-40 td-grey td-bold">
                            Issued Date                                                            
                        </td>
                        <td class="td-40 td-grey td-bold">
                            Expiration Date
                        </td>
                    </tr>
                    <tr>
                        <td class="td-30">
                            <?php echo $lic_manejo_ds ?>
                        </td>
                        <td class="td-30">
                            <?php echo $lic_manejo_fe_ini ?>
                        </td>
                        <td class="td-30">
                            <?php echo $lic_manejo_fe_fin ?>
                        </td>
                    </tr>
                    <?php } ?>

                    <?php if($lic_unarmed_ds){ ?>
                    <tr>
                        <td class="td-40 td-grey td-bold">
                            Unarmed License - D
                        </td>
                        <td class="td-40 td-grey td-bold">
                            Issued Date                                                            
                        </td>
                        <td class="td-40 td-grey td-bold">
                            Expiration Date
                        </td>
                    </tr>
                    <tr>
                        <td class="td-30">
                            <?php echo $lic_unarmed_ds ?>
                        </td>
                        <td class="td-30">
                            <?php echo $lic_unarmed_fe_ini ?>
                        </td>
                        <td class="td-30">
                            <?php echo $lic_unarmed_fe_fin ?>
                        </td>
                    </tr>
                    <?php } ?>

                    <?php if($lic_armed_ds){ ?>
                    <tr>
                        <td class="td-40 td-grey td-bold">
                            Armed License - G
                        </td>
                        <td class="td-40 td-grey td-bold">
                            Issued Date                                                            
                        </td>
                        <td class="td-40 td-grey td-bold">
                            Expiration Date
                        </td>
                    </tr>
                    <tr>
                        <td class="td-30">
                            <?php echo $lic_armed_ds ?>
                        </td>
                        <td class="td-30">
                            <?php echo $lic_armed_fe_ini ?>
                        </td>
                        <td class="td-30">
                            <?php echo $lic_armed_fe_fin ?>
                        </td>
                    </tr>
                    <?php } ?>

                    <?php if($lic_firearm_ds){ ?>
                    <tr>
                        <td class="td-40 td-grey td-bold">
                            Concealed / Firearm - W
                        </td>
                        <td class="td-40 td-grey td-bold">
                            Issued Date                                                            
                        </td>
                        <td class="td-40 td-grey td-bold">
                            Expiration Date
                        </td>
                    </tr>
                    <tr>
                        <td class="td-30">
                            <?php echo $lic_firearm_ds ?>
                        </td>
                        <td class="td-30">
                            <?php echo $lic_firearm_fe_ini ?>
                        </td>
                        <td class="td-30">
                            <?php echo $lic_firearm_fe_fin ?>
                        </td>
                    </tr>
                    <?php } ?>

                    <?php if($lic_firstaid_ds){ ?>
                    <tr>
                        <td class="td-40 td-grey td-bold">
                            First AID Certification
                        </td>
                        <td class="td-40 td-grey td-bold">
                            Issued Date                                                            
                        </td>
                        <td class="td-40 td-grey td-bold">
                            Expiration Date
                        </td>
                    </tr>
                    <tr>
                        <td class="td-30">
                            <?php echo $lic_firstaid_ds ?>
                        </td>
                        <td class="td-30">
                            <?php echo $lic_firstaid_fe_ini ?>
                        </td>
                        <td class="td-30">
                            <?php echo $lic_firstaid_fe_fin ?>
                        </td>
                    </tr>
                    <?php } ?>

                </table>
            </td>
        </tr>
    </table>
    <hr>
    <div class="col-md-12">
        <div class="form-group ">
            <label class="control-label" for="r_co_stat_employee">Employee Status: </label>
           
                <?php
                $rs = $employee->listarStatus($db);

                foreach($rs as $rss)
                {
                    extract($rss);
                    
                    if($co==$co_stat_employee) echo $nb ;

                }
                ?>
        </div>
    </div>
</page>
</body>
    <script>
       window.print();
    </script>

</html>