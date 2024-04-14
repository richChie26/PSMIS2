<?php
  include 'cn.php';

  $result = array();

  if(!isset($_SESSION['uid']) || (trim($_SESSION['uid']) == '')) {
       $_SESSION["uid"]  = 0;
    }
    $uid = $_SESSION["uid"] ;


$sqlres = "SELECT a.`ResponsibilityCenter` rid ,c.ResponsibilityCenter
,concat(a.fname,' ', substring(a.mname, 1,1),'. ', lname) completename
 FROM `u_profile` a
left join a_user b on a.`profileid` = b.`profileid` and b.isactive = 1 
left join a_responsibilitycenter c on a.ResponsibilityCenter = c.id and c.isactive = 1 
where a.isactive = 1 and b.userid =  $uid ";


$qryres = mysqli_query($con,$sqlres);
$aarres = mysqli_fetch_array($qryres);
$ResponsibilityCenter = $aarres['ResponsibilityCenter'];
$selmyacct = $_GET['selmyacct'];
$rid = $aarres['rid'];
	$sqldata = "SELECT 
item,

`propertyno`, `description`, `Serial`,format( `amount`,2) amount, units,
case when a.Status = '' or a.Status = 'Issued' or a.Status = 'For Repair' or a.Status = 'Serviceable' or a.Status = 'For Disposal'  then 
'1' else '' end pc  
FROM `t_equipmentdeliverydetails`  a
left join m_equipent  b on a.`itemid` = b.id and b.isactive =1 
left join m_accouttitle c on b.accounttitle = c.id and c.isactive =1 
left join m_units d on b.unitofmeasurement = d.id and d.isactive = 1
where a.isactive = 1 and `ResponsibilityCenter` = $rid
and b.accounttitle =  $selmyacct";


$qrydata = mysqli_query($con,$sqldata);
	$sss = "";
	while ($row = mysqli_fetch_array($qrydata)) {
		if($row['amount'] == ""){
			$sss = "";
		}else{
    	$sss =	'<span>&#8369;</span>'.$row['amount'];

		}
	echo '<tr>
			<td>'.$row['item'].'</td>
			<td>'.$row['description'].'</td>
			<td>'.$row['propertyno'].'</td>
			<td>'.$row['units'].'</td>
			<td>'.$sss.'</td>
			<td><center>'.$row['pc'].'</center></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
		   </tr>';
	
	}

	?>
