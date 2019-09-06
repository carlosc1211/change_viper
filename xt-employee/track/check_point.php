<?php 
require_once("../../lib/core.php");
require_once('../../xt-model/PostModel.php');

$post = new PostModel();

$co_post = getA("co_post");
$poslatact = getA("poslat");
$poslongact = getA("poslong");
$mensaje = "";

$rs_point = $post->obtener_point($db,$co_post);

foreach($rs_point as $points) {
	extract($points);

	$distancia = GPSDistance($poslatact, $poslongact, $latitude, $longitude, "K") . " kilometers<br>";
	//echo $distancia . "<br>";
	if($distancia <0.06)
		$mensaje = $nb;
}

echo $mensaje;
?>