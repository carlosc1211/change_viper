<?php 

$_dir = $_REQUEST["_dir"];
$filename = $_REQUEST["filename"];

$targetPath = "../../images/track/";
// El archivo
$nombre_archivo = $targetPath.$_dir."/".$filename;
//echo $nombre_archivo;
//$nombre_archivo = "../../images/track/b77d16bef255211653d462f7df07b262/P_20151201_124653.jpg";

$origen=$nombre_archivo;
$destino=$nombre_archivo;
$destino_temporal=tempnam("tmp/","tmp");
redimensionar_jpeg($origen, $destino_temporal, 300, 350, 100);
 
// guardamos la imagen
$fp=fopen($destino,"w");
fputs($fp,fread(fopen($destino_temporal,"r"),filesize($destino_temporal)));
fclose($fp);
 
// mostramos la imagen
//echo "<img src='../../images/track/b77d16bef255211653d462f7df07b262/P_20151201_124653.jpg'>";
 
function redimensionar_jpeg($img_original, $img_nueva, $img_nueva_anchura, $img_nueva_altura, $img_nueva_calidad)
{
    // crear una imagen desde el original 
    $img = ImageCreateFromJPEG($img_original);
    // crear una imagen nueva 
    $thumb = imagecreatetruecolor($img_nueva_anchura,$img_nueva_altura);
    // redimensiona la imagen original copiandola en la imagen 
    ImageCopyResized($thumb,$img,0,0,0,0,$img_nueva_anchura,$img_nueva_altura,ImageSX($img),ImageSY($img));
    // guardar la nueva imagen redimensionada donde indicia $img_nueva 
    ImageJPEG($thumb,$img_nueva,$img_nueva_calidad);
    ImageDestroy($img);
}


?>