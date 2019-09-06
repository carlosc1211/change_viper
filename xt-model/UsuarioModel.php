<?php

/**
 * Created by PhpStorm.
 * User: dlugo
 * Date: 02/11/2015
 * Time: 20:20
 */
class UsuarioModel
{

    public function listar($db)
    {
        $stmt = $db->query("select a.co,a.nb,a.apll,c.nb as rol,a.actv,a.company from tssa_user a,  tssa_rol c
                    where a.co_rol = c.co order by 1,3");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function listarClientesActivos($db)
    {
        $stmt = $db->query("select a.co as co_user,a.company,a.usr,a.nb as nb_user,a.apll as apll_user,c.nb as rol,a.company from tssa_user a,  tssa_rol c
                    where a.co_rol = c.co and c.co=3 and a.actv=1 order by 1,3");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtener($db,$codigo)
    {
        $stmt = $db->prepare("select * from tssa_user where co=?");
        $stmt->execute(array($codigo));

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerUserusr($db,$codigo)
    {
        $stmt = $db->prepare("select * from tssa_user where usr=?");
        $stmt->execute(array($codigo));

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtener_perfil($db, $codigo)
    {
        $stmt = $db->prepare("select co_perfil from tssa_user where co=?");
        $stmt->execute(array($codigo));

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function ingresar($db,array $campos,array $allcampos)
    {
        $fecha_now = date("Y-m-d H:i:s");

        try
        {
            $codigo = id($db,"usuarios");

            $stmt = $db->prepare("insert into tssa_user (co,nb,apll,company,telf,corr,co_rol,co_perfil,usr,pwd,actv)
                 values (?,?,?,?,?,?,?,?,?,?,?)");
            $stmt->execute(array($codigo,$campos['nb'],$campos['apll'],$campos['company'],$campos['telf'],$campos['corr'],$campos['co_rol'],
                $campos['co_perfil'],$campos['usr'],$campos['pwd'],$campos['actv']));


            $stmt = $db->prepare("select a.co from tssa_acc_exist a, tssa_acc b
				 where a.co=b.co_acc_exist and b.co_perfil=?");
            $stmt->execute(array($campos['co_perfil']));
            $rs = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach($rs as $rss)
            {
                extract($rss);

                $ing = check($allcampos["ing$co"]);
                $mod = check($allcampos["mod$co"]);
                $elim = check($allcampos["elim$co"]);

                $stmt = $db->prepare("insert into tssa_user_acc_exist (co_usr,co_acc_exist,ingresa,modifica,elimina)
                      values (?,?,?,?,?)");
                $stmt->execute(array($codigo,$co,$ing,$mod,$elim));

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
            $stmt = $db->prepare(" update tssa_user set nb=?, apll=?, company=?, telf=?, corr=?, co_rol=?, co_perfil=?, pwd=?, actv=? where co =?");
            $stmt->execute(array($campos['nb'],$campos['apll'],$campos['company'],$campos['telf'],$campos['corr'],$campos['co_rol'],$campos['co_perfil'],
                $campos['pwd'],$campos['actv'],$campos['co']));


            $stmt = $db->prepare("delete from tssa_user_acc_exist where co_usr=?");
            $stmt->execute(array($campos['co']));


            $stmt = $db->prepare("select a.co from tssa_acc_exist a, tssa_acc b
				 where a.co=b.co_acc_exist and b.co_perfil=?");
            $stmt->execute(array($campos['co_perfil']));
            $rs = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach($rs as $rss)
            {
                extract($rss);

                $ing = check($allcampos["ing$co"]);
                $mod = check($allcampos["mod$co"]);
                $elim = check($allcampos["elim$co"]);

                $stmt = $db->prepare("insert into tssa_user_acc_exist (co_usr,co_acc_exist,ingresa,modifica,elimina)
                      values (?,?,?,?,?)");
                $stmt->execute(array($campos['co'],$co,$ing,$mod,$elim));

            }

            return true;
        }
        catch (Exception $e) {
            return 'Caught exception: ' .  $e->getMessage();
        }
    }

    public function eliminar($db,array $campos)
    {
        try
        {
            $stmt = $db->prepare("delete from tssa_user where co=?");
            $stmt->execute(array($campos['co']));

            $stmt = $db->prepare("delete from tssa_user_acc_exist where co_usr=?");
            $stmt->execute(array($campos['co']));

            return true;
        }
        catch (Exception $e) {
            return 'Caught exception: ' .  $e->getMessage();
        }

    }

}