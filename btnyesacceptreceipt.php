<?php
	include 'cn.php';

  $result = array();

  if(!isset($_SESSION['uid']) || (trim($_SESSION['uid']) == '')) {
       $_SESSION["uid"]  = 0;
    }
    $uid = $_SESSION["uid"] ;

    $wid = $_GET['wid'];
    $sql ="SELECT `ptrcode` FROM `t_ptrdetails` WHERE id = $wid";
    $qry = mysqli_query($con,$sql);
  
    $arr = mysqli_fetch_array($qry);
    	$ptrcode = $arr['ptrcode']; 

    $sqlko ="SELECT `ptrcode` FROM `t_ptrheader` WHERE `ptrcode` ='$ptrcode'";
 	$qryko = mysqli_query($con,$sqlko);
    if(mysqli_num_rows($qryko) == 1 ){
    	
    	$sqlcode = "update  `t_ptrheader`
set `status` = 'Received',
`datereceived` = now(), `receivedby` = $uid,
`previouslymodifiedby` = `modifiedby`
, `previousmodificationdate` = `modificationdate`
,`modifiedby` = $uid, `modificationdate` = now()
WHERE `ptrcode` = '$ptrcode'";
    mysqli_query($con,$sqlcode);

    $sqlup = "update `t_ptrdetails` 
set `status` = 'Received'

WHERE ptrcode = '$ptrcode' ";
	mysqli_query($con,$sqlup);
    }else{
  $sqlup = "update `t_ptrdetails` 
set `status` = 'Received'

WHERE ptrcode = '$ptrcode' ";
	mysqli_query($con,$sqlup);
    }


?>