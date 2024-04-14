<?php
include 'cn.php';

  $result = array();

  if(!isset($_SESSION['uid']) || (trim($_SESSION['uid']) == '')) {
       $_SESSION["uid"]  = 0;
    }
    $uid = $_SESSION["uid"];

$supplierid = $_GET['supplierid'];
$fundid = $_GET['fundid'];
$txtPO = $_GET['txtPO'];
$txtddate = $_GET['txtddate'];
$txtpodate = $_GET['txtpodate'];
$txtreceiptni = $_GET['txtreceiptni'];

$sqlresposibility = "SELECT `userid`, `username` ,ResponsibilityCenter FROM `a_user` a
left join u_profile b on a.`profileid` = b.`profileid` and b.isactive = 1 
where a.isactive =1 and `userid` =  $uid";
$qryresponsibility = mysqli_query($con,$sqlresposibility);

$arrress = mysqli_fetch_array($qryresponsibility);
	$ResponsibilityCenter = $arrress['ResponsibilityCenter'];	

	$sql = "SELECT `itemid`, `qty`,id,amount ,fundSource  FROM `t_tempreceived` WHERE `createdby` = $uid";

	$qry = mysqli_query($con,$sql);

	if(mysqli_num_rows($qry) > 0 ){
		$sqlsearch = "select  
case when length(cnn) = 1 then 
		concat(substring(now(),1,4),'-', substring(now(),6,2),'-000',cnn)
      when length(cnn) = 2 then 
		concat(substring(now(),1,4),'-', substring(now(),6,2),'-00',cnn)
      when length(cnn) = 3 then 
		concat(substring(now(),1,4),'-', substring(now(),6,2),'-0',cnn)
      
        else
       concat(substring(now(),1,4),'-', substring(now(),6,2),'-',cnn)
 end code
from
(SELECT count(id) + 1 cnn FROM `t_receivedheader` ) a ";


		$qrysearch = mysqli_query($con,$sqlsearch);
		$arr = mysqli_fetch_array($qrysearch);
		$code = $arr['code'];
		$sqlinsertheader = "insert into  `t_receivedheader`(`transcode`, `supplierid`, `datereceived`, `isactive`, `createdby`, `creationdate` ,`Pono`, `PODATE`, `sourceoffund`, `receiptno`)
values ('$code', $supplierid, '$txtddate',1,$uid,now(), '$txtPO','$txtpodate', $fundid ,'$txtreceiptni')";
		mysqli_query($con,$sqlinsertheader);
		$runbal = 0;
		$newrunbal = 0;
		while ($row = mysqli_fetch_array($qry)) {
			$sqls = "SELECT ifnull(sum(`qty`),0) bal  FROM `t_itemreceived` where `itemid` = ".$row['itemid']."
and `ResponsibilityCenter` = $ResponsibilityCenter ";
$fundSource =$row['fundSource'];
$qrys = mysqli_query($con,$sqls);
$arrs = mysqli_fetch_array($qrys);
$cbal = $arrs['bal'];
$sqlrel = "SELECT ifnull(sum(`approvedqty`),0) rel FROM `t_requisitiondetails` WHERE
 `itemid` = ".$row['itemid']."  and ResponsibilityCenter =  $ResponsibilityCenter and fundSource = $fundSource" ;
$qryrel = mysqli_query($con,$sqlrel);
$arrrel = mysqli_fetch_array($qryrel);
$rel = $arrrel['rel'];


$sqlrel1 = "SELECT ifnull(sum(`approvedqty`),0) rel FROM `t_requisitiondetails` WHERE `itemid` 
= ".$row['itemid']." and fundSource = $fundSource ";
$qryrel1 = mysqli_query($con,$sqlrel1);
$arrrel1 = mysqli_fetch_array($qryrel1);
$rel1 = $arrrel1['rel'];


$myave = 0;

 $totalRunningBal = "SELECT ifnull(sum(`qty`),0) sumbal  FROM `t_itemreceived` where 
 `itemid` = ".$row['itemid']."
 and fundSource = $fundSource  ";

$qrynewrunbal = mysqli_query($con, $totalRunningBal);
$drbal = 0;
while($newrow = mysqli_fetch_array($qrynewrunbal)){
	$drbal = $newrow['sumbal'];
}

$newrunbal = $drbal - $rel1;
$amt = $row['amount'] * $row['qty'];

$sqlamt = "SELECT `ave` FROM `t_itemreceived` where   fundSource = $fundSource and 
`itemid` = ".$row['itemid']."  
order by id desc limit 1 ";

$qryamt = mysqli_query($con,$sqlamt);
$newamt = 0 ;
$newamtdet = 0;
while($newrow = mysqli_fetch_array($qryamt)){
	$newamt =$newrow['ave']; 
}


$newamtdet   = $newrunbal * $newamt ; 
$rectota = $row['qty']  * $row['amount'];
 
$totalcost = $newamtdet + $rectota ;
 $runbal = ($cbal + $row['qty'] ) - $rel;

$newtotalbal = ($newrunbal + $row['qty'] );
$newaverage  =  $totalcost  / $newtotalbal ; 
// if($runbal > 0 ){

// }
			$sqlinsert = "insert `t_itemreceived` (`itemid`, `qty`, `transcode`, `isactive`,
			 `createdby`, `creationdate`,amount,ResponsibilityCenter,bal,ave,totalcost,fundSource,totalRunningBal)
values(".$row['itemid'].", ". $row['qty'].", '$code', 1, $uid, now(),
".$row['amount'].",$ResponsibilityCenter,$runbal,$newaverage,$totalcost ,$fundSource ,$newtotalbal)";
	mysqli_query($con,$sqlinsert);



			$sqldel = "delete FROM `t_tempreceived` WHERE id = ".$row['id']."  ";
			mysqli_query($con,$sqldel);
		}

 		$result[] = array("msg" => "Inventory item  successefully added!" , "tag" =>"2");
	}else{

 		$result[] = array("msg" => "No Item received!" , "tag" =>"1");
	}


	   echo json_encode($result);
     mysqli_close($con);
?>