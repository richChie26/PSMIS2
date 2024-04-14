<?php
include 'cn.php';

	$result = array();

 	if(!isset($_SESSION['uid']) || (trim($_SESSION['uid']) == '')) {
       $_SESSION["uid"]  = 0;
    }
    $uid = $_SESSION["uid"] ;

    $division = preg_replace("/'/", "",$_GET['division']);
   

    $sql = "SELECT `id`, `division` FROM `a_division` WHERE isactive = 1 and `division` = '$division'";
	
	$qry = mysqli_query($con,$sql);
	if(mysqli_num_rows($qry) > 0 ){
			$result[] = array("msg" => "Duplicate Division Already Exist!" , "tag" =>"1");
	}else{
            $result[] = array("msg" => "Success Division is Successefully Saved!" , "tag" =>"2");

            $sqlinsert = "insert into  `a_division`(`division`, `isactive`, `createdby`, `creationdate`)
values ('$division', 1, $uid, now())";
  mysqli_query($con,$sqlinsert);

    }


echo json_encode($result);
mysqli_close($con);
?>