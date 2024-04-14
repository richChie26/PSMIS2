<?php 
include 'cn.php';

	$result = array();

 	if(!isset($_SESSION['uid']) || (trim($_SESSION['uid']) == '')) {
       $_SESSION["uid"]  = 0;
    }
    $uid = $_SESSION["uid"] ;
	$mnuid = $_GET['mnuid'];

	$sql = "update a_menu set isactive = 0 
,`previouslymodifiedby` = `modifiedby`, `previousmodificationdate` = `modificationdate`,
`modifiedby` = $uid , `modificationdate` = now() 
where id = $mnuid";
	mysqli_query($con,$sql);
	
?>
