<?php
require_once("../../lib/core.php");
require_once("../../lib/val_session.php");
require_once('../../xt-model/PostModel.php');
require_once('../../xt-model/TaskModel.php');
require_once('../../xt-model/MensajeModel.php');

$post = new PostModel();
$task = new TaskModel();
$mensaje = new MensajeModel();

require('../includes/header.php');

$codigo = getA("co");
$co_acc = getA("co_acc");

$tit1 = "Task Alerts";
$tit2 = "Edit Task Alerts";
$url1 = "task-list.php?co_acc=$co_acc";
$url2 = "task-edit.php?co_acc=$co_acc&co=$codigo";
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
                                 <a href="task-edit-print.php?co=<?php echo $codigo ?>" target="_blank" class="btn btn-default pull-right"><i class="fa fa-print"></i> Print</a>
                                <div class="clearfix"></div>
                            </div>
                            <!--****************************************************************-->

                            <div class="x_content">

                                <?php

                                if(isset($_REQUEST["acc"]))
                                {
                                    if(getA("acc")=="ing")
                                    {
                                        $result = $task->actualizar($db,
                                            [   "co"=>$codigo,
                                                "pointnum"=>getA("pointnum"),
                                            ], $_REQUEST
                                        );

                                        if($result)
                                            echo $mensaje->MensajeRegistro(1,"Record updated successfully");
                                        else
                                            echo $mensaje->MensajeRegistro(2,"Sorry an error has ocurrred");
                                    }
                                    elseif(getA("acc")=="elim")
                                    {
                                        $result = $task->eliminar($db,["co"=>$codigo]);

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
                                else
                                {

                                $rs_point = $task->obtener($db,$codigo);
                                $rs_pointnum = $task->obtener_pointnum($db,$codigo);

                                if($rs_pointnum) extract($rs_pointnum[0]);

                                ?>

                                <form role="form" action="<?php echo $url2;?>" method="post" name="forma" id="forma">
                                    <input type="hidden" id="pointnum" name="pointnum" value="<?php echo $pointnum?>" >
                                    <div class="col-md-6">
                                        <div class="form-group ">
                                            <label class="control-label" for="r_post">Post</label>
                                            <select name="r_post" class="form-control" id="r_post" disabled>
                                                <option value="" selected>Select</option>
                                                <?php
                                                $rs = $post->listarActivos($db);

                                                foreach($rs as $rss)
                                                {
                                                    extract($rss);
                                                    ?>
                                                    <option value="<?php echo $co ?>" <?php if($co==$codigo) echo "selected" ?>><?php echo $nb ?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="clearfix"></div>
                                    <br>
                                    <hr>
                                    <div class="well well-sm"><strong>Task Alerts List</strong></div>
                                    <div class="clearfix"></div>

                                    <table class="table table-hover">
                                        <thead>
                                        <tr>
                                            <th>Check Point</th>
                                            <th>Task</th>
                                            <th>Task Time Stamp</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody id="addPoints">
                                        <?php
                                        if ($rs_point)
                                        {   $i = 0;

                                            foreach($rs_point as $points)
                                            {
                                                extract($points);
                                                ?>
                                                <tr id="point_<?php echo $i ?>">
                                                    <th>
                                                        <select name="chkpoint_<?php echo $i ?>" class="form-control" id="chkpoint_<?php echo $i ?>">
                                                        <?php
                                                        $rs = $post->obtener_point($db,$codigo);

                                                        foreach($rs as $rss)
                                                        {
                                                            extract($rss);
                                                            ?>
                                                            <option value="<?php echo $co ?>" <?php if($co==$co_post_point) echo "selected" ?>><?php echo $nb ?></option>
                                                            <?php
                                                        }
                                                        ?>                                                        
                                                        </select>
                                                    </th>                                                
                                                    <th><input type="text" class="form-control" name="task_<?php echo $i ?>" id="task_<?php echo $i ?>" value="<?php echo $tarea ?>" maxlength="150"></th>
                                                    <th>
                                                        <div class='input-group date' id='datetimepicker_<?php echo $i ?>' onclick="javascript:cargaesto('datetimepicker_<?php echo $i ?>')" style="width: 150px">
                                                            <input type='text' class="form-control " name="fe_task_<?php echo $i ?>" id="fe_task_<?php echo $i ?>"  value="<?php echo $fe_tarea ?>"/>
                                                            <span class="input-group-addon">
                                                                <span class="glyphicon glyphicon-calendar"></span>
                                                            </span>
                                                        </div>
                                                    </th>
                                                    <?php if($i==0) { ?>
                                                        <th style="width:110px">
                                                            <a href="javascript:addChkPoints()" class="btn btn-dark btn-xs" data-toggle="tooltip" data-placement="top" title="Add New"><i class="fa fa-plus"></i></a>
                                                        </th>
                                                    <?php } else { ?>
                                                        <th>
                                                            <a href="javascript:delPoint('point_<?php echo $i ?>')" class="btn btn-danger btn-xs"  data-toggle="tooltip" data-placement="top" title="Delete"><i class="fa fa-trash"></i></a>
                                                        </th>
                                                    <?php } ?>
                                                </tr>
                                                <?php
                                                $i++;
                                            }
                                        }
                                        ?>
                                        </tbody>
                                    </table>

                                    <div class="clearfix"></div>
                                    <br>
                                    <hr>
                                    <br>
                                    <?php echo putBotonAccion($db,$co_acc,1,''); ?>
                                    <?php echo putBotonAccion($db,$co_acc,3,$tit1); ?>
                                    <button type="button" class="btn btn-default" onclick="javascript:location.href='<?php echo $url1?>'">Back</button>
                                </form>
                                <?php } ?>


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
    <script type="text/javascript" src="../../bower_components/moment/min/moment.min.js"></script>
    <script type="text/javascript" src="../../bower_components/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>
    <link rel="stylesheet" href="../../bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css" />

    <script type="text/javascript">

        $(function () {
            $('#datetimepicker_0').datetimepicker({ format: 'LT', widgetPositioning: { horizontal:'right' }  });
        });

        function cargaesto(objeto)
        {
            $("#"+objeto).datetimepicker({ format: 'LT', widgetPositioning: { horizontal:'right' }  });
        }

        function addChkPoints()
        {   var i = parseInt($('#pointnum').val()) + 1;

            $('#pointnum').val(i);


            $("#addPoints").append('<tr id="point_'+i+'"><th><select class="form-control" name="chkpoint_'+i+'" id="chkpoint_'+i+'"></select></th><th><input type="text" class="form-control" name="task_'+i+'" id="task_'+i+'" maxlength="150"></th><th><div class="input-group date datetimeus" id="datetimepicker_'+i+'" onclick="javascript:cargaesto(\'datetimepicker_'+i+'\')" style="width: 150px"><input type="text" class="form-control " name="fe_task_'+i+'" id="fe_task_'+i+'" /><span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span></div></th><th><a href="javascript:delPoint(\'point_'+i+'\')" class="btn btn-danger"><i class="fa fa-trash"></i> Del</a></th></tr>   ');

            changePoint("chkpoint_"+i);

        }

        function delPoint(puntodel)
        {
            $("#"+puntodel).remove();
        }

        function  clearPoint()
        {
            var pointnum = $("#pointnum").val();

            $("#task_0").val('');
            $("#datetimepicker_0").val('');
            $('#pointnum').val('0');

            for(i=1;i<=pointnum;i++)
            {
                delPoint("point_"+i);
            }
        }

        function changePoint(pointList)
        {
            var co_post = $("#r_post").val();

            if(co_post!='')
            {
                $.ajax({
                 type: "get",
                 url: "din_point_task.php",
                 data: "co_post="+co_post,
                 success: function(msg){
                    var strResult = msg.split("|");
                    var n = strResult.length;
                    var j=1;k=0;
                    $("#" + pointList).removeOption(/./); 
                  
                    for (var i=0; i<(n/2); i++){
                      $("#" + pointList).addOption(strResult[k],strResult[j]);
                      k+=2;j=k+1;
                    } 
                
                   }
                });            
            }
        }    

    </script>
</body>

</html>