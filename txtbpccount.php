<?php
include 'cn.php';

  $result = array();

  if(!isset($_SESSION['uid']) || (trim($_SESSION['uid']) == '')) {
       $_SESSION["uid"]  = 0;
    }
    $uid = $_SESSION["uid"] ;
    $sqlres = "SELECT 
(select r.`id` from a_responsibilitycenter r
where r.isactive = 1 and r.id =  up.ResponsibilityCenter)
rid ,
(select r.`ResponsibilityCenter` from a_responsibilitycenter r
where r.isactive = 1 and r.id =  up.ResponsibilityCenter) Responsibility,
`userid`,
`username`,
concat(`lname`, ', ', `fname`,' ', substring(`mname`,1,1),'.') Completename ,
`contactNo` ,
case when ifnull(`userpic`,'') = '' then 'img/userpic.png' else userpic end pic

FROM `a_user` au 
left join u_profile up on au.`profileid` = up.profileid and up.isactive = 1 
where au.isactive = 1 and `userid` = $uid ";
$qryres = mysqli_query($con,$sqlres);
$arr = mysqli_fetch_array($qryres);
$Responsibility  = $arr['Responsibility'];
 $rid  = $arr['rid'];


$itemid = $_GET['itemid'];
$txtbpccount = $_GET['txtbpccount'];
$myval = $_GET['myval'];
$qty = $_GET['qty'];
$cost = $_GET['cost'];
$dtpReportDate = $_GET['dtpReportDate'];
$bal = $_GET['bal'];
$sqlups = "update t_temprpcdetail set
`cost` = '$cost', `bal` = '$bal', `onhand` = '$qty', `storageqty` = '$txtbpccount', `storageVal` ='$myval'

where `itemid`= $itemid  and  `resid` = $rid and `createdBy` = $uid
";
mysqli_query($con,$sqlups);
echo $sqlups;
?>