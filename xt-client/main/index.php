<?php  
/*if(!empty($_SERVER["HTTPS"]))
  if($_SERVER["HTTPS"]!=="off")
    echo ""; //https
  else
    header('Location: https://viperuss.com/xt-admin/main/'); //http
else
    header('Location: https://viperuss.com/xt-admin/main/'); //http
*/
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Viper Client </title>

    <!-- Bootstrap core CSS -->

    <link href="../css/bootstrap.min.css" rel="stylesheet">

    <link href="../fonts/css/font-awesome.min.css" rel="stylesheet">
    <link href="../css/animate.min.css" rel="stylesheet">

    <!-- Custom styling plus plugins -->
    <link href="../css/custom.css" rel="stylesheet">
    <link href="../css/icheck/flat/green.css" rel="stylesheet">


    <script src="../js/jquery.min.js"></script>

    <!--[if lt IE 9]>
        <script src="../../assets/js/ie8-responsive-file-warning.js"></script>
        <![endif]-->

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
          <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->

</head>

<body>
    
    <div class="">
        <a class="hiddenanchor" id="tologin"></a>

        <div id="wrapper" style="margin-top: 1%;">
            <div id="login" class="animate form col-md-12">
                <div class="text-center"><img src="../../images/logo_black.png" alt="" style="max-height: 170px;margin-left: auto;margin-right: auto;" class="img-responsive"></div>
                <section class="login_content">
                    <form method="post" action="index.php?acc=1" style="margin:0px">
                        <h1>Client</h1>

                        <div class="alert alert-danger alert-dismissible fade in" role="alert" id="msjBox1" style="display:none">
                            <strong>Information!</strong>
                        </div>
                        <div>
                            <input type="text" name="user" id="user" class="form-control" placeholder="Username" required="" />
                        </div>
                        <div>
                            <input type="password" name="pwd" id="pwd" class="form-control" placeholder="Password" required="" />
                        </div>
                        <div>
                            <a class="btn btn-default submit" href="javascript:verifica_usr()">Log in</a>
                        </div>
                        <div class="clearfix"></div>
                        <div class="separator">

                            <div class="clearfix"></div>
                            <br />
                            <div class="alert alert-info" role="alert">Optimized for <a href="https://www.google.com/chrome" target="_blank" style="color:#fff;font-size:14px">Google Chrome</a></div>
                            
                            <div>
                                <p>©2015 All Rights Reserved.</p>
                            </div>
                        </div>
                    </form>
                    <!-- form -->
                </section>
                <!-- content -->
            </div>
        </div>
    </div>
    <script type="text/javascript">
        function verifica_usr()
        {	if($('#user').val()=='' && $('#pwd').val()=='')
        {$("#msjBox1").html('<strong>Warning!</strong> Please type your User and Password');$("#msjBox1").show('slow');}
        else
        {	$.ajax({
            type: "get",
            url: "din_usr.php",
            data: "usuario="+encodeURIComponent($('#user').val())+"&clave="+encodeURIComponent($('#pwd').val()),
            success: function(msg){
                if(parseInt(msg)==1)
                {	document.location.href = '../main/findex.php';
                }
                else
                {	$("#msjBox1").html('<strong>Warning!</strong> Wrong User or Password');$("#msjBox1").show('slow');
                    $('#user').val(''); $('#pwd').val('');
                }
            }
        });
        }
        }


    </script>
</body>

</html>