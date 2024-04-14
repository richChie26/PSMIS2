<?php
include 'cn.php';

	$result = array();

 	if(!isset($_SESSION['uid']) || (trim($_SESSION['uid']) == '')) {
       $_SESSION["uid"]  = 0;
    }
    $uid = $_SESSION["uid"] ;

$Units = ucwords(strtolower(preg_replace("/'/", "",$_GET['Units'])));

    $sql = "SELECT `id`,`units` FROM `m_units` WHERE isactive =1 
    and units = '$Units' order by `units` ASC";
	
	$qry = mysqli_query($con,$sql);
	if(mysqli_num_rows($qry) > 0 ){
			$result[] = array("msg" => "Already Exist" , "tag" =>"1");
	}else{
            $result[] = array("msg" => " Successefully saved" , "tag" =>"2");

            $sqlinsert = "INSERT INTO `m_units`( `units`, `isactive`, `createdby`, `creationdate`)values
( '$Units ', 1, $uid, now())";
  mysqli_query($con,$sqlinsert);
    }
	  echo json_encode($result);
     mysqli_close($con);
?>