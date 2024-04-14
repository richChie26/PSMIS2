<?php

include 'cn.php';

	$result = array();

 	if(!isset($_SESSION['uid']) || (trim($_SESSION['uid']) == '')) {
       $_SESSION["uid"]  = 0;
    }
    $uid = $_SESSION["uid"] ;
$pid = $_GET['pid'];

$sqlupdate = "update u_profile set isactive = 0 
,`previouslymodifiedby` = `modifiedby`, `previousmodificationdate` = `modificationdate`,
`modifiedby` = $uid , `modificationdate` = now() 
where profileid = $pid";
mysqli_query($con,$sqlupdate);

// echo $sqlupdate;

?>