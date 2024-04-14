<?php
include 'cn.php';

	$result = array();

 	if(!isset($_SESSION['uid']) || (trim($_SESSION['uid']) == '')) {
       $_SESSION["uid"]  = 0;
    }
    $uid = $_SESSION["uid"] ;

    $txtsectiondata = preg_replace("/'/", "",$_GET['txtsectiondata']);
    $mydivid = $_GET['mydivid'];

    $sql = "SELECT `id`, `position` FROM `a_position` WHERE `isactive` = 1 and `id` != $mydivid and `position` = '$txtsectiondata'";
	
	$qry = mysqli_query($con,$sql);
	if(mysqli_num_rows($qry) > 0 ){
			$result[] = array("msg" => "Already exist." , "tag" =>"1");
	}else{
            $result[] = array("msg" => "Successefully updated." , "tag" =>"2");

            $sqlinsert = "update  `a_position` 
set 
`position` = '$txtsectiondata',

`previouslymodifiedby` = `modifiedby`,
`previousmodificationdate` = `modificationdate`,
`modifiedby` = $uid, `modificationdate` = now()

WHERE `id` =  $mydivid";
  mysqli_query($con,$sqlinsert);

    }


echo json_encode($result);
mysqli_close($con);
?>