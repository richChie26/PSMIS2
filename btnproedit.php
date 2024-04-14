<?php
include 'cn.php';

	$result = array();

 	if(!isset($_SESSION['uid']) || (trim($_SESSION['uid']) == '')) {
       $_SESSION["uid"]  = 0;
    }
    $uid = $_SESSION["uid"] ;

$fname = preg_replace("/'/", "",$_GET['fname']);
$mname = preg_replace("/'/", "",$_GET['mname']);
$lname = preg_replace("/'/", "",$_GET['lname']);
$address = preg_replace("/'/", "",$_GET['address']);
$contact = preg_replace("/'/", "",$_GET['contact']);
$pos = $_GET['pos'];
$rc = $_GET['rc'];
$sec = $_GET['sec'];
    $editbtnid = $_GET['editbtnid'];

    $sql = "SELECT `profileid` FROM `u_profile` WHERE isactive =1 
and concat(
`fname`, `mname`, `lname`) = concat(
'$fname', '$mname', '$lname')  and profileid != $editbtnid ";
	
	$qry = mysqli_query($con,$sql);
	if(mysqli_num_rows($qry) > 0 ){
			$result[] = array("msg" => "Already exist." , "tag" =>"1");
	}else{
            $result[] = array("msg" => "Successefully updated." , "tag" =>"2");

            $sqlinsert = "update `u_profile`  set 

`fname` ='$fname',
`mname` = '$mname', 
`lname` = '$lname',
`Position` = '$pos', 
`ResponsibilityCenter` = $rc,
`Section` = $sec,
`contactNo` =  '$contact', 
`address` = '$address', 
`previouslymodifiedby` = `modifiedby`,
`previousmodificationdate` = `modificationdate` ,
`modifiedby` = $uid, `modificationdate` = now()
where `profileid` = $editbtnid

";
  mysqli_query($con,$sqlinsert);
    }


	  echo json_encode($result);
     mysqli_close($con);
?>