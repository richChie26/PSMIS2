<?php
include 'cn.php';

  $result = array();

  if(!isset($_SESSION['uid']) || (trim($_SESSION['uid']) == '')) {
       $_SESSION["uid"]  = 0;
    }
    $uid = $_SESSION["uid"] ;
    
    $myid = $_GET['myid'];

    $sql = "delete from t_tempreceived where id = $myid";
    mysqli_query($con,$sql);
 ?>