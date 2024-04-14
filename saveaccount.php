<?php

include 'cn.php';

	$result = array();

 	if(!isset($_SESSION['uid']) || (trim($_SESSION['uid']) == '')) {
       $_SESSION["uid"]  = 0;
    }
    $uid = $_SESSION["uid"] ;

    $hiddenid = $_GET['hiddenid']; 
    $username = $_GET['username']; 
    $password = md5($_GET['password']);

    $sql = "SELECT `username` FROM `a_user` WHERE `isactive` = 1 and `username` = '$username' ";

    $qry = mysqli_query($con,$sql);
    if(mysqli_num_rows($qry)> 0){
    		$result[] = array("msg" => "Duplicate Entry User Name Already Exist!" , "tag" =>"1");
     }else{
     		$result[] = array("msg" => "Success User Name Successfully Created!" , "tag" =>"2");
     
     		$sqlinsert = "insert into `a_user`(`username`, `profileid`, `password`, `isactive`, `createdby`, `creationdate`)
			values
		('$username', $hiddenid, '$password', 1, $uid, now())";
		mysqli_query($con,$sqlinsert);
     }
      echo json_encode($result);
     mysqli_close($con);
?>