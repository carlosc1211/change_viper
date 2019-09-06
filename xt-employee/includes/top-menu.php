<div class="top_nav">

    <div class="nav_menu">
        <nav class="" role="navigation">
            <div class="nav toggle">
                <a id="menu_toggle"><i class="fa fa-bars"></i></a>
            </div>

            <ul class="nav navbar-nav navbar-right">
                <li class="">
                    <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                        <?php  echo $_SESSION["codemployee"]['nb'] . '  ' . $_SESSION["codemployee"]['apll']; ?>
                        <span class=" fa fa-angle-down"></span>
                    </a>
                    <ul class="dropdown-menu dropdown-usermenu animated fadeInDown pull-right">
                        <li><a href="../user/user-edit.php?co=<?php echo $_SESSION["codemployee"]["co"]?>&co_acc=5">  Edit Profile</a>
                        </li>
                        <li>
                            <a href="../includes/help.pdf" target="_blank">Help</a>
                        </li>
                        <li><a href="../main/logout.php"><i class="fa fa-sign-out pull-right"></i> Log Out</a>
                        </li>
                    </ul>
                </li>

            </ul>
        </nav>
    </div>

</div>
