<?php
include 'cn.php';

	$result = array();

 	if(!isset($_SESSION['uid']) || (trim($_SESSION['uid']) == '')) {
       $_SESSION["uid"]  = 0;
    }
    $uid = $_SESSION["uid"] ;

	$mcode = $_GET['mcode'];
	$mnuname = $_GET['mnuname'];
	$mnulink = $_GET['mnulink'];
	$mnumode = $_GET['mnumode'];
	

	$sql = "SELECT `id` FROM `a_menu` WHERE isactive = 1 and 
	`menuname` = '$mnuname' ";

	$qry = mysqli_query($con,$sql);
	if(mysqli_num_rows($qry) > 0 ){
		$result[] = array("msg" => "Already exist." , "tag" =>"1");

	}elseif($mcode == ""){
		$result[] = array("msg" => "Menu code is require." , "tag" =>"2");
	}elseif($mnuname == ""){
		$result[] = array("msg" => "Menu name is required." , "tag" =>"3");
	}elseif($mnulink == ""){
		$result[] = array("msg" => "Menu link is required." , "tag" =>"4");
	}elseif ($mnumode == "Select Module") {
		$result[] = array("msg" => " Please select a module." , "tag" =>"6");
	} else{
		$result[] = array("msg" => "Successfully saved." , "tag" =>"5");

		$sqlinsert = "insert into  `a_menu` (`menucode`, `menuname`, `link`, `isactive`, `createdby`, `creationdate`,tag)
values ('$mcode', '$mnuname', '$mnulink', 1, $uid, now() ,'$mnumode')";
		mysqli_query($con,$sqlinsert);
	}
	

	 echo json_encode($result);
     mysqli_close($con);
?>