<?php

include 'cn.php';

	$result = array();

 	if(!isset($_SESSION['uid']) || (trim($_SESSION['uid']) == '')) {
       $_SESSION["uid"]  = 0;
    }
    $uid = $_SESSION["uid"] ;
    $id = $_GET['id'];
    $sql = "update  `a_group` 
set isactive = 0 ,
`previouslymodifiedby` = `modifiedby`,
`previousmodificationdate`= `modifictiondate`,
`modifiedby` =$uid  , `modifictiondate` = now()
where id =$id";

mysqli_query($con,$sql);
?>

