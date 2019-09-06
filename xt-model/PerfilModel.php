<?php
/**
 * Created by PhpStorm.
 * User: dlugo
 * Date: 02/11/2015
 * Time: 12:36
 */
class PerfilModel
{
    public function listar($db)
    {
        $stmt = $db->query("select a.co,a.nb,a.actv,b.nb as rol from tssa_perfil a, tssa_rol b where a.co_rol=b.co order by 1");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function listarRol($db)
    {
        $stmt = $db->query("select co,nb from tssa_rol where actv=1");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtener($db,$codigo)
    {
        $stmt = $db->prepare("select * from tssa_perfil where co=?");
        $stmt->execute(array($codigo));

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerPerfilRol($db,$codigo)
    {
        $stmt = $db->prepare("select * from tssa_perfil where actv=1 and  co_rol=?");
        $stmt->execute(array($codigo));

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerModulosAsgn($db,$codigo)
    {
        $stmt = $db->prepare("select a.* from tssa_acc_exist a, tssa_acc b where a.co=b.co_acc_exist and b.co_perfil=?");
        $stmt->execute(array($codigo));

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerModulosLibres($db,$codigo)
    {
        $stmt = $db->prepare("select a.* from tssa_acc_exist a  where a.co not in (select b.co_acc_exist from tssa_acc b  where b.co_perfil=?)");
        $stmt->execute(array($codigo));

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function ingresar($db,array $campos)
    {
        $fecha_now = date("Y-m-d H:i:s");

        try
        {
            $codigo = id($db,"perfil");

            $stmt = $db->prepare("insert into tssa_perfil (co,nb,co_rol,co_user_admin,fe_reg,fe_act,actv)
                values (?,?,?,?,?,?,?)");
            $stmt->execute(array($codigo,$campos['nb'],$campos['co_rol'],$_SESSION["coduser"]["co"],$fecha_now,$fecha_now,$campos['actv']));


            $accesos = explode("|", $campos['accesos']);

            for ($i = 0; $i <= count($accesos) - 1; $i++) {
                $stmt = $db->prepare("insert into tssa_acc (co_perfil,co_acc_exist) values (?,?)");
                $stmt->execute(array($codigo,$accesos[$i]));
            }

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
            $stmt = $db->prepare("update tssa_perfil set nb=?, co_rol=?, actv=?, co_user_admin=?,fe_act=? where co=?");
            $stmt->execute(array($campos['nb'],$campos['co_rol'],$campos['actv'],$_SESSION["coduser"]["co"],$fecha_now,$campos['co']));

            $stmt = $db->prepare("delete from tssa_acc where co_perfil=?");
            $stmt->execute(array($campos['co']));

            $accesos = explode("|", $campos['accesos']);

            for($i=0;$i<=count($accesos)-1;$i++)
            {
                $stmt = $db->prepare("insert into tssa_acc (co_perfil,co_acc_exist) values (?,?)");
                $stmt->execute(array($campos['co'],$accesos[$i]));
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
            $stmt = $db->prepare("delete from tssa_perfil where co=?");
            $stmt->execute(array($campos['co']));

            $stmt = $db->prepare("delete from tssa_acc where co_perfil=?");
            $stmt->execute(array($campos['co']));

            return true;
        }
        catch (PDOException $e) {
            return 'Caught exception: ' .  $e->getMessage();
        }

    }


}