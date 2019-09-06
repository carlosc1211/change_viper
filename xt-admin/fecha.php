<?php 
include_once '../xt-model/PointLocation.php';



 ?>
<html>
<head>
	<meta charset="UTF-8">
	<title>Document</title>
</head>
<body>



<?php 


$pointLocation = new pointLocation();
$points = array("10.458604 -66.573139");
$polygon = array("10.458775 -66.572466","10.457377 -66.572444","10.457382 -66.573291","10.458769 -66.573296","10.458775 -66.572466");
// The last point's coordinates must be the same as the first one's, to "close the loop"
foreach($points as $key => $point) {
    echo "point " . ($key+1) . " ($point): " . $pointLocation->pointInPolygon($point, $polygon) . "<br>";
}


echo "string 2";
 ?>





</body>
</html>