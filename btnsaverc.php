<?php
include 'cn.php';

	$result = array();

 	if(!isset($_SESSION['uid']) || (trim($_SESSION['uid']) == '')) {
       $_SESSION["uid"]  = 0;
    }
    $uid = $_SESSION["uid"] ;


    $rcocde = $_GET['rcocde'];
    $rccenter = $_GET['rccenter'];
    $opunit = $_GET['opunit'];


    $sql = "SELECT `rccode` FROM `a_responsibilitycenter` WHERE isactive =1 
and (`rccode` = '$rcocde' or `ResponsibilityCenter` = '$rccenter')";
	
	$qry = mysqli_query($con,$sql);
	if(mysqli_num_rows($qry) > 0 ){
			$result[] = array("msg" => " Already exist." , "tag" =>"1");
	}else{
            $result[] = array("msg" => "Successefully Saved." , "tag" =>"2");

            $sqlinsert = "insert into  `a_responsibilitycenter`(`rccode`, `operationUnitCode`, `ResponsibilityCenter`, `isactive`, `createdby`, `creationdate`)
values
('$rcocde', '$opunit', '$rccenter', 1,$uid , now())";
  mysqli_query($con,$sqlinsert);
    }
	  echo json_encode($result);
     mysqli_close($con);
?>