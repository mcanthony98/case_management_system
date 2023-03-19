<?php
 if(!isset($_SESSION["lecturerid"])){
	 header ("Location: index.php");
	 exit ();
 }else{
	$lecID = $_SESSION["lecturerid"];
 }
?>