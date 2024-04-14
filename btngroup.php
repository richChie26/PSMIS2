<?php
include 'cn.php';

  $result = array();

  if(!isset($_SESSION['uid']) || (trim($_SESSION['uid']) == '')) {
       $_SESSION["uid"]  = 0;
    }
    $uid = $_SESSION["uid"] ;
  	$gname = $_GET['gname'];
  	$gdescription = $_GET['gdescription'];

  	$sql = "SELECT `id` FROM `a_group` WHERE isactive = 1 and `Groupnane` = '$gname' ";

  	$qry = mysqli_query($con,$sql);

  	if(mysqli_num_rows($qry) > 0 ){	
  			 $result[] = array("msg" => "Warning! Username Already Exist",
                       "tag" => "1");
   	
  	}else{
  			 $result[] = array("msg" => "Success! Group Name Successfully Created",
                       "tag" => "2");

  			 $sqlinsert = "insert into `a_group`(`Groupnane`, `Description`, `isactive`, `createdby`, `creationdate`)
values
('$gname', '$gdescription', 1, $uid, now())";
   mysqli_query($con,$sqlinsert);
  	}
  	echo json_encode($result);
 mysqli_close($con);

 ?>