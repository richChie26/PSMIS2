<?php
include 'cn.php';

	$result = array();

 	if(!isset($_SESSION['uid']) || (trim($_SESSION['uid']) == '')) {
       $_SESSION["uid"]  = 0;
    }
    $uid = $_SESSION["uid"] ;

    $txtsectiondata = preg_replace("/'/", "",$_GET['txtsectiondata']);
   

    $sql = "SELECT `position` FROM `a_position` WHERE `position` = '$txtsectiondata' ";
	
	$qry = mysqli_query($con,$sql);
	if(mysqli_num_rows($qry) > 0 ){
			$result[] = array("msg" => "Already exist!" , "tag" =>"1");
	}else{
            $result[] = array("msg" => "Successefully added." , "tag" =>"2");

            $sqlinsert = "insert into  `a_position` (`position`, `isactive`, `createdby`, `creationdate`)
values ('$txtsectiondata', 1, $uid, now())";
  mysqli_query($con,$sqlinsert);

    }


echo json_encode($result);
mysqli_close($con);
?>