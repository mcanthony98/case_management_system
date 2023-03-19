<?php
 if(!isset($_SESSION["adminid"])){
	 header ("Location: index.php");
	 exit ();
 }
?>