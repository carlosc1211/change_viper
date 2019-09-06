<?php

/**
 * Created by PhpStorm.
 * User: dlugo
 * Date: 10/11/2015
 * Time: 14:15
 */
class DailyModel
{

    public function listar($db)
    {
        $stmt = $db->query("select a.co,DATE_FORMAT(a.fe_reg,'%m/%d/%Y %l:%i %p') as fe_reg,a.co, b.nb as nb_employee,
                b.apll as apll_employee,c.nb as post_name
                from tssa_daily_log a, tssa_employee b, tssa_post c
                where a.co_employee=b.co and a.co_post=c.co order by a.fe_reg desc,b.co");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);

    }

    public function listarFiltered($db,$co_user)
    {
        $stmt = $db->query("select a.co,DATE_FORMAT(a.fe_reg,'%m/%d/%Y %l:%i %p') as fe_reg,a.co, b.nb as nb_employee,
                b.apll as apll_employee,c.nb as post_name
                from tssa_daily_log a, tssa_employee b, tssa_post c, tssa_client_post d
                where a.co_employee=b.co and a.co_post=c.co and a.co_post=d.co_post and d.co_user=$co_user order by a.fe_reg desc,b.co");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);

    }

    public function valDailyLogClient($db,$codigo,$co_user)
    {
        $stmt = $db->query("select a.co from tssa_daily_log a, tssa_client_post f where a.co_post=f.co_post and f.co_user=$co_user and a.co=$codigo order by a.co");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function listar_propios($db,$codigo)
    {
        $stmt = $db->prepare("select a.co,DATE_FORMAT(a.fe_reg,'%m/%d/%Y %l:%i %p') as fe_reg,a.co, b.nb as nb_employee,
                b.apll as apll_employee,c.nb as post_name
                from tssa_daily_log a, tssa_employee b, tssa_post c
                where a.co_employee=b.co and a.co_post=c.co and b.co=? order by a.fe_reg desc,b.co");
        $stmt->execute(array($codigo));

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtener_in($db,$codigo)
    {
        $stmt = $db->prepare("select DATE_FORMAT(a.fe_reg,'%m/%d/%Y %l:%i %p') as fe_reg,a.co,a.obs, b.nb as nb_employee,
                b.apll as apll_employee,c.nb as post_name,a.pos_lat,a.pos_long,a.accuracy,a.ds_dir,c.corr_daily_log as post_corr_daily_log
                from tssa_daily_log a, tssa_employee b, tssa_post c
                where a.co_employee=b.co and a.co_post=c.co and a.co=? order by a.fe_reg desc,b.co");
        $stmt->execute(array($codigo));

        return $stmt->fetchAll(PDO::FETCH_ASSOC);

    }

    public function ingresar($db,array $campos)
    {
 
        $fecha_now = date("Y-m-d H:i:s");
        $codigo = id($db,"dailylog");

        try
        {
            $stmt = $db->prepare("insert into tssa_daily_log (co,co_employee, pos_lat, pos_long, accuracy, fe_reg, co_post, obs, ds_dir)
                values (?,?,?,?,?,?,?,?,?)");
            $stmt->execute(array($codigo,$campos['coduser'],$campos['poslat'],$campos['poslong'],$campos['accuracy'],$fecha_now,$campos['co_post'],
                    $campos['obs'], $campos['ds_dir']));

            return $codigo;
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
            $stmt = $db->prepare("update tssa_daily_log set fe_reg=?, obs=? where co=?");
            $stmt->execute(array($fecha_now,$campos['obs'], $campos['co']));

            return $campos['co'];
        }
        catch (PDOException $e) {
            return 'Caught exception: ' .  $e->getMessage();
        }
    }

    public function eliminar($db,array $campos)
    {
        try
        {
            $stmt = $db->prepare("delete from tssa_daily_log where co=?");
            $stmt->execute(array($campos['co']));

            return true;
        }
        catch (PDOException $e) {
            return 'Caught exception: ' .  $e->getMessage();
        }

    }

}