<?php
include 'cn.php';

$result = array();

if(!isset($_SESSION['uid']) || (trim($_SESSION['uid']) == '')) {
     $_SESSION["uid"]  = 0;
  }
  $uid = $_SESSION["uid"] ;

?>