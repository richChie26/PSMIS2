<?php
include 'cn.php';

  $result = array();

  if(!isset($_SESSION['uid']) || (trim($_SESSION['uid']) == '')) {
       $_SESSION["uid"]  = 0;
    }
    $uid = $_SESSION["uid"] ;


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
		$supplierid = $_GET['supplierid'];
		$fundid = $_GET['fundid'];
		$txtddate = $_GET['txtddate'];
		$txtPO = $_GET['txtPO'];
		$txtpodate = $_GET['txtpodate'];
		$txtreceiptn = $_GET['txtreceiptn'];

 $sql = "SELECT id FROM `t_tempsemipee` WHERE `createdby` = $uid ";
 $qry = mysqli_query($con,$sql);
 if(mysqli_num_rows($qry) > 0 ){
 	$sqlcode = "SELECT 
 concat(substring(ifnull(`creationdate`,now()),1,4),'-',
 
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
 

FROM `t_equipmentdeliveryheader` WHERE ifnull(substring(`creationdate`,1,4),substring(now(),1,4))  = substring(now(),1,4)";
 
	$qrycode = mysqli_query($con,$sqlcode);
	$arrcode = mysqli_fetch_array($qrycode);
	$code = $arrcode['code'];

	$sqlinsertheader = "insert into  `t_equipmentdeliveryheader` (`deliverycode`, `sourceoffund`, `Supplierid`
	, `PODate`, `PONumber`, `deliverydate`, `deliveryNumber`,`isactive`, `createdby`, `creationdate`,tag)
values('$code', $fundid, $supplierid, '$txtpodate', '$txtPO', '$txtddate', '$txtreceiptn',1, $uid, now(),0)";
 
mysqli_query($con,$sqlinsertheader);

$sqlsearch = "SELECT `id`, `itemid`, `amount`, `description`, `serial`, `createdby`, `tag`, `dateaquire` FROM `t_tempsemipee` WHERE `createdby` = $uid and tag = 0";



	$qryseach = mysqli_query($con,$sqlsearch);
while ($row = mysqli_fetch_array($qryseach)) {
	$itemid = $row['itemid'];
$amount = $row['amount'];
$description = $row['description'];
$serial = $row['serial'];
$dateaquire = $row['dateaquire'];
$id = $row['id'];
	$sqlproperty =  "Select  
concat(
    substring('$dateaquire',1,4),'-',	
     (SELECT 
SubMajorAccountGroup

FROM `m_equipent` a
left join m_accouttitle b on a.`accounttitle` = b.id and b.isactive = 1 
where a.isactive = 1 and  a.id = $itemid ),'-',
    
 (SELECT 
GLAccount

FROM `m_equipent` a
left join m_accouttitle b on a.`accounttitle` = b.id and b.isactive = 1 
where a.isactive = 1 and  a.id = $itemid ),'-',

(SELECT case when length(count(eq.id) + 1) = 1 then 
		concat( '000',(count(eq.id) + 1))
        when length(count(eq.id) + 1) = 2 then 
		concat( '00',(count(eq.id) + 1))
when length(count(eq.id) + 1) = 3 then 
		concat( '0',(count(eq.id) + 1))
else
	concat((count(eq.id) + 1))

end code FROM `t_equipmentdeliverydetails` eq 
left join m_equipent ent on eq.itemid = ent.id and ent.isactive =1 
left join m_accouttitle acc on ent.accounttitle = acc.id and acc.isactive =1 


 WHERE  eq.isactive = 1 

  and `ResponsibilityCenter` = $Responsibility  and substring(ifnull(eq.`creationdate`,now()),1,4) = substring(now(),1,4)) 

,'-',(SELECT 
`operationUnitCode`

FROM `a_responsibilitycenter` WHERE `id` = $Responsibility
) ) Property";

$qryproperty = mysqli_query($con,$sqlproperty);
	$arrproperty = mysqli_fetch_array($qryproperty);
	$Property = $arrproperty['Property'];
	$sqlinsertdetails = "insert into  `t_equipmentdeliverydetails`(`ResponsibilityCenter`,
	 `deliverycode`, `itemid`, `propertyno`, `dateaquired`, `description`, `Serial`, `amount`, 
	 `isactive`, `createdby`, `creationdate`,tag,accounttitle
	)
  select  $Responsibility,'$code', $itemid, '$Property', '$dateaquire',
 '$description', '$serial', $amount , 1, $uid , now(),0 ,
		(
			SELECT 
		`accounttitle`

		FROM `m_equipent` x WHERE x.isactive = 1 and x.`id` =  $itemid  limit 1 

		)
 
 ";

	mysqli_query($con,$sqlinsertdetails);

	$sqldel = "delete from t_tempsemipee where id = $id";
	mysqli_query($con,$sqldel);
}
 }

 $result[] = array("msg" => "Success Semi Expendables Successfully Received!" , "tag" =>"1");


   echo json_encode($result);
     mysqli_close($con);

?>