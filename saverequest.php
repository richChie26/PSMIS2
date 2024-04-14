<?php
include 'cn.php';

  $result = array();

  if(!isset($_SESSION['uid']) || (trim($_SESSION['uid']) == '')) {
       $_SESSION["uid"]  = 0;
    }
    $uid = $_SESSION["uid"];



$txtpurpose = $_GET['txtpurpose'];
$dtpdate = $_GET['dtpdate'];

  $sql = "SELECT 

(select r.`id` from a_responsibilitycenter r
where r.isactive = 1 and r.id =  up.ResponsibilityCenter) Responsibility,
`userid`

FROM `a_user` au 
left join u_profile up on au.`profileid` = up.profileid and up.isactive = 1 
where au.isactive = 1 and `userid` = $uid ";

	$qry = mysqli_query($con,$sql);
	$arr = mysqli_fetch_array($qry);
	$Responsibility = $arr['Responsibility'];

	$sqlcode = "Select case when  length(cnn) = 1 then
	concat('RIS-','000',cnn)
    when  length(cnn) = 2 then
	concat('RIS-','00',cnn)
    when  length(cnn) = 3 then
	concat('RIS-','0',cnn)
    else

	concat('RIS-',cnn)
end code
from


(SELECT (count(id) + 1) cnn FROM `t_requesitionhead` 
)a";

$qrycode = mysqli_query($con,$sqlcode);
$arrcode = mysqli_fetch_array($qrycode);
$code = $arrcode['code'];



$sqlinsert = "insert into `t_requesitionhead` 
(`risno`, `purpose`, `requestedby`, `datarerequest`,
 `isactive`, `createdby`, `creationdate`)
 values('$code', '$txtpurpose',$uid , '$dtpdate',
 1, $uid, now())";
mysqli_query($con,$sqlinsert);

$sqltemp = "SELECT `id`, `itemid`, `qty`, `createdby`,fundSource FROM `t_temprec` WHERE `createdby` = $uid";
$qrytemp = mysqli_query($con,$sqltemp);
while ($row = mysqli_fetch_array($qrytemp)) {
	$id = $row['id'];
	$qty = $row['qty'];
	$itemid = $row['itemid'];
	$fundSource = $row['fundSource'];
	$sqlintserttemp = "insert into  `t_requisitiondetails` (`itemid`, `qty`, `ResponsibilityCenter`, `RSIcode`, `Status`,fundSource)
values ($itemid, $qty, $Responsibility, '$code', 'Pending' ,$fundSource)
";


mysqli_query($con,$sqlintserttemp);

$sqldelete ="delete from t_temprec where id = $id";
mysqli_query($con,$sqldelete);

 $result[] = array("msg" => "Inventory request successfully submited." , "tag" =>"1");

}




	   echo json_encode($result);
     mysqli_close($con);
?>