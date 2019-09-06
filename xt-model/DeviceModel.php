<?php

/**
 * Created by PhpStorm.
 * User: dlugo
 * Date: 05/11/2015
 * Time: 19:01
 */
class DeviceModel
{
    public function listar($db)
    {
        $stmt = $db->query('select a.co,a.nb,a.ds_id,b.nb as post_name,a.actv
                from tssa_device a, tssa_post b where a.co_post=b.co  order by 1');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function listarActivos($db)
    {
        $stmt = $db->query('select a.co,a.nb,a.ds_id,b.nb as post_name,a.actv
                from tssa_device a, tssa_post b where a.co_post=b.co and a.actv=1 order by 1');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function listar_log_propios($db,$codigo)
    {
        $stmt = $db->prepare("select a.co,a.co,DATE_FORMAT(a.fe_report,'%m/%d/%Y %l:%i %p') as fe_report, b.nb as post_name,
                c.nb as device_name, d.nb as nb_user, d.apll as apll_user, e.nb as stat
                from tssa_device_log a, tssa_post b, tssa_device c, tssa_employee d, tssa_device_log_stat e
                where a.co_post=b.co and a.co_device=c.co and a.co_employee=d.co and a.co_device_log_stat = e.co
                and d.co=?  order by a.fe_report desc");
        $stmt->execute(array($codigo));

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function listar_log($db)
    {
        $stmt = $db->query("select a.co,a.co,DATE_FORMAT(a.fe_report,'%m/%d/%Y %l:%i %p') as fe_report, b.nb as post_name,
                c.nb as device_name, d.nb as nb_user, d.apll as apll_user, e.nb as stat
                from tssa_device_log a, tssa_post b, tssa_device c, tssa_employee d, tssa_device_log_stat e
                where a.co_post=b.co and a.co_device=c.co and a.co_employee=d.co and a.co_device_log_stat = e.co
                order by a.fe_report desc");

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtener($db,$codigo)
    {
        $stmt = $db->prepare("select * from tssa_device where co=?");
        $stmt->execute(array($codigo));

        return $stmt->fetchAll(PDO::FETCH_ASSOC);

    }

    public function obtenerLog($db,$codigo)
    {
        $stmt = $db->prepare("select *,DATE_FORMAT(fe_report,'%m/%d/%Y %l:%i %p') as fe_report
            from tssa_device_log where co=?");
        $stmt->execute(array($codigo));

        return $stmt->fetchAll(PDO::FETCH_ASSOC);

    }

    public function ingresar($db,array $campos)
    {
        $fecha_now = date("Y-m-d H:i:s");

        try
        {
            $stmt = $db->prepare("insert into tssa_device (nb, ds_make, ds_id, ds_model, ds_serial, co_post, co_user_admin, fe_reg, fe_act, actv,ds_dir)
                 values (?,?,?,?,?,?,?,?,?,?,?)");
            $stmt->execute(array($campos['nb'],$campos['ds_make'],$campos['ds_id'],$campos['ds_model'],$campos['ds_serial'],
                $campos['co_post'],$_SESSION["coduser"]["co"],$fecha_now,$fecha_now,$campos['actv'],$campos['ds_dir']));

            return true;
        }
        catch (PDOException $e) {
            return 'Caught exception: ' .  $e->getMessage();
        }
    }

    public function actualizar($db,array $campos)
    {
        $fecha_now = date("Y-m-d H:i:s");

        try
        {
            $stmt = $db->prepare("update tssa_device set nb=?, ds_make=?, ds_id=?, ds_model=?, ds_serial=?, co_post=?,
                co_user_admin=?, fe_act=?, actv=?  where co=?");
            $stmt->execute(array($campos['nb'],$campos['ds_make'],$campos['ds_id'],$campos['ds_model'],$campos['ds_serial'],
                $campos['co_post'],$_SESSION["coduser"]["co"],$fecha_now,$campos['actv'],$campos['co']));

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
            $stmt = $db->prepare("delete from tssa_device where co=?");
            $stmt->execute(array($campos['co']));

            return true;
        }
        catch (PDOException $e) {
            return 'Caught exception: ' .  $e->getMessage();
        }

    }

    public function ingresarLog($db,array $campos)
    {
        try
        {
            $codigo = id($db,"device");
            $fecha_now = date("Y-m-d H:i:s");


            $stmt = $db->prepare("insert into tssa_device_log (co,co_device,co_post,ds_dir,ds,co_employee,co_device_log_stat,fe_report,fe_reg,fe_act)
                 values (?,?,?,?,?,?,1,?,?,?)");
            $stmt->execute(array($codigo,$campos['co_device'],$campos['co_post'],$campos['ds_dir'],$campos['ds'],$campos['co_employee'],
                $campos['fe_report'],$fecha_now,$fecha_now));

            return true;
        }
        catch (PDOException $e) {
            return 'Caught exception: ' .  $e->getMessage();
        }
    }

    public function actualizarLog($db,array $campos)
    {
        $fecha_now = date("Y-m-d H:i:s");

        try
        {

            $stmt = $db->prepare("update tssa_device_log set co_device=?,co_post=?,ds=?,fe_report=?,fe_act=? where co=?");
            $stmt->execute(array($campos['co_device'],$campos['co_post'],$campos['ds'],$campos['fe_report'],$fecha_now,$campos['co']));

            return true;
        }
        catch (PDOException $e) {
            return 'Caught exception: ' .  $e->getMessage();
        }
    }

    public function eliminarLog($db,array $campos)
    {
        try
        {
            $stmt = $db->prepare("delete from tssa_device_log where co=?");
            $stmt->execute(array($campos['co']));

            return true;
        }
        catch (PDOException $e) {
            return 'Caught exception: ' .  $e->getMessage();
        }

    }


}