<?php
$filename = "controller/ajax/" . G::$args[1] . ".php";
if (file_exists($filename)){
	require_once($filename);
	exit;
}
?>