<?php
require_once("../../lib/core.php");
require_once("../../lib/val_session.php");
require_once('../../xt-model/PostModel.php');
require_once('../../xt-model/ToDoModel.php');
require_once('../../xt-model/MensajeModel.php');

$post = new PostModel();
$todo = new ToDoModel();
$mensaje = new MensajeModel();


require('../includes/header.php');

$co_acc = getA("co_acc");

$tit1 = "To Do List";
$tit2 = "New To Do List";
$url1 = "todo-list.php?co_acc=$co_acc";
$url2 = "todo-new.php?co_acc=$co_acc";
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
                                        $result = $todo->ingresar($db,
                                            [   "post"=>getA("r_post"),
                                                "pointnum"=>getA("pointnum"),
                                            ], $_REQUEST
                                        );

                                        if($result)
                                            echo $mensaje->MensajeRegistro(1,"Record created successfully");
                                        else
                                            echo $mensaje->MensajeRegistro(2,"Sorry an error has ocurrred");

                                    }
                                }
                                else
                                {
                                ?>

                                <form role="form" action="<?php echo $url2;?>" method="post" name="forma" id="forma" enctype="multipart/form-data">
                                    <input type="hidden" name="pointnum" id="pointnum" value="0">
                                    <div class="alert alert-info">
                                      <strong>Info!</strong> Please select Post to list Check Points asociated.
                                    </div>
                                    <div class="clearfix"></div>
                                    <div class="col-md-6">
                                        <div class="form-group ">
                                            <label class="control-label" for="r_post">Post</label>
                                            <select name="r_post" class="form-control" id="r_post" onchange="javascript:clearPoint();changePoint('chkpoint_0')">
                                                <option value="" selected>Select</option>
                                                <?php
                                                $rs = $post->listarActivos($db);

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
                                    <hr>
                                    <div class="well well-sm"><strong>To Do List</strong></div>
                                    <div class="clearfix"></div>

                                    <table class="table table-hover">
                                        <thead>
                                        <tr>
                                            <th>Check Point</th>
                                            <th>Task</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody id="addPoints">
                                        <tr>
                                            <th>
                                                <select name="chkpoint_0" class="form-control" id="chkpoint_0">
                                                </select>
                                            </th>
                                            <th><input type="text" class="form-control" name="task_0" id="task_0" maxlength="150"></th>
                                            <th><a href="javascript:addChkPoints()" class="btn btn-dark"><i class="fa fa-plus"></i> Add</a></th>
                                        </tr>
                                        </tbody>
                                    </table>

                                    <div class="clearfix"></div>
                                    <br>
                                    <hr>
                                    <br>
                                    <?php echo putBotonAccion($db,  $co_acc,1,''); ?>
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
    <!-- ... -->
    <script type="text/javascript" src="../../bower_components/moment/min/moment.min.js"></script>
    <script type="text/javascript">



    function addChkPoints()
    {   var i = parseInt($('#pointnum').val()) + 1;

        $('#pointnum').val(i);


        $("#addPoints").append('<tr id="point_'+i+'"><th><select class="form-control" name="chkpoint_'+i+'" id="chkpoint_'+i+'"></select></th><th><input type="text" class="form-control" name="task_'+i+'" id="task_'+i+'" maxlength="150"></th><th><a href="javascript:delPoint(\'point_'+i+'\')" class="btn btn-danger"><i class="fa fa-trash"></i> Del</a></th></tr>   ');

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
             url: "din_point_todo.php",
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