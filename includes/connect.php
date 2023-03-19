<?php

define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'u640333703_root');
define('DB_PASSWORD', '36987412Mm.');
define('DB_DATABASE', 'u640333703_case_management_system');

$conn = mysqli_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_DATABASE);

//verify connection
	 if ($conn->connect_error){
		 die("Connection Failed: <br />" .$conn->connect_error);
	  }
 
?>