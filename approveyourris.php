<?php
include 'cn.php';

  $result = array();

  if(!isset($_SESSION['uid']) || (trim($_SESSION['uid']) == '')) {
       $_SESSION["uid"]  = 0;
    }
    $uid = $_SESSION["uid"] ;


$myid = $_GET['myid'];
$remarks = $_GET['remarks'];

$sqlres = "SELECT `ResponsibilityCenter` FROM `u_profile` a 
left join a_user b on a.`profileid` = b.`profileid`
where b.userid = $uid ";

$qryidd = mysqli_query($con,$sqlres);


$rarrid = mysqli_fetch_array($qryidd);
$rid = $rarrid['ResponsibilityCenter'];
$sqlko = "select b.* from t_requesitionhead a 
left join t_requisitiondetails b on a.risno = b.RSIcode  
where a.id = $myid";


$myqry = mysqli_query($con,$sqlko);

while($row = mysqli_fetch_array($myqry)){
$itemid = $row['itemid'];
  $sqlam = "SELECT `amount` FROM `t_itemreceived` WHERE `ResponsibilityCenter` = $rid and `itemid` = $itemid";
  $qryam = mysqli_query($con,$sqlam);
  $arram = mysqli_fetch_array($qryam);
  $am = $arram['amount'];
  $id = $row['id'];
  $sqlupdate = "update t_requisitiondetails set Averagecost = $am
  where id =$id  ";

  mysqli_query($con,$sqlupdate);
}


$sql = "update  `t_requesitionhead` set 
`approvedby` = $uid , `status` = 'Approved', `remarksforapproval` = '$remarks', `dateapproved` = now(),
`previouslymodifiedby` = modifiedby, `previousmodificationdate` = modificationdate,

`modifiedby` = $uid , `modificationdate` = now()
where 
`id` = $myid";

 mysqli_query($con,$sql);
?>