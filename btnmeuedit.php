<?php
include 'cn.php';

  $result = array();

  if(!isset($_SESSION['uid']) || (trim($_SESSION['uid']) == '')) {
       $_SESSION["uid"]  = 0;
    }
    $uid = $_SESSION["uid"] ;
	
	$mnuid = $_GET['mnuid'];
	$mcode = $_GET['mcode'];
	$menuname = $_GET['menuname'];
	$link = $_GET['link'];
	$mnumode = $_GET['mnumode'];
	$sql = "SELECT id FROM `a_menu` WHERE `isactive` = 1 and `id` != $mnuid and `menuname` = '$menuname'";
 	$qry = mysqli_query($con,$sql);
 	if(mysqli_num_rows($qry) > 0 ){
 		$result[] = array("msg" => "Already Exist." , "tag" =>"1");
 	}else{
 		$result[] = array("msg" => "Successfully updated." , "tag" =>"2");
 		$sqlupdate = "update  `a_menu` 
				set `menucode` ='$mcode', `menuname` ='$menuname', `link` ='$link',
				tag = '$mnumode',
				`previouslymodifiedby` =modifiedby, 
				`previousmodificationdate` =modificationdate,

				`modifiedby` =$uid , 
				`modificationdate` = now()
				WHERE isactive =1 and id = $mnuid
"; 

		mysqli_query($con,$sqlupdate);
 	}
 	 echo json_encode($result);
     mysqli_close($con);
 ?>