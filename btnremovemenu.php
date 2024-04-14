<?php
include 'cn.php';

  $result = array();

  if(!isset($_SESSION['uid']) || (trim($_SESSION['uid']) == '')) {
       $_SESSION["uid"]  = 0;
    }
    $uid = $_SESSION["uid"] ;


	$val  = $_GET['val'];

	foreach ($val as $chie ){
		$sql = "update `a_menusetup` set 
				`isactive` = 0 , 
				`previouslymodifiedby` = `modifiedby`, `previousmodificationdate` =`modificationdate`,
				`modifiedby` = $uid, `modificationdate`  = now()
				where id = $chie";
	mysqli_query($con,$sql);
	// echo $sql;
	}

?>