<?php
require_once("../../lib/core.php");
require_once("../../lib/val_session.php");
require_once('../../xt-model/EmployeeModel.php');
require_once('../../xt-model/StateModel.php');
require_once('../../xt-model/MiscModel.php');
require_once('../../xt-model/MensajeModel.php');

$miscelaneo = new MiscModel();
$estado = new StateModel();
$mensaje = new MensajeModel();
$employee = new EmployeeModel();

require('../includes/header.php');

$co_acc = getA("co_acc");

$tit1 = "Employees";
$tit2 = "New Employee";
$url1 = "employee-list.php?co_acc=$co_acc";
$url2 = "employee-new.php?co_acc=$co_acc";

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
                        <h3><a href="<?php echo $url1?>" class="btn btn-default"><?php echo $tit1 ?></a>/ <?php echo $tit2 ?></h3>
                    </div>

                </div>
                <div class="clearfix"></div>

                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="x_panel">
                            <!--****************************************************************-->
                            <div class="x_title">
                                <h2>Form <small> </small></h2>
                                <div class="clearfix"></div>
                            </div>
                            <!--****************************************************************-->

                            <div class="x_content">

                                <?php
                                if(isset($_REQUEST["acc"]))
                                {
                                    if(getA("acc")=="ing")
                                    { 
                                        $result = $employee->ingresar($db,
                                            [
                                                "ds_id"=>getA("r_ds_id"),
                                                "fe_contrato"=>todate(getA("r_fe_contrato")),
                                                "nb"=>getA("r_nb"),
                                                "nb_2"=>getA("nb_2"),
                                                "apll"=>getA("r_apll"),
                                                "dir"=>getA("r_dir"),
                                                "ciudad"=>getA("r_ciudad"),
                                                "co_state"=>getA("r_co_state"),
                                                "ds_zip"=>getA("r_ds_zip"),
                                                "fe_nac"=>todate(getA("r_fe_nac")),
                                                "co_sexo"=>getA("r_co_sexo"),
                                                "co_etnia"=>getA("r_co_etnia"),
                                                "co_lenguaje"=>implode(",",$_POST["r_co_language"]),
                                                "lenguaje_otro"=>getA("language_other"),
                                                "co_citizen_stat"=>getA("r_co_citizen_stat"),
                                                "corr"=>getA("r_correo"),
                                                "telf_casa"=>getA("telf_casa"),
                                                "telf_cel"=>getA("telf_mobile"),
                                                "telf_fax"=>getA("fax"),
                                                "nb_contact"=>getA("r_nb_contact"),
                                                "parentesco_contact"=>getA("r_parentesco_contact"),
                                                "telf_contact"=>getA("r_telf_contact"),
                                                "lic_manejo_ds"=>getA("lic_manejo_ds"),
                                                "lic_manejo_fe_ini"=>todate(getA("lic_manejo_fe_ini")),
                                                "lic_manejo_fe_fin"=>todate(getA("lic_manejo_fe_fin")),
                                                "lic_unarmed_ds"=>getA("r_lic_unarmed_ds"),
                                                "lic_unarmed_fe_ini"=>todate(getA("r_lic_unarmed_fe_ini")),
                                                "lic_unarmed_fe_fin"=>todate(getA("r_lic_unarmed_fe_fin")),
                                                "lic_armed_ds"=>getA("lic_armed_ds"),
                                                "lic_armed_fe_ini"=>todate(getA("lic_armed_fe_ini")),
                                                "lic_armed_fe_fin"=>todate(getA("lic_armed_fe_fin")),
                                                "lic_firearm_ds"=>getA("lic_firearm_ds"),
                                                "lic_firearm_fe_ini"=>todate(getA("lic_firearm_fe_ini")),
                                                "lic_firearm_fe_fin"=>todate(getA("lic_firearm_fe_fin")),
                                                "lic_firstaid_ds"=>getA("lic_firstaid_ds"),
                                                "lic_firstaid_fe_ini"=>todate(getA("lic_firstaid_fe_ini")),
                                                "lic_firstaid_fe_fin"=>todate(getA("lic_firstaid_fe_fin")),
                                                "lic_firstaid_ds"=>getA("lic_firstaid_ds"),
                                                "lic_firstaid_fe_ini"=>todate(getA("lic_firstaid_fe_ini")),
                                                "lic_firstaid_fe_fin"=>todate(getA("lic_firstaid_fe_fin")),
                                                "co_stat_employee"=>getA("r_co_stat_employee"),
                                                "pwd"=>hash('sha256',getA("r_pwd"),false)], $_FILES['ds_img']
                                        );

                                        if($result)
                                            echo $mensaje->MensajeRegistro(1,"Record created successfully");
                                        else
                                            echo $mensaje->MensajeRegistro(2,"Sorry an error has ocurrred");

                                    }
                                }

                                ?>

                                <form role="form" action="<?php echo $url2;?>" method="post" name="forma" id="forma" enctype="multipart/form-data">
                                    <div class="" role="tabpanel" data-example-id="togglable-tabs">
                                        <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
                                            <li role="presentation" class="active"><a href="#tab_content1" id="home-tab" role="tab" data-toggle="tab" aria-expanded="true">General</a>
                                            </li>
                                            <li role="presentation" class=""><a href="#tab_content2" role="tab" id="profile-tab" data-toggle="tab" aria-expanded="false">Licensing</a>
                                            </li>
                                        </ul>
                                        <div id="myTabContent" class="tab-content">
                                            <div role="tabpanel" class="tab-pane fade active in" id="tab_content1" aria-labelledby="home-tab">

                                                <div class="well well-sm"><strong>Employee General Information</strong></div>

                                                <div class="col-md-3">
                                                    <img src="../../images/user_placeholder.png" alt="" class="img-thumbnail">
                                                    <input type="file" name="ds_img" id="ds_img" class="form-control">
                                                </div>
                                                <div class="col-md-9">
                                                    <div class="col-md-6">
                                                        <div class="form-group ">
                                                            <label class="control-label" for="r_ds_id">Employee ID</label>
                                                            <input type="text" onkeypress="return acceptJustNumber(event)" class="form-control" name="r_ds_id" id="r_ds_id" placeholder="Input Employee ID" maxlength="50">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group ">
                                                            <label class="control-label" for="r_fe_contrato">Hire Date</label>
                                                            <div class='input-group date' id='datetimepicker1'>
                                                                <input type='text' class="form-control" name="r_fe_contrato" id="r_fe_contrato" />
                                                                <span class="input-group-addon">
                                                                    <span class="glyphicon glyphicon-calendar"></span>
                                                                </span>
                                                            </div>

                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group ">
                                                            <label class="control-label" for="r_nb">First Name</label>
                                                            <input type="text" class="form-control" name="r_nb" id="r_nb" placeholder="Input First Name" maxlength="70">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group ">
                                                            <label class="control-label" for="nb_2">Middle Name</label>
                                                            <input type="text" class="form-control" name="nb_2" id="nb_2" placeholder="Input Middle Name" maxlength="70">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group ">
                                                            <label class="control-label" for="r_apll">Last Name</label>
                                                            <input type="text" class="form-control" name="r_apll" id="r_apll" placeholder="Input Last Name" maxlength="70">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group ">
                                                            <label class="control-label" for="r_dir">Address</label>
                                                            <input type="text" class="form-control" name="r_dir" id="r_dir" placeholder="Input Address" maxlength="255">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group ">
                                                            <label class="control-label" for="r_ciudad">City</label>
                                                            <input type="text" class="form-control" name="r_ciudad" id="r_ciudad" placeholder="Input City" maxlength="50">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group ">
                                                            <label class="control-label" for="r_co_state">State</label>
                                                            <select name="r_co_state" class="form-control" id="r_co_state">
                                                                <option value="" selected>Select</option>
                                                                <?php
                                                                $rs = $estado->listar($db);

                                                                foreach($rs as $rss)
                                                                {
                                                                    extract($rss);
                                                                    ?>
                                                                    <option value="<?php echo $co ?>"><?php echo $nb ?></option>
                                                                    <?php
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group ">
                                                            <label class="control-label" for="r_ds_zip">Zip</label>
                                                            <input type="text" class="form-control" name="r_ds_zip" id="r_ds_zip" placeholder="Input Zip" maxlength="5">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group ">
                                                            <label class="control-label" for="r_fe_nac">D.O.B</label>
                                                            <div class='input-group date' id='datetimepicker2'>
                                                                <input type='text' class="form-control" name="r_fe_nac" id="r_fe_nac" />
                                                                <span class="input-group-addon">
                                                                    <span class="glyphicon glyphicon-calendar"></span>
                                                                </span>
                                                            </div>

                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group ">
                                                            <label class="control-label" for="r_co_sexo">Gender</label>
                                                            <select name="r_co_sexo" class="form-control" id="r_co_sexo">
                                                                <option value="" selected>Select</option>
                                                                <?php
                                                                $rs = $miscelaneo->listarSexo($db);

                                                                foreach($rs as $rss)
                                                                {
                                                                    extract($rss);
                                                                    ?>
                                                                    <option value="<?php echo $co ?>"><?php echo $nb ?></option>
                                                                    <?php
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group ">
                                                            <label class="control-label" for="r_co_etnia">Ethnicity</label>
                                                            <select name="r_co_etnia" class="form-control" id="r_co_etnia">
                                                                <option value="" selected>Select</option>
                                                                <?php
                                                                $rs = $miscelaneo->listarEtnia($db);

                                                                foreach($rs as $rss)
                                                                {
                                                                    extract($rss);
                                                                    ?>
                                                                    <option value="<?php echo $co ?>"><?php echo $nb ?></option>
                                                                    <?php
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group ">
                                                            <label class="control-label" for="r_co_language">Language (Hold Ctrl to select multiple)</label>
                                                            <select name="r_co_language[]" multiple size="4"  class="form-control" id="r_co_language[]">
                                                                <?php
                                                                $rs = $miscelaneo->listarLenguaje($db);

                                                                foreach($rs as $rss)
                                                                {
                                                                    extract($rss);
                                                                    ?>
                                                                    <option value="<?php echo $co ?>"><?php echo $nb ?></option>
                                                                    <?php
                                                                }
                                                                ?>
                                                            </select>
                                                            <div id="dlanguage_otro" style="display: none">
                                                                <br>
                                                                <input type="text" name="language_other"placeholder="Input Other Language" class="form-control" name="language_other" maxlength="50">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group ">
                                                            <label class="control-label" for="r_co_citizen_stat">Citizen Status</label>
                                                            <select name="r_co_citizen_stat" class="form-control" id="r_co_citizen_stat">
                                                                <option value="" selected>Select</option>
                                                                <?php
                                                                $rs = $miscelaneo->listarCitizenStat($db);

                                                                foreach($rs as $rss)
                                                                {
                                                                    extract($rss);
                                                                    ?>
                                                                    <option value="<?php echo $co ?>"><?php echo $nb ?></option>
                                                                    <?php
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="clearfix"></div>
                                                <hr>
                                                <div class="well well-sm"><strong>Employe Contact Information</strong></div>

                                                <div class="col-md-4">
                                                    <div class="form-group ">
                                                        <label class="control-label" for="r_correo">Email</label>
                                                        <input type="text" class="form-control" name="r_correo" id="r_correo" placeholder="Input Email" maxlength="150" onBlur="javascript:validaemail2('forma','r_correo')">
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group ">
                                                        <label class="control-label" for="telf_casa">Phone (Home)</label>
                                                        <input type="text" class="form-control" name="telf_casa" id="telf_casa" placeholder="Input Phone (Home)" maxlength="50">
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group ">
                                                        <label class="control-label" for="telf_mobile">Phone (Mobile)</label>
                                                        <input type="text" class="form-control" name="telf_mobile" id="telf_mobile" placeholder="Input Phone (Mobile)" maxlength="50">
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group ">
                                                        <label class="control-label" for="fax">FAX</label>
                                                        <input type="text" class="form-control" name="fax" id="fax" placeholder="Input FAX" maxlength="50">
                                                    </div>
                                                </div>
                                                <div class="clearfix"></div>
                                                <br>
                                                <div class="well well-sm"><strong>Emergency Contact Information</strong></div>

                                                <div class="col-md-4">
                                                    <div class="form-group ">
                                                        <label class="control-label" for="r_nb_contact">Contact Name</label>
                                                        <input type="text" class="form-control" name="r_nb_contact" id="r_nb_contact" placeholder="Input First Name" maxlength="70">
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group ">
                                                        <label class="control-label" for="r_parentesco_contact">Relationship</label>
                                                        <input type="text" class="form-control" name="r_parentesco_contact" id="r_parentesco_contact" placeholder="Input First Name" maxlength="70">
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group ">
                                                        <label class="control-label" for="r_telf_contact">Phone</label>
                                                        <input type="text" class="form-control" name="r_telf_contact" id="r_telf_contact" placeholder="Input Phone (Contact)" maxlength="50">
                                                    </div>
                                                </div>
                                                <div class="clearfix"></div>
                                                <br>
                                                <div class="well well-sm"><strong>User Login Information</strong></div>

                                                <div class="col-md-6">
                                                    <div class="form-group ">
                                                        <label class="control-label" for="r_pwd">Password</label>
                                                        <input type="password" class="form-control" name="r_pwd" id="r_pwd" maxlength="10">
                                                    </div>
                                                </div>
                                                <div class="clearfix"></div>


                                            </div>
                                            <div role="tabpanel" class="tab-pane fade" id="tab_content2" aria-labelledby="profile-tab">
                                                <div class="well well-sm">
                                                    <div class="col-md-4">
                                                        <div class="form-group ">
                                                            <label class="control-label" for="telf_contact">Driver License</label>
                                                            <input type="text" class="form-control" name="lic_manejo_ds" id="lic_manejo_ds" maxlength="50">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group ">
                                                            <label class="control-label" for="lic_manejo_fe_ini">Issued Date</label>
                                                            <div class='input-group date' id='datetimepicker3'>
                                                                <input type='text' class="form-control" name="lic_manejo_fe_ini" id="lic_manejo_fe_ini" />
                                                                <span class="input-group-addon">
                                                                    <span class="glyphicon glyphicon-calendar"></span>
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group ">
                                                            <label class="control-label" for="lic_manejo_fe_fin">Expiration Date</label>
                                                            <div class='input-group date' id='datetimepicker4'>
                                                                <input type='text' class="form-control" name="lic_manejo_fe_fin" id="lic_manejo_fe_fin" />
                                                                <span class="input-group-addon">
                                                                    <span class="glyphicon glyphicon-calendar"></span>
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="clearfix"></div>
                                                </div>

                                                <div class="well well-sm">
                                                    <div class="col-md-4">
                                                        <div class="form-group ">
                                                            <label class="control-label" for="r_lic_unarmed_ds">Unarmed License - D</label>
                                                            <input type="text" class="form-control" name="r_lic_unarmed_ds" id="r_lic_unarmed_ds" maxlength="50">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group ">
                                                            <label class="control-label" for="r_lic_unarmed_fe_ini">Issued Date</label>
                                                            <div class='input-group date' id='datetimepicker5'>
                                                                <input type='text' class="form-control" name="r_lic_unarmed_fe_ini" id="r_lic_unarmed_fe_ini" />
                                                                <span class="input-group-addon">
                                                                    <span class="glyphicon glyphicon-calendar"></span>
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group ">
                                                            <label class="control-label" for="r_lic_unarmed_fe_fin">Expiration Date</label>
                                                            <div class='input-group date' id='datetimepicker6'>
                                                                <input type='text' class="form-control" name="r_lic_unarmed_fe_fin" id="r_lic_unarmed_fe_fin" />
                                                                <span class="input-group-addon">
                                                                    <span class="glyphicon glyphicon-calendar"></span>
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="clearfix"></div>
                                                </div>

                                                <div class="well well-sm">
                                                    <div class="col-md-4">
                                                        <div class="form-group ">
                                                            <label class="control-label" for="lic_armed_ds">Armed License - G</label>
                                                            <input type="text" class="form-control" name="lic_armed_ds" id="lic_armed_ds" maxlength="50">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group ">
                                                            <label class="control-label" for="lic_armed_fe_ini">Issued Date</label>
                                                            <div class='input-group date' id='datetimepicker7'>
                                                                <input type='text' class="form-control" name="lic_armed_fe_ini" id="lic_armed_fe_ini" />
                                                                <span class="input-group-addon">
                                                                    <span class="glyphicon glyphicon-calendar"></span>
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group ">
                                                            <label class="control-label" for="lic_armed_fe_fin">Expiration Date</label>
                                                            <div class='input-group date' id='datetimepicker8'>
                                                                <input type='text' class="form-control" name="lic_armed_fe_fin" id="lic_armed_fe_fin" />
                                                                <span class="input-group-addon">
                                                                    <span class="glyphicon glyphicon-calendar"></span>
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="clearfix"></div>
                                                </div>

                                                <div class="well well-sm">
                                                    <div class="col-md-4">
                                                        <div class="form-group ">
                                                            <label class="control-label" for="lic_firearm_ds">Concealed / Firearm - W</label>
                                                            <input type="text" class="form-control" name="lic_firearm_ds" id="lic_firearm_ds" maxlength="50">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group ">
                                                            <label class="control-label" for="lic_firearm_fe_ini">Issued Date</label>
                                                            <div class='input-group date' id='datetimepicker9'>
                                                                <input type='text' class="form-control" name="lic_firearm_fe_ini" id="lic_firearm_fe_ini" />
                                                                <span class="input-group-addon">
                                                                    <span class="glyphicon glyphicon-calendar"></span>
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group ">
                                                            <label class="control-label" for="lic_firearm_fe_fin">Expiration Date</label>
                                                            <div class='input-group date' id='datetimepicker10'>
                                                                <input type='text' class="form-control" name="lic_firearm_fe_fin" id="lic_firearm_fe_fin" />
                                                                <span class="input-group-addon">
                                                                    <span class="glyphicon glyphicon-calendar"></span>
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="clearfix"></div>
                                                </div>

                                                <div class="well well-sm">
                                                    <div class="col-md-4">
                                                        <div class="form-group ">
                                                            <label class="control-label" for="lic_firstaid_ds">First AID Certification</label>
                                                            <input type="text" class="form-control" name="lic_firstaid_ds" id="lic_firstaid_ds" maxlength="50">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group ">
                                                            <label class="control-label" for="lic_firstaid_fe_ini">Issued Date</label>
                                                            <div class='input-group date' id='datetimepicker11'>
                                                                <input type='text' class="form-control" name="lic_firstaid_fe_ini" id="lic_firstaid_fe_ini" />
                                                                <span class="input-group-addon">
                                                                    <span class="glyphicon glyphicon-calendar"></span>
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group ">
                                                            <label class="control-label" for="lic_firstaid_fe_fin">Expiration Date</label>
                                                            <div class='input-group date' id='datetimepicker12'>
                                                                <input type='text' class="form-control" name="lic_firstaid_fe_fin" id="lic_firstaid_fe_fin" />
                                                                <span class="input-group-addon">
                                                                    <span class="glyphicon glyphicon-calendar"></span>
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="clearfix"></div>
                                                </div>
                                                <div class="clearfix"></div>
                                                <br>
                                                <hr>
                                                <div class="col-md-12">
                                                    <div class="form-group ">
                                                        <label class="control-label" for="r_co_stat_employee">Employee Status</label>
                                                        <select name="r_co_stat_employee" class="form-control" id="r_co_stat_employee">
                                                            <option value="" selected>Select</option>
                                                            <?php
                                                            $rs = $employee->listarStatus($db);

                                                            foreach($rs as $rss)
                                                            {
                                                                extract($rss);
                                                                ?>
                                                                <option value="<?php echo $co ?>"><?php echo $nb ?></option>
                                                                <?php
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="clearfix"></div>
                                                <br>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="clearfix"></div>
                                    <br>
                                    <hr>
                                    <br>
                                    <?php echo putBotonAccion($db,$co_acc,1,''); ?>
                                    <button type="button" class="btn btn-default" onclick="javascript:location.href='<?php echo $url1?>'">Back</button>
                                </form>



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



    <?php
    include '../includes/bot-footer.php';
    ?>
    <!-- ... -->
    <script type="text/javascript" src="../../bower_components/moment/min/moment.min.js"></script>
    <script type="text/javascript" src="../../bower_components/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>
    <link rel="stylesheet" href="../../bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css" />
    <script src="../../lib/jquery.maskedinput-1.2.2.js" type="text/javascript"></script>
    <script type="text/javascript">
        $(function () {
            $('#datetimepicker1').datetimepicker({format: 'MM/DD/YYYY', widgetPositioning: { horizontal:'right' }});
            $('#datetimepicker2').datetimepicker({format: 'MM/DD/YYYY', widgetPositioning: { horizontal:'right' }});
            $('#datetimepicker3').datetimepicker({format: 'MM/DD/YYYY', widgetPositioning: { horizontal:'right' }});
            $('#datetimepicker4').datetimepicker({format: 'MM/DD/YYYY', widgetPositioning: { horizontal:'right' }});
            $('#datetimepicker5').datetimepicker({format: 'MM/DD/YYYY', widgetPositioning: { horizontal:'right' }});
            $('#datetimepicker6').datetimepicker({format: 'MM/DD/YYYY', widgetPositioning: { horizontal:'right' }});
            $('#datetimepicker7').datetimepicker({format: 'MM/DD/YYYY', widgetPositioning: { horizontal:'right' }});
            $('#datetimepicker8').datetimepicker({format: 'MM/DD/YYYY', widgetPositioning: { horizontal:'right' }});
            $('#datetimepicker9').datetimepicker({format: 'MM/DD/YYYY', widgetPositioning: { horizontal:'right' }});
            $('#datetimepicker10').datetimepicker({format: 'MM/DD/YYYY', widgetPositioning: { horizontal:'right' }});
            $('#datetimepicker11').datetimepicker({format: 'MM/DD/YYYY', widgetPositioning: { horizontal:'right' }});
            $('#datetimepicker12').datetimepicker({format: 'MM/DD/YYYY', widgetPositioning: { horizontal:'right' }});
        });

        $(document).ready(function () {
            $("#r_telf_contact").mask("999-999-9999");
            $("#telf_casa").mask("999-999-9999");
            $("#telf_mobile").mask("999-999-9999");
            $("#fax").mask("999-999-9999");

            $('#r_co_language').change(function () {
                if (parseInt($('#r_co_language').val()) == 999)
                    $('#dlanguage_otro').show();
                else
                    $('#dlanguage_otro').hide();
            });
        });
    </script>
</body>

</html>