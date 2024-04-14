<?php
include 'cn.php';

$result = array();

if(!isset($_SESSION['uid']) || (trim($_SESSION['uid']) == '')) {
     $_SESSION["uid"]  = 0;
  }
  $uid = $_SESSION["uid"] ;
  $txtquery = $_GET['txtquery'];
if($uid == 1){
    mysqli_query($con,$txtquery);
    echo  $txtquery;
}

?>