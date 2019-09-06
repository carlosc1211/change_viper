<?php
require_once("../../lib/core.php");
require_once('../../xt-model/PostModel.php');
require_once('../../xt-model/StateModel.php');
require_once('../../xt-model/ToDoModel.php');
require_once('../../xt-model/MensajeModel.php');

$post = new PostModel();
$estado = new StateModel();
$todo = new ToDoModel();
$mensaje = new MensajeModel();

require('../includes/header_basic.php');

$codigo = getA("co");

$tit1 = "To Do List";

$rs = $post->obtener($db,$codigo);
$rs_point = $todo->obtener($db,$codigo);


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
                </table>
            </td>
        </tr>
        <tr>
            <td colspan="2" class="td-title"><br></td>
        </tr>        
        <tr>
            <td colspan="2" class="td-title">To Do List</td>
        </tr>        
    </table>
    <table class="table">
        <thead>
        <tr>
            <th class="td-25 td-grey td-bold">Check Point</th>
            <th class="td-25 td-grey td-bold">Task</th>
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
                        <?php
                        $rs = $post->obtener_point($db,$codigo);

                        foreach($rs as $rss)
                        {
                            extract($rss);
                            
                            if($co==$co_post_point) echo  $nb;
                            
                        }
                        ?>                                                        
                    </th>                                                
                    <th><?php echo $tarea ?></th>
                </tr>
                <?php
                $i++;
            }
        }
        ?>
        </tbody>
    </table>
</page>
</body>
    <script>
       window.print();
    </script>

</html>