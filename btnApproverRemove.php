<?php
include 'cn.php';

$result = array();

if(!isset($_SESSION['uid']) || (trim($_SESSION['uid']) == '')) {
     $_SESSION["uid"]  = 0;
  }
  $uid = $_SESSION["uid"] ;


$mydata = $_GET['mydata'];


$sqlselect ="update a_deparmentapproval set
isactive = 0
where id =  $mydata

";
 mysqli_query($con,$sqlselect);
echo 1 ;
// echo $sqlselect;

?>