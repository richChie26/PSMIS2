<?php
include('cn.php');
$username = $_GET['username'];
$password = md5($_GET['password']);


$sql = "SELECT userid

FROM `a_user` WHERE isactive = 1 and `username` = '$username'
and `password` = '$password'";


	$qry = mysqli_query($con, $sql);
	$r = 0;


	while ($row = mysqli_fetch_array($qry)) {



			 $_SESSION["uid"] = $row['userid'];
			$r = 1;
	
	}

	echo $r;
?>