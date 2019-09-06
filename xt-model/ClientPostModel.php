<?php
/**
 * Created by PhpStorm.
 * User: dlugo
 * Date: 02/11/2015
 * Time: 12:36
 */
class ClientPostModel
{
    public function listar($db)
    {
        $stmt = $db->query("select a.co,a.nb,a.apll,a.company from tssa_user a, tssa_client_post b where a.co=b.co_user group by  a.co,a.nb,a.apll,a.company order by 1");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function listarRol($db)
    {
        $stmt = $db->query("select co,nb from tssa_rol where actv=1");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerPostAssigned($db,$codigo)
    {
        $stmt = $db->prepare("select b.co as co_post, b.nb as nb_post from tssa_client_post a, tssa_post b where a.co_post = b.co and a.co_user=?");
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

        try
        {
            $post_asgn_add = explode("|", $campos['post_asgn_add']);

            for ($i = 0; $i <= count($post_asgn_add) - 1; $i++) {
                $stmt = $db->prepare("insert into tssa_client_post (co_user,co_post) values (?,?)");
                $stmt->execute(array($campos['client'],$post_asgn_add[$i]));
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

            $stmt = $db->prepare("delete from tssa_client_post where co_user=?");
            $stmt->execute(array($campos['co']));

            $post_asgn_add = explode("|", $campos['post_asgn_add']);

            for ($i = 0; $i <= count($post_asgn_add) - 1; $i++) {
                $stmt = $db->prepare("insert into tssa_client_post (co_user,co_post) values (?,?)");
                $stmt->execute(array($campos['client'],$post_asgn_add[$i]));
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
            $stmt = $db->prepare("delete from tssa_client_post where co_user=?");
            $stmt->execute(array($campos['co']));

            return true;
        }
        catch (PDOException $e) {
            return 'Caught exception: ' .  $e->getMessage();
        }

    }


}