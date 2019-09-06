<?php 
require_once("../../lib/core.php");
require_once('../../xt-model/PointLocation.php');

?>
 <html>
<head>
	<meta charset="UTF-8">
	<title>Document</title>
</head>
<body>
<?php
$points = "26.707117 -80.096451";
//$points = "26.707753 -80.098804";
$post_polygon = array("26.706944 -80.100182","26.709052 -80.098282","26.708895 -80.093552","26.706718 -80.093649","26.706944 -80.100182");

$pointLocation = new pointLocation();
$statGeoFence = $pointLocation->pointInPolygon($points, $post_polygon);

echo $statGeoFence;



?>
</body>
</html>