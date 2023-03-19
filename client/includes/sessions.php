<?php
 if(!isset($_SESSION["clientID"])){
	 header ("Location: index.php");
	 exit ();
 }else{
	$clientID = $_SESSION["clientID"];
	$studID = $clientID;
 }
?>