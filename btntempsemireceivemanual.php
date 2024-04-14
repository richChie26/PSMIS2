<?php
include 'cn.php';

  $result = array();

  if(!isset($_SESSION['uid']) || (trim($_SESSION['uid']) == '')) {
       $_SESSION["uid"]  = 0;
    }
    $uid = $_SESSION["uid"] ;
$editbtnid = $_GET['editbtnid']; 
$fundid = $_GET['fundid']; 
$dtpdateaquired = $_GET['dtpdateaquired']; 
$txtamount = $_GET['txtamount']; 
$txtdesc = $_GET['txtdesc']; 
$txtserial = $_GET['txtserial']; 
$txtproperty = $_GET['txtpropertys'];

if($txtamount > 14999){

echo 1;
}else{
$sql = "insert into  `t_temptransfer`(`itemid`, `amount`, `decription`, `serial`, `tag`, `createdby`, `dateaquire`, `fund`,propertyno)values($editbtnid, $txtamount, '$txtdesc',  '$txtserial', 1, $uid , '$dtpdateaquired', $fundid,'$txtproperty')";
mysqli_query($con,$sql);
echo 2;
}
 ?>
