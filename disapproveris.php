<?php
include 'cn.php';

  $result = array();

  if(!isset($_SESSION['uid']) || (trim($_SESSION['uid']) == '')) {
       $_SESSION["uid"]  = 0;
    }
    $uid = $_SESSION["uid"] ;


$myid = $_GET['myid'];
$remarks = $_GET['remarks'];

$sql = "update  `t_requesitionhead` set 
`approvedby` = $uid , `status` = 'Disapproved', `remarksforapproval` = '$remarks', `dateapproved` = now(),
`previouslymodifiedby` = modifiedby, `previousmodificationdate` = modificationdate,

`modifiedby` = $uid , `modificationdate` = now()
where 
`id` = $myid";

 mysqli_query($con,$sql);
?>