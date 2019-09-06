<?php
/**
 * Created by PhpStorm.
 * User: dlugo
 * Date: 16/11/2015
 * Time: 21:39
 */

class ConnectModel
{
    public function Connect()
    {
        $db = new PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME.';charset=utf8', DB_USER , DB_PASS);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

        if (!$db) {
            die('***');
        }

        return $db;

    }

    public function getAcceso($db, $co_acc, $caso)
    {
        $stmt = $db->prepare("select ingresa,modifica,elimina from tssa_user_acc_exist where co_acc_exist =? and co_usr=?");
        $stmt->execute(array($co_acc, $_SESSION["coduser"]['co']));

        $rs = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if($rs) extract($rs[0]);

        switch($caso) {
            case 1:
                return($ingresa);
                break;
            case 2:
                return($modifica);
                break;
            case 3:
                return($elimina);
            default:
                return(0);
                break;
        }
    }

    public function getRolAccesoMod($db, $co_rol)
    {
        $stmt = $db->prepare("select co,ds_mod from tssa_acc_exist where co_rol=? order by ds_mod");
        $stmt->execute(array($co_rol));

        return $stmt->fetchAll(PDO::FETCH_ASSOC);

    }

    public function validaUserAdmin($db, $usr, $pwd)
    {
        $stmt = $db->prepare("select co,nb,apll,corr from tssa_user where usr =? and pwd =? and actv=1");
        $stmt->execute(array($usr, $pwd));

        return $stmt->fetchAll(PDO::FETCH_ASSOC);

    }

    public function validaUserEmployee($db, $usr, $pwd)
    {
        $stmt = $db->prepare("select a.co,a.nb,a.apll,b.corr
		from tssa_employee a, tssa_employee_cont b, tssa_employee_user c
		where a.co=b.co_employee and a.co=c.co_employee and c.usr =? and c.pwd =? and a.actv=1");
        $stmt->execute(array($usr, $pwd));

        return $stmt->fetchAll(PDO::FETCH_ASSOC);

    }

    public function getUserAccesoCorr($db, $corr)
    {
        $stmt = $db->prepare("select * from tssa_user where corr =? and actv=1");
        $stmt->execute(array($corr));

        return $stmt->fetchAll(PDO::FETCH_ASSOC);

    }

    public function getUserAccesoMod($db, $co_perfil)
    {
        $stmt = $db->prepare("select a.co,a.ds_mod,c.nb as grupo from tssa_acc_exist a, tssa_acc b, tssa_acc_grupo c
					 where a.co=b.co_acc_exist and a.co_grupo=c.co and b.co_perfil=? order by c.ord,a.ord");
        $stmt->execute(array($co_perfil));

        return $stmt->fetchAll(PDO::FETCH_ASSOC);

    }

    public function getUserAccesoModEdit($db, $co_perfil, $co_usr)
    {
        $stmt = $db->prepare("select a.co,a.ds_mod,c.nb as grupo,d.ingresa,d.modifica,d.elimina
          from tssa_acc_exist a, tssa_acc b, tssa_acc_grupo c,tssa_user_acc_exist d
          where a.co=b.co_acc_exist and a.co_grupo=c.co and b.co_perfil=? and a.co=d.co_acc_exist and d.co_usr=?
          group by a.co,a.ds_mod,c.nb,d.ingresa,d.modifica,d.elimina order by c.ord,a.ord ");
        $stmt->execute(array($co_perfil,$co_usr));

        return $stmt->fetchAll(PDO::FETCH_ASSOC);

    }

    public function getId($db, $desc)
    {
        $stmt = $db->prepare("select val from tssa_corr where ds =?");
        $stmt->execute(array($desc));

        $rs = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if($rs) extract($rs[0]);

        $valor = $val + 1;

        $stmt = $db->prepare("update tssa_corr set val=? where ds=?");
        $stmt->execute(array($valor, $desc));

        return $valor;
    }
}