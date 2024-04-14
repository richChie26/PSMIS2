<?php
include 'cn.php';

  $result = array();

  if(!isset($_SESSION['uid']) || (trim($_SESSION['uid']) == '')) {
       $_SESSION["uid"]  = 0;
    }
    $uid = $_SESSION["uid"] ;

    $btnid = $_GET['btnid'];
    $sql = " update  `a_division`
set `isactive` = 0,
`previouslymodifiedby` = `modifiedby`, 
`previousmodificationdate` = `modificationdate`,
`modifiedby` = $uid, `modificationdate` = now()
WHERE `id` =  $btnid";
    mysqli_query($con,$sql);

    ?>