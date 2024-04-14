<?php
include 'cn.php';

  $result = array();

  if(!isset($_SESSION['uid']) || (trim($_SESSION['uid']) == '')) {
       $_SESSION["uid"]  = 0;
    }
    $uid = $_SESSION["uid"] ;

$editbtnid = $_GET['editbtnid'];
$txtdesc = $_GET['txtdesc'];
$txtserial = $_GET['txtserial'];
$txtamount = $_GET['txtamount'];
$dtpdateaquired = $_GET['dtpdateaquired'];
$txtchasis = $_GET['txtchasis'];



 $sqlinsert = "insert into  `t_tempsemipee` (`itemid`, 
 `amount`, `description`, `serial`, `createdby`, `tag`,dateaquire,chano )
 values($editbtnid , $txtamount, '$txtdesc', '$txtserial', $uid, 0,'$dtpdateaquired','$txtchasis')";

mysqli_query($con,$sqlinsert);
  $result[] = array("msg" => "Successfully added!" , "tag" =>"2");	




  echo json_encode($result);
     mysqli_close($con);
    ?>