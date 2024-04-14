<?php

include 'cn.php';

  $result = array();

  if(!isset($_SESSION['uid']) || (trim($_SESSION['uid']) == '')) {
       $_SESSION["uid"]  = 0;
    }
    $uid = $_SESSION["uid"] ;
    $btnid = $_GET['btnid'];

    $sql = "update `u_profile` set `isactive` = 0 , `modifiedby` =$uid, `modificationdate` =now() WHERE `profileid` =$btnid";
    mysqli_query($con,$sql);
?>