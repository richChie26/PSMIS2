<?php
include 'cn.php';

  $result = array();

  if(!isset($_SESSION['uid']) || (trim($_SESSION['uid']) == '')) {
       $_SESSION["uid"]  = 0;
    }
    $uid = $_SESSION["uid"] ;
    
    $btnid = $_GET['btnid'];
;
    
    $sql = "update  `m_equipent` 
set `isactive` = 0 ,
`previouslymodifiedby` = `modifiedby`, `previousmodificationdate` = `moficationdate`
,modifiedby =  $uid, `moficationdate` = now()
where id = $btnid ";
	$qry = mysqli_query($con,$sql);

?>