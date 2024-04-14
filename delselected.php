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
 $dtpReportDate = $_GET['dtpReportDate'];
$sqlllllll = "select * from t_tempitemcount where `itemid` =$itemid  and
 convert( `datereport`,date) = convert('$dtpReportDate',date) ";

 $qryllll = mysqli_query($con,$sqlllllll);
 if(mysqli_num_rows($qryllll) > 0  ){

echo 1;
 }else{
  echo 2 ;
 $sqlsss = "insert `t_tempvaldel`(`itemid`, `resid`, `userid`)values( $itemid ,$rid,$uid)";
 mysqli_query($con,$sqlsss);

$sqlssss = "delete from t_temprpci where `itemid` = $itemid  and `resid` =$rid and  `userid` =  $uid";
mysqli_query($con,$sqlssss);

// echo $sqlssss;

 $sqldel = "delete from t_temprpcdetail where `itemid` =$itemid and  `resid`=$rid and  `createdBy` = $uid";
 mysqli_query($con,$sqldel);
 }
?>