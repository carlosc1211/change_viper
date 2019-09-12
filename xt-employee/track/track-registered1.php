<?php
require_once("../../lib/core.php");
require_once("../../lib/val_session_employee.php");
require_once('../../xt-model/PerfilModel.php');
require_once('../../xt-model/TrackModel.php');
require_once('../../xt-model/ToDoModel.php');

require('../includes/header.php');

$co_acc = getA("co_acc");
$titcomp = getA("tipo");
$nb_punto = getA("point");


$tit1 = "Main Menu";
$tit2 = "Officer Tracker";
$url1 = "../main/findex.php";
$url2 = "clock-activity.php";

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
                        <h3><a href="<?php echo $url1?>" class="btn btn-default"><?php echo $tit1 ?></a> / <?php echo $tit2 ?></h3>
                    </div>

                </div>
                <div class="clearfix"></div>

                <div class="row">
                    <div class="col-md-12 col-xs-12">
                        <div class="x_panel">
                            <form role="form" action="#">
                                <div class="col-md-12 col-xs-12">
                                    <br><br><br>
                                    <div  class="alert alert-success" role="alert"><i class="fa fa-check-circle-o" style="font-size: 24px"></i> Officer Tracker Position Updated</div>
                                    <br><br>
                                    <?php 
                                    $i = 0; 
                                    $todo = new ToDoModel();
                                    $rs = $todo->obtenerTaskPoint($db,$_SESSION["codclockin"]["co_post"],$nb_punto);

                                    if($rs)
                                    {
                                        echo "<div  class='alert alert-warning' role='alert'><h4><i class='fa fa-info-circle'></i> To Do List</h4></div>";

                                        foreach($rs as $rss)
                                        {
                                            extract($rss);
                                            ?>

                                            <p id="point_<?php echo $i?>" ><i class="fa fa-arrow-right"></i> <?php echo $tarea ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <a href="javascript:actToDoLog(<?php echo $i ?>,'<?php echo $tarea ?>',1)" class="btn btn-sm alert-success"><i class="fa fa-check"></i> Yes</a> <a href="javascript:actToDoLog(<?php echo $i ?>,'<?php echo $tarea ?>',0)" class="btn btn-sm btn-danger"><i class="fa fa-ban"></i> Not</a></p>
                                            
                                            <?php
                                            $i++;
                                        }

                                        echo "<br><br>";
                                    }
                                    ?>                                    
                                    <button class="btn-info btn load col-md-6 col-xs-12" type="button" onclick="javasscript:location.href='tracker-activity.php'"><i class="fa fa-arrow-circle-o-right"></i> Next Check Point</button>
                                    <button class="btn-dark btn load col-md-5 col-xs-12" type="button" onclick="javasscript:location.href='<?php echo $url1?>'">Back to Main Menu</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

                <!-- footer content -->
                    <?php include '../footer.php'; ?>
                <!-- /footer content -->

            </div>
            <!-- /page content -->
        </div>


    </div>

    <?php
    include '../bot-footer.php';
    ?>

    <script>
        function actToDoLog(punto,tarea,tipo)
        {
            var co_post = <?php echo $_SESSION["codclockin"]["co_post"]?>;
            var co_employee = <?php echo $_SESSION["codemployee"]["co"]?>;
            var co_clock_in = <?php echo $_SESSION["codclockin"]["co"]?>;

            if(co_post!='' && co_employee!='' && co_clock_in!='')
            {
                $.ajax({
                 type: "get",
                 url: "din_act_todo_log.php",
                 data: "co_post="+co_post+"&co_employee="+co_employee+"&co_clock_in="+co_clock_in+"&tarea="+tarea+"&tipo="+tipo,
                 success: function(msg){
                    if(msg=="1")
                    { 
                        $("#point_"+punto).fadeOut( "slow" );                
                    }
                   }
                });            
            }            
        }
    </script>

</body>

</html>