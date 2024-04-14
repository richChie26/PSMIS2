<?php
include 'cn.php';

  $result = array();

  if(!isset($_SESSION['uid']) || (trim($_SESSION['uid']) == '')) {
       $_SESSION["uid"]  = 0;
    }
    $uid = $_SESSION["uid"] ;
  	$id = $_GET['hiddenid'];
  	$username = $_GET['username'];



  	$sql = "SELECT userid FROM `a_user` WHERE isactive = 1 and `username` ='$username' and `userid` != $id";
  	$qry = mysqli_query($con,$sql);
  	if(mysqli_num_rows($qry) > 0 ){
  		 $result[] = array("msg" => "Warning! Username Already Exist",
                       "tag" => "1");
   
  	}else{
  		$result[] = array("msg" => "Success! Account Successfully Updated!",
                       "tag" => "2");

  		$sqlupdate = "update  `a_user` 
			set  username = '$username',
			`previouslymodifiedby` = `modifiedby`, `previousmodificationdate` = `modificationdate`,
			`modifiedby` = $uid , `modificationdate` = now()
			WHERE userid = $id";

			mysqli_query($con,$sqlupdate);
  	}

  	echo json_encode($result);
 mysqli_close($con);

  ?>