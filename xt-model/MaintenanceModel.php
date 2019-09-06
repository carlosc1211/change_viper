<?php

/**
 * Created by PhpStorm.
 * User: dlugo
 * Date: 06/11/2015
 * Time: 11:33
 */
class MaintenanceModel
{
    protected $strsql = "";

    public function listar($db)
    {
        $stmt = $db->query("select a.co,a.nb as nb_maintenance,DATE_FORMAT(a.fe_reg,'%m/%d/%Y %l:%i %p') as fe_reg, b.nb as post_name,
            c.nb as nb_employee,c.apll as apll_employee
                from tssa_maintenance a, tssa_post b, tssa_employee c
                where a.co_post=b.co and a.co_employee=c.co order by a.co");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function listarFiltered($db,$co_user)
    {
        $stmt = $db->query("select a.co,a.nb as nb_maintenance,DATE_FORMAT(a.fe_reg,'%m/%d/%Y %l:%i %p') as fe_reg, b.nb as post_name,
            c.nb as nb_employee,c.apll as apll_employee
                from tssa_maintenance a, tssa_post b, tssa_employee c, tssa_client_post d
                where a.co_post=b.co and a.co_employee=c.co and a.co_post=d.co_post and d.co_user=$co_user order by a.co");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function listar_propios($db,$codigo)
    {
        $stmt = $db->prepare("select a.co,DATE_FORMAT(a.fe_reg,'%m/%d/%Y %l:%i %p') as fe_reg, b.nb as post_name
                from tssa_maintenance a, tssa_post b
                where a.co_post=b.co and a.co_employee=? order by a.co");
        $stmt->execute(array($codigo));

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtener($db,$codigo)
    {
        $stmt = $db->prepare("select * from tssa_maintenance where co=?");
        $stmt->execute(array($codigo));

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtener_propnum($db,$codigo)
    {
        $stmt = $db->prepare("select ifnull(count(co),0) as propnum from tssa_maintenance_maintenance_type where co_maintenance=?");
        $stmt->execute(array($codigo));

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtener_prop($db,$codigo)
    {
        $stmt = $db->prepare("select * from tssa_maintenance_maintenance_type where co_maintenance=?");
        $stmt->execute(array($codigo));

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function ingresar($db,array $campos, array $allcampos)
    {
        try
        {
            $codigo = id($db,"maintenance");
            $fecha_now = date("Y-m-d H:i:s");


            $stmt = $db->prepare("insert into tssa_maintenance (co,nb,ds,co_post,co_employee,ds_dir,fe_reg,fe_act )
                values (?,?,?,?,?,?,?,?)");
            $stmt->execute(array($codigo,$campos['title'],$campos['ds'],$campos['co_post'],
                $campos['co_employee'],$campos['ds_dir'],$fecha_now,$fecha_now));


            for($i=0;$i<=$campos['propnum'];$i++)
            {
                $maintenance_type = $allcampos["maintenance_type_$i"];
                $prop_ds = $allcampos["prop_ds_$i"];

                if(trim($maintenance_type)!='' && trim($prop_ds)!='')
                {
                    $stmt = $db->prepare("insert into tssa_maintenance_maintenance_type (co_maintenance,co_maintenance_type,ds)
                    values (?,?,?)");
                    $stmt->execute(array($codigo,$maintenance_type,$prop_ds));
                }
            }


            return true;
        }
        catch (PDOException $e) {
            return 'Caught exception: ' .  $e->getMessage();
        }
    }

    public function actualizar($db,array $campos, array $allcampos)
    {
        $fecha_now = date("Y-m-d H:i:s");

        try
        {
            $stmt = $db->prepare("update tssa_maintenance set nb=?,ds=?,co_post=?,co_employee=?,ds_dir=?,fe_reg=?,fe_act=? where co=?");
            $stmt->execute(array($campos['title'],$campos['ds'],$campos['co_post'],
                $campos['co_employee'],$campos['ds_dir'],$fecha_now,$fecha_now,$campos['co']));


            $stmt = $db->prepare("delete from tssa_maintenance_maintenance_type where co_maintenance=?");
            $stmt->execute(array($campos['co']));


            for($i=0;$i<=$campos['propnum'];$i++)
            {
                $maintenance_type = $allcampos["maintenance_type_$i"];
                $prop_ds = $allcampos["prop_ds_$i"];

                if(trim($maintenance_type)!='' && trim($prop_ds)!='')
                {
                    $stmt = $db->prepare("insert into tssa_maintenance_maintenance_type (co_maintenance,co_maintenance_type,ds)
                    values (?,?,?)");
                    $stmt->execute(array($campos['co'],$maintenance_type,$prop_ds));
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
            $stmt = $db->prepare("delete from tssa_maintenance where co=?");
            $stmt->execute(array($campos['co']));

            $stmt = $db->prepare("delete from tssa_maintenance_maintenance_type where co_maintenance=?");
            $stmt->execute(array($campos['co']));


            unlink("../../images/maintenance/".$campos['_dir']);

            return true;
        }
        catch (PDOException $e) {
            return 'Caught exception: ' .  $e->getMessage();
        }

    }

}