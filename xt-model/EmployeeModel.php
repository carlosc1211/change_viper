<?php

/**
 * Created by PhpStorm.
 * User: dlugo
 * Date: 03/11/2015
 * Time: 8:32
 */
class EmployeeModel
{
    protected $strsql = "";

    public function listar($db)
    {
        $stmt = $db->query('select a.co,a.nb,a.apll,b.telf_cel,b.corr,a.actv,e.nb as stat_employee
                    from tssa_employee a, tssa_employee_cont b, tssa_employee_user c, tssa_stat_employee e
                    where a.co=b.co_employee and a.co=c.co_employee and a.co_stat_employee=e.co');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function listarActivos($db)
    {
        $stmt = $db->query('select a.co,a.nb,a.apll from tssa_employee a  where a.actv=1 order by a.nb');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function listarStatus($db)
    {
        $stmt = $db->query('select co,nb from tssa_stat_employee order by nb');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtener($db, $codigo)
    {
        $stmt = $db->prepare("select a.*, DATE_FORMAT(a.fe_nac,'%m/%d/%Y') as fe_nac, DATE_FORMAT(a.fe_contrato,'%m/%d/%Y') as fe_contrato,
                    b.nb_contact, b.corr, b.telf_casa, b.telf_cel, b.telf_fax, b.parentesco_contact, b.telf_contact,
                    c.usr, c.pwd, d.lic_manejo_ds, DATE_FORMAT(d.lic_manejo_fe_ini,'%m/%d/%Y') as lic_manejo_fe_ini,
                    DATE_FORMAT(d.lic_manejo_fe_fin,'%m/%d/%Y') as lic_manejo_fe_fin, d.lic_unarmed_ds,
                    DATE_FORMAT(d.lic_unarmed_fe_ini,'%m/%d/%Y') as lic_unarmed_fe_ini, DATE_FORMAT(d.lic_unarmed_fe_fin,'%m/%d/%Y') as lic_unarmed_fe_fin,
                    d.lic_armed_ds, DATE_FORMAT(d.lic_armed_fe_ini,'%m/%d/%Y') as lic_armed_fe_ini, DATE_FORMAT(d.lic_armed_fe_fin,'%m/%d/%Y') as lic_armed_fe_fin,
                    d.lic_firearm_ds, DATE_FORMAT(d.lic_firearm_fe_ini,'%m/%d/%Y') as lic_firearm_fe_ini, DATE_FORMAT(d.lic_firearm_fe_fin,'%m/%d/%Y') as lic_firearm_fe_fin,
                    d.lic_firstaid_ds, DATE_FORMAT(d.lic_firstaid_fe_ini,'%m/%d/%Y') as lic_firstaid_fe_ini,DATE_FORMAT(d.lic_firstaid_fe_fin,'%m/%d/%Y') as lic_firstaid_fe_fin
                    from tssa_employee a, tssa_employee_cont b, tssa_employee_user c, tssa_employee_credential d
                    where a.co=b.co_employee and a.co=c.co_employee and a.co=d.co_employee and a.co=?");
        $stmt->execute(array($codigo));
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtener_user($db, $codigo)
    {
        $stmt = $db->prepare("select b.corr, c.pwd
                from tssa_employee a, tssa_employee_cont b, tssa_employee_user c, tssa_employee_credential d
                    where a.co=b.co_employee and a.co=c.co_employee and a.co=d.co_employee and a.co=?");
        $stmt->execute(array($codigo));
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function ingresar($db, array $campos, $file)
    {
        try
        {
            $codigo = id($db, "employee");
            $fecha_now = date("Y-m-d H:i:s");

            $imagen = $file['name'];

            if($imagen)
            {	$imagen = preparaLink($codigo . $imagen);
                move_uploaded_file($file['tmp_name'], "../../images/employee/$imagen");
            }

            $stmt = $db->prepare("insert into tssa_employee (co, nb, nb_2, apll, dir, ciudad, co_state, ds_zip, fe_nac, co_sexo, co_lenguaje,
                lenguaje_otro, co_citizen_stat, co_etnia, co_stat_employee, ds_img, ds_id, fe_contrato, co_user_admin, fe_reg, fe_act)
                values (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
            $stmt->execute(array($codigo,$campos['nb'],$campos['nb_2'],$campos['apll'],$campos['dir'],$campos['ciudad'],
                $campos['co_state'],$campos['ds_zip'],$campos['fe_nac'],$campos['co_sexo'],$campos['co_lenguaje'],$campos['lenguaje_otro'],
                $campos['co_citizen_stat'],$campos['co_etnia'],$campos['co_stat_employee'],$imagen,$campos['ds_id'],$campos['fe_contrato'],
                $_SESSION["coduser"]["co"],$fecha_now,$fecha_now));


            $stmt = $db->prepare("insert into tssa_employee_cont (co_employee, corr, telf_casa, telf_cel, telf_fax, nb_contact, parentesco_contact,
                telf_contact) values (?,?,?,?,?,?,?,?)");
            $stmt->execute(array($codigo,$campos['corr'],$campos['telf_casa'],$campos['telf_cel'],$campos['telf_fax'],
                $campos['nb_contact'],$campos['parentesco_contact'],$campos['telf_contact']));


            $stmt = $db->prepare("insert into tssa_employee_credential (co_employee, lic_manejo_ds, lic_manejo_fe_ini, lic_manejo_fe_fin, lic_unarmed_ds, lic_unarmed_fe_ini,
                lic_unarmed_fe_fin, lic_armed_ds, lic_armed_fe_ini, lic_armed_fe_fin, lic_firearm_ds, lic_firearm_fe_ini, lic_firearm_fe_fin, lic_firstaid_ds,
                lic_firstaid_fe_ini, lic_firstaid_fe_fin)
                values (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
            $stmt->execute(array($codigo,$campos['lic_manejo_ds'],$campos['lic_manejo_fe_ini'],$campos['lic_manejo_fe_fin'],
                $campos['lic_unarmed_ds'],$campos['lic_unarmed_fe_ini'],$campos['lic_unarmed_fe_fin'],$campos['lic_armed_ds'],
                $campos['lic_armed_fe_ini'],$campos['lic_armed_fe_fin'],$campos['lic_firearm_ds'],$campos['lic_firearm_fe_ini'],
                $campos['lic_firearm_fe_fin'],$campos['lic_firstaid_ds'],$campos['lic_firstaid_fe_ini'],$campos['lic_firstaid_fe_fin']));


            $stmt = $db->prepare("insert into tssa_employee_user (co_employee, usr, pwd) values(?,?,?)");
            $stmt->execute(array($codigo,$campos['ds_id'],$campos['pwd']));

            
            return true;
        }
        catch (Exception $e) {
            return 'Caught exception: ' .  $e->getMessage();
        }
    }

    public function actualizar($db, array $campos, $file)
    {
        try
        {
            $fecha_now = date("Y-m-d H:i:s");
            $imagen = $file['name'];

            if($imagen)
            {	$imagen = preparaLink($co . $imagen);
                move_uploaded_file($file['tmp_name'], "../../images/employee/$imagen");
                unlink("../../images/employee/" . $campos['imagen_2']);
            }
            else
            {$imagen=$campos['imagen_2'];}

            $stmt = $db->prepare("update tssa_employee set nb=?, nb_2=?, apll=?, dir=?, ciudad=?, co_state=?, ds_zip=?,
                fe_nac=?, co_sexo=?, co_lenguaje=?, lenguaje_otro=?, co_citizen_stat=?, co_etnia=?, co_stat_employee=?,
                ds_img=?, ds_id=?, fe_contrato=?, co_user_admin=?, fe_act=?,actv=?  where co=?");
            $stmt->execute(array($campos['nb'],$campos['nb_2'],$campos['apll'],$campos['dir'],$campos['ciudad'],$campos['co_state'],
                $campos['ds_zip'],$campos['fe_nac'],$campos['co_sexo'],$campos['co_lenguaje'],$campos['lenguaje_otro'],
                $campos['co_citizen_stat'],$campos['co_etnia'],$campos['co_stat_employee'],$imagen,$campos['ds_id'],$campos['fe_contrato'],
                $_SESSION["coduser"]["co"],$fecha_now,$campos['co_stat_employee'],$campos['co']));


            $stmt = $db->prepare("update tssa_employee_cont set corr=?, telf_casa=?, telf_cel=?, telf_fax=?, nb_contact=?,
                parentesco_contact=?, telf_contact=?  where co_employee=?");
            $stmt->execute(array($campos['corr'],$campos['telf_casa'],$campos['telf_cel'],$campos['telf_fax'],$campos['nb_contact'],
                $campos['parentesco_contact'],$campos['telf_contact'],$campos['co']));


            $stmt = $db->prepare("update tssa_employee_credential set lic_manejo_ds=?, lic_manejo_fe_ini=?,
                lic_manejo_fe_fin=?, lic_unarmed_ds=?, lic_unarmed_fe_ini=?, lic_unarmed_fe_fin=?, lic_armed_ds=?,
                lic_armed_fe_ini=?, lic_armed_fe_fin=?, lic_firearm_ds=?, lic_firearm_fe_ini=?, lic_firearm_fe_fin=?,
                lic_firstaid_ds=?, lic_firstaid_fe_ini=?, lic_firstaid_fe_fin=?  where co_employee=?");
            $stmt->execute(array($campos['lic_manejo_ds'],$campos['lic_manejo_fe_ini'],$campos['lic_manejo_fe_fin'],
                $campos['lic_unarmed_ds'],$campos['lic_unarmed_fe_ini'],$campos['lic_unarmed_fe_fin'],$campos['lic_armed_ds'],
                $campos['lic_armed_fe_ini'],$campos['lic_armed_fe_fin'],$campos['lic_firearm_ds'],$campos['lic_firearm_fe_ini'],
                $campos['lic_firearm_fe_fin'],$campos['lic_firstaid_ds'],$campos['lic_firstaid_fe_ini'],$campos['lic_firstaid_fe_fin'],
                $campos['co']));


            $stmt = $db->prepare("update tssa_employee_user set usr=?, pwd=? where co_employee=?");
            $stmt->execute(array($campos['ds_id'],$campos['pwd'],$campos['co']));


            return true;
        }
        catch (PDOException $e) {
            echo $e->getMessage();
            return 'Caught exception: ' .  $e->getMessage();
        }
    }

    public function actualizar_user($db, array $campos)
    {
        try
        {

            $stmt = $db->prepare("update tssa_employee_cont set corr=? where co_employee=?");
            $stmt->execute(array($campos['corr'], $campos['co']));

            $stmt = $db->prepare("update tssa_employee_user set  pwd=?' where co_employee=?");
            $stmt->execute(array($campos['pwd'], $campos['co']));

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
            $stmt = $db->prepare("delete from tssa_employee where co=?");
            $stmt->execute(array($campos['co']));

            $stmt = $db->prepare("delete from tssa_employee_cont where co_employee=?");
            $stmt->execute(array($campos['co']));

            $stmt = $db->prepare("delete from tssa_employee_credential where co_employee=?");
            $stmt->execute(array($campos['co']));

            $stmt = $db->prepare("delete from tssa_employee_user where co_employee=?");
            $stmt->execute(array($campos['co']));

            return true;
        }
        catch (Exception $e) {
            return 'Caught exception: ' .  $e->getMessage();
        }

    }


}