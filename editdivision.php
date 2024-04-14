<?php
include 'cn.php';

	$result = array();

 	if(!isset($_SESSION['uid']) || (trim($_SESSION['uid']) == '')) {
       $_SESSION["uid"]  = 0;
    }
    $uid = $_SESSION["uid"] ;

    $division = preg_replace("/'/", "",$_GET['division']);
    $mydivid = $_GET['mydivid'];

    $sql = "SELECT `id`, `division` FROM `a_division` WHERE isactive = 1 and `division` = '$division' and id != $mydivid ";
	
	$qry = mysqli_query($con,$sql);
	if(mysqli_num_rows($qry) > 0 ){
			$result[] = array("msg" => "Duplicate Division Already Exist!" , "tag" =>"1");
	}else{
            $result[] = array("msg" => "Success Division is Successefully Updated!" , "tag" =>"2");

            $sqlinsert = "update  `a_division` 
set `division` = '$division'
,`previouslymodifiedby` = `modifiedby`
, `previousmodificationdate` = `modificationdate`
,`modifiedby` = $uid
, `modificationdate` = now()

where id = $mydivid";
  mysqli_query($con,$sqlinsert);

    }


echo json_encode($result);
mysqli_close($con);
?>