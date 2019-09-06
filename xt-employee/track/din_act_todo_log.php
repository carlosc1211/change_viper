<?php 
require_once("../../lib/core.php");
require_once('../../xt-model/ToDoModel.php');

$todo = new ToDoModel();

$co_post = getA("co_post");
$co_employee = getA("co_employee");
$co_clock_in = getA("co_clock_in");
$tarea = getA("tarea");
$tipo = getA("tipo");

$rs = $todo->actToDoLog($db,$co_post,$co_employee,$co_clock_in,$tarea,$tipo);

if($rs)
	echo "1";
?>