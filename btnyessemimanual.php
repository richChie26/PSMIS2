<?php
include 'cn.php';

  $result = array();

  if(!isset($_SESSION['uid']) || (trim($_SESSION['uid']) == '')) {
       $_SESSION["uid"]  = 0;
    }
    $uid = $_SESSION["uid"] ;
$txtorigin = $_GET['txtorigin'];
$PTRNumber = $_GET['PTRNumber'];
$ptrdate = $_GET['ptrdate'];
 $sqlres = "SELECT 

(select r.`id` from a_responsibilitycenter r
where r.isactive = 1 and r.id =  up.ResponsibilityCenter) Responsibility,
`userid`,
`username`,
concat(`lname`, ', ', `fname`,' ', substring(`mname`,1,1),'.') Completename ,
`contactNo` ,
case when ifnull(`userpic`,'') = '' then 'img/userpic.png' else userpic end pic

FROM `a_user` au 
left join u_profile up on au.`profileid` = up.profileid and up.isactive = 1 
where au.isactive = 1 and `userid` = $uid";
 
$qryres = mysqli_query($con,$sqlres);
$arrres = mysqli_fetch_array($qryres);
$Responsibility = $arrres['Responsibility'];
      $sql = "SELECT a.id ,

`accounttitle`, `itemno`,  `item`, `yearoflife`, '1' Qty, units
, `amount`, `decription`, `cha`, `serial`,Fundcategory,a.itemid ,a.fund,dateaquire ,propertyno
FROM `t_temptransfer` a
left join (SELECT 
x.`id`, `itemno`, y.`accounttitle`, `item`, `yearoflife`,units
FROM `m_equipent`  x 
left join m_accouttitle y on x.`accounttitle` = y.id and y.isactive =1
left join m_units z on x.`unitofmeasurement` = z.id and z.isactive = 1 
where x.isactive = 1  ) b on a.`itemid` = b.id

left join m_fundcluster c on a.`fund` = c.id and c.isactive = 1 
where tag = 1  and a.createdby = $uid

 ";
            

               	$qry = mysqli_query($con,$sql);
$sqlcode = "SELECT 
 concat('T-',substring(ifnull(`creationdate`,now()),1,4),'-',
 
 substring(ifnull(`creationdate`,now()),6,2),'-',
 case when length(count(id) + 1) = 1 then 
		concat('000',(count(id) + 1))
        
       	when length(count(id) + 1) = 2 then 
		concat('00',(count(id) + 1))
        when length(count(id) + 1) = 3 then 
		concat('0',(count(id) + 1))
        else
         
		(count(id) + 1)
	end ) code
 	

FROM `t_transferouside` WHERE ifnull(substring(`creationdate`,1,4),substring(now(),1,4))  = substring(now(),1,4)";
 
	$qrycode = mysqli_query($con,$sqlcode);
	$arrcode = mysqli_fetch_array($qrycode);
	$code = $arrcode['code'];


	$sqlheader ="insert into  `t_transferouside` (`origin`, `ptrcode`, `ptrdate`, `resposibilityid`, `isactive`, `createdby`, `creationdate`, `tcode`)
values
 ('$txtorigin', '$PTRNumber', '$ptrdate', $Responsibility, 1, $uid, now(), '$code')";
mysqli_query($con,$sqlheader);

$sqlinsertheader = " insert into  t_equipmentdeliveryheader(
`orgin`, `deliverycode`, `tag`, `deliverydate`, `deliveryNumber`, `isactive`, `createdby`, `creationdate`) values(
'$txtorigin','$code' , 0, '$ptrdate', '$PTRNumber', 1, $uid, now())";
mysqli_query($con,$sqlinsertheader);
while($row = mysqli_fetch_array($qry)){
$itemid = $row['itemid'];

	
$Property = $row['propertyno'];
$amount = $row['amount'];
$decription = $row['decription'];

$serial = $row['serial'];
$fund = $row['fund'];
$dateaquire = $row['dateaquire'];
$id = $row['id'];
$sqldetails = "insert into  `t_transferoutsidedetails` 
(`tcode`, `propertyno`, `responsibilitycenter`, `itemid`, `amount`, `description`, `serial`, `dateacquired`, `fundid`, `tag`, `isactive`, `createdby`, `creationdate`)
values
('$code', '$Property', $Responsibility, $itemid, $amount, '$decription', '$serial', '$dateaquire', $fund, 1, 1, $uid, now())
";
mysqli_query($con,$sqldetails);
$sqlinsertdetails = "insert into  `t_equipmentdeliverydetails`(`ResponsibilityCenter`, `deliverycode`, `itemid`, `propertyno`, `dateaquired`, `description`, `Serial`, `amount`, `isactive`, `createdby`, `creationdate`)
values($Responsibility,'$code', $itemid, '$Property', '$dateaquire', '$decription', '$serial', $amount , 1, $uid , now())";
mysqli_query($con,$sqlinsertdetails);

$qryupdate  = " update t_equipmentdeliveryheader 
set sourceoffund = $fund where deliverycode = '$code'
";
mysqli_query($con,$qryupdate);
$sqldel = "delete FROM `t_temptransfer` WHERE id = $id";
mysqli_query($con,$sqldel);
}
 ?>
