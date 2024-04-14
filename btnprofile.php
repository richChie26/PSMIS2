<?php
include 'cn.php';
// sikapgrant.r2@ched.gov.ph
// bit.ly/sikapgrant
// bit.ly/chedsikap
// 09163511475
	$result = array();

 	if(!isset($_SESSION['uid']) || (trim($_SESSION['uid']) == '')) {
       $_SESSION["uid"]  = 0;
    }
    $uid = $_SESSION["uid"] ;

	$fname =  preg_replace("/'/", "",$_GET['fname']);
	$mname =  preg_replace("/'/", "",$_GET['mname']);
	$lname =  preg_replace("/'/", "",$_GET['lname']);
	$address =  preg_replace("/'/", "",$_GET['address']);
	$contact =  preg_replace("/'/", "",$_GET['contact']);
	$pos = $_GET['pos'];
	$rc = $_GET['rc'];
	$sec = $_GET['sec'];

	$sql = "SELECT `profileid` FROM `u_profile` WHERE `isactive` = 1 and 
concat(`fname`, `mname`, `lname`) = concat('$fname','$mname','$lname')";

	$qry = mysqli_query($con,$sql);

	if(mysqli_num_rows($qry) > 0 ){
			$result[] = array("msg" => "Already exist!" , "tag" =>"1");
	}elseif($fname == ""){
		$result[] = array("msg" => "Employee first name is required." , "tag" =>"3");
	}elseif($mname == ""){
		$result[] = array("msg" => "Employee middle name is required." , "tag" =>"4");
	}elseif($lname == ""){
			$result[] = array("msg" => "Employee last name is required." , "tag" => "5");
	}else{
		$result[] = array("msg" => "Successfully created." , "tag" =>"2");
		$sqlinsert = "insert into `u_profile`(
    `fname`, `mname`, `lname`, `contactNo`, `address`, `isactive`, `createdby`, `creationdate`,Position,`ResponsibilityCenter`, `Section`
    )values
    (
    '$fname', '$mname', '$lname', '$contact', '$address', 1, $uid, now()
    ,'$pos',$rc,$sec
    )";
		mysqli_query($con,$sqlinsert);
	}


	 echo json_encode($result);
     mysqli_close($con);
?>