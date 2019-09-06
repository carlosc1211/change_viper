<?php
require_once("../../lib/core.php");
require_once("../../lib/val_session_employee.php");
require_once('../../xt-model/IssueModel.php');
require_once('../../xt-model/PostModel.php');
require_once('../../xt-model/MensajeModel.php');

$mensaje = new MensajeModel();
$issue = new IssueModel();
$post = new PostModel();

require('../includes/header.php');

$codigo = getA("co");
$co_acc = getA("co_acc");

$tit1 = "Issues";
$tit2 = "Edit Issue";
$url1 = "issue-list.php";
$url2 = "issue-edit.php?co=$codigo";
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
                        <h3><a href="../main/findex.php" class="btn btn-default">Main</a> / <a href="<?php echo $url1?>" class="btn btn-default"><?php echo $tit1 ?></a> / <?php echo $tit2 ?></h3>
                    </div>

                </div>
                <div class="clearfix"></div>

                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="x_panel">

                            <div class="x_content">

                                <?php

                                if(isset($_REQUEST["acc"]))
                                {
                                    if(getA("acc")=="ing")
                                    {
                                        $result = $issue->actualizar($db,
                                            [
                                                "co"=>$codigo,
                                                "co_employee"=>$_SESSION["codemployee"]["co"],
                                                "co_post"=>getA("r_post"),
                                                "fe_issue"=>todate_hr(getA("r_fe_issue")),
                                                "ds"=>getA("ds")
                                            ]
                                        );

                                        if($result)
                                        {
                                            echo $mensaje->MensajeRegistro(1,"Record updated successfully");
                                            ?>
                                            <script>
                                            $.ajax({
                                                type: "POST",
                                                url: "mail-issue-edit.php",
                                                data: "co=<?php echo $result ?>",
                                                success: function(data)
                                                {data=data;
                                                }
                                            });
                                            </script>

                                            <?php                                            
                                        }
                                        else
                                            echo $mensaje->MensajeRegistro(2,"Sorry an error has ocurrred");
                                    }
                                    elseif(getA("acc")=="elim")
                                    {
                                        $result = $issue->eliminar($db,["co"=>$codigo]);

                                        if($result)
                                            echo $mensaje->MensajeRegistro(1,"Record deleted successfully");
                                        else
                                            echo $mensaje->MensajeRegistro(2,"Sorry an error has ocurrred");

                                        ?>
                                        <script>
                                        var redirectTimeout = setTimeout( function() { window.location = '<?php echo $url1?>'; }, 3000 );
                                        </script>
                                        <?php
                                    }
                                }

                                $rs = $issue->obtener($db,$codigo);

                                if($rs) extract($rs[0]);

                                ?>

                                <form role="form" action="<?php echo $url2;?>" method="post" name="forma" id="forma">
                                    <div class="form-group col-md-12 col-xs-12">
                                        <label class="control-label" for="r_post">Post</label>
                                        <select name="r_post" class="form-control" id="r_post">
                                            <option value="" selected>Select</option>
                                            <?php
                                            $rs = $post->listarActivos($db);

                                            foreach($rs as $rss)
                                            {
                                                extract($rss);
                                                ?>
                                                <option value="<?php echo $co ?>" <?php if($co==$co_post) echo "selected"?>><?php echo $nb ?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="col-md-12 col-xs-12">
                                        <div class="form-group ">
                                            <label class="control-label" for="r_fe_issue">Issue Date</label>
                                            <div class='input-group date' id='datetimepicker1'>
                                                <input type='text' class="form-control" name="r_fe_issue" id="r_fe_issue" value="<?php echo $fe_issue?>" />
                                                                <span class="input-group-addon">
                                                                    <span class="glyphicon glyphicon-calendar"></span>
                                                                </span>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="form-group col-md-12 col-xs-12">
                                        <label class="control-label" for="ds">Issue Description</label>
                                        <textarea class="form-control" name="ds" id="ds" rows="10"><?php echo $ds?></textarea>
                                    </div>

                                    <br /><br />
                                    <div class="clearfix"></div>
                                    <?php if($co_issue_stat==1) {?>
                                        <button type="button" class="btn btn-dark " onclick="javascript:validar(this.form,'ing')">Submit</button>
                                        <button type="button" class="btn btn-danger" onclick="javascript:prevalida('the record')?validar(this.form,'elim'):''">Delete</button>
                                    <?php } ?>
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
    <script src="../ckeditor/ckeditor.js" type="text/javascript"></script>
    <script type="text/javascript" src="../../bower_components/moment/min/moment.min.js"></script>
    <script type="text/javascript" src="../../bower_components/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>
    <link rel="stylesheet" href="../../bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css" />

    <script type="text/javascript">
        $(function () {
            $('#datetimepicker1').datetimepicker({  widgetPositioning: { horizontal:'right' }  });
        });

        $(document).ready(function () {
            CKEDITOR.replace('ds');
        });
    </script>
</body>

</html>