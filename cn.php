

<?php

try
{

$con = mysqli_connect("localhost", "root", "", "denrpenro");

		if(!isset($_SESSION)){
		    session_start();
		}
}
catch(PDOException $pe)
{
 die('Could not connect to the database because: ' .
 $pe->getMessage());
}

 date_default_timezone_set('Asia/Manila');



?>
