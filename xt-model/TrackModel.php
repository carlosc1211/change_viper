<?php

/**
 * Created by PhpStorm.
 * User: dlugo
 * Date: 18/11/2015
 * Time: 17:42
 */
class TrackModel
{
    public function listarWorkedHours($db)
    {
        $stmt = $db->query("select a.co,b.nb as nb_employee,b.apll as apll_employee, c.nb as post_name,a.fe_reg as clocked_in,
            (select fe_reg from tssa_clock_log where co_clock_in=a.co ) as clocked_out,
            TIMEDIFF((select fe_reg from tssa_clock_log where co_clock_in=a.co ), a.fe_reg) as dif
            from tssa_clock_log a, tssa_employee b, tssa_post c
            where a.co_employee=b.co and a.co_post=c.co and tipo=1 and a.co in 
            (select co_clock_in from tssa_clock_log where co_clock_in is not null)  ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);

    }

    public function listarWorked($db,$desde='',$hasta='',$co_post='', $ano='')
    {
        $ano = getdate();
        echo $ano;
        if(trim($desde)!='-- :' && trim($hasta)!='-- :' && trim($desde)!='' && trim($hasta)!='')
            $strsql_1 = " and  (a.fe_reg >= '$desde' and a.fe_reg <= '$hasta')";

        if(trim($co_post)!='')
            $strsql_2 = " and a.co_post=$co_post";

        $stmt = $db->query("select a.co,b.nb as nb_emp, b.apll as apll_emp,c.nb as post_name, DATE_FORMAT(a.fe_reg,'%m/%d/%Y %l:%i %p') as clocked_in,
            a.stat
            from tssa_clock_log a, tssa_employee b, tssa_post c
            where a.co_employee=b.co and a.co_post=c.co and a.tipo=1 $strsql_1 $strsql_2");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);

    }

    //public function listarWorkedforYear($db, $desde='',$hasta='',$co_post='', $ano='')
    public function listarWorkedforYear($db,$ano)
    {
        /* if(trim($desde)!='-- :' && trim($hasta)!='-- :' && trim($desde)!='' && trim($hasta)!='')
            $strsql_1 = " and  (a.fe_reg >= '$desde' and a.fe_reg <= '$hasta')";

        if(trim($co_post)!='')
            $strsql_2 = " and a.co_post=$co_post"; */
       

        $stmt = $db->query("select a.co,b.nb as nb_emp, b.apll as apll_emp,c.nb as post_name, 
                            DATE_FORMAT(a.fe_reg,'%m/%d/%Y %l:%i %p') as clocked_in, a.stat
                            from tssa_clock_log a, tssa_employee b, tssa_post c
                            where a.co_employee=b.co and a.fe_reg LIKE '%$ano%' and a.co_post=c.co and a.tipo=1");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);

    }

    public function listarWorkedFiltered($db,$desde='',$hasta='',$co_user)
    {
        if(trim($desde)!='-- :' && trim($hasta)!='-- :' && trim($desde)!='' && trim($hasta)!='')
            $strsql_1 = " and  (a.fe_reg >= '$desde' and a.fe_reg <= '$hasta')";


        $stmt = $db->query("select a.co,b.nb as nb_emp, b.apll as apll_emp,c.nb as post_name, DATE_FORMAT(a.fe_reg,'%m/%d/%Y %l:%i %p') as clocked_in,
            a.stat
            from tssa_clock_log a, tssa_employee b, tssa_post c, tssa_client_post d
            where a.co_employee=b.co and a.co_post=c.co and a.co_post=d.co_post and d.co_user=$co_user and a.tipo=1 $strsql_1");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);

    }

    public function obtenerWorkedHours($db,$codigo)
    {
        $stmt = $db->prepare("select a.co,b.nb as nb_employee,b.apll as apll_employee, c.nb as post_name,DATE_FORMAT(a.fe_reg,'%m/%d/%Y %l:%i %p') as clocked_in,
            (select DATE_FORMAT(fe_reg,'%m/%d/%Y %l:%i %p') from tssa_clock_log where tipo=2 and co_clock_in=a.co ) as clocked_out,
            TIMEDIFF((select fe_reg from tssa_clock_log where tipo=2 and co_clock_in=a.co ), a.fe_reg) as dif
            from tssa_clock_log a, tssa_employee b, tssa_post c
            where a.co_employee=b.co and a.co_post=c.co and tipo=1 and a.co=?  ");
        $stmt->execute(array($codigo));

        return $stmt->fetchAll(PDO::FETCH_ASSOC);

    }

    public function listarWorkedOfficerTracker($db, $desde='',$hasta='',$co_post='')
    {
        if(trim($desde)!='-- :' && trim($hasta)!='-- :' && trim($desde)!='' && trim($hasta)!='')
            $strsql_1 = " and  (a.fe_reg >= '$desde' and a.fe_reg <= '$hasta')";

        if(trim($co_post)!='')
            $strsql_2 = " and a.co_post=$co_post";

        $stmt = $db->query("select a.co,a.nb_point,b.nb as nb_emp, b.apll as apll_emp,c.nb as post_name, DATE_FORMAT(a.fe_reg,'%m/%d/%Y %l:%i %p') as fe_reg_track
            from tssa_track_log a, tssa_employee b, tssa_post c
            where a.co_employee=b.co and a.co_post=c.co $strsql_1 $strsql_2");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);

    }

    public function obtenerOfficerTracker($db,$codigo)
    {
        $stmt = $db->prepare(" select a.*,DATE_FORMAT(a.fe_reg,'%m/%d/%Y %l:%i %p') as fe_reg_track 
            from tssa_track_log a 
            where a.co_clock_in=? order by a.fe_reg desc ");
        $stmt->execute(array($codigo));

        return $stmt->fetchAll(PDO::FETCH_ASSOC);

    }

    public function obtenerToDoTracker($db,$codigo)
    {
        $stmt = $db->prepare(" select a.*,DATE_FORMAT(a.fe_reg,'%m/%d/%Y %l:%i %p') as fe_reg 
            from tssa_todo_log a 
            where a.co_clock_in=? order by a.fe_reg desc ");
        $stmt->execute(array($codigo));

        return $stmt->fetchAll(PDO::FETCH_ASSOC);

    }

    public function obtenerOfficerTrackerPoint($db,$codigo)
    {
        $stmt = $db->prepare(" select a.* from tssa_track_log a
            where a.co=? ");
        $stmt->execute(array($codigo));

        return $stmt->fetchAll(PDO::FETCH_ASSOC);

    }

    public function getLatLongClockIn($db,$codigo)
    {
        $stmt = $db->prepare("select pos_lat as lat_in,pos_long as long_in, accuracy as accuracy_in from tssa_clock_log where co=?  ");
        $stmt->execute(array($codigo));

        return $stmt->fetchAll(PDO::FETCH_ASSOC);

    }

    public function getLatLongClockOut($db,$codigo)
    {
        $stmt = $db->prepare("select pos_lat as lat_out,pos_long as long_out, accuracy as accuracy_out from tssa_clock_log where tipo=2 and co_clock_in=?  ");
        $stmt->execute(array($codigo));

        return $stmt->fetchAll(PDO::FETCH_ASSOC);

    }


    public function getActiveClockIn($db)
    {
        $stmt = $db->prepare("select a.co,a.tipo,a.co_post from tssa_clock_log a
            where a.co_employee=? and tipo= 1 and co_clock_in is null");
        $stmt->execute(array($_SESSION["codemployee"]["co"]));

        $rs = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if($rs)
        {
            extract($rs[0]);

            $_SESSION["codclockin"] = array('co' => $co, "co_post" => $co_post, "_dir" => "");


            //GEO Fence
            $stmt = $db->prepare("select * from tssa_post_geopoint where co_post=?");
            $stmt->execute(array($co_post));

            $rsgeopoint = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $polygon = array();

            if($rsgeopoint)
            {
                foreach($rsgeopoint as $rss)
                {
                extract($rss);

                $polygon[] = "$latitude $longitude";

                }

                $polygon[] = $polygon[0];

                $_SESSION["post_polygon"] = $polygon;
            }


            $stmt = $db->prepare("select b.co,b.nb,a.task,a.fe_task from tssa_post_task a, tssa_post_point b 
                    where a.co_post_point=b.co and b.actv=1 and a.co_post=? order by a.fe_task");
            $stmt->execute(array($co_post));
            $rs = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if($rs)
            {
                foreach ($rs as $rss) {
                    extract($rss);

                    $arrTasker[] = array("co"=>$co,"nb"=>$nb,"task"=>$task,"fe_task"=>$fe_task,"trevisado"=>"0");

                }

                $_SESSION["tasker"] = $arrTasker;
            }
        }
        else
            $_SESSION["codclockin"]=null;

        return true;

    }

    public function getTipo($db)
    {
        $stmt = $db->prepare("select co,tipo,co_post from tssa_clock_log where co_employee=? order by fe_reg desc limit 1");
        $stmt->execute(array($_SESSION["codemployee"]["co"]));

        return $stmt->fetchAll(PDO::FETCH_ASSOC);

    }

    public function getTipoPost($db)
    {
        $stmt = $db->prepare("select a.co,a.tipo,DATE_FORMAT(a.fe_reg,'%m/%d/%Y %l:%i %p') as fe_reg,b.co as co_post,b.nb as post_name,b.dir as post_dir
                from tssa_clock_log a, tssa_post b
                where a.co_post=b.co and a.co=? order by a.fe_reg desc limit 1
                ");
        $stmt->execute(array($_SESSION["codclockin"]["co"]));

        return $stmt->fetchAll(PDO::FETCH_ASSOC);

    }

    public function getNextTask($db,$codigo)
    {
        $fecha_now = date("H:i:s");

        $stmt = $db->prepare("select co,nb,task,fe_task from tssa_post_point where actv=1 and co_post=? and fe_task>='$fecha_now' 
            order by fe_task");
        $stmt->execute(array($codigo));
        return $stmt->fetchAll(PDO::FETCH_ASSOC);        
    }

    public function ClockLogIn($db,array $campos)
    {
        $fecha_now = date("Y-m-d H:i:s");

        try
        {

            $codigo = id($db,"clock_log");

            $_SESSION["codclockin"] = array('co' => $codigo, "co_post" => $campos['co_post'], "_dir" => $campos['_dir']);

            //GEO Fence
            $stmt = $db->prepare("select * from tssa_post_geopoint where co_post=?");
            $stmt->execute(array($campos['co_post']));

            $rsgeopoint = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $polygon = array();

            if($rsgeopoint)
            {
                foreach($rsgeopoint as $rss)
                {
                extract($rss);

                $polygon[] = "$latitude $longitude";

                }

                $polygon[] = $polygon[0];

                $_SESSION["post_polygon"] = $polygon;
            }

            $arrTasker = array();

            $stmt = $db->prepare("select b.co,b.nb,a.task,a.fe_task from tssa_post_task a, tssa_post_point b 
                    where a.co_post_point=b.co and b.actv=1 and a.co_post=? order by a.fe_task");
            $stmt->execute(array($campos['co_post']));
            $rs = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($rs as $rss) {
                extract($rss);

                $arrTasker[] = array("co"=>$co,"nb"=>$nb,"task"=>$task,"fe_task"=>$fe_task,"trevisado"=>"0");

            }

            $_SESSION["tasker"] = $arrTasker;

            //**************Valida GEO Fence**********************

            $points = $campos['poslat'] . " " . $campos['poslong'];
            //echo $points . "<br>" . $campos['accuracy'];

            /*
            if($campos['accuracy']<5)
            {
                $pointLocation = new pointLocation();
                $statGeoFence = $pointLocation->pointInPolygon($points, $_SESSION["post_polygon"]);
            }
            else
                $statGeoFence='inside';
            */
            //****************************************************
            $statGeoFence='inside';

            if($statGeoFence=='inside')
            {
                $stmt = $db->prepare("insert into tssa_clock_log (co, co_employee, pos_lat, pos_long, accuracy, fe_reg, tipo, co_post, ds_dir, stat)
                        values (?,?,?,?,?,?,?,?,?,1)");
                $stmt->execute(array($codigo,$campos['coduser'],$campos['poslat'],$campos['poslong'],$campos['accuracy'],$fecha_now,$campos['tipo'],$campos['co_post'],$campos['_dir']));

                return true;
            }
            else
            {
                unset($_SESSION["codclockin"]);
                unset($_SESSION["post_polygon"]);
                unset($_SESSION["tasker"]);                

                return false;
            }

        }
        catch (PDOException $e) {
            echo $e->getMessage();
            return 'Caught exception: ' .  $e->getMessage();
        }

    }

    public function ClockLogOut($db,array $campos)
    {
        $fecha_now = date("Y-m-d H:i:s");

        try
        {
            $codigo = id($db,"clock_log");

            $stmt = $db->prepare("insert into tssa_clock_log (co, co_employee, pos_lat, pos_long, accuracy, fe_reg, tipo, co_post, co_clock_in)
                    values (?,?,?,?,?,?,?,?,?)");
            $stmt->execute(array($codigo,$campos['coduser'],$campos['poslat'],$campos['poslong'],$campos['accuracy'],$fecha_now,$campos['tipo'],$campos['co_post'],$campos['co_clock_in']));

            $stmt = $db->prepare("update tssa_clock_log set co_clock_in=?, stat=0 where co=?");
            $stmt->execute(array($campos['co_clock_in'],$campos['co_clock_in']));

            unset($_SESSION["codclockin"]);
            unset($_SESSION["post_polygon"]);
            unset($_SESSION["tasker"]);

            return true;
        }
        catch (PDOException $e) {
            echo $e->getMessage();
            return 'Caught exception: ' .  $e->getMessage();
        }    
    }

    public function OfficcerTrack($db,array $campos)
    {
        $fecha_now = date("Y-m-d H:i:s");

        try
        {
            $points = $campos['poslat'] . " " . $campos['poslong'];

            /*
            if($campos['accuracy']<5)
            {
                $pointLocation = new pointLocation();
                $statGeoFence = $pointLocation->pointInPolygon($points, $_SESSION["post_polygon"]);
            }
            else
                $statGeoFence='inside';
            */
                
            $statGeoFence='inside';
        
            if($statGeoFence=='inside')
            {
                $stmt = $db->prepare("insert into tssa_track_log (co_employee, pos_lat, pos_long, accuracy, fe_reg, co_post, pos_lat_point, pos_long_point, nb_point, co_clock_in)
                        values (?,?,?,?,?,?,?,?,?,?)");
                $stmt->execute(array($campos['coduser'],$campos['poslat'],$campos['poslong'],$campos['accuracy'],$fecha_now,$campos['co_post'],$campos['pos_lat_point'],$campos['pos_long_point'],$campos['nb_point'],$campos['co_clock_in']));

                return true;
            }
            else
                return false;
        }
        catch (PDOException $e) {
            echo $e->getMessage();
            return 'Caught exception: ' .  $e->getMessage();
        }    
    }
}