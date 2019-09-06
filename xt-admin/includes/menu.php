<?php
include_once '../../xt-model/MenuModel.php';
include_once '../../xt-model/UsuarioModel.php';
?>
<div class="left_col ">

    <div class="navbar nav_title" style="border: 0;">
        <a href="../main/findex.php" class="site_title">
            <div class="text-center"><img src="../../images/logo_gray.png" alt="" style="max-height: 112px;margin-left: auto;margin-right: auto;" class="img-responsive"></div>
        </a>
    </div>
    <div class="clearfix"></div>




    <br />

    <!-- sidebar menu -->
    <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">

        <div class="menu_section">
            <ul class="nav side-menu">
                <li><a href="../main/findex.php" class="load"><i class="fa fa-home"></i> Dashboard</a>
                <?php

                $menumodel = new MenuModel();
                $usuariomodel = new UsuarioModel();

                $rs = $menumodel -> MenuRol($db, 1);

                foreach($rs as $rss)
                {	extract($rss);
                    ?>
                    <li><a href="#"><?php echo $icon ?> <?php echo $nb ?> <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu" style="display: none">
                            <?php
                            $rs_perfil = $usuariomodel->obtener_perfil($db, $_SESSION["coduser"]['co']);
                            extract($rs_perfil[0]);

                            $rs = $menumodel->MenuModulos($db, $co_perfil, $co, 1);

                            foreach($rs as $rss)
                            {
                                extract($rss);
                                ?>
                                <li><a href="<?php echo $ds_url ?>?co_acc=<?php echo $co?>" class="load"><?php echo $ds_mod ?></a></li>
                                <?php
                            }
                            ?>
                        </ul>
                    </li>
                    <?php
                }
                ?>

            </ul>
        </div>

    </div>
    <!-- /sidebar menu -->

    <!-- /menu footer buttons -->
    <div class="sidebar-footer hidden-small">
        <a href="../main/findex.php" data-toggle="tooltip" data-placement="top" title="Home">
            <span class="glyphicon glyphicon-home" aria-hidden="true"></span>
        </a>
        <a href="../user/user-edit.php?co=<?php echo $_SESSION["coduser"]["co"]?>&co_acc=5" data-toggle="tooltip" data-placement="top" title="Profile">
            <span class="glyphicon glyphicon-user" aria-hidden="true"></span>
        </a>
        <a href="../includes/help.pdf" target="_blank" data-toggle="tooltip" data-placement="top" title="Help">
            <span class="glyphicon glyphicon-question-sign" aria-hidden="true"></span>
        </a>
        <a href="../main/logout.php" data-toggle="tooltip" data-placement="top" title="Logout">
            <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
        </a>
    </div>
    <!-- /menu footer buttons -->
</div>
