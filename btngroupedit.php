<?php
include 'cn.php';

  $result = array();

  if(!isset($_SESSION['uid']) || (trim($_SESSION['uid']) == '')) {
       $_SESSION["uid"]  = 0;
    }
    $uid = $_SESSION["uid"] ;

    $mnuid = $_GET['mnuid'];
    $Groupnane = $_GET['Groupnane'];
    $Description = $_GET['Description'];

    $sql = "SELECT `id`, `Groupnane`, `Description` FROM `a_group` WHERE `id` != $mnuid and Groupnane = '$Groupnane'
and `isactive` = 1 ";
 
$qry = mysqli_query($con,$sql);
		if(mysqli_num_rows($qry) > 0 ){
			 $result[] = array("msg" => "Warning! Username Already Exist",
		                       "tag" => "1");
		   
		}else{
			$result[] = array("msg" => "Group Name Successfully Updated!" , "tag" =>"2");

			$sqlupdate = "update  `a_group` set 
`Groupnane` = '$Groupnane', `Description` ='$Description' , 

`previouslymodifiedby` = `modifiedby`, `previousmodificationdate` = `modifictiondate`,
`modifiedby` =  $uid , `modifictiondate` = now()
WHERE `id` = $mnuid";

mysqli_query($con,$sqlupdate);
		}
  	echo json_encode($result);
 	mysqli_close($con);


 ?>

