<?php
include 'cn.php';

	$result = array();

 	if(!isset($_SESSION['uid']) || (trim($_SESSION['uid']) == '')) {
       $_SESSION["uid"]  = 0;
    }
    $uid = $_SESSION["uid"] ;


    $Units = $_GET['Units'];

    $editbtnid = $_GET['editbtnid'];

    $sql = "SELECT `units` FROM `m_units` WHERE isactive =1 
and `units` = '$Units'  and id != $editbtnid ";
	
	$qry = mysqli_query($con,$sql);
	if(mysqli_num_rows($qry) > 0 ){
			$result[] = array("msg" => "Already exist" , "tag" =>"1");
	}else{
            $result[] = array("msg" => "Successefully updated" , "tag" =>"2");

            $sqlinsert = "update `m_units`  set 
`units` ='$Units', 
`previouslymodifiedby` = `modifiedby`,
`previousmodificationdate` = `modificationdate` ,
`modifiedby` = $uid, `modificationdate` = now()
where `id` = $editbtnid

";
  mysqli_query($con,$sqlinsert);
    }
	  echo json_encode($result);
     mysqli_close($con);
?>