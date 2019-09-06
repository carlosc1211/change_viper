<?php 
require_once("../../lib/phpqrcode/qrlib.php");


$pos_lat_point = $_GET['pos_lat_point'];
$pos_long_point = $_GET['pos_long_point'];
$nb = $_GET['nb'];
 
// we need to be sure ours script does not output anything!!! 
// otherwise it will break up PNG binary! 
 
ob_start("callback"); 
 
// here DB request or some processing 
$codeText = $pos_lat_point.'|'.$pos_long_point.'|'.$nb; 
 
// end of processing here 
$debugLog = ob_get_contents(); 
ob_end_clean(); 
 
// outputs image directly into browser, as PNG stream 
define('IMAGE_WIDTH',250);
define('IMAGE_HEIGHT',250);

QRcode::png($codeText);

?>