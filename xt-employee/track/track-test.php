<?php
require_once("../../lib/core.php");
require_once("../../lib/val_session_employee.php");
require_once('../includes/lib/QrReader.php');
require_once('../../xt-model/PointLocation.php');
require_once('../../xt-model/PostModel.php');

$post = new PostModel();

?>
<html>
<head>
	<meta charset="UTF-8">
	<title>QR Code test</title>
</head>
<body>


<?php 
if(isset($_REQUEST["acc"]))
{
	if($_REQUEST["acc"]=="ing")
	{
		$file = "test.png";
		unlink("../../images/test/$file");

		move_uploaded_file($_FILES["archivo"]["tmp_name"], "../../images/test/".$file);

		$nombre_archivo = "../../images/test/$file";

		//*********************************************************

	        $origen=$nombre_archivo;
	        $destino=$nombre_archivo;
	        $destino_temporal=tempnam("tmp/","tmp");

	        // Establecer un ancho y alto máximo
	        $ancho = 300;
	        $alto = 300;

	        // Obtener las nuevas dimensiones
	        list($ancho_orig, $alto_orig) = getimagesize($nombre_archivo);


	        if($ancho_orig>$ancho)
	        {
	            $ratio_orig = $ancho_orig/$alto_orig;

	            if ($ancho/$alto > $ratio_orig) {
	               $ancho = $alto*$ratio_orig;
	            } else {
	               $alto = $ancho/$ratio_orig;
	            }

	            redimensionar_jpeg($origen, $destino_temporal, $ancho, $alto, 100);
	             
	            // guardamos la imagen
	            $fp=fopen($destino,"w");
	            fputs($fp,fread(fopen($destino_temporal,"r"),filesize($destino_temporal)));
	            fclose($fp);
	             
	             
	        }

		//******************************************************************

	    echo "<img src='../../images/test/$file' alt=''>";

		$qrcode = new QrReader("../../images/test/$file");


		if($qrcode->text())
		{
			$text = explode("|",$qrcode->text()); //return decoded text from QR Code 
			if($_REQUEST["tipo"]==1) 
			{
				$rs = $post -> obtener($db,$text[0]);

                if ($rs) extract($rs[0]);
                ?>

				<h4>Post Info</h4>
				<label for=""><strong>Post:</strong> </label> <?php echo $text[2] ?><br>
				<label for=""><strong>Address:</strong> </label> <?php echo $dir ?><br>
				<a href="track-test.php"><< Volver  </a>
				<?php
			}
			else
			{
				$points = trim($text[0]) . " " . trim($text[1]);

			    //GEO Fence
			    $stmt = $db->prepare("select * from tssa_post_geopoint where co_post=?");
			    $stmt->execute(array($_REQUEST["post"]));

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

			    }
			    //var_dump($polygon);

				$pointLocation = new pointLocation();
				$statGeoFence = $pointLocation->pointInPolygon("$points", $polygon);

                ?>

				<h4>Check Point Info</h4>
				<label for=""><strong>Puntos:</strong> </label> <?php echo $points ?><br>
				<label for=""><strong>GEO Fence:</strong> </label> <?php echo $statGeoFence ?><br><br>
				<a href="track-test.php"><< Volver  </a>
				<?php				

			}
		}
		else
		{
			echo "QR Code no traducido";
		}
	}
}
else
{


?>
<form action="track-test.php?acc=ing" name="forma" id="forma" method="post" enctype="multipart/form-data">
	<p>Tipo de QR Code:</p>
	<p>
		<select name="tipo" id="tipo">
		    <option value="1">Clock In</option>
		    <option value="2">Check Point</option>
		</select>
	</p>
	<p>QR Code:</p>
	<p><input type="file" name="archivo" id="archivo"></p>
	<p>Post a evaluar</p>
	<p>
		<select name="post" id="post">
		    <?php
		    $rs = $post->listarActivos($db);

		    foreach($rs as $rss)
		    {
		        extract($rss);
		        ?>
		        <option value="<?php echo $co ?>"><?php echo $nb ?></option>
		        <?php
		    }
		    ?>			
		</select>
	</p>
	<p>
		<input type="submit" value="Validar">
	</p>
</form>
<?php 
} ?>
</body>
</html>