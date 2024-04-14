<?php
include 'cn.php';

  $result = array();

  if(!isset($_SESSION['uid']) || (trim($_SESSION['uid']) == '')) {
       $_SESSION["uid"]  = 0;
    }
    $uid = $_SESSION["uid"] ;
$editbtnid = $_GET['editbtnid'];
$fundid = $_GET['fundid'];
$txtamount = $_GET['txtamount'];
$txtdesc = $_GET['txtdesc'];
$txtengine = $_GET['txtengine'];
$txtchasis = $_GET['txtchasis'];
$dtpdateaquired = $_GET['dtpdateaquired'];
$txtpropertys = $_GET['txtpropertys'];

$sql = "insert into  `t_temptransfer`(`itemid`, `amount`, `decription`, `cha`, `serial`, `tag`, `createdby`, `dateaquire`, `fund`,propertyno)values($editbtnid, $txtamount, '$txtdesc', '$txtchasis', '$txtengine', 0, $uid , '$dtpdateaquired', $fundid,'$txtpropertys')";
mysqli_query($con,$sql);
 ?>