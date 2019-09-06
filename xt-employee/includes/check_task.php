<?php 
include_once '../../lib/core.php';

$co_post = getA("co_post");
$strtask = "";
$sep = "|";


foreach ($_SESSION["tasker"] as $key => $value) {
	extract($value);

	$dteStart = new DateTime(date('H:i')); 
	$dteEnd   = new DateTime($fe_task); 

	$dteDiff  = $dteStart->diff($dteEnd); 


	if($dteStart->format("h")==$dteEnd->format("h"))
	{
		
		if(intval($dteDiff->format("%I"))>=0 && intval($dteDiff->format("%I"))<=10)
		{
			if($trevisado=="0")
			{
				$strtask .= "$task at " . $dteEnd->format("H:i") . $sep;
				$_SESSION["tasker"][$key]["trevisado"]=1;
			}
		}
	}
}

echo $strtask;

?>