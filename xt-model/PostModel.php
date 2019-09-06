<?php

/**
 * Created by PhpStorm.
 * User: dlugo
 * Date: 04/11/2015
 * Time: 21:44
 */
class PostModel
{
    protected $strsql = "";

    public function listar($db)
    {
        $stmt = $db->query("select a.co,a.nb,a.ds_id,a.ciudad,b.nb as state,c.nb_contact,c.telf,c.corr,a.actv
                from tssa_post a, tssa_state b, tssa_post_cont c
                where a.co_state=b.co and a.co=c.co_post
                order by a.nb");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function listarActivos($db)
    {
        $stmt = $db->query("select a.co,a.nb,a.ds_id from tssa_post a where a.actv=1  order by a.nb");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtener($db,$codigo)
    {
        $stmt = $db->prepare("select a.nb, a.ds_id, a.ds_industria, a.dir, a.co_state, a.ciudad, a.ds_zip, a.ds_dir, a.corr_daily_log, a.co_user_admin, a.fe_reg, a.fe_act, a.actv as actv_post,
            b.co_post, b.nb_contact, b.title, b.telf, b.telf_cel, b.telf_otro, b.corr, b.nb_contact_other, b.title_other, b.telf_contact_other
            from tssa_post a, tssa_post_cont b
            where a.co=b.co_post and a.co=b.co_post and a.co=?");
        $stmt->execute(array($codigo));

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtener_incidentalert($db,$codigo)
    {
        $stmt = $db->prepare("select a.co,a.nb,(select ds_corr from tssa_post_alert where co_post=? and co_incident_type=a.co) 
            as ds_corr from tssa_incident_type a where a.actv=1  ");
        $stmt->execute(array($codigo));

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtener_point($db,$codigo)
    {
        $stmt = $db->prepare("select * from tssa_post_point where co_post=?");
        $stmt->execute(array($codigo));

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtener_det_point($db,$codigo)
    {
        $stmt = $db->prepare("select * from tssa_post_point where co=?");
        $stmt->execute(array($codigo));

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtener_det_geopoint($db,$codigo)
    {
        $stmt = $db->prepare("select * from tssa_post_geopoint where co=?");
        $stmt->execute(array($codigo));

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtener_geopoint($db,$codigo)
    {
        $stmt = $db->prepare("select * from tssa_post_geopoint where co_post=?");
        $stmt->execute(array($codigo));

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

     public function obtener_point_activos($db,$codigo)
    {
        $stmt = $db->prepare("select * from tssa_post_point where co_post=? and actv=1");
        $stmt->execute(array($codigo));

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtener_gpsnum($db,$codigo)
    {
        $stmt = $db->prepare("select ifnull(count(co),0) as gpsnum from tssa_post_point where co_post=?");
        $stmt->execute(array($codigo));

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtener_geonum($db,$codigo)
    {
        $stmt = $db->prepare("select ifnull(count(co),0) as geonum from tssa_post_geopoint where co_post=?");
        $stmt->execute(array($codigo));

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function ingresar($db,array $campos, array $allcampos)
    {
        $fecha_now = date("Y-m-d H:i:s");

        try
        {
            $codigo = id($db,"post");

            $stmt = $db->prepare("insert into tssa_post (co,nb,ds_id,ds_industria,dir,co_state,ciudad,ds_zip,ds_dir,corr_daily_log,co_user_admin,fe_reg,fe_act,actv)
                values (?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
            $stmt->execute(array($codigo,$campos['nb'],$campos['ds_id'],$campos['industria'],$campos['dir'],$campos['co_state'],
                $campos['ciudad'],$campos['ds_zip'],$campos['ds_dir'],$campos['corr_daily_log'],$_SESSION["coduser"]["co"],$fecha_now,$fecha_now,$campos['actv']));


            $stmt = $db->prepare("insert into tssa_post_cont (co_post, nb_contact, title, telf, telf_cel, telf_otro, corr, nb_contact_other, title_other, telf_contact_other)
                 values (?,?,?,?,?,?,?,?,?,?)");
            $stmt->execute(array($codigo,$campos['nb_contact'],$campos['title'],$campos['telf_casa'],$campos['telf_cel'],
                $campos['telf_fax'],$campos['corr'],$campos['nb_contact_other'],$campos['title_other'],$campos['telf_contact_other']));

            /*
            $stmt = $db->prepare("insert into tssa_post_user (co_post, usr, pwd, co_rol) values(?,?,?,?)");
            $stmt->execute(array($codigo,$campos['ds_id'],$campos['pwd'],$campos['co_rol']));
            */

            for($i=0;$i<=$campos['gpsnum'];$i++)
            {
                $point_pos = trim($allcampos["point_pos_$i"]);
                $point_name = trim($allcampos["point_name_$i"]);
                $point_lat = trim($allcampos["point_lat_$i"]);
                $point_long = trim($allcampos["point_log_$i"]);
                $point_actv = check($allcampos["point_activo_$i"]);

                if(trim($point_pos)!='' && trim($point_name)!='' && trim($point_lat)!='' && trim($point_long)!='' && trim($point_actv)!='')
                {
                    $stmt = $db->prepare("insert into tssa_post_point (co_post,nb,latitude,longitude,pos,actv)
                        values (?,?,?,?,?,?)");
                    $stmt->execute(array($codigo,$point_name,$point_lat,$point_long,$point_pos,$point_actv));
                }
            }

            for($i=0;$i<=$campos['geonum'];$i++)
            {
                $geo_point_lat = trim($allcampos["geo_point_lat_$i"]);
                $geo_point_long = trim($allcampos["geo_point_log_$i"]);

                if(trim($geo_point_lat)!='' && trim($geo_point_long)!='')
                {
                    $stmt = $db->prepare("insert into tssa_post_geopoint (co_post,latitude,longitude)
                        values (?,?,?)");
                    $stmt->execute(array($codigo,$geo_point_lat,$geo_point_long));
                }
            }

            $stmt = $db->query("select co,nb,actv from tssa_incident_type where actv=1 order by 1");
            $rs = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach($rs as $rss)
            {
                extract($rss);            

                $correo_alert = $allcampos["corr_$co"];

                if(trim($correo_alert)!="")
                {
                    $stmt = $db->prepare("insert into tssa_post_alert (co_post,co_incident_type,ds_corr)
                        values (?,?,?)");
                    $stmt->execute(array($codigo,$co,$correo_alert));                    
                }

            }
            /*
            $supervisor = explode("|", $campos['supervisor']);

            for ($i = 0; $i <= count($supervisor) - 1; $i++) {
                $stmt = $db->prepare("insert into tssa_post_access (co_post,co_user) values (?,?)");
                $stmt->execute(array($codigo,$supervisor[$i]));

            }
            */
            return true;
        }
        catch (Exception $e) {
            echo $e->getMessage();
            return 'Caught exception: ' .  $e->getMessage();
        }
    }

    public function actualizar($db,array $campos, array $allcampos)
    {
        $fecha_now = date("Y-m-d H:i:s");

        try
        {
            $stmt = $db->prepare("update tssa_post set nb=?,ds_id=?,ds_industria=?,dir=?,co_state=?,ciudad=?,ds_zip=?,
                ds_dir=?,corr_daily_log=?,co_user_admin=?,fe_act=?,actv=? where co=?");
            $stmt->execute(array($campos['nb'],$campos['ds_id'],$campos['industria'],$campos['dir'],$campos['co_state'],
                $campos['ciudad'],$campos['ds_zip'],$campos['ds_dir'],$campos['corr_daily_log'],$_SESSION["coduser"]["co"],$fecha_now,$campos['actv'],$campos['co']));


            $stmt = $db->prepare("update tssa_post_cont set nb_contact=?, title=?, telf=?, telf_cel=?, telf_otro=?, corr=?,
                nb_contact_other=?, title_other=?, telf_contact_other=? where co_post=?");
            $stmt->execute(array($campos['nb_contact'],$campos['title'],$campos['telf_casa'],$campos['telf_cel'],$campos['telf_fax'],
                $campos['corr'],$campos['nb_contact_other'],$campos['title_other'],$campos['telf_contact_other'], $campos['co']));

            /*
            $stmt = $db->prepare("update tssa_post_user set usr=?, pwd=?, co_rol=? where co_post=?");
            $stmt->execute(array($campos['ds_id'],$campos['pwd'],$campos['co_rol'],$campos['co']));
            */

            if($campos['gpsnum']>0)
            {
                $sep = "";
                for($i=0;$i<=$campos['gpsnum'];$i++)
                {
                    if(trim($allcampos["point_co_$i"])!='')
                    {
                        $codpoint .= $sep . trim($allcampos["point_co_$i"]);
                        $sep = ",";
                    }
                }

                if(trim($codpoint)!="")
                {
                    $stmt = $db->prepare("delete from tssa_post_point where co_post=? and co not in ($codpoint)");
                    $stmt->execute(array($campos['co']));

                    $stmt = $db->prepare("delete from tssa_post_task where co_post=? and co_post_point not in ($codpoint)");
                    $stmt->execute(array($campos['co']));

                    $stmt = $db->prepare("delete from tssa_post_todo where co_post=? and co_post_point not in ($codpoint)");
                    $stmt->execute(array($campos['co']));
                }
            }

            for($i=0;$i<=$campos['gpsnum'];$i++)
            {        
                $point_co = trim($allcampos["point_co_$i"]);
                $point_pos = trim($allcampos["point_pos_$i"]);
                $point_name = trim($allcampos["point_name_$i"]);
                $point_lat = trim($allcampos["point_lat_$i"]);
                $point_long = trim($allcampos["point_log_$i"]);
                $point_actv = check($allcampos["point_activo_$i"]);

                if(trim($point_pos)!='' && trim($point_name)!='' && trim($point_lat)!='' && trim($point_long)!='' && trim($point_actv)!='')
                { 
                    if($point_co!='')
                    {
                        $stmt = $db->prepare("update tssa_post_point set co_post=?,nb=?,latitude=?,longitude=?,pos=?,actv=? where co=?");
                        $stmt->execute(array($campos['co'],$point_name,$point_lat,$point_long,$point_pos,$point_actv,$point_co));
                    }
                    else
                    {
                        $stmt = $db->prepare("insert into tssa_post_point (co_post,nb,latitude,longitude,pos,actv)
                            values (?,?,?,?,?,?)");
                        $stmt->execute(array($campos['co'],$point_name,$point_lat,$point_long,$point_pos,$point_actv));
                    }
                }
            }
            

            
            $stmt = $db->prepare("delete from tssa_post_geopoint where co_post=?");
            $stmt->execute(array($campos['co']));


            for($i=0;$i<=$campos['geonum'];$i++)
            {
                $geo_point_lat = trim($allcampos["geo_point_lat_$i"]);
                $geo_point_long = trim($allcampos["geo_point_log_$i"]);

                if(trim($geo_point_lat)!='' && trim($geo_point_long)!='')
                {
                    $stmt = $db->prepare("insert into tssa_post_geopoint (co_post,latitude,longitude)
                        values (?,?,?)");
                    $stmt->execute(array($campos['co'],$geo_point_lat,$geo_point_long));
                }
            }


            $stmt = $db->prepare("delete from tssa_post_alert where co_post=?");
            $stmt->execute(array($campos['co']));


            $stmt = $db->query("select co,nb,actv from tssa_incident_type where actv=1 order by 1");
            $rs = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach($rs as $rss)
            {
                extract($rss);            

                $correo_alert = $allcampos["corr_$co"];

                if(trim($correo_alert)!="")
                {
                    $stmt = $db->prepare("insert into tssa_post_alert (co_post,co_incident_type,ds_corr)
                        values (?,?,?)");
                    $stmt->execute(array($campos['co'],$co,$correo_alert));                    
                }

            }
            /*
            $stmt = $db->prepare("delete from tssa_post_access where co_post=?");
            $stmt->execute(array($campos['co']));

            $supervisor = explode("|", $campos['supervisor']);

            for ($i = 0; $i <= count($supervisor) - 1; $i++) {
                $stmt = $db->prepare("insert into tssa_post_access (co_post,co_user) values (?,?)");
                $stmt->execute(array($campos['co'],$supervisor[$i]));
            }
            */

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
            $stmt = $db->prepare("delete from tssa_post where co=?");
            $stmt->execute(array($campos['co']));

            $stmt = $db->prepare("delete from tssa_post_cont where co_post=?");
            $stmt->execute(array($campos['co']));

            //$stmt = $db->prepare("delete from tssa_post_user where co_post=?");
            //$stmt->execute(array($campos['co']));

            $stmt = $db->prepare("delete from tssa_post_point where co_post=?");
            $stmt->execute(array($campos['co']));

            //$stmt = $db->prepare("delete from tssa_post_access where co_post=?");
            //$stmt->execute(array($campos['co']));

            return true;
        }
        catch (Exception $e) {
            return 'Caught exception: ' .  $e->getMessage();
        }

    }


}