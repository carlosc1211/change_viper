<?php 
require_once("../../lib/core.php");
require_once('../../xt-model/PostModel.php');

$post = new PostModel();

$co_post = getA("co_post");
$sep = "";

$rs = $post->obtener_point($db,$co_post);

foreach($rs as $rss)
{
	extract($rss);

	echo("$sep$co|$nb");

	$sep = "|";
}
?>