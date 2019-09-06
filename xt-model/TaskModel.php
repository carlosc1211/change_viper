<?php

/**
 * Created by PhpStorm.
 * User: dlugo
 * Date: 04/05/2016
 * Time: 21:44
 */
class TaskModel
{
    protected $strsql = "";

    public function listarPostTask($db)
    {
        $stmt = $db->query("select a.co,a.nb,a.ds_id,a.ciudad,b.nb as state 
                from tssa_post a, tssa_state b
                where a.co_state=b.co and a.co in (select distinct co_post from tssa_post_task)
                order by a.nb");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtener($db,$codigo)
    {
        $stmt = $db->prepare("select b.co_post_point, b.task as tarea, b.fe_task as fe_tarea
            from tssa_post_task b
            where b.co_post=?");
        $stmt->execute(array($codigo));

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtener_pointnum($db,$codigo)
    {
        $stmt = $db->prepare("select ifnull(count(co),0) as pointnum from tssa_post_task where co_post=?");
        $stmt->execute(array($codigo));

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public function ingresar($db,array $campos, array $allcampos)
    {

        try
        {
            for($i=0;$i<=$campos['pointnum'];$i++)
            {
                $chkpoint = $allcampos["chkpoint_$i"];
                $task = $allcampos["task_$i"];
                $fe_task = tohour_hr($allcampos["fe_task_$i"]);

                if(trim($chkpoint)!='' && trim($task)!='' && trim($fe_task)!='')
                {
                    $stmt = $db->prepare("insert into tssa_post_task (co_post,co_post_point,task,fe_task)
                        values (?,?,?,?)");
                    $stmt->execute(array($campos['post'],$chkpoint,$task,$fe_task));
                }
            }

            return true;
        }
        catch (Exception $e) {
            echo $e->getMessage();
            return 'Caught exception: ' .  $e->getMessage();
        }
    }

    public function actualizar($db,array $campos, array $allcampos)
    {
        try
        {
            $stmt = $db->prepare("delete from tssa_post_task where co_post=?");
            $stmt->execute(array($campos['co']));


            for($i=0;$i<=$campos['pointnum'];$i++)
            {
                $chkpoint = $allcampos["chkpoint_$i"];
                $task = $allcampos["task_$i"];
                $fe_task = tohour_hr($allcampos["fe_task_$i"]);

                if(trim($chkpoint)!='' && trim($task)!='' && trim($fe_task)!='')
                {
                    $stmt = $db->prepare("insert into tssa_post_task (co_post,co_post_point,task,fe_task)
                        values (?,?,?,?)");
                    $stmt->execute(array($campos['co'],$chkpoint,$task,$fe_task));
                }
            }

            return true;
        }
        catch (PDOException $e) {
            return 'Caught exception: ' .  $e->getMessage();
        }
    }

    public function eliminar($db,array $campos)
    {
        try
        {
            $stmt = $db->prepare("delete from tssa_post_task where co_post=?");
            $stmt->execute(array($campos['co']));

            return true;
        }
        catch (Exception $e) {
            return 'Caught exception: ' .  $e->getMessage();
        }

    }


}