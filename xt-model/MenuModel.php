<?php

/**
 * Created by PhpStorm.
 * User: dlugo
 * Date: 16/11/2015
 * Time: 21:58
 */
class MenuModel
{
    public function MenuRol($db, $co_rol)
    {
        $stmt = $db->prepare('select c.co, c.nb, c.icon from tssa_acc_grupo c where c.co in (select b.co_grupo from tssa_acc_exist b where b.co_rol=?) order by c.ord ');
        $stmt->execute(array($co_rol));
        return $stmt->fetchAll(PDO::FETCH_ASSOC);

    }

    public function MenuModulos($db, $co_perfil, $co_grupo, $co_rol)
    {
        $stmt = $db->prepare('select c.co, c.ds_url, c.ds_mod from tssa_user a, tssa_acc b, tssa_acc_exist c, tssa_acc_grupo d
                        where a.co_perfil=b.co_perfil and b.co_acc_exist=c.co and c.co_grupo=d.co and a.co_perfil=?
                        and d.co=? and c.co_rol=? group by c.co, c.ds_mod, c.ds_url, d.nb, c.ord, d.nb, d.co order by d.ord, c.ord ');
        $stmt->execute(array($co_perfil, $co_grupo, $co_rol));
        return $stmt->fetchAll(PDO::FETCH_ASSOC);

    }

    public function MenuModulosEmployee($db, $co_grupo, $co_rol)
    {
        $stmt = $db->prepare('select c.co, c.ds_url, c.ds_mod from tssa_acc_exist c
                        where c.co_rol=2 and c.co_grupo=? and c.co_rol=? order by c.ord ');
        $stmt->execute(array($co_grupo, $co_rol));
        return $stmt->fetchAll(PDO::FETCH_ASSOC);

    }
}