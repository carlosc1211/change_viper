<?php

/**
 * Created by PhpStorm.
 * User: dlugo
 * Date: 12/11/2015
 * Time: 9:59
 */
class IssueModel
{

    public function listar($db)
    {
        $stmt = $db->query("select a.co,b.nb as nb_employee, b.apll as apll_employee, c.nb as post_name, d.nb as stat, d.co as co_stat,
                DATE_FORMAT(a.fe_issue,'%m/%d/%Y %l:%i %p') as fe_issue
                from tssa_issue a, tssa_employee b, tssa_post c, tssa_issue_stat d
                where a.co_employee=b.co and a.co_post=c.co and a.co_issue_stat=d.co
                order by fe_issue desc");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function listarIssuestat($db)
    {
        $stmt = $db->query("select co,nb from tssa_issue_stat order by co");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtener($db,$codigo)
    {
        $stmt = $db->prepare("select *,DATE_FORMAT(fe_issue,'%m/%d/%Y %l:%i %p') as fe_issue from tssa_issue where co=?");
        $stmt->execute(array($codigo));

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function actionsLog($db,$codigo)
    {
        $stmt = $db->prepare("(select DATE_FORMAT(a.fe_issue_action,'%m/%d/%Y %l:%i %p') as fe_issue_action,a.ds as ds_actions,
                b.nb as nb_stat, c.nb as nb_user, c.apll as apll_user
                from tssa_issue_actions a, tssa_issue_stat b, tssa_employee c
                where a.co_issue_stat=b.co and a.co_employee=c.co and a.co_issue=? and a.co_user_admin is null
                order by a.fe_issue_action desc)
                union
                (select DATE_FORMAT(a.fe_issue_action,'%m/%d/%Y %l:%i %p') as fe_issue_action,a.ds as ds_actions,
                b.nb as nb_stat, c.nb as nb_user, c.apll as apll_user
                from tssa_issue_actions a, tssa_issue_stat b, tssa_user c
                where a.co_issue_stat=b.co and a.co_user_admin=c.co and a.co_issue=?
                order by a.fe_issue_action desc)");
        $stmt->execute(array($codigo,$codigo));

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function ingresar($db,array $campos)
    {
        try
        {

            $fecha_now = date("Y-m-d H:i:s");
            $codigo = id($db,"issue");

            $stmt = $db->prepare("insert into tssa_issue (co,co_employee,co_post,co_issue_stat,fe_issue,ds,fe_reg,fe_act)
                values (?,?,?,?,?,?,?,?)");
            $stmt->execute(array($codigo,$campos['co_employee'],$campos['co_post'],1,$campos['fe_issue'],$campos['ds'],$fecha_now,$fecha_now));


            $stmt = $db->prepare("insert into tssa_issue_actions (co_issue,co_employee,co_issue_stat,fe_issue_action)
                values (?,?,?,?)");
            $stmt->execute(array($codigo,$campos['co_employee'],1,$fecha_now));


            return $codigo;
        }
        catch (PODException $e) {
            return 'Caught exception: ' .  $e->getMessage();
        }
    }

    public function ingresar_admin($db,array $campos)
    {
        try
        {

            $fecha_now = date("Y-m-d H:i:s");
            $codigo = id($db,"issue");

            $stmt = $db->prepare("insert into tssa_issue (co,co_employee,co_post,co_issue_stat,fe_issue,ds,fe_reg,fe_act)
                values (?,?,?,?,?,?,?,?)");
            $stmt->execute(array($codigo,$campos['co_employee'],$campos['co_post'],1,$campos['fe_issue'],$campos['ds'],$fecha_now,$fecha_now));


            $stmt = $db->prepare("insert into tssa_issue_actions (co_issue,co_employee,co_user_admin,co_issue_stat,fe_issue_action)
                values (?,?,?,?,?)");
            $stmt->execute(array($codigo,$campos['co_employee'],$_SESSION["coduser"]["co"],1,$fecha_now));


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

            $stmt = $db->prepare("update tssa_issue set co_employee=?,co_post=?,fe_issue=?,ds=?,fe_act=? where co=?");
            $stmt->execute(array($campos['co_employee'],$campos['co_post'],$campos['fe_issue'],$campos['ds'],$fecha_now,$campos['co']));


            $stmt = $db->prepare("delete from tssa_issue_actions where co_issue=?");
            $stmt->execute(array($campos['co']));


            $stmt = $db->prepare("insert into tssa_issue_actions (co_issue,co_employee,co_issue_stat,fe_issue_action)
                values (?,?,?,?)");
            $stmt->execute(array($campos['co'],$campos['co_employee'],1,$fecha_now));

            return $campos['co'];
        }
        catch (PDOException $e) {
            return 'Caught exception: ' .  $e->getMessage();
        }
    }

    public function actualizar_admin($db,array $campos)
    {
        $fecha_now = date("Y-m-d H:i:s");

        try
        {
            $stmt = $db->prepare("update tssa_issue set co_issue_stat=?,fe_act=? where co=?");
            $stmt->execute(array($campos['co_issue_stat'],$fecha_now,$campos['co']));


            $stmt = $db->prepare("insert into tssa_issue_actions (co_issue,co_employee,co_user_admin,co_issue_stat,ds,fe_issue_action)
                values (?,?,?,?,?,?)");
            $stmt->execute(array($campos['co'],$campos['co_employee'],$_SESSION["coduser"]["co"],$campos['co_issue_stat'],$campos['ds_actions'],$fecha_now));

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
            $stmt = $db->prepare("delete from tssa_issue where co=?");
            $stmt->execute(array($campos['co']));

            $stmt = $db->prepare("delete from tssa_issue_actions where co_issue=?");
            $stmt->execute(array($campos['co']));

            return true;
        }
        catch (PDOException $e) {
            return 'Caught exception: ' .  $e->getMessage();
        }

    }

}