<?php

/**
 * Created by PhpStorm.
 * User: dlugo
 * Date: 02/11/2015
 * Time: 22:52
 */


class EmergencyServiceModel
{

    public function listar($db)
    {
        $stmt = $db->query('select co,nb,actv from tssa_emergency_service order by 1');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtener($db, $codigo)
    {
        $stmt = $db->prepare("select * from tssa_emergency_service where co=?");
        $stmt->execute(array($codigo));

        return $stmt->fetchAll(PDO::FETCH_ASSOC);

    }

    public function ingresar($db, array $campos)
    {
        $fecha_now = date("Y-m-d H:i:s");

        try
        {
        	$codigo = id($db,"emergencyservice");

            $stmt = $db->prepare("insert into tssa_emergency_service (co,nb,co_user_admin,fe_reg,fe_act,actv) values (?,?,?,?,?,?)");
            $stmt->execute(array($codigo,$campos['nb'],$_SESSION["coduser"]["co"],$fecha_now,$fecha_now,$campos['actv']));

            return true;
        }
        catch (Exception $e) {
            return 'Caught exception: ' .  $e->getMessage();
        }
    }

    public function actualizar($db, array $campos)
    {
        $fecha_now = date("Y-m-d H:i:s");
 
        try
        {
            $stmt = $db->prepare("update tssa_emergency_service set nb=?,actv=?,co_user_admin=?,fe_act=? where co=?");
            $stmt->execute(array($campos['nb'],$campos['actv'],$_SESSION["coduser"]["co"],$fecha_now,$campos['co']));

            return true;
        }
        catch (Exception $e) {
            return 'Caught exception: ' .  $e->getMessage();
        }
    }

    public function eliminar($db, array $campos)
    {
        try
        {
            $stmt = $db->prepare("delete from tssa_emergency_service where co=?");
            $stmt->execute(array($campos['co']));

            return true;
        }
        catch (Exception $e) {
            return 'Caught exception: ' .  $e->getMessage();
        }

    }

}