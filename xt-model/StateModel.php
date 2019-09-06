<?php

/**
 * Created by PhpStorm.
 * User: dlugo
 * Date: 02/11/2015
 * Time: 22:52
 */


class StateModel
{

    public function listar($db)
    {
        $stmt = $db->query('select co,nb,abrev,actv from tssa_state order by 1');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtener($db, $codigo)
    {
        $stmt = $db->prepare("select * from tssa_state where co=?");
        $stmt->execute(array($codigo));

        return $stmt->fetchAll(PDO::FETCH_ASSOC);

    }

    public function ingresar($db, array $campos)
    {
        $fecha_now = date("Y-m-d H:i:s");

        try
        {
            $stmt = $db->prepare("insert into tssa_state (nb,abrev,co_user_admin,fe_reg,fe_act,actv) values (?,?,?,?,?,?)");
            $stmt->execute(array($campos['nb'],$campos['abrev'],$_SESSION["coduser"]["co"],$fecha_now,$fecha_now,$campos['actv']));

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
            $stmt = $db->prepare("update tssa_state set nb=?,abrev=?,actv=?,co_user_admin=?,fe_act=? where co=?");
            $stmt->execute(array($campos['nb'],$campos['abrev'],$campos['actv'],$_SESSION["coduser"]["co"],$fecha_now,$campos['co']));

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
            $stmt = $db->prepare("delete from tssa_state where co=?");
            $stmt->execute(array($campos['co']));

            return true;
        }
        catch (Exception $e) {
            return 'Caught exception: ' .  $e->getMessage();
        }

    }

}