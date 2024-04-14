<?php
include 'cn.php';

  $result = array();

  if(!isset($_SESSION['uid']) || (trim($_SESSION['uid']) == '')) {
       $_SESSION["uid"]  = 0;
    }
    $uid = $_SESSION["uid"] ;
    $myid = $_GET['myid'];
    $sql = "update  `t_requisitiondetails` set `Status` = 'approved' WHERE id = $myid";
    mysqli_query($con,$sql);
    $sqlsearch = "select RSIcode from t_requisitiondetails where id = $myid ";
    $qry = mysqli_query($con,$sqlsearch);
    $arr = mysqli_fetch_array($qry);
    $RSIcode = $arr['RSIcode'];
    $sqlupdate = "update  `t_requesitionhead`
set `approvedby` = $uid , `dateapproved` = now()
WHERE `risno` = '$RSIcode' ";
    mysqli_query($con,$sqlupdate);




    ?>	
