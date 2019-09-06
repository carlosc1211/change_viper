<?php

/**
 * Created by PhpStorm.
 * User: dlugo
 * Date: 06/11/2015
 * Time: 11:33
 */
class IncidentModel
{
    protected $strsql = "";

    public function listar($db,$desde="",$hasta="",$co_post="")
    {
        if(trim($desde)!='-- :' && trim($hasta)!='-- :' && trim($desde)!='' && trim($hasta)!='')
            $strsql_1 = " and  (a.fe_incident >= '$desde' and a.fe_incident <= '$hasta')";

        if(trim($co_post)!='')
            $strsql_2 = " and a.co_post=$co_post";

        $stmt = $db->query("select a.co,DATE_FORMAT(a.fe_incident,'%m/%d/%Y %l:%i %p') as fe_incident, b.nb as post_name,
                c.nb as incident_type, d.nb as nb_user, d.apll as apll_user, e.nb as stat
                from tssa_incident a, tssa_post b, tssa_incident_type c, tssa_employee d, tssa_incident_stat e
                where a.co_post=b.co and a.co_incident_type=c.co and a.co_employee=d.co and a.co_incident_stat = e.co $strsql_1 $strsql_2
                order by a.co");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function listarFiltered($db,$desde="",$hasta="",$co_user)
    {
        if(trim($desde)!='-- :' && trim($hasta)!='-- :' && trim($desde)!='' && trim($hasta)!='')
            $strsql_1 = " and  (a.fe_incident >= '$desde' and a.fe_incident <= '$hasta')";

        $stmt = $db->query("select a.co,DATE_FORMAT(a.fe_incident,'%m/%d/%Y %l:%i %p') as fe_incident, b.nb as post_name,
                c.nb as incident_type, d.nb as nb_user, d.apll as apll_user, e.nb as stat
                from tssa_incident a, tssa_post b, tssa_incident_type c, tssa_employee d, tssa_incident_stat e, tssa_client_post f
                where a.co_post=b.co and a.co_incident_type=c.co and a.co_employee=d.co and a.co_incident_stat = e.co and a.co_post=f.co_post and f.co_user=$co_user $strsql_1 $strsql_2
                order by a.co");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function valIncidentClient($db,$codigo,$co_user)
    {
        $stmt = $db->query("select a.co from tssa_incident a, tssa_client_post f where a.co_post=f.co_post and f.co_user=$co_user and a.co=$codigo order by a.co");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function listar_propios($db,$codigo)
    {
        $stmt = $db->prepare("select a.co,a.co,DATE_FORMAT(a.fe_incident,'%m/%d/%Y %l:%i %p') as fe_incident, b.nb as post_name,
                c.nb as incident_type, d.nb as nb_user, d.apll as apll_user, e.nb as stat
                from tssa_incident a, tssa_post b, tssa_incident_type c, tssa_employee d, tssa_incident_stat e
                where a.co_post=b.co and a.co_incident_type=c.co and a.co_employee=d.co and a.co_incident_stat = e.co
                and d.co=?  order by a.fe_incident desc");
        $stmt->execute(array($codigo));

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function listar_incidentstat($db)
    {
        $stmt = $db->query("select co,nb from tssa_incident_stat order by co");

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function listar_emergencyserv($db)
    {
        $stmt = $db->query("select co,nb from tssa_emergency_service where actv=1 order by co");

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtener($db,$codigo)
    {
        $stmt = $db->prepare("select *,DATE_FORMAT(fe_incident,'%m/%d/%Y %l:%i %p') as fe_incident,
        DATE_FORMAT(fe_emergency_in,'%m/%d/%Y %l:%i %p') as fe_emergency_in,
        DATE_FORMAT(fe_emergency_out,'%m/%d/%Y %l:%i %p') as fe_emergency_out
        from tssa_incident where co=?");
        $stmt->execute(array($codigo));

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtener_propnum($db,$codigo)
    {
        $stmt = $db->prepare("select ifnull(count(co),0) as propnum from tssa_incident_prop where co_incident=?");
        $stmt->execute(array($codigo));

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtener_vehicnum($db,$codigo)
    {
        $stmt = $db->prepare("select ifnull(count(co),0) as vehicnum from tssa_incident_vehic where co_incident=?");
        $stmt->execute(array($codigo));

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtener_personnum($db,$codigo)
    {
        $stmt = $db->prepare("select ifnull(count(co),0) as personnum from tssa_incident_person where co_incident=?");
        $stmt->execute(array($codigo));

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtener_witnessnum($db,$codigo)
    {
        $stmt = $db->prepare("select ifnull(count(co),0) as witnessnum from tssa_incident_witness where co_incident=?");
        $stmt->execute(array($codigo));

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtener_prop($db,$codigo)
    {
        $stmt = $db->prepare("select * from tssa_incident_prop where co_incident=?");
        $stmt->execute(array($codigo));

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtener_vehic($db,$codigo)
    {
        $stmt = $db->prepare("select * from tssa_incident_vehic where co_incident=?");
        $stmt->execute(array($codigo));

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtener_person($db,$codigo)
    {
        $stmt = $db->prepare("select * from tssa_incident_person where co_incident=?");
        $stmt->execute(array($codigo));

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtener_witness($db,$codigo)
    {
        $stmt = $db->prepare("select * from tssa_incident_witness where co_incident=?");
        $stmt->execute(array($codigo));

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public function ingresar($db,array $campos, array $allcampos)
    {
        try
        {
            $codigo = id($db,"incident");
            $fecha_now = date("Y-m-d H:i:s");


            $stmt = $db->prepare("insert into tssa_incident (co, co_incident_type, co_post, co_incident_stat, fe_incident, victim_name, victim_dir,
                victim_telf, ds, ds_dir, co_employee, co_emergency_disp, emergency_otro, emergency_name, emergency_badge,case_no,
                fe_emergency_in, fe_emergency_out, co_user_admin, fe_reg, fe_act)
                values (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
            $stmt->execute(array($codigo,$campos['co_incident_type'],$campos['co_post'],$campos['co_incident_stat'],
                $campos['fe_incident'],$campos['victim_name'],$campos['victim_dir'],$campos['victim_telf'],$campos['ds'],
                $campos['ds_dir'],$campos['co_employee'],nulo($campos['co_emergency']),$campos['emergency_otro'],
                $campos['emergency_name'],$campos['emergency_badge'],$campos['case_no'],fe_nulo($campos['fe_emergency_in']),
                fe_nulo($campos['fe_emergency_out']),nulo($_SESSION["coduser"]["co"]),$fecha_now,$fecha_now));


            for($i=0;$i<=$campos['propnum'];$i++)
            {
                $prop_dir = $allcampos["prop_dir_$i"];
                $prop_ciudad = $allcampos["prop_ciudad_$i"];
                $prop_state = $allcampos["prop_state_$i"];
                $prop_zip = $allcampos["prop_zip_$i"];

                if(trim($prop_dir)!='' && trim($prop_ciudad)!='' && trim($prop_state)!='' && trim($prop_zip)!='')
                {
                    $stmt = $db->prepare("insert into tssa_incident_prop (co_incident,prop_dir,prop_ciudad,prop_state,prop_zip)
                    values (?,?,?,?,?)");
                    $stmt->execute(array($codigo,$prop_dir,$prop_ciudad,$prop_state,$prop_zip));
                }
            }

            for($i=0;$i<=$campos['vehicnum'];$i++)
            {
                $vehic_make = $allcampos["vehic_make_$i"];
                $vehic_model = $allcampos["vehic_model_$i"];
                $vehic_ano = $allcampos["vehic_ano_$i"];
                $vehic_tag = $allcampos["vehic_tag_$i"];
                $vehic_color = $allcampos["vehic_color_$i"];
                $vehic_placa = $allcampos["vehic_placa_$i"];
                $vehic_otro = $allcampos["vehic_otro_$i"];

                if(trim($vehic_make)!='' && trim($vehic_model)!='' && trim($vehic_ano)!='' && trim($vehic_tag)!='' && trim($vehic_color)!='' && trim($vehic_placa)!='')
                {
                    $stmt = $db->prepare("insert into tssa_incident_vehic (co_incident,vehic_make,vehic_model,vehic_ano,vehic_tag,vehic_color,vehic_placa,vehic_otro)
                    values (?,?,?,?,?,?,?,?)");
                    $stmt->execute(array($codigo,$vehic_make,$vehic_model,$vehic_ano,$vehic_tag,$vehic_color,$vehic_placa,$vehic_otro));
                }
            }

            for($i=0;$i<=$campos['personnum'];$i++)
            {
                $person_nb = $allcampos["person_nb_$i"];
                $person_dir = $allcampos["person_dir_$i"];
                $person_telf = $allcampos["person_telf_$i"];
                $person_age = $allcampos["person_age_$i"];

                if(trim($person_nb)!='' && trim($person_dir)!='' && trim($person_telf)!='' && trim($person_age)!='')
                {
                    $stmt = $db->prepare("insert into tssa_incident_person (co_incident,person_nb,person_dir,person_telf,person_age)
                    values (?,?,?,?,?)");
                    $stmt->execute(array($codigo,$person_nb,$person_dir,$person_telf,$person_age));
                }
            }

            for($i=0;$i<=$campos['witnessnum'];$i++)
            {
                $witness_nb = $allcampos["witness_nb_$i"];
                $witness_dir = $allcampos["witness_dir_$i"];
                $witness_telf = $allcampos["witness_telf_$i"];

                if(trim($witness_nb)!='' && trim($witness_dir)!='' && trim($witness_telf)!='')
                {
                    $stmt = $db->prepare("insert into tssa_incident_witness (co_incident,witness_nb,witness_dir,witness_telf)
                    values (?,?,?,?)");
                    $stmt->execute(array($codigo,$witness_nb,$witness_dir,$witness_telf));
                }
            }

            return $codigo;
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
            $stmt = $db->prepare("update tssa_incident set co_incident_type=?, co_post=?, co_incident_stat=?, fe_incident=?,
                  victim_name=?, victim_dir=?, victim_telf=?, ds=?, ds_dir=?, co_employee=?, co_emergency_disp=?,
                  emergency_otro=?, emergency_name=?, emergency_badge=?, case_no=?,fe_emergency_in=?, fe_emergency_out=?,
                  co_user_admin=?, fe_act=? where co=?");
            $stmt->execute(array($campos['co_incident_type'],$campos['co_post'],$campos['co_incident_stat'],$campos['fe_incident'],
                $campos['victim_name'],$campos['victim_dir'],$campos['victim_telf'],$campos['ds'],$campos['ds_dir'],$campos['co_employee'],
                $campos['co_emergency'],$campos['emergency_otro'],$campos['emergency_name'],$campos['emergency_badge'],$campos['case_no'],
                $campos['fe_emergency_in'],$campos['fe_emergency_out'],nulo($_SESSION["coduser"]["co"]),$fecha_now,$campos['co']));


            $stmt = $db->prepare("delete from tssa_incident_prop where co_incident=?");
            $stmt->execute(array($campos['co']));


            for($i=0;$i<=$campos['propnum'];$i++)
            {
                $prop_dir = $allcampos["prop_dir_$i"];
                $prop_ciudad = $allcampos["prop_ciudad_$i"];
                $prop_state = $allcampos["prop_state_$i"];
                $prop_zip = $allcampos["prop_zip_$i"];

                if(trim($prop_dir)!='' && trim($prop_ciudad)!='' && trim($prop_state)!='' && trim($prop_zip)!='')
                {
                    $stmt = $db->prepare("insert into tssa_incident_prop (co_incident,prop_dir,prop_ciudad,prop_state,prop_zip)
                    values (?,?,?,?,?)");
                    $stmt->execute(array($campos['co'],$prop_dir,$prop_ciudad,$prop_state,$prop_zip));
                }
            }

            $stmt = $db->prepare("delete from tssa_incident_vehic where co_incident=?");
            $stmt->execute(array($campos['co']));


            for($i=0;$i<=$campos['vehicnum'];$i++)
            {
                $vehic_make = $allcampos["vehic_make_$i"];
                $vehic_model = $allcampos["vehic_model_$i"];
                $vehic_ano = $allcampos["vehic_ano_$i"];
                $vehic_tag = $allcampos["vehic_tag_$i"];
                $vehic_color = $allcampos["vehic_color_$i"];
                $vehic_placa = $allcampos["vehic_placa_$i"];
                $vehic_otro = $allcampos["vehic_otro_$i"];

                if(trim($vehic_make)!='' && trim($vehic_model)!='' && trim($vehic_ano)!='' && trim($vehic_tag)!='' && trim($vehic_color)!='' && trim($vehic_placa)!='')
                {
                    $stmt = $db->prepare("insert into tssa_incident_vehic (co_incident,vehic_make,vehic_model,vehic_ano,vehic_tag,vehic_color,vehic_placa,vehic_otro)
                    values (?,?,?,?,?,?,?,?)");
                    $stmt->execute(array($campos['co'],$vehic_make,$vehic_model,$vehic_ano,$vehic_tag,$vehic_color,$vehic_placa,$vehic_otro));

                }
            }

            $stmt = $db->prepare("delete from tssa_incident_person where co_incident=?");
            $stmt->execute(array($campos['co']));


            for($i=0;$i<=$campos['personnum'];$i++)
            {
                $person_nb = $allcampos["person_nb_$i"];
                $person_dir = $allcampos["person_dir_$i"];
                $person_telf = $allcampos["person_telf_$i"];
                $person_age = $allcampos["person_age_$i"];

                if(trim($person_nb)!='' && trim($person_dir)!='' && trim($person_telf)!='' && trim($person_age)!='')
                {
                    $stmt = $db->prepare("insert into tssa_incident_person (co_incident,person_nb,person_dir,person_telf,person_age)
                    values (?,?,?,?,?)");
                    $stmt->execute(array($campos['co'],$person_nb,$person_dir,$person_telf,$person_age));
                }
            }


            $stmt = $db->prepare("delete from tssa_incident_witness where co_incident=?");
            $stmt->execute(array($campos['co']));


            for($i=0;$i<=$campos['witnessnum'];$i++)
            {
                $witness_nb = $allcampos["witness_nb_$i"];
                $witness_dir = $allcampos["witness_dir_$i"];
                $witness_telf = $allcampos["witness_telf_$i"];

                if(trim($witness_nb)!='' && trim($witness_dir)!='' && trim($witness_telf)!='')
                {
                    $stmt = $db->prepare("insert into tssa_incident_witness (co_incident,witness_nb,witness_dir,witness_telf)
                    values (?,?,?,?)");
                    $stmt->execute(array($campos['co'],$witness_nb,$witness_dir,$witness_telf));
                }
            }



            return $campos['co'];
        }
        catch (PDOException $e) {
            return 'Caught exception: ' .  $e->getMessage();
        }
    }

    public function eliminar($db,array $campos)
    {
        try
        {
            $stmt = $db->prepare("delete from tssa_incident where co=?");
            $stmt->execute(array($campos['co']));

            $stmt = $db->prepare("delete from tssa_incident_prop where co_incident=?");
            $stmt->execute(array($campos['co']));

            $stmt = $db->prepare("delete from tssa_incident_vehic where co_incident=?");
            $stmt->execute(array($campos['co']));

            $stmt = $db->prepare("delete from tssa_incident_person where co_incident=?");
            $stmt->execute(array($campos['co']));

            $stmt = $db->prepare("delete from tssa_incident_witness where co_incident=?");
            $stmt->execute(array($campos['co']));


            unlink("../../images/incidents/".$campos['_dir']);

            return true;
        }
        catch (PDOException $e) {
            return 'Caught exception: ' .  $e->getMessage();
        }

    }

}