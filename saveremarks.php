<?php

include 'cn.php';

$result = array();

if(!isset($_SESSION['uid']) || (trim($_SESSION['uid']) == '')) {
     $_SESSION["uid"]  = 0;
  }
  $uid = $_SESSION["uid"] ;


$sqlres = "SELECT a.ResponsibilityCenter rid ,c.ResponsibilityCenter
,concat(a.fname,' ', substring(a.mname, 1,1),'. ', lname) completename
 FROM u_profile a
left join a_user b on a.profileid = b.profileid and b.isactive = 1 
left join a_responsibilitycenter c on a.ResponsibilityCenter = c.id and c.isactive = 1 
where a.isactive = 1 and b.userid =  $uid ";


$qryres = mysqli_query($con,$sqlres);
$aarres = mysqli_fetch_array($qryres);
$ResponsibilityCenter = $aarres['ResponsibilityCenter'];

$rid = $aarres['rid'];
$itemid = $_GET['itemid'];
$remarks = $_GET['remarks'];


$sqli = "update  `t_temprpcdetail`
set `remarks` = '$remarks'

WHERE `itemid` =$itemid and  `resid` = $rid and `createdBy` =$uid";
mysqli_query($con,$sqli);


?>