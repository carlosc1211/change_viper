<?php

/**
 * Created by PhpStorm.
 * User: dlugo
 * Date: 17/11/2015
 * Time: 10:58
 */
class MiscModel
{
    public function listarIncident24($db)
    {   
        $fecha_now = date("Y-m-d H:i:s");

        $stmt = $db->query("SELECT count(co) as cont_incident from tssa_incident where HOUR(TIMEDIFF('$fecha_now', fe_reg))<=24");

        return $stmt->fetchAll(PDO::FETCH_ASSOC);

    }

    public function listarInternalComm24($db)
    {   
        $fecha_now = date("Y-m-d H:i:s");

        $stmt = $db->query("SELECT count(co) as cont_internalcomm from tssa_issue where HOUR(TIMEDIFF('$fecha_now', fe_reg))<=24");

        return $stmt->fetchAll(PDO::FETCH_ASSOC);

    }

    public function listarEquipment24($db)
    {   
        $fecha_now = date("Y-m-d H:i:s");

        $stmt = $db->query("SELECT count(co) as cont_equipment from tssa_device_log where HOUR(TIMEDIFF('$fecha_now', fe_reg))<=24");

        return $stmt->fetchAll(PDO::FETCH_ASSOC);

    }

    public function listarOfficer24($db)
    {
        $stmt = $db->query('select count(co) as cont_officer from tssa_clock_log 
            where co not in (select co_clock_in from tssa_clock_log where co_clock_in is not null) and tipo=1');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);

    }

    public function listarOfficerClocked8($db)
    {
        $fecha_now = date("Y-m-d H:i:s");

        $stmt = $db->query("select a.co_employee, b.nb as nb_employee,b.apll as apll_employee, HOUR(TIMEDIFF('$fecha_now', a.fe_reg)) as acumulado, c.corr as corr_employee, c.telf_casa, c.telf_cel 
            from tssa_clock_log a, tssa_employee b, tssa_employee_cont c
            where a.co_employee=b.co and a.co_employee=c.co_employee and a.co not in (select co_clock_in from tssa_clock_log where co_clock_in is not null) 
            and tipo=1 and HOUR(TIMEDIFF('$fecha_now', a.fe_reg)) >= 8");

        return $stmt->fetchAll(PDO::FETCH_ASSOC);

    }

    public function listarOfficerStack($db)
    {
        $fecha_now = date("Y-m-d H:i:s");

        $stmt = $db->query("select distinct a.co_employee as co_employee_stack,a.co_post as co_post_stack, 
            b.nb as nb_employee_stack, b.apll as apll_employee_stack, c.nb as nb_post_stack, d.corr as corr_employee_stack, 
            d.telf_casa as telf_casa_stack, d.telf_cel as telf_cel_stack 
            from tssa_track_log a, tssa_employee b, tssa_post c, tssa_employee_cont d
            where a.co_employee = b.co and a.co_post=c.co and b.co=d.co_employee and HOUR(TIMEDIFF('$fecha_now', a.fe_reg)) >= 1 and 
            a.co_clock_in in (select distinct co from tssa_clock_log where stat=1 and tipo=1)");

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function listarInactiveOfficer($db)
    {
        $stmt = $db->query('select b.co as co_employee_inactive, b.nb as nb_employee_inactive,b.apll as apll_employee_inactive, c.corr as corr_employee_inactive, 
            c.telf_casa as telf_casa_inactive, c.telf_cel as telf_cel_inactive 
            from tssa_employee b, tssa_employee_cont c
            where b.co=c.co_employee and b.co not in (select co_employee from tssa_clock_log where stat=1)');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);

    }    

    public function listarPostUncheck($db)
    {
        $stmt = $db->query("select a.co as co_post_uncheck,a.nb as nb_post_uncheck,a.ds_id as ds_id_post_uncheck from tssa_post a where a.actv=1 and co not in (select co_post from tssa_clock_log where stat=1)  order by a.nb");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function listarActivePost($db)
    {
        $stmt = $db->query("select a.co as co_post_active,a.nb as nb_post_active,a.ds_id as ds_id_post_active 
            from tssa_post a where a.actv=1 and a.co in (select co_post from tssa_clock_log where stat=1 and tipo=1)  order by a.nb");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function listarSexo($db)
    {
        $stmt = $db->query('select co,nb from tssa_sexo where actv=1 order by nb');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);

    }

    public function listarEtnia($db)
    {
        $stmt = $db->query('select co,nb from tssa_etnia where actv=1 order by nb');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);

    }

    public function listarLenguaje($db)
    {
        $stmt = $db->query('select co,nb from tssa_lenguaje order by co');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);

    }

    public function listarCitizenStat($db)
    {
        $stmt = $db->query('select co,nb from tssa_citizen_stat order by co');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);

    }

    public function obtener_param($db)
    {
        $stmt = $db->query('select * from tssa_param');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);

    }

    public function actualizar_param($db,array $campos)
    {
        try
        {
            $stmt = $db->prepare("update tssa_param set corr_incident=?, corr_issue=?, corr_track=?, corr_daily_log=?, header_incident=?, footer_incident=?,
            header_issue=?, footer_issue=?, header_track=?, footer_track=?, header_daily_log=?, footer_daily_log=?  where co=1");
            $stmt->execute(array($campos['corr_incident'],$campos['corr_issue'],$campos['corr_track'],$campos['corr_daily_log'],$campos['header_incident'],$campos['footer_incident'],
                $campos['header_issue'],$campos['footer_issue'],$campos['header_track'],$campos['footer_track'],$campos['header_daily_log'],$campos['footer_daily_log']));

            return true;
        }
        catch (PDOException $e) {
            echo $e->getMessage();
            return 'Caught exception: ' .  $e->getMessage();
        }
    }


}