<?php
include 'cn.php';

  $result = array();

  if(!isset($_SESSION['uid']) || (trim($_SESSION['uid']) == '')) {
       $_SESSION["uid"]  = 0;
    }
    $uid = $_SESSION["uid"];
    $editbtnid = $_GET['editbtnid'];
	$txtquantity = $_GET['txtquantity'];
	$bal = $_GET['bal'];
	$txtsource = $_GET['txtsource']; 


	$sqlsource = " select id from m_fundcluster where isactive =1 and Fundcategory ='$txtsource'";
	$sqrysource = mysqli_query($con,$sqlsource);
	$fundid = 0;

	while($rowfund = mysqli_fetch_array($sqrysource)){
		$fundid = $rowfund['id'];
	}
$sqlres = "SELECT 

(select  r.`id` from a_responsibilitycenter r
where r.isactive = 1 and r.id =  up.ResponsibilityCenter) Responsibility,
`userid`,
`username`


FROM `a_user` au 
left join u_profile up on au.`profileid` = up.profileid and up.isactive = 1 
where au.isactive = 1 and `userid` = $uid ";
$qryres = mysqli_query($con,$sqlres);

$arrres = mysqli_fetch_array($qryres);

$Responsibility = $arrres['Responsibility'];



$sqlchek = "Select Received - ifnull(Issued,0)  qty from  (SELECT 
 
sum(`qty`) Received
,

(SELECT 

case when `Status` = 'Pending' then 
	sum(ifnull(`qty`,0))
   when  `Status` = 'Approved' then
   sum( ifnull(`approvedqty`,0))
end issued

FROM `t_requisitiondetails` x WHERE  x.`itemid` = a.itemid  and x. `ResponsibilityCenter` = a.ResponsibilityCenter 
and `Status` in ('Pending','Approved') ) Issued

FROM `t_itemreceived` a 
where a.`itemid` = $editbtnid and a.`ResponsibilityCenter` = $Responsibility 
and a.isactive = 1 ) kk";

$qrychk = mysqli_query($con,$sqlchek);
$row = mysqli_fetch_array($qrychk);

$qty = $row['qty'];
// echo $qty;


$sql = "SELECT id FROM `t_temprec` WHERE `itemid`  = $editbtnid and `createdby` = $uid ";

	$qry = mysqli_query($con,$sql);
	if(mysqli_num_rows($qry)> 0 ){
	 $result[] = array("msg" => "Warning Supply and Inventory  request Already Exist!" , "tag" =>"2");

	}elseif($txtquantity > $qty){
			$result[] = array("msg" => "Warning Insufficient Stocks!" , "tag" =>"3");
	}else{
			$sqlinsert = "insert into `t_temprec`(`itemid`, `qty`, `createdby`,fundSource)
values($editbtnid, $txtquantity, $uid ,$fundid)";
			mysqli_query($con,$sqlinsert);	
			 $result[] = array("msg" => "Successefully added!" , "tag" =>"1");
	}
	

	   echo json_encode($result);
     mysqli_close($con);
    ?>