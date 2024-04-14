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
	$sqldata = "select * from (SELECT `item`, `stockno`,b.units, `description`
,(SELECT `amount` FROM `t_itemreceived` xc  WHERE xc.isactive = 1 
and xc.`ResponsibilityCenter` = $rid
and xc.`itemid` = a.id  
limit 1 ) cost,
((SELECT sum(`qty`) FROM `t_itemreceived` xc  WHERE xc.isactive = 1 
and xc.`ResponsibilityCenter` = $rid
and xc.`itemid` = a.id  
limit 1 ) - 
(SELECT sum(`approvedqty`) FROM `t_requisitiondetails` s WHERE s.`itemid` = a.id 
and s.`ResponsibilityCenter` = $rid) )qtyres
	 FROM `m_materials` a 
left join m_units b on a.`units` = b.id and b.isactive = 1 
where a.isactive = 1 and `titleid` = $selmyacct) xx  where qtyres != ''";


$qrydata = mysqli_query($con,$sqldata);
	$sss = "";
	while ($row = mysqli_fetch_array($qrydata)) {
		if($row['cost'] == ""){
			$sss = "";
		}else{
    	$sss =	'<span>&#8369;</span>'.$row['cost'];

		}
	echo '<tr>
			<td>'.$row['item'].'</td>
			<td>'.$row['description'].'</td>
			<td>'.$row['stockno'].'</td>
			<td>'.$row['units'].'</td>
			<td>'.$sss.'</td>
			<td>'.$row['qtyres'].'</td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
		   </tr>';
	
	}

	?>
